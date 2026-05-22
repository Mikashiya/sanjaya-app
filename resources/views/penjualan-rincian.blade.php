<x-base title="Rincian Penjualan">    
    @vite(['resources/js/sales.js'])
    <div class="w-full h-[90vh] overflow-auto p-2">
        @foreach ($sales as $s)
            <form action="" method="post" class="w-full flex gap-3">
                <div class="grid gap-1">
                    <label for="" class="w-auto">Tanggal</label>
                    <input type="text" disabled name="" id="" class="py-1 w-full" value="{{ $s->date_sales }}">
                </div>
                <div class="grid gap-1">
                    <label for="" class="w-auto">Nama</label>
                    <input type="text" disabled name="" id="" class="py-1 w-full" value="{{ $s->customer->name }}">
                </div>
                <div class="grid gap-1">
                    <label for="" class="w-auto">Total Barang</label>
                    <input type="text" disabled name="" id="" class="py-1 w-full" value="{{ $s->total_qty }}">
                </div>
                <div class="grid gap-1">
                    <label for="" class="w-auto">Total Belanja</label>
                    <input type="text" disabled name="" id="" class="py-1 w-full" value="Rp. {{ number_format($s->total_price, 0, ',', '.') }}">
                </div>
            </form>
        @endforeach
        <table id="table-cart" class="w-full">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Sub Harga</th>
                    @if (Auth::check() && Auth::user()->access_level > 1)
                        <th>Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody id="data-cart">
                @php
                    $no = 1
                @endphp
                @foreach ($detail_sales as $ds)
                    <tr class="h-[7vh] hover:bg-gray-200">
                        <td class="w-[10vw] border-b border-gray-200">{{ $no++ }}</td>
                        <td class="w-[20vw] border-b border-gray-200">{{ $ds->product->name }}</td>
                        <td class="w-[10vw] border-b border-gray-200">{{ $ds->sub_qty }}</td>
                        <td class="w-[20vw] border-b border-gray-200">Rp. {{ number_format($ds->sub_price, 0, ',', '.') }}</td>
                        @if (Auth::check() && Auth::user()->access_level > 1)
                            <td class="h-[7vh] flex gap-3 justify-center items-center px-2 border-b border-gray-200">
                                <button onclick="togglemodal('modal_edit_produk_{{ $ds->id }}')" class="px-2 py-1 rounded-md bg-yellow-500 text-[#F6F6F6] hover:opacity-80"><i class="bi bi-pencil-square"></i></button>
                                <form action="{{ route('api.detailsales.update.item') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" id="id" value="{{ $ds->id }}">
                                    <input type="hidden" name="sales_id" id="sales_id" value="{{ $ds->sales_id }}">
                                    <input type="hidden" name="product_id" id="product_id" value="{{ $ds->product_id }}">
                                    <button type="submit" class="px-2 py-1 rounded-md bg-red-500 text-[#F6F6F6] hover:opacity-80"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-base>
@foreach ($detail_sales as $mds)
    <x-modal id="edit_produk_{{ $mds->id }}" title="Ubah Jumlah {{ $mds->product->name }}">
        <form action="{{ route('api.detailsales.update.qty') }}" method="post" class="grid gap-5">
            @csrf
            <input type="hidden" name="id" id="id" value="{{ $mds->id }}">
            <input type="hidden" name="sales_id" id="sales_id" value="{{ $mds->sales_id }}">
            <input type="hidden" name="product_id" id="product_id" value="{{ $mds->product_id }}">
            <div class="flex">
                <div class="w-[15vw] flex items-center">
                    <label for="sub_qty" class="w-auto">Jumlah</label>
                    <span class="w-full h-0 border-b border-dashed mx-1"></span>
                </div>
                <input type="number" name="sub_qty" id="sub_qty" value="{{ $mds->sub_qty }}" min="0" required class="rounded-md border px-2 py-1 md:w-[20vw]">
            </div>
            <button class="rounded-md px-2 py-1 w-full md:w-[35vw] bg-[#2F2F2F] text-[#F6F6F6] hover:scale-102 transition-all">Ubah</button>
        </form>
    </x-modal>
@endforeach