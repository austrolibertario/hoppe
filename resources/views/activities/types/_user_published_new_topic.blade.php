<li class="list-group-item media" >
    <div class="avatar pull-left">
        <a href="{{ route('users.show', [$activity->user->id]) }}">
            <img class="media-object img-thumbnail avatar" alt="{{ $activity->user->name }}" src="{{ $activity->user->present()->gravatar }}" />
        </a>
    </div>
    <div class="infos">
        <div class="media-heading">

            <i class="fa fa-file-text-o" aria-hidden="true"></i>

            <a href="{{ route('users.show', [$activity->user->id]) }}">
                {{ $activity->user->name }}
            </a>
            @if ($activity->data['topic_type'] == 'article')
                publicou um artigo
                 <a href="{{ $activity->data['topic_link'] }}" title="{{ $activity->data['topic_title'] }}">
                    {{ "《" . str_limit($activity->data['topic_title'], '100') . "》" }}
                </a>

            @elseif ($activity->data['topic_type'] == 'share_link')
                compartilhou o link

                 <a href="{{ $activity->data['topic_link'] }}" title="{{ $activity->data['topic_title'] }}">
                    <i class="fa fa-link"></i> {{ str_limit($activity->data['topic_title'], '100') }}
                </a>
            @else
                na categoria <a href="{{ route('categories.show', $activity->data['topic_category_id'] ) }}">{{ $activity->data['topic_category_name'] }}</a>
                postou o tópico

                 <a href="{{ $activity->data['topic_link'] }}" title="{{ $activity->data['topic_title'] }}">
                    {{ str_limit($activity->data['topic_title'], '100') }}
                </a>

            @endif
            <span class="meta pull-right">
                 <span class="timeago">{{ $activity->created_at }}</span>
            </span>

            @include("activities._topic_images")
        </div>
    </div>
</li>