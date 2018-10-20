<footer class="footer">
      <div class="container">
        <div class="row footer-top">

          <div class="col-sm-5 col-lg-5">

              <p class="padding-top-xsm">Somos uma comunidade de libertários, seguidores da escola austriaca afim de compartilhar criatividade, conhecer parceiros e colaborar.</p>

              <div class="text-md " >
                  <a class="popover-with-html" data-content="Problema de feedback" target="_blank" style="padding-right:8px" href="mailto:ricardo@sierratecnologia.com.br"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                  <a class="popover-with-html" data-content="Siga-nos no Twitter" target="_blank" style="padding-right:8px" href="https://twitter.com/H3SoToSpeak"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                  <a class="popover-with-html" data-content="Siga-nos no facebook" target="_blank" style="padding-right:8px" href="https://www.facebook.com/h3sotospeak"><i class="fa fa-facebook-square" aria-hidden="true"></i></a>
                  <a class="popover-with-html" data-content="Siga-nos no instagram" target="_blank" style="padding-right:8px" href="https://www.instagram.com/h3.sotospeak/"><i class="fa fa-instagram" aria-hidden="true"></i></a>
              </div>
              <br>
              <span style="font-size:0.9em">
                  Equipe Hans-Hermann Hoppe Brasil
              </span>
          </div>

          <div class="col-sm-6 col-lg-6 col-lg-offset-1">

              <div class="row">
                <div class="col-sm-4">
                  <h4>Patrocinador</h4>
                  <ul class="list-unstyled">
                      @if(isset($banners['footer-sponsor']))
                          @foreach($banners['footer-sponsor'] as $banner)
                              <a href="{{ linkWithUTMSource($banner->link) }}" target="_blank"><img src="{{ $banner->image_url }}" class="popover-with-html footer-sponsor-link" width="98" data-placement="top" data-content="{{ $banner->title }}"></a>
                          @endforeach
                      @endif
                  </ul>
                </div>

                  <div class="col-sm-4">
                    <h4>{{ lang('Site Status') }}</h4>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('users.index') }}">{{ lang('Total User') }}: {{ $siteStat->user_count }}</a></li>
                        <li>{{ lang('Total Topic') }}: {{ $siteStat->topic_count }} </li>
                        <li>{{ lang('Total Reply') }}: {{ $siteStat->reply_count }} </li>
                    </ul>
                  </div>
                  <div class="col-sm-4">
                    <h4>Outras informações</h4>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('sites.index') }}"><i class="fa fa-globe text-md"></i> Sites recomendados</a></li>
                        <li><a href="/about"><i class="fa fa-info-circle" aria-hidden="true"></i> Sobre nós</a></li>
                        <li><a href="{{ route('hall_of_fames') }}"><i class="fa fa-star" aria-hidden="true"></i> {{ lang('Hall of Fame') }}</a></li>
                    </ul>
                  </div>

                </div>

          </div>
        </div>
        <br>
        <br>
      </div>
    </footer>   
