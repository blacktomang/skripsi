@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')
<section>
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp" class="img-fluid"
          alt="Sample image">
      </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <form method="POST" action="{{route('login')}}">
          @csrf
          <div class="d-flex flex-column justify-content-center justify-content-lg-start">
            <h4>Selamat Datang Kembali</h4>
            <h6 class="fw-light mt-2 mb-4">Silahkan masuk terlebih dahulu</h6>

            @if (request()->session()->has('status'))
            <div class="alert alert-danger mt-4">
              {{ request()->session()->get('status') }}
            </div>
            @endif
          </div>

          <!-- Email input -->
          <div class="form-outline mb-4">
            <label class="form-label" for="form3Example3">Email </label>
            <input type="email" id="form3Example3" class="form-control @error('email') is-invalid @enderror"
              placeholder="Email" name="email" required />
            @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>

          <!-- Password input -->
          <div class="form-outline mb-3">
            <label class="form-label" for="form3Example4">Password</label>
            <input type="password" id="form3Example4" class="form-control @error('email') is-invalid @enderror"
              placeholder="Password" name="password" required />
            @error('password')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>

          <div class="d-flex justify-content-between align-items-center">
            <div>
              <p class="small fw-bold mb-0">Don't have an account? <a href="{{route('register')}}"
                  class="link-danger">Register</a></p>
            </div>
            <div>
              <a href="#" class="text-body">Forgot password?</a>
            </div>
          </div>
          <div class="text-center text-lg-start mt-4 pt-2">
            <button type="submit"
              class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Login</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection