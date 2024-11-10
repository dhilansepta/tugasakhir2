@extends('layouts.ownerlayout')

@section('title', 'Owner Dashboard')

@section('dashboard-link', 'active')

@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4" style="height:120px;">
                <i class="fa fa-chart-line fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Pendapatan Kotor</p>
                    <h6 class="mb-0">Rp {{ number_format($pendapatanKotor, 0, ',', '.') }} </h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4" style="height:120px;">
                <i class="fa fa-chart-bar fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Pendapatan Sebenarnya</p>
                    <h6 class="mb-0">Rp {{ number_format($pendapatanSebenarnya, 0, ',', '.') }}</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4" style="height:120px;">
                <i class="fa fa-area-chart fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Pendapatan Bersih</p>
                    <h6 class="mb-0">Rp {{ number_format($pendapatanBersih, 0, ',', '.') }}</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4" style="height:120px;">
                <i class="fa-solid fa-user fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Jumlah Akun Karyawan</p>
                    <h6 class="mb-0">{{$totalKaryawan}}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Sale & Revenue End -->

<!-- Sales Chart Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-7">
            <div class="bg-secondary text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Penjualan</h6>
                    <a href="{{route('owner.penjualan')}}">Lihat Laporan Penjualan</a>
                </div>
                <canvas id="laporan-penjualan"></canvas>
            </div>
        </div>
        <div class="col-sm-12 col-xl-5">
            <div class="bg-secondary text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Stok Telur</h6>
                    <a href="{{route('owner.stokbarang')}}">Lihat Laporan Stok Barang</a>
                </div>
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
                var ctx2 = $("#stok-telur").get(0).getContext("2d");
                var myChart2 = new Chart(ctx2, {
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

                var ctx2 = $("#laporan-penjualan").get(0).getContext("2d");
                var myChart2 = new Chart(ctx2, {
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
            },
            error: function(xhr, status, error) {
                console.error("Error fetching data:", error);
            }
        });
    });
</script>
@endsection