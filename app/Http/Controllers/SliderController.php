<?php

namespace App\Http\Controllers;

use App\Models\LogHistori;
use App\Models\Slider;

use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $imageService;
    function __construct(ImageService $imageService)
    {
        $this->middleware('permission:slider-list|slider-create|slider-edit|slider-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:slider-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:slider-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:slider-delete', ['only' => ['destroy']]);
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
        $title = "Halaman Slider";
        $subtitle = "Menu Slider";
        $data_sliders = Slider::all();
        return view('slider.index', compact('data_sliders', 'title', 'subtitle'));
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $title = "Halaman Tambah Slider";
        $subtitle = "Menu Tambah Slider";
        return view('slider.create', compact('title', 'subtitle'));
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
                    'upload/sliders'
                );
            } else {
                $input['image'] = '';
            }

            // Simpan data slider
            $slider = Slider::create($input);

            // Simpan log histori setelah semua proses berhasil
            $loggedInUserId = Auth::id();
            $this->simpanLogHistori('Create', 'Slider', $slider->id, $loggedInUserId, null, json_encode($slider));

            DB::commit();

            return redirect()->route('sliders.index')->with('success', 'Data berhasil disimpan');
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
     * @param  \App\Sliders  $slider
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        // Judul untuk halaman
        $title = "Halaman Lihat Slider";
        $subtitle = "Menu Lihat Slider";



        // Ambil data slider berdasarkan ID
        $data_sliders = Slider::findOrFail($id);

        // Kembalikan view dengan membawa data produk
        return view('slider.show', compact(
            'title',
            'subtitle',

            'data_sliders',
        ));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sliders  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $title = "Halaman Edit Slider";
        $subtitle = "Menu Edit Slider";


        // Ambil data slider berdasarkan ID
        $data_sliders = Slider::findOrFail($id);

        // Kirim data ke view
        return view('slider.edit', compact(
            'title',
            'subtitle',

            'data_sliders',
        ));
    }


    public function update(Request $request, Slider $slider): RedirectResponse
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

            $oldData = $slider->toArray();
            $input = $request->all();

            // Upload dan konversi gambar menggunakan service
            if ($request->hasFile('image')) {
                $input['image'] = $this->imageService->handleImageUpload(
                    $request->file('image'),
                    'upload/sliders',
                    $slider->image // Pass old image for deletion
                );
            } else {
                $input['image'] = $slider->image; // Gunakan gambar yang sudah ada
            }

            // Update data slider
            $slider->update($input);

            // Simpan log histori setelah semua proses berhasil
            $loggedInUserId = Auth::id();
            $this->simpanLogHistori(
                'Update',
                'Slider',
                $slider->id,
                $loggedInUserId,
                json_encode($oldData),
                json_encode($slider->toArray())
            );

            DB::commit();

            return redirect()->route('sliders.index')->with('success', 'Data berhasil diperbarui');
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
     * @param  \App\Sliders  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Cari slider berdasarkan ID
        $slider = Slider::findOrFail($id);

      
        try {


            // Hapus file gambar jika ada
            if (!empty($slider->image)) {
                $imagePath = public_path('upload/sliders/' . $slider->image);
                if (file_exists($imagePath)) {
                    @unlink($imagePath); // Menghapus file gambar
                }
            }



            // Hapus slider dari tabel sliders
            $slider->delete();

            // Mendapatkan ID pengguna yang sedang login
            $loggedInUserId = Auth::id();

            // Simpan log histori untuk operasi Delete
            $this->simpanLogHistori('Delete', 'Slider', $id, $loggedInUserId, json_encode($slider), null);

            // Commit slider
            DB::commit();

            // Redirect kembali dengan pesan sukses
            return redirect()->route('sliders.index')->with('success', 'Slider berhasil dihapus');
        } catch (\Exception $e) {
            // Rollback slider jika terjadi error
            DB::rollBack();

            // Kembalikan pesan error
            return redirect()->route('sliders.index')->with('error', 'Gagal menghapus slider: ' . $e->getMessage());
        }
    }
}
