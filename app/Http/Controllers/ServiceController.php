<?php

namespace App\Http\Controllers;

use App\Models\LogHistori;
use App\Models\Service;

use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $imageService;
    function __construct(ImageService $imageService)
    {
        $this->middleware('permission:service-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:service-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:service-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:service-delete', ['only' => ['destroy']]);
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
        $title = "Halaman Layanan";
        $subtitle = "Menu Layanan";
        $data_services = Service::all();
        return view('service.index', compact('data_services', 'title', 'subtitle'));
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $title = "Halaman Tambah Layanan";
        $subtitle = "Menu Tambah Layanan";
        return view('service.create', compact('title', 'subtitle'));
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
                    'upload/services'
                );
            } else {
                $input['image'] = '';
            }

            // Simpan data service
            $service = Service::create($input);

            // Simpan log histori setelah semua proses berhasil
            $loggedInUserId = Auth::id();
            $this->simpanLogHistori('Create', 'Service', $service->id, $loggedInUserId, null, json_encode($service));

            DB::commit();

            return redirect()->route('services.index')->with('success', 'Data berhasil disimpan');
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
     * @param  \App\Services  $service
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        // Judul untuk halaman
        $title = "Halaman Lihat Layanan";
        $subtitle = "Menu Lihat Layanan";



        // Ambil data service berdasarkan ID
        $data_services = Service::findOrFail($id);

        // Kembalikan view dengan membawa data produk
        return view('service.show', compact(
            'title',
            'subtitle',

            'data_services',
        ));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Services  $service
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $title = "Halaman Edit Layanan";
        $subtitle = "Menu Edit Layanan";


        // Ambil data service berdasarkan ID
        $data_services = Service::findOrFail($id);

        // Kirim data ke view
        return view('service.edit', compact(
            'title',
            'subtitle',

            'data_services',
        ));
    }


    public function update(Request $request, Service $service): RedirectResponse
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

            $oldData = $service->toArray();
            $input = $request->all();

            // Upload dan konversi gambar menggunakan service
            if ($request->hasFile('image')) {
                $input['image'] = $this->imageService->handleImageUpload(
                    $request->file('image'),
                    'upload/services',
                    $service->image // Pass old image for deletion
                );
            } else {
                $input['image'] = $service->image; // Gunakan gambar yang sudah ada
            }

            // Update data service
            $service->update($input);

            // Simpan log histori setelah semua proses berhasil
            $loggedInUserId = Auth::id();
            $this->simpanLogHistori(
                'Update',
                'Layanan',
                $service->id,
                $loggedInUserId,
                json_encode($oldData),
                json_encode($service->toArray())
            );

            DB::commit();

            return redirect()->route('services.index')->with('success', 'Data berhasil diperbarui');
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
     * @param  \App\Services  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Cari service berdasarkan ID
        $service = Service::findOrFail($id);

      
        try {


            // Hapus file gambar jika ada
            if (!empty($service->image)) {
                $imagePath = public_path('upload/services/' . $service->image);
                if (file_exists($imagePath)) {
                    @unlink($imagePath); // Menghapus file gambar
                }
            }



            // Hapus service dari tabel services
            $service->delete();

            // Mendapatkan ID pengguna yang sedang login
            $loggedInUserId = Auth::id();

            // Simpan log histori untuk operasi Delete
            $this->simpanLogHistori('Delete', 'Layanan', $id, $loggedInUserId, json_encode($service), null);

            // Commit service
            DB::commit();

            // Redirect kembali dengan pesan sukses
            return redirect()->route('services.index')->with('success', 'Layanan berhasil dihapus');
        } catch (\Exception $e) {
            // Rollback service jika terjadi error
            DB::rollBack();

            // Kembalikan pesan error
            return redirect()->route('services.index')->with('error', 'Gagal menghapus service: ' . $e->getMessage());
        }
    }
}
