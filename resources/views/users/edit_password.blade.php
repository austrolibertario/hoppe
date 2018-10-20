@extends('layouts.default')

@section('title')
    Alterar senha | @parent
@stop

@section('content')

<div class="users-show">

  <div class="col-md-3 main-col">
    @include('users.partials.setting_nav')
  </div>

  <div class="col-md-9  left-col ">

    <div class="panel panel-default padding-md">

      <div class="panel-body ">

        <h2><i class="fa fa-lock" aria-hidden="true"></i> Alterar senha</h2>
        <hr>

        @include('layouts.partials.errors')

        <form class="form-horizontal" method="POST" action="{{ route('users.update_password', $user->id) }}" accept-charset="UTF-8">
            <input name="_method" type="hidden" value="PATCH">
            {!! csrf_field() !!}

            <div class="form-group">
              <label class="col-md-2 control-label">Caixa de correio:</label>
              <div class="col-md-6">
                <input name="" class="form-control" type="text" value="{{ $user->email }}" disabled>
                <input name="email" type="hidden" value="{{ $user->email }}">
              </div>
              <div class="col-sm-4 help-block">
                  Você poderá fazer o login com esta caixa de correio depois de definir a senha.
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-2 control-label">Senha:</label>
              <div class="col-md-6">
                <input type="password" class="form-control" name="password" required>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-2 control-label">Confirme a senha：</label>
              <div class="col-md-6">
                <input type="password" class="form-control" name="password_confirmation" required>
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
