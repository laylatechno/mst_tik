<?php

namespace App\Http\Controllers;

use App\Models\Cash;
use App\Models\LogHistori;
use App\Models\Transaction;

use App\Models\Profit;
use App\Models\TransactionCategory;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $imageService;
    function __construct(ImageService $imageService)
    {
        $this->middleware('permission:transaction-list|transaction-create|transaction-edit|transaction-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:transaction-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:transaction-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:transaction-delete', ['only' => ['destroy']]);
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
        $title = "Halaman Transaksi";
        $subtitle = "Menu Transaksi";

        // Ambil data untuk dropdown select
        $data_transaction_categories = TransactionCategory::all(); // Ambil semua stimuli
        $data_cash = Cash::all(); // Ambil semua produk
        $user = auth()->user(); // Ambil user yang sedang login 

        if ($user->can('user-access')) {
            $data_transactions = Transaction::with('user')->get();
        } else {
            // Jika tidak, hanya tampilkan supplier dengan user_id yang sesuai dengan user yang login
            $data_transactions = Transaction::where('user_id', $user->id)->with('user')->get();
        }


        // Kirim semua data ke view
        return view('transaction.index', compact('data_transaction_categories', 'data_cash', 'data_transactions', 'title', 'subtitle'));
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $title = "Halaman Tambah Transaksi";
        $subtitle = "Menu Tambah Transaksi";

        // Ambil data untuk dropdown select
        $user = auth()->user();
        if ($user->can('user-access')) {
            $data_cash = Cash::all();
        } else {
            $data_cash = Cash::where('user_id', $user->id)->get();
        }
        $data_transaction_categories = TransactionCategory::all();
        $users = User::all();

        // Kirim data ke view
        return view('transaction.create', compact('title', 'subtitle', 'data_transaction_categories', 'data_cash', 'users'));
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


     public function store(Request $request): RedirectResponse
     {
         $validator = Validator::make($request->all(), [
             'name' => 'required',
             'transaction_category_id' => 'required',
             'cash_id' => 'required|exists:cash,id',
             'amount' => 'required',
             'image' => 'nullable|image|mimes:jpeg,jpg,png|max:4096',
         ], [
             'name.required' => 'Nama wajib diisi.',
             'transaction_category_id.required' => 'Kategori wajib diisi.',
             'cash_id.required' => 'Kas wajib diisi.',
             'cash_id.exists' => 'Kas tidak valid.',
             'amount.required' => 'Jumlah wajib diisi.',
             'image.image' => 'Gambar harus dalam format jpeg, jpg, atau png',
             'image.mimes' => 'Format gambar harus jpeg, jpg, atau png',
             'image.max' => 'Ukuran gambar tidak boleh lebih dari 4 MB',
         ]);
     
         if ($validator->fails()) {
             return redirect()->back()
                 ->withErrors($validator)
                 ->withInput();
         }
     
         DB::beginTransaction();
     
         try {
             // Hilangkan separator titik dan koma dari amount
             $cleanedAmount = str_replace([',', '.'], '', $request->amount);
             $numericAmount = (float) $cleanedAmount;
     
             // Pastikan amount tetap berupa angka setelah pembersihan
             if (!is_numeric($numericAmount) || $numericAmount <= 0) {
                 return redirect()->back()
                     ->withErrors(['amount' => 'Jumlah tidak valid.'])
                     ->withInput();
             }
     
             // Ambil user yang sedang login
             $loggedInUser = Auth::user();
             $loggedInUserId = $loggedInUser->id;
     
             // Ambil data kas yang dipilih
             $cash = Cash::find($request->cash_id);
     
             // Jika kas tidak ditemukan
             if (!$cash) {
                 return redirect()->back()
                     ->withErrors(['cash_id' => 'Kas tidak ditemukan.'])
                     ->withInput();
             }
     
             // **VALIDASI: Pastikan cash_id sesuai dengan user_id pengguna yang login**
             if (!$loggedInUser->can('user-access') && $cash->user_id !== $loggedInUserId) {
                 return redirect()->back()
                     ->withErrors(['cash_id' => 'Anda tidak memiliki izin untuk menggunakan kas ini.'])
                     ->withInput();
             }
     
             // Ambil data kategori transaksi
             $transactionCategory = TransactionCategory::find($request->transaction_category_id);
     
             if (!$transactionCategory) {
                 return redirect()->back()
                     ->withErrors(['transaction_category_id' => 'Kategori transaksi tidak ditemukan.'])
                     ->withInput();
             }
     
             // Update saldo kas berdasarkan parent_type
             if ($transactionCategory->parent_type === 'kurang') {
                 $cash->amount -= $numericAmount;
             } elseif ($transactionCategory->parent_type === 'tambah') {
                 $cash->amount += $numericAmount;
             }
     
             // Simpan perubahan saldo kas
             $cash->save();
     
             // Ambil user_id berdasarkan kondisi
             $userIdToSave = $request->filled('user_id') && $loggedInUser->can('user-access')
                 ? $request->user_id
                 : $loggedInUserId;
     
             // Proses image jika ada file yang diupload
             $data = $request->except(['image', 'amount']);
             $data['amount'] = $numericAmount; // Gunakan amount yang sudah dibersihkan
             $data['user_id'] = $userIdToSave; // Simpan user_id sesuai kondisi
     
             // Upload dan konversi gambar menggunakan service
             if ($request->hasFile('image')) {
                 $data['image'] = $this->imageService->handleImageUpload(
                     $request->file('image'),
                     'upload/transactions'
                 );
             } else {
                 $data['image'] = '';
             }
     
             // Simpan transaksi ke database
             $transaction = Transaction::create($data);
     
             // Simpan log histori
             $this->simpanLogHistori('Create', 'Transaksi', $transaction->id, $loggedInUserId, null, json_encode($transaction));
     
             // Simpan ke tabel profit_loss
             $profitLoss = new Profit();
             $profitLoss->cash_id = $transaction->cash_id;
             $profitLoss->transaction_id = $transaction->id;
             $profitLoss->date = $transaction->date;
             $profitLoss->amount = $transaction->amount;
             $profitLoss->category = $transactionCategory->parent_type === 'tambah' ? 'tambah' : 'kurang';
             $profitLoss->save();
     
             DB::commit();
     
             return redirect()->route('transactions.index')
                 ->with('success', 'Transaksi berhasil dibuat.');
         } catch (\Exception $e) {
             DB::rollBack();
             return redirect()->back()
                 ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan transaksi: ' . $e->getMessage()])
                 ->withInput();
         }
     }
     










    /**
     * Display the specified resource.
     *
     * @param  \App\Transactions  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        // Judul untuk halaman
        $title = "Halaman Lihat Transaksi";
        $subtitle = "Menu Lihat Transaksi";

        // Ambil data untuk dropdown select
        $data_cash = Cash::all(); // Ambil semua kategori kas
        $data_transaction_categories = TransactionCategory::all();

        // Ambil data transaksi berdasarkan ID
        $data_transactions = Transaction::findOrFail($id);

        // Kembalikan view dengan membawa data produk
        return view('transaction.show', compact(
            'title',
            'subtitle',
            'data_cash',
            'data_transaction_categories',
            'data_transactions',
        ));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transactions  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View {}






    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transactions  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse {}





    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transactions  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Cari transaksi berdasarkan ID
        $transaction = Transaction::findOrFail($id);

        // Mulai transaksi database untuk memastikan konsistensi
        DB::beginTransaction();
        try {
            // Ambil data kategori transaksi
            $transactionCategory = TransactionCategory::find($transaction->transaction_category_id);

            // Cek apakah kategori transaksi ada
            if (!$transactionCategory) {
                throw new \Exception('Kategori transaksi tidak ditemukan.');
            }

            // Ambil data kas yang terkait dengan transaksi
            $cash = Cash::find($transaction->cash_id);

            if (!$cash) {
                throw new \Exception('Kas tidak ditemukan.');
            }

            // Update saldo kas berdasarkan parent_type
            if ($transactionCategory->parent_type === 'kurang') {
                // Jika parent_type = kurang, tambahkan jumlah transaksi ke saldo kas
                $cash->amount += $transaction->amount;
            } elseif ($transactionCategory->parent_type === 'tambah') {
                // Jika parent_type = tambah, kurangi saldo kas sesuai dengan jumlah transaksi
                $cash->amount -= $transaction->amount;
            }

            // Simpan perubahan saldo kas
            $cash->save();

            // Hapus file gambar jika ada
            if (!empty($transaction->image)) {
                $imagePath = public_path('upload/transactions/' . $transaction->image);
                if (file_exists($imagePath)) {
                    @unlink($imagePath); // Menghapus file gambar
                }
            }

            // Hapus data terkait di tabel profit_loss
            $transaction->profitLoss()->delete();

            // Hapus transaksi dari tabel transactions
            $transaction->delete();

            // Mendapatkan ID pengguna yang sedang login
            $loggedInUserId = Auth::id();

            // Simpan log histori untuk operasi Delete
            $this->simpanLogHistori('Delete', 'Transaksi', $id, $loggedInUserId, json_encode($transaction), null);

            // Commit transaksi
            DB::commit();

            // Redirect kembali dengan pesan sukses
            return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();

            // Kembalikan pesan error
            return redirect()->route('transactions.index')->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }
}
