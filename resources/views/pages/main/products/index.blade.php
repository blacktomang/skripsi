@extends('layouts.main')
@section('content')
<section class="category-page section">
  <div class="container">
    <div class="row">
      {{-- <div class="col-lg-3 d-none d-lg-block d-xl-block">
        <div class="category-sidebar">

          <div class="single-widget">
            <h3>All Categories</h3>
            <ul class="list">
              @foreach ($categories as $item)
              <li>
                <a href="{{route('shop.index')}}?category={{ $item->slug }}"><i class="lni lni-dinner"></i>{{ $item->nama }}<span>{{ $item->products_count }}</span></a>
              </li>

              @endforeach
            </ul>
          </div>
        </div>
      </div> --}}
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