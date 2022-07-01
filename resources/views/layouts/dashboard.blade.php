<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta name="csrf-token" id="head-csrf" content="{{ csrf_token() }}" />
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>@yield('title', 'Marketplace')</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{asset('vendors/feather/feather.css')}}">
  <link rel="stylesheet" href="{{asset('vendors/mdi/css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{asset('vendors/ti-icons/css/themify-icons.css')}}">
  <link rel="stylesheet" href="{{asset('vendors/typicons/typicons.css')}}">
  <link rel="stylesheet" href="{{asset('vendors/simple-line-icons/css/simple-line-icons.css')}}">
  <link rel="stylesheet" href="{{asset('vendors/css/vendor.bundle.base.css')}}">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <!-- endinject -->
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
  </style>
  @yield('css')
</head>

<body>
  <div class="container-scroller">
    @include('partials.dashboard.navbar')

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
  <script src="{{asset('vendors/js/vendor.bundle.base.js')}}"></script>
  <script src="{{asset('js/app.js') }}"></script>
  <script src="{{asset('select2/js/i18n/id.js') }}"></script>
  <script src="{{asset('select2/js/select2.min.js') }}"></script>
  <script src="{{asset('vendors/chart.js/Chart.min.js')}}"></script>

  <script src="{{asset('js/off-canvas.js')}}"></script>
  <script src="{{asset('js/hoverable-collapse.js')}}"></script>
  <script src="{{asset('js/template.js')}}"></script>

  <script src="{{asset('js/dashboard.js')}}"></script>
  <script src="{{ asset('vendors/loadingoverlay.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="{{asset('js/Chart.roundedBarCharts.js')}}"></script>
  <script>
    // Set up csrf token
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
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
          url: "{{route('cekStock')}}",
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
        url: "{{route('getAllNotif')}}",
        success: function(data) {
          console.log(data)

          let count = 0
          data.forEach(item => {

            let href_val = '#'
            let icon_src = ''
            if (item.type == 'new_order') {
              href_val = "{{ route('order.index') }}" + '?keyword=' + 'BELUM_BAYAR'
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
        url: "{{route('markAsRead')}}",
        data: 'notif_id=' + notif_id,
        success: function(data) {
          console.log(data)

        }
      })
    }

    function markAllAsRead() {
      $.ajax({
        type: "get",
        url: "{{route('markAllAsRead')}}",
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
      console.info(url)
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