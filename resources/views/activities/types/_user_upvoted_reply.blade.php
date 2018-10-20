<li class="list-group-item media" >
    <div class="avatar pull-left">
        <a href="{{ route('users.show', [$activity->user->id]) }}">
            <img class="media-object img-thumbnail avatar" alt="{{ $activity->user->name }}" src="{{ $activity->user->present()->gravatar }}" />
        </a>
    </div>
    <div class="infos">
        <div class="media-heading">

            <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>

            <a href="{{ route('users.show', [$activity->user->id]) }}">
                {{ $activity->user->name }}
            </a>
            @if ($activity->data['topic_type'] == 'article')
                gostou do artigo
            @elseif ($activity->data['topic_type'] == 'share_link')
                gostou do link
            @else
                gostou do tópico
            @endif
             <a href="{{ $activity->data['topic_link'] }}#reply{{ $activity->data['reply_id'] }}" title="{{ $activity->data['topic_title'] }}">
                {{ str_limit($activity->data['topic_title'], '100') }}
            </a>
            @if (isset($activity->data['reply_user_name']))
                Abaixo <a href="{{ $activity->data['topic_link'] }}#reply{{ $activity->data['reply_id'] }}">{{ '@'.$activity->data['reply_user_name'] }} Comentário</a>：
            @else
                Abaixo <a href="{{ $activity->data['topic_link'] }}#reply{{ $activity->data['reply_id'] }}">Comentário</a>：
            @endif

             <span class="meta pull-right">
                 <span class="timeago">{{ $activity->created_at }}</span>
            </span>
        </div>
        <div class="media-body markdown-reply content-body">
            {!! $activity->data['body'] !!}
        </div>
    </div>
</li>