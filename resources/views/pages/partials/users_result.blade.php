<div class="result user media">
  <div class="media">
    <div class="avatar media-left">
      <div class="image"><a title="{{ $user_result->name }}" href="{{ route('users.show', $user_result->id) }}">
          <img class="media-object img-thumbnail avatar avatar-66" src="{{ $user_result->present()->gravatar }}" alt="96"></a>
      </div>
    </div>
    <div class="media-body user-info">
      <div class="info">
        <a href="{{ route('users.show', $user_result->id) }}">
            {{ $user_result->name }}
            @if ($user_result->real_name)
                （{{ $user_result->real_name }}）
            @endif
        </a>
        @if ($user_result->present()->hasBadge())
            <div class="role-label">
                <a class="label label-success role" href="{{ route('roles.show', [$user_result->present()->badgeID()]) }}">{{{ $user_result->present()->badgeName() }}}</a>
            </div>
        @endif

        @if ($user_result->introduction)
             | {{ $user_result->introduction }}
        @endif

      </div>
      <div class="info number">
        Membro: {{ $user_result->id }}
          ⋅
        <span title="Data de inscrição">
            {{ Carbon\Carbon::parse($user_result->created_at)->format('Y-m-d') }}
        </span>

          ⋅ <span>{{ $user_result->follower_count }}</span> Seguidores
          ⋅ <span>{{ $user_result->topic_count }}</span> Tópicos
          ⋅ <span>{{ $user_result->reply_count }}</span> Respostas
          ⋅ <span>{{ $user_result->article_count }}</span> Artigos
      </div>
    </div>
  </div>

</div>
<hr>
