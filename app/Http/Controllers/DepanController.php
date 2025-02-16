<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Profil;
use App\Models\Service;
use App\Models\Testimony;
use App\Models\User;
use App\Models\Visitor;
use Jenssegers\Agent\Agent;

class DepanController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $profil = Profil::first();
        $title = "Halaman " . ($profil ? $profil->nama_profil : 'Nama Profil');
        $subtitle = "Menu Beranda";

        // Eager loading
        $data_sliders = Slider::select('id', 'name', 'image', 'description')->get();
        $data_services = Service::select('id', 'name', 'image', 'description')->get();
        $data_galleries = Gallery::select('id', 'name', 'image')->get();
        $data_stores = User::select('id', 'name', 'image', 'user', 'about', 'address', 'wa_number', 'phone_number', 'banner')
            ->where('status', 'active')
            ->whereNotNull('position')
            ->orderBy('position', 'asc')
            ->first();

        // Periksa apakah data ada sebelum mengakses propertinya
  

        $data_product_categories = Category::select('id', 'name', 'image', 'slug')
            ->orderBy('position', 'asc')
            ->get();

        $data_products = Product::with('category:id,name,slug')
            ->select('id', 'name', 'image', 'cost_price', 'price_before_discount', 'description', 'category_id', 'note', 'user_id', 'slug')
            ->take(12) // Batasi hanya 12 produk
            ->get();



        $product_categories = Category::all();
        // Ambil kategori dengan position pertama yang tersedia
        $first_category = Category::orderBy('position', 'asc')
            ->whereNotNull('position')
            ->first();

        $product_first_category = Product::where('status_active', 'active')
            ->where('category_id', $first_category->id)
            ->where(function ($query) {
                $query->where('status_discount', 'nonactive')
                    ->orWhereNull('status_discount');
            })
            ->take(12)
            ->get();

        $second_category = Category::orderBy('position', 'asc')
            ->whereNotNull('position')
            ->skip(1) // Melewati position pertama
            ->first();


        $product_second_category = Product::where('status_active', 'active')
            ->where('category_id', $second_category->id)
            ->where(function ($query) {
                $query->where('status_discount', 'nonactive')
                    ->orWhereNull('status_discount');
            })
            ->take(12)
            ->get();


        // Mengambil kategori dengan position terbesar ketiga
        $third_category = Category::orderBy('position', 'asc')
            ->whereNotNull('position')
            ->skip(2) // Lewati dua kategori pertama
            ->first();

        // Mengambil product berdasarkan kategori terbesar ketiga
        $product_third_category = Product::where('status_active', 'active')
            ->where('category_id', $third_category->id)
            ->where(function ($query) {
                $query->where('status_discount', 'nonactive')
                    ->orWhereNull('status_discount');
            })
            ->take(12)
            ->get();


        $product_discount = Product::where('status_discount', 'active') // Filter produk dengan diskon aktif
            ->orderBy('position', 'desc') // Urutkan berdasarkan position descending
            ->take(12) // Ambil 12 produk
            ->get(); // Eksekusi query


        // **Mencatat Visitor**
        $agent = new Agent();
        $visitor = new Visitor();
        $visitor->visit_time = now();
        $visitor->ip_address = $request->ip();
        $visitor->session_id = session()->getId();
        $visitor->cookie_id = $request->cookie('laravel_session');
        $visitor->user_agent = $request->header('User-Agent');
        $visitor->device = $agent->device();
        $visitor->platform = $agent->platform();
        $visitor->browser = $agent->browser();
        $visitor->save();

        return view('front.beranda', compact(
            'data_product_categories',
            'data_sliders',
            'data_stores',
            'data_services',
            'data_galleries',
            'data_products',
            'product_first_category',
            'product_second_category',
            'product_third_category',
            'first_category',
            'second_category',
            'third_category',
            'product_discount',
            'title',
            'subtitle'
        ));
    }

    public function product(Request $request)
    {
        $profil = Profil::first();
        $title = "Halaman Produk " . ($profil ? $profil->nama_profil : 'Nama Profil');
        $subtitle = "Menu Produk";

        $data_product_categories = Category::select('id', 'name', 'image', 'slug')
            ->orderBy('position', 'asc')
            ->get();

        // Ambil input pencarian, sortir, dan kategori
        $search = $request->input('search');
        $sort = $request->input('sort');
        $category_slug = $request->input('category');

        // Cari kategori berdasarkan slug
        $category = Category::where('slug', $category_slug)->first();

        // Query produk dengan filter kategori, pencarian, dan sortir
        $data_products = Product::with('category:id,name,slug')
            ->select('id', 'name', 'image', 'cost_price', 'price_before_discount', 'description', 'category_id', 'note', 'user_id', 'sold','slug')
            ->when($category, function ($query) use ($category) {
                return $query->where('category_id', $category->id);
            })
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                        ->orWhere('description', 'like', "%$search%");
                });
            })
            ->when($sort, function ($query) use ($sort) {
                if ($sort == 'termurah') {
                    return $query->orderBy('cost_price', 'asc');
                } elseif ($sort == 'termahal') {
                    return $query->orderBy('cost_price', 'desc');
                }
                return $query;
            })
            ->inRandomOrder() // Tambahkan ini agar urutan acak setiap reload
            ->paginate(20);



        return view('front.product', compact(
            'title',
            'subtitle',
            'data_product_categories',
            'data_products',
            'search',
            'sort',
            'category_slug'
        ));
    }


    public function product_detail($slug)
    {
        $title = "Halaman Produk Detail";
        $subtitle = "Menu Produk Detail";

        // Ambil produk berdasarkan slug & sertakan gambar tambahan dari tabel product_images
        $product = Product::with('images')->where('slug', $slug)->firstOrFail();

        // Produk lain (opsional)
        $product_other = Product::all();

        return view('front.product_detail', compact(
            'title',
            'product',
            'product_other',
            'subtitle'
        ));
    }


    public function store(Request $request)
    {
        $profil = Profil::first();
        $title = "Halaman Toko " . ($profil ? $profil->nama_profil : 'Nama Profil');
        $subtitle = "Menu Toko";

        // Ambil hanya user dengan status 'active'
        $query = User::where('status', 'active');

        // Filter pencarian berdasarkan beberapa kolom
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('user', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%')
                    ->orWhere('address', 'like', '%' . $request->search . '%')
                    ->orWhere('about', 'like', '%' . $request->search . '%');
            });
        }

        // Sorting berdasarkan waktu pembuatan
        if ($request->has('sort')) {
            if ($request->sort == 'terlama') {
                $query->orderBy('created_at', 'asc'); // Dari paling lama ke terbaru
            } elseif ($request->sort == 'terbaru') {
                $query->orderBy('created_at', 'desc'); // Dari terbaru ke paling lama
            }
        } else {
            $query->orderBy('created_at', 'desc'); // Default: terbaru dulu
        }

        // Pagination dengan 1 store per halaman
        $data_stores = $query->paginate(1);

        return view('front.store', compact(
            'data_stores',
            'title',
            'subtitle'
        ));
    }




    public function store_detail($user)
    {
        $title = "Halaman Toko Detail";
        $subtitle = "Menu Toko Detail";

        // Ambil data store berdasarkan user
        $data_stores = User::with('links')->where('user', $user)->firstOrFail();

        // Ambil produk berdasarkan user_id yang sesuai dan paginasi 2 produk per halaman
        $data_products = Product::where('user_id', $data_stores->id)->paginate(2);

        // Hitung total produk
        $total_products = Product::where('user_id', $data_stores->id)->count();

        return view('front.store_detail', compact(
            'title',
            'data_stores',
            'data_products',
            'total_products',
            'subtitle'
        ));
    }
}
