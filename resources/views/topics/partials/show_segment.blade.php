
  <div class="votes-container panel panel-default padding-md">

    <div class="panel-body vote-box text-center">

        <div class="btn-group">

            <a data-ajax="post" href="javascript:void(0);" data-url="{{ route('topics.upvote', $topic->id) }}" title="{{ lang('Up Vote') }}"
                data-content="Gosta de uma coleção, você pode visualizá-lo na navegação Como um tópico na sua página pessoal."
                id="up-vote"
                <?php
                    $is_voted = $currentUser && $topic->votes()->ByWhom(Auth::id())->WithType('upvote')->exists();
                ?>
                class="vote btn btn-primary {{ $topic->user->payment_qrcode ?: 'btn-inverted' }} popover-with-html {{  $is_voted ? 'active' :'' }}" >
                @if ($is_voted)
                    Remover Curtir
                @else
                <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                    Curtir
                @endif

            </a>

            @if( $topic->user->payment_qrcode )
                <div class="or"></div>
                <button class="btn btn-warning popover-with-html"  data-toggle="modal" data-target="#payment-qrcode-modal" data-content="Se você acha que meu artigo é útil para você, sinta-se à vontade para pedir. Seu apoio me incentivará a continuar criando! <br> Você pode modificar o perfil Código QR de pagamento para ativar a função de recompensa.">
                    <i class="fa fa-heart" aria-hidden="true"></i>
                    Recompensa
                </button>
            @endif
        </div>

        <div class="voted-users">

            @if(count($votedUsers))
                <div class="user-lists">
                    @foreach($votedUsers as $votedUser)
                        <a href="{{ route('users.show', $votedUser->id) }}" data-userId="{{ $votedUser->id }}">
                            <img class="img-thumbnail avatar avatar-middle" src="{{ $votedUser->present()->gravatar() }}" style="width:48px;height:48px;">
                        </a>
                    @endforeach
                </div>
            @else
                <div class="user-lists">

                </div>
                <div class="vote-hint">
                    Seja o primeiro a gostar <img title=":bowtie:" alt=":bowtie:" class="emoji" src="https://dn-phphub.qbox.me/assets/images/emoji/bowtie.png" align="absmiddle"></img>
                </div>
            @endif

            <a class="voted-template" href="" data-userId="" style="display:none">
                <img class="img-thumbnail avatar avatar-middle" src="" style="width:48px;height:48px;">
            </a>
        </div>

    </div>
  </div>

  <!-- Reply List -->
  <div class="replies panel panel-default list-panel replies-index" id="replies">

    <div class="panel-heading">
        <div class="total">{{ lang('Total Reply Count') }}: <b>{{ $replies->total() }}</b> </div>

        <div class="order-links">
            <a class="btn btn-default btn-sm {{ active_class( ! if_query('order_by', 'vote_count')) }} popover-with-html" data-content="Ordenar por hora" href="{{ $topic->link(['order_by' => 'created_at', '#replies']) }}" role="button">Recentes</a>
            <a class="btn btn-default btn-sm {{ active_class(if_query('order_by', 'vote_count')) }} popover-with-html" data-content="Ordenar por voto" href="{{ $topic->link(['order_by' => 'vote_count', '#replies'])  }}" role="button">Favoritos</a>
        </div>

    </div>

    <div class="panel-body">

      @if (count($replies))
        @include('topics.partials.replies', ['manage_topics' => $currentUser ? $currentUser->can("manage_topics") : false])
        <div id="replies-empty-block" class="empty-block hide">{{ lang('No comments') }}~~</div>
      @else
        <ul class="list-group row"></ul>
        <div id="replies-empty-block" class="empty-block">{{ lang('No comments') }}~~</div>
      @endif

      <!-- Pager -->
      <div class="pull-right" style="padding-right:20px">
        {!! $replies->appends(Request::except('page'))->render() !!}
      </div>
    </div>
  </div>

  <!-- Reply Box -->
  <div class="reply-box form box-block">

    @include('layouts.partials.errors')

    <form method="POST" action="{{ route('replies.store') }}" accept-charset="UTF-8" id="reply-form">
      {!! csrf_field() !!}
      <input type="hidden" name="topic_id" value="{{ $topic->id }}" />

        @include('topics.partials.composing_help_block')

        <div class="alert alert-dismissable alert-info">
            <i class="fa fa-info" aria-hidden="true"></i> &nbsp;&nbsp;Não poste conteúdo ofensivo. Ser educado com as pessoas é mais importante do que ser inteligente!
        </div>

        <div class="form-group">
            @if ($currentUser)
                @if ($currentUser->verified)
                <textarea class="form-control" rows="5" placeholder="{{ lang('Please using markdown.') }}" style="overflow:hidden" id="reply_content" name="body" cols="50"></textarea>
                @else
                <textarea class="form-control" disabled="disabled" rows="5" placeholder="{{ lang('You need to verify the email for commenting.') }}" name="body" cols="50"></textarea>
                @endif
            @else
                <textarea class="form-control" disabled="disabled" rows="5" placeholder="{{ lang('User Login Required for commenting.') }}" name="body" cols="50"></textarea>
            @endif
        </div>

        <div class="form-group reply-post-submit">
            <input class="btn btn-primary {{ $currentUser ? '' :'disabled'}}" id="reply-create-submit" type="submit" value="{{ lang('Reply') }}">
            <span class="help-inline" title="Or Command + Enter">Ctrl+Enter</span>
        </div>

        <div class="box preview markdown-reply" id="preview-box" style="display:none;"></div>

    </form>
  </div>
