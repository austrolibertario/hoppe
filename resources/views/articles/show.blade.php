@extends('layouts.default')

@section('title'){{$topic->title}}@stop

@section('description'){{{\App\Models\Topic::makeExcerpt($topic->body)}}}@stop

@section('wechat_icon')
<img src="{{ img_crop($blog->cover, 512, 512) }}" alt="">
@stop

@section('content')

<div class="blog-pages">

          <div class="col-md-9 left-col pull-right">

              <div class="panel article-body content-body">

                  <div class="panel-body">

                        <h1 class="text-center">
                            {{ $topic->title }}
                        </h1>

                        @if ($topic->is_draft == 'yes')
                            <div class="text-center alert alert-warning">
                                O estado atual é <i class="fa fa-file-text-o"></i>Rascunho, visível apenas para o autor, por favor, vá <a href="{{ route('articles.edit', $topic->id) }}" class="no-pjax">Editar lançamento</a>
                            </div>
                        @endif

                        <div class="article-meta text-center">
                            <i class="fa fa-clock-o"></i> <abbr title="{{ $topic->created_at }}" class="timeago">{{ $topic->created_at }}</abbr>
                            ⋅
                            <i class="fa fa-eye"></i> {{ $topic->view_count }}
                            ⋅
                            <i class="fa fa-thumbs-o-up"></i> {{ $topic->vote_count }}
                            ⋅
                            <i class="fa fa-comments-o"></i> {{ $topic->reply_count }}

                        </div>

                        <div class="entry-content">
                            @include('topics.partials.body', array('body' => $topic->body))
                        </div>


                        <div class="post-info-panel">
                            <p class="info">
                                <label class="info-title">Não existem direitos autorais：</label><i class="fa fa-fw fa-creative-commons"></i>Pode copiar e assumir a autoria（<a href="https://github.com/austrolibertario/anarchist-license">Anarchist License 1.0</a>）
                            </p>
                        </div>
                        <br>
                        <br>
                        @include('topics.partials.topic_operate', ['is_article' => true, 'manage_topics' => $currentUser ? ($currentUser->can("manage_topics") && $currentUser->roles->count() <= 5) : false])
                  </div>

              </div>

              @include('topics.partials.show_segment')
        </div>


        @if( $topic->user->payment_qrcode )
            @include('topics.partials.payment_qrcode_modal')
        @endif

        <div class="col-md-3 main-col pull-left">
            @include('blogs._info')

            <div id="sticker">

                <div class="panel panel-default corner-radius">

                  <div class="panel-heading text-center">
                    <h3 class="panel-title">Autor：{{ $topic->user->name }}</h3>
                  </div>

                    <div class="panel-body text-center topic-author-box">
                        @include('topics.partials.topic_author_box')

                        @if(Auth::check() && $currentUser->id != $topic->user->id)
                            <span class="text-white">
                                <?php $isFollowing = $currentUser && $currentUser->isFollowing($topic->user->id) ?>
                                <hr>
                                <a data-method="post" class="btn btn-{{ !$isFollowing ? 'warning' : 'default' }} btn-block" href="javascript:void(0);" data-url="{{ route('users.doFollow', $topic->user->id) }}" id="user-edit-button">
                                   <i class="fa {{!$isFollowing ? 'fa-plus' : 'fa-minus'}}"></i> {{ !$isFollowing ? 'Seguir' : 'Parar de seguir' }}
                                </a>

                                <a class="btn btn-default btn-block" href="{{ route('messages.create', $topic->user->id) }}" >
                                   <i class="fa fa-envelope-o"></i> Envie uma mensagem
                                </a>
                            </span>
                        @endif
                    </div>
                </div>
            </div>


            @if (count($userTopics))

            <div class="recommended-wrap">
                <div class="panel panel-default corner-radius recommended-articles">
                    <div class="panel-heading text-center">
                      <h3 class="panel-title">Recomendação de Blog</h3>
                    </div>
                    <div class="panel-body">
                      @include('layouts.partials.sidebar_topics', ['sidebarTopics' => $userTopics, 'is_article' => true])
                    </div>
                </div>
            </div>

            @endif

        </div>

</div>

@stop


@section('scripts')
<script type="text/javascript">

    $(document).ready(function()
    {
        var $config = {
            title               : '{{{ $topic->title }}} | de H³ #hoppe-brasil# {{ $topic->user->id != 1 ? '@ricardosierra' : '' }} {{ $topic->user->weibo_name ? '@'.$topic->user->weibo_name : '' }}',
            wechatQrcodeTitle   : "Escaneie para compartilhar", // WeChat QR code prompt de texto
            wechatQrcodeHelper  : '<p>No WeChat va em "Discover" e mire no qrcode</p>',
            image               : "{{ $cover ? $cover->link : $blog->cover }}",
            sites               : ['facebook', 'twitter', 'google', 'wechat'] //, 'linkedin', 'pinterest', 'weibo','qzone', 'qq', 'douban',
        };

        socialShare('.social-share-cs', $config);

        Config.following_users =  @if($currentUser) {!!$currentUser->present()->followingUsersJson()!!} @else [] @endif;
        PHPHub.initAutocompleteAtUser();
    });

</script>
@stop