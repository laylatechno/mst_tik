<?php

namespace App\Http\Controllers;

use App\Models\Cash;
use App\Models\LogHistori;
use App\Models\Product;
use App\Models\Profil;
use App\Models\Profit;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\ImageService;
use Yajra\DataTables\Facades\DataTables;

class PurchaseController extends Controller
{
    protected $imageService;
    function __construct(ImageService $imageService)
    {
        $this->middleware('permission:purchase-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:purchase-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:purchase-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:purchase-delete', ['only' => ['destroy']]);
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


    


    public function index(Request $request)
    {
        $title = "Halaman Pembelian";
        $subtitle = "Menu Pembelian";
        $user = auth()->user(); // Ambil user yang sedang login

        if ($request->ajax()) {
            if ($user->can('user-access')) {
                $query = Purchase::with(['supplier:id,name', 'user:id,name']);
            } else {
                $query = Purchase::where('user_id', $user->id)
                    ->with(['supplier:id,name', 'user:id,name']);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('user_name', function ($purchase) {
                    return $purchase->user->name ?? 'Tidak Diketahui';
                })
                ->addColumn('purchase_date', function ($purchase) {
                    return \Carbon\Carbon::parse($purchase->purchase_date)->locale('id')->isoFormat('dddd, D MMMM YYYY');
                })
                ->addColumn('supplier_name', function ($purchase) {
                    return $purchase->supplier->name ?? 'No Data';
                })
                ->addColumn('total_cost', function ($purchase) {
                    return 'Rp ' . number_format($purchase->total_cost, 0, ',', '.');
                })
                ->addColumn('status', function ($purchase) {
                    $status_badge = [
                        'Lunas' => 'bg-success',
                        'Pending' => 'bg-warning',
                        'Pesanan Pembelian' => 'bg-primary',
                        'Belum Lunas' => 'bg-danger'
                    ];
                    $badge_class = $status_badge[$purchase->status] ?? 'bg-secondary';
                    return '<span class="badge ' . $badge_class . '">' . ucfirst($purchase->status) . '</span>';
                })
                ->addColumn('image', function ($purchase) {
                    if (!empty($purchase->image)) {
                        return '<a href="/upload/purchases/' . $purchase->image . '" target="_blank">
                        <img src="/upload/purchases/' . $purchase->image . '" style="max-width:50px; max-height:50px;">
                    </a>';
                    }
                    return '<span>No Image</span>';
                })
                ->addColumn('actions', function ($purchase) {
                    $btn = '<a class="btn btn-warning btn-sm" href="' . route('purchases.show', $purchase->id) . '">
                            <i class="fa fa-eye"></i> Show
                        </a>';

                    if (auth()->user()->can('purchase-edit') && $purchase->status !== 'Lunas') {
                        $btn .= ' <a class="btn btn-primary btn-sm" href="' . route('purchases.edit', $purchase->id) . '">
                                <i class="fa fa-edit"></i> Edit
                              </a>';
                    }

                    if (auth()->user()->can('purchase-delete')) {
                        $btn .= ' <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(' . $purchase->id . ')">
                                <i class="fa fa-trash"></i> Delete
                              </button>
                              <form id="delete-form-' . $purchase->id . '" method="POST" action="' . route('purchases.destroy', $purchase->id) . '" style="display:none;">
                                  ' . csrf_field() . '
                                  ' . method_field("DELETE") . '
                              </form>';
                    }

                    $btn .= ' <a class="btn btn-info btn-sm" target="_blank" href="' . route('purchases.print_invoice', $purchase->id) . '">
                            <i class="fa fa-print"></i> Print Invoice
                          </a>';

                    return $btn;
                })
                ->rawColumns(['status', 'image', 'actions']) // Render kolom sebagai HTML
                ->make(true);
        }

        return view('purchase.index', compact('title', 'subtitle'));
    }


    public function printInvoice($id)
    {
        // Ambil data pembelian berdasarkan ID
        $purchase = Purchase::with(['supplier', 'user', 'purchaseItems.product'])->findOrFail($id);

        // Kirim data pembelian ke view
        return view('purchase.print', compact('purchase'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Halaman Tambah Pembelian";
        $subtitle = "Menu Tambah Pembelian";

      
        $data_products = Product::all();
        $data_suppliers = Supplier::all();
        $data_purchases = Purchase::all();
         // Ambil data untuk dropdown select
         $user = auth()->user();
         if ($user->can('user-access')) {
             $data_cashes = Cash::all();
         } else {
             $data_cashes = Cash::where('user_id', $user->id)->get();
         }

        // Mendapatkan kode pembelian terbaru dari database
        $latestPurchase = Purchase::latest()->first();
        $no_purchase = '';

        // Mengambil alias dari tabel profil
        $alias = Profil::first()->alias ?? 'LTPOS';  // Default 'LTPOS' jika alias kosong

        // Jika belum ada pembelian sebelumnya
        if (!$latestPurchase) {
            $no_purchase = $alias . '-' . date('Ymd') . '-000001-PCS';
        } else {
            // Memecah kode pembelian untuk mendapatkan nomor urut
            $parts = explode('-', $latestPurchase->no_purchase);
            $nomor_urut = intval($parts[2]) + 1;

            // Format ulang nomor urut agar memiliki panjang 6 digit
            $nomor_urut_format = str_pad($nomor_urut, 6, '0', STR_PAD_LEFT);

            // Menggabungkan kode pembelian baru
            $no_purchase = $alias . '-' . date('Ymd') . '-' . $nomor_urut_format . '-PCS';
        }

        $users = User::all();
        // Menampilkan view dengan data yang diperlukan
        return view('purchase.create', compact('data_cashes', 'data_purchases', 'data_products',  'data_suppliers', 'title', 'subtitle', 'no_purchase', 'users'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data pembelian
        $request->validate([
            'purchase_date' => 'required|date',
            'total_cost' => 'required|numeric',
            'product_id' => 'required|array',
            'quantity' => 'required|array',
            'image' => 'mimes:jpg,jpeg,png,gif|max:4048',
            'cash_id' => 'required|exists:cash,id',
        ], [
            'image.mimes' => 'Bukti yang dimasukkan hanya diperbolehkan berekstensi JPG, JPEG, PNG dan GIF',
            'image.max' => 'Ukuran image tidak boleh lebih dari 4 MB',
            'cash_id.exists' => 'Cash ID tidak valid.',
        ]);
    
        try {
            // Handle image upload
            $imageName = null;
            if ($request->hasFile('image')) {
                $imageName = $this->imageService->handleImageUpload(
                    $request->file('image'),
                    'upload/purchases'
                );
            }
    
            // Ambil user_id berdasarkan kondisi
            $loggedInUserId = Auth::id();
            $userIdToSave = $request->filled('user_id') && Auth::user()->can('user-access')
                ? $request->user_id
                : $loggedInUserId;
    
            // Validasi cash_id hanya boleh sesuai dengan user_id kecuali user-access
            $cash = Cash::find($request->cash_id);
            if (!$cash || ($cash->user_id !== $userIdToSave && !Auth::user()->can('user-access'))) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses ke Cash ID ini.',
                ], 403);
            }
    
            // Simpan data pembelian
            $purchase = new Purchase();
            $purchase->image = $imageName ?? '';
            $purchase->type_payment = $request->type_payment;
            $purchase->purchase_date = $request->purchase_date;
            $purchase->no_purchase = $request->no_purchase;
            $purchase->supplier_id = $request->supplier_id;
            $purchase->user_id = $userIdToSave;
            $purchase->cash_id = $request->cash_id;
            $purchase->total_cost = str_replace(['.', ','], '', $request->total_cost);
            $purchase->status = $request->status;
            $purchase->description = $request->description;
            $purchase->save();
    
            // Simpan detail purchase
            foreach ($request->product_id as $key => $productId) {
                $hargaBeliWithoutSeparator = str_replace(['.', ','], '', $request->purchase_price[$key]);
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $productId,
                    'purchase_price' => $hargaBeliWithoutSeparator,
                    'quantity' => $request->quantity[$key],
                    'total_price' => $request->quantity[$key] * $hargaBeliWithoutSeparator,
                ]);
            }
    
            // Cek saldo cash
            if ($cash->amount < $request->total_cost) {
                return response()->json([
                    'success' => false,
                    'message' => 'Saldo cash tidak mencukupi untuk transaksi ini.',
                ], 400);
            }
    
            // Proses jika status Lunas
            if ($purchase->status === 'Lunas') {
                // Update stock
                foreach ($request->product_id as $key => $productId) {
                    Product::find($productId)?->increment('stock', $request->quantity[$key]);
                }
    
                // Update cash
                $cash->decrement('amount', $purchase->total_cost);
    
                // Simpan profit loss
                Profit::create([
                    'cash_id' => $request->cash_id,
                    'purchase_id' => $purchase->id,
                    'date' => $purchase->purchase_date,
                    'category' => 'kurang',
                    'amount' => $purchase->total_cost,
                ]);
            }
    
            // Simpan log
            $this->simpanLogHistori('Create', 'Purchase', $purchase->id, Auth::id(), null, json_encode($purchase));
    
            return response()->json(['success' => true, 'message' => 'Pembelian berhasil disimpan'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    









    /**
     * Display the specified resource.
     */
    // Controller Method (Show Pembelian)
    public function show($id)
    {
        $title = "Halaman Lihat Pembelian";
        $subtitle = "Menu Lihat Pembelian";
        // Ambil data pembelian berdasarkan ID
        $purchase = Purchase::with(['supplier', 'user', 'purchaseItems.product'])->findOrFail($id);

        // Kirim data ke view
        return view('purchase.show', compact('purchase', 'title', 'subtitle'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = "Halaman Lihat Pembelian";
        $subtitle = "Menu Lihat Pembelian";
        // Ambil data pembelian berdasarkan ID
        $purchase = Purchase::with('purchaseItems.product')->findOrFail($id);


        // Ambil data lainnya yang dibutuhkan untuk dropdown
        $data_suppliers = Supplier::all();
        $data_products = Product::all();
        $user = auth()->user();
        if ($user->can('user-access')) {
            $data_cashes = Cash::all();
        } else {
            $data_cashes = Cash::where('user_id', $user->id)->get();
        }
        $users = User::all();

        // Kirim data ke view
        return view('purchase.edit', compact('purchase', 'title', 'subtitle', 'data_suppliers', 'data_products', 'data_cashes','users'));
    }



    public function update(Request $request, string $id)
    {
        // Validasi data
        $request->validate([
            'purchase_date' => 'required|date',
            'product_id' => 'required|array',
            'quantity' => 'required|array',
            'purchase_price' => 'required|array',
            'total_cost' => 'required|numeric',
            'status' => 'required',
            'description' => 'nullable|string',
            'type_payment' => 'nullable|string',
            'no_purchase' => 'nullable|string',
            'cash_id' => 'nullable|exists:cash,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        $purchase = Purchase::findOrFail($id);
        $oldData = $purchase->toArray();
        $loggedInUserId = Auth::id();
    
        // Validasi apakah cash_id yang dipilih adalah milik user ini (kecuali admin/user-access)
        if ($request->filled('cash_id')) {
            $cash = Cash::where('id', $request->cash_id)
                ->where(function ($query) use ($loggedInUserId) {
                    $query->where('user_id', $loggedInUserId)
                        ->orWhereHas('user', function ($q) {
                            $q->whereHas('roles', function ($roleQuery) {
                                $roleQuery->where('name', 'user-access');
                            });
                        });
                })
                ->first();
    
            if (!$cash) {
                return response()->json(['success' => false, 'message' => 'Anda tidak memiliki akses ke Kas ini.']);
            }
        }
    
        if ($request->hasFile('image')) {
            $purchase->image = $this->imageService->handleImageUpload(
                $request->file('image'),
                'upload/purchases',
                $purchase->image
            );
        }
    
        // Ambil status untuk pengecekan
        $status = $request->status;
    
        if ($status === 'Lunas') {
            $cashId = $request->cash_id;
            $cashAmount = Cash::find($cashId)->amount;
    
            if ($purchase->total_cost > $cashAmount) {
                return response()->json(['success' => false, 'message' => 'Saldo Kas tidak mencukupi.']);
            }
    
            // Update saldo kas
            $newCashAmount = $cashAmount - $purchase->total_cost;
            Cash::find($cashId)->update(['amount' => $newCashAmount]);
    
            // Tambahkan stok produk
            foreach ($request->product_id as $key => $productId) {
                $quantity = $request->quantity[$key];
                $product = Product::find($productId);
    
                if ($product) {
                    $product->increment('stock', $quantity);
                }
            }
        }
    
        // Tentukan user_id yang akan disimpan
        $userIdToSave = $request->filled('user_id') && Auth::user()->can('user-access')
            ? $request->user_id
            : $loggedInUserId;
    
        // Update data pembelian
        $purchase->update([
            'description' => $request->description,
            'type_payment' => $request->type_payment,
            'purchase_date' => $request->purchase_date,
            'status' => $request->status,
            'cash_id' => $request->cash_id,
            'supplier_id' => $request->supplier_id,
            'no_purchase' => $request->no_purchase,
            'user_id' => $userIdToSave,
            'total_cost' => str_replace(['.', ','], '', $request->total_cost),
        ]);
    
        $newProductIds = $request->product_id;
        $existingItems = $purchase->purchaseItems()->get();
        $total_cost = 0;
    
        foreach ($newProductIds as $key => $productId) {
            $quantity = $request->quantity[$key];
            $purchase_price = str_replace(['.', ','], '', $request->purchase_price[$key]);
            $total_price = $quantity * $purchase_price;
    
            $existingItem = $existingItems->firstWhere('product_id', $productId);
    
            if ($existingItem) {
                $existingItem->update([
                    'quantity' => $quantity,
                    'purchase_price' => $purchase_price,
                    'total_price' => $total_price,
                ]);
            } else {
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'purchase_price' => $purchase_price,
                    'total_price' => $total_price,
                ]);
            }
    
            $total_cost += $total_price;
        }
    
        // Hapus item yang tidak ada di request
        $existingItems->whereNotIn('product_id', $newProductIds)->each(function ($item) {
            $item->delete();
        });
    
        // Update total cost pembelian
        $purchase->update(['total_cost' => $total_cost]);
    
        $newData = $purchase->refresh()->toArray();
    
        if ($purchase->status === 'Lunas' && $cash) {
            Profit::updateOrCreate(
                ['purchase_id' => $purchase->id],
                [
                    'cash_id' => $purchase->cash_id,
                    'date' => $purchase->purchase_date,
                    'category' => 'kurang',
                    'amount' => $purchase->total_cost,
                ]
            );
        }
    
        // Simpan log histori
        $this->simpanLogHistori(
            'Update',
            'Purchase',
            $purchase->id,
            $loggedInUserId,
            json_encode($oldData),
            json_encode($newData)
        );
    
        return response()->json(['success' => true, 'message' => 'Pembelian berhasil diperbarui.']);
    }
    






    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Ambil data purchase yang akan dihapus
        $purchase = Purchase::findOrFail($id);

        // Mulai transaksi untuk memastikan semuanya atau tidak sama sekali
        DB::beginTransaction();

        try {
            // Cek status pembelian, hanya jika status "Lunas" yang mempengaruhi stok dan cash
            if ($purchase->status == 'Lunas') {
                // Perbarui stok produk berdasarkan purchase_items yang ada
                foreach ($purchase->purchaseItems as $item) {
                    // Mengurangi stok produk berdasarkan quantity yang dibeli
                    $product = $item->product;
                    $product->stock -= $item->quantity; // Mengurangi stok produk
                    $product->save();
                }

                // Menambah kembali jumlah cash yang digunakan dalam purchase
                $cash = $purchase->cash;
                $cash->amount += $purchase->total_cost; // Menambah cash yang digunakan
                $cash->save();
            }

            // Hapus gambar terkait pembelian jika ada
            if ($purchase->image) {
                $imagePath = public_path('upload/purchases/' . $purchase->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath); // Menghapus file gambar
                }
            }

            // Hapus semua purchase_items terkait
            $purchase->purchaseItems()->delete();

            // Hapus purchase
            $purchase->delete();

            // Commit transaksi
            DB::commit();

            // Mendapatkan ID pengguna yang sedang login
            $loggedInUserId = Auth::id();

            // Simpan log histori untuk operasi Delete
            $this->simpanLogHistori('Delete', 'Purchase', $id, $loggedInUserId, json_encode($purchase), null);

            return redirect()->route('purchases.index')->with('success', 'Pembelian berhasil dihapus dan data terkait telah diperbarui.');
        } catch (\Exception $e) {
            // Rollback transaksi jika ada error
            DB::rollback();

            // Log error jika diperlukan
            Log::error("Error menghapus pembelian: " . $e->getMessage());

            return back()->with('error', 'Terjadi kesalahan saat menghapus pembelian.');
        }
    }
}
