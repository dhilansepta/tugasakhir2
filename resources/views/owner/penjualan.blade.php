@extends('layouts.ownerlayout')

@section('title', 'Penjualan')

@section('laporan-link', 'active')

@section('content')
<?php $downloadUrl = route('downloadLaporanPenjualan'); ?>
<div class="container-fluid pt-4 px-4">
    <div class="g-4">
        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @elseif (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <div class="d-flex flex-row align-items-end justify-content-between">
            <h3 id="judul">Laporan Penjualan</h3>
        </div>

        <div class="d-flex flex-row align-items-center justify-content-between mt-2">
            <button
                type="button"
                class="btn btn-light ms-auto"
                style="width: 80px;"
                onclick="window.location.href='<?= $downloadUrl ?>';">
                Unduh
            </button>
        </div>

        <div class="d-flex flex-column bd-highlight bg-secondary rounded p-3 mt-2">
            <div>
                Laporan Tanggal
                <span style="font-weight:bold">
                    {{ request('filterTanggal') ? \Carbon\Carbon::parse(request('filterTanggal'))->format('d M Y') : now()->format('d M Y') }}
                </span>
            </div>

            <div class="d-flex flex-row align-items-end justify-content-end mb-2">
                <form action="{{ route('owner.penjualan') }}" method="GET" class="d-flex flex-wrap align-items-center gap-2">
                    <div class="form-group mb-0">
                        <select name="sort_by" class="form-select form-select-sm me-2" style="min-width: 120px; border-color:var(--tertiary)" onchange="this.form.submit()">
                            <option value="" disabled selected>Sort By</option>
                            <option value="id" {{ request('sort_by') === 'id' ? 'selected' : '' }}>ID</option>
                            <option value="pendapatan_kotor" {{ request('sort_by') === 'pendapatan_kotor' ? 'selected' : '' }}>Pendapatan Kotor</option>
                        </select>
                    </div>

                    <div class="form-group mb-0">
                        <input
                            class="form-control form-control-sm me-2"
                            id="filterSearch"
                            type="text"
                            name="filterSearch"
                            placeholder="Cari Nama Barang"
                            value="{{ request('filterSearch') }}"
                            style="min-width: 150px; border-color:var(--tertiary)">
                    </div>

                    <div class="form-group mb-0">
                        <input
                            class="form-control form-control-sm me-2"
                            id="filterTanggal"
                            type="date"
                            name="filterTanggal"
                            value="{{ request('filterTanggal') }}"
                            style="min-width: 150px; border-color:var(--tertiary)">
                    </div>

                    <div class="form-group mb-0">
                        <button
                            type="submit"
                            class="btn btn-primary btn-sm"
                            style="min-width: 50px;">
                            Cari
                        </button>
                        <a href="{{ route('owner.penjualan') }}" class="btn btn-danger btn-sm ms-2" style="width: 50px;">
                            Clear
                        </a>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Harga Jual</th>
                            <th scope="col">Satuan</th>
                            <th scope="col">Terjual</th>
                            <th scope="col">Stok Minus</th>
                            <th scope="col">Pendapatan Kotor</th>
                            <th scope="col">Kerugian</th>
                            <th scope="col">Pendapatan Sebenarnya</th>
                            <th scope="col">Pendapatan Bersih</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($laporanPenjualan as $laporan)
                        <tr>
                            <td>{{ $laporan->laporanstok->barang->id }}</td>
                            <td>{{ $laporan->laporanstok->barang->nama_barang }}</td>
                            <td>Rp {{ number_format($laporan->harga_jual, 0, ',', '.') }}</td>
                            <td>{{ $laporan->laporanstok->barang->satuan->satuan }}</td>
                            <td>{{ $laporan->laporanstok->stok_keluar }}</td>
                            <td>{{ $laporan->laporanstok->stok_minus }}</td>
                            <td>Rp {{ number_format($laporan->pendapatan_kotor, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($laporan->kerugian, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($laporan->pendapatan_sebenarnya, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($laporan->keuntungan, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center text-mute" colspan="10">Data tidak tersedia</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{$laporanPenjualan->links()}}
            </div>
        </div>
    </div>
</div>
@endsection