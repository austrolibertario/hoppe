@extends('layouts.default')

@section('title')
{{ lang('Email Verification Require') }}_@parent
@stop

@section('content')
  <div class="row">
    <div class="col-md-4 col-md-offset-4 floating-box">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">{{ lang('Email Verification') }}</h3>
        </div>
        <div class="panel-body">
            <form method="POST" id="email-verification-required-form" action="{{route('users.send-verification-mail')}}" accept-charset="UTF-8">
            {!! csrf_field() !!}
            <fieldset>
              <div class="alert alert-warning">
                  A caixa de correio não está ativada, por favor, vá para {{ \Auth::user()->email }} Verifique o e-mail de ativação para ativar os recursos da comunidade, como postagens e respostas.
                  <br /><br />
                  Não recebeu o email? Por favor, clique no botão abaixo para reenviar o email de verificação.
              </div>
              <a class="btn btn-lg btn-primary btn-block" id="email-verification-required-submit" href="javascript:$('#email-verification-required-form').submit();"><i class="fa fa-paper-plane" aria-hidden="true"></i> {{lang('Resend Verification Mail')}}</a>
            </fieldset>
            </form>
        </div>
      </div>
    </div>
  </div>

@stop
