<?php

namespace App\Http\Controllers;

use App\Models\LogHistori;
use App\Models\Letter;
use App\Models\LetterCategory;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\ImageService;

class LetterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $imageService;
    function __construct(ImageService $imageService)
    {
        $this->middleware('permission:letter-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:letter-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:letter-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:letter-delete', ['only' => ['destroy']]);
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
        $title = "Halaman Surat";
        $subtitle = "Menu Surat";

        // Ambil data untuk dropdown select
        $data_letters = Letter::with(['recipient', 'sender'])->get();



        // Kirim semua data ke view
        return view('letter.index', compact('data_letters', 'title', 'subtitle'));
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Tambah Surat";
        $subtitle = "Menu Tambah Surat";
        $users = User::all();

        return view('letter.create', compact('title', 'subtitle','users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'letter_number' => 'required|string|max:255|unique:letters,letter_number',
            'category' => 'required|string|in:incoming,outgoing',
            'type' => 'required|string|in:Undangan,Undangan Pemerintahan,Undangan Komunitas,Peminjaman barang,Peminjaman Tempat,Pemberitahuan/informasi,Surat Keterangan,Surat Pengajuan,Surat Permohonan,Surat Kuasa',
            'date' => 'required|date',
            'sender_id' => 'nullable|exists:users,id',
            'recipient_id' => 'nullable|exists:users,id',
            'subject' => 'required|string|max:255',
            'content' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,jpeg,png,jpg,doc,docx|max:4096', // Tambahkan doc dan docx di sini
            'status' => 'required|string|in:pending,processed,completed,draft,sent',
        ], [
            'letter_number.required' => 'Nomor Surat wajib diisi.',
            'letter_number.unique' => 'Nomor Surat sudah digunakan.',
            'category.required' => 'Kategori Surat wajib dipilih.',
            'category.in' => 'Kategori Surat tidak valid.',
            'type.required' => 'Jenis Surat wajib dipilih.',
            'type.in' => 'Jenis Surat tidak valid.',
            'date.required' => 'Tanggal Surat wajib diisi.',
            'sender_id.exists' => 'Pengirim tidak ditemukan.',
            'recipient_id.exists' => 'Penerima tidak ditemukan.',
            'subject.required' => 'Perihal Surat wajib diisi.',
            'subject.max' => 'Perihal Surat maksimal 255 karakter.',
            'content.string' => 'Isi Surat harus berupa teks.',
            'attachment.mimes' => 'File harus berupa PDF, gambar (jpeg, png, jpg), atau dokumen Word (doc, docx).', // Pesan validasi diperbarui
            'attachment.max' => 'Ukuran file maksimal 4 MB.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
        ]);


        $data = $request->all();

        // Tetapkan user_id dari user yang sedang login
        $data['user_id'] = Auth::id();

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload/letters'), $fileName);

            // Hanya simpan nama file, bukan path lengkapnya
            $data['attachment'] = $fileName;
        }



        // Simpan data ke database
        $letter = Letter::create($data);

        // Catat log histori
        $loggedInUserId = Auth::id();
        $this->simpanLogHistori('Create', 'Asset', $letter->id, $loggedInUserId, null, json_encode($letter));

        return redirect()->route('letters.index')->with('success', 'Surat berhasil disimpan');
    }












    /**
     * Display the specified resource.
     *
     * @param  \App\Letters  $letter
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        // Judul untuk halaman
        $title = "Halaman Lihat Surat";
        $subtitle = "Menu Lihat Surat";



        // Ambil data letter berdasarkan ID
        $data_letters = Letter::findOrFail($id);




        // Kembalikan view dengan membawa data produk
        return view('letter.show', compact(
            'title',
            'subtitle',

            'data_letters',
        ));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Letters  $letter
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $title = "Edit Surat";
        $subtitle = "Menu Edit Surat";
        $data_letters = Letter::findOrFail($id);
        $users = User::all();

        return view('letter.edit', compact('title', 'subtitle', 'data_letters', 'users'));
    }



    public function update(Request $request, Letter $letter): RedirectResponse
    {
        $request->validate([
            'letter_number'  => 'required|string|max:255',
            'category'       => 'required|string|in:incoming,outgoing',
            'type'           => 'required|string|in:Undangan,Undangan Pemerintahan,Undangan Komunitas,Peminjaman barang,Peminjaman Tempat,Pemberitahuan/informasi,Surat Keterangan,Surat Pengajuan,Surat Permohonan,Surat Kuasa',
            'date'           => 'required|date',
            'sender_id'      => 'nullable|exists:users,id',
            'recipient_id'   => 'nullable|exists:users,id',
            'subject'        => 'required|string|max:255',
            'content'        => 'nullable|string',
            'attachment'     => 'nullable|file|mimes:pdf,jpeg,png,jpg,doc,docx|max:4096',
            'status'         => 'required|string|in:pending,processed,completed,draft,sent',
        ], [
            'letter_number.required'  => 'Nomor Surat wajib diisi.',
            'category.required'       => 'Kategori Surat wajib dipilih.',
            'category.in'             => 'Kategori Surat tidak valid.',
            'type.required'           => 'Jenis Surat wajib dipilih.',
            'type.in'                 => 'Jenis Surat tidak valid.',
            'date.required'           => 'Tanggal Surat wajib diisi.',
            'sender_id.exists'        => 'Pengirim tidak ditemukan.',
            'recipient_id.exists'     => 'Penerima tidak ditemukan.',
            'subject.required'        => 'Perihal Surat wajib diisi.',
            'subject.max'             => 'Perihal Surat maksimal 255 karakter.',
            'content.string'          => 'Isi Surat harus berupa teks.',
            'attachment.mimes'        => 'File harus berupa PDF, gambar (jpeg, png, jpg), atau dokumen Word (doc, docx).',
            'attachment.max'          => 'Ukuran file maksimal 4 MB.',
            'status.required'         => 'Status wajib dipilih.',
            'status.in'               => 'Status tidak valid.',
        ]);

        // Simpan data lama untuk log histori
        $oldData = $letter->toArray();

        $input = $request->all();

        // Jika ada file attachment baru, hapus file lama (jika ada) dan simpan file baru
        if ($request->hasFile('attachment')) {
            if ($letter->attachment && file_exists(public_path('upload/letters/' . $letter->attachment))) {
                \File::delete(public_path('upload/letters/' . $letter->attachment));
            }
            $file = $request->file('attachment');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload/letters'), $fileName);
            $input['attachment'] = $fileName;
        } else {
            // Jika tidak ada file baru, gunakan file attachment yang sudah ada
            $input['attachment'] = $letter->attachment;
        }

        // Update data surat
        $letter->update($input);

        // Catat log histori (misalnya di tabel history_logs)
        $loggedInUserId = Auth::id();
        $this->simpanLogHistori(
            'Update',
            'Letter',
            $letter->id,
            $loggedInUserId,
            json_encode($oldData),
            json_encode($letter->toArray())
        );

        return redirect()->route('letters.index')->with('success', 'Data berhasil diperbarui');
    }








    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Letters  $letter
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Mulai transaksi database
        \DB::beginTransaction();

        // Cari letter berdasarkan ID
        $letter = Letter::findOrFail($id);

        try {
            // Hapus file attachment jika ada
            if (!empty($letter->attachment)) {
                $filePath = public_path('upload/letters/' . $letter->attachment);
                if (file_exists($filePath)) {
                    @unlink($filePath); // Menghapus file
                }
            }

            // Hapus record letter dari tabel letters
            $letter->delete();

            // Mendapatkan ID pengguna yang sedang login
            $loggedInUserId = \Auth::id();

            // Simpan log histori untuk operasi Delete
            $this->simpanLogHistori('Delete', 'Letter', $id, $loggedInUserId, json_encode($letter), null);

            // Commit transaksi
            \DB::commit();

            return redirect()->route('letters.index')->with('success', 'Surat berhasil dihapus');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            \DB::rollBack();

            return redirect()->route('letters.index')->with('error', 'Gagal menghapus surat: ' . $e->getMessage());
        }
    }
}
