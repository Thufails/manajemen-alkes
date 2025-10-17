<?php

namespace App\Http\Controllers;

use App\Models\MasterItem;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        return view('kategori.index.index', compact('kategori'));
    }

    public function create()
    {
        return view('kategori.form.form');
    }

    public function search()
    {
        $data = MasterItem::with('kategori')->get();

        return datatables()->of($data)
            ->addColumn('kategori', function ($row) {
                return $row->kategori->nama ?? '-';
            })
            ->addColumn('action', function ($row) {
                return '<a href="'.url('master-items/view/'.$row->id).'" class="btn btn-sm btn-info">View</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'rerequired|string|max:255'
        ]);

        Kategori::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function show(Kategori $kategori)
    {
        return view('kategori.index.index', compact('kategori'));
    }

    public function edit(Kategori $kategori)
    {
        return view('kategori.form.form', compact('kategori'));
    }

    public function formView($method, $id = null)
{
    if ($method == 'new') {
        return view('kategori.form.form', ['method' => $method]);
    } elseif ($method == 'edit') {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.form.form', ['method' => $method, 'kategori' => $kategori]);
    }

    abort(404);
}



    public function formSubmit(Request $request, $method, $id = null)
    {
        $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'kode'=> 'required|string|max:255'
    ]);

    if ($method === 'edit' && $id) {
        $kategori = Kategori::findOrFail($id);
        $kategori->update($validated);
        return redirect('kategori')->with('success', 'Kategori berhasil diperbarui!');
    }

    // default create
    Kategori::create($validated);
    return redirect('kategori')->with('success', 'Kategori berhasil ditambahkan!');
    }


    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'rerequired|string|max:255'
        ]);

        $kategori->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }

}
