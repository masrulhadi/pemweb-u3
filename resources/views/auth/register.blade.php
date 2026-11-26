@extends('layouts.app')

@section('title', 'Register')

@section('content')
  <div class="auth-wrap">
    <section class="card auth-card">
      <h2>Register</h2>
      <p class="muted">Buat akun baru untuk mulai menulis dan mengelola artikel.</p>

      @if ($errors->any())
        <div class="error">
          <ul style="margin:0; padding-left:1.1rem;">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ url('/register') }}" novalidate>
        @csrf

        <label for="name">Nama</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email">

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required autocomplete="new-password">

        <label for="password_confirmation">Ulangi Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">

        <div class="form-actions">
          <button type="submit" class="btn btn-primary" style="width:100%;">Daftar</button>
        </div>
      </form>

      <p class="auth-footer">Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
    </section>
  </div>
@endsection
