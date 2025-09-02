<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

<script>
    async function loadData() {
        const kode = document.getElementById('filter-kode').value || '';
        const nama = document.getElementById('filter-nama').value || '';
        const loading = document.getElementById('loading-filter');
        const tbody = document.querySelector('#kategori-table tbody');

        loading.style.display = 'inline';
        tbody.innerHTML = '';

        try {
            const url = new URL("{{ url('kategori/search') }}");
            if (kode) url.searchParams.append('kode', kode);
            if (nama) url.searchParams.append('nama', nama);

            const res = await fetch(url);
            const data = await res.json();

            if (Array.isArray(data) && data.length) {
                data.forEach(item => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${item.kode ?? ''}</td>
                        <td>${item.nama ?? ''}</td>
                        <td>
                            <a href="{{ url('kategori/form/edit') }}/${item.id}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ url('kategori') }}/${item.id}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            } else {
                tbody.innerHTML = `<tr><td colspan="3" class="text-center">Tidak ada data</td></tr>`;
            }
        } catch (e) {
            tbody.innerHTML = `<tr><td colspan="3" class="text-danger">Gagal memuat data</td></tr>`;
        } finally {
            loading.style.display = 'none';
        }
    }

    document.getElementById('btn-filter').addEventListener('click', loadData);
    loadData(); // load pertama kali
</script>
