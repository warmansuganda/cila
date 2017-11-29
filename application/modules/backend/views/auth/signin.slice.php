@extends('layouts.signin')

@section('title')
    {{ $title }}
@endsection

@section('content')
<!-- /.login-logo -->
<div class="col col-md-12">
    <h2 style="border-left: 4px solid #126a99;padding-left: 15px;color: #126a99;">Sign in</h2>

    @if(!empty($error_message))
      <p class="login-box-msg"><code>{{ $error_message }}</code></p>
    @endif

    {{ form_open('signin') }}
      <div class="form-group has-feedback">
        <input name="username" type="text" class="form-control" placeholder="Username">
        <span class="fa fa-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input name="password" type="password" class="form-control" placeholder="Password">
        <span class="fa fa-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input name="remember" type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    {{ form_close() }}

    <div class="social-auth-links text-center">
      <br><br>
      <p style="font-size: 11px;"> Copyright &copy; 2017 <br> PT. Bandara Internasional Jawa Barat</p>
    </div>
</div>
<!-- /.login-box-body -->
@endsection

@section('js')
<script type="text/javascript">
    $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
    });
</script>
@endsection