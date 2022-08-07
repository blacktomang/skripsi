@extends('layouts.main')
@section('content')
<section class="category-page section">
  <div class="container">
    <div class="row">
      <div class="col-lg-9">
        <div class="category-grid-list">
          <div class="row">
            <div class="col-12">
              <div class="row">
               @include('pages.main.products.pagination')
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@include('partials.flash-message-ajax')

@endsection

@section('js')

<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  })

  const redirectPage = (stock, link) => {
    if (stock > 0) {
      window.location.href = link;
    } else {
      $swal.fire({
        title: 'Stok habis!',
        text: 'Silahkan pilih item lain.',
        icon: 'error'
      });
    }
  };
</script>

@endsection