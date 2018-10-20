@extends('layouts.default')

@section('title')
@if (if_query('view', null))
Minha atenção para a dinâmica | @parent
@elseif (if_query('view', 'all'))
Toda a dinâmica | @parent
@elseif (if_query('view', 'mine'))
Minha dinâmica | @parent
@endif
@stop

@section('content')

<div class="col-md-9 topics-index feed-list main-col">

    <div class="panel panel-default">

        <div class="panel-heading">
            <ul class="nav nav-tabs">
                <li role="presentation" class="{{ active_class(if_query('view', null)) }}"><a href="{{ route('home') }}"><i class="fa fa-eye" aria-hidden="true"></i> Tópicos Sugeridos</a></li>
                <li role="presentation" class="{{ active_class(if_query('view', 'all')) }}"><a href="{{ route('home', ['view' => 'all']) }}"><i class="fa fa-rss" aria-hidden="true"></i> Todos os Tópicos</a></li>
                <li role="presentation" class="{{ active_class(if_query('view', 'mine')) }}"><a href="{{ route('home', ['view' => 'mine']) }}"><i class="fa fa-calendar-minus-o" aria-hidden="true"></i> Meus Tópicos</a></li>
            </ul>
        </div>

        @if ( ! $activities->isEmpty())

            <div class="jscroll">
                <div class="panel-body remove-padding-horizontal">
                    <ul class="list-group row feed-list">
                        <?php
                             $indentifiers = [];
                        ?>
                        @foreach ($activities as $activity)
                            @unless($activity->type == 'UserPublishedNewTopic' && in_array($activity->indentifier, $indentifiers))
                                @include('activities.types._' . snake_case(class_basename($activity->type)))
                            @endunless
                            <?php
                                if ($activity->type == 'BlogHasNewArticle') {
                                    $indentifiers[] = $activity->indentifier;
                                }
                            ?>
                        @endforeach
                    </ul>

                </div>


                @if (($activities->total() / $activities->perPage() ) > 1)
                    <div class="panel-footer text-right remove-padding-horizontal pager-footer">
                        {!! $activities->appends(Request::except('page', '_pjax'))->render() !!}
                    </div>
                @else
                <div class="panel-footer text-center remove-padding-horizontal pager-footer">
                        <div class="pagination" style="color: #ccc;">
                            Carregamento concluído ~~
                        </div>
                    </div>
                @endif


            </div>

        @else
            <div class="panel-body">
                <div class="empty-block">
                    @if (if_query('view', null))
                        (=￣ω￣=)··· Siga um usuário ou assine um blog para ter conteúdo aqui.
                    @elseif (if_query('view', 'all'))
                        (=￣ω￣=)···  Inatividade, seja dinâmico! Lembre-se de comentar e curtir para gerar interações.
                    @endif
                </div>
            </div>
        @endif

    </div>

</div>

@include('layouts.partials.sidebar')

@stop
