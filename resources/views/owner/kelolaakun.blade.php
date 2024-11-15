@extends('layouts.ownerlayout')

@section('title', 'Kelola Akun')

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
            <h3 id="judul">Data Akun</h3>
            <button class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#tambahAkunModal">
                Tambah Akun
            </button>
        </div>

        @include('layouts.partials.modaladd.akun')
        @include('layouts.partials.modaledit.akun')

        <div class="d-flex flex-column bd-highlight bg-secondary rounded p-3 mt-3">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Role</th>
                            <th scope="col">Username</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->role }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->status }}</td>
                            <td>
                                <a class="btn btn-sm btn-warning mx-2 btn-edit"
                                    href="#"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editAkunModal"
                                    data-id="{{ $user->id }}"
                                    data-name="{{ $user->name }}"
                                    data-username="{{ $user->username }}"
                                    data-role="{{ $user->role }}"
                                    data-status="{{ $user->status }}">
                                    Edit
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center text-mute" colspan="4">Data user tidak tersedia</td>
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

        editButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var userId = this.getAttribute('data-id');
                var userName = this.getAttribute('data-name');
                var userUsername = this.getAttribute('data-username');
                var userRole = this.getAttribute('data-role');
                var userStatus = this.getAttribute('data-status');

                // Isi form dengan data user
                document.getElementById('edit_name').value = userName;
                document.getElementById('edit_username').value = userUsername;
                document.getElementById('edit_role').value = userRole;
                document.getElementById('edit_status').value = userStatus;

                // Set action URL untuk form
                var form = document.getElementById('editAkunForm');
                form.action = '/edit-kelolaakun/' + userId;
            });
        });
    });
</script>
@endsection