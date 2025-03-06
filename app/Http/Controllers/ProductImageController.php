<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Services\ImageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


class ProductImageController extends Controller
{

    protected $imageService;
    function __construct(ImageService $imageService)
    {
        $this->middleware('permission:productimages-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:productimages-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:productimages-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:productimages-delete', ['only' => ['destroy']]);
        $this->imageService = $imageService;
    }


    public function index(Product $product)
    {
        $title = "Halaman Gambar Produk";
        $subtitle = "Menu Gambar Produk";
        $images = $product->images()->orderBy('sort_order')->get();
        return view('product.images', compact('product', 'images', 'title', 'subtitle'));
    }

    public function store(Request $request, Product $product)
    {
        $messages = [
            'images.required' => 'Mohon pilih gambar yang akan diunggah.',
            'images.*.required' => 'Setiap file gambar harus dipilih.',
            'images.*.image' => 'File yang diunggah harus berupa gambar.',
            'images.*.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'images.*.max' => 'Ukuran gambar maksimal 2MB.'
        ];

        $request->validate([
            'images' => 'required',
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ], $messages);

        try {
            DB::beginTransaction();

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    // Upload dan konversi gambar menggunakan service
                    $filename = $this->imageService->handleImageUpload(
                        $image,
                        'upload/products/details'
                    );

                    if ($filename) {
                        $product->images()->create([
                            'image' => $filename,
                            'sort_order' => $product->images()->count() + 1
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Gambar berhasil diunggah');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Product $product, ProductImage $image)
    {
        if (File::exists(public_path('upload/products/details/' . $image->image))) {
            File::delete(public_path('upload/products/details/' . $image->image));
        }

        $image->delete();
        return redirect()->back()->with('success', 'Gambar Berhasil Dihapus');
    }
}
