<?php

use App\Models\User;

return [
    'title'   => 'Usuário',
    'heading' => 'Usuário',
    'single'  => 'Usuário',
    'model'   => User::class,

    'permission'=> function()
    {
        return Auth::user()->may('manage_users');
    },

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'image_url' => [
            'title'  => 'Avatar',
            'output' => function ($value, $model) {
                $value = $model->present()->gravatar();
                return empty($value) ? 'N/A' : '<img src="'.$value.'" width="80">';
            },
            'sortable' => false,
        ],
        'name' => [
            'title'    => 'Nome de usuário',
            'sortable' => false,
            'output' => function ($value, $model) {
                return '<a href="/users/'.$model->id.'" target=_blank>'.$value.'</a>';
            },
        ],
        'real_name' => [
            'title'    => 'Nome real',
            'sortable' => false,
        ],
        'github_name' => [
            'title' => 'Usuário GitHub'
        ],
        'topic_count' => [
            'title' => 'N° de Tópicos'
        ],
        'reply_count' => [
            'title' => 'N° de Respostas'
        ],
        'register_source' => [
            'title'  => 'Fonte de registro',
        ],
        'email' => [
            'title' => 'Email',
        ],
        'is_banned' => [
            'title'  => 'Bloqueado?',
            'output' => function ($value) {
                return admin_enum_style_output($value, true);
            },
        ],
        'verified' => [
            'title'  => 'Email verificado?',
            'output' => function ($value) {
                $value = $value ? 'sim' : 'não';
                return admin_enum_style_output($value);
            },
        ],
        'email_notify_enabled' => [
            'title'  => 'Alertas por email?',
            'output' => function ($value) {
                return admin_enum_style_output($value);
            },
        ],
        'operation' => [
            'title'  => 'Funções',
            'output' => function ($value, $model) {
                return $value;
            },
            'sortable' => false,
        ],
    ],
    'edit_fields' => [
        'name' => [
            'title' => 'Nome',
        ],
        'email' => [
            'title' => 'Caixa postal',
        ],
        'github_id' => [
            'title' => 'GitHub ID'
        ],
        'github_url' => [
            'title' => 'GitHub URL'
        ],
        'wechat_openid' => [
            'title' => 'WeChat openid',
        ],
        'wechat_unionid' => [
            'title' => 'WeChat unionid',
        ],
        'register_source' => [
            'title'  => 'Fonte de registro',
        ],
        'is_banned' => [
            'title'    => 'Está bloqueado?',
            'type'     => 'enum',
            'options'  => [
                'yes' => 'Sim',
                'no'  => 'Não',
            ],
        ],
        'city' => [
            'title' => 'Cidade'
        ],
        'company' => [
            'title' => 'Empresa'
        ],
        'twitter_account' => [
            'title' => 'Contar do Twitter'
        ],
        'personal_website' => [
            'title' => 'Site pessoal'
        ],
        'introduction' => [
            'title' => 'Perfil pessoal'
        ],
        'certification' => [
            'title' => 'Informações de certificação',
            'type' => 'textarea',
        ],
        'github_name' => [
            'title' => 'Nome de usuário do GitHub'
        ],
        'real_name' => [
            'title' => 'Nome real'
        ],
        'avatar' => [
            'title' => 'Avatar do usuário',
            'type' => 'image',
            'location' => public_path() . '/uploads/avatars/',
        ],
        'roles' => array(
            'type'       => 'relationship',
            'title'      => 'Grupo de usuários',
            'name_field' => 'display_name',
        ),
        'register_source' => [
            'title'  => 'Fonte de registro',
        ],
    ],
    'filters' => [
        'id' => [
            'title' => 'ID do usuário',
        ],
        'name' => [
            'title' => 'Nome',
        ],
        'github_name' => [
            'title' => 'Nome de usuário do GitHub'
        ],
        'real_name' => [
            'title' => 'Nome real'
        ],
        'email' => [
            'title' => 'Caixa postal',
        ],
        'roles' => [
            'type'       => 'relationship',
            'title'      => 'Grupo de usuários',
            'name_field' => 'display_name',
        ],
        'is_banned' => [
            'title'    => 'Está bloqueado?',
            'type'     => 'enum',
            'options'  => [
                'yes' => 'Sim',
                'no'  => 'Não',
            ],
        ],
        'email_notify_enabled' => [
            'title'    => 'Se deseja abrir alertas por email',
            'type'     => 'enum',
            'options'  => [
                'yes' => 'Sim',
                'no'  => 'Não',
            ],
        ],
        'city' => [
            'title' => 'Cidade'
        ],
        'company' => [
            'title' => 'Empresa'
        ],
        'twitter_account' => [
            'title' => 'Conta do Twitter'
        ],
        'personal_website' => [
            'title' => 'Site pessoal'
        ],
        'introduction' => [
            'title' => 'Perfil pessoal'
        ],
        'register_source' => [
            'title'  => 'Fonte de registro',
        ],
    ],
    'actions' => [
        'banned_user' => [
            'title'    => 'Desabilitar',
            'messages' => array(
                'active'  => 'Processando...',
                'success' => 'Processamento bem sucedido',
                'error'   => 'O processamento falhou, por favor tente novamente',
            ),
            'permission' => function ($model) {
                return $model->is_banned == 'no';
            },
            'action' => function ($model) {
                $model->is_banned = 'yes';
                $model->save();
                return true;
            }
        ],
        'unbanned_user' => [
            'title'    => 'Ativar',
            'messages' => array(
                'active'  => 'Processando...',
                'success' => 'Processamento bem sucedido',
                'error'   => 'O processamento falhou, por favor tente novamente',
            ),
            'permission' => function ($model) {
                return $model->is_banned == 'yes';
            },
            'action' => function ($model) {
                $model->is_banned = 'no';
                $model->save();
                return true;
            }
        ],
        'verified_email' => [
            'title'    => 'Definir a caixa de correio a ser ativada',
            'messages' => array(
                'active'  => 'Processando...',
                'success' => 'Processamento bem sucedido',
                'error'   => 'O processamento falhou, por favor tente novamente',
            ),
            'permission' => function ($model) {
                return !$model->verified;
            },
            'action' => function ($model) {
                $model->verified = true;
                $model->save();
                return true;
            }
        ],
        'unverified_email' => [
            'title'    => 'Definir a caixa de correio para estar inativa',
            'messages' => array(
                'active'  => 'Processando...',
                'success' => 'Processamento bem sucedido',
                'error'   => 'O processamento falhou, por favor tente novamente',
            ),
            'permission' => function ($model) {
                return $model->verified;
            },
            'action' => function ($model) {
                $model->verified = false;
                $model->save();
                return true;
            }
        ],
        'email_notify_enabled' => [
            'title'    => ' Ativar alertas por email',
            'messages' => array(
                'active'  => 'Processando...',
                'success' => 'Processamento bem sucedido',
                'error'   => 'O processamento falhou, por favor tente novamente',
            ),
            'permission' => function ($model) {
                return $model->email_notify_enabled == 'no';
            },
            'action' => function ($model) {
                $model->email_notify_enabled = 'yes';
                $model->save();
                return true;
            }
        ],
        'email_notify_disenabled' => [
            'title'    => 'Fechar email de alerta',
            'messages' => array(
                'active'  => 'Processando...',
                'success' => 'Processamento bem sucedido',
                'error'   => 'O processamento falhou, por favor tente novamente',
            ),
            'permission' => function ($model) {
                return $model->email_notify_enabled == 'yes';
            },
            'action' => function ($model) {
                $model->email_notify_enabled = 'no';
                $model->save();
                return true;
            }
        ],
    ],
];
