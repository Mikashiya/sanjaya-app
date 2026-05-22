<x-base title="Produk Toko">
    @vite(['resources/js/products.js'])
    <nav class="w-full h-[10vh] shadow-md flex gap-5 items-center px-2">
        <x-items.button onclick="togglemodal('modal_tambah_produk')" type="button" class="bg-[#2F2F2F] text-[#F6F6F6]" icon="bi bi-plus" title="Baru" />
        <form method="GET" action="{{ route('product.index') }}">
            <select name="category" onchange="this.form.submit()" class="w-50 h-10 px-2 rounded-md hover:opacity-80 transition-all bg-[#2F2F2F] text-[#F6F6F6]">
                <option value="">-- Semua Kategori --</option>
                @foreach($category as $c)
                    <option value="{{ $c->id }}" {{ $selectedCategory == $c->id ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
        </form>
    </nav>
    <div class="w-full h-[80vh] overflow-auto p-2">
        <table id="table-products" class="w-full">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Barang</th>
                    <th>Merk</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="data-products">
                @php
                    $no = 1
                @endphp
                @foreach ($products as $p)
                    <tr class="h-[7vh] hover:bg-gray-200">
                        <td class="w-[10vw] border-b border-gray-200">{{ $no++ }}</td>
                        <td class="w-[50vw] border-b border-gray-200">{{ $p->name }}</td>
                        <td class="w-[20vw] border-b border-gray-200">{{ $p->brand }}</td>
                        <td class="w-[10vw] border-b border-gray-200">{{ $p->qty_instock }}</td>
                        <td class="w-[10vw] border-b border-gray-200">Rp. {{ number_format($p->price, 0, ',', '.') }}</td>
                        <td class="space-x-3 justify-center items-center px-2 border-b border-gray-200">
                            <!-- <button class="px-2 py-1 rounded-md bg-green-500 text-[#F6F6F6] hover:opacity-80"><i class="bi bi-eye"></i></button> -->
                            <button onclick="togglemodal('modal_edit_produk_{{ $p->id }}')" class="px-2 py-1 rounded-md bg-yellow-500 text-[#F6F6F6] hover:opacity-80"><i class="bi bi-pencil-square"></i></button>
                            @if (Auth::check() && Auth::user()->access_level > 1)
                                <button onclick="togglemodal('modal_delete_produk_{{ $p->id }}')" class="px-2 py-1 rounded-md bg-red-500 text-[#F6F6F6] hover:opacity-80"><i class="bi bi-trash"></i></button>
                                <x-modal id="delete_produk_{{ $p->id }}" title="Hapus Produk {{ $p->name }}" class="flex justify-center">
                                    <form action="{{ route('api.product.delete') }}" method="post" class="w-2/4">
                                        @csrf
                                        <input type="hidden" name="id" id="id" value="{{ $p->id }}">
                                        <p class="text-center">Yakin ingin menghapus produk ini?</p>
                                        <p class="text-center text-2xl">{{ $p->name }}</p>
                                        <div class="flex justify-between">
                                            <button type="submit" class="px-2 py-1 rounded-md bg-red-500 text-[#F6F6F6] hover:opacity-80">Ya, Hapus</button>
                                            <button type="reset" onclick="togglemodal('modal_delete_produk_{{ $p->id }}')" class="px-2 py-1 rounded-md bg-gray-500 text-[#F6F6F6] hover:opacity-80">Batalkan</button>
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
    <!-- <div id="modals"></div> -->
</x-base>
@foreach ($products as $mp)
    <x-modal id="edit_produk_{{ $mp->id }}" title="Edit Produk {{ $mp->name }}" class="grid grid-cols-10">
        <form action="{{ route('api.product.update') }}" method="post" class="col-span-4 grid gap-5" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="id" value="{{ $mp->id }}">
            <div class="flex h-[6vh]">
                <div class="w-[15vw] flex items-center">
                    <label for="name" class="w-auto">Nama</label>
                    <span class="w-full h-0 border-b border-dashed mx-1"></span>
                </div>
                <input type="text" name="name" id="name" value="{{ $mp->name }}" required class="rounded-md border px-2 py-1 md:w-[20vw]">
            </div>
            <div class="flex h-[6vh]">
                <div class="w-[15vw] flex items-center">
                    <label for="brand" class="w-auto">Merk</label>
                    <span class="w-full h-0 border-b border-dashed mx-1"></span>
                </div>
                <input type="text" name="brand" id="brand" value="{{ $mp->brand }}" required class="rounded-md border px-2 py-1 md:w-[20vw]">
            </div>
            <div class="flex h-[6vh]">
                <div class="w-[15vw] flex items-center">
                    <label for="category" class="w-auto">Kategori</label>
                    <span class="w-full h-0 border-b border-dashed mx-1"></span>
                </div>
                <select name="category_id" id="category_id" class="rounded-md border px-2 py-1 md:w-[20vw]" required>
                    <option value="{{ $mp->category_product->id }}">{{ $mp->category_product->name }}</option>
                    @foreach ($category as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex h-[6vh]">
                <div class="w-[15vw] flex items-center">
                    <label for="qty_instock" class="w-auto">Stok</label>
                    <span class="w-full h-0 border-b border-dashed mx-1"></span>
                </div>
                <input type="number" name="qty_instock" id="qty_instock" min="0" value="{{ $mp->qty_instock }}" required class="rounded-md border px-2 py-1 md:w-[20vw]">
            </div>
            <div class="flex h-[6vh]">
                <div class="w-[15vw] flex items-center">
                    <label for="price" class="w-auto">Harga</label>
                    <span class="w-full h-0 border-b border-dashed mx-1"></span>
                </div>
                <input type="number" name="price" id="price" min="0" value="{{ $mp->price }}" required class="rounded-md border px-2 py-1 md:w-[20vw]">
            </div>
            <div class="flex h-[6vh]">
                <div class="w-[15vw] flex items-center">
                    <label for="photo" class="w-auto">Foto</label>
                    <span class="w-full h-0 border-b border-dashed mx-1"></span>
                </div>
                <input type="file" name="photo" id="photo" accept="image/*" class="rounded-md border px-2 py-1 md:w-[20vw]" onchange="previewPhoto(event, 'photoEdit{{ $mp->id }}')">
            </div>
            <button class="rounded-md px-2 py-1 w-full md:w-[35vw] h-[6vh] bg-[#2F2F2F] text-[#F6F6F6] hover:scale-102 transition-all">Ubah</button>
        </form>
        <div class="col-span-6 flex gap-1">
            @if($mp->photo && file_exists(public_path('storage/' . $mp->photo)))
                <img src="{{ asset('storage/' . $mp->photo) }}" alt="Foto Lama" class="img-fluid border rounded-md h-[80vh] w-[25vw]">
            @else
                <p class="text-muted">Belum ada foto yang tersimpan atau file tidak ditemukan.</p>
            @endif
            <img id="photoEdit{{ $mp->id }}" class="img-fluid border rounded-md h-[80vh] w-[25vw]" alt="Preview Foto Baru">
        </div>
    </x-modal>
@endforeach
<x-modal id="tambah_produk" title="Tambah Produk" class="grid grid-cols-10">
    <form action="{{ route('api.product.store') }}" method="post" class="col-span-4 grid gap-5" enctype="multipart/form-data">
        @csrf
        <div class="flex h-[6vh]">
            <div class="w-[15vw] flex items-center">
                <label for="name" class="w-auto">Nama</label>
                <span class="w-full h-0 border-b border-dashed mx-1"></span>
            </div>
            <input type="text" name="name" id="name" class="rounded-md border px-2 py-1 md:w-[20vw]" required>
        </div>
        <div class="flex h-[6vh]">
            <div class="w-[15vw] flex items-center">
                <label for="brand" class="w-auto">Merk</label>
                <span class="w-full h-0 border-b border-dashed mx-1"></span>
            </div>
            <input type="text" name="brand" id="brand" class="rounded-md border px-2 py-1 md:w-[20vw]" required>
        </div>
        <div class="flex h-[6vh]">
            <div class="w-[15vw] flex items-center">
                <label for="category" class="w-auto">Kategori</label>
                <span class="w-full h-0 border-b border-dashed mx-1"></span>
            </div>
            <select name="category_id" id="category_id" class="rounded-md border px-2 py-1 md:w-[20vw]" required>
                @foreach ($category as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex h-[6vh]">
            <div class="w-[15vw] flex items-center">
                <label for="qty_instock" class="w-auto">Stok</label>
                <span class="w-full h-0 border-b border-dashed mx-1"></span>
            </div>
            <input type="number" name="qty_instock" id="qty_instock" min="0" class="rounded-md border px-2 py-1 md:w-[20vw]" required>
        </div>
        <div class="flex h-[6vh]">
            <div class="w-[15vw] flex items-center">
                <label for="price" class="w-auto">Harga</label>
                <span class="w-full h-0 border-b border-dashed mx-1"></span>
            </div>
            <input type="number" name="price" id="price" min="0" class="rounded-md border px-2 py-1 md:w-[20vw]" required>
        </div>
        <div class="flex h-[6vh]">
            <div class="w-[15vw] flex items-center">
                <label for="photo" class="w-auto">Foto</label>
                <span class="w-full h-0 border-b border-dashed mx-1"></span>
            </div>
            <input type="file" name="photo" id="photo" accept="image/*" class="rounded-md border px-2 py-1 md:w-[20vw]" onchange="previewPhoto(event, 'photoAdd')">
        </div>
        <button class="rounded-md px-2 py-1 w-full md:w-[35vw] h-[6vh] bg-[#2F2F2F] text-[#F6F6F6] hover:scale-102 transition-all">Tambah</button>
    </form>
    <div class="col-span-6">
        <img id="photoAdd" class="img-fluid border rounded-md h-[80vh] w-[25vw]" alt="Preview Foto Baru">
    </div>
</x-modal>
@if ($errors->any())
    <x-modal id="errors" title="Kesalahan">
        <ul>
           @foreach ($errors->all() as $err)
                <li class="text-red-500">{{ $err }}</li>
           @endforeach 
        </ul>
    </x-modal>
    <script>
        document.getElementById('modal_errors').classList.remove('hidden')
    </script>
@endif
<script>
    function previewPhoto(event, previewId) {
        const input = event.target
        const preview = document.getElementById(previewId)

        if (input.files && input.files[0]) {
            const reader = new FileReader()
            reader.onload = e => preview.src = e.target.result
            reader.readAsDataURL(input.files[0])
        }
    }
</script>