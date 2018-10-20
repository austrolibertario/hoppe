@extends('layouts.default')

@section('title')
{{ lang('Recommended Sites') }} @parent
@stop

@section('content')

    <div class="box text-center site-intro rm-link-color">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        Bem-vindo ao Instituto Hoppe Brasil, prioridade ao libertarianismo, tópicos relacionados à anarquia. Entre em contato com <a href="mailto:ricardo@sierratecnologia.com.br">Nossa Equipe</a>
    </div>

    <div class="sites-index">

        @include('sites.partials.sites', ['heading_title' => '<i class="fa fa-weibo text-md"></i> Canais Libertários', 'filterd_sites' => $sites['canal']])

        @include('sites.partials.sites', ['heading_title' => '<i class="fa fa-globe text-md"></i> Portais Libertários', 'filterd_sites' => $sites['portal']])

        @include('sites.partials.sites', ['heading_title' => '<i class="fa fa-flag text-md"></i> Discussões/Debates Libertários', 'filterd_sites' => $sites['discussão']])

        @include('sites.partials.sites', ['heading_title' => '<i class="fa fa-cloud text-md"></i> Blockchain e Bitcoin', 'filterd_sites' => $sites['blockchain']])

        @include('sites.partials.sites', ['heading_title' => '<i class="fa fa-cloud text-md"></i> Sites Estrangeiros', 'filterd_sites' => $sites['site_foreign']])

        @include('sites.partials.sites', ['heading_title' => '<i class="fa fa-cloud text-md"></i> Outros sites recomendados', 'filterd_sites' => $sites['other']])

    </div>

    @include('layouts.partials.topbanner')

@stop
