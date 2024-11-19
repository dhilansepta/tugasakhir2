@extends('layouts.ownerlayout')

@section('title', 'Satuan Barang')

@section('lain-link', 'active')

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
        <div class="d-flex flex-row align-items-end justify-content-between">
            <h3 id="judul">Data Satuan Barang</h3>
            <button class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#tambahSatuanModal">
                Tambah Satuan
            </button>
        </div>

        @include('layouts.partials.modaladd.satuan')
        @include('layouts.partials.modaledit.satuan')
        @include('layouts.partials.modaldelete.deletebarang')

        <div class="d-flex flex-column bd-highlight bg-secondary rounded p-3 mt-3">
            <div class="d-flex flex-row align-items-end justify-content-end mb-2 gap-2">
                <form action="{{route('owner.satuanbarang')}}" method="GET" class="d-flex flex-wrap align-items-center gap-2">
                    <div class="form-group mb-0">
                        <input
                            class="form-control form-control-sm"
                            id="filterSearch"
                            type="text"
                            name="filterSearch"
                            placeholder="Cari..."
                            value="{{ request('filterSearch') }}"
                            style="width: 150px; border-color:var(--tertiary)">
                    </div>
                    <div class="form-group mb-0 d-flex">
                        <button
                            type="submit"
                            class="btn btn-primary btn-sm"
                            style="width: 50px;">
                            Cari
                        </button>
                        <a href="{{ route('owner.satuanbarang') }}" class="btn btn-danger btn-sm ms-2" style="width: 50px;">
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
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center text-mute" colspan="4">Data Satuan tidak tersedia</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{$satuan->links()}}
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