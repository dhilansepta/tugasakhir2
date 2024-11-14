@extends('layouts.ownerlayout')

@section('title', 'Daftar Barang')

@section('inventori-link', 'active')

@section('content')
<?php $downloadUrl = route('export-barang'); ?>
<div class="container-fluid pt-4 px-4">
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <div class="g-4">
        <div class="d-flex flex-row align-items-center justify-content-between">
            <h3 id="judul">Data Barang</h3>
            <div class="d-flex flex-column align-items-end justify-content-start">
                <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#tambahBarangModal">
                    Tambah Barang
                </button>
                <button class="btn btn-light mb-2" onclick="window.location.href='<?= $downloadUrl ?>';">
                    Unduh Template Excel
                </button>
                <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#importExcelModal">
                    Import Excel
                </button>
            </div>
        </div>

        @include('layouts.partials.modaladd.daftarbarang')
        @include('layouts.partials.modaledit.daftarbarang')
        @include('layouts.partials.modaladd.importbarang')

        <div class="d-flex flex-column bd-highlight bg-secondary rounded p-3 mt-2">
            <div class="d-flex flex-row align-items-end justify-content-end mb-2">
                <form action="{{ route('owner.daftarbarang') }}" method="GET" class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <select name="sort_by" class="form-select form-select-sm me-2" style="width: 150px; border-color:var(--tertiary)" onchange="this.form.submit()">
                            <option value="" disabled selected>Sort By</option>
                            <option value="id" {{ request('sort_by') === 'id' ? 'selected' : '' }}>ID</option>
                            <option value="stok" {{ request('sort_by') === 'stok' ? 'selected' : '' }}>Sisa Stok</option>
                        </select>
                    </div>

                    <div class="d-flex align-items-center">
                        <input
                            class="form-control form-control-sm me-2"
                            id="filterSearch"
                            type="text"
                            name="filterSearch"
                            placeholder="Cari Nama Barang"
                            value="{{ request('filterSearch') }}"
                            style="width: 150px; border-color:var(--tertiary)">

                        <button
                            type="submit"
                            class="btn btn-primary btn-sm"
                            style="width: 50px;">
                            Cari
                        </button>

                        <a href="{{ route('owner.daftarbarang') }}" class="btn btn-danger btn-sm ms-2" style="width: 50px;">
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
                            <th scope="col">Kategori</th>
                            <th scope="col">Harga Beli</th>
                            <th scope="col">Harga Jual</th>
                            <th scope="col">Keuntungan</th>
                            <th scope="col">Sisa Stok</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($barang as $data)
                        <tr>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->nama_barang }}</td>
                            <td>{{ $data->kategori->kategori }}</td>
                            <td>Rp {{ number_format($data->harga_beli, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($data->harga_jual, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($data->keuntungan, 0, ',', '.') }}</td>
                            <td>{{ $data->stok }} {{ $data->satuan->satuan }}</td>
                            <td>
                                <a class="btn btn-sm btn-warning mx-2 btn-edit"
                                    href="#"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editBarangModal"
                                    data-id="{{ $data->id }}"
                                    data-nama_barang="{{ $data->nama_barang }}"
                                    data-kategori_id="{{ $data->kategori_id}}"
                                    data-satuan_id="{{ $data->satuan_id }}"
                                    data-harga_beli="{{ $data->harga_beli }}"
                                    data-harga_jual="{{ $data->harga_jual }}"
                                    data-keuntungan="{{ $data->keuntungan }}"
                                    data-stok="{{ $data->stok }}">
                                    Edit
                                </a>
                                <a class="btn btn-sm btn-danger mx-2 btn-delete">
                                    Delete
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center text-mute" colspan="10">Data Barang tidak tersedia</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{$barang->links()}}
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
                var dataNama = this.getAttribute('data-nama_barang');
                var dataKategori = this.getAttribute('data-kategori_id');
                var dataSatuan = this.getAttribute('data-satuan_id');
                var dataHargaBeli = this.getAttribute('data-harga_beli');
                var dataHargaJual = this.getAttribute('data-harga_jual');
                var dataKeuntungan = this.getAttribute('data-keuntungan');

                // Isi form dengan data
                document.getElementById('edit_nama_barang').value = dataNama;
                document.getElementById('edit_kategori_id').value = dataKategori;
                document.getElementById('edit_satuan_id').value = dataSatuan;
                document.getElementById('edit_harga_beli').value = dataHargaBeli;
                document.getElementById('edit_harga_jual').value = dataHargaJual;
                document.getElementById('edit_keuntungan').value = dataKeuntungan;

                hitungKeuntungan();

                // Set action URL untuk form
                var form = document.getElementById('editBarangForm');
                form.action = '/edit-daftarbarang/' + dataId;
            });
        });

        const hargaBeliInput = document.getElementById('edit_harga_beli');
        const hargaJualInput = document.getElementById('edit_harga_jual');
        const keuntunganInput = document.getElementById('edit_keuntungan');

        function hitungKeuntungan() {
            const hargaBeli = parseInt(hargaBeliInput.value) || 0;
            const hargaJual = parseInt(hargaJualInput.value) || 0;
            const keuntungan = hargaJual - hargaBeli;
            keuntunganInput.value = keuntungan;
        }

        hargaBeliInput.addEventListener('input', hitungKeuntungan);
        hargaJualInput.addEventListener('input', hitungKeuntungan);
    });
</script>
@endsection