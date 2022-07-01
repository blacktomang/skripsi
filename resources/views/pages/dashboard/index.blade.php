@extends('layouts.dashboard')
@section('content')
<style>
  .link-wrapper {
    text-decoration: none;
    color: black;

  }

  .link-wrapper:hover {
    text-decoration: none;
    color: white;
  }

  .costume-card {
    color: black !important;
    opacity: 0.8;
    transition: 0.3s;
  }

  .costume-card:hover {
    opacity: 1;
    color: white !important;
    background-color: #0b6351 !important;
  }

  .card-title-costume {
    /* color: #010101; */
    margin-bottom: 1.2rem;
    text-transform: capitalize;
    font-size: 1.125rem;
    font-weight: 600;
  }
</style>

<h3>Dashboard</h3>
<div class="row mt-4">
  <div class="col-lg-3 grid-margin stretch-card">
    <div class="card bg-secondary costume-card">
      <a href="?status_order=belum_dibayar" class="link-wrapper">
        <div class="card-body">
          <h4 class="card-title-costume">Belum Bayar</h4>
          <h6 id='DASH_BELUM_DIBAYAR' class=""></h6>
        </div>
      </a>
    </div>
  </div>
  <div class="col-lg-3 grid-margin stretch-card">
    <div class="card bg-warning costume-card">
      <a href="?status_order=dikemas" class="link-wrapper">
        <div class="card-body">
          <h4 class="card-title-costume ">Dikemas</h4>
          <h6 id='DASH_DIKEMAS' class=""></h6>
        </div>

      </a>
    </div>
  </div>
  <div class="col-lg-3 grid-margin stretch-card">
    <div class="card bg-info costume-card">
      <a href="?status_order=dikirim" class="link-wrapper">
        <div class="card-body">
          <h4 class="card-title-costume">Dikirim</h4>
          <h6 id='DASH_DIKIRIM' class=""></h6>
        </div>

      </a>
    </div>
  </div>
  <div class="col-lg-3 grid-margin stretch-card">
    <div class="card bg-success costume-card">
      <a href="?status_order=selesai" class="link-wrapper">
        <div class="card-body">
          <h4 class="card-title-costume">Selesai</h4>
          <h6 id='DASH_SELESAI' class=""></h6>
        </div>
      </a>
    </div>
  </div>
</div>
@endsection

@section('js')
<script>
  $(document).ready(function() {
    // DASHBOARD 
    getOrderStatCount('BELUM_DIBAYAR', 'DASH_BELUM_DIBAYAR');
    getOrderStatCount('DIKEMAS', 'DASH_DIKEMAS');
    getOrderStatCount('DIKIRIM', 'DASH_DIKIRIM');
    getOrderStatCount('SELESAI', 'DASH_SELESAI');
  });
</script>
@endsection