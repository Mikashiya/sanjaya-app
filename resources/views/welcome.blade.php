<x-base>
    <form action="{{ route('api.login') }}" method="post" class="space-y-6">
        @csrf
        <div class="grid">
            <label for="name">Nama Pengguna</label>
            <input type="text" name="name" id="name" class="rounded-full border px-2 py-1 md:w-[20vw]">
        </div>
        <div class="grid">
            <label for="password">Kata Sandi</label>
            <input type="password" name="password" id="password" class="rounded-full border px-2 py-1 md:w-[20vw]">
        </div>
        <button type="submit" class="rounded-full px-2 py-1 w-full md:w-[20vw] bg-[#2F2F2F] text-[#F6F6F6] hover:scale-105 transition-all">Login</button>
    </form>
</x-base>
