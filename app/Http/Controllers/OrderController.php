<?php

namespace App\Http\Controllers;

use App\Models\Cash;
use App\Models\LogHistori;
use App\Models\Product;
use App\Models\Profil;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\Profit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\ImageService;


class OrderController extends Controller
{
    protected $imageService;
    function __construct(ImageService $imageService)
    {
        $this->middleware('permission:order-list|order-create|order-edit|order-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:order-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:order-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:order-delete', ['only' => ['destroy']]);
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


    public function index()
    {
        $title = "Halaman Penjualan";
        $subtitle = "Menu Penjualan";

        // Eager loading customer dan user
        $user = auth()->user(); // Ambil user yang sedang login

        if ($user->can('user-access')) {
            // Jika user memiliki izin, tampilkan semua data order
            $data_orders = Order::with(['customer', 'user'])->orderBy('id', 'desc')->get();
        } else {
            // Jika tidak, hanya tampilkan data order yang dibuat oleh user tersebut
            $data_orders = Order::where('user_id', $user->id)
                ->with(['customer', 'user'])
                ->orderBy('id', 'desc')
                ->get();
        }


        $data_products = Product::all();

        // Kirim semua data ke view
        return view('order.index', compact('data_orders', 'data_products', 'title', 'subtitle'));
    }

    public function printInvoice($id)
    {
        $title = "Halaman Invoice Penjualan";
        $subtitle = "Menu Invoice Penjualan";
        // Ambil data pembelian berdasarkan ID
        $order = Order::with(['customer', 'user', 'orderItems.product'])->findOrFail($id);

        // Kirim data pembelian ke view
        return view('order.print_invoice', compact('order', 'title', 'subtitle'));
    }


    public function printStruk($id)
    {
        $title = "Halaman Struk Penjualan";
        $subtitle = "Menu Struk Penjualan";
        // Ambil data pembelian berdasarkan ID
        $order = Order::with(['customer', 'user', 'orderItems.product'])->findOrFail($id);

        // Kirim data pembelian ke view
        return view('order.print_struk', compact('order', 'title', 'subtitle'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Halaman Tambah Penjualan";
        $subtitle = "Menu Tambah Penjualan";


        $data_products = Product::where('stock', '>', 0)
            ->where('status_active', 'active')
            ->get();

        $data_customers = Customer::all();
        $data_orders = Order::all();
        $user = auth()->user();
        if ($user->can('user-access')) {
            $data_cashes = Cash::all();
        } else {
            $data_cashes = Cash::where('user_id', $user->id)->get();
        }

        // Mendapatkan kode pembelian terbaru dari database
        $latestOrder = Order::latest()->first();
        $no_order = '';

        // Mengambil alias dari tabel profil
        $alias = Profil::first()->alias ?? 'LTPOS'; // Default 'LTPOS' jika alias kosong

        // Jika belum ada pembelian sebelumnya
        if (!$latestOrder) {
            $no_order = $alias . '-' . date('Ymd') . '-000001-ORD';
        } else {
            // Memecah kode pembelian untuk mendapatkan nomor urut
            $parts = explode('-', $latestOrder->no_order);
            $nomor_urut = intval($parts[2]) + 1;

            // Format ulang nomor urut agar memiliki panjang 6 digit
            $nomor_urut_format = str_pad($nomor_urut, 6, '0', STR_PAD_LEFT);

            // Menggabungkan kode pembelian baru
            $no_order = $alias . '-' . date('Ymd') . '-' . $nomor_urut_format . '-ORD';
        }
        $users = User::all();

        // Menampilkan view dengan data yang diperlukan
        return view('order.create', compact('data_cashes', 'data_orders', 'data_products', 'data_customers', 'title', 'subtitle', 'no_order', 'users'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data pembelian
        $request->validate([
            'order_date' => 'required|date',
            'total_cost' => 'required|numeric',
            'product_id' => 'required|array',
            'quantity' => 'required|array',
            'cash_id' => 'required|exists:cash,id', // Pastikan cash_id valid
            'image' => 'mimes:jpg,jpeg,png,gif|max:4048',
        ], [
            'cash_id.required' => 'Cash ID harus diisi.',
            'cash_id.exists' => 'Cash ID tidak valid.',
            'image.mimes' => 'Bukti yang dimasukkan hanya diperbolehkan berekstensi JPG, JPEG, PNG dan GIF',
            'image.max' => 'Ukuran image tidak boleh lebih dari 4 MB',
        ]);
    
        // Menangani gambar (jika ada)
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = $this->imageService->handleImageUpload(
                $request->file('image'),
                'upload/orders'
            );
        }
    
        // Ambil user yang sedang login
        $loggedInUser = Auth::user();
    
        // Ambil data cash berdasarkan cash_id
        $cash = Cash::find($request->cash_id);
    
        // Jika cash tidak ditemukan, kembalikan error
        if (!$cash) {
            return response()->json([
                'success' => false,
                'message' => 'Cash ID tidak ditemukan.'
            ], 400);
        }
    
        // Cek apakah user memiliki akses ke cash_id yang dipilih
        if (!$loggedInUser->can('user-access') && $cash->user_id !== $loggedInUser->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses ke kas ini.'
            ], 403);
        }
    
        // Ambil user_id berdasarkan kondisi
        $loggedInUserId = Auth::id();
        $userIdToSave = $request->filled('user_id') && Auth::user()->can('user-access')
            ? $request->user_id
            : $loggedInUserId;
    
        // Simpan data pembelian ke dalam database
        $order = new Order();
        $order->image = $imageName ?? '';
        $order->type_payment = $request->type_payment;
        $order->order_date = $request->order_date;
        $order->no_order = $request->no_order;
        $order->customer_id = $request->customer_id;
        $order->user_id = $userIdToSave;
        $order->cash_id = $request->cash_id;
        $order->total_cost = str_replace(['.', ','], '', $request->total_cost);
        $order->status = $request->status;
        $order->total_cost_before = $request->total_cost_before;
        $order->percent_discount = $request->percent_discount;
        $order->amount_discount = $request->amount_discount;
        $order->input_payment = $request->input_payment;
        $order->return_payment = $request->return_payment;
        $order->description = $request->description;
        $order->save();
    
        // Mendapatkan ID dari order yang baru saja disimpan
        $orderId = $order->id;
    
        // Simpan detail order ke dalam database
        $productIds = $request->product_id;
        $quantitys = $request->quantity;
        $orderprice = $request->cost_price;
    
        foreach ($productIds as $key => $productId) {
            $hargaBeliWithoutSeparator = str_replace(['.', ','], '', $orderprice[$key]);
            $detail = new OrderItem();
            $detail->order_id = $orderId;
            $detail->product_id = $productId;
            $detail->order_price = $hargaBeliWithoutSeparator;
            $detail->quantity = $quantitys[$key];
            $detail->total_price = $quantitys[$key] * $hargaBeliWithoutSeparator;
            $detail->save();
        }
    
        // Proses pembayaran dan pembaruan stok hanya jika status pembelian 'Lunas'
        if ($order->status === 'Lunas') {
            // Update stock produk: kurangi stok produk berdasarkan quantity yang dipesan
            foreach ($request->product_id as $key => $productId) {
                $product = Product::find($productId);
                if ($product) {
                    // Kurangi stok produk sesuai dengan quantity yang dipesan
                    $product->stock -= $request->quantity[$key];
                    $product->save();
                }
            }
    
            // Tambahkan saldo cash berdasarkan cash_id (hanya update saldo, tanpa pengecekan saldo)
            if ($cash) {
                $cash->amount += $order->total_cost;
                $cash->save();
            } else {
                // Jika cash_id tidak ditemukan, batalkan transaksi dan kirimkan error
                $order->delete();
                return response()->json([
                    'success' => false,
                    'message' => 'Cash ID tidak ditemukan. Silakan periksa input data Anda.'
                ], 400);
            }
    
            // Simpan data ke tabel profit_loss
            $profitLoss = new Profit();
            $profitLoss->cash_id = $order->cash_id;
            $profitLoss->order_id = $order->id;
            $profitLoss->date = $order->order_date;
            $profitLoss->category = 'tambah';
            $profitLoss->amount = $order->total_cost;
            $profitLoss->save();
        }
    
        // Simpan log histori untuk operasi Create dengan user_id yang sedang login
        $this->simpanLogHistori('Create', 'Order', $order->id, $loggedInUserId, null, json_encode($order));
    
        // Kembalikan respons sukses
        return response()->json([
            'success' => true,
            'message' => 'Penjualan berhasil disimpan',
            'order_id' => $orderId, // Kirim ID order untuk digunakan di frontend
            'print_option' => true, // Memberikan informasi bahwa pencetakan struk tersedia
        ], 200);
    }
    

    /**
     * Display the specified resource.
     */
    // Controller Method (Show Penjualan)
    public function show($id)
    {
        $title = "Halaman Lihat Penjualan";
        $subtitle = "Menu Lihat Penjualan";
        // Ambil data pembelian berdasarkan ID
        $order = Order::with(['customer', 'user', 'orderItems.product'])->findOrFail($id);

        // Kirim data ke view
        return view('order.show', compact('order', 'title', 'subtitle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = "Halaman Lihat Penjualan";
        $subtitle = "Menu Lihat Penjualan";
        // Ambil data pembelian berdasarkan ID
        $order = Order::with(['customer', 'user', 'orderItems.product'])->findOrFail($id);


        // Ambil data lainnya yang dibutuhkan untuk dropdown
        $data_customers = Customer::all();
        $data_products = Product::where('stock', '>', 0)
            ->where('status_active', 'active')
            ->get();
        $user = auth()->user();
        if ($user->can('user-access')) {
            $data_cashes = Cash::all();
        } else {
            $data_cashes = Cash::where('user_id', $user->id)->get();
        }
        $users = User::all();
        // Kirim data ke view
        return view('order.edit', compact('order', 'title', 'subtitle', 'data_customers', 'data_products', 'data_cashes', 'users'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi data
        $request->validate([
            'order_date' => 'required|date',
            'product_id' => 'required|array',
            'quantity' => 'required|array',
            'order_price' => 'required|array',
            'total_cost' => 'required|numeric',
            'status' => 'required',
            'description' => 'nullable|string',
            'type_payment' => 'nullable|string',
            'no_order' => 'nullable|string',
            'cash_id' => 'nullable|exists:cash,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        $order = Order::findOrFail($id);
        $oldData = $order->toArray();
    
        // Validasi cash_id berdasarkan hak akses user
        if (!Auth::user()->can('user-access')) {
            // Jika bukan user-access, pastikan cash_id yang dipilih adalah miliknya
            $allowedCashIds = Cash::where('user_id', Auth::id())->pluck('id')->toArray();
            
            if (!in_array($request->cash_id, $allowedCashIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses ke kas yang dipilih.'
                ], 403);
            }
        }
    
        // Proses upload gambar
        if ($request->hasFile('image')) {
            $order->image = $this->imageService->handleImageUpload(
                $request->file('image'),
                'upload/orders',
                $order->image // Pass old image for deletion
            );
        }
    
        // Ambil user_id berdasarkan kondisi
        $loggedInUserId = Auth::id();
        $userIdToSave = $request->filled('user_id') && Auth::user()->can('user-access')
            ? $request->user_id
            : $loggedInUserId;
    
        $order->update([
            'description' => $request->description,
            'type_payment' => $request->type_payment,
            'order_date' => $request->order_date,
            'status' => $request->status,
            'cash_id' => $request->cash_id,
            'customer_id' => $request->customer_id,
            'total_cost_before' => $order->total_cost, // Simpan nilai lama
            'total_cost' => str_replace(['.', ','], '', $request->total_cost), // Gunakan input form
            'percent_discount' => $request->percent_discount,
            'amount_discount' => $request->amount_discount,
            'input_payment' => $request->input_payment,
            'return_payment' => $request->return_payment,
            'user_id' => $userIdToSave,
        ]);
    
        // Update atau tambahkan order item
        $newProductIds = $request->product_id;
        $existingItems = $order->orderItems()->get();
    
        foreach ($newProductIds as $key => $productId) {
            $quantity = $request->quantity[$key];
            $order_price = str_replace(['.', ','], '', $request->order_price[$key]);
            $total_price = $quantity * $order_price;
    
            $existingItem = $existingItems->firstWhere('product_id', $productId);
    
            if ($existingItem) {
                $existingItem->update([
                    'quantity' => $quantity,
                    'order_price' => $order_price,
                    'total_price' => $total_price,
                ]);
            } else {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'order_price' => $order_price,
                    'total_price' => $total_price,
                ]);
            }
        }
    
        $existingItems->whereNotIn('product_id', $newProductIds)->each(function ($item) {
            $item->delete();
        });
    
        // Simpan ke tabel profit_loss jika status adalah "Lunas"
        if ($order->status === 'Lunas') {
            Profit::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'cash_id' => $order->cash_id,
                    'date' => $order->order_date,
                    'category' => 'tambah',
                    'amount' => $order->total_cost,
                ]
            );
        }
    
        // Simpan log histori
        $newData = $order->refresh()->toArray();
        $loggedInUserId = Auth::id();
        $this->simpanLogHistori(
            'Update',
            'Order',
            $order->id,
            $loggedInUserId,
            json_encode($oldData),
            json_encode($newData)
        );
    
        return response()->json(['success' => true, 'message' => 'Penjualan berhasil diperbarui.']);
    }
    








    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Ambil data order yang akan dihapus
        $order = Order::findOrFail($id);

        // Mulai transaksi untuk memastikan semuanya atau tidak sama sekali
        DB::beginTransaction();

        try {
            // Cek status pembelian, hanya jika status "Lunas" yang mempengaruhi stok dan cash
            if ($order->status == 'Lunas') {
                // Kembalikan stok produk berdasarkan order_items yang ada
                foreach ($order->orderItems as $item) {
                    // Mengembalikan stok produk berdasarkan quantity yang dibeli
                    $product = $item->product;
                    $product->stock += $item->quantity; // Menambah stok produk
                    $product->save();
                }

                // Mengurangi kembali jumlah cash yang digunakan dalam order
                $cash = $order->cash;
                $cash->amount -= $order->total_cost; // Mengurangi cash yang digunakan
                $cash->save();
            }

            // Hapus gambar terkait pembelian jika ada
            if ($order->image) {
                $imagePath = public_path('upload/orders/' . $order->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath); // Menghapus file gambar
                }
            }

            // Hapus semua order_items terkait
            $order->orderItems()->delete();

            // Hapus order
            $order->delete();

            // Commit transaksi
            DB::commit();

            // Mendapatkan ID pengguna yang sedang login
            $loggedInUserId = Auth::id();

            // Simpan log histori untuk operasi Delete
            $this->simpanLogHistori('Delete', 'Order', $id, $loggedInUserId, json_encode($order), null);

            return redirect()->route('orders.index')->with('success', 'Penjualan berhasil dihapus dan data terkait telah diperbarui.');
        } catch (\Exception $e) {
            // Rollback transaksi jika ada error
            DB::rollback();

            // Log error jika diperlukan
            Log::error("Error menghapus pembelian: " . $e->getMessage());

            return back()->with('error', 'Terjadi kesalahan saat menghapus pembelian.');
        }
    }
}
