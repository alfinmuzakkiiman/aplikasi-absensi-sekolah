@extends('layouts.app')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard Absensi</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-download fa-sm text-white-50"></i> Export Laporan
    </a>
</div>

<!-- Content Row -->
<div class="row">

    <!-- Total Siswa -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Siswa</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalStudents">0</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Siswa Hadir -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Siswa Hadir</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="hadirCount">0</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Persentase Kehadiran -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Persentase Kehadiran</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="presentPercentage">0%</div>
                        <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-info" id="presentBar" style="width: 0%"></div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Izin / Sakit / Alpha -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Izin / Sakit / Alpha</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="otherCount">0</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Grafik -->
<div class="row">

    <!-- Grafik Area -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Statistik Kehadiran</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Distribusi Kehadiran</h6>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                </div>
                <div class="mt-4 text-center small">
                    <span class="mr-2"><i class="fas fa-circle text-primary"></i> Hadir</span>
                    <span class="mr-2"><i class="fas fa-circle text-warning"></i> Izin</span>
                    <span class="mr-2"><i class="fas fa-circle text-info"></i> Sakit</span>
                    <span class="mr-2"><i class="fas fa-circle text-danger"></i> Alpha</span>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script src="{{ asset('template/vendor/chart.js/Chart.min.js') }}"></script>

<script>
var ctxLine = document.getElementById("myAreaChart");
var ctxPie = document.getElementById("myPieChart");

// Inisialisasi chart kosong
var areaChart = new Chart(ctxLine, {
    type: 'line',
    data: {
        labels: ["Hadir", "Izin", "Sakit", "Alpha"],
        datasets: [{
            label: "Jumlah Siswa",
            data: [0, 0, 0, 0],
            backgroundColor: "rgba(78,115,223,0.05)",
            borderColor: "rgba(78,115,223,1)",
            fill: false
        }]
    },
    options: {
        indexAxis: 'y',
        maintainAspectRatio: false,
        scales: {
            x: { beginAtZero: true }
        }
    }
});

var pieChart = new Chart(ctxPie, {
    type: 'doughnut',
    data: {
        labels: ["Hadir", "Izin", "Sakit", "Alpha"],
        datasets: [{
            data: [0, 0, 0, 0],
            backgroundColor: ["#4e73df", "#f6c23e", "#36b9cc", "#e74a3b"]
        }]
    },
    options: {
        maintainAspectRatio: false,
        plugins: { legend: { display: false } }
    }
});

// Fungsi update chart & stats
function updateDashboard() {
    fetch('{{ route("dashboard") }}')
        .then(res => res.json())
        .then(data => {
            // Update angka
            document.getElementById('totalStudents').innerText = data.total;
            document.getElementById('hadirCount').innerText = data.hadir;
            document.getElementById('otherCount').innerText = data.izin + data.sakit + data.alpha;
            let percentage = data.total > 0 ? Math.round((data.hadir / data.total) * 100) : 0;
            document.getElementById('presentPercentage').innerText = percentage + '%';
            document.getElementById('presentBar').style.width = percentage + '%';

            // Update line chart
            areaChart.data.datasets[0].data = [data.hadir, data.izin, data.sakit, data.alpha];
            areaChart.update();

            // Update pie chart
            pieChart.data.datasets[0].data = [data.hadir, data.izin, data.sakit, data.alpha];
            pieChart.update();
        });
}

// Auto update setiap 3 detik
setInterval(updateDashboard, 3000);
updateDashboard(); // panggil sekali saat load
</script>
@endsection
