<form method="POST" action="{{ route('auth.login') }}" accept-charset="UTF-8">
    {{ csrf_field() }}

    <input type="hidden" name="remember" value="yes">

    @if (isset($login_required))
        <div class="alert alert-warning">
            Você precisa fazer login para operar.
        </div>
    @endif

    <div class="form-group {{{ $errors->has('email') ? 'has-error' : '' }}}">
        <label class="control-label" for="email">{{ lang('Email') }}</label>
        <input class="form-control" name="email" type="text" value="{{ old('email') }}" placeholder="Por favor preencha o email">
        {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
    </div>

    <div class="form-group {{{ $errors->has('password') ? 'has-error' : '' }}}">
        <label class="control-label" for="password">Senha</label>
        <input class="form-control" name="password" type="password" value="{{ old('password') }}" placeholder="Por favor, preencha a senha">
        {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
    </div>

    <button type="submit" class="btn btn-lg btn-success btn-block">
        <i class="fa fa-btn fa-sign-in"></i> Login
    </button>

    <hr>

    <fieldset class="form-group">
      <div class="alert alert-info">
          Use os seguintes métodos para registrar ou fazer login （<a class="forget-password">Esqueceu sua senha?</a>）
      </div>
      <a class="btn btn-lg btn-default btn-block" id="login-required-submit" href="{{ URL::route('auth.oauth', ['driver' => 'github']) }}"><i class="fa fa-github-alt"></i> {{lang('Login with GitHub')}}</a>
      <a class="btn btn-lg btn-default btn-block" href="{{ URL::route('auth.oauth', ['driver' => 'google']) }}"><i class="fa fa-google"></i> {{lang('Login with Google')}}</a>
      <a class="btn btn-lg btn-default btn-block" href="{{ URL::route('auth.oauth', ['driver' => 'facebook']) }}"><i class="fa fa-facebook"></i> {{lang('Login with Facebook')}}</a>
      <a class="btn btn-lg btn-default btn-block" href="{{ URL::route('auth.oauth', ['driver' => 'twitter']) }}"><i class="fa fa-twitter"></i> {{lang('Login with Twitter')}}</a>
      <a class="btn btn-lg btn-default btn-block" href="{{ URL::route('auth.oauth', ['driver' => 'wechat']) }}"><i class="fa fa-weixin" ></i> {{lang('Login with WeChat')}}</a>
    </fieldset>
</form>

