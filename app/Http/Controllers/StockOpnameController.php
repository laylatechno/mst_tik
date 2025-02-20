<?php

namespace App\Http\Controllers;

use App\Models\LogHistori;
use App\Models\StockOpname;
use App\Models\Category;
use App\Models\CustomerCategory;
use App\Models\Product;
use App\Models\StockOpnameDetail;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Services\ImageService;


class StockOpnameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $imageService;
    function __construct(ImageService $imageService)
    {
        $this->middleware('permission:stockopname-list|stockopname-create|stockopname-edit|stockopname-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:stockopname-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:stockopname-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:stockopname-delete', ['only' => ['destroy']]);
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
        $title = "Halaman Stock Opname";
        $subtitle = "Menu Stock Opname";

     
        $user = auth()->user(); // Ambil user yang sedang login 

        
        if ($user->can('user-access')) {
            $data_stock_opname = StockOpname::with('user')->get();
        } else {
            // Jika tidak, hanya tampilkan supplier dengan user_id yang sesuai dengan user yang login
            $data_stock_opname = StockOpname::where('user_id', $user->id)->with('user')->get();
        }



        return view('stock_opname.index', compact('data_stock_opname', 'title', 'subtitle'));
    }







    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $title = "Halaman Tambah Stock Opname";
        $subtitle = "Menu Tambah Stock Opname";

        // Ambil data untuk dropdown select
        $data_products = Product::all();

        $users = User::all();
        // Kirim data ke view
        return view('stock_opname.create', compact('title', 'subtitle', 'data_products','users'));
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */






     public function store(Request $request)
     {
         // Validasi input
         $request->validate([
             'opname_date' => 'required|date',
             'description' => 'nullable|string',
             'products' => 'required|array',
             'products.*.product_id' => 'required|exists:products,id',
             'products.*.system_stock' => 'required|integer|min:0',
             'products.*.physical_stock' => 'required|integer|min:0',
             'image' => 'nullable|mimes:jpg,jpeg,png,gif|max:4048',
             'user_id' => 'nullable|exists:users,id', // Pastikan user_id valid jika ada
         ], [
             'opname_date.required' => 'Tanggal opname wajib diisi.',
             'opname_date.date' => 'Tanggal opname harus berupa format tanggal yang valid.',
             'products.required' => 'Produk wajib dipilih.',
             'products.*.product_id.required' => 'ID produk wajib diisi.',
             'products.*.product_id.exists' => 'Produk yang dipilih tidak valid.',
             'products.*.system_stock.required' => 'Stok sistem wajib diisi.',
             'products.*.physical_stock.required' => 'Stok fisik wajib diisi.',
             'image.mimes' => 'Bukti hanya diperbolehkan berekstensi JPG, JPEG, PNG, dan GIF.',
             'image.max' => 'Ukuran gambar tidak boleh lebih dari 4 MB.',
             'user_id.exists' => 'User yang dipilih tidak valid.',
         ]);
     
         $data = $request->only(['opname_date', 'description']);
     
         // Menentukan user_id yang akan disimpan
         $loggedInUserId = Auth::id();
         $userIdToSave = $request->filled('user_id') && Auth::user()->can('user-access')
             ? $request->user_id
             : $loggedInUserId;
     
         // Menangani gambar (jika ada)
         if ($request->hasFile('image')) {
             $data['image'] = $this->imageService->handleImageUpload(
                 $request->file('image'),
                 'upload/stock_opname'
             );
         } else {
             $data['image'] = '';
         }
     
         // Buat Stock Opname
         $stockOpname = StockOpname::create([
             'opname_number' => 'SO-' . time(),
             'opname_date' => $data['opname_date'],
             'description' => $data['description'],
             'image' => $data['image'] ?? null,
             'user_id' => $userIdToSave, // Simpan user_id
         ]);
     
         // Tambahkan detail produk
         foreach ($request->products as $product) {
             if (!isset($product['product_id'])) {
                 continue;
             }
     
             StockOpnameDetail::create([
                 'stock_opname_id' => $stockOpname->id,
                 'product_id' => $product['product_id'],
                 'system_stock' => $product['system_stock'],
                 'physical_stock' => $product['physical_stock'],
                 'difference' => $product['physical_stock'] - $product['system_stock'],
                 'description_detail' => $product['description_detail'] ?? null,
             ]);
         }
     
         return redirect()->route('stock_opname.index')->with('success', 'Stock Opname berhasil disimpan.');
     }
     




    /**
     * Display the specified resource.
     *
     * @param  \App\StockOpnames  $stock_opname
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Ambil data stock opname yang sedang diedit
        $data_stock_opname = StockOpname::with('stockOpnameDetails.product')->findOrFail($id);

        // Ambil data produk yang tersedia
        $data_products = Product::all();

        // Judul untuk halaman
        $title = "Halaman Lihat Stock Opname";
        $subtitle = "Menu Lihat Stock Opname";

        // Kembalikan view dengan membawa data produk
        return view('stock_opname.show', compact(
            'data_stock_opname',
            'title',
            'subtitle',
            'data_products'
        ));
    }

    public function print($id)
    {
           // Judul untuk halaman
           $title = "Halaman Lihat Stock Opname";
           $subtitle = "Menu Lihat Stock Opname";
        $data_stock_opname = StockOpname::findOrFail($id);
        $data_products = Product::all(); // Ambil data produk terkait

        return view('stock_opname.print', compact('data_stock_opname', 'data_products','title','subtitle'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StockOpnames  $stock_opname
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $title = "Halaman Edit Stock Opname";
        $subtitle = "Menu Edit Stock Opname";

        // Ambil data stock opname yang sedang diedit
        $data_stock_opname = StockOpname::with('stockOpnameDetails.product')->findOrFail($id);

        // Ambil data produk yang tersedia
        $data_products = Product::all();
        $users = User::all();
        // Kirim data ke view
        return view('stock_opname.edit', compact(
            'data_stock_opname',
            'users',
            'title',
            'subtitle',
            'data_products'
        ));
    }







    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StockOpnames  $stock_opname
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'opname_date' => 'required|date',
            'description' => 'nullable|string',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.system_stock' => 'required|integer|min:0',
            'products.*.physical_stock' => 'required|integer|min:0',
            'image' => 'nullable|mimes:jpg,jpeg,png,gif|max:4048',
        ], [
            'opname_date.required' => 'Tanggal opname wajib diisi.',
            'opname_date.date' => 'Tanggal opname harus berupa format tanggal yang valid.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'products.required' => 'Produk wajib dipilih.',
            'products.array' => 'Produk harus dalam bentuk array.',
            'products.*.product_id.required' => 'ID produk wajib diisi.',
            'products.*.product_id.exists' => 'Produk yang dipilih tidak valid.',
            'products.*.system_stock.required' => 'Stok sistem wajib diisi.',
            'products.*.system_stock.integer' => 'Stok sistem harus berupa angka.',
            'products.*.system_stock.min' => 'Stok sistem tidak boleh kurang dari 0.',
            'products.*.physical_stock.required' => 'Stok fisik wajib diisi.',
            'products.*.physical_stock.integer' => 'Stok fisik harus berupa angka.',
            'products.*.physical_stock.min' => 'Stok fisik tidak boleh kurang dari 0.',
            'image.mimes' => 'Bukti yang dimasukkan hanya diperbolehkan berekstensi JPG, JPEG, PNG, dan GIF.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 4 MB.',
        ]);
    
        // Temukan data stock opname
        $data_stock_opname = StockOpname::findOrFail($id);
    
        // Tentukan user_id yang akan disimpan
        $loggedInUserId = Auth::id();
        $userIdToSave = $request->filled('user_id') && Auth::user()->can('user-access')
            ? $request->user_id
            : $loggedInUserId;
    
        // Update data utama
        $data = $request->only(['opname_date', 'description']);
        $data['user_id'] = $userIdToSave; // Tambahkan user_id ke dalam data yang diperbarui
        $data_stock_opname->update($data);
    
        // Handle image upload menggunakan ImageService
        if ($request->hasFile('image')) {
            try {
                $data_stock_opname->image = $this->imageService->handleImageUpload(
                    $request->file('image'),
                    'upload/stock_opname',
                    $data_stock_opname->image // Pass gambar lama untuk dihapus
                );
                $data_stock_opname->save();
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal mengupload gambar: ' . $e->getMessage());
            }
        }
    
        // Update detail produk
        foreach ($request->input('products') as $productData) {
            $data_stock_opname->stockOpnameDetails()->updateOrCreate(
                ['product_id' => $productData['product_id']],
                [
                    'system_stock' => $productData['system_stock'],
                    'physical_stock' => $productData['physical_stock'],
                    'difference' => $productData['physical_stock'] - $productData['system_stock'],
                    'description_detail' => $productData['description_detail']
                ]
            );
        }
    
        return redirect()->route('stock_opname.index')->with('success', 'Stock Opname berhasil diperbarui.');
    }
    







    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StockOpnames  $stock_opname
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Cari StockOpname berdasarkan ID
        $stock_opname = StockOpname::findOrFail($id);

        // Mulai transaksi database untuk memastikan konsistensi
        DB::beginTransaction();
        try {
            // Hapus file gambar jika ada
            if (!empty($stock_opname->image)) {
                $imagePath = public_path('upload/stock_opname/' . $stock_opname->image);
                if (file_exists($imagePath)) {
                    if (!unlink($imagePath)) {
                        // Jika gambar gagal dihapus, lemparkan exception
                        throw new \Exception('Gagal menghapus gambar');
                    }
                }
            }

            // Hapus data StockOpname
            $stock_opname->delete();

            // Mendapatkan ID pengguna yang sedang login
            $loggedInUserId = Auth::id();

            // Simpan log histori untuk operasi Delete
            $this->simpanLogHistori('Delete', 'Stock Opname', $id, $loggedInUserId, json_encode($stock_opname), null);

            // Commit transaksi
            DB::commit();

            // Redirect kembali dengan pesan sukses
            return redirect()->route('stock_opname.index')->with('success', 'Stock Opname berhasil dihapus');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();

            // Kembalikan pesan error
            return redirect()->route('stock_opname.index')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
