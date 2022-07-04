@extends('layouts.main')

@section('css')
<style>
  .navbar-collapse.sub-menu-bar {
    display: none;
  }

  .section {
    margin-top: 75px;
  }
</style>
@endsection
@section('content')
<section class="section bg-light">
  <div class="container">
    <div class="row">
      <div class="col-lg-6">
        <div class="card p-3 mb-4">
          <div class="card-body">
            <form 
            {{-- action="{{route('edit-profile',$data->id)}}" method="POST"> --}}
              >@csrf
              @method('put')
              <div class="form-group">
                <div class="text-center">
                  <img src="{{asset('images/auth/avatar.svg')}}" class="img-lg rounded" alt="profile image"><br>
                  {{-- <input type="file" hidden> --}}
                  {{-- <label for="photo" class="mt-4">Foto Profil</label> --}}
                </div>
              </div>
              <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" class="form-control" name="name" value="{{$data->name}}">
              </div>
              <div class="form-group">
                <label for="phone">No. HP</label>
                <input type="text" class="form-control" name="phone" value="{{$data->phone_number}}">
              </div>
              <div class="form-group">
                <label for="phone">Email</label>
                <input type="text" class="form-control" name="phone" value="{{$data->email}}">
              </div>
              <button type="submit" class="btn btn-primary btn-block mt-4">Ubah Profil</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card p-3">
          <div class="card-body">
            <div class="card-title">
              <h6>Ubah Password</h6>
            </div>
            <form 
            {{-- action="{{route('profile-password',$data->id)}}" method="POST"> --}}
              >@csrf
              @method('put')
              <div class="form-group">
                <label for="name">Password Lama</label>
                <input type="password" class="form-control" name="old_password">
              </div>
              <div class="form-group">
                <label for="name">Password Baru</label>
                <input type="password" class="form-control" name="password">
              </div>
              <div class="form-group">
                <label for="name">Konfirmasi Password Baru</label>
                <input type="password" class="form-control" name="npassword-confirmation">
              </div>
              <button type="submit" class="btn btn-primary btn-block">Ubah Password</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('modal')
{{-- @include('main.modal.multipleAddress') --}}
{{-- @include('main.modal.newAddress') --}}
@include('partials.flash-message-ajax')

@endsection


@section('js')

{{-- @include('js.alamat-function') --}}

<script>
  $(document).ready(function() {

    refreshAlamatDataOnPage()

  })
</script>

@endsection