<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Foto</th>
            <th scope="col">Judul</th>
            <th scope="col">Tanggal</th>
            <th scope="col" width="20%">Deskripsi</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($news as $item)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td><img style="width: 200px; object-fit: cover; " class="img-table-promo" src="{{ asset('@getPath(news)'.$item->photo) }}" alt="" title=""></td>
            <td>{{$item->title}}</td>
            <td>{{$item->date}}</td>
            <td class="td-long-text">{{$item->description}}
            </td>
            <td>
                <button type="button" 
                class="btn-sm btn btn-success" 
                onclick="editData('{{$item->id}}')">
                    <i class="mdi mdi-pencil-box-outline"></i>
                </button>
                <button class="btn-sm btn btn-danger hapus" onclick="deleteData('{{ $item->id}}')" type="button">
                    <i class="mdi mdi-delete"></i>
                </button>
            </td>
        </tr>
        @endforeach
        <!-- EMPTY -->
        <!-- <tr>
            <td colspan="5" class="text-center">Tidak ada data</td>
        </tr> -->
    </tbody>
</table>

<form action="" method="POST" id="deleteForm">
    @csrf
    @method('DELETE')
    <button hidden type="submit" class="btn btn-danger" id="submitDelete">Delete</button>
</button>
</form>
<form action="" method="POST" id="editForm">
    @csrf
    @method('PUT')
    <button hidden type="submit" class="btn btn-success" id="submitEdit">Edit</button>
</button>
</form>