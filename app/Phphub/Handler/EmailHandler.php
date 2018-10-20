<?php

namespace Phphub\Handler;

use App\Models\User;
use App\Models\Reply;
use App\Models\Topic;
use App\Models\Mention;
use App\Models\Append;
use App\Models\NotificationMailLog;
use Illuminate\Mail\Message;
use Mail;
use Naux\Mail\SendCloudTemplate;
use Jrean\UserVerification\Facades\UserVerification;

class EmailHandler
{
    protected $methodMap = [

        // Só é necessário enviar uma mensagem se a informação for processada pelo usuário.

        'at'                   => 'sendAtNotifyMail',
        'mentioned_in_topic'   => 'sendMentionedInTopicNotifyMail',
        'attention'            => 'sendAttentionNotifyMail',
        'vote_append'          => 'sendVoteAppendNotifyMail',
        'comment_append'       => 'sendCommentAppendNotifyMail',
        'attented_append'      => 'sendAttendAppendNotifyMail',
        'new_reply'            => 'sendNewReplyNotifyMail',
        'new_message'          => 'sendNewMessageNotifyMail',

        // A ação a seguir é apenas "informações de informações", não há necessidade de enviar um e-mail, o sistema pode ser notificado (excluir e manter simplificado)

        // 'follow'               => 'sendFollowNotifyMail',
        // 'reply_upvote'         => 'sendReplyUpvoteNotifyMail',
        // 'topic_attent'         => 'sendTopicAttentNotifyMail',
        // 'topic_mark_excellent' => 'sendTopicMarkExcellentNotifyMail',
        // 'topic_upvote'         => 'sendTopicUpvoteNotifyMail',
        // 'new_topic_from_subscribe'
        // 'new_topic_from_following'
    ];

    protected $type;
    protected $fromUser;
    protected $toUser;
    protected $topic;
    protected $reply;
    protected $body;

    public function sendMaintainerWorksMail(User $user, $timeFrame, $content)
    {
        Mail::send('emails.fake', [], function (Message $message) use ($user, $timeFrame, $content) {
            $message->subject('Estatísticas do trabalho do administrador');

            $message->getSwiftMessage()->setBody(new SendCloudTemplate('maintainer_works', [
                'name'       => $user->name,
                'time_frame' => $timeFrame,
                'content'    => $content,
            ]));

            $message->to($user->email);
        });
    }

    public function sendActivateMail(User $user)
    {
        UserVerification::generate($user);
        $token = $user->verification_token;
        Mail::send('emails.fake', [], function (Message $message) use ($user, $token) {
            $message->subject(lang('Please verify your email address'));

            $message->getSwiftMessage()->setBody(new SendCloudTemplate('template_active', [
                'name' => $user->name,
                'url'  => url('verification', $user->verification_token).'?email='.urlencode($user->email),
            ]));
            $message->to($user->email);
        });
    }

    public function sendNotifyMail($type, User $fromUser, User $toUser, Topic $topic = null, Reply $reply = null, $body = null)
    {
        if (
            !isset($this->methodMap[$type])             // Não é um tipo de corrida
            || $toUser->email_notify_enabled != 'yes'   // Não abriu a notificação por email
            || $toUser->id == $fromUser->id             // O remetente e o destinatário são a mesma pessoa
            || !$toUser->email                          // Nenhum email existe
            || $toUser->verified != 1                   // Ainda não verificado
            || $this->_checkNecessary($type, $toUser)   // O usuário pode ter lido a notificação no site devido a um atraso.
        ) {
            return false;
        }

        $this->topic = $topic;
        $this->reply = $reply;
        $this->body = $body;
        $this->fromUser = $fromUser;
        $this->toUser = $toUser;
        $this->type = $type;

        $method = $this->methodMap[$type];
        $this->$method();
    }

    protected function sendNewMessageNotifyMail()
    {
        if ( ! $this->body) return false;

        $action = "Eu enviei uma mensagem pessoal para você. O conteúdo é como segue：<br />";
        $this->_send(null, $this->fromUser, 'Você tem uma nova mensagem privada', $action, $this->body, $this->body);
    }

    protected function sendNewReplyNotifyMail()
    {
        if (!$this->reply) return false;

        $action = "Respondeu ao seu tópico: <a href='" . $this->reply->topic->link() . "' target='_blank'>{$this->reply->topic->title}</a><br /><br />O conteúdo é como segue：<br />";
        $this->_send($this->topic, $this->fromUser, 'Seu tópico tem novos comentários', $action, $this->reply->body, $this->reply->body);
    }

    protected function sendAtNotifyMail()
    {
        if (!$this->reply) return false;
        $action = "No assunto: <a href='" . $this->topic->link(['#reply' . $this->reply->id]) . "' target='_blank'>{$this->reply->topic->title}</a> Mencionou você nos comentários<br /><br />O conteúdo é como segue：<br />";
        $this->_send($this->topic, $this->fromUser, 'Alguns usuários mencionaram você nos comentários', $action, $this->reply->body, $this->reply->body);
    }

    protected function sendAttentionNotifyMail()
    {
        if (!$this->reply) return false;
        $action = "Comentou sobre o tema que você está seguindo: <a href='" . $this->topic->link(['#reply' . $this->reply->id]) . "' target='_blank'>{$this->reply->topic->title}</a><br /><br />Comentários são os seguintes：<br />";
        $this->_send($this->topic, $this->fromUser, 'Alguns usuários comentaram o tópico que você está seguindo.', $action, $this->reply->body, $this->reply->body);
    }

    protected function sendVoteAppendNotifyMail()
    {
        if (!$this->body || !$this->topic) return false;
        $action = "O tópico que você curtiu: <a href='" . $this->topic->link() . "' target='_blank'>{$this->topic->title}</a> Novo post<br /><br />A postagem é a seguinte：<br />";
        $this->_send($this->topic, '', 'Há novas postagens sobre tópicos que você curtiu.', $action, $this->body, $this->body);
    }

    protected function sendCommentAppendNotifyMail()
    {
        if (!$this->body || !$this->topic) return false;
        $action = "O tópico que você comentou: <a href='" . $this->topic->link() . "' target='_blank'>{$this->topic->title}</a> Novo post<br /><br />A postagem é a seguinte：<br />";
        $this->_send($this->topic, '', 'Há novas postagens sobre tópicos que você comentou.', $action, $this->body, $this->body);
    }

    protected function sendAttendAppendNotifyMail()
    {
        if (!$this->body || !$this->topic) return false;
        $action = "O assunto que você se importa: <a href='" . $this->topic->link() . "' target='_blank'>{$this->topic->title}</a> Novo post<br /><br />A postagem é a seguinte：<br />";
        $this->_send($this->topic, '', 'Há novas postagens sobre tópicos importantes para você.', $action, $this->body, $this->body);
    }

    protected function sendMentionedInTopicNotifyMail()
    {
        if (!$this->topic) return false;
        $action = "No tópico: <a href='" . $this->topic->link() . "' target='_blank'>{$this->topic->title}</a> mencionaram você.<br />";
        $this->_send($this->topic, $this->fromUser, 'Alguns usuários mencionaram você no tópico', $action, '', '');
    }

    protected function generateMailLog($body = '')
    {
        $data = [];
        $data['from_user_id'] = $this->fromUser->id;
        $data['user_id'] = $this->toUser->id;
        $data['type'] = $this->type;
        $data['body'] = $body;
        $data['reply_id'] = $this->reply ? $this->reply->id : 0;
        $data['topic_id'] = $this->topic ? $this->topic->id : 0;

        NotificationMailLog::create($data);
    }

    private function _correctSubject($subject, Topic $topic)
    {
        if ($topic->isArticle()) {
            $subject = str_replace('Tema', 'Artigo', $subject);
            return str_replace('Tópico', 'Artigo', $subject);
        }
        return $subject;
    }
    private function _correctAction($action, Topic $topic)
    {
        if ($topic->isArticle()) {
            $action = str_replace('Tópico', 'Artigo', $action);
            $action = str_replace('Tema', 'Artigo', $action);
            $action = str_replace('topics', 'articles', $action);
        }
        return $action;
    }

    private function _send($topic, $user, $subject, $action, $content, $mailog = '')
    {
        $name = $user ? "<a href='" . url(route('users.show', $user->id)) . "' target='_blank'>{$user->name}</a>" : '';

        if ($topic) {
            $subject = $this->_correctAction($subject, $topic);
            $action = $this->_correctAction($action, $topic);
        }

        Mail::send('emails.fake', [], function (Message $message) use ($topic, $name, $subject, $action, $content, $mailog) {

            $message->subject($subject);

            $message->getSwiftMessage()->setBody(new SendCloudTemplate('notification_mail', [
                'name'     => $name,
                'action'   => $action,
                'content'  => $content,
            ]));

            $message->to($this->toUser->email);
            $this->generateMailLog($mailog);
        });
    }

    private function _checkNecessary($type, User $toUser)
    {
        // Reler usuários do banco de dados
        $user = User::find($toUser->id);

        // mensagem privada, se lida
        if ($type == 'new_message' && $user->message_count <= 0) {
            return true;
        // Observe se ler
        } elseif ($user->notification_count <= 0) {
            return true;
        }

        return false;
    }
}
