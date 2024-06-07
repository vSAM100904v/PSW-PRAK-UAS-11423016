@extends('layout.admin')

@section('title', 'Home Lapangan List')

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

        <div class="row justify-content-center">
            <div class="col-md-10">
                <!-- Tabel Lokasi -->
                <div class="card mb-4">
                    <div class="card-header">Lokasi</div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Lokasi</th>
                                    <th>Alamat</th>
                                    <th>Deskripsi</th>
                                    <th>Foto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $item->nama_lokasi }}</td>
                                        <td>{{ $item->alamat }}</td>
                                        <td>{{ $item->deskripsi }}</td>
                                        <td>
                                            <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Lokasi"
                                                width="100">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Tombol Add -->
                        <a href="/lapangan/lokasi/tambah">
                            <button type="button" class="btn btn-primary m-2">ADD</button>
                        </a>
                    </div>
                    <!-- Tabel Lapangan -->
                    <div class="card">
                        <div class="card-header">Lapangan</div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Nama Lapangan</th>
                                        <th>Harga Sewa</th>
                                        <th>Gambar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data_lapangan as $item)
                                        <tr>
                                            <td>{{ $item->nama_lapangan }}</td>
                                            <td>{{ $item->harga_lapangan }}</td>
                                            <td>
                                                <img src="{{ asset('storage/' . $item->img_lapangan) }}"
                                                    alt="Gambar Lapangan" width="100">
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-success m-2"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $item->id_lapangan }}">
                                                        Edit
                                                    </button>
                                                    <button type="button" class="btn btn-success m-2"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#detailModal{{ $item->id_lapangan }}">
                                                        Detail
                                                    </button>
                                                    <form action="{{ route('lapangan.destroy', $item->id_lapangan) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Apakah anda yakin ingin menghapus?')"
                                                        class="float-right text-red-800">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger m-2">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-primary m-2"
                                onclick="window.location='{{ route('create_lapangan') }}'">ADD</button>
                        </div>
                    </div>

                    <!-- Edit Modal -->
                    @foreach ($data_lapangan as $item)
                        <div class="modal fade" id="editModal{{ $item->id_lapangan }}" tabindex="-1"
                            aria-labelledby="editModalLabel{{ $item->id_lapangan }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel{{ $item->id_lapangan }}">Edit Lapangan
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('lapangan.update', $item->id_lapangan) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-3">
                                                <label for="namaLapangan" class="form-label">Nama Lapangan</label>
                                                <input type="text" class="form-control" id="namaLapangan"
                                                    name="nama_lapangan" value="{{ $item->nama_lapangan }}">
                                            </div>

                                            <div class="mb-3">
                                                <label for="hargaLapangan" class="form-label">Harga Lapangan</label>
                                                <input type="number" class="form-control" id="hargaLapangan"
                                                    name="harga_lapangan" value="{{ $item->harga_lapangan }}">
                                            </div>

                                            <div class="mb-3">
                                                <label for="deskripsiLapangan" class="form-label">Deskripsi Lapangan</label>
                                                <textarea class="form-control" id="deskripsiLapangan" name="deskripsi_lapangan">{{ $item->deskripsi_lapangan }}</textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label for="fotoLapangan" class="form-label">Foto Lapangan</label>
                                                <img src="{{ asset('storage/' . $item->img_lapangan) }}" class="img-fluid"
                                                    width="100" alt="Gambar Lapangan">
                                                <input type="file" class="form-control" id="fotoLapangan"
                                                    name="img_lapangan">
                                            </div>

                                            <div class="mb-3">
                                                <label for="lokasiLapangan" class="form-label">Lokasi Lapangan</label>
                                                <select class="form-select" id="lokasiLapangan" name="id_lokasi">
                                                    @foreach ($data as $lokasi)
                                                        <option value="{{ $lokasi->id_lokasi }}"
                                                            {{ $item->id_lokasi == $lokasi->id_lokasi ? 'selected' : '' }}>
                                                            {{ $lokasi->nama_lokasi }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach


                    <!-- Detail Modal -->
                    @foreach ($data_lapangan as $item)
                        <div class="modal fade" id="detailModal{{ $item->id_lapangan }}" tabindex="-1" role="dialog"
                            aria-labelledby="detailModalLabel{{ $item->id_lapangan }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="detailModalLabel{{ $item->id_lapangan }}">Detail
                                            Lapangan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <img src="{{ asset('storage/' . $item->img_lapangan) }}"
                                                    class="img-fluid" alt="Gambar Lapangan">
                                            </div>
                                            <div class="col-md-6">
                                                <ul class="list-group">
                                                    <li class="list-group-item">Nama Lapangan: {{ $item->nama_lapangan }}
                                                    </li>
                                                    <li class="list-group-item">Harga Sewa (Per Jam):
                                                        Rp{{ number_format($item->harga_lapangan, 0, ',', '.') }}</li>
                                                    <li class="list-group-item">Deskripsi Lapangan:
                                                        {{ $item->deskripsi_lapangan }}</li>
                                                    <li class="list-group-item">Lokasi: {{ $item->lokasi->nama_lokasi }} -
                                                        {{ $item->lokasi->alamat }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endsection

        @section('scripts')
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        @endsection
