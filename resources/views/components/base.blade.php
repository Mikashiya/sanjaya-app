<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>
            @if (request()->is('/'))
                sanjaya-app
            @else
                @if (Auth::check())
                    {{ $title }}
                @else
                Pengguna Tidak Terautentikasi | sanjaya-app
                @endif
            @endif
        </title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    @if (request()->is('/'))
        <body class="py-3 flex flex-col justify-between gap-30">
            <header class="md:w-3/4 h-[10vh] self-center bg-[#2F2F2F] text-[#F6F6F6] rounded-full flex items-center px-5">
                <p class="uppercase font-bold text-3xl">sanjaya-app</p>
            </header>
            <main class="w-auto h-auto self-center shadow-xl rounded-xl p-3">
                {{ $slot }}
                @if($errors->any())
                    <div class="mt-10 flex items-center justify-center bg-[#F6F6F6]">
                        <ul>
                            @foreach ($errors->all() as $err)
                                <li class="text-red-500">{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </main>
        </body>
    @else
        @if (Auth::check())
            <body> 
                <header class="w-full h-[10vh] shadow-md bg-[#2F2F2F] text-[#F6F6F6] px-2 flex justify-between items-center">
                    <ul id="links-header" class="flex gap-3"></ul>
                    <form action="{{ route('api.logout') }}" method="post">
                        @csrf
                        <button type="submit" class="px-2 py-1 bg-red-500 rounded-md hover:opacity-80">Logout</button>
                    </form>
                </header>
                <main class="w-full h-[90vh] {{ $class ?? '' }}">
                    {{ $slot }}
                </main>
            </body>
            <script>
                links = [
                    {href: '/beranda', title: 'Beranda'},
                    {href: '/produk', title: 'Produk'},
                    {href: '/penjualan', title: 'Penjualan'},
                    {href: '/pelanggan', title: 'Pelanggan'},
                ]

                window.userAccessLevel = {{ Auth::check() ? Auth::user()->access_level : 0 }}

                if (window.userAccessLevel > 1) {
                    links.push (
                        {href: '/pendapatan', title: 'Pendapatan'},
                    )
                }

                const currentPath = window.location.pathname
                document.getElementById('links-header').innerHTML = links.map(link => {
                    const isActive = currentPath === link.href
                    return `
                        <li><a href="${link.href}" class="hover:opacity-80 transition-all ${isActive ? 'text-[#FFCB74] font-bold' : ''}">
                            ${link.title}
                        </a></li>
                    `
                }).join('')
            </script>
        @else
            <body>
                <div class="w-full h-screen flex items-center justify-center bg-[#2F2F2F]">
                    <p class="text-red-500 uppercase">tidak terautentikasi</p>
                </div>
            </body>
        @endif
    @endif
</html>