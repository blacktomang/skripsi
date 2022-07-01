<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>@yield('title', 'Autentikasi')</title>
  <!-- endinject -->
  <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/logo.svg')}}" />


  <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}" />
  <link rel="stylesheet" href="{{asset('css/LineIcons.2.0.css')}}" />
  <link rel="stylesheet" href="{{asset('css/animate.css')}}" />
  <link rel="stylesheet" href="{{asset('css/tiny-slider.css')}}" />
  <link rel="stylesheet" href="{{asset('css/glightbox.min.css')}}" />
  <link rel="stylesheet" href="{{asset('css/main.css')}}" />
  <!-- <link rel="stylesheet" href="{{asset('css/style.css')}}" /> -->

  <!-- endinject -->
  <link rel="shortcut icon" href="{{asset('images/favicon.png')}}" />

  @yield('css')
</head>

<body>
  <div class="{{Request()->url() == url('login') ?'vh-100':''}} d-flex align-items-center">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          @yield('content')
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{asset('js/hoverable-collapse.js')}}"></script>
  @yield('js')
</body>

</html>