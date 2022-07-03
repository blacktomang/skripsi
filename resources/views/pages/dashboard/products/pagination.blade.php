<table class="table table-sm">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nama</th>
      <th scope="col">Status</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody id="tbody">
    @forelse ($products as $key => $value)
    <tr>
      <th scope="row">{{ ($products->currentpage()-1) * $products->perpage() + $loop->index + 1 }}</th>
      <td>{{ $value->name??0 }}</td>
      <td>
        @if ($value->status)
        <span class="filter badge badge-success">Aktif</span>
        @else
        <span class="filter badge badge-danger">Tidak Aktif</span>
        @endif
      </td>
      <td>
        @if ($value->status)
        <button class="btn btn-sm btn-danger" onclick="setStatusCourier({{ $value->id }}, 0)">Nonaktifkan</button>
        @else
        <button class="btn btn-sm btn-success" onclick="setStatusCourier({{ $value->id }}, 1)">Aktifkan</button>
        @endif
      </td>
    </tr>
    @empty
    <tr>
      <td colspan="4" class="text-center">Tidak ada data</td>
    </tr>
    @endforelse
  </tbody>
</table>

{{ $products->links() }}