
<div class="markdown-body" id="emojify">
{!! $body !!}

@if ($topic->user->signature)
    <!--<a class="popover-with-html" data-content="Assinatura do autor" target="_blank" style="display: block;width: 30px;color: #ccc;margin: 22px 0 8px;" href="https://h3sotospeak.com/topics/3422"><i class="fa fa-paw" aria-hidden="true"></i></a>-->
    <i class="fa fa-paw" aria-hidden="true"></i>
    {!! $topic->user->present()->formattedSignature() !!}
@endif

</div>
