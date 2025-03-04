<?php

namespace App\Http\Controllers;

use App\Models\LogHistori;
use App\Models\Product;
use App\Models\Category;
use App\Models\CustomerCategory;
use App\Models\ProductPrice;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Services\ImageService;
use Illuminate\Support\Facades\Gate;

use Picqer\Barcode\BarcodeGeneratorHTML;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $imageService;
    function __construct(ImageService $imageService)
    {
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:product-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
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
        $title = "Halaman Produk";
        $subtitle = "Menu Produk";
        $user = auth()->user(); // Ambil data user yang sedang login
    
        // Ambil data hanya yang diperlukan untuk dropdown dan tabel
        $data_units = Unit::select('id', 'name')->get();
        $data_categories = Category::select('id', 'name')->get();
        $data_customer_categories = CustomerCategory::select('id', 'name')->get();
    
        // Optimasi query produk dengan eager loading
        $query = Product::with(['category:id,name', 'unit:id,name', 'user:id,name']) // Tambahkan relasi user
            ->select('id', 'name', 'code_product', 'barcode', 'description', 'purchase_price', 'cost_price', 'stock', 'image', 'category_id', 'unit_id', 'status_active', 'status_display', 'user_id');
    
        // Jika user tidak memiliki permission 'data-users-select2', hanya tampilkan produknya sendiri
        if (!$user->can('data-users-select2')) {
            $query->where('user_id', $user->id);
        }
    
        $data_products = $query->get();
    
        // Kirim data ke view
        return view('product.index', compact('data_products', 'data_units', 'data_categories', 'data_customer_categories', 'title', 'subtitle'));
    }
    




    public function getProductPrice(Request $request)
    {
        $productId = $request->product_id;
        $customerCategoryId = $request->customer_category_id;

        // Ambil harga berdasarkan kategori pelanggan
        $productPrice = ProductPrice::where('product_id', $productId)
            ->where('customer_category_id', $customerCategoryId)
            ->first();

        if ($productPrice) {
            return response()->json([
                'price' => $productPrice->price
            ]);
        } else {
            // Jika tidak ada harga khusus, kembalikan harga default dari produk
            $product = Product::find($productId);
            return response()->json([
                'price' => $product->cost_price
            ]);
        }
    }



    public function generateBarcode(Request $request)
    {
        $title = "Halaman Barcode Produk";
        $subtitle = "Menu Barcode Produk";
        $ids = explode(',', $request->input('selected_ids'));
        $products = Product::whereIn('id', $ids)->get();

        $barcodeGenerator = new BarcodeGeneratorHTML();


        // Menyimpan barcode ke field 'barcode' di tabel produk
        foreach ($products as $product) {
            // Misalnya Anda ingin menggunakan 'code_product' sebagai barcode
            $barcode = $product->code_product;

            // Simpan barcode ke field di database
            $product->barcode = $barcode;
            $product->save();
        }

        return view('product.barcodes', compact('products', 'barcodeGenerator', 'title', 'subtitle'));
    }

    public function getProductByBarcode(Request $request)
    {
        $barcode = $request->input('barcode');

        // Cari produk berdasarkan barcode
        $product = Product::where('barcode', $barcode)->first();

        if ($product) {
            return response()->json(['product' => $product]);
        }

        return response()->json(['message' => 'Produk tidak ditemukan'], 404);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $title = "Halaman Tambah Produk";
        $subtitle = "Menu Tambah Produk";

        // Ambil data untuk dropdown select
        $data_units = Unit::all();
        $data_categories = Category::all();
        $data_customer_categories = CustomerCategory::all();
        $users = User::all(); // Ambil semua pengguna

        // Kirim data ke view
        return view('product.create', compact('title', 'subtitle', 'data_customer_categories', 'data_units', 'data_categories', 'users'));
    }





    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */






   

    public function store(Request $request): RedirectResponse
    {
        // Validasi data produk utama
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products,name',
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
            'purchase_price' => 'required',
            'cost_price' => 'required',
            'stock' => 'nullable|integer',
            'reminder' => 'nullable|integer',
            'description' => 'nullable|string',
            'customer_category_id.*' => 'nullable|exists:customer_categories,id',
            'customer_price.*' => 'nullable',
            'image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:4048',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.unique' => 'Nama sudah terdaftar.',
            'category_id.required' => 'Kategori produk wajib dipilih.',
            'category_id.exists' => 'Kategori tidak valid.',
            'unit_id.required' => 'Satuan produk wajib dipilih.',
            'unit_id.exists' => 'Satuan tidak valid.',
            'purchase_price.required' => 'Harga beli produk wajib diisi.',
            'cost_price.required' => 'Harga jual produk wajib diisi.',
            'customer_category_id.*.exists' => 'Kategori konsumen tidak valid.',
            'image.image' => 'Gambar harus dalam format jpeg, jpg, atau png',
            'image.mimes' => 'Format gambar harus jpeg, jpg, atau png',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 4 MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Membersihkan data harga dari karakter koma
        $data = $request->all();
        $data['purchase_price'] = str_replace(',', '', $data['purchase_price']);
        if (!empty($data['cost_price'])) {
            $data['cost_price'] = str_replace(',', '', $data['cost_price']);
        }

        // Pengkondisian untuk user_id
        if (Gate::allows('user-access')) {
            // Jika memiliki akses user-access, gunakan inputan dari form
            $data['user_id'] = $request->input('user_id');
        } else {
            // Jika tidak memiliki akses, gunakan ID user yang sedang login
            $data['user_id'] = Auth::id();
        }

        // Hilangkan data yang tidak perlu sebelum menyimpan
        unset($data['customer_category_id'], $data['customer_price']);

        // Upload gambar jika ada
        if ($request->hasFile('image')) {
            $data['image'] = $this->imageService->handleImageUpload(
                $request->file('image'),
                'upload/products'
            );
        } else {
            $data['image'] = '';
        }

        // Simpan produk ke database
        $product = Product::create($data);

        // Simpan harga konsumen jika ada
        if ($request->has('customer_category_id')) {
            foreach ($request->customer_category_id as $index => $categoryId) {
                $customerPrice = str_replace(',', '', $request->customer_price[$index] ?? null);
                if ($categoryId && $customerPrice) {
                    $product->productPrices()->create([
                        'customer_category_id' => $categoryId,
                        'price' => $customerPrice,
                    ]);
                }
            }
        }

        // Simpan log histori
        $loggedInUserId = Auth::id();
        $this->simpanLogHistori('Create', 'Produk', $product->id, $loggedInUserId, null, json_encode($product));

        return redirect()->route('products.index')->with('success', 'Produk berhasil dibuat.');
    }








    /**
     * Display the specified resource.
     *
     * @param  \App\Products  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Ambil data produk dengan relasi 'category', 'unit', dan 'productPrices.customerCategory'
        $data_product = Product::with(['category', 'unit', 'productPrices.customerCategory'])
            ->findOrFail($id);

        // Judul untuk halaman
        $title = "Halaman Lihat Produk";
        $subtitle = "Menu Lihat Produk";

        // Kembalikan view dengan membawa data produk
        return view('product.show', compact('data_product', 'title', 'subtitle'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Products  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $title = "Halaman Edit Produk";
        $subtitle = "Menu Edit Produk";

        // Ambil data produk yang sedang diedit
        $data_product = Product::findOrFail($id);

        // Ambil data terkait lainnya
        $data_units = Unit::all(); // Ambil semua unit
        $data_categories = Category::all(); // Ambil semua kategori
        $data_customer_categories = CustomerCategory::all(); // Ambil semua kategori konsumen
        $data_prices = ProductPrice::where('product_id', $data_product->id)->get(); // Ambil harga berdasarkan ID produk yang sedang diedit
        $users = User::all(); // Ambil semua pengguna

        // Kirim data ke view
        return view('product.edit', compact(
            'data_product',
            'title',
            'subtitle',
            'data_customer_categories',
            'data_units',
            'data_categories',
            'data_prices',
            'users'
        ));
    }






    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        // Validasi data produk utama
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
            'purchase_price' => 'required',
            'cost_price' => 'required',
            'stock' => 'nullable|integer',
            'reminder' => 'nullable|integer',
            'description' => 'nullable|string',
            // Validasi untuk kategori dan harga konsumen
            'customer_category_id.*' => 'nullable|exists:customer_categories,id',
            'customer_price.*' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4048',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'category_id.required' => 'Kategori produk wajib dipilih.',
            'category_id.exists' => 'Kategori tidak valid.',
            'unit_id.required' => 'Satuan produk wajib dipilih.',
            'unit_id.exists' => 'Satuan tidak valid.',
            'purchase_price.required' => 'Harga beli produk wajib diisi.',
            'purchase_price.required' => 'Harga jual produk wajib diisi.',
            'customer_category_id.*.exists' => 'Kategori konsumen tidak valid.',
            'image.image' => 'Gambar harus dalam format jpeg, jpg, atau png',
            'image.mimes' => 'Format gambar harus jpeg, jpg, atau png',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 4 MB',
        ]);

        // Validasi khusus untuk duplikasi kategori konsumen
        $customerCategoryIds = $request->input('customer_category_id', []);
        if (count($customerCategoryIds) !== count(array_unique($customerCategoryIds))) {
            $validator->errors()->add('customer_category_id', 'Terdapat duplikasi kategori konsumen.');
        }

        // Jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Membersihkan data harga dari karakter koma
        $data = $request->all();
        $data['purchase_price'] = str_replace(',', '', $data['purchase_price']);
        if (!empty($data['cost_price'])) {
            $data['cost_price'] = str_replace(',', '', $data['cost_price']);
        }

        // Hilangkan data 'customer_category_id' dan 'customer_price' dari array sebelum menyimpan produk
        unset($data['customer_category_id']);
        unset($data['customer_price']);


        if (Gate::allows('user-access')) {
            // Jika memiliki akses, gunakan user_id dari input form
            $data['user_id'] = $request->input('user_id');
        } else {
            // Jika tidak memiliki akses, gunakan ID user yang sedang login
            $data['user_id'] = Auth::id();
        }

        // Ambil produk yang akan diupdate
        $product = Product::find($id);

        // Pastikan produk ditemukan
        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Produk tidak ditemukan.');
        }

        if ($request->hasFile('image')) {
            $data['image'] = $this->imageService->handleImageUpload(
                $request->file('image'),
                'upload/products',
                $product->image // Pass old image for deletion
            );
        } else {
            $data['image'] = $product->image; // Gunakan gambar yang sudah ada
        }

        // Proses image jika ada file yang diupload
        // if ($image = $request->file('image')) {
        //     $destinationPath = 'upload/products/';
        //     $originalFileName = $image->getClientOriginalName();
        //     $imageMimeType = $image->getMimeType();

        //     // Memastikan file adalah gambar
        //     if (strpos($imageMimeType, 'image/') === 0) {
        //         $imageName = date('YmdHis') . '_' . str_replace(' ', '_', $originalFileName);
        //         $image->move($destinationPath, $imageName);

        //         $sourceImagePath = public_path($destinationPath . $imageName);
        //         $webpImagePath = $destinationPath . pathinfo($imageName, PATHINFO_FILENAME) . '.webp';

        //         // Mengubah gambar ke format webp
        //         switch ($imageMimeType) {
        //             case 'image/jpeg':
        //                 $sourceImage = @imagecreatefromjpeg($sourceImagePath);
        //                 break;
        //             case 'image/png':
        //                 $sourceImage = @imagecreatefrompng($sourceImagePath);
        //                 break;
        //             default:
        //                 throw new \Exception('Tipe MIME tidak didukung.');
        //         }

        //         // Jika gambar berhasil dibaca, konversi ke WebP dan hapus gambar asli
        //         if ($sourceImage !== false) {
        //             imagewebp($sourceImage, $webpImagePath);
        //             imagedestroy($sourceImage);
        //             @unlink($sourceImagePath); // Menghapus file gambar asli
        //             $data['image'] = pathinfo($imageName, PATHINFO_FILENAME) . '.webp';  // Menggunakan $data, bukan $input
        //         } else {
        //             throw new \Exception('Gagal membaca gambar asli.');
        //         }

        //         // Hapus gambar lama jika ada
        //         if ($product->image) {
        //             $oldImagePath = public_path('upload/products/' . $product->image);
        //             if (file_exists($oldImagePath)) {
        //                 @unlink($oldImagePath);  // Menghapus gambar lama
        //             }
        //         }
        //     } else {
        //         throw new \Exception('Tipe MIME gambar tidak didukung.');
        //     }
        // } else {
        //     $data['image'] = $product->image;  // Jika tidak ada gambar baru, gunakan gambar lama
        // }

        // Menyimpan data produk yang diperbarui
        $product->update($data);

        // Menyimpan harga konsumen tambahan jika ada
        if ($request->has('customer_category_id') && !empty($request->customer_category_id)) {
            // Ambil semua kategori yang ada saat ini untuk produk ini
            $existingPrices = $product->productPrices()->pluck('customer_category_id')->toArray();

            // Loop untuk menyimpan atau memperbarui harga konsumen
            foreach ($request->customer_category_id as $index => $categoryId) {
                $customerPrice = str_replace(',', '', $request->customer_price[$index] ?? null);
                if ($categoryId && $customerPrice) {
                    // Simpan atau perbarui harga untuk kategori pelanggan di tabel product_prices
                    $product->productPrices()->updateOrCreate(
                        ['customer_category_id' => $categoryId], // Kondisi pencarian
                        ['price' => $customerPrice]               // Data yang akan diperbarui
                    );
                }
            }

            // Hapus harga konsumen yang tidak ada lagi di request
            $categoryIdsFromRequest = $request->input('customer_category_id', []);
            $product->productPrices()
                ->whereNotIn('customer_category_id', $categoryIdsFromRequest)
                ->delete();  // Menghapus harga konsumen yang sudah tidak ada dalam request
        } else {
            // Jika tidak ada kategori yang dipilih, hapus semua harga konsumen yang ada
            $product->productPrices()->delete();
        }

        $loggedInUserId = Auth::id();

        // Simpan log histori untuk operasi Update dengan user_id yang sedang login
        $this->simpanLogHistori('Update', 'Produk', $product->id, $loggedInUserId, json_encode($product), json_encode($data));

        // Redirect ke halaman produk dengan pesan sukses
        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }






    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Products  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        DB::beginTransaction();
        try {
            // Hapus file gambar utama produk
            if (!empty($product->image)) {
                $imagePath = public_path('upload/products/' . $product->image);
                if (file_exists($imagePath)) {
                    @unlink($imagePath);
                }
            }

            // Hapus file gambar dari product_images
            foreach ($product->images as $image) {
                $imagePath = public_path('upload/products/details/' . $image->image);
                if (file_exists($imagePath)) {
                    @unlink($imagePath);
                }
            }

            // Hapus data terkait
            $product->productPrices()->delete();
            $product->images()->delete();
            $product->delete();

            $loggedInUserId = Auth::id();
            $this->simpanLogHistori('Delete', 'Produk', $id, $loggedInUserId, json_encode($product), null);

            DB::commit();
            return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('products.index')->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }


    public function destroyMultiple(Request $request)
    {
        $ids = explode(',', $request->input('selected_ids'));

        DB::beginTransaction();
        try {
            foreach ($ids as $id) {
                $product = Product::find($id);
                if ($product) {
                    // Hapus file gambar utama
                    if (!empty($product->image)) {
                        $imagePath = public_path('upload/products/' . $product->image);
                        if (file_exists($imagePath)) {
                            @unlink($imagePath);
                        }
                    }

                    // Hapus file gambar terkait
                    foreach ($product->images as $image) {
                        $imagePath = public_path('upload/products/details/' . $image->image);
                        if (file_exists($imagePath)) {
                            @unlink($imagePath);
                        }
                    }

                    $product->productPrices()->delete();
                    $product->images()->delete();
                    $product->delete();

                    $loggedInUserId = Auth::id();
                    $this->simpanLogHistori('Delete', 'Produk', $id, $loggedInUserId, json_encode($product), null);
                }
            }

            DB::commit();
            return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('products.index')->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }
}
