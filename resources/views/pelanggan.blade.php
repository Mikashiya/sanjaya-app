<x-base title="Pelanggan">
    @vite(['resources/js/customers.js'])
    <nav class="w-full h-[10vh] shadow-md flex items-center px-2">
        <x-items.button onclick="togglemodal('modal_tambah_pelanggan')" type="button" class="bg-[#2F2F2F] text-[#F6F6F6]" icon="bi bi-plus" title="Baru" />
    </nav>
    <div class="w-full h-[80vh] overflow-auto p-2">
        <table id="table-customers" class="w-full">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Pelanggan</th>
                    <th>No HP</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="data-customers">
                @php
                    $no = 1
                @endphp
                @foreach ($customers as $c)
                    <tr class="h-[7vh] hover:bg-gray-200">
                        <td class="w-[10vw] border-b border-gray-200">{{ $no++ }}</td>
                        <td class="w-[50vw] border-b border-gray-200">{{ $c->name }}</td>
                        <td class="w-[20vw] border-b border-gray-200">{{ $c->phone_no }}</td>
                        <td class="w-[10vw] border-b border-gray-200">{{ $c->address }}</td>
                        <td class="space-x-3 justify-center items-center px-2 border-b border-gray-200">
                            <button onclick="togglemodal('modal_edit_pelanggan_{{ $c->id }}')" class="px-2 py-1 rounded-md bg-yellow-500 text-[#F6F6F6] hover:opacity-80"><i class="bi bi-pencil-square"></i></button>
                            <button onclick="togglemodal('modal_delete_pelanggan_{{ $c->id }}')" class="px-2 py-1 rounded-md bg-red-500 text-[#F6F6F6] hover:opacity-80"><i class="bi bi-trash"></i></button>
                            <x-modal id="delete_pelanggan_{{ $c->id }}" title="Hapus Pelanggan {{ $c->name }}" class="flex justify-center">
                                <form action="{{ route('api.customer.delete') }}" method="post" class="w-2/4">
                                    @csrf
                                    <input type="hidden" name="id" id="id" value="{{ $c->id }}">
                                    <p class="text-center">Yakin ingin menghapus pelanggan ini?</p>
                                    <p class="text-center text-2xl">{{ $c->name }}</p>
                                    <div class="flex justify-between">
                                        <button type="submit" class="px-2 py-1 rounded-md bg-red-500 text-[#F6F6F6] hover:opacity-80">Ya, Hapus</button>
                                        <button type="reset" onclick="togglemodal('modal_delete_pelanggan_{{ $c->id }}')" class="px-2 py-1 rounded-md bg-gray-500 text-[#F6F6F6] hover:opacity-80">Batalkan</button>
                                    </div>
                                </form>
                            </x-modal>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-base>
@foreach ($customers as $mc)
    <x-modal id="edit_pelanggan_{{ $mc->id }}" title="Edit Pelanggan {{ $mc->name }}">
        <form action="{{ route('api.customer.update') }}" method="post" class="grid gap-5">
            @csrf
            <input type="hidden" name="id" id="id" value="{{ $mc->id }}">
            <div class="flex">
                <div class="w-[15vw] flex items-center">
                    <label for="name" class="w-auto">Nama</label>
                    <span class="w-full h-0 border-b border-dashed mx-1"></span>
                </div>
                <input type="text" name="name" id="name" value="{{ $mc->name }}" required class="rounded-md border px-2 py-1 md:w-[20vw]">
            </div>
            <div class="flex">
                <div class="w-[15vw] flex items-center">
                    <label for="phone_no" class="w-auto">No HP</label>
                    <span class="w-full h-0 border-b border-dashed mx-1"></span>
                </div>
                <input type="text" name="phone_no" id="phone_no" value="{{ $mc->phone_no }}" required class="rounded-md border px-2 py-1 md:w-[20vw]">
            </div>
            <div class="flex">
                <div class="w-[15vw] flex items-center">
                    <label for="address" class="w-auto">Alamat</label>
                    <span class="w-full h-0 border-b border-dashed mx-1"></span>
                </div>
                <textarea name="address" id="address" class="rounded-md border px-2 py-1 md:w-[20vw]">{{ $mc->address }}</textarea>
            </div>
            <button class="rounded-md px-2 py-1 w-full md:w-[35vw] bg-[#2F2F2F] text-[#F6F6F6] hover:scale-102 transition-all">Ubah</button>
        </form>
    </x-modal>
@endforeach
<x-modal id="tambah_pelanggan" title="Tambah Pelanggan">
    <form action="{{ route('api.customer.store') }}" method="post" class="grid gap-5">
        @csrf
        <div class="flex">
            <div class="w-[15vw] flex items-center">
                <label for="name" class="w-auto">Nama</label>
                <span class="w-full h-0 border-b border-dashed mx-1"></span>
            </div>
            <input type="text" name="name" id="name" class="rounded-md border px-2 py-1 md:w-[20vw]" required>
        </div>
        <div class="flex">
            <div class="w-[15vw] flex items-center">
                <label for="phone_no" class="w-auto">No HP</label>
                <span class="w-full h-0 border-b border-dashed mx-1"></span>
            </div>
            <input type="text" name="phone_no" id="phone_no" class="rounded-md border px-2 py-1 md:w-[20vw]" required>
        </div>
        <div class="flex">
            <div class="w-[15vw] flex items-center">
                <label for="address" class="w-auto">Alamat</label>
                <span class="w-full h-0 border-b border-dashed mx-1"></span>
            </div>
            <textarea name="address" id="address" class="rounded-md border px-2 py-1 md:w-[20vw]"></textarea>
        </div>
        <button class="rounded-md px-2 py-1 w-full md:w-[35vw] bg-[#2F2F2F] text-[#F6F6F6] hover:scale-102 transition-all">Tambah</button>
    </form>
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