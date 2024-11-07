@extends('layouts.ownerlayout')

@section('title', 'Retur Barang')

@section('inventori-link', 'active')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="g-4">
        <div class="d-flex flex-row align-items-center justify-content-between">
            <div>
                <h3>Data Retur Barang</h3>
            </div>
            <div class="d-flex flex-column align-items-end mt-2">
                <div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahReturBarangModal">
                        Tambah Data
                    </button>
                </div>
            </div>
        </div>

        @include('layouts.partials.modaladd.returbarang')
        @include('layouts.partials.modaldelete.deletebarang')
        @include('layouts.partials.modaledit.returbarang')

        <div class="d-flex flex-column bd-highlight bg-secondary rounded p-3 mt-3">
            <div class="d-flex flex-row align-items-end justify-content-end mb-2">
                <form action="{{ route('owner.returbarang') }}" method="GET" class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <select name="filterShow" class="form-select form-select-sm me-2" style="width: 200px; border-color:var(--tertiary)" onchange="this.form.submit()">
                            <option value="" disabled selected>Jenis Status</option>
                            <option value="expired" {{ request('filterShow') === 'expired' ? 'selected' : '' }}>Expired</option>
                            <option value="rusak" {{ request('filterShow') === 'rusak' ? 'selected' : '' }}>Rusak</option>
                            <option value="dikembalikan" {{ request('filterShow') === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                        </select>
                    </div>

                    <div class="d-flex align-items-center">
                        <input
                            class="form-control form-control-sm me-2"
                            id="filterSearch"
                            type="text"
                            name="filterSearch"
                            placeholder="Cari..."
                            value="{{ request('filterSearch') }}"
                            style="width: 150px; border-color:var(--tertiary)">

                        <button
                            type="submit"
                            class="btn btn-primary btn-sm"
                            style="width: 50px;">
                            Cari
                        </button>

                        <a href="{{ route('owner.returbarang') }}" class="btn btn-danger btn-sm ms-2" style="width: 50px;">
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
                            <th scope="col">Kategori</th>
                            <th scope="col">Jumlah Barang Retur</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($returBarang as $data)
                        <tr>
                            <td>{{ $data->barang_id }}</td>
                            <td>{{ $data->barang->nama_barang }}</td>
                            <td>{{ $data->barang->kategori->kategori }}</td>
                            <td>{{ $data->jumlah}} {{$data->barang->satuan->satuan}}</td>
                            <td>
                                <span class="badge {{ $data->status == 'dikembalikan' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $data->status == 'dikembalikan' ? 'Dikembalikan' : ($data->status == 'expired' ? 'Expired' : 'Rusak') }}
                                </span>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-warning mx-2 btn-edit"
                                    href="#"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editReturBarangModal"
                                    data-id="{{ $data->id }}"
                                    data-barang_id="{{ $data->barang_id}}"
                                    data-nama_barang="{{ $data->barang->nama_barang }}"
                                    data-kategori_barang="{{ $data->barang->kategori->kategori }}"
                                    data-satuan_barang="{{ $data->barang->satuan->satuan}}"
                                    data-jumlah="{{ $data->jumlah }}"
                                    data-status="{{ $data->status }}">
                                    Edit
                                </a>
                                <a class="btn btn-sm btn-danger mx-2 btn-delete"
                                    href="#"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteBarangModal"
                                    data-id="{{$data->id}}">
                                    Delete
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center text-mute" colspan="7">Data Barang tidak tersedia</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
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
                form.action = '/delete-returbarang/' + dataId;
            });
        });

        editButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var dataId = this.getAttribute('data-id');
                var dataIdBarang = this.getAttribute('data-barang_id');
                var dataNama = this.getAttribute('data-nama_barang');
                var dataKategori = this.getAttribute('data-kategori_barang');
                var dataSatuan = this.getAttribute('data-satuan_barang');
                var dataJumlah = this.getAttribute('data-jumlah');
                var dataStatus = this.getAttribute('data-status');

                // Isi form dengan data
                document.getElementById('edit_namaBarang').value = dataIdBarang;
                document.getElementById('edit_namaBarang').text = dataNama;
                document.getElementById('edit_kategoriBarang').value = dataKategori;
                document.getElementById('edit_satuanBarang').value = dataSatuan;
                document.getElementById('edit_jumlah').value = dataJumlah;
                document.getElementById('edit_status').value = dataStatus;

                $(document).ready(function() {
                    $('.editNamaBarangSelect').select2({
                        width: '100%',
                        dropdownParent: $("#editReturBarangModal"),
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
                var form = document.getElementById('editReturBarangForm');
                form.action = '/edit-returbarang/' + dataId;
            });
        });
    });
</script>
@endsection