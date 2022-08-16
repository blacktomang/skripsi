@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-lg-12 mb-3 d-flex justify-content-end">
        <button class="btn btn-primary" id="btnTambah">Tambah Testimonial</button>
    </div>
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <h4 class="card-title">Testimonial</h4>
                    <div class="col-md-4">
                        <form action="" method="get" class="row">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="keyword" placeholder="Kata Kunci"
                                    value="{{ request()->keyword ?? '' }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary ml-2"><i class="fas fa-search"></i>Cari</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    @include('pages.dashboard.testimonial.pagination')
                </div>
            </div>
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
            <form action="{{route('testimonial.store')}}" method="post" id="formTambah" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" value="POST" id="methodEdit">
                <input type="hidden" name="id" id="inputID">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Jabatan</label>
                                <input type="text" name="jabatan" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="file" class="form-control" name="foto">
                            </div>
                        </div>

                        <img id="preview" src="" alt="">
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
    $("#btnTambah").on('click', () => {
        type = 'STORE'
        $("#modalTitle").html('Tambah Testimonial')
        $('#modal_tambah').modal('show')
        $("#formTambah")[0].reset()
    })
    const deleteData = actionURL => {
        $swal.fire({
                title: 'Yakin?',
                text: "Ingin menghapus data ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Tidak',
                confirmButtonText: 'Ya!'
            })
            .then((result) => {
                if (result.isConfirmed) {
                    $('#deleteForm').attr('action', actionURL)
                    $('#submitDelete').click()
                }
            })
    }

    const editData = (actionURL,foto,name,jabatan,deskripsi) => {
        $("#formTambah")[0].reset()
        $("#inputID").val(user.id)
        $("#modalTitle").html('Update Testimonial')
        $("#inputName").val()

         // Preparation
        $("#formTambah").attr('action',actionURL)
        $("#methodEdit").attr('value', "PUT")

        $('input[name="foto"]').attr('value',foto)
        $('input[name="name"]').attr('value',name)
        $('input[name="jabatan"]').attr('value',jabatan)
        $('textarea[name="deskripsi"]').val(deskripsi)

        $('#modal_tambah').modal('show')
    }

</script>
@endsection
