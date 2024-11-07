@extends('layouts.ownerlayout')

@section('title', 'Satuan Barang')

@section('lain-link', 'active')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="g-4">
        <div class="d-flex flex-row align-items-end justify-content-between">
            <h3 id="judul">Data Satuan Barang</h3>
            <button class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#tambahSatuanModal">
                Tambah Satuan
            </button>
        </div>

        @include('layouts.partials.modaladd.satuan')
        @include('layouts.partials.modaledit.satuan')

        <div class="d-flex flex-column bd-highlight bg-secondary rounded p-3 mt-3">
            <div class="d-flex flex-row align-items-end justify-content-between mb-2">
                <div>Tampilan xx Data</div>
                <div>
                    Cari
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nama Satuan</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($satuan as $data)
                        <tr>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->satuan }}</td>
                            <td>
                                <a class="btn btn-sm btn-warning mx-2 btn-edit"
                                    href="#"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editSatuanModal"
                                    data-id="{{ $data->id }}"
                                    data-name="{{ $data->satuan }}">
                                    Edit
                                </a>
                                <a class="btn btn-sm btn-warning mx-2 btn-danger">
                                    Delete
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center text-mute" colspan="4">Data Satuan tidak tersedia</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Tangkap semua tombol edit
    var editButtons = document.querySelectorAll('.btn-edit');
    
    editButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var dataId = this.getAttribute('data-id');
            var dataSatuan = this.getAttribute('data-name');
            
            // Isi form dengan data user
            document.getElementById('edit_satuan').value = dataSatuan;
            
            // Set action URL untuk form
            var form = document.getElementById('editSatuanForm');
            form.action = '/edit-satuanbarang/' + dataId;
        });
    });
});
</script>
@endsection