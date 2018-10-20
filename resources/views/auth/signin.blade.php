@extends('layouts.default')

@section('title')
  Login do usuário | @parent
@stop

@section('content')
  <div class="row">
    <div class="col-md-4 col-md-offset-4 floating-box">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Por favor faça o login</h3>
        </div>
        <div class="panel-body">

            @include('auth._login_form')

        </div>
      </div>
    </div>
  </div>

@stop
