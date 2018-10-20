
@if ($topic->is_excellent == 'yes')
  <div class="ribbon">
      <div class="ribbon-excellent">
          <i class="fa fa-trophy"></i> {{ lang('This topic has been mark as Excenllent Topic.') }}
      </div>
  </div>
@endif

@if ($topic->order == -1)
  <div class="ribbon">
      <div class="ribbon-anchored">
            @if ($topic->category_id === 1)
                <i class="fa fa-anchor"></i> Este post foi <a href="https://h3sotospeak.com/topics/2802">Afundar</a>，Por favor siga <a href="https://h3sotospeak.com/topics/817/hoppe-brasil-recruitment-post-specification">Especificação de lançamento de recrutamento</a>Modificado, alterado @ admin cancelado naufrágio.
            @else
                <i class="fa fa-anchor"></i> Esta etiqueta afundou, por favor verifique <a href="https://h3sotospeak.com/topics/2802">Instruções afundando</a> Modificado, alterado @@ admin cancelado naufrágio.
            @endif
      </div>
  </div>
@endif
