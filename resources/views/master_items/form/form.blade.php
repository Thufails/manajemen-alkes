<form action="{{ route('master-items.submit', ['method' => $method, 'id' => $item->id ?? 0]) }}"
      method="POST"
      enctype="multipart/form-data">
    @csrf

    @if($method == 'edit')
    <div class="form-group">
        <label>Kode Barang</label>
        <input type="text" class="form-control" name="kode_barang" required readonly value="{{ $item->kode ?? '' }}">
    </div>
    @endif

    <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control" name="nama" required value="{{ $item->nama ?? '' }}">
    </div>

    <div class="form-group">
        <label>Harga Beli</label>
        <input type="number" class="form-control" name="harga_beli" required value="{{ $item->harga_beli ?? '' }}">
    </div>

    <div class="form-group">
        <label>Laba (dalam persen)</label>
        <input type="number" class="form-control" name="laba" required value="{{ $item->laba ?? '' }}">
    </div>

    @php $selected = $item->supplier ?? ''; @endphp
    <div class="form-group">
        <label>Supplier</label>
        <select class="form-control" required name="supplier">
            <option @if($selected == '') selected @endif value="">--Pilih--</option>
            <option @if($selected == 'Tokopaedi') selected @endif>Tokopaedi</option>
            <option @if($selected == 'Bukulapuk') selected @endif>Bukulapuk</option>
            <option @if($selected == 'TokoBagas') selected @endif>TokoBagas</option>
            <option @if($selected == 'E Commurz') selected @endif>E Commurz</option>
            <option @if($selected == 'Blublu') selected @endif>Blublu</option>
        </select>
    </div>

    @php $selected = $item->jenis ?? ''; @endphp
    <div class="form-group">
        <label>Jenis</label>
        <select class="form-control" required name="jenis">
            <option @if($selected == '') selected @endif value="">--Pilih--</option>
            <option @if($selected == 'Obat') selected @endif>Obat</option>
            <option @if($selected == 'Alkes') selected @endif>Alkes</option>
            <option @if($selected == 'Matkes') selected @endif>Matkes</option>
            <option @if($selected == 'Umum') selected @endif>Umum</option>
            <option @if($selected == 'ATK') selected @endif>ATK</option>
        </select>
    </div>

    {{-- Tambahan Kategori --}}
    @php $selectedKategori = $item->kategori_id ?? ''; @endphp
    <div class="form-group">
        <label>Kategori</label>
        <select class="form-control" required name="kategori_id">
            <option value="">--Pilih Kategori--</option>
            @foreach($kategori as $kat)
                <option value="{{ $kat->id }}"
                    @if($selectedKategori == $kat->id) selected @endif>
                    {{ $kat->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="foto">Foto (format: jpg, jpeg, png)</label>
        <input type="file" name="foto" id="foto" class="form-control" accept=".jpg,.jpeg,.png">
        @if(!empty($item->foto))
            <small>Foto sekarang:</small><br>
            <img src="{{ asset($item->foto) }}" alt="Foto Item" width="100" class="mt-2">
        @endif
    </div>

    <button class="btn btn-primary mt-3">Submit</button>
</form>
