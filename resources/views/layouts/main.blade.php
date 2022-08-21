<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>{{$company_profile->nama??'Jamu'}} | @yield('title', '')</title>
  <meta name="description" content="" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/logo.svg')}}" />
  <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}" />
  <link rel="stylesheet" href="{{asset('css/LineIcons.2.0.css')}}" />
  <link rel="stylesheet" href="{{asset('css/animate.css')}}" />
  <link rel="stylesheet" href="{{asset('css/tiny-slider.css')}}" />
  <link rel="stylesheet" href="{{asset('css/glightbox.min.css')}}" />
  <link rel="stylesheet" href="{{asset('css/main.css')}}" />
  @yield('css')
</head>

<body>
  @include('partials.main.navbar')

  @yield('content')

  @include('partials.main.footer')

  <a href="#" class="scroll-top btn-hover">
    <i class="lni lni-chevron-up"></i>
  </a>

  @yield('modal')

  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="{{asset('js/bootstrap.min.js')}}"></script>
  <script src="{{asset('js/app.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="{{asset('js/wow.min.js')}}"></script>
  <script src="{{asset('js/tiny-slider.js')}}"></script>
  <script src="{{asset('js/glightbox.min.js')}}"></script>
  <script src="{{asset('js/main.js')}}"></script>

  @yield('js')

  <script>
    $(document).ready(function() {
      @if(Auth::check())
      getCartCount()
      @endif
    });

    function getCartCount() {
      $.ajax({
        type: "get",
        url: "{{route('getCartCount')}}",
        success: function(data) {
          if (data.message.body > 0) {
            $('#cart-indicator').text(data.message.body)
            $('#cart-indicator').show()
          } else {
            $('#cart-indicator').hide();
          }
        }
      });
    }
    const logout = () => {
      swal({
          title: 'Yakin?',
          text: "Anda akan logout!",
          buttons: true,
          dangerMode: true,
        })
        .then((result) => {
          if (result) {
            document.getElementById('logout-form').submit();
          }
        });
    };
  </script>
</body>

</html>