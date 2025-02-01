<?php

namespace App\Http\Controllers;

use App\Models\LogHistori;

use App\Models\Product;
use App\Models\AdjustmentDetail;
use App\Models\Adjustment;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\ImageService;



class AdjustmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $imageService;
    function __construct(ImageService $imageService)
    {
        $this->middleware('permission:adjustment-list|adjustment-create|adjustment-edit|adjustment-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:adjustment-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:adjustment-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:adjustment-delete', ['only' => ['destroy']]);
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
        $title = "Halaman Adjustment";
        $subtitle = "Menu Adjustment";

        // Ambil data hanya yang diperlukan untuk dropdown dan tabel
        $data_adjustment = Adjustment::all(); // Ambil hanya kolom penting



        return view('adjustment.index', compact('data_adjustment', 'title', 'subtitle'));
    }







    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $title = "Halaman Tambah Adjustment";
        $subtitle = "Menu Tambah Adjustment";

        // Ambil data untuk dropdown select
        $data_products = Product::all();


        // Kirim data ke view
        return view('adjustment.create', compact('title', 'subtitle', 'data_products'));
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */






    public function store(Request $request)
    {


        $request->validate([
            'adjustment_date' => 'required|date',
            'description' => 'nullable|string',
            'product_id' => 'required|array',
            'quantity' => 'required|array',
            'reason' => 'required|array',
            'total' => 'required|array',
            'image' => 'nullable|mimes:jpg,jpeg,png,gif|max:4048', // Validasi untuk gambar
        ], [
            // Pesan error kustom
            'adjustment_date.required' => 'Tanggal penyesuaian wajib diisi.',
            'adjustment_date.date' => 'Tanggal penyesuaian harus berupa format tanggal yang valid.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'product_id.required' => 'Produk harus dipilih.',
            'product_id.array' => 'Data produk tidak valid.',
            'quantity.required' => 'Jumlah produk wajib diisi.',
            'quantity.array' => 'Data jumlah produk tidak valid.',
            'reason.required' => 'Alasan penyesuaian wajib diisi.',
            'reason.array' => 'Data alasan penyesuaian tidak valid.',
            'total.required' => 'Total wajib diisi.',
            'total.array' => 'Data total tidak valid.',
            'image.mimes' => 'Gambar yang dimasukkan hanya diperbolehkan berekstensi JPG, JPEG, PNG, atau GIF.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 4 MB.',
        ]);




        $imageName = null;
            if ($request->hasFile('image')) {
                $imageName = $this->imageService->handleImageUpload(
                    $request->file('image'),
                    'upload/adjustments'
                );
            }

        // Proses penyimpanan dalam transaksi database
        DB::transaction(function () use ($request, $imageName) {
            // Simpan adjustment utama
            $adjustment = Adjustment::create([
                'adjustment_number' => 'ADJ-' . now()->format('YmdHis'),
                'adjustment_date' => $request->adjustment_date,
                'user_id' => auth()->id(),
                'description' => $request->description,
                'image' => $imageName, // Simpan nama file gambar
                'total' => array_sum(array_map(function ($qty, $price) {
                    return $qty * $price;
                }, $request->quantity, array_map('intval', $request->cost_price))),
            ]);

            // Simpan detail adjustment dan update stok produk
            foreach ($request->product_id as $index => $productId) {
                AdjustmentDetail::create([
                    'adjustment_id' => $adjustment->id,
                    'product_id' => $productId,
                    'quantity' => $request->quantity[$index],
                    'reason' => $request->reason[$index],
                ]);

                // Update stok produk
                $product = Product::find($productId);
                $product->stock += $request->quantity[$index];
                $product->save();
            }
        });

        return redirect()->route('adjustments.index')->with('success', 'Data berhasil disimpan dan stok diperbarui!');
    }






    /**
     * Display the specified resource.
     *
     * @param  \App\Adjustments  $adjustment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = "Halaman Liht Adjustment";
        $subtitle = "Menu Liht Adjustment";
        $adjustment = Adjustment::with('details.product')->findOrFail($id);


        // Kembalikan view dengan membawa data produk
        return view('adjustment.show', compact(
            'adjustment',
            'title',
            'subtitle',
        ));
    }

    public function print($id)
    {
        // Judul untuk halaman
        $title = "Halaman Lihat Adjustment";
        $subtitle = "Menu Lihat Adjustment";
        $data_adjustment = Adjustment::findOrFail($id);
        $data_products = Product::all(); // Ambil data produk terkait

        return view('adjustment.print', compact('data_adjustment', 'data_products', 'title', 'subtitle'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Adjustments  $adjustment
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View {}







    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Adjustments  $adjustment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {}







    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Adjustments  $adjustment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Cari Adjustment berdasarkan ID
        $adjustment = Adjustment::findOrFail($id);

        // Mulai transaksi database untuk memastikan konsistensi
        DB::beginTransaction();
        try {
            // Hapus file gambar jika ada
            if (!empty($adjustment->image)) {
                $imagePath = public_path('upload/adjustment/' . $adjustment->image);
                if (file_exists($imagePath)) {
                    if (!unlink($imagePath)) {
                        // Jika gambar gagal dihapus, lemparkan exception
                        throw new \Exception('Gagal menghapus gambar');
                    }
                }
            }

            // Hapus data Adjustment
            $adjustment->delete();

            // Mendapatkan ID pengguna yang sedang login
            $loggedInUserId = Auth::id();

            // Simpan log histori untuk operasi Delete
            $this->simpanLogHistori('Delete', 'Adjustment', $id, $loggedInUserId, json_encode($adjustment), null);

            // Commit transaksi
            DB::commit();

            // Redirect kembali dengan pesan sukses
            return redirect()->route('adjustments.index')->with('success', 'Adjustment berhasil dihapus');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();

            // Kembalikan pesan error
            return redirect()->route('adjustments.index')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
