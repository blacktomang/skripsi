<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Aksi</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Kode Transaksi</th>
            <th scope="col">Nama Customer</th>
            <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($orders as $item)
        <tr>
            <td>{{ ($orders->currentpage()-1) * $orders->perpage() + $loop->index + 1 }}</td>
            <td>
                <button type="button" class="btn-sm btn btn-success" onclick="viewData('{{ $item->id }}')">
                    <i class="mdi mdi-eye"></i>
                </button>
            </td>
            <td>{{ $item->created_at }}</td>
            <td>{{ $item->code }}</td>
            <td>{{ $item->user->name }}</td>
            <td>
                <div class="dropdown">

                    @php
                    $statClass = 'btn btn-sm dropdown-toggle';
                    $statMessage ;
                    
                    if($item->status == 1) {
                      $statClass = 'btn btn-info btn-sm';
                      $statMessage = 'Diproses';
                    }elseif ($item->status == 2) {
                      $statClass = 'btn btn-success btn-sm';
                      $statMessage = 'Selesai';
                    }elseif($item->status == 0){
                      $statClass = 'btn btn-secondary btn-sm';
                      $statMessage = 'Belum dibayar';  
                    }else{
                      $statClass = 'btn btn-danger btn-sm';
                      $statMessage = 'Dibatalkan';  
                    }

                    @endphp

                    <button class="{{ $statClass }}" type="button" id="statusButton{{ $item->id }}"
                        @if(($item->status==1 || $item->status ==0)) data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @endif>
                        {{ $statMessage }}
                        <i class="fas @if($item->status==2) fa-check @elseif($item->status==3) fa-burn @else fa-angle-down @endif ms-1" style="font-size: 10px"></i>
                    </button>
                    
                    <div class="dropdown-menu" aria-labelledby="" id="dropdownOrderStatus">
                        <button class="dropdown-item"
                            onclick="updateOrderStatus('{{ $item->id }}','1')">Diproses</button>
                        <button class="dropdown-item"
                            onclick="updateOrderStatus('{{ $item->id }}','2')">Selesai</button>
                        <div class="dropdown-divider"></div>
                        <button class="dropdown-item text-danger"
                            onclick="updateOrderStatus('{{ $item->id }}','3')">Batalkan Pesanan</button>
                    </div>
                </div>
            </td>
        </tr>
        @empty
    <tr>
      <td colspan="6" class="text-center">Tidak ada data</td>
    </tr>
    @endforelse
  </tbody>
</table>

{{ $orders->links() }}