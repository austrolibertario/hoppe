@extends('layouts.default')

@section('title')
{{ isset($category) ? $category->name : '话题列表'  }} @parent
@stop

@section('content')

<div class="col-md-9 topics-index main-col hunt-index share-link-index">

    @if (isset($category) && $category->id == config('phphub.life_category_id'))
        <div class="alert alert-info">
        "A vida pode trazer inspiração para o trabalho e o trabalho é para uma vida melhor. Tópicos como viagens, imigração, animais de estimação, etc. <?php /*Postando por favor siga <a style="text-decoration: underline;" href="https://h3sotospeak.com/topics/3022/community-posting-and-management">Postagens comunitárias e práticas de gerenciamento</a>。*/?>
        </div>
    @endif
    @if (isset($category) && $category->id == config('phphub.qa_category_id'))
        <div class="alert alert-info">
        Por favor faça debates construtivos<?php /*Na H3, nós não defendemos <a href="{{ route('topics.show', 535) }}" style="text-decoration: underline;">Pergunta principiante</a> ，Se você tiver problemas de programação, por favor, primeiro <a href="{{ route('topics.show', 3656) }}" style="text-decoration: underline;">搜索</a> 再 <a href="{{ route('topics.create', ['category_id' => config('phphub.qa_category_id')]) }}" class="btn btn-warning">Faça uma pergunta</a>*/ ?>
        </div>
    @endif
    @if (isset($category) && $category->id === 1)
        <div class="alert alert-info">
        Por favor, pesquise antes de postar para verificar se não está sendo repetido. <a href="{{ route('topics.create', ['category_id' => 1]) }}" class="btn btn-warning">Postar Assunto</a><?php /*<a href="https://h3sotospeak.com/topics/817/hoppe-brasil-recruitment-post-specification" style="text-decoration: underline;">Hans-Hermann Hoppe Brasil Especificação de lançamento de recrutamento</a>，Postar sem a especificação será admin <a href="https://h3sotospeak.com/topics/2802/description-of-shen" style="text-decoration: underline;">Naufrágio permanente</a>。*/ ?>
        </div>
    @endif
    <div class="panel panel-default">

        <div class="panel-heading">


          <ul class="list-inline topic-filter">

                <li class="popover-with-html" data-content="Últimas respostas"><a {!! app(App\Models\Topic::class)->present()->topicFilter('default') !!}>Ativo</a></li>
                <li class="popover-with-html" data-content="Classificado em relação a data de publicação"><a {!! app(App\Models\Topic::class)->present()->topicFilter('recent') !!}>{{ lang('Recent') }}</a></li>
                <li class="popover-with-html" data-content="Links Favoritos"><a {!! app(App\Models\Topic::class)->present()->topicFilter('excellent') !!}>{{ lang('Excellent') }}</a></li>
                <li class="popover-with-html" data-content="Links Curtidos"><a {!! app(App\Models\Topic::class)->present()->topicFilter('vote') !!}>{{ lang('Vote') }}</a></li>

                <li class="pull-right" style="margin-right: -5px;">
                    <a href="{{ route('share_links.create') }}" class="btn btn-primary btn-sm share-link no-pjax">
                        <i class="fa fa-link "></i> Compartilhar link
                    </a>
                </li>
            </ul>

          <div class="clearfix"></div>
        </div>

        @if ( ! $topics->isEmpty())

            <div class="jscroll">
                <div class="panel-body remove-padding-horizontal">
                    @include('share_links.partials.share_links')
                </div>

                <div class="panel-footer text-right remove-padding-horizontal pager-footer">
                    <!-- Pager -->
                    {!! $topics->appends(Request::except('page', '_pjax'))->render() !!}
                </div>
            </div>

        @else
            <div class="panel-body">
                <div class="empty-block">{{ lang('Dont have any data Yet') }}~~</div>
            </div>
        @endif

    </div>

</div>

@include('layouts.partials.sidebar')

@stop

@section('scripts')

<script type="text/javascript">

    $(document).ready(function()
    {
        $('.share-link-site').click(function(e) {
            var link = $(this).data('link');
            var win = window.open(link, '_blank');
            if (win) {
                win.focus();
            } else {
                alert('Por favor, permita o pop-up nesta página!');
            }

            e.stopPropagation();
            return false;
        });
    });



</script>
@stop
