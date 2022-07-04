@extends('layouts.main')
@section('css')
<style>
  .rating {
    margin-top: 24px;
    border: none;
    float: left;
  }

  .rating>label {
    color: #b8b8b8;
    float: right;
  }

  .rating>label:before {
    margin: 5px;
    font-size: 32px;
    display: inline-block;
    font-family: 'LineIcons';
    content: "\eba4";
    display: inline-block;
  }

  .rating>input {
    display: none;
  }

  .rating>input:checked~label,
  .rating:not(:checked)>label:hover,
  .rating:not(:checked)>label:hover~label {
    color: #f79426;
  }

  .rating>input:checked+label:hover,
  .rating>input:checked~label:hover,
  .rating>label:hover~input:checked~label,
  .rating>input:checked~label:hover~label {
    color: #F4A42B;
  }
</style>
@endsection
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
                  src="{{ asset('uploads/images/' . ($res['photos'][0]['value'])) }}" id="current" alt="#"
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
                <div class="text-center img-variant-div" id="box{{$item['id']}}" onclick="setImage('{{asset('uploads/images/' . $item['value'])}}', 'image{{$item['id']}}', 'box{{$item['id']}}', `$res['photos'][0]['value']`)">
                  <img id='image{{$item['id']}}' src="{{asset('uploads/images/' . $item['value'])}}"
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

    {{-- Hanya menampilkan form ulasan jika user sudah membeli product --}}

    {{-- @if ($showUlasan)  --}}
    {{-- uncomment ketika crud sudah selesai --}}

    {{-- @if (true) comment ketika crud ulasan sudah selesai --}}
    {{-- <div class="item-details-blocks" id="ulasan-container">
      <div class="row">
        <div class="col-lg-12">
          <div class="single-block comments">
            <h3>Tulis Ulasan</h3>
            <div class="row">
              <div class="col-2 text-center">
                <img class="mt-3" src="{{asset('panel/images/auth/avatar.svg')}}" alt="#">
              </div>
              <div class="col-6">
                <form action="{{route('tambah-ulasan',$res->id)}}" method="POST">
                  @csrf
                  <div class="d-flex">
                    <div class="rating">
                      <input type="radio" id="star5" name="rate" value="5" />
                      <label class="star" for="star5" title="Awesome" aria-hidden="true"></label>
                      <input type="radio" id="star4" name="rate" value="4" />
                      <label class="star" for="star4" title="Great" aria-hidden="true"></label>
                      <input type="radio" id="star3" name="rate" value="3" />
                      <label class="star" for="star3" title="Very good" aria-hidden="true"></label>
                      <input type="radio" id="star2" name="rate" value="2" />
                      <label class="star" for="star2" title="Good" aria-hidden="true"></label>
                      <input type="radio" id="star1" name="rate" value="1" />
                      <label class="star" for="star1" title="Bad" aria-hidden="true"></label>
                    </div>
                  </div>
                  <div class="form-group">
                    <textarea name="ulasan" class="form-control" placeholder="Tulis Ulasanmu"
                      id="inputReview"></textarea>
                  </div>
                  <button class="btn btn-primary" type="submit">Beri Review</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif --}}

    {{-- <div class="item-details-blocks">
      <div class="row">
        <div class="col-lg-12">
          <div class="single-block comments">
            <h3>Ulasan</h3>
            <div class="rating-group rating-group-lg">
              @php
              $bintang = floor($rata_rata);
              @endphp

              @for ($i = 0; $i < 5; $i++) @if ($i < $bintang) <i class="lni lni-star-filled active"></i>
                @else
                <i class="lni lni-star-filled"></i>
                @endif
                @endfor
                <span>{{substr($rata_rata,0,3)}} ({{$total}} Review )</span>
            </div>

            @foreach ($ulasan as $item)


            <div class="single-comment">
              <img src="{{asset('panel/images/auth/avatar.svg')}}">
              <div class="content">
                <h4>{{$item->user->name}}</h4>
                <span>{{date_format($item->created_at, "d M Y")}}</span>
                <div class="rating-group">
                  @for ($i = 1; $i < 6 ; $i++) @if ($i <=$item->rate)
                    <i class="lni lni-star-filled active"></i>
                    @else
                    <i class="lni lni-star-filled "></i>
                    @endif
                    @endfor
                </div>
                <p>
                  {{$item->ulasan}}
                </p>
              </div>
            </div>
            @endforeach


          </div>
        </div>
      </div>
    </div> --}}
  </div>
</section>
@endsection

@include('partials.flash-message-ajax')

@section('js')
<script>
  $(".btn-plus").click(function() {
    if (!$("input[name='selected_variant']").val() || !$("input[name='selected_size']").val()) {
      showErrorMessage('Silahkan pilih ukuran dan variant terlebih dahulu.');
      return;
    }
    amount = parseInt($(".spinner-input").val());
    if (parseInt($("#item-stock").val()) > parseInt($("#item-amount").val())) amount += 1;
    $(".spinner-input").val(amount);
  });

  $(".btn-minus").click(function() {
    if (!$("input[name='selected_variant']").val() || !$("input[name='selected_size']").val()) {

      showErrorMessage('Silahkan pilih ukuran dan variant terlebih dahulu.');;
      return;
    }
    amount = parseInt($(".spinner-input").val());
    if (amount > 1 && (parseInt($("#item-stock").val()) >= parseInt($("#item-amount").val()))) {
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

  let addToCart = async (product_id) => {
    if ($("#stock-id").val() == 0 || $("#stock-id").val() == '') {
      showErrorMessage('Silahkan pilih ukuran dan variant terlebih dahulu.');
      return 0;
    }
    var itemAmount = parseInt($("#item-amount").val());
    var itemStock = parseInt($("#item-stock").val());
    console.info({
      stock: itemStock,
      amount: itemAmount
    });
    if (!(itemStock >= itemAmount)) {
      $swal.fire({
          title: 'Penyesuaian?',
          text: `Order akan disesuaikan dengan stok yang tersedia!`,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Tidak',
          confirmButtonText: 'Ya!'
        })
        .then(async (result) => {
          if (result.isConfirmed) {
            $("#item-amount").val(itemStock);
            await $.ajax({
              type: "POST",
              url: "{{url('cart')}}/" + product_id,
              data: {
                amount: itemAmount,
                stock_id: $("#stock-id").val()
              },
              success: function(data) {
                console.log("Success add item to cart.")
                showSuccessMessage("Success add item to cart.")

              }
            })
          }
        })
    } else {
      var itemAmount = $("#item-amount").val()
      await $.ajax({
        type: "POST",
        url: "{{url('cart')}}/" + product_id,
        data: {
          amount: itemAmount,
          stock_id: $("#stock-id").val()
        },
        success: function(data) {
          getCartCount();

          showSuccessMessage("Success add item to cart.")
        }
      })
    }
    return 1;
  }

  let buyNow = async (product_id) => {
    await addToCart(product_id).then((d) => {
      console.log(d);
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
    console.info(boxSelector);
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

  /**
   * set image on variant click
   * @param {number} size_id
   * @param {string} boxSelector
   */
  const setSize = (size_id, boxSelector) => {
    $(".boxSize").each((i, e) => {
      console.info(e);
      e.classList.remove('border');
      e.classList.remove('border-primary');
    });
    if ($(boxSelector).hasClass('border border-primary')) {
      $(boxSelector).removeClass('border border-primary');
      $("input[name='selected_size']").val('').trigger('change');
    } else {
      $(boxSelector).addClass('border border-primary');
      $("input[name='selected_size']").val(size_id).trigger('change');
    }
  };

  $(window).ready(() => {
    $("input[name='selected_variant']").val('').trigger('change');
    // $("#item-stock").val('').trigger('change');
    $("input[name='stock_id']").val('').trigger('change');
    $("input[name='selected_size']").val('').trigger('change');
  })
  $("input[name='selected_size']").on("change", function(e) {
    let variant = $("input[name='selected_variant']").val();
    let size = $("input[name='selected_size']").val();
    if (variant || size) $.ajax({
      type: "GET",
      dataType: 'json',
      // data: "amount=" + itemAmount,
      success: function(data) {
        // $("#item-amount").val(data);
        $("#item-stock").val(data[0]);
        $("#stock-id").val(data[1]);
        $('#textStock').html(data[0]);
      },
      error: function() {
        // $("#item-amount").val(0);
        $("#item-stock").val(0);
        $('#textStock').html(0);
        $("#stock-id").val(0);
      }
    });
  });
  $("input[name='selected_variant']").on("change", function(e) {
    let variant = $("input[name='selected_variant']").val();
    let size = $("input[name='selected_size']").val();
    if (variant || size) $.ajax({
      type: "GET",
      dataType: 'json',
      // data: "amount=" + itemAmount,
      success: function(data) {
        // $("#item-amount").val(data);
        $("#item-stock").val(data[0]);
        $("#stock-id").val(data[1]);
        $('#textStock').html(data[0]);
      },
      error: function() {
        // $("#item-amount").val(0);
        $("#item-stock").val(0);
        $('#textStock').html(0);
        $("#stock-id").val(0);
      }
    });
  });
</script>
@endsection