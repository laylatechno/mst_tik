<?php

namespace App\Http\Controllers;

use App\Models\LogHistori;
use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\ImageService;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $imageService;
    function __construct(ImageService $imageService)
    {
        $this->middleware('permission:asset-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:asset-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:asset-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:asset-delete', ['only' => ['destroy']]);
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
        $title = "Halaman Aset";
        $subtitle = "Menu Aset";

        // Ambil data untuk dropdown select
        $data_assets = Asset::with(['user', 'category','room'])->get();



        // Kirim semua data ke view
        return view('asset.index', compact('data_assets', 'title', 'subtitle'));
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $title = "Halaman Tambah Aset";
        $subtitle = "Menu Tambah Aset";
        $data_asset_categories = AssetCategory::all();
        $users = User::all();
        $rooms = Room::all();

        // Kirim data ke view
        return view('asset.create', compact('title', 'subtitle', 'data_asset_categories','users','rooms'));
    }



    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'name' => 'required|string|max:255|unique:assets,name',
            'code' => 'required|string|max:100',
            'asset_category_id' => 'required|exists:asset_categories,id',
            'purchase_date' => 'required|date',
            'value' => 'required|min:0',
            'condition' => 'required|string',
            'room_id' => 'required|string|max:255',
            'status' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:4096',
        ], [
            'name.required' => 'Nama Aset wajib diisi.',
            'name.unique' => 'Nama Aset sudah ada.',
            'room_id.required' => 'Ruangan wajib diisi.',
            'code.required' => 'Kode wajib diisi.',
            'value.required' => 'Harga wajib diisi.',
            'purchase_date.required' => 'Tanggal beli wajib diisi.',
            'asset_category_id.required' => 'Kategori wajib dipilih.',
            'status.required' => 'Status wajib dipilih.',
        ]);




        // Mengambil semua input dan memproses harga
        $input = $request->all();

        $input['value'] = str_replace(',', '', $input['value']);

        // Upload dan konversi gambar menggunakan service
        if ($request->hasFile('image')) {
            $input['image'] = $this->imageService->handleImageUpload(
                $request->file('image'),
                'upload/assets'
            );
        } else {
            $input['image'] = '';
        }

        $asset = Asset::create($input);

        $loggedInUserId = Auth::id();
        $this->simpanLogHistori('Create', 'Asset', $asset->id, $loggedInUserId, null, json_encode($asset));

        return redirect()->route('assets.index')->with('success', 'Data berhasil disimpan');
    }











    /**
     * Display the specified resource.
     *
     * @param  \App\Assets  $asset
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        // Judul untuk halaman
        $title = "Halaman Lihat Aset";
        $subtitle = "Menu Lihat Aset";



        // Ambil data asset berdasarkan ID
        $data_assets = Asset::with('category')->find($id);



        // Kembalikan view dengan membawa data produk
        return view('asset.show', compact(
            'title',
            'subtitle',

            'data_assets',
        ));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Assets  $asset
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $title = "Halaman Edit Aset";
        $subtitle = "Menu Edit Aset";

        // Ambil data asset berdasarkan ID
        $data_assets = Asset::findOrFail($id);
        $data_asset_categories = AssetCategory::all();

      
        $users = User::all();  
        $rooms = Room::all();

        // Kirim data ke view
        return view('asset.edit', compact(
            'title',
            'subtitle',
            'data_assets',
            'data_asset_categories',
            'rooms',
            'users' // 
        ));
    }



    public function update(Request $request, Asset $asset): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255 ',
            'code' => 'required|string|max:100',
            'asset_category_id' => 'required|exists:asset_categories,id',
            'purchase_date' => 'required|date',
            'value' => 'required|min:0',
            'condition' => 'required|string',
            'room_id' => 'required|string|max:255',
            'status' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:4096',
        ], [
            'name.required' => 'Nama Aset wajib diisi.',
            'code.required' => 'Kode wajib diisi.',
            'value.required' => 'Harga wajib diisi.',
            'purchase_date.required' => 'Tanggal beli wajib diisi.',
            'asset_category_id.required' => 'Kategori wajib dipilih.',
            'status.required' => 'Status wajib dipilih.',
        ]);


        // Simpan data lama untuk log
        $oldData = $asset->toArray();

        $input = $request->all();
        $input['value'] = str_replace(',', '', $input['value']);

        // Upload dan konversi gambar menggunakan service
        if ($request->hasFile('image')) {
            $input['image'] = $this->imageService->handleImageUpload(
                $request->file('image'),
                'upload/assets',
                $asset->image // Pass old image for deletion
            );
        } else {
            $input['image'] = $asset->image; // Gunakan gambar yang sudah ada
        }

        // Update data asset
        $asset->update($input);

        // Simpan log histori
        $loggedInUserId = Auth::id();
        $this->simpanLogHistori(
            'Update',
            'Asset',
            $asset->id,
            $loggedInUserId,
            json_encode($oldData),
            json_encode($asset->toArray())
        );

        return redirect()->route('assets.index')->with('success', 'Data berhasil diperbarui');
    }









    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Assets  $asset
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Cari asset berdasarkan ID
        $asset = Asset::findOrFail($id);


        try {


            // Hapus file gambar jika ada
            if (!empty($asset->image)) {
                $imagePath = public_path('upload/assets/' . $asset->image);
                if (file_exists($imagePath)) {
                    @unlink($imagePath); // Menghapus file gambar
                }
            }



            // Hapus asset dari tabel assets
            $asset->delete();

            // Mendapatkan ID pengguna yang sedang login
            $loggedInUserId = Auth::id();

            // Simpan log histori untuk operasi Delete
            $this->simpanLogHistori('Delete', 'Asset', $id, $loggedInUserId, json_encode($asset), null);

            // Commit asset
            DB::commit();

            // Redirect kembali dengan pesan sukses
            return redirect()->route('assets.index')->with('success', 'Aset berhasil dihapus');
        } catch (\Exception $e) {
            // Rollback asset jika terjadi error
            DB::rollBack();

            // Kembalikan pesan error
            return redirect()->route('assets.index')->with('error', 'Gagal menghapus asset: ' . $e->getMessage());
        }
    }
}
