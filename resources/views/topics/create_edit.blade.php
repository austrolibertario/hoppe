@extends('layouts.default')

@section('title')
{{ isset($topic) ? 'Editar tópico' : lang('Create New Topic') }}_@parent
@stop

@section('content')

<div class="topic_create">

  <div class="col-md-8 main-col">

    <div class="reply-box form box-block">

      <div class="alert alert-warning">
          {!! lang('be_nice') !!}
      </div>

      @include('layouts.partials.errors')

      @if (isset($topic))
        <form method="POST" action="{{ route('topics.update', $topic->id) }}" accept-charset="UTF-8" id="topic-edit-form" class="topic-form">
        <input name="_method" type="hidden" value="PATCH">
      @else
        <form method="POST" action="{{ route('topics.store') }}" accept-charset="UTF-8" id="topic-create-form" class="topic-form">
      @endif
        {!! csrf_field() !!}
        <div class="form-group">
            <select class="selectpicker form-control" name="category_id" id="category-select" required="require">

              <option value="" disabled {{ count($category) != 0 ?: 'selected' }}>{{ lang('Pick a category') }}</option>

              @foreach ($categories as $value)
                  {{-- Se o usuário puder postar um anúncio e for id == 3 --}}
                  @if($value->id != 3 || Auth::user()->can('compose_announcement'))
                      @if($value->id != config('phphub.admin_board_cid') || Auth::user()->can('access_board'))
                          <option value="{{ $value->id }}" {{ (count($category) != 0 && $value->id == $category->id) ? 'selected' : '' }} >{{ $value->name }}</option>
                      @endif
                  @endif
              @endforeach
            </select>
        </div>


        @foreach ($categories as $cat)
            <div class="category-hint alert alert-warning category-{{ $cat->id }} {{ count($category) && $cat->id == $category->id ? 'animated rubberBand ' : ''}}" style="{{ (count($category) && $cat->id == $category->id) ? '' : 'display:none' }}">
                {!! $cat->description !!}
            </div>
        @endforeach

        <div class="form-group">
            <input class="form-control" id="topic-title" placeholder="{{ lang('Please write down a topic') }}" name="title" type="text" value="{{ !isset($topic) ? '' : $topic->title }}" required="require">
        </div>

        @include('topics.partials.composing_help_block')

        <div class="form-group">To pens
            <textarea required="require" class="form-control" rows="20" style="overflow:hidden" id="reply_content" placeholder="{{ lang('Please using markdown.') }}" name="body" cols="50">{{ !isset($topic) ? '' : $topic->body_original }}</textarea>
        </div>

        <div class="form-group status-post-submit">
            <button class="btn btn-primary submit-btn" id="topic-submit" type="submit">{{ lang('Publish') }}</button>
        </div>

    </form>

    </div>
  </div>

  <div class="col-md-4 side-bar">

    <div class="panel panel-default corner-radius help-box">
      <div class="panel-heading text-center">
        <h3 class="panel-title">{{ lang('This kind of topic is not allowed.') }}</h3>
      </div>
      <div class="panel-body">
        <ul class="list">
            <li> Por favor, pesquise para evitar informação duplicada. </li>
            <li> Por favor, compartilhe tópicos relacionados ao libertarianismo. </li>
            <li> Seja sempre amigável e educado! </li>
            <li> Valorize a argumentação! </li>
      </div>
    </div>

    <div class="panel panel-default corner-radius help-box">
      <div class="panel-heading text-center">
        <h3 class="panel-title">{{ lang('We can benefit from it.') }}</h3>
      </div>
      <div class="panel-body">
        <ul class="list">
            <li> Compartilhe sempre conhecimento </li>
            <li> Entre em contato com novas idéias </li>
            <li> Encontre parceiros para seus projetos e idéias </li>
            <li> Conheça pessoas que pensam como você </li>
            <li> Seja atuante no libertarianismo </li>
        </ul>
      </div>
    </div>

  </div>
</div>

<script>
    Config.topic_id = '{{ isset($topic) ? $topic->id : 0 }}';
</script>

@stop

@section('scripts')

<link rel="stylesheet" href="{{ cdn(elixir('assets/css/editor.css')) }}">
<script src="{{ cdn(elixir('assets/js/editor.js')) }}"></script>

<script type="text/javascript">

    $(document).ready(function()
    {
        @if ( ! isset($topic))
            localforage.getItem('topic-title', function(err, value) {
                if ($('#topic-title').val() == '' && !err) {
                    $('#topic-title').val(value);
                };
            });
            $('#topic-title').keyup(function(){
                localforage.setItem('topic-title', $(this).val());
            });
        @endif

        $('#category-select').on('change', function() {
            var current_cid = $(this).val();
            $('.category-hint').hide();
            $('.category-'+current_cid).fadeIn();
        });

        var simplemde = new SimpleMDE({
            spellChecker: false,
            autosave: {
                enabled: true,
                delay: 5000,
                unique_id: "topic_content{{ isset($topic) ? $topic->id . '_' . str_slug($topic->updated_at) : '' }}"
            },
            forceSync: true,
            tabSize: 4,
            toolbar: [
                "bold", "italic", "heading", "|", "quote", "code", "table",
                "horizontal-rule", "unordered-list", "ordered-list", "|",
                "link", "image", "|",  "side-by-side", 'fullscreen', "|",
                {
                    name: "guide",
                    action: function customFunction(editor){
                        var win = window.open('https://github.com/luongvo209/Markdown-Tutorial/blob/master/README_pt-BR.md', '_blank');
                        if (win) {
                            //Browser has allowed it to be opened
                            win.focus();
                        } else {
                            //Browser has blocked it
                            alert('Favor permitir popups para esse site.');
                        }
                    },
                    className: "fa fa-info-circle",
                    title: "Como usar Marcação de Texto (Linguagem Markdown)!",
                },
                {
                    name: "publish",
                    action: function customFunction(editor){
                        $('#topic-submit').click();
                    },
                    className: "fa fa-paper-plane",
                    title: "Publicar",
                }
            ],
        });

        inlineAttachment.editors.codemirror4.attach(simplemde.codemirror, {
            uploadUrl: Config.routes.upload_image,
            extraParams: {
              '_token': Config.token,
            },
            onFileUploadResponse: function(xhr) {
                var result = JSON.parse(xhr.responseText),
                filename = result[this.settings.jsonFieldName];

                if (result && filename) {
                    var newValue;
                    if (typeof this.settings.urlText === 'function') {
                        newValue = this.settings.urlText.call(this, filename, result);
                    } else {
                        newValue = this.settings.urlText.replace(this.filenameTag, filename);
                    }
                    var text = this.editor.getValue().replace(this.lastValue, newValue);
                    this.editor.setValue(text);
                    this.settings.onFileUploaded.call(this, filename);
                }
                return false;
            }
        });
    });



</script>
@stop
