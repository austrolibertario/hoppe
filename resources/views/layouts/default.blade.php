<!DOCTYPE html>
<html lang="pt-BR">
	<head>

		<meta charset="UTF-8" />

		<title>@section('title')Hans-Hermann Hoppe Brasil @show</title>

		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

		<meta name="keywords" content="H³, So To Speak, por assim dizer, libertarianismo, libertarios, anarquia, cyberlibertarianismo, cyber-libertarianismo, livre comercio, Hans-Hermann Hoppe, Ciberativismo libertário, austriacos, austrolibertarios, austro-libertarios, imposto é roubo, estado é gangue, h3" />
		<meta name="author" content="H³ So To Speak" />
		<meta name="description" content="@section('description')Hans-Hermann Hoppe Brasil - Debate Libertário @show" />
        
		<meta property="og:site_name" content="Hans-Hermann Hoppe Brasil" />
		<meta property="og:type" content="article" />
		<meta name="twitter:card" content="summary">
		<meta property="fb:admins" content="h3sotospeak" />
		<meta property="og:title" content="@section('title')Hans-Hermann Hoppe Brasil @show" />
		<meta name="twitter:title" content="@section('title')Hans-Hermann Hoppe Brasil @show" />
		<meta property="og:description" content="@section('description')Hans-Hermann Hoppe Brasil - Debate Libertário @show" />
		<meta property="og:url" content="{{Request::url()}}" />
		<meta name="twitter:url" content="{{Request::url()}}" />
		<meta name="twitter:site" content="@H3SoToSpeak" />
		<?php
		/*
		<meta property="og:image"content="https://marketingdeconteudo.com/wp-content/uploads/2014/09/zuckerberg-620×316.png "/>
		<meta name="twitter:image"content="https://marketingdeconteudo.com/wp-content/uploads/2014/09/zuckerberg-620×316.png" />
		*/
		?>

        <meta name="_token" content="{{ csrf_token() }}" />

        <link rel="stylesheet" href="{{ cdn(elixir('assets/css/styles.css')) }}" />

        <link rel="shortcut icon" href="{{ cdn('favicon1.png') }}" />

        <script>
            Config = {
                'cdnDomain': '{{ get_cdn_domain() }}',
                'user_id': {{ $currentUser ? $currentUser->id : 0 }},
                'user_avatar': {!! $currentUser ? '"'.$currentUser->present()->gravatar() . '"' : '""' !!},
                'user_link': {!! $currentUser ? '"'. route('users.show', $currentUser->id) . '"' : '""' !!},
                'user_badge': '{{ $currentUser ? ($currentUser->present()->hasBadge() ? $currentUser->present()->badgeName() : '') : '' }}',
                'user_badge_link': "{{ $currentUser ? (route('roles.show', [$currentUser->present()->badgeID()])) : '' }}",
                'routes': {
                    'notificationsCount' : '{{ route('notifications.count') }}',
                    'upload_image' : '{{ route('upload_image') }}'
                },
                'token': '{{ csrf_token() }}',
                'environment': '{{ app()->environment() }}',
                'following_users': [],
                'qa_category_id': '{{ config('phphub.qa_category_id') }}'
            };

			var ShowCrxHint = '{{isset($show_crx_hint) ? $show_crx_hint : 'no'}}';
        </script>

	    @yield('styles')

		<meta http-equiv="x-pjax-version" content="{{ elixir('assets/css/styles.css') }}">

	</head>
	<body id="body" class="{{ route_class() }}">

        {{-- Wechat share cover --}}
        <div style="display: none;"
        　　document.getElementById("typediv1").style.display="none";>
            @section('wechat_icon')
            <img src="https://h3sotospeak.com/uploads/images/201701/29/1/pQimFCe1r5.png">
            @show

        </div>

		<div id="wrap">

			@include('layouts.partials.nav')

			<div class="container main-container {{ (Request::is('blogs*') || Request::is('articles*')) || is_route('wildcard') ? 'blog-container' : '' }}">

				@if(Auth::check() && !Auth::user()->verified && !Request::is('email-verification-required'))
    				<div class="alert alert-warning">
    		            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						A caixa de correio não está ativada Vá para {{ Auth::user()->email }} para verificar o email de ativação Após a ativação, você pode usar totalmente os recursos da comunidade, como postar e responder. Não recebeu o email? Por favor, vá para <a href="{{ route('email-verification-required') }}">reenvie e-mail</a>.
    		        </div>
                @elseif (Auth::check() && empty(Auth::user()->password) )
                    <div class="alert alert-warning">
    		            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						A senha de login não está definida. Vá para a página <a href="{{ route('users.edit_password', [Auth::id()]) }}">Alterar senha</a> para configurá-la. Depois de definido, você poderá fazer login no site usando sua caixa de correio em seu dispositivo móvel.
    		        </div>
				@endif

				@include('flash::message')

				@yield('content')

			</div>

            @include('layouts.partials.footer')

		</div>



        <script src="{{ cdn(elixir('assets/js/scripts.js')) }}"></script>

	    @yield('scripts')

        @if (App::environment() == 'production')
			<script>
			  ga('create', '{{ getenv('GA_Tracking_ID') }}', 'auto');
			  ga('send', 'pageview');
			</script>
			<script src="https://cdn.ravenjs.com/3.22.3/raven.min.js" crossorigin="anonymous"></script>
			<script>Raven.config('https://6b86e675df974aa4a7bdfb83015ff4e5@sentry.io/1290773').install();</script>
        @endif



	</body>
</html>
