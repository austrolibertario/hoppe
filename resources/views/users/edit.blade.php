@extends('layouts.default')

@section('title')
{{ lang('Edit Profile') }} | @parent
@stop

@section('content')

<div class="users-show">

  <div class="col-md-3 main-col">
    @include('users.partials.setting_nav')
  </div>

  <div class="col-md-9  left-col ">

    <div class="panel panel-default padding-md">

      <div class="panel-body ">

        <h2><i class="fa fa-cog" aria-hidden="true"></i> {{ lang('Edit Profile') }}</h2>
        <hr>

        @include('layouts.partials.errors')

        <form class="form-horizontal" method="POST" action="{{ route('users.update', $user->id) }}" accept-charset="UTF-8" enctype="multipart/form-data">
            <input name="_method" type="hidden" value="PATCH">
            {!! csrf_field() !!}

            <div class="form-group">
                <label for="" class="col-sm-2 control-label">Sexo</label>
                <div class="col-sm-6">
                    <select class="form-control" name="gender">
                      <option value="unselected" {{ $user->gender == 'unselected' ? 'selected' : '' }}>Não selecionado</option>
                      <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Masculino</option>
                      <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Feminino</option>
                    </select>
                </div>

                <div class="col-sm-4 help-block"></div>
            </div>

            <div class="form-group">
                <label for="" class="col-sm-2 control-label">{{ lang('GitHub Name') }}</label>
                <div class="col-sm-6">
                    <input class="form-control" name="github_name" type="text" value="{{ $user->github_name }}">
                </div>

                <div class="col-sm-4 help-block">
                    Por favor, mantenha-se consistente com o GitHub
                </div>
            </div>

            <div class="form-group">
                <label for="" class="col-sm-2 control-label">{{ lang('Email') }}</label>
                <div class="col-sm-6">
                    <input class="form-control" name="email" type="text" value="{{ $user->email }}">
                </div>
                <div class="col-sm-4 help-block">
                    {{ lang('Email example: name@website.com') }}
                </div>
            </div>

          <div class="form-group">
              <label for="" class="col-sm-2 control-label">{{ lang('Real Name') }}</label>
              <div class="col-sm-6">
                  <input class="form-control" name="real_name" type="text" value="{{ $user->real_name }}">
              </div>
              <div class="col-sm-4 help-block">
                {{ lang('Real Name example: 李小明') }}
              </div>
          </div>

          <div class="form-group">
              <label for="" class="col-sm-2 control-label">{{lang('City')}}</label>
              <div class="col-sm-6">
                  <input class="form-control" name="city" type="text" value="{{ $user->city }}">
              </div>
              <div class="col-sm-4 help-block">
                    {{lang('City example: BeiJing')}}
              </div>
          </div>

          <div class="form-group">
              <label for="" class="col-sm-2 control-label">{{ lang('Company') }}</label>
              <div class="col-sm-6">
                  <input class="form-control" name="company" type="text" value="{{ $user->company }}">
              </div>
              <div class="col-sm-4 help-block">
                {{ lang('Company example: Alibaba') }}
              </div>
          </div>

          <div class="form-group">
              <label for="" class="col-sm-2 control-label">{{ lang('Weibo Username') }}</label>
              <div class="col-sm-6">
                  <input class="form-control" name="weibo_name" type="text" value="{{ $user->weibo_name}}">
              </div>
              <div class="col-sm-4 help-block">
                    {{ lang('Weibo Username example: PHPHub') }}
              </div>
          </div>

          <div class="form-group">
              <label for="" class="col-sm-2 control-label">Weibo página pessoal</label>
              <div class="col-sm-6">
                  <input class="form-control" name="weibo_link" type="text" value="{{ $user->weibo_link}}">
              </div>
              <div class="col-sm-4 help-block">
                  Weibo, link da página pessoal, como: http://weibo.com/laravelnews
              </div>
          </div>

          <div class="form-group">
              <label for="" class="col-sm-2 control-label">{{ lang('twitter_placeholder') }}</label>
              <div class="col-sm-6">
                  <input class="form-control" name="twitter_account" type="text" value="{{ $user->twitter_account}}">
              </div>
              <div class="col-sm-4 help-block">
                {{ lang('twitter_placeholder_hint') }}
              </div>
          </div>

          <div class="form-group">
              <label for="" class="col-sm-2 control-label">{{ lang('LinkedIn') }}</label>
              <div class="col-sm-6">
                  <input class="form-control" name="linkedin" type="text" value="{{ $user->linkedin}}">
              </div>
              <div class="col-sm-4 help-block">
                你的 <a href="https://www.linkedin.com">LinkedIn</a> Endereço de URL completo inicial, como: https://cn.linkedin.com/in/ricardorsierra
              </div>
          </div>

          <div class="form-group">
              <label for="" class="col-sm-2 control-label">{{ lang('personal_website_placebolder') }}</label>
              <div class="col-sm-6">
                  <input class="form-control" name="personal_website" type="text" value="{{ $user->personal_website }}">
              </div>
              <div class="col-sm-4 help-block">
                    {{ lang('personal_website_placebolder_hint') }}
              </div>
          </div>

            <div class="form-group">
                <label for="wechat_qrcode" class="col-sm-2 control-label">Código QR da conta WeChat</label>
                <div class="col-sm-6">
                    <input type="file" name="wechat_qrcode">
                    @if($user->wechat_qrcode)
                        <img class="payment-qrcode" src="{{ $user->wechat_qrcode }}" alt="" />
                    @endif
                </div>
                <div class="col-sm-4 help-block">
                    Sua conta pessoal do WeChat ou número de assinatura
                </div>
            </div>

            <div class="form-group">
                <label for="" class="col-sm-2 control-label">Pague o código QR</label>
                <div class="col-sm-6">
                    <input type="file" name="payment_qrcode">

                    @if($user->payment_qrcode)
                        <img class="payment-qrcode" src="{{ $user->payment_qrcode }}" alt="" />
                    @endif
                </div>
                <div class="col-sm-4 help-block">
                    Use quando o artigo é recompensado, WeChat paga o código QR
                </div>
            </div>

          <div class="form-group">
              <label for="" class="col-sm-2 control-label">{{ lang('introduction_placeholder') }}</label>
              <div class="col-sm-6">
                  <textarea class="form-control" rows="3" name="introduction" cols="50">{{ $user->introduction }}</textarea>
              </div>
              <div class="col-sm-4 help-block">
                    {{ lang('introduction_placeholder_hint') }}，Na maioria das vezes, ele aparecerá ao lado do seu avatar e nome.
              </div>
          </div>

          <div class="form-group">
              <label for="" class="col-sm-2 control-label">Assinatura</label>
              <div class="col-sm-6">
                  <textarea class="form-control" rows="3" name="signature" cols="50">{{ $user->signature }}</textarea>
              </div>
              <div class="col-sm-4 help-block">
                  Sua assinatura será colocada atrás de cada postagem que você publicar. Suporte para marcação de texto (Linguagem Markdown).
              </div>
          </div>

          <div class="form-group">
              <div class="col-sm-offset-2 col-sm-6">
                <input class="btn btn-primary" id="user-edit-submit" type="submit" value="{{ lang('Apply Changes') }}">
              </div>
            </div>
      </form>
      </div>

    </div>
  </div>


</div>




@stop
