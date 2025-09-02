<div class="form-group mb-2">
    <label for="kode">Kode</label>
    <input type="text" name="kode" id="kode" class="form-control"
           value="{{ old('kode', $kategori->kode ?? '') }}" required>
</div>

<div class="form-group mb-2">
    <label for="nama">Nama</label>
    <input type="text" name="nama" id="nama" class="form-control"
           value="{{ old('nama', $kategori->nama ?? '') }}" required>
</div>

<button type="submit" class="btn btn-success mt-2">Simpan</button>
<a href="{{ url('kategori') }}" class="btn btn-secondary mt-2">Batal</a>
