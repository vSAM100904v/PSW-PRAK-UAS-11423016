@extends('layout.admin')

@section('title', 'Create Kategori Lapangan')

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

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Create Kategori Lapangan</div>

                        <div class="card-body">

                            <form action="{{ route('kategori_lapangan.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label for="nama_katlapangan" class="form-label">Nama Kategori Lapangan</label>
                                    <input type="text" class="form-control" id="nama_katlapangan"
                                        name="nama_katlapangan">
                                </div>

                                <div class="mb-3">
                                    <label for="harga_katlapangan" class="form-label">Jenis Lapangan</label>
                                    <input type="text" class="form-control" id="jenis_lapangan"
                                        name="jenis_lapangan">
                                </div>
                                <div class="mb-3">
                                    <label for="jumlah_lapangan" class="form-label">Jumlah Lapangan</label>
                                    <input type="number" class="form-control" id="jumlah_lapangan" name="jumlah_lapangan">
                                </div>
                                <div class="mb-3">
                                    <label for="file_katlapangan" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" id="file_katlapangan" name="file_katlapangan" rows="3"></textarea>
                                </div>

                                <input type="hidden" name="created_by" value="admin">

                                <button type="submit" class="btn btn-primary">Submit</button>

                                <button type="button" class="btn btn-secondary"
                                    onclick="window.location='{{ route('lapangan_index') }}'">Back</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
