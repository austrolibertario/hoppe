<?php /*<div class="box text-center">
  <p style="margin-bottom: 10px;margin-top: 10px;"><a href="https://h3sotospeak.com/topics/1531">Cliente</a> Login QR code</p>
  <img style="height: 180px; width=180px;" src="data:image/png;base64,{{ base64_encode($user->present()->loginQR(180)) }}">
  <br/><br/>
<form method="POST" action="{{ route('users.regenerate_login_token') }}" accept-charset="UTF-8">
    {!! csrf_field() !!}
    <div style="margin-bottom: 8px;color: #999;font-size: 0.9em;">Login falhou, por favor clique</div>
    <input class="btn btn-sm btn-default" style="margin-bottom: 13px;" id="topic-create-submit" type="submit" value="Regenerar">
</form>

</div>
*/ ?>