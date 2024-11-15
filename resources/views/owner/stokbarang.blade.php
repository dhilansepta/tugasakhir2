@extends('layouts.ownerlayout')

@section('title', 'Stok Barang')

@section('laporan-link', 'active')

@section('content')
<?php $downloadUrl = route('downloadLaporanStok'); ?>
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
            <h3 id="judul">Laporan Stok Barang</h3>
        </div>

        @include('layouts.partials.modaledit.stokbarang')

        <div class="d-flex flex-row align-items-center justify-content-between mt-2">
            <button
                type="button"
                class="btn btn-light ms-auto"
                style="width: 80px;"
                onclick="window.location.href='<?= $downloadUrl ?>';">
                Unduh
            </button>
            </form>
        </div>


        <div class="d-flex flex-column bd-highlight bg-secondary rounded p-3 mt-2">
            <div class="d-flex flex-row align-items-end justify-content-between mb-2">
                <div>
                    Laporan Tanggal
                    <span style="font-weight:bold">
                        {{ request('filterTanggal') ? \Carbon\Carbon::parse(request('filterTanggal'))->format('d M Y') : now()->format('d M Y') }}
                    </span>
                </div>

                <form action="{{ route('owner.stokbarang') }}" method="GET" class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <input
                            class="form-control form-control-sm me-2"
                            id="filterSearch"
                            type="text"
                            name="filterSearch"
                            placeholder="Cari Nama Barang"
                            value="{{ request('filterSearch') }}"
                            style="width: 150px; border-color:var(--tertiary)">

                        <select name="sort_by" class="form-select form-select-sm me-2" style="width: 150px; border-color:var(--tertiary)" onchange="this.form.submit()">
                            <option value="" disabled selected>Sort By</option>
                            <option value="id" {{ request('sort_by') === 'id' ? 'selected' : '' }}>ID</option>
                            <option value="stok_minus" {{ request('sort_by') === 'stok_minus' ? 'selected' : '' }}>Stok Minus</option>
                            <option value="stok_keluar" {{ request('sort_by') === 'stok_keluar' ? 'selected' : '' }}>Stok Keluar</option>
                            <option value="stok_masuk" {{ request('sort_by') === 'stok_masuk' ? 'selected' : '' }}>Stok Masuk</option>
                        </select>

                        <input
                            class="form-control form-control-sm me-2"
                            id="filterTanggal"
                            type="date"
                            name="filterTanggal"
                            value="{{ request('filterTanggal') }}"
                            style="width: 150px; border-color:var(--tertiary)">

                        <button
                            type="submit"
                            class="btn btn-primary btn-sm"
                            style="width: 50px;">
                            Cari
                        </button>
                        <a href="{{ route('owner.stokbarang') }}" class="btn btn-danger btn-sm ms-2" style="width: 50px;">
                            Clear
                        </a>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID Barang</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Satuan</th>
                            <th scope="col">Stok Awal</th>
                            <th scope="col">In</th>
                            <th scope="col">Out</th>
                            <th scope="col">Stok Akhir</th>
                            <th scope="col">Barang Retur</th>
                            <th scope="col">Stok Di Gudang</th>
                            <th scope="col">Stok Minus</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($laporanStok as $laporan)
                        <tr>
                            <td>{{ $laporan->barang->id }}</td>
                            <td>{{ $laporan->barang->nama_barang }}</td>
                            <td>{{ $laporan->barang->satuan->satuan }}</td>
                            <td>{{ $laporan->stok_awal }}</td>
                            <td>{{ $laporan->stok_masuk }}</td>
                            <td>{{ $laporan->stok_keluar }}</td>
                            <td>{{ $laporan->stok_akhir }}</td>
                            <td>{{ $totalRetur[$laporan->barang_id] ?? 0 }}</td>
                            <td>{{ $laporan->stok_gudang }}</td>
                            <td>{{ $laporan->stok_minus }}</td>
                            <td>
                                @if(!request('filterTanggal') || \Carbon\Carbon::parse(time: request('filterTanggal'))->isToday())
                                <a class="btn btn-sm btn-warning mx-2 btn-edit"
                                    href="#"
                                    data-bs-toggle="modal"
                                    data-bs-target="#cekFisikModal"
                                    data-id="{{ $laporan->id }}"
                                    data-stokGudang="{{ $laporan->stok_gudang }}">
                                    Cek Fisik
                                </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center text-mute" colspan="11">Data tidak tersedia</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{$laporanStok->links()}}
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tangkap semua tombol edit
        var editButtons = document.querySelectorAll('.btn-edit');

        editButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var dataId = this.getAttribute('data-id');
                var dataStokGudang = this.getAttribute('data-stokGudang');

                // Isi form dengan data user
                document.getElementById('edit_stokGudang').value = dataStokGudang;

                // Set action URL untuk form
                var form = document.getElementById('cekFisikForm');
                form.action = '/edit-stokbarang/' + dataId;
            });
        });
    });
</script>

@endsection