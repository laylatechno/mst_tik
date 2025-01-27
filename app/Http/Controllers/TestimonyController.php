<?php

namespace App\Http\Controllers;

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
    function __construct()
    {
        $this->middleware('permission:testimony-list|testimony-create|testimony-edit|testimony-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:testimony-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:testimony-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:testimony-delete', ['only' => ['destroy']]);
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
            // 'name' => 'required',

            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:4096',
        ], [
            // 'name.required' => 'Nama wajib diisi.',

            'image.image' => 'Gambar harus dalam format jpeg, jpg, atau png',
            'image.mimes' => 'Format gambar harus jpeg, jpg, atau png',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 4 MB',
        ]);



        $input = $request->all();

        if ($image = $request->file('image')) {
            $destinationPath = 'upload/testimonial/';

            // Mengambil nama file asli dan ekstensinya
            $originalFileName = $image->getClientOriginalName();

            // Membaca tipe MIME dari file image
            $imageMimeType = $image->getMimeType();

            // Menyaring hanya tipe MIME image yang didukung (misalnya, image/jpeg, image/png, dll.)
            if (strpos($imageMimeType, 'image/') === 0) {
                // Menggabungkan waktu dengan nama file asli
                $imageName = date('YmdHis') . '_' . str_replace(' ', '_', $originalFileName);

                // Simpan image asli ke tujuan yang diinginkan
                $image->move($destinationPath, $imageName);

                // Path image asli
                $sourceImagePath = public_path($destinationPath . $imageName);

                // Path untuk menyimpan image WebP
                $webpImagePath = $destinationPath . pathinfo($imageName, PATHINFO_FILENAME) . '.webp';

                // Membaca image asli dan mengonversinya ke WebP jika tipe MIME-nya didukung
                switch ($imageMimeType) {
                    case 'image/jpeg':
                        $sourceImage = @imagecreatefromjpeg($sourceImagePath);
                        break;
                    case 'image/png':
                        $sourceImage = @imagecreatefrompng($sourceImagePath);
                        break;
                        // Tambahkan jenis MIME lain jika diperlukan
                    default:
                        // Jenis MIME tidak didukung, tangani kasus ini sesuai kebutuhan Anda
                        // Misalnya, tampilkan pesan kesalahan atau lakukan tindakan yang sesuai
                        break;
                }

                // Jika image asli berhasil dibaca
                if ($sourceImage !== false) {
                    // Membuat image baru dalam format WebP
                    imagewebp($sourceImage, $webpImagePath);

                    // Hapus image asli dari memori
                    imagedestroy($sourceImage);

                    // Hapus file asli setelah konversi selesai
                    @unlink($sourceImagePath);

                    // Simpan hanya nama file image ke dalam array input
                    $input['image'] = pathinfo($imageName, PATHINFO_FILENAME) . '.webp';
                } else {
                    // Gagal membaca image asli, tangani kasus ini sesuai kebutuhan Anda
                }
            } else {
                // Tipe MIME image tidak didukung, tangani kasus ini sesuai kebutuhan Anda
            }
        } else {
            // Set nilai default untuk image jika tidak ada image yang diunggah
            $input['image'] = '';
        }

        // Membuat testimony baru dan mendapatkan data pengguna yang baru dibuat
        $testimony = Testimony::create($input);

        // Simpan log histori
        $loggedInUserId = Auth::id();
        $this->simpanLogHistori('Create', 'Testimonial', $testimony->id, $loggedInUserId, null, json_encode($testimony));

        return redirect()->route('testimonial.index')->with('success', 'Data berhasil disimpan');
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
            
            
            'image' => 'image|mimes:jpeg,jpg,png|max:4096',
        ], [
            
    
        
            'image.image' => 'Gambar harus berupa file gambar.',
            'image.mimes' => 'Format gambar harus jpeg, jpg, atau png.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 4 MB.',
        ]);
        $testimony = Testimony::findOrFail($id);
    
        // Simpan data lama untuk log
        $oldData = $testimony->toArray();
    
        $input = $request->all();
    
      
    
        if ($image = $request->file('image')) {
            $destinationPath = 'upload/testimonial/';
    
            // Hapus gambar lama jika ada
            if ($testimony->image && file_exists(public_path($destinationPath . $testimony->image))) {
                unlink(public_path($destinationPath . $testimony->image));
            }
    
            // Mengambil nama file asli dan ekstensinya
            $originalFileName = $image->getClientOriginalName();
    
            // Membaca tipe MIME dari file image
            $imageMimeType = $image->getMimeType();
    
            // Menyaring hanya tipe MIME image yang didukung
            if (strpos($imageMimeType, 'image/') === 0) {
                // Menggabungkan waktu dengan nama file asli
                $imageName = date('YmdHis') . '_' . str_replace(' ', '_', $originalFileName);
    
                // Simpan image asli ke tujuan yang diinginkan
                $image->move($destinationPath, $imageName);
    
                // Path image asli
                $sourceImagePath = public_path($destinationPath . $imageName);
    
                // Path untuk menyimpan image WebP
                $webpImagePath = $destinationPath . pathinfo($imageName, PATHINFO_FILENAME) . '.webp';
    
                // Membaca image asli dan mengonversinya ke WebP
                $sourceImage = null;
                switch ($imageMimeType) {
                    case 'image/jpeg':
                        $sourceImage = @imagecreatefromjpeg($sourceImagePath);
                        break;
                    case 'image/png':
                        $sourceImage = @imagecreatefrompng($sourceImagePath);
                        break;
                    default:
                        break;
                }
    
                // Jika image asli berhasil dibaca
                if ($sourceImage !== false) {
                    // Membuat image baru dalam format WebP
                    imagewebp($sourceImage, $webpImagePath);
    
                    // Hapus image asli dari memori
                    imagedestroy($sourceImage);
    
                    // Hapus file asli setelah konversi selesai
                    @unlink($sourceImagePath);
    
                    // Simpan hanya nama file image ke dalam array input
                    $input['image'] = pathinfo($imageName, PATHINFO_FILENAME) . '.webp';
                }
            }
        } else {
            // Jika tidak ada upload image baru, gunakan image yang ada
            $input['image'] = $testimony->image;
        }
    
        // Update data testimony
        $testimony->update($input);
    
        // Simpan log histori
        $loggedInUserId = Auth::id();
        $this->simpanLogHistori(
            'Update',
            'Testimoni',
            $testimony->id,
            $loggedInUserId,
            json_encode($oldData),
            json_encode($testimony->toArray())
        );
    
        return redirect()->route('testimonial.index')->with('success', 'Data berhasil diperbarui');
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
