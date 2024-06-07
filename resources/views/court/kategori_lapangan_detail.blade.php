@extends('layout.admin')

@section('title', 'Detail Kategori Lapangan')

@section('contents')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Detail Kategori Lapangan</div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label for="nama_katlapangan" class="form-label">Nama Kategori Lapangan</label>
                            <input type="text" class="form-control" id="nama_katlapangan" name="nama_katlapangan"
                                value="{{ $kategori->nama_katlapangan }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="jenis_lapangan" class="form-label">Jenis Lapangan</label>
                            <input type="text" class="form-control" id="jenis_lapangan" name="jenis_lapangan"
                                value="{{ $kategori->jenis_lapangan }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="file_katlapangan" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="file_katlapangan" name="file_katlapangan" rows="3" readonly>{{ $kategori->file_katlapangan }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="created_by" class="form-label">Dibuat Oleh</label>
                            <input type="text" class="form-control" id="created_by" name="created_by"
                                value="{{ $kategori->created_by }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="created_at" class="form-label">Tanggal Dibuat</label>
                            <input type="text" class="form-control" id="created_at" name="created_at"
                                value="{{ $kategori->created_at }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="updated_at" class="form-label">Tanggal Diperbarui</label>
                            <input type="text" class="form-control" id="updated_at" name="updated_at"
                                value="{{ $kategori->updated_at }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="lapangan" class="form-label">Lapangan yang menggunakan kategori ini:</label>
                            <ul>
                                @foreach ($kategori->lapangan as $lapangan)
                                    <li>{{ $lapangan->nama_lapangan }}</li>
                                @endforeach
                            </ul>
                        </div>
                        
                        <button type="button" class="btn btn-secondary"
                            onclick="window.location='{{ route('lapangan_index') }}'">Back</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
