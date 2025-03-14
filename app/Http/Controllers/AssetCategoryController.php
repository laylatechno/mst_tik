<?php

namespace App\Http\Controllers;

use App\Models\LogHistori;
use App\Models\AssetCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AssetCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:assetcategory-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:assetcategory-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:assetcategory-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:assetcategory-delete', ['only' => ['destroy']]);
    }

    private function simpanLogHistori($aksi, $tabelAsal, $idEntitas, $pengguna, $dataLama, $dataBaru)
    {
        $log = new LogHistori();
        $log->tabel_asal = $tabelAsal;
        $log->id_entitas = $idEntitas;
        $log->aksi = $aksi;
        $log->waktu = now();
        $log->pengguna = $pengguna;
        $log->data_lama = $dataLama;
        $log->data_baru = $dataBaru;
        $log->save();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $title = "Halaman Kategori Aset";
        $subtitle = "Menu Kategori Aset";
        $data_asset_categories = AssetCategory::all();
        return view('asset_category.index', compact('data_asset_categories', 'title', 'subtitle'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $title = "Halaman Tambah Kategori Aset";
        $subtitle = "Menu Tambah Kategori Aset";
        $data_asset_categories = AssetCategory::all();
        return view('asset_category.create', compact('title', 'subtitle', 'data_asset_categories'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:asset_categories,name',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.unique' => 'Nama sudah terdaftar.',
        ]);

        $assetcategory = AssetCategory::create($request->all());

        $loggedInUserId = Auth::id();
        // Simpan log histori untuk operasi Create dengan user_id yang sedang login
        $this->simpanLogHistori('Create', 'AssetCategory', $assetcategory->id, $loggedInUserId, null, json_encode($assetcategory));
        return redirect()->route('asset_categories.index')
            ->with('success', 'Kategori Aset berhasil dibuat.');
    }





    /**
     * Display the specified resource.
     *
     * @param  \App\AssetCategory  $assetcategory
     * @return \Illuminate\Http\Response
     */
    public function show($id): View

    {
        $title = "Halaman Lihat Kategori Aset";
        $subtitle = "Menu Lihat Kategori Aset";
        $data_asset_categories = AssetCategory::find($id);
        return view('asset_category.show', compact('data_asset_categories', 'title', 'subtitle'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AssetCategory  $assetcategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $title = "Halaman Edit Kategori Aset";
        $subtitle = "Menu Edit Kategori Aset";

        $data_asset_categories = AssetCategory::findOrFail($id);

        return view('asset_category.edit', compact('data_asset_categories', 'title', 'subtitle'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AssetCategory  $assetcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        // Validasi input
        $this->validate($request, [
            'name' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi.',
        ]);

        // Cari data berdasarkan ID
        $assetcategory = AssetCategory::find($id);

        // Jika data tidak ditemukan
        if (!$assetcategory) {
            return redirect()->route('asset_categories.index')
                ->with('error', 'Data AssetCategory tidak ditemukan.');
        }

        // Menyimpan data lama sebelum update
        $oldAssetCategorysnData = $assetcategory->toArray();

        // Melakukan update data
        $assetcategory->update($request->all());

        // Mendapatkan ID pengguna yang sedang login
        $loggedInUserId = Auth::id();

        // Mendapatkan data baru setelah update
        $newAssetCategorysnData = $assetcategory->fresh()->toArray();

        // Menyimpan log histori untuk operasi Update
        $this->simpanLogHistori('Update', 'AssetCategory', $assetcategory->id, $loggedInUserId, json_encode($oldAssetCategorysnData), json_encode($newAssetCategorysnData));

        return redirect()->route('asset_categories.index')
            ->with('success', 'Kategori Aset berhasil diperbaharui');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AssetCategory  $assetcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $assetcategory = AssetCategory::find($id);
        $assetcategory->delete();
        $loggedInAssetCategoryId = Auth::id();
        // Simpan log histori untuk operasi Delete dengan assetcategory_id yang sedang login dan informasi data yang dihapus
        $this->simpanLogHistori('Delete', 'AssetCategory', $id, $loggedInAssetCategoryId, json_encode($assetcategory), null);
        // Redirect kembali dengan pesan sukses
        return redirect()->route('asset_categories.index')->with('success', 'Kategori Aset berhasil dihapus');
    }
}
