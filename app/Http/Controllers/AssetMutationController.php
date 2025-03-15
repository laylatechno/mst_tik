<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\LogHistori;
use App\Models\AssetMutation;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\ImageService;

class AssetMutationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $imageService;
    function __construct(ImageService $imageService)
    {
        $this->middleware('permission:assetmutation-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:assetmutation-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:assetmutation-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:assetmutation-delete', ['only' => ['destroy']]);
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
     */ public function index(Request $request): View
    {
        $title = "Halaman Mutasi Aset";
        $subtitle = "Menu Mutasi Aset";

        // Ambil data untuk dropdown select
        $data_assetmutations = AssetMutation::with(['user', 'asset', 'previousRoom', 'newRoom'])->get();

        // Kirim semua data ke view
        return view('asset_mutation.index', compact('data_assetmutations', 'title', 'subtitle'));
    }






    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $title = "Halaman Tambah Mutasi Aset";
        $subtitle = "Menu Tambah Mutasi Aset";

        $users = User::all();
        $rooms = Room::all();
        $assets = Asset::with('room')->get(); // Tambahkan relasi room

        // Kirim data ke view
        return view('asset_mutation.create', compact('title', 'subtitle', 'users', 'rooms', 'assets'));
    }



    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'mutation_date' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'asset_id' => 'required|exists:assets,id',
            'previous_room_id' => 'required|exists:rooms,id',
            'new_room_id' => 'required|exists:rooms,id',
            'status' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:4096',
        ], [
            'mutation_date.required' => 'Tanggal Mutasi wajib diisi.',
            'user_id.required' => 'Penanggung Jawab wajib dipilih.',
            'asset_id.required' => 'Nama Aset wajib dipilih.',
            'previous_room_id.required' => 'Lokasi Lama wajib dipilih.',
            'new_room_id.required' => 'Lokasi Baru wajib dipilih.',
            'status.required' => 'Status wajib dipilih.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, jpg, atau png.',
            'image.max' => 'Ukuran gambar maksimal 4 MB.',
        ]);

        // Mengambil semua input
        $input = $request->all();

        // Upload dan konversi gambar menggunakan service
        if ($request->hasFile('image')) {
            $input['image'] = $this->imageService->handleImageUpload(
                $request->file('image'),
                'upload/asset_mutations'
            );
        } else {
            $input['image'] = '';
        }

        // Simpan data mutasi aset
        $assetmutation = AssetMutation::create($input);

        // Update tabel assets berdasarkan mutasi
        $asset = Asset::findOrFail($request->asset_id);
        $asset->room_id = $request->new_room_id; // Update lokasi aset
        $asset->status = $request->status; // Update status aset
        $asset->save();

        // Simpan log histori
        $loggedInUserId = Auth::id();
        $this->simpanLogHistori('Create', 'AssetMutation', $assetmutation->id, $loggedInUserId, null, json_encode($assetmutation));

        return redirect()->route('asset_mutations.index')->with('success', 'Data berhasil disimpan dan aset berhasil diperbarui');
    }

 

    /**
     * Display the specified resource.
     *
     * @param  \App\AssetMutations  $assetmutation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Judul untuk halaman
        $title = "Halaman Lihat Mutasi Aset";
        $subtitle = "Menu Lihat Mutasi Aset";

        // Ambil data assetmutation berdasarkan ID dengan relasi
        $data_asset_mutations = AssetMutation::with(['user', 'asset', 'previousRoom', 'newRoom'])->findOrFail($id);

        // Kembalikan view dengan membawa data
        return view('asset_mutation.show', compact(
            'title',
            'subtitle',
            'data_asset_mutations'
        ));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AssetMutations  $assetmutation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Halaman Edit Mutasi Aset";
        $subtitle = "Menu Edit Mutasi Aset";

        // Ambil data assetmutation berdasarkan ID
        $data_asset_mutations = AssetMutation::findOrFail($id);

        // Ambil data untuk dropdown dengan eager loading room
        $assets = Asset::with('room')->get();
        $users = User::all();
        $rooms = Room::all();

        // Kirim data ke view
        return view('asset_mutation.edit', compact(
            'title',
            'subtitle',
            'data_asset_mutations',
            'assets',
            'rooms',
            'users'
        ));
    }



    public function update(Request $request, $id): RedirectResponse
    {
        // Temukan data mutasi aset
        $assetmutation = AssetMutation::findOrFail($id);

        $request->validate([
            'mutation_date' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'asset_id' => 'required|exists:assets,id',
            'previous_room_id' => 'required|exists:rooms,id',
            'new_room_id' => 'required|exists:rooms,id',
            'status' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:4096',
        ], [
            'mutation_date.required' => 'Tanggal Mutasi wajib diisi.',
            'user_id.required' => 'Penanggung Jawab wajib dipilih.',
            'asset_id.required' => 'Nama Aset wajib dipilih.',
            'previous_room_id.required' => 'Lokasi Lama wajib dipilih.',
            'new_room_id.required' => 'Lokasi Baru wajib dipilih.',
            'status.required' => 'Status wajib dipilih.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, jpg, atau png.',
            'image.max' => 'Ukuran gambar maksimal 4 MB.',
        ]);

        // Simpan data lama untuk log
        $oldData = $assetmutation->toArray();
        $input = $request->all();

        // Upload dan konversi gambar menggunakan service
        if ($request->hasFile('image')) {
            $input['image'] = $this->imageService->handleImageUpload(
                $request->file('image'),
                'upload/asset_mutations',
                $assetmutation->image // Pass old image for deletion
            );
        } else {
            $input['image'] = $assetmutation->image; // Gunakan gambar yang sudah ada
        }

        // Update data assetmutation
        $assetmutation->update($input);

        // Update tabel assets berdasarkan mutasi
        $asset = Asset::findOrFail($request->asset_id);
        $asset->room_id = $request->new_room_id; // Update lokasi aset
        $asset->status = $request->status; // Update status aset
        $asset->save();

        // Simpan log histori
        $loggedInUserId = Auth::id();
        $this->simpanLogHistori(
            'Update',
            'AssetMutation',
            $assetmutation->id,
            $loggedInUserId,
            json_encode($oldData),
            json_encode($assetmutation->toArray())
        );

        return redirect()->route('asset_mutations.index')->with('success', 'Data berhasil diperbarui');
    }









    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AssetMutations  $assetmutation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Cari assetmutation berdasarkan ID
        $assetmutation = AssetMutation::findOrFail($id);


        try {


            // Hapus file gambar jika ada
            if (!empty($assetmutation->image)) {
                $imagePath = public_path('upload/asset_mutations/' . $assetmutation->image);
                if (file_exists($imagePath)) {
                    @unlink($imagePath); // Menghapus file gambar
                }
            }



            // Hapus assetmutation dari tabel assetmutations
            $assetmutation->delete();

            // Mendapatkan ID pengguna yang sedang login
            $loggedInUserId = Auth::id();

            // Simpan log histori untuk operasi Delete
            $this->simpanLogHistori('Delete', 'AssetMutation', $id, $loggedInUserId, json_encode($assetmutation), null);

            // Commit assetmutation
            DB::commit();

            // Redirect kembali dengan pesan sukses
            return redirect()->route('asset_mutations.index')->with('success', 'Mutasi Aset berhasil dihapus');
        } catch (\Exception $e) {
            // Rollback assetmutation jika terjadi error
            DB::rollBack();

            // Kembalikan pesan error
            return redirect()->route('asset_mutations.index')->with('error', 'Gagal menghapus assetmutation: ' . $e->getMessage());
        }
    }
}
