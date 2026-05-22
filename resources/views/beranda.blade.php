<x-base title="Beranda SANJAYA-APP" class="p-3">
    <div class="grid grid-cols-6 gap-3">
        <div class="col-span-2 h-[30vh] shadow-md grid rounded-md px-2 py-1">
            <p class="uppercase font-bold">Penjualan Hari ini</p>
            <table class="w-full h-[15vh]">
                <thead>
                    <tr>
                        <th class="text-center">Total Pembeli</th>
                        <th class="text-center">Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center h-[15vh]">{{ $totalbuyer }}</td>
                        <td class="text-center h-[15vh]">Rp. {{ number_format($totalprice, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-span-4 h-[87vh] shadow-md rounded-md px-2 py-1 overflow-auto">
            <p class="uppercase font-bold">Stok Rendah</p>
            <table class="w-full border-separate">
                <thead>
                    <tr>
                        <th class="text-center w-7/10">Nama Barang</th>
                        <th class="text-center w-1/10">Stok Sisa</th>
                        <th class="text-center w-2/10">Urgensi</th>
                    </tr>
                </thead>
                <tbody id="table-stock">
                    @foreach ($lowstocks as $ls)
                        <tr class="h-[7vh] hover:bg-gray-200">
                            <td class="px-2 border-b border-gray-200">{{ $ls->name }}</td>
                            <td class="text-center border-b border-gray-200">{{ $ls->qty_instock }}</td>
                            <td class="text-center border-b border-gray-200 rounded-md text-[#F6F6F6] {{ $ls->bg_color }}">{{ $ls->urgency }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-base>
<script>
    // stocks = [
    //     {name: 'Barang 1', qty: 10, urgency: 'Rendah'},
    //     {name: 'Barang 2', qty: 5, urgency: 'Sedang'},
    //     {name: 'Barang 3', qty: 1, urgency: 'Tinggi'},
    // ]

    // document.getElementById('table-stock').innerHTML = stocks.map(stock => {
    //     let bgColor = ''
    //     if (stock.urgency == 'Rendah') bgColor = 'bg-yellow-500'
    //     else if (stock.urgency == 'Sedang') bgColor = 'bg-orange-500'
    //     else if (stock.urgency == 'Tinggi') bgColor = 'bg-red-500'

    //     return `
    //         <tr class="h-[7vh] hover:bg-gray-200">
    //             <td class="px-2 border-b border-gray-200">${stock.name}</td>
    //             <td class="text-center border-b border-gray-200">${stock.qty}</td>
    //             <td class="text-center border-b border-gray-200 rounded-md text-[#F6F6F6] ${bgColor}">${stock.urgency}</td>
    //         </tr>
    //     `
    // }).join('')
</script>