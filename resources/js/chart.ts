import Chart from "chart.js/auto";

// Daily
const d_ctx = document.getElementById('daily-chart') as HTMLCanvasElement | null;
const daily_labels: string[] = (window as any).daily_labels;
const daily_data: number[]   = (window as any).daily_data;

if (d_ctx) {
    console.log(daily_labels, daily_data);
    new Chart(d_ctx, {
        type: 'bar',
        data: {
            labels: daily_labels,
            datasets: [{
                label: 'Harian',
                data: daily_data,
                backgroundColor: '#FFCB74',
            }]
        }
    });
}

// Weekly
const w_ctx = document.getElementById('weekly-chart') as HTMLCanvasElement | null;
const weekly_labels: string[] = (window as any).weekly_labels;
const weekly_data: number[]   = (window as any).weekly_data;

if (w_ctx) {
    console.log(weekly_labels, weekly_data);
    new Chart(w_ctx, {
        type: 'bar',
        data: {
            labels: weekly_labels,
            datasets: [{
                label: 'Mingguan',
                data: weekly_data,
                backgroundColor: '#FFCB74',
            }]
        }
    });
}

// Monthly
const m_ctx = document.getElementById('monthly-chart') as HTMLCanvasElement | null;
const monthly_labels: string[] = (window as any).monthly_labels;
const monthly_data: number[]   = (window as any).monthly_data;

if (m_ctx) {
    console.log(monthly_labels, monthly_data);
    new Chart(m_ctx, {
        type: 'bar',
        data: {
            labels: monthly_labels,
            datasets: [{
                label: 'Bulanan',
                data: monthly_data,
                backgroundColor: '#FFCB74',
            }]
        }
    });
}
