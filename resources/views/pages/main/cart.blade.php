@extends('layouts.main')
@section('title', 'Keranjang')
@section('content')
<div class="breadcrumbs">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="breadcrumbs-content">
                    <h1 class="page-title">Keranjang Kamu</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="section bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="cart-list-head">
                    <div class="cart-list-title overflow-auto">                        
                        <div class="row">
                            <div class="col-lg-2 col-md-1 col-12">
                            </div>
                            <div class="col-lg-3 col-md-3 col-12">
                                <p>Product Name</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p>Quantity</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p>Subtotal</p>
                            </div>

                            <div class="col-lg-1 col-md-2 col-12">
                                <p>Remove </p>
                            </div>
                        </div>
                    </div>
                    @include('partials.flash-message-ajax')
                    @foreach ($carts as $item)
                    <div class="cart-single-list" id="div{{ $item->id }}">
                        <div class="row align-items-center">
                            <div class="col-lg-2 col-md-1 col-12">
                                <div class="form-check">
                                    @if ($item->checked == '1')
                                    <input class="form-check-input" type="checkbox" id="checkbox{{$item->id}}"
                                        onclick="changeCheckStat('{{$item->id}}')" checked>
                                    @else
                                    <input class="form-check-input" type="checkbox" id="checkbox{{$item->id}}"
                                        onclick="changeCheckStat('{{$item->id}}')">
                                    @endif
                                    @if (!$item->product->photos->isEmpty())
                                    <a href="{{url('product/detail/'.$item->product->slug)}}">
                                      <img src="{{ asset('uploads/images/' . ($item->product->photos[0]->value)) }}" alt="#">
                                    </a>
                                    @else
                                    <img src="{{ asset('images/product/default-product.svg') }}" alt="#">
                                    @endif
                                    {{-- <a href="{{url('product/detail')}}"><img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->slug }}"></a></a>  --}}
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-12">
                                <h5 class="product-name"><a href="{{url('product/detail')}}">{{$item->product->name}}</a>
                                </h5>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <div class="input-group spinner-num">
                                    <button class="btn btn-minus"
                                        onclick="decrement('{{ $item->id }}','{{$item->product->price }}', 10000)">-</button>
                                    <input id="{{$item->id}}" type="number" class="form-control spinner-input"
                                        value="{{ $item->amount }}" min="0">

                                    <button class="btn btn-plus"
                                        onclick="increment('{{ $item->id}}' , '{{$item->product->price}}', 10000)">+</button>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p id="subtotal{{$item->id}}" class="subtotal">Rp {{number_format($item->product->price * $item->amount)}}
                                </p>
                            </div>
                            <div class="col-lg-1 col-md-2 col-12">
                                <a class="remove-item" onclick="deleteCart('{{ $item->id }}')"><i
                                        class="lni lni-close"></i></a>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
            <div class="col-md-3">
                <div class="total-amount">
                    <div class="row">
                        <div class="col-12">
                            <div class="right">
                                <ul>
                                    <li>Total Keranjang :</li>
                                    <li id="totalKeranjang">Rp </li>
                                </ul>
                                <div class="button">
                                    <form action="{{url('/checkout')}}" method="POST">
                                        @csrf
                                        {{-- <a href="/checkout" style="width:100% !important"
                                            class="btn m-0">Checkout</a> --}}
                                            <button class="btn m-0" type="submit" style="width:100% !important">
                                                Checkout
                                            </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script>
    // Set up csrf token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        console.log("ready!");
        $('#totalKeranjang').text(formatter.format('{{$total_price}}'))
    });

    function changeCheckStat(cart_id) {
        if ($('#checkbox' + cart_id).is(':checked')) {
            // update jadi checked
            checked_stat = 1
        } else {
            // update jadi unchecked
            checked_stat = 0
        }

        $.ajax({
            type: "put",
            url: "{{url('cart')}}/" + cart_id,
            data: "checked=" + checked_stat,
            success: function(status) {
                if (status) {
                    getCartTotalPrice();
                }
            }
        });
    }

    // update amount di view
    function increment(cart_id, item_harga, stock) {

        amount = parseInt($("#" + cart_id).val());
        if (amount >= stock) {
        showErrorMessage(`Value tidak boleh melebihi stok ! value : ${amount}, stok :${stock}`);
        return;
        }
        amount += 1;
        $("#" + cart_id).val(amount);

        updateAmount(cart_id, item_harga);

    }

    function decrement(cart_id, item_harga, stock) {

        let amount = parseInt($("#" + cart_id).val());

        if (amount != 1) {
            amount -= 1;
        }
        
        $("#" + cart_id).val(amount);

        updateAmount(cart_id, item_harga);
    }



    // update amount product di server
    function updateAmount(cart_id, item_harga) {
        let amount = $("#" + cart_id).val();
        $.ajax({
            type: "patch",
            url: "{{url('cart')}}/" + cart_id,
            data: "amount=" + amount,
            success: function(data) {
                console.log("Success update product amount.")
                generateSubtotal(cart_id, item_harga);
                getCartTotalPrice();
            }
        });
    }

    // get Total Cart's Price 
    function getCartTotalPrice() {
        $.ajax({
            type: "get",
            url: "{{route('getTotalPrice')}}",
            success: function(data) {
                $('#totalKeranjang').text(formatter.format(data.message.body))

            }
        });
    }

    // Generate Subtotal
    let generateSubtotal = (cart_id, item_harga) => {
        let amount = $("#" + cart_id).val();
        var harga = parseInt(item_harga) * parseInt(amount)
        let subtotal_id = "#subtotal" + cart_id
        $(subtotal_id).text(formatter.format(harga))
    }

    // Number Formater Function
    var formatter = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',

        // These options are needed to round to whole numbers if that's what you want.
        minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
        maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
    });

    // delete cart
    let deleteCart = (cart_id) => {
        $.ajax({
            type: "DELETE",
            url: "{{url('cart')}}/" + cart_id,
            success: function(data) {
                console.log("Success delete item in cart.")
                $("#div" + cart_id).hide();
                getCartTotalPrice();
                getCartCount();
            }
        });
    };
</script>
@endsection

@section('css')
<style>
    .remove-item {
        cursor: pointer;
    }
</style>
@endsection