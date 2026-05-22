<x-base title="Penjualan Harian">
    @vite(['resources/js/sales.js'])
    <div class="w-full h-[90vh] flex">
        <div class="w-3/4 h-full p-2 overflow-auto">
            <table id="table-sales" class="w-full">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Nama Pembeli</th>
                        <th>Penjualan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="data-sales">
                    @php
                        $no = 1
                    @endphp
                    @foreach ($sales as $s)
                        <tr class="h-[7vh] hover:bg-gray-200">
                            <td class="w-[10vw] border-b border-gray-200">{{ $no++ }}</td>
                            <td class="w-[20vw] border-b border-gray-200">{{ $s->date_sales }}</td>
                            <td class="w-[20vw] border-b border-gray-200">{{ $s->customer->name }}</td>
                            <td class="w-[10vw] border-b border-gray-200">Rp. {{ number_format($s->total_price, 0, ',', '.') }}</td>
                            <td class="flex space-x-3 justify-start items-center px-2 border-b border-gray-200">
                                <a href="{{ route('api.sales.detail', ['id' => $s->id]) }}" class="px-2 py-1 rounded-md bg-green-500 text-[#F6F6F6] hover:opacity-80"><i class="bi bi-eye"></i></a>
                                @if (Auth::check() && Auth::user()->access_level > 1)
                                    <button onclick="togglemodal('modal_delete_penjualan_{{ $s->id }}')" class="px-2 py-1 rounded-md bg-red-500 text-[#F6F6F6] hover:opacity-80"><i class="bi bi-trash"></i></button>
                                    <x-modal id="delete_penjualan_{{ $s->id }}" title="Hapus Penjualan {{ $s->date_sales }}" class="flex justify-center">
                                        <form action="{{ route('api.sales.delete') }}" method="post" class="w-2/4">
                                            @csrf
                                            <input type="hidden" name="id" id="id" value="{{ $s->id }}">
                                            <p class="text-center">Yakin ingin menghapus penjualan ini?</p>
                                            <p class="text-center text-2xl">{{ $s->date_sales }} {{ $s->customer->name }}</p>
                                            <p class="text-center text-red-500">Stok barang tidak akan dikembalikan kedalam data!</p>
                                            <div class="flex justify-between">
                                                <button type="submit" class="px-2 py-1 rounded-md bg-red-500 text-[#F6F6F6] hover:opacity-80">Ya, Hapus</button>
                                                <button type="reset" onclick="togglemodal('modal_delete_penjualan_{{ $s->id }}')" class="px-2 py-1 rounded-md bg-gray-500 text-[#F6F6F6] hover:opacity-80">Batalkan</button>
                                            </div>
                                        </form>
                                    </x-modal>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="w-1/4 h-full border-l border-gray-200 p-2 space-y-5">
            <p class="text-center my-5">Tambah Penjualan Baru</p>
            <form action="{{ route('api.detailsales.store') }}" method="post" class="grid gap-5">
                @csrf
                <input type="hidden" name="sales_id" id="sales_id" value="1">  
                <div class="flex gap-1">
                    <div class="grid gap-1">
                        <label for="product_id" class="w-auto">Barang</label>
                        <select name="product_id" id="product_id" class="rounded-md border px-2 py-1 w-60">
                            @foreach ($products as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                                <option value="" disabled>sisa stok: {{ $p->qty_instock }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid gap-1">
                        <label for="sub_qty" class="w-auto">Jumlah</label>
                        <input type="number" name="sub_qty" id="sub_qty" min="0" class="rounded-md border px-2 py-1 w-20" value="0">
                    </div>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="rounded-md px-2 py-1 w-full bg-[#2F2F2F] text-[#F6F6F6] hover:scale-102 transition-all">Tambah Barang</button>
                    <button type="button" class="rounded-md px-2 py-1 w-full bg-[#2F2F2F] text-[#F6F6F6] hover:scale-102 transition-all" onclick="togglemodal('modal_keranjang')">Lihat Keranjang</button>
                </div>
            </form>
            <form action="{{ route('api.sales.store') }}" method="post" class="grid gap-5">
                @csrf
                <div class="grid gap-1">
                    <label for="date_sales" class="w-auto">Tanggal</label>
                    <input type="date" name="date_sales" id="date_sales" class="rounded-md border px-2 py-1">
                    <script>
                        function dateInput(dateObject) {
                            const local = new Date(dateObject)
                            local.setMinutes(dateObject.getMinutes() - dateObject.getTimezoneOffset())
                            return local.toJSON().slice(0, 10)
                        }

                        document.getElementById('date_sales').value = dateInput(new Date())
                    </script>
                </div>
                <div class="grid gap-1">
                    <label for="customer_id" class="w-auto">Nama Pelanggan</label>
                    <select name="customer_id" id="customer_id" class="rounded-md border px-2 py-1">
                        @foreach ($customers as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid gap-1">
                    <label for="barang" class="w-auto">Total Harga</label>
                    <input type="text" name="total_harga" id="total_harga" value="Rp. {{ number_format($total_price, 0, ',', '.') }}" disabled>
                </div>
                <button type="submit" class="rounded-md px-2 py-1 w-full bg-[#2F2F2F] text-[#F6F6F6] hover:scale-102 transition-all">Tambah</button>
            </form>
        </div>
    </div>
    <div id="modals"></div>
</x-base>
<x-modal id="keranjang" title="Daftar Keranjang">
    <table id="table-cart" class="w-full">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Sub Harga</th>
                <th>Aksi</th>
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
                    <td class="h-[7vh] flex gap-3 justify-center items-center px-2 border-b border-gray-200">
                        <form action="{{ route('api.detailsales.delete') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{ $ds->id }}">
                            <button type="submit" class="px-2 py-1 rounded-md bg-red-500 text-[#F6F6F6] hover:opacity-80"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-modal>