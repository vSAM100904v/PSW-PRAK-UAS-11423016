@extends('layout.user')

@section('title', 'Court List')

@section('contents')
    <div class="container">
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
        <div class="row">
            @foreach ($data_lapangan as $lapangan)
                <div class="col-md-4 mb-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <img src="{{ asset('storage/' . $lapangan->img_lapangan) }}" class="card-img-top"
                                alt="Lapangan Image">
                            <h5 class="card-title m-3"
                                style="font-family: 'Arial Black', sans-serif; font-size: 2rem; color: #333333;">
                                {{ $lapangan->nama_lapangan }}</h5>
                            <p class="card-text mb-1"
                                style="font-family: 'Times New Roman', serif; font-size: 1.2rem; color: #666666;">
                                @if ($lapangan->kategori)
                                    {{ $lapangan->kategori->nama_katlapangan }}
                                @else
                                    Kategori lapangan tidak tersedia
                                @endif
                            </p>
                            <p class="card-text mb-1"
                                style="font-family: 'Courier New', monospace; font-size: 1.2rem; color: #666666;">
                                Rp{{ $lapangan->harga_lapangan }}<b>/Hour</b></p>
                            <p class="card-text mb-1"
                                style="font-family: 'Times New Roman', serif; font-size: 1.2rem; color: #666666;">
                                Type Court:
                                @if ($lapangan->kategori)
                                    {{ $lapangan->kategori->jenis_lapangan }}
                                @else
                                    Jenis lapangan tidak tersedia
                                @endif
                            </p>

                            @if (session('is_logged_in'))
                                <a href="{{ route('user_court_show', $lapangan->id_lapangan) }}"
                                    class="btn btn-primary btn-sm">Detail Court</a>
                                <a href="{{ route('book_now', ['id_lapangan' => $lapangan->id_lapangan]) }}"
                                    class="btn btn-success btn-sm">Book Now</a>
                            @else
                                <a href="{{ route('user_court_show', $lapangan->id_lapangan) }}"
                                    class="btn btn-primary btn-sm">Detail Court</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
