@extends('layouts.dashboard')

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
          <h4 class="card-title">Pengaturan Company Profile</h4>
        </div>
        <form action="{{ route('company-profile.store') }}" method="post">
          @csrf
          @include('partials.flash-message-ajax')
          <div class="form-row">
            <div class="col">
              <div class="form-group">
                <label for="nama">Nama Toko</label>
                <input required type="text" class="form-control" name="nama" value="{{ $data->nama ?? ''}}">
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label for="no_telp">No. HP</label>
                <input required type="text" class="form-control" name="no_telp" value='{{ $data->no_telp ?? ''}}'>
              </div>
            </div>
          </div>

          <div class="form-row">

            <div class="col">
              <div class="form-group">
                <label for="email">Email</label>
                <input required type="text" class="form-control" name="email" value="{{ $data->email ?? ''}}">
              </div>
            </div>

            <div class="col">
              <div class="form-group">
                <label for="whatsapp">WhatsApp</label>
                <input required type="text" class="form-control" name="whatsapp" value="{{ $data->whatsapp ?? ''}}">
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col">
              <div class="form-group">
                <label for="desc">Deskripsi Toko</label>
                <textarea required class="form-control" name="desc" rows="3">{{ $data->desc ?? ''}}</textarea>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea required class="form-control" id="alamat" name="alamat" rows="3">{{ $data->alamat ?? ''}}</textarea>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary btn-block">Ubah Profil</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script>
  let selectedProvince = 0;
  $(document).ready(() => {
    selectedProvince = $("#province-from-controller").val()
    selectClient = $('#provinsi').select2({
      minimumInputLength: 1,
      allowClear: true,
      placeholder: 'Pilih Provinsi',
      language: {
        "noResults": function() {
          return "Data Tidak ditemukan";
        },
        "searching": function() {
          return "Mencari…"
        },
        "inputTooShort": function(e) {
          return "Silahkan input " + (e.minimum - e.input.length) + " huruf atau lebih"
        },
        "errorLoading": function() {
          return "Hasil tidak dapat ditampilkan"
        },
      },
    });
  });

</script>
@endsection