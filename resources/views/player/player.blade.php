@extends('layout.admin')

@section('title', 'Pengelola Details')

@section('contents')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <h1>Player List</h1>

        <!-- Add manager Button -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPlayerModal">
            Add Player
        </button>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Last Login</th>
                    <th>Jenis Pelanggan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($players as $player)
                    <tr>
                        <td>{{ $player->id_pengguna }}</td>
                        <td>{{ $player->username_pengguna }}</td>
                        <td>{{ $player->last_login }}</td>

                        <td>{{ optional($player->pelanggan)->jenis_pelanggan ?? 'Biasa' }}</td>
                        <td>
                            <button type="button" class="btn btn-success m-2" data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $player->id_pengguna }}">
                                Ganti Status Pelanggan
                            </button>
                            {{-- Delete Form --}}
                            <form action="{{ route('pengguna.destroy', $player->id_pengguna) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('Are you sure you want to delete this player?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <!-- Edit Modal -->
    @foreach ($players as $item)
        <div class="modal fade" id="editModal{{ $item->id_pengguna }}" tabindex="-1"
            aria-labelledby="editModalLabel{{ $item->id_pengguna }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel{{ $item->id_pengguna }}">Edit Lapangan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('updatedStatus') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="id_pengguna" value="{{ $item->id_pengguna }}">

                            <div class="mb-3">
                                <label for="namaLapangan" class="form-label">Ganti status member</label>
                                <select class="form-select" id="lokasiLapangan" name="id_lokasi">
                                    <option value="1" {{ $item->jenis_pelanggan == 'member' ? 'selected' : '' }}>
                                        Member</option>
                                    <option value="2" {{ $item->jenis_pelanggan == 'biasa' ? 'selected' : '' }}>Biasa
                                    </option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach



    <!-- Add manager Modal -->
    <div class="modal fade" id="addPlayerModal" tabindex="-1" role="dialog" aria-labelledby="addmanagerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addmanagerModalLabel">Add manager</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('pengguna.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
