@extends('layouts.app')

@section('content')

<div class="login-page" style="min-height:512.8px;">



<div class="login-box">
    <div class="login-logo">
    <h2><b>Jobes </b>Company</h2>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in here</p>

        <form action="{{ route('login') }}" method="post">
            @csrf
          <div class="input-group mb-3">
            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" placeholder="Email or Phone " value="{{ old('username') }}" required autocomplete="username" autofocus>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
            @error('username')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
            </span>
             @enderror
          </div>

          <div class="input-group mb-3">
             <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="password" name="password" required autocomplete="current-password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
          </div>

          <div class="row">
            <div class="col-8">
              <div class="icheck-primary pl-4">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">
                  {{ 'Remember Me' }}
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block"> {{ __('Login') }}</button>
             </div>

            <!-- /.col -->
          </div>
        </form>
        <p class="mb-1">
            @if (Route::has('password.request'))
            <a class="btn btn-link pl-1" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
        @endif
        </p>

        <p class="mb-0">
            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="text-center pl-1">{{ 'Register Here if you dont have Account' }}</a>
             @endif

          </p>

      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
</div>
@endsection
