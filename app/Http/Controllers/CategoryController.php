<?php

namespace App\Http\Controllers;

use App\Models\LogHistori;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Services\ImageService;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $imageService;
    function __construct(ImageService $imageService)
    {
        $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:category-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:category-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);
        $this->imageService = $imageService;
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
        $title = "Halaman Kategori Produk";
        $subtitle = "Menu Kategori Produk";
        $data_categories = Category::all();
        return view('category.index', compact('data_categories', 'title', 'subtitle'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $title = "Halaman Tambah Kategori Produk";
        $subtitle = "Menu Tambah Kategori Produk";
        return view('category.create', compact('title', 'subtitle'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:4096',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'image.image' => 'Gambar harus dalam format jpeg, jpg, atau png',
            'image.mimes' => 'Format gambar harus jpeg, jpg, atau png',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 4 MB',
        ]);
    
        try {
            $input = $request->all();
    
            // Upload dan konversi gambar menggunakan service
            if ($request->hasFile('image')) {
                try {
                    $input['image'] = $this->imageService->handleImageUpload(
                        $request->file('image'),
                        'upload/product_categories'
                    );
                } catch (\Exception $e) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Gagal mengupload gambar: ' . $e->getMessage());
                }
            } else {
                $input['image'] = '';
            }
    
            // Simpan data kategori
            $category = Category::create($input);
    
            // Simpan log histori
            $loggedInUserId = Auth::id();
            $this->simpanLogHistori(
                'Create', 
                'Kategori Produk', 
                $category->id, 
                $loggedInUserId, 
                null, 
                json_encode($category)
            );
    
            return redirect()->route('categories.index')
                ->with('success', 'Kategori Produk berhasil dibuat.');
    
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }




    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id): View

    {
        $title = "Halaman Lihat Kategori Produk";
        $subtitle = "Menu Lihat Kategori Produk";
        $data_categories = Category::find($id);
        return view('category.show', compact('data_categories', 'title', 'subtitle'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $title = "Halaman Edit Kategori Produk";
        $subtitle = "Menu Edit Kategori Produk";
        $data_categories = Category::findOrFail($id);  

        return view('category.edit', compact('data_categories', 'title', 'subtitle'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:4096',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'image.image' => 'Gambar harus dalam format jpeg, jpg, atau png',
            'image.mimes' => 'Format gambar harus jpeg, jpg, atau png',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 4 MB',
        ]);

        try {
            DB::beginTransaction();

            $oldData = $category->toArray();
            $input = $request->all();

            // Upload dan konversi gambar menggunakan service
            if ($request->hasFile('image')) {
                $input['image'] = $this->imageService->handleImageUpload(
                    $request->file('image'),
                    'upload/product_categories',
                    $category->image // Pass old image for deletion
                );
            } else {
                $input['image'] = $category->image; // Gunakan gambar yang sudah ada
            }

            // Update data category
            $category->update($input);

            // Simpan log histori setelah semua proses berhasil
            $loggedInUserId = Auth::id();
            $this->simpanLogHistori(
                'Update',
                'Slider',
                $category->id,
                $loggedInUserId,
                json_encode($oldData),
                json_encode($category->toArray())
            );

            DB::commit();

            return redirect()->route('categories.index')->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        $loggedInCategoryId = Auth::id();
        // Simpan log histori untuk operasi Delete dengan category_id yang sedang login dan informasi data yang dihapus
        $this->simpanLogHistori('Delete', 'Kategori Produk', $id, $loggedInCategoryId, json_encode($category), null);
        // Redirect kembali dengan pesan sukses
        return redirect()->route('categories.index')->with('success', 'Kategori Produk berhasil dihapus');
    }
}
