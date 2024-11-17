@extends('layouts.ownerlayout')

@section('title', 'Owner Dashboard')

@section('dashboard-link', 'active')

@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @elseif (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <!-- Revenue Cards -->
        <div class="col-12 col-sm-6 col-md-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4 h-100">
                <i class="fa fa-chart-line fa-3x text-primary"></i>
                <div class="ms-3 text-end">
                    <p class="mb-2">Pendapatan Kotor</p>
                    <h6 class="mb-0">Rp {{ number_format($pendapatanKotor, 0, ',', '.') }}</h6>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4 h-100">
                <i class="fa fa-chart-bar fa-3x text-primary"></i>
                <div class="ms-3 text-end">
                    <p class="mb-2">Pendapatan Sebenarnya</p>
                    <h6 class="mb-0">Rp {{ number_format($pendapatanSebenarnya, 0, ',', '.') }}</h6>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4 h-100">
                <i class="fa fa-area-chart fa-3x text-primary"></i>
                <div class="ms-3 text-end">
                    <p class="mb-2">Pendapatan Bersih</p>
                    <h6 class="mb-0">Rp {{ number_format($pendapatanBersih, 0, ',', '.') }}</h6>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4 h-100">
                <i class="fa-solid fa-user fa-3x text-primary"></i>
                <div class="ms-3 text-end">
                    <p class="mb-2">Jumlah Akun Karyawan</p>
                    <h6 class="mb-0">{{ $totalKaryawan }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sales Chart -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12 col-xl-7">
            <div class="bg-secondary text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Penjualan</h6>
                    <a href="{{ route('owner.penjualan') }}">Lihat Laporan Penjualan</a>
                </div>
                <p id="penjualan-message" class="text-danger" style="display: none;">Data Tidak Tersedia</p>
                <canvas id="laporan-penjualan"></canvas>
            </div>
        </div>
        <div class="col-12 col-xl-5">
            <div class="bg-secondary text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="mb-0">Stok Telur Ayam</h6>
                    <a href="{{ route('owner.stokbarang') }}">Lihat Laporan Stok Barang</a>
                </div>
                <p id="stok-message" class="text-danger" style="display: none;">Data Tidak Tersedia</p>
                <canvas id="stok-telur"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $.ajax({
            url: "/data-dashboard",
            method: "GET",
            success: function(response) {
                // Stok Telur Chart
                if (response.labelsStok && response.labelsStok.length > 0 && response.stokKeluar.length > 0 && response.sisaStok.length > 0) {
                    var ctxStok = $("#stok-telur").get(0).getContext("2d");
                    var stokChart = new Chart(ctxStok, {
                        type: "line",
                        data: {
                            labels: response.labelsStok,
                            datasets: [{
                                    label: "Stok Keluar",
                                    data: response.stokKeluar,
                                    backgroundColor: "rgba(235, 22, 22, .7)",
                                    fill: true
                                },
                                {
                                    label: "Sisa Stok",
                                    data: response.sisaStok,
                                    backgroundColor: "rgba(235, 22, 22, .5)",
                                    fill: true
                                }
                            ]
                        },
                        options: {
                            responsive: true
                        }
                    });
                } else {
                    $("#stok-message").show();
                    $("#stok-telur").hide();
                }

                // Laporan Penjualan Chart
                if (response.labelsPenjualan && response.labelsPenjualan.length > 0 && response.pendapatanKotor.length > 0 && response.pendapatanSebenarnya.length > 0 && response.pendapatanBersih.length > 0) {
                    var ctxPenjualan = $("#laporan-penjualan").get(0).getContext("2d");
                    var penjualanChart = new Chart(ctxPenjualan, {
                        type: "bar",
                        data: {
                            labels: response.labelsPenjualan,
                            datasets: [{
                                    label: "Pendapatan Kotor",
                                    data: response.pendapatanKotor,
                                    backgroundColor: "rgba(235, 22, 22, .7)",
                                },
                                {
                                    label: "Pendapatan Sebenarnya",
                                    data: response.pendapatanSebenarnya,
                                    backgroundColor: "rgba(235, 22, 22, .5)",
                                },
                                {
                                    label: "Pendapatan Bersih",
                                    data: response.pendapatanBersih,
                                    backgroundColor: "rgba(235, 22, 22, .3)",
                                }
                            ]
                        },
                        options: {
                            responsive: true
                        }
                    });
                } else {
                    $("#penjualan-message").show();
                    $("#laporan-penjualan").hide();
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching data:", error);
                $("#penjualan-message, #stok-message").text("Data Tidak Tersedia").show();
                $("#laporan-penjualan, #stok-telur").hide();
            }
        });
    });
</script>
@endsection