@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    {{ isset($kategori) ? 'Edit Kategori' : 'Buat Kategori Baru' }}
                </div>
                <div class="card-body">
                    <form
                        action="{{ isset($kategori)
                            ? route('kategori.submit', ['method' => 'edit', 'id' => $kategori->id])
                            : route('kategori.submit', ['method' => 'create']) }}"
                        method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="kode" class="form-label">Kode</label>
                            <input type="text" name="kode" id="kode" class="form-control"
                                value="{{ old('kode', $kategori->kode ?? '') }}"
                                placeholder="Masukkan kode kategori" required>
                        </div>

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control"
                                value="{{ old('nama', $kategori->nama ?? '') }}"
                                placeholder="Masukkan nama kategori" required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href="{{ url('kategori') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
