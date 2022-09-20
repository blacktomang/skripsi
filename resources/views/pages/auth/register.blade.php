@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="col-lg-6 mx-auto">
  <div class="auth-form-light text-left py-5 px-4 px-sm-5">
    <div class="brand-logo text-center">
      <img src="{{asset('images/logo.png')}}" alt="logo" width="100px">
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
        <div class="form-group col-md-12">
          <label for="name">Nama</label>
          <input id="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror"
            name="name" autocomplete="off" autofocus value="{{old('name')}}">
        </div>
        <div class="form-group col-md-6">
          <label for="email">Email</label>
          <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
            autocomplete="off" name="email" value="{{old('email')}}">
          @error('email')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
        <div class="form-group col-md-6">
            <label for="phone_number">Phone</label>
            <input id="phone_number" type="phone_number" class="form-control form-control-lg @error('phone_number') is-invalid @enderror"
              autocomplete="off" name="phone_number" value="{{old('phone_number')}}" placeholder="0812345677">
            @error('phone_number')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
        <div class="form-group col-md-6">
          <label for="password" class="d-block">Password</label>
          <input id="password" type="password"
            class="form-control form-control-lg @error('password') is-invalid @enderror pwstrength"
            data-indicator="pwindicator" name="password">
          @error('password')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>

        <div class="form-group col-md-6">
          <label for="password2" class="d-block">Konfirmasi Password</label>
          <input id="password2" type="password"
            class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror" name="password_confirmation">
          @error('password_confirmation')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
        <div id="progress-container" class="">
          <div class="card">
            <div class="text-danger p-2 bg-light" id="lengthP">Password harus lebih dari 5 <span id="lengthPicon" class="mx-2"><i
                  class="lni lni-thumbs-up" ></i></span></div>
            <div class="text-danger p-2 bg-light" id="numberP">Password setidaknya terdapat 1 angka <span
                class="mx-2" id="numberPicon"><i class="lni lni-thumbs-up"></i></span></div>
            <div class="text-danger p-2 bg-light" id="specialP">Password setidaknya terdapat karakter spesial seperti (*!@&$) dll.
              <span class="mx-2" id="specialPicon"><i class="lni lni-thumbs-up"></i></span>
            </div>
          </div>
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
@section('js')
<script>
const special_char = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;

const isContainSpecialChar = (input) => special_char.test(input);

const isContainNumber = (input) => /[0-9]/.test(input);

/**
 * Update password indicator
 * @param {String} field - make sure has the same name as id
 * @param {Boolean} condition
 */
const updateIndicator = (field, condition) => {
  $(`#${field}P`).removeClass('text-danger');
  $(`#${field}P`).removeClass('text-success');
  condition?$("#password").removeClass('border-danger'):$("#password").addClass('border-danger');
 
  $(`#${field}P`).addClass(condition?'text-success':'text-danger');
  $(`#${field}Picon`).html(`<i class='lni lni-${condition?'thumbs-up':'thumbs-down'}'></i>`);
};

$("#password").on("input", function () {
  let value = $(this).val();
  updateIndicator('length', value.length > 5);
  updateIndicator('number', isContainNumber(value));
  updateIndicator('special', isContainSpecialChar(value));
});

$("input[name='password_confirmation']").on("input", function () {

});
</script>
@endsection