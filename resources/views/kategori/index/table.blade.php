<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th style="width: 80px;">Kode</th>
            <th>Nama</th>
            <th style="width: 180px;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($kategori as $row)
            <tr>
                <td>{{ $row->kode }}</td>
                <td>{{ $row->nama }}</td>
                <td>
                    <a href="{{ url('kategori/view/'.$row->kode) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ url('kategori/form/edit/'.$row->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ url('kategori/delete/'.$row->id) }}"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Yakin mau hapus?')">Delete</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
