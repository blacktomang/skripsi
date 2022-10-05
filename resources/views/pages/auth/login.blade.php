@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')
<section>
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="{{asset('images/logo.png')}}" class="img-fluid" alt="Sample image">
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
              placeholder="Email" name="email" value="{{old('email')}}" required />
          </div>

          <!-- Password input -->
          <div class="form-outline mb-3">
            <label class="form-label" for="form3Example4">Password</label>
            <div class="input-group mb-3">
              <input type="password" name="password" id="input_password" class="form-control @error('password') is-invalid @enderror"
                placeholder="password" aria-label="password" aria-describedby="button-addon2">
              <i class="btn btn-outline-secondary lni lni-16 lni-lock" id="button-addon2" style="padding-top: 17px;"></i>
            </div>
            @error('password')
            {{$message}}
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
@section('js')
<script>
  $("#button-addon2").click(()=>{
        const typeAttr = $("#input_password").attr('type')
        console.log(typeAttr);
        if(typeAttr == 'password') {
          $("#input_password").attr('type', 'text'); $("#button-addon2").removeClass('lni-lock'); $("#button-addon2").addClass('lni-unlock');
        } else {
          $("#input_password").attr('type', 'password');$("#button-addon2").removeClass('lni-unlock'); $("#button-addon2").addClass('lni-lock');
        }
      });
</script>
@endsection