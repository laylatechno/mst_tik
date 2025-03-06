<?php

namespace App\Http\Controllers;

use App\Models\LogHistori;
use App\Models\Gallery;

use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $imageService;
    function __construct(ImageService $imageService)
    {
        $this->middleware('permission:gallery-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:gallery-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:gallery-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:gallery-delete', ['only' => ['destroy']]);
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
        $title = "Halaman Galeri";
        $subtitle = "Menu Galeri";
        $data_galleries = Gallery::all();
        return view('gallery.index', compact('data_galleries', 'title', 'subtitle'));
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $title = "Halaman Tambah Galeri";
        $subtitle = "Menu Tambah Galeri";
        return view('gallery.create', compact('title', 'subtitle'));
    }



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
            DB::beginTransaction();

            $input = $request->all();

            // Upload dan konversi gambar menggunakan service
            if ($request->hasFile('image')) {
                $input['image'] = $this->imageService->handleImageUpload(
                    $request->file('image'),
                    'upload/galleries'
                );
            } else {
                $input['image'] = '';
            }

            // Simpan data gallery
            $gallery = Gallery::create($input);

            // Simpan log histori setelah semua proses berhasil
            $loggedInUserId = Auth::id();
            $this->simpanLogHistori('Create', 'Gallery', $gallery->id, $loggedInUserId, null, json_encode($gallery));

            DB::commit();

            return redirect()->route('galleries.index')->with('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }










    /**
     * Display the specified resource.
     *
     * @param  \App\Gallerys  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        // Judul untuk halaman
        $title = "Halaman Lihat Galeri";
        $subtitle = "Menu Lihat Galeri";



        // Ambil data gallery berdasarkan ID
        $data_galleries = Gallery::findOrFail($id);

        // Kembalikan view dengan membawa data produk
        return view('gallery.show', compact(
            'title',
            'subtitle',

            'data_galleries',
        ));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Gallerys  $gallery
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $title = "Halaman Edit Galeri";
        $subtitle = "Menu Edit Galeri";


        // Ambil data gallery berdasarkan ID
        $data_galleries = Gallery::findOrFail($id);

        // Kirim data ke view
        return view('gallery.edit', compact(
            'title',
            'subtitle',

            'data_galleries',
        ));
    }


    public function update(Request $request, Gallery $gallery): RedirectResponse
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

            $oldData = $gallery->toArray();
            $input = $request->all();

            // Upload dan konversi gambar menggunakan service
            if ($request->hasFile('image')) {
                $input['image'] = $this->imageService->handleImageUpload(
                    $request->file('image'),
                    'upload/galleries',
                    $gallery->image // Pass old image for deletion
                );
            } else {
                $input['image'] = $gallery->image; // Gunakan gambar yang sudah ada
            }

            // Update data gallery
            $gallery->update($input);

            // Simpan log histori setelah semua proses berhasil
            $loggedInUserId = Auth::id();
            $this->simpanLogHistori(
                'Update',
                'Galeri',
                $gallery->id,
                $loggedInUserId,
                json_encode($oldData),
                json_encode($gallery->toArray())
            );

            DB::commit();

            return redirect()->route('galleries.index')->with('success', 'Data berhasil diperbarui');
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
     * @param  \App\Gallerys  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Cari gallery berdasarkan ID
        $gallery = Gallery::findOrFail($id);

      
        try {


            // Hapus file gambar jika ada
            if (!empty($gallery->image)) {
                $imagePath = public_path('upload/galleries/' . $gallery->image);
                if (file_exists($imagePath)) {
                    @unlink($imagePath); // Menghapus file gambar
                }
            }



            // Hapus gallery dari tabel galleries
            $gallery->delete();

            // Mendapatkan ID pengguna yang sedang login
            $loggedInUserId = Auth::id();

            // Simpan log histori untuk operasi Delete
            $this->simpanLogHistori('Delete', 'Galeri', $id, $loggedInUserId, json_encode($gallery), null);

            // Commit gallery
            DB::commit();

            // Redirect kembali dengan pesan sukses
            return redirect()->route('galleries.index')->with('success', 'Galeri berhasil dihapus');
        } catch (\Exception $e) {
            // Rollback gallery jika terjadi error
            DB::rollBack();

            // Kembalikan pesan error
            return redirect()->route('galleries.index')->with('error', 'Gagal menghapus gallery: ' . $e->getMessage());
        }
    }
}
