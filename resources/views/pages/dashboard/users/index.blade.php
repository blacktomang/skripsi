@extends('layouts.dashboard')

@section('content')
<div class="section-body">
  <div class="card overflow-hidden">
    @include('partials.flash-message-ajax')
    <div class="card-header d-flex align-items-center justify-content-between">
      <button class="btn btn-success col-lg-3 col-md-6 col-12" id="btnTambah"><i class="fas fa-plus"></i> Tambah User</button>
      <div class="col-lg-3 col-md-6 col-12">
        <form action="" method="get" class="row">
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="keyword" placeholder="Kata Kunci" value="{{ request()->keyword ?? '' }}">
            <div class="input-group-append">
              <button class="btn btn-primary ml-2"><i class="fas fa-search"></i>Cari</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="card-body table-responsive" id="table_data">
      @include('pages.dashboard.users.pagination')
    </div>
  </div>
</div>
@endsection
@section('modal')
<div class="modal fade" tabindex="-1" role="dialog" id="modal_tambah">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle"></h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post" id="formTambah" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="inputID">
        <div class="modal-body">
          <div class="form-group">
            <label for="inputName">Nama</label>
            <input type="text" name="name" id="inputName" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="inputEmail">Email</label>
            <input type="email" name="email" id="inputEmail" class="form-control inputEmail" required>
          </div>
          <div class="form-group">
            <label for="phone">No Hp</label>
            <input type="text" name="phone_number" id="phone" class="form-control phone" required>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control password" required>
          </div>
          <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-control">
              <option value="0">-- Pilih Role --</option>
              <option value="1">Admin</option>
              <option value="2">Klien</option>
            </select>
          </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('js')
<script>
  $("#btnTambah").on('click', (e) => {
    e.preventDefault();
    type = 'STORE';
    countimageinput = 0;
    $("#modalTitle").html('Tambah User')
    $("#formTambah")[0].reset()
    $("#role").val(0)
    $("#fieldFoto").hide()
    $("#fieldFoto").removeClass('d-flex');
    $("#teksImage").hide()
    $('#modal_tambah').modal('show')
  });

  const setStatusProduct = async (id, status) => {

    let url = "{{ $is_admin? route('admin.update', ':id'):route('admin.client', ':id')}}";
    url = url.replace(':id', id);

    await axios.patch(url, {
      status: status
    }).then((d) => {
      console.info(d);
      showSuccessMessage(`Produk berhasil ${status?'diaktifkan':'dinonaktifkan'}`);
      refresh_table(URL_NOW);
    }).catch((e) => {
      console.error(e);
      throwErr(e);
    })
  }

  const editData = async id => {
    await new Promise(async (resolve, reject) => {
      axios.get(`${URL_NOW}/${id}/edit`)
        .then(async ({
          data
        }) => {
          let user = data.data
          type = 'UPDATE'
          $("#formTambah")[0].reset();
          $("#inputDescription").text(user.description);
          $("#inputID").val(user.id);
          $("#modalTitle").html('Update User');
          $("input[name='name']").val(user.name)
          $("input[name='email']").val(user.email)
          $("input[name='phone_number']").val(user.phone_number)
          $("#role").val(user.role)
          $('#modal_tambah').modal('show');
        })
        .catch(err => {
          console.log('edit data', err)
          swal({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
          })
        })
    })
  };

  const deleteData = id => {
    swal({
        title: 'Yakin?',
        text: "Ingin menghapus data ini!",
        buttons: true,
        dangerMode: true,
      })
      .then((result) => {
        if (result) {
          new Promise((resolve, reject) => {
            axios.delete(`${URL_NOW}/${id}`)
              .then(({
                data
              }) => {
                swal({
                  icon: 'success',
                  title: data.message.head,
                  text: data.message.body
                })
                refresh_table(URL_NOW)
              })
              .catch(err => {
                let data = err.response.data
                console.error(err);
                swal({
                  icon: 'error',
                  title: data.message.head,
                  text: data.message.body
                })
              })
          })
        }
      })
  }

  function deleteImage(id) {
    swal({
        title: 'Yakin?',
        text: "Anda akan menghapus foto ini?",
        buttons: true,
        dangerMode: true,
      })
      .then((result) => {
        if (result) {
          new Promise((resolve, reject) => {
            let url = `{{ route('product-image.delete',['id' => ':id']) }}`;
            url = url.replace(':id', id);
            axios.delete(url)
              .then(({
                data
              }) => {
                $(`#image-${id}`).remove();
                toastr.success(data.message.head, data.message.body)
                refresh_table(URL_NOW);
              }).catch((err) => {
                throwErr(err);
              })
          });
        } else {
          return;
        }
      })
  }

  $("#formTambah").on('submit', async (e) => {
    e.preventDefault();
    let FormDataVar = new FormData($("#formTambah")[0]);
    let image = $(".inputImage");
    let tempName = "";
    $("#modal_tambah").LoadingOverlay('show');
    if (type == "STORE") {
      for (var pair of FormDataVar.entries()) {
        console.log(pair[0] + ', ' + pair[1]);
      }
      await new Promise((resolve, reject) => {
        axios.post(`{{ $is_admin == 1 ? route('admin.store'):route('client.store') }}`, FormDataVar, {
            headers: {
              'Content-type': 'multipart/form-data'
            }
          })
          .then(({
            data
          }) => {
            $("#modal_tambah").LoadingOverlay('hide');
            $('#modal_tambah').modal('hide')
            refresh_table(URL_NOW)
            console.info(data);
            showSuccessMessage(data.message.body);
          })
          .catch(err => {
            console.error(err);
            $("#modal_tambah").LoadingOverlay('hide');
            throwErr(err)
          })
      })
    } else if (type == "UPDATE") {
      let id_product = $("#inputID").val()
      FormDataVar.append('_method', 'PUT')
      await new Promise((resolve, reject) => {
        axios.post(`${URL_NOW}/${id_product}`, FormDataVar, {
            headers: {
              'Content-type': 'multipart/form-data'
            }
          })
          .then(({
            data
          }) => {
            $("#modal_tambah").LoadingOverlay('hide');
            $('#modal_tambah').modal('hide')
            showSuccessMessage(data.message.body);
            refresh_table(URL_NOW)
            // data.message.body
          })
          .catch(err => {
            $("#modal_tambah").LoadingOverlay('hide');
            throwErr(err)
          })
      })
    }
    $("#modal_tambah").LoadingOverlay('hide');
  });

  $('html').on('click', '.pagination a', function(e) {
    e.preventDefault();
    var url = $(this).attr('href');

    axios.get(url).then(() => {
      refresh_table(url);
    });

  });
</script>
@endsection