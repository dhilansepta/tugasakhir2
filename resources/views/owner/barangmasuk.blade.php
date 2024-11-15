@extends('layouts.ownerlayout')

@section('title', 'Barang Masuk')

@section('inventori-link', 'active')

@section('content')
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
        <div class="d-flex flex-row align-items-center justify-content-between">
            <div>
                <h3>Data Barang Masuk</h3>
            </div>
            <div class="d-flex flex-column align-items-end mt-2">
                <div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahBarangMasukModal">
                        Tambah Data
                    </button>
                </div>

                <div class="mt-2">
                    <button
                        type="button"
                        class="btn btn-light ms-auto"
                        style="width: 80px;">
                        Unduh
                    </button>
                </div>
            </div>
        </div>

        @include('layouts.partials.modaladd.barangmasuk')
        @include('layouts.partials.modaldelete.deletebarang')
        @include('layouts.partials.modaledit.barangmasuk')

        <div class="d-flex flex-column bd-highlight bg-secondary rounded p-3 mt-2">
            <div class="d-flex flex-row align-items-end justify-content-between mb-2">
                <div>
                    Data Tanggal
                    <span style="font-weight:bold">
                        {{ request('filterTanggal') ? \Carbon\Carbon::parse(request('filterTanggal'))->format('d M Y') : now()->format('d M Y') }}
                    </span>
                </div>

                <form action="{{ route('owner.barangmasuk') }}" method="GET" class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <input
                            class="form-control form-control-sm me-2"
                            id="filterSearch"
                            type="text"
                            name="filterSearch"
                            placeholder="Cari..."
                            value="{{ request('filterSearch') }}"
                            style="width: 150px; border-color:var(--tertiary)">

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
                        <a href="{{ route('owner.barangmasuk') }}" class="btn btn-danger btn-sm ms-2" style="width: 50px;">
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
                            <th scope="col">Tanggal Masuk</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Kategori Barang</th>
                            <th scope="col">Harga Beli</th>
                            <th scope="col">Jumlah Barang Masuk</th>
                            <th scope="col">Harga Beli Persatuan</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($barangmasuk as $data)
                        <tr>
                            <td>{{$data->id}}</td>
                            <td>{{$data->created_at->format('d M Y')}}</td>
                            <td>{{$data->barang->nama_barang}}</td>
                            <td>{{$data->barang->kategori->kategori}}</td>
                            <td>Rp {{ number_format($data->harga_beli, 0, ',', '.') }}</td>
                            <td>{{$data->jumlah}} {{$data->barang->satuan->satuan}}</td>
                            <td>Rp {{ number_format($data->harga_persatuan, 0, ',', '.') }}</td>
                            <td>
                                @if(!request('filterTanggal') || \Carbon\Carbon::parse(time: request('filterTanggal'))->isToday())
                                <a class="btn btn-sm btn-warning mx-2 btn-edit"
                                    href="#"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editBarangMasukModal"
                                    data-id="{{ $data->id }}"
                                    data-idBarang="{{$data->barang_id}}"
                                    data-nama_barang="{{ $data->barang->nama_barang }}"
                                    data-kategori_barang="{{ $data->barang->kategori->kategori }}"
                                    data-satuan_barang="{{ $data->barang->satuan->satuan}}"
                                    data-harga_beli="{{ $data->harga_beli }}"
                                    data-jumlah="{{ $data->jumlah }}"
                                    data-harga_persatuan="{{ $data->harga_persatuan }}">
                                    Edit
                                </a>
                                <a class="btn btn-sm btn-danger mx-2 btn-delete"
                                    href="#"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteBarangModal"
                                    data-id="{{$data->id}}">
                                    Delete
                                </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center text-mute" colspan="8">Data tidak tersedia</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{$barangmasuk->links()}}
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tangkap semua tombol edit
        var editButtons = document.querySelectorAll('.btn-edit');
        var deleteButtons = document.querySelectorAll('.btn-delete');

        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var dataId = this.getAttribute('data-id');

                // Set action URL untuk form
                var form = document.getElementById('deleteBarangForm');
                form.action = '/delete-barangmasuk/' + dataId;
            });
        });

        editButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var dataId = this.getAttribute('data-id');
                var dataIdBarang = this.getAttribute('data-idBarang');
                var dataNama = this.getAttribute('data-nama_barang');
                var dataKategori = this.getAttribute('data-kategori_barang');
                var dataSatuan = this.getAttribute('data-satuan_barang');
                var dataHargaBeli = this.getAttribute('data-harga_beli');
                var dataJumlah = this.getAttribute('data-jumlah');
                var dataHargaPersatuan = this.getAttribute('data-harga_persatuan');

                // Isi form dengan data
                document.getElementById('edit_namaBarang').value = dataIdBarang;
                document.getElementById('edit_namaBarang').text = dataNama;
                document.getElementById('edit_kategoriBarang').value = dataKategori;
                document.getElementById('edit_satuanBarang').value = dataSatuan;
                document.getElementById('edit_hargaBeli').value = dataHargaBeli;
                document.getElementById('edit_jumlah').value = dataJumlah;
                document.getElementById('edit_hargaBeliSatuan').value = dataHargaPersatuan;

                $(document).ready(function() {
                    $('.editNamaBarangSelect').select2({
                        width: '100%',
                        dropdownParent: $("#editBarangMasukModal"),
                        ajax: {
                            url: "{{ route('selectbarang') }}",
                            dataType: 'json',
                            delay: 250, // Delay for requests to prevent too many requests
                            data: function(params) {
                                return {
                                    q: params.term // Search term
                                };
                            },
                            processResults: function(data) {
                                return {
                                    results: data.results // `results` key should match the key returned by the controller
                                };
                            }
                        }
                    });

                    $('#edit_namaBarang').on('change', function() {
                        let id = $(this).val();

                        if (id) {
                            $.ajax({
                                url: "{{ url('selectbarang') }}/" + id,
                                type: 'GET',
                                dataType: 'json',
                                success: function(data) {
                                    if (data.error) {
                                        alert(data.error);
                                    } else {
                                        $('#edit_kategoriBarang').val(data.kategori);
                                        $('#edit_satuanBarang').val(data.satuan);
                                    }
                                },
                                error: function() {
                                    alert('Failed to fetch data.');
                                }
                            });
                        } else {
                            $('#edit_kategoriBarang').val('');
                            $('#edit_satuanBarang').val('');
                        }
                    });
                });

                // Set action URL untuk form
                var form = document.getElementById('editBarangMasukForm');
                form.action = '/edit-barangmasuk/' + dataId;
            });
        });
    });
</script>
@endsection