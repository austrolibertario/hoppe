@extends('layouts.default')

@section('title')
{{{ $user->name }}} {{ lang('Reply List') }}_@parent
@stop

@section('content')


<div class="users-show row">

  <div class="col-md-3">
        @include('users.partials.basicinfo')
  </div>

  <div class="main-col col-md-9 left-col">

  <ol class="breadcrumb">
      <li><a href="{{ route('users.show', $user->id) }}">Perfil Pessoal</a></li>
      <li class="active">Minhas respostas（{{ $user->reply_count }}）</li>
  </ol>

  <div class="panel panel-default">

    <div class="panel-body">

      @if (count($replies))
	      @include('users.partials.replies')
	      <div class="pull-right add-padding-vertically">
	        {!! $replies->render() !!}
	      </div>
      @else
	       <div class="empty-block">{{ lang('Dont have any comment yet') }}~~</div>
      @endif

    </div>

  </div>
</div>
</div>

@stop
