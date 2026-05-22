<x-base title="Pendapatan Toko">
    <script>
        window.daily_labels = {!! json_encode($daily_labels) !!};
        window.daily_data   = {!! json_encode($daily_data) !!};
        window.weekly_labels = {!! json_encode($weekly_labels) !!};
        window.weekly_data   = {!! json_encode($weekly_data) !!};
        window.monthly_labels = {!! json_encode($monthly_labels) !!};
        window.monthly_data   = {!! json_encode($monthly_data) !!};
    </script>
    @vite(['resources/js/chart.ts'])
    <div class="w-full h-[90vh] grid grid-cols-10 gap-10">
        <div class="col-span-5 grid gap-1 p-2">
            <p>Penjualan Harian</p>
            <canvas id="daily-chart"></canvas>
        </div>
        <div class="col-span-5 grid gap-1 p-2">
            <p>Penjualan Mingguan</p>
            <canvas id="weekly-chart"></canvas>
        </div>
        <div class="col-span-5 grid gap-1 p-2">
            <p>Penjualan Bulanan</p>
            <canvas id="monthly-chart"></canvas>
        </div>
    </div>
</x-base>
