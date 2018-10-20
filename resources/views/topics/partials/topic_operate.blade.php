<div class="panel-footer operate">

    <div class="pull-left hidden-xs">
        <div class="social-share-cs "></div>
    </div>

  <div class="pull-right actions">

    @if ($currentUser && $currentUser->isAttentedTopic($topic))
      <a class="popover-with-html" data-content="Vigiar Tópico. Vocẽ será notificado quando comentários forem criados" data-method="post" id="topic-attent-cancel-button" href="javascript:void(0);" data-url="{{ route('attentions.createOrDelete', $topic->id) }}">
        <i class="glyphicon glyphicon-eye-open" style="color:#ce8a81"></i> <span></span>
      </a>
    @elseif ($currentUser)
      <a class="popover-with-html" data-content="Vigiar Tópico. Vocẽ será notificado quando comentários forem criados" data-method="post" id="topic-attent-button" href="javascript:void(0);" data-url="{{ route('attentions.createOrDelete', $topic->id) }}">
        <i class="glyphicon glyphicon-eye-open"></i> <span></span>
      </a>
    @endif

    @if ($currentUser && $manage_topics )
        <a data-ajax="post" id="topic-recomend-button" href="javascript:void(0);" data-url="{{ route('topics.recommend', [$topic->id]) }}" class="admin popover-with-html {{ $topic->is_excellent == 'yes' ? 'active' : ''}}" data-content="Recomendar Tópico. Mensagens adicionadas aparecerão na página inicial">
        <i class="fa fa-trophy"></i>
        </a>

        @if ($topic->order >= 0)
          <a data-ajax="post" id="topic-pin-button" href="javascript:void(0);" data-url="{{ route('topics.pin', [$topic->id]) }}" class="admin popover-with-html {{ $topic->order > 0 ? 'active' : '' }}" data-content="Fixar Post. Será colocado no começo da Lista">
            <i class="fa fa-thumb-tack"></i>
          </a>
        @endif

        @if ($topic->order <= 0)
            <a data-ajax="post" id="topic-sink-button" href="javascript:void(0);" data-url="{{ route('topics.sink', [$topic->id]) }}" class="admin popover-with-html {{ $topic->order < 0 ? 'active' : '' }}" data-content="Marcar como não interessante. As postagens serão reduzidas pela prioridade de classificação">
                <i class="fa fa-anchor"></i>
            </a>
        @endif

    @endif

    @if ( $currentUser && ($manage_topics || $currentUser->id == $topic->user_id) )

        <a data-method="delete" id="topic-delete-button" href="javascript:void(0);" data-url="{{ route('topics.destroy', [$topic->id]) }}" data-content="{{ lang('Delete') }}" class="admin  popover-with-html">
            <i class="fa fa-trash-o"></i>
        </a>

        @if ($topic->isShareLink())
        <a id="topic-edit-button" href="{{ route('share_links.edit', [$topic->id]) }}" data-content="{{ lang('Edit') }}" class="admin  popover-with-html no-pjax">
            <i class="fa fa-pencil-square-o"></i>
          </a>
        @else
        <a id="topic-edit-button" href="{{ isset($is_article) ?  route('articles.edit', [$topic->id]) : route('topics.edit', [$topic->id]) }}" data-content="{{ lang('Edit') }}" class="admin  popover-with-html no-pjax">
            <i class="fa fa-pencil-square-o"></i>
          </a>
        @endif

    @endif


      @if (!isset($is_article) && $currentUser && ($manage_topics || $currentUser->id == $topic->user_id))
          <a id="topic-append-button" href="javascript:void(0);" class="admin  popover-with-html" data-toggle="modal" data-target="#exampleModal" data-content="Publique um post, todos os usuários que participaram da discussão depois de receber a postagem receberão um lembrete de mensagem, incluindo usuários que gostam e comentam">
            <i class="fa fa-plus"></i>
          </a>

          @if ($topic->user->blogs()->count() > 0)
              <a data-method="patch" data-btn="transform-button" href="javascript:void(0);" data-url="{{ route('articles.transform', [$topic->id]) }}" class="admin  popover-with-html" data-content="Converter tópicos em blogs">
                <i class="fa fa-rocket" aria-hidden="true"></i>
              </a>
          @endif
      @endif

  </div>
  <div class="clearfix"></div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" role="" aria-labelledby="exampleModalLabel" >
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">{{ lang('Append Content') }}</h4>
      </div>

     <form method="POST" action="{{route('topics.append', $topic->id)}}" accept-charset="UTF-8">
         {!! csrf_field() !!}
        <div class="modal-body">

          <div class="alert alert-warning">
              {{ lang('append_notice') }}
          </div>

          <div class="form-group">
              <textarea class="form-control" style="min-height:20px" placeholder="{{ lang('Please using markdown.') }}" name="content" cols="50" rows="10"></textarea>
          </div>

          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{ lang('Close') }}</button>
            <button type="submit" class="btn btn-primary">{{ lang('Submit') }}</button>
          </div>

      </form>

    </div>
  </div>
</div>
