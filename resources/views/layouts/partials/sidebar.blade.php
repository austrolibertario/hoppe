<div class="col-md-3 side-bar">

    @if (Auth::check() && Auth::user()->draft_count > 0)
        <div class="text-center alert alert-warning">
            <a href="{{ route('users.drafts') }}" style="color:inherit;"><i class="fa fa-file-text-o"></i>
                Rascunho {{ Auth::user()->draft_count }} 篇</a>
        </div>
    @endif


    @if (isset($topic))
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
                <a data-method="post" class="btn btn-{{ !$isFollowing ? 'warning' : 'default' }} btn-block"
                   href="javascript:void(0);" data-url="{{ route('users.doFollow', $topic->user->id) }}"
                   id="user-edit-button">
                   <i class="fa {{!$isFollowing ? 'fa-plus' : 'fa-minus'}}"></i> {{ !$isFollowing ? 'Seguir' : 'Deixar de seguir' }}
                </a>

                <a class="btn btn-default btn-block" href="{{ route('messages.create', $topic->user->id) }}">
                   <i class="fa fa-envelope-o"></i> Envie uma mensagem
                </a>
            </span>
                @endif
            </div>

        </div>
    @endif


    @if (isset($userTopics) && count($userTopics))
        <div class="panel panel-default corner-radius">
            <div class="panel-heading text-center">
                <h3 class="panel-title">Outros tópicos de {{ $topic->user->name }}</h3>
            </div>
            <div class="panel-body">
                @include('layouts.partials.sidebar_topics', ['sidebarTopics' => $userTopics])
            </div>
        </div>
    @endif


    @if (isset($categoryTopics) && count($categoryTopics))
        <div class="panel panel-default corner-radius">
            <div class="panel-heading text-center">
                <h3 class="panel-title">{{ lang('Same Category Topics') }}</h3>
            </div>
            <div class="panel-body">
                @include('layouts.partials.sidebar_topics', ['sidebarTopics' => $categoryTopics])
            </div>
        </div>
    @endif

    @if (isset($active_users) && count($active_users))
        <div class="panel panel-default corner-radius panel-active-users">
            <div class="panel-heading text-center">
                <h3 class="panel-title">{{ lang('Active Users') }}（<a href="{{ route('hall_of_fames') }}"><i
                                class="fa fa-star" aria-hidden="true"></i> {{ lang('Hall of Fame') }}</a>）</h3>
            </div>
            <div class="panel-body">
                @include('topics.partials.active_users')
            </div>
        </div>
    @endif

    @if (isset($hot_topics) && count($hot_topics))
        <div class="panel panel-default corner-radius panel-hot-topics">
            <div class="panel-heading text-center">
                <h3 class="panel-title">Mais quente da Semana</h3>
            </div>
            <div class="panel-body">
                @include('layouts.partials.sidebar_topics', ['sidebarTopics' => $hot_topics, 'numbered' => true])
            </div>
        </div>
    @endif


    <div class="panel panel-default corner-radius">
        <div class="panel-body text-center sidebar-sponsor-box">
            @if(isset($banners['sidebar-sponsor']))
                @foreach($banners['sidebar-sponsor'] as $banner)
                    <a class="sidebar-sponsor-link" href="{{ linkWithUTMSource($banner->link) }}" target="_blank">
                        <img src="{{ $banner->image_url }}" class="popover-with-html"
                             data-content="{{ $banner->title }}" width="100%">
                    </a>
                    <hr>
                @endforeach
            @endif
        </div>
    </div>

    @if (Route::currentRouteName() != 'home')
        @if (isset($links) && count($links))
            <div class="panel panel-default corner-radius">
                <div class="panel-heading text-center">
                    <h3 class="panel-title">{{ lang('Links') }}</h3>
                </div>
                <div class="panel-body text-center" style="padding-top: 5px;">
                    @foreach ($links as $link)
                        <a href="{{ linkWithUTMSource($link->link) }}" target="_blank" rel="nofollow" title="{{ $link->title }}"
                           style="padding: 3px;">
                            <img src="{{ $link->cover }}" style="width:150px; margin: 3px 0;">
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    @endif

    <?php /*
    @if (Route::currentRouteName() == 'topics.index')

        <div class="panel panel-default corner-radius">
            <div class="panel-heading text-center">
                <h3 class="panel-title">{{ lang('App Download') }}</h3>
            </div>
            <div class="panel-body text-center" style="padding: 7px;">
                <a href="https://h3sotospeak.com/topics/1531" target="_blank" rel="nofollow" title="">
                    <img src="https://raw.githubusercontent.com/austrolibertario/awesome/master/media/logo_anarcocapitalismo.jpg" style="width:240px;">
                </a>
            </div>
        </div>

    @endif
    */ ?>

    <div id="sticker">

        @include('layouts.partials._resources_panel')

        <div class="panel panel-default corner-radius" style="color:#a5a5a5">
            <div class="panel-body text-center">
                <a href="https://www.facebook.com/h3sotospeak" target="_BLANK" style="color:#a5a5a5">
                    <span style="margin-top: 7px;display: inline-block;">
                        Siga nossa Página no Facebook
                    </span>
                </a>
            </div>
        </div>
        
        <div class="panel panel-default corner-radius" style="color:#a5a5a5">
            <div class="panel-body text-center">
                <a href="{{ Auth::check() ? 'https://h3sotospeak.com/messages/to/1' : 'mailto:ricardo@sierratecnologia.com.br'}}"
                   style="color:#a5a5a5">
                    <span style="margin-top: 7px;display: inline-block;">
                        <i class="fa fa-heart" aria-hidden="true" style="color: rgba(232, 146, 136, 0.89);"></i> Sugestões de feedback? Por favor nos envie uma mensagem!
                    </span>
                </a>
            </div>
        </div>

        <div class="panel panel-default corner-radius" style="text-align: center; background-color: transparent; border: none;">
            <a href="https://h3sotospeak.com/about" rel="nofollow" title="" style="">
                <img src="https://h3sotospeak.com/assets/images/hoppe/banner.jpeg" style="width: 100%;border-radius: 0px;box-shadow: none;border: 1px solid #ffafaf;">
            </a>
        </div>

    </div>
</div>
<div class="clearfix"></div>

