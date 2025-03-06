<?php

namespace App\Http\Controllers;

use App\Services\ImageService;
use App\Models\LogHistori;
use App\Models\Testimony;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class TestimonyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $imageService;
  
    function __construct(ImageService $imageService)
    {
        $this->middleware('permission:testimony-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:testimony-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:testimony-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:testimony-delete', ['only' => ['destroy']]);
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
        $title = "Halaman Testimoni";
        $subtitle = "Menu Testimoni";

        // Ambil data untuk dropdown select
        $data_testimonial = Testimony::all();


        // Kirim semua data ke view
        return view('testimony.index', compact('data_testimonial', 'title', 'subtitle'));
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $title = "Halaman Tambah Testimoni";
        $subtitle = "Menu Tambah Testimoni";


        // Kirim data ke view
        return view('testimony.create', compact('title', 'subtitle'));
    }



    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:4096',
        ], [
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
                    'upload/testimonial'
                );
            } else {
                $input['image'] = '';
            }

            // Simpan data testimony
            $testimony = Testimony::create($input);

            // Simpan log histori setelah semua proses berhasil
            $loggedInUserId = Auth::id();
            $this->simpanLogHistori('Create', 'Testimonial', $testimony->id, $loggedInUserId, null, json_encode($testimony));

            DB::commit();

            return redirect()->route('testimonial.index')->with('success', 'Data berhasil disimpan');
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
     * @param  \App\Testimonials  $testimony
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        // Judul untuk halaman
        $title = "Halaman Lihat Testimoni";
        $subtitle = "Menu Lihat Testimoni";



        // Ambil data testimony berdasarkan ID
        $data_testimonial = Testimony::findOrFail($id);

        // Kembalikan view dengan membawa data produk
        return view('testimony.show', compact(
            'title',
            'subtitle',

            'data_testimonial',
        ));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Testimonials  $testimony
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $title = "Halaman Edit Testimoni";
        $subtitle = "Menu Edit Testimoni";


        // Ambil data testimony berdasarkan ID
        $data_testimonial = Testimony::findOrFail($id);

        // Kirim data ke view
        return view('testimony.edit', compact(
            'title',
            'subtitle',

            'data_testimonial',
        ));
    }


    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:4096',
        ], [
            'image.image' => 'Gambar harus berupa file gambar.',
            'image.mimes' => 'Format gambar harus jpeg, jpg, atau png.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 4 MB.',
        ]);

        try {
            DB::beginTransaction();

            $testimony = Testimony::findOrFail($id);
            $oldData = $testimony->toArray();
            $input = $request->all();

            // Upload dan konversi gambar menggunakan service
            if ($request->hasFile('image')) {
                $input['image'] = $this->imageService->handleImageUpload(
                    $request->file('image'),
                    'upload/testimonial',
                    $testimony->image // Pass old image for deletion
                );
            } else {
                $input['image'] = $testimony->image; // Gunakan gambar yang sudah ada
            }

            // Update data testimony
            $testimony->update($input);

            // Simpan log histori setelah semua proses berhasil
            $loggedInUserId = Auth::id();
            $this->simpanLogHistori(
                'Update',
                'Testimoni',
                $testimony->id,
                $loggedInUserId,
                json_encode($oldData),
                json_encode($testimony->toArray())
            );

            DB::commit();

            return redirect()->route('testimonial.index')->with('success', 'Data berhasil diperbarui');
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
     * @param  \App\Testimonials  $testimony
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Cari testimony berdasarkan ID
        $testimony = Testimony::findOrFail($id);

      
        try {


            // Hapus file gambar jika ada
            if (!empty($testimony->image)) {
                $imagePath = public_path('upload/testimonial/' . $testimony->image);
                if (file_exists($imagePath)) {
                    @unlink($imagePath); // Menghapus file gambar
                }
            }



            // Hapus testimony dari tabel testimonial
            $testimony->delete();

            // Mendapatkan ID pengguna yang sedang login
            $loggedInUserId = Auth::id();

            // Simpan log histori untuk operasi Delete
            $this->simpanLogHistori('Delete', 'Testimonial', $id, $loggedInUserId, json_encode($testimony), null);

            // Commit testimony
            DB::commit();

            // Redirect kembali dengan pesan sukses
            return redirect()->route('testimonial.index')->with('success', 'Testimonial berhasil dihapus');
        } catch (\Exception $e) {
            // Rollback testimony jika terjadi error
            DB::rollBack();

            // Kembalikan pesan error
            return redirect()->route('testimonial.index')->with('error', 'Gagal menghapus testimony: ' . $e->getMessage());
        }
    }
}
