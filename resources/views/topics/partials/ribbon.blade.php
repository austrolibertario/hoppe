
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
            <i class="fa fa-anchor"></i> Este tópico foi classificado como não relevante. Por favor verifique nossas regras para publicação.
      </div>
  </div>
@endif
