<?php

namespace App\Http\Controllers;

use App\Models\LogHistori;
use App\Models\Team;

use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $imageService;
    function __construct(ImageService $imageService)
    {
        $this->middleware('permission:team-list|team-create|team-edit|team-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:team-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:team-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:team-delete', ['only' => ['destroy']]);
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
        $title = "Halaman Team";
        $subtitle = "Menu Team";
        $data_teams = Team::all();
        return view('team.index', compact('data_teams', 'title', 'subtitle'));
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $title = "Halaman Tambah Team";
        $subtitle = "Menu Tambah Team";
        return view('team.create', compact('title', 'subtitle'));
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
                    'upload/teams'
                );
            } else {
                $input['image'] = '';
            }

            // Simpan data team
            $team = Team::create($input);

            // Simpan log histori setelah semua proses berhasil
            $loggedInUserId = Auth::id();
            $this->simpanLogHistori('Create', 'Team', $team->id, $loggedInUserId, null, json_encode($team));

            DB::commit();

            return redirect()->route('teams.index')->with('success', 'Data berhasil disimpan');
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
     * @param  \App\Teams  $team
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        // Judul untuk halaman
        $title = "Halaman Lihat Team";
        $subtitle = "Menu Lihat Team";



        // Ambil data team berdasarkan ID
        $data_teams = Team::findOrFail($id);

        // Kembalikan view dengan membawa data produk
        return view('team.show', compact(
            'title',
            'subtitle',

            'data_teams',
        ));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Teams  $team
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $title = "Halaman Edit Team";
        $subtitle = "Menu Edit Team";


        // Ambil data team berdasarkan ID
        $data_teams = Team::findOrFail($id);

        // Kirim data ke view
        return view('team.edit', compact(
            'title',
            'subtitle',

            'data_teams',
        ));
    }


    public function update(Request $request, Team $team): RedirectResponse
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

            $oldData = $team->toArray();
            $input = $request->all();

            // Upload dan konversi gambar menggunakan service
            if ($request->hasFile('image')) {
                $input['image'] = $this->imageService->handleImageUpload(
                    $request->file('image'),
                    'upload/teams',
                    $team->image // Pass old image for deletion
                );
            } else {
                $input['image'] = $team->image; // Gunakan gambar yang sudah ada
            }

            // Update data team
            $team->update($input);

            // Simpan log histori setelah semua proses berhasil
            $loggedInUserId = Auth::id();
            $this->simpanLogHistori(
                'Update',
                'Team',
                $team->id,
                $loggedInUserId,
                json_encode($oldData),
                json_encode($team->toArray())
            );

            DB::commit();

            return redirect()->route('teams.index')->with('success', 'Data berhasil diperbarui');
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
     * @param  \App\Teams  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Cari team berdasarkan ID
        $team = Team::findOrFail($id);

      
        try {


            // Hapus file gambar jika ada
            if (!empty($team->image)) {
                $imagePath = public_path('upload/teams/' . $team->image);
                if (file_exists($imagePath)) {
                    @unlink($imagePath); // Menghapus file gambar
                }
            }



            // Hapus team dari tabel teams
            $team->delete();

            // Mendapatkan ID pengguna yang sedang login
            $loggedInUserId = Auth::id();

            // Simpan log histori untuk operasi Delete
            $this->simpanLogHistori('Delete', 'Team', $id, $loggedInUserId, json_encode($team), null);

            // Commit team
            DB::commit();

            // Redirect kembali dengan pesan sukses
            return redirect()->route('teams.index')->with('success', 'Team berhasil dihapus');
        } catch (\Exception $e) {
            // Rollback team jika terjadi error
            DB::rollBack();

            // Kembalikan pesan error
            return redirect()->route('teams.index')->with('error', 'Gagal menghapus team: ' . $e->getMessage());
        }
    }
}
