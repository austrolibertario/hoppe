<div class="panel panel-default corner-radius">

<div class="panel-body text-center topic-author-box blog-info">

    <div class="image blog-cover">
        <a href="{{ route('wildcard', $blog->slug) }}" >
            <img class=" avatar-112 avatar img-thumbnail" src="{{ img_crop($blog->cover, 224, 224) }}">
        </a>
    </div>
    <div class="blog-name">
        <h4><a href="{{ route('wildcard', $blog->slug) }}">{{ $blog->name }}</a></h4>
    </div>
    <div class="blog-description">
        {{ $blog->description ?: $user->name . 'Blog pessoal' }}
    </div>

    <hr>

    <a href="{{ route('wildcard', $blog->slug) }}" class="{{ navViewActive('users.articles') }}">
        <li class="list-group-item"><i class="text-md fa fa-list-ul"></i> &nbsp;Blog（{{ $blog->article_count }}）</li>
    </a>

    @if ($currentUser && ($currentUser->id == $user->id || Entrust::can('manage_users')) )
        <hr>
      <div class="follow-box">
          <a class="btn btn-info btn-block" href="{{ route('blogs.edit', $blog->id) }}">
            <i class="fa fa-edit"></i> Editar Blog
          </a>
      </div>
    @endif

    @if ($currentUser && $currentUser->id != $user->id)
        <hr>

        @if ($currentUser->subscribe($blog))
            <a data-method="post" class="btn btn-default btn-block" href="javascript:void(0);" data-url="{{ route('blogs.unsubscribe', $blog->id) }}">
              <i class="fa fa-minus"></i> Cancelar inscrição
            </a>
        @else
            <div class="follow-box">
                <a data-method="post" class="btn btn-primary btn-block" href="javascript:void(0);" data-url="{{ route('blogs.subscribe', $blog->id) }}">
                  <i class="fa fa-eye"></i> Se inscrever no blog
                </a>
            </div>
        @endif
    @endif

</div>

</div>