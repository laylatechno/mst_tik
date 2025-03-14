<?php

namespace App\Http\Controllers;

use App\Models\LogHistori;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Services\ImageService;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $imageService;
    function __construct(ImageService $imageService)
    {
        $this->middleware('permission:room-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:room-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:room-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:room-delete', ['only' => ['destroy']]);
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
        $title = "Halaman Ruangan";
        $subtitle = "Menu Ruangan";

        // Mengambil semua kategori dan mengurutkan berdasarkan kolom 'position' secara ascending
        $data_rooms = Room::all();

        return view('room.index', compact('data_rooms', 'title', 'subtitle'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $title = "Halaman Tambah Ruangan";
        $subtitle = "Menu Tambah Ruangan";
        return view('room.create', compact('title', 'subtitle'));
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
            'code' => 'required',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:4096',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'code.required' => 'Kode wajib diisi.',
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
                        'upload/rooms'
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
            $room = Room::create($input);

            // Simpan log histori
            $loggedInUserId = Auth::id();
            $this->simpanLogHistori(
                'Create',
                'Ruangan',
                $room->id,
                $loggedInUserId,
                null,
                json_encode($room)
            );

            return redirect()->route('rooms.index')
                ->with('success', 'Ruangan berhasil dibuat.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }




    /**
     * Display the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show($id): View

    {
        $title = "Halaman Lihat Ruangan";
        $subtitle = "Menu Lihat Ruangan";
        $data_rooms = Room::find($id);
        return view('room.show', compact('data_rooms', 'title', 'subtitle'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $title = "Halaman Edit Ruangan";
        $subtitle = "Menu Edit Ruangan";
        $data_rooms = Room::findOrFail($id);

        return view('room.edit', compact('data_rooms', 'title', 'subtitle'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:4096',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'code.required' => 'Kode wajib diisi.',
            'image.image' => 'Gambar harus dalam format jpeg, jpg, atau png',
            'image.mimes' => 'Format gambar harus jpeg, jpg, atau png',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 4 MB',
        ]);

        try {
            DB::beginTransaction();

            $oldData = $room->toArray();
            $input = $request->all();

            // Upload dan konversi gambar menggunakan service
            if ($request->hasFile('image')) {
                $input['image'] = $this->imageService->handleImageUpload(
                    $request->file('image'),
                    'upload/rooms',
                    $room->image // Pass old image for deletion
                );
            } else {
                $input['image'] = $room->image; // Gunakan gambar yang sudah ada
            }

            // Update data room
            $room->update($input);

            // Simpan log histori setelah semua proses berhasil
            $loggedInUserId = Auth::id();
            $this->simpanLogHistori(
                'Update',
                'Room',
                $room->id,
                $loggedInUserId,
                json_encode($oldData),
                json_encode($room->toArray())
            );

            DB::commit();

            return redirect()->route('rooms.index')->with('success', 'Data berhasil diperbarui');
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
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $room = Room::find($id);
        $room->delete();
        $loggedInRoomId = Auth::id();
        // Simpan log histori untuk operasi Delete dengan room_id yang sedang login dan informasi data yang dihapus
        $this->simpanLogHistori('Delete', 'Ruangan', $id, $loggedInRoomId, json_encode($room), null);
        // Redirect kembali dengan pesan sukses
        return redirect()->route('rooms.index')->with('success', 'Ruangan berhasil dihapus');
    }
}
