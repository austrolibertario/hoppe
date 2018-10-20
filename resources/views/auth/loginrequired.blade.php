@extends('layouts.default')

@section('title')
{{ lang('User Login Require') }}_@parent
@stop

@section('content')
  <div class="row">
    <div class="col-md-4 col-md-offset-4 floating-box">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">{{ lang('Login') }}</h3>
        </div>
        <div class="panel-body">

            @include('auth._login_form', ['login_required' => true])

        </div>
      </div>
    </div>
  </div>

@stop
