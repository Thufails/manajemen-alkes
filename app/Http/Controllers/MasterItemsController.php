<?php

namespace App\Http\Controllers;

use App\Models\MasterItem;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class MasterItemsController extends Controller
{
    public function index()
    {
        $items = MasterItem::with('kategori')->orderBy('kategori_id', 'asc')->get();
        return view('master_items.index.index',compact('items'));
    }
    public function search(Request $request)
    {
            $kode = $request->kode;
            $nama = $request->nama;
            $hargamin = $request->hargamin;
            $hargamax = $request->hargamax;

            $data_search = MasterItem::query();

            if (!empty($kode)) $data_search = $data_search->where('kode', $kode);
            if (!empty($nama)) $data_search = $data_search->where('nama', 'LIKE', '%' . $nama . '%');

            //if (!empty($hargamin)) $data_search = $data_search->where('harga_beli', '>=', $hargamin)->where('harga_beli', '<=', $hargamax);
            if (!empty($hargamin)){
                $data_search->where('harga_beli', '>=', $hargamin);
                }
            if (!empty($hargamax)){
                $data_search->where('harga_beli', '<=', $hargamin);
                }

            $data_search = $data_search->select('kode', 'nama', 'jenis', 'harga_beli', 'laba', 'supplier', 'kategori_id', 'foto')->orderBy('id')->get();

            $data_search->transform(function ($item) {
            if (!empty($item->foto) && file_exists(public_path($item->foto))) {
                $item->foto_url = asset($item->foto);
            } else {
                $item->foto_url = asset('images/no-image.png'); // fallback image
            }
            return $item;
            });

            return json_encode([
                'status' => 200,
                'data' => $data_search
            ]);
    }

    public function formView($method, $id = 0)
    {
        if ($method == 'new') {
            $item = new MasterItem(); // biar properti bisa diakses di blade
        } else {
            $item = MasterItem::find($id);
        }
        // ambil semua kategori untuk dropdown
        $kategori = Kategori::select('id', 'nama')->orderBy('nama')->get();
        $data = [
        'item'     => $item,
        'method'   => $method,
        'kategori' => $kategori
        ];
        return view('master_items.form.index', $data);
    }

    public function singleView($kode)
    {
        $data['data'] = MasterItem::with('kategori') // load relasi kategori
        ->where('kode', $kode)
        ->firstOrFail();
        return view('master_items.single.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
    $request->validate([
        'nama'        => 'required|string|max:255',
        'harga_beli'  => 'required|numeric',
        'laba'        => 'required|numeric',
        'supplier'    => 'required',
        'jenis'       => 'required',
        'kategori_id' => 'required|exists:kategori,id',
        'foto'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($method == 'new') {
        $data_item = new MasterItem;
        $kode = MasterItem::count('id');
        $kode = $kode + 1;
        $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);
        sleep(3);
    } else {
        $data_item = MasterItem::find($id);
        $kode = $data_item->kode;
    }

    $data_item->nama        = $request->nama;
    $data_item->harga_beli  = $request->harga_beli;
    $data_item->laba        = $request->laba;
    $data_item->kode        = $kode;
    $data_item->supplier    = $request->supplier;
    $data_item->jenis       = $request->jenis;
    $data_item->kategori_id = $request->kategori_id;

    // === LOGIKA UPLOAD FOTO ===
    if ($request->hasFile('foto')) {
        $file     = $request->file('foto');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/items'), $filename);

        $data_item->foto = 'uploads/items/' . $filename;
    }

    $data_item->save();

    return redirect('master-items')->with('success', 'Data item berhasil disimpan!');
    }


    public function delete($id)
    {
        $item = MasterItem::find($id);

    if ($item) {
        // Hapus file foto kalau ada
        if ($item->foto && file_exists(public_path($item->foto))) {
            unlink(public_path($item->foto));
        }

        // Hapus data dari database
        $item->delete();
    }

    return redirect('master-items')->with('data berhasil di hapus');
    }

    public function updateRandomData()
    {
        $data = MasterItem::get();
        foreach($data as $item)
        {
            $kode = $item->id;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);

            $item->harga_beli = rand(100,1000000);
            $item->laba = rand(10,99);
            $item->kode = $kode;
            $item->supplier = $this->getRandomSupplier();
            $item->jenis = $this->getRandomJenis();

            $item->save();
        }
    }

    private function getRandomSupplier()
    {
        $array = ['Tokopaedi','Bukulapuk','TokoBagas','E Commurz','Blublu'];
        $random = rand(0,4);
        return $array[$random];
    }

    private function getRandomJenis()
    {
        $array = ['Obat','Alkes','Matkes','Umum','ATK'];
        $random = rand(0,4);
        return $array[$random];
    }
}
