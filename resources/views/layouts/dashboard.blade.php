<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta name="csrf-token" id="head-csrf" content="{{ csrf_token() }}" />
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>@yield('title', 'Marketplace')</title>
  <!-- plugins:css -->
  <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}" />
  <link rel="stylesheet" href="{{asset('css/animate.css')}}" />
  <link rel="stylesheet" href="{{asset('css/mdi/css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/feather/feather.css')}}" />
  <!-- inject:css -->
  <link type="text/css" rel="stylesheet" href="{{asset('select2/css/select2.min.css') }}">
  </link>
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{asset('images/logo.svg')}}" />
  <style>
    .select2 {
      width: 100% !important;
    }

    .mdi::before {
      font-size: 24px;
      line-height: 14px;
    }

    .btn .mdi::before {
      position: relative;
      top: 4px;
    }

    .btn-xs .mdi::before {
      font-size: 18px;
      top: 3px;
    }

    .btn-sm .mdi::before {
      font-size: 18px;
      top: 3px;
    }

    .dropdown-menu .mdi {
      width: 18px;
    }

    .dropdown-menu .mdi::before {
      position: relative;
      top: 4px;
      left: -8px;
    }

    .nav .mdi::before {
      position: relative;
      top: 4px;
    }

    .navbar .navbar-toggle .mdi::before {
      position: relative;
      top: 4px;
      color: #FFF;
    }

    .breadcrumb .mdi::before {
      position: relative;
      top: 4px;
    }

    .breadcrumb a:hover {
      text-decoration: none;
    }

    .breadcrumb a:hover span {
      text-decoration: underline;
    }

    .alert .mdi::before {
      position: relative;
      top: 4px;
      margin-right: 2px;
    }

    .input-group-addon .mdi::before {
      position: relative;
      top: 3px;
    }

    .navbar-brand .mdi::before {
      position: relative;
      top: 2px;
      margin-right: 2px;
    }

    .list-group-item .mdi::before {
      position: relative;
      top: 3px;
      left: -3px
    }
  </style>
  @yield('css')
</head>

<body>
  <div class="container-scroller">
    @include('partials.dashboard.head')

    <div class="container-fluid page-body-wrapper">
      @include('partials.dashboard.sidebar')

      <div class="main-panel">
        <div class="content-wrapper">
          @yield('content')
        </div>
      </div>
    </div>
  </div>

  @yield('modal')
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="{{asset('js/bootstrap.min.js')}}"></script>
  <script src="{{asset('js/app.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="{{asset('js/wow.min.js')}}"></script>
  <script src="{{asset('js/tiny-slider.js')}}"></script>
  <script src="{{asset('js/glightbox.min.js')}}"></script>
  <script src="{{asset('js/main.js')}}"></script>

  <script src="{{asset('js/off-canvas.js')}}"></script>
  <script src="{{asset('js/hoverable-collapse.js')}}"></script>
  <script src="{{asset('js/template.js')}}"></script>

  <script src="{{asset('js/dashboard.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js" integrity="sha256-jLFv9iIrIbqKULHpqp/jmePDqi989pKXOcOht3zgRcw=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="{{asset('js/Chart.roundedBarCharts.js')}}"></script>
  <script>
    const BASE_URL = `{{ url('/') }}`
    const URL_NOW = `{{ request()->url() }}`
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content")

    // Set up csrf token
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    const refresh_table = url => {
      new Promise((resolve, reject) => {
        $("#table_data").LoadingOverlay('show')
        axios.get(url)
          .then(({
            data
          }) => {
            $("#table_data").LoadingOverlay('hide')
            $('#table_data').html(data)
          })
          .catch(err => {
            console.log(err)
            $("#table_data").LoadingOverlay('hide')
            $swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!',
            })
          })
      })
    }

    const loading = (type, selector = null, options = null) => {
      if (selector) {
        $(selector).LoadingOverlay(type, options)
      } else {
        $.LoadingOverlay(type, options)
      }
    }

    const throwErr = err => {
      if (err.response.status == 422) {
        let message = err.response.data.errors
        let teks_error = ''
        $.each(message, (i, e) => {
          if (e.length > 1) {
            $.each(e, (id, el) => {
              teks_error += `<p>${el}</p>`
            })
          } else {
            teks_error += `<p>${e}</>`
          }
        })
        $swal.fire({
          icon: 'error',
          title: 'Oops...',
          html: teks_error,
        })
      } else {
        let message = err.response.data.message
        $swal.fire({
          icon: 'error',
          title: message.head,
          text: message.body,
        })
      }
    };
  </script>

  {{-- Updating penjualan's badge on sidebar menu --}}
  <script>
    $(document).ready(function() {
      refreshSideBadge()
      checkStock()
      getAllNotif()
    });

    // SIDE BADGE INDICATOR
    function getOrderStatCount(status_order, tag_id) {
      $.ajax({
        type: "get",
        url: "{{url('dashboard/order/getOrderStatCount')}}",
        data: "status_order=" + status_order,
        success: function(amountOfOrder) {
          $('#' + tag_id).text(amountOfOrder)
        }
      });
    }

    function refreshSideBadge() {
      //  SIDE BAR
      getOrderStatCount('DIKEMAS', 'DIKEMAS');
      getOrderStatCount('DIKIRIM', 'DIKIRIM');
      getOrderStatCount('SELESAI', 'SELESAI');
    }

    // NOTIFICATION
    function checkStock() {
      let runOutStockPromise = Promise.resolve(
        $.ajax({
          type: "get",
          url: "",
          success: function(data) {
            $('#notifikasi-container').append(data)

            $count_notif = $('#product-run-of-stock').text()
            if ($count_notif >= 1) {
              $('#notif-indicator').show()
              // console.log($count_notif + 'ini jumlah notifikasi produck')

            }
          }
        })
      )
    }

    function getAllNotif() {
      $.ajax({
        type: "get",
        url: "",
        success: function(data) {
          console.log(data)

          let count = 0
          data.forEach(item => {

            let href_val = '#'
            let icon_src = ''
            if (item.type == 'new_order') {
              href_val = "" + '?keyword=' + 'BELUM_BAYAR'
              icon_src = 'https://clipground.com/images/purchase-order-icon-clipart-8.jpg'
            }

            let notifikasi = $("<a>", {
              id: 'notif-' + item.id,
              onclick: "markAsRead(" + item.id + ")",
              class: "dropdown-item preview-item",
              href: href_val
            }).append(
              $("<div>", {
                class: "preview-thumbnail"
              }).append(
                $('<img>', {
                  src: icon_src,
                  alt: 'icon',
                  class: 'img-sm profile-pic'
                })
              ),
              $("<div>", {
                class: "preview-item-content flex-grow py-2"
              }).append(
                $('<p>', {
                  class: 'preview-subject ellipsis font-weight-medium text-dark',
                  text: item.title
                }),
                $('<p>', {
                  class: 'fw-light small-text mb-0',
                  text: item.desc
                }),
              ),
            )

            $('#notifikasi-container').append(notifikasi)
            count += 1
          })

          // enable indicator
          if (count >= 1) {
            $('#notif-indicator').show()
          }
        }
      })
    }

    function markAsRead(notif_id) {
      $.ajax({
        type: "get",
        url: "",
        data: 'notif_id=' + notif_id,
        success: function(data) {
          console.log(data)

        }
      })
    }

    function markAllAsRead() {
      $.ajax({
        type: "get",
        url: "",
        success: function(data) {
          console.log(data)
          $('#notifikasi-container').empty()
          $('#notif-indicator').hide()
        }
      })
    }

    /**
     * Refresh Table Client Side.
     * @param {string} url 
     * @param {string} table
     */

    const throwErr = (status, data) => {
      console.warn(data);
      if (status == 422) {
        let message = data.errors
        let teks_error = ''
        $.each(message, (i, e) => {
          if (e.length > 1) {
            $.each(e, (id, el) => {
              teks_error += `<p>${el}</p>`
            })
          } else {
            teks_error += `<p>${e}</>`
          }
        })
        $swal.fire({
          icon: 'error',
          title: 'Oops...',
          html: teks_error,
        })
      } else {
        let message = data.message
        $swal.fire({
          icon: 'error',
          title: 'Oops..',
          text: data.message,
        })
      }
    }

    async function refreshTable(url, table) {
      $.ajax({
        url: url,
        dataType: 'html',
        success: (data) => {
          $(table).html(data);
        },
        error: (err) => {
          throwErr(err, err)
        }
      })
    };
  </script>

  @yield('js')
</body>

</html>