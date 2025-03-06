<?php

namespace App\Http\Controllers;

use App\Models\LogHistori;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:blogcategory-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:blogcategory-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:blogcategory-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:blogcategory-delete', ['only' => ['destroy']]);
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
        $title = "Halaman Kategori Blog";
        $subtitle = "Menu Kategori Blog";
        $data_blogcategories = BlogCategory::all();
        return view('blog_category.index', compact('data_blogcategories', 'title', 'subtitle'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $title = "Halaman Tambah Kategori Blog";
        $subtitle = "Menu Tambah Kategori Blog";
        $data_blogcategory_categories = BlogCategory::all();
        return view('blog_category.create', compact('title', 'subtitle', 'data_blogcategory_categories'));
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
            'name' => 'required|unique:blog_categories,name',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.unique' => 'Nama sudah terdaftar.',
        ]);

        $blogcategory = BlogCategory::create($request->all());

        $loggedInUserId = Auth::id();
        // Simpan log histori untuk operasi Create dengan user_id yang sedang login
        $this->simpanLogHistori('Create', 'BlogCategory', $blogcategory->id, $loggedInUserId, null, json_encode($blogcategory));
        return redirect()->route('blog_categories.index')
            ->with('success', 'Kategori Blog berhasil dibuat.');
    }





    /**
     * Display the specified resource.
     *
     * @param  \App\BlogCategory  $blogcategory
     * @return \Illuminate\Http\Response
     */
    public function show($id): View

    {
        $title = "Halaman Lihat Kategori Blog";
        $subtitle = "Menu Lihat Kategori Blog";
        $data_blogcategories = BlogCategory::find($id);
        return view('blog_category.show', compact('data_blogcategories', 'title', 'subtitle'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BlogCategory  $blogcategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $title = "Halaman Edit Kategori Blog";
        $subtitle = "Menu Edit Kategori Blog";
      
        $data_blogcategories = BlogCategory::findOrFail($id);

        return view('blog_category.edit', compact('data_blogcategories', 'title', 'subtitle'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BlogCategory  $blogcategory
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
        $blogcategory = BlogCategory::find($id);

        // Jika data tidak ditemukan
        if (!$blogcategory) {
            return redirect()->route('blog_categories.index')
                ->with('error', 'Data BlogCategory tidak ditemukan.');
        }

        // Menyimpan data lama sebelum update
        $oldBlogCategorysnData = $blogcategory->toArray();

        // Melakukan update data
        $blogcategory->update($request->all());

        // Mendapatkan ID pengguna yang sedang login
        $loggedInUserId = Auth::id();

        // Mendapatkan data baru setelah update
        $newBlogCategorysnData = $blogcategory->fresh()->toArray();

        // Menyimpan log histori untuk operasi Update
        $this->simpanLogHistori('Update', 'BlogCategory', $blogcategory->id, $loggedInUserId, json_encode($oldBlogCategorysnData), json_encode($newBlogCategorysnData));

        return redirect()->route('blog_categories.index')
            ->with('success', 'Kategori Blog berhasil diperbaharui');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BlogCategory  $blogcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blogcategory = BlogCategory::find($id);
        $blogcategory->delete();
        $loggedInBlogCategoryId = Auth::id();
        // Simpan log histori untuk operasi Delete dengan blogcategory_id yang sedang login dan informasi data yang dihapus
        $this->simpanLogHistori('Delete', 'BlogCategory', $id, $loggedInBlogCategoryId, json_encode($blogcategory), null);
        // Redirect kembali dengan pesan sukses
        return redirect()->route('blog_categories.index')->with('success', 'Kategori Blog berhasil dihapus');
    }
}
