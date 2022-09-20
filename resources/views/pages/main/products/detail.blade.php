@extends('layouts.main')
@section('title', $res['name'])
@section('content')
<section class="item-details section" style="padding:120px 0">
  <div class="container">
    <div class="top-area">
      <div class="row">
        <div class="col-lg-6 col-md-12 col-12">
          <div class="product-images">
            <main id="gallery">
              <div class="main-img">
                @if (count($res['photos'])>0) <img id="displayVariant"
                  src="{{ asset('@getPath(products)'.$res['photos'][0]['value']) }}" id="current" alt="#"
                  style="max-height: 400px;">
                @else
                <img id="displayVariant" src="{{ asset('panel/images/product/default-product.svg') }}" id="current"
                  alt="#" style="max-height: 400px;">
                @endif
              </div>
              <form action="">
                <input type="hidden" name="selected_variant" value="">
                <input type="hidden" name="selected_size" value="">
              </form>
              <div class="d-flex images">
                @if (count($res['photos'])>0)
                @foreach ($res['photos'] as $item)
                <div class="text-center img-variant-div" id="box{{$item['id']}}" onmouseover="setImage('{{ asset('@getPath(products)'.$res['photos'][0]['value']) }}', 'image{{$item['id']}}', 'box{{$item['id']}}', `$res['photos'][0]['value']`)">
                  <img id='image{{$item['id']}}' src="{{ asset('@getPath(products)'.$res['photos'][0]['value']) }}"
                    class="img img-variant" alt="#">
                </div>
                @endforeach
                @else
                <img src="{{asset('panel/images/product/default-product.svg')}}" class="img" alt="#">
                <img src="{{asset('panel/images/product/default-product.svg')}}" class="img" alt="#">
                <img src="{{asset('panel/images/product/default-product.svg')}}" class="img" alt="#">
                <img src="{{asset('panel/images/product/default-product.svg')}}" class="img" alt="#">
                <img src="{{asset('panel/images/product/default-product.svg')}}" class="img" alt="#">
                @endif

              </div>
            </main>
          </div>
        </div>
        <div class="col-lg-6 col-md-12 col-12">
          <div class="product-info">
            <h3 class="title">{{ $res['name'] }}</h3>
            <p class="category">
              <i class="lni lni-tag"></i>
              {{-- <a href="javascript:void(0)">{{ $category->nama }}</a> --}}
            </p>
            <h4 class="price">Rp {{number_format($res['price'])}} </h4>
            {{-- <span class="old-price" style="text-decoration: line-through;">Rp @convert($res->harga) </span> --}}
            <div class="row cta-buy">
              <div class="col-lg-12 mb-4">
                <div class="row">
                  <div class="col-lg-4 col-md-6 col-12">
                    <div class="input-group spinner-num">
                      <button class="btn btn-minus">-</button>
                      <input id="stock-id" type="hidden" class="form-control" value="0" min="0">
                      <input id="item-amount" type="number" class="form-control spinner-input" value="1" min="0">
                      <input id="item-stock" type="hidden" class="form-control" value="1" min="0">
                      <button class="btn btn-plus">+</button>
                    </div>
                    {{-- <span>Sisa Stock : <b id="textStock">{{$res->stock}}</b></span> --}}
                  </div>
                </div>
              </div>
              <div class="col-lg-6 mb-3">
                <button class="btn btn-cart" onclick="addToCart('{{$res['slug']}}')"><i class="lni lni-cart"></i>Masukkan
                  Keranjang</button>
              </div>
              <div class="col-lg-6">
                <button class="btn btn-buy" onclick="buyNow('{{ $res['slug'] }}')">Beli Sekarang</button>
              </div>
              <div class="col-lg-12">
                <h3>Deskripsi</h3>
                <p>
                  {{ $res['description'] }}
                </p>

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
  $(".btn-plus").click(function() {
    // if (!$("input[name='selected_variant']").val() || !$("input[name='selected_size']").val()) {
    //   showErrorMessage('Silahkan pilih ukuran dan variant terlebih dahulu.');
    //   return;
    // }
    amount = parseInt($(".spinner-input").val());
    // if (parseInt($("#item-stock").val()) > parseInt($("#item-amount").val())) 
    amount += 1;
    $(".spinner-input").val(amount);
  });

  $(".btn-minus").click(function() {
    // if (!$("input[name='selected_variant']").val() || !$("input[name='selected_size']").val()) {

    //   showErrorMessage('Silahkan pilih ukuran dan variant terlebih dahulu.');;
    //   return;
    // }
    amount = parseInt($(".spinner-input").val());
    if (amount > 1) {
      amount -= 1;
    }
    $(".spinner-input").val(amount);
  });

  // Set up csrf token
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  })

  let addToCart = async (slug) => {
      var itemAmount = $("#item-amount").val()
      await $.ajax({
        type: "POST",
        url: "{{url('cart')}}",
        data: {
          amount: itemAmount,
          slug: slug
        },
        success: function(data) {
          getCartCount();
          showSuccessMessage("Success add item to cart.")
        },
        error:function(err){
          if(err.status === 401) {
            swal({
                  icon: 'error',
                  title: 'Gagal',
                  text: 'Silahkan login terlebih dahulu!',
                })
                .then((isConfirm)=> {
                  if(isConfirm) window.location.href = "/login"
                })
          }else if(400){
            let message = err.responseJSON.message
            swal({
              icon: 'warning',
              title: message.head,
              text: message.body,
              buttons: true,
              dangerMode: true,
            })
            .then((isConfirm)=>{
              if(isConfirm) window.location.href = "https://wa.me/{{$company_profile->whatsapp??''}}";
            })
          }else{
            swal({
                  icon: 'error',
                  title: 'Gagal',
                  text: 'Mohon maaf, ada kesalahan di server kami.'
                })
          }
        }
      })
    return 1;
  }

  let buyNow = async (slug) => {
    await addToCart(slug).then((d) => {
      if (d === 1) {
        
      }
    })
  };

  /**
   * set image on variant click
   * @param {string} imageURL
   * @param {string} imageSelector
   * @param {number} variant_id
   * @param {string} boxSelector
   * @param {string} defaultImage
   */
  const setImage = (imageURL, imageSelector, boxSelector, defaultImage) => {
    $(".img-variant-div").each((i, e) => {
      e.classList.remove('border');
      e.classList.remove('border-primary');
    });
    if ($("#displayVariant").attr('src') === imageURL && $(boxSelector).hasClass('border border-primary')) {
      $(`#${boxSelector}`).removeClass('border border-primary');
      $("#displayVariant").attr('src', defaultImage);
    } else {
      $("#displayVariant").attr('src', imageURL);
      $(`#${boxSelector}`).addClass('border border-primary');
    }
  };

  $(window).ready(() => {
    $("input[name='selected_variant']").val('').trigger('change');
    // $("#item-stock").val('').trigger('change');
    $("input[name='stock_id']").val('').trigger('change');
    $("input[name='selected_size']").val('').trigger('change');
  })

</script>
@endsection