@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="col-lg-6 mx-auto">
  <div class="auth-form-light text-left py-5 px-4 px-sm-5">
    <div class="brand-logo text-center">
      <img src="{{asset('images/logo.svg')}}" alt="logo">
    </div>
    <h4>Selamat Bergabung</h4>
    <h6 class="fw-light">Silahkan lengkapi pendaftaran berikut</h6>
    @if (request()->session()->has('status'))
    <div class="alert alert-danger mt-3">
      {{ request()->session()->get('status') }}
    </div>
    @endif
    <form method="POST" action="{{route('register')}}" class="pt-3">
      @csrf
      <div class="row">
        <div class="form-group col-md-6">
          <label for="name">Nama</label>
          <input id="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" autocomplete="off" autofocus>
        </div>
        <div class="form-group col-md-6">
          <label for="hp">No. HP</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="input-phone">+62</span>
            </div>
            <input id="phone" type="name" class="form-control form-control-lg @error('phone') is-invalid @enderror" autocomplete="off" name="phone" aria-describedby="input-phone">
          </div>
        </div>
        <div class="form-group col-md-6">
          <label for="email">Email</label>
          <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" autocomplete="off" name="email">
        </div>
        <div class="form-group col-md-6">
          <label for="password" class="d-block">Password</label>
          <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror pwstrength" data-indicator="pwindicator" name="password">
          <div id="pwindicator" class="pwindicator">
            <div class="bar"></div>
            <div class="label"></div>
          </div>
        </div>
        <div class="form-group col-md-6">
          <label for="password2" class="d-block">Konfirmasi Password</label>
          <input id="password2" type="password" class="form-control form-control-lg" name="password_confirmation">
        </div>
        <div class="form-group col-md-6">
          <label for="kode_referal">Kode Referal <small class="text-secondary">(Opsional)</small></label>
          <input id="kode_referal" type="text" class="form-control form-control-lg @error('kode_referal') is-invalid @enderror" name="referral_code" value="{{ old('kode_referal') }}">
        </div>
      </div>
      <div class="my-2 d-flex justify-content-between align-items-center">
        <div class="form-check">
          <label class="form-check-label text-muted">
            <input type="checkbox" name="remember" class="form-check-input">
            Saya setuju dengan <a href="#">Syarat dan Kebijakan</a>
          </label>
        </div>
      </div>

      <div class="mt-3 text-center">
        <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Daftar</button>
      </div>

      <div class="text-center mt-4 fw-light">
        Sudah Punya Akun? <a href="{{ url('login') }}" class="text-primary">Masuk</a>
      </div>
    </form>
  </div>
</div>
@endsection