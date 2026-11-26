@extends('layouts.app')

@section('title', 'Login')

@section('content')
  <div class="auth-wrap">
    <section class="card auth-card">
      <h2>Login</h2>
      <p class="muted">Masuk untuk mengelola artikel dan mengakses dashboard.</p>

      @if ($errors->any())
        <div class="error">
          <ul style="margin:0; padding-left:1.1rem;">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ url('/login') }}" novalidate>
        @csrf

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required autocomplete="current-password">

        <label class="check-row" for="remember">
          <input type="checkbox" id="remember" name="remember"> Remember me
        </label>

        <div class="form-actions">
          <button type="submit" class="btn btn-primary" style="width:100%;">Masuk</button>
        </div>
      </form>

      <p class="auth-footer">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
    </section>
  </div>
@endsection
