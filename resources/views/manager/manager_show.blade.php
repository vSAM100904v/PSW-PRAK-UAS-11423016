@extends('layout.admin')

@section('title', 'Pengelola Details')

@section('contents')
    <div class="container">
        <h1>Pengelola List</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Status</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th>Last Login</th>
                    <th>Bekerja Di</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($member as $manager)
                    <tr>
                        <td>{{ $manager->id_pengguna }}</td>
                        <td>{{ $manager->username_pengguna }}</td>
                        <td>{{ $manager->pengelola->status }}</td>
                        <td>{{ $manager->pengelola->tanggal_mulai }}</td>
                        <td>{{ $manager->pengelola->tanggal_selesai }}</td>
                        <td>{{ $manager->last_login }}</td>
                        <td>{{ $manager->pengelola->lapangan->nama_lokasi }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('pengelola') }}" class="btn btn-primary">Back</a>
    </div>
@endsection
