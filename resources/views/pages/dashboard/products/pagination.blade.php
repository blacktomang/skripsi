<table class="table table-sm">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nama</th>
      <th scope="col">Harga</th>
      <th scope="col">Dibuat oleh</th>
      <th scope="col">Status</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody id="tbody">
    @forelse ($products as $key => $value)
    <tr>
      <td>{{ ($products->currentpage()-1) * $products->perpage() + $loop->index + 1 }}</th>
      <td>{{ $value->name??0 }}</td>
      <td>Rp .{{number_format($value->price)}}</td>
      <td>{{$value->creator->name}}</td>
      <td>
        @if ($value->status)
        <span class="filter badge badge-success">Aktif</span>
        @else
        <span class="filter badge badge-danger">Tidak Aktif</span>
        @endif
      </td>
      <td>
        @if ($value->status)
        <button class="btn btn-sm btn-danger" onclick="setStatusProduct({{ $value->id }}, 0)">Nonaktifkan</button>
        @else
        <button class="btn btn-sm btn-success" onclick="setStatusProduct({{ $value->id }}, 1)">Aktifkan</button>
        @endif
        <button type="button" class="btn btn-sm btn-warning" onclick="editData({{ $value->id }})"><i class="fa fa-pen"></i></button>
        <button class="btn btn-sm btn-danger hapus" onclick="deleteData({{ $value->id }})" type="button"><i class="fa fa-trash"></i></button>
      </td>
    </tr>
    @empty
    <tr>
      <td colspan="6" class="text-center">Tidak ada data</td>
    </tr>
    @endforelse
  </tbody>
</table>

{{ $products->links() }}