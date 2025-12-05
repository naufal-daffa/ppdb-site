@extends('admin.templates.app')

@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('success') }} <b>Selamat Datang, {{ Auth::user()->nama }}</b>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- CARD STATISTIK -->
    <div class="row mt-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pendaftar
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalPendaftar">{{ $totalApplicants }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Diterima
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalDiterima">{{ $totalDiterima }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Menunggu
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalMenunggu">{{ $totalMenunggu }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Ditolak
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalDitolak">{{ $totalDitolak }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CHART -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Status Pendaftaran Peserta</h5>
                </div>
                <div class="card-body">
                    @if($totalApplicants == 0)
                        <div class="text-center py-5">
                            <i class="fas fa-chart-pie fa-4x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data pendaftaran</p>
                        </div>
                    @else
                        <div style="height: 320px; position: relative;">
                            <canvas id="pieStatus"></canvas>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Pendaftar per Gelombang</h5>
                </div>
                <div class="card-body">
                    @if(empty($gelombang))
                        <div class="text-center py-5">
                            <i class="fas fa-chart-bar fa-4x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data gelombang</p>
                        </div>
                    @else
                        <div style="height: 320px; position: relative;">
                            <canvas id="barGelombang"></canvas>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Pilihan Jurusan Prioritas 1</h5>
                </div>
                <div class="card-body">
                    @if(empty($jurusanPertama))
                        <div class="text-center py-5">
                            <i class="fas fa-graduation-cap fa-4x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data pilihan jurusan</p>
                        </div>
                    @else
                        <div style="height: 400px; position: relative;">
                            <canvas id="barJurusan"></canvas>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .card {
        border-radius: 10px;
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-2px);
    }
    .card-header {
        border-radius: 10px 10px 0 0 !important;
    }
    .border-left-primary {
        border-left: 4px solid #4e73df !important;
    }
    .border-left-success {
        border-left: 4px solid #1cc88a !important;
    }
    .border-left-warning {
        border-left: 4px solid #f6c23e !important;
    }
    .border-left-danger {
        border-left: 4px solid #e74a3b !important;
    }
</style>
@endpush

@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(function() {
        function refreshStatistics() {
            $.ajax({
                url: "{{ route('admin.dashboard.statistics') }}",
                method: "GET",
                success: function(res) {
                    $('#totalPendaftar').text(res.total);
                    $('#totalDiterima').text(res.diterima);
                    $('#totalMenunggu').text(res.menunggu);
                    $('#totalDitolak').text(res.ditolak);
                    $('#totalDiverifikasi').text(res.diverifikasi);
                }
            });
        }


        refreshStatistics();
        setInterval(refreshStatistics, 30000);

        $.ajax({
            url: "{{ route('admin.dashboard.chart.status') }}",
            method: "GET",
            success: function(res) {
                let labels = res.labels;
                let data = res.data;
                let colors = res.colors;

                new Chart($('#pieStatus')[0], {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Pendaftar',
                            data: data,
                            backgroundColor: colors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true,
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.label || '';
                                        let value = context.raw || 0;
                                        let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        let percentage = Math.round((value / total) * 100);
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            },
            error: function(err) {
                console.log('Gagal memuat data status');
            }
        });

        $.ajax({
            url: "{{ route('admin.dashboard.chart.gelombang') }}",
            method: "GET",
            success: function(res) {
                let labels = res.labels;
                let data = res.data;
                let colors = res.colors;

                new Chart($('#barGelombang')[0], {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Pendaftar',
                            data: data,
                            backgroundColor: colors,
                            borderColor: colors.map(color => color.replace('0.8', '1')),
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    precision: 0
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return `Pendaftar: ${context.raw}`;
                                    }
                                }
                            }
                        }
                    }
                });
            },
            error: function(err) {
                console.log('Gagal memuat data gelombang');
            }
        });

        // Optional: Load Bar Chart for Jurusan
        $.ajax({
            url: "{{ route('admin.dashboard.chart.jurusan') }}",
            method: "GET",
            success: function(res) {
                if(res.labels.length > 0) {
                    let labels = res.labels;
                    let data = res.data;
                    let colors = res.colors;

                    new Chart($('#barJurusan')[0], {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Jumlah Pendaftar',
                                data: data,
                                backgroundColor: colors,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            indexAxis: 'y',
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                x: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1,
                                        precision: 0
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }
                        }
                    });
                }
            },
            error: function(err) {
                console.log('Gagal memuat data jurusan');
            }
        });
    });
</script>
@endpush
