<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Profil;
use App\Models\Service;
use App\Models\Visitor;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
        $data_blogs = Blog::with('blog_category:id,name,slug')
            ->select('id', 'title', 'image', 'writer', 'resume', 'description', 'posting_date', 'slug','blog_category_id')
            ->take(4) // Batasi hanya 12 produk
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
            'data_blogs',
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
            ->select('id', 'name', 'image', 'cost_price', 'price_before_discount', 'description', 'category_id', 'note', 'user_id', 'sold', 'slug')
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
            ->paginate(27);



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

        // Ambil produk lain yang memiliki user_id yang sama, kecuali produk yang sedang dilihat
        $product_other = Product::where('user_id', $product->user_id)
            ->where('id', '!=', $product->id) // Hindari produk yang sama
            ->get();

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
    
        // Ambil hanya user dengan status 'active' dan id != 1
        $query = User::where('status', 'active')->where('id', '!=', 1);
    
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
    
        $data_stores = $query->paginate(10);
    
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

        $data_products = Product::where('user_id', $data_stores->id)->paginate(10);

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


    public function blog(Request $request)
    {
        $profil = Profil::first();
        $title = "Halaman Blog " . ($profil ? $profil->nama_profil : 'Nama Profil');
        $subtitle = "Menu Blog";

        // Ambil kategori dari query parameter (jika ada)
        $categorySlug = $request->query('category');
        $search = $request->query('search');
        $sort = $request->query('sort', 'terbaru');  // Default sort adalah 'terbaru'

        // Ambil kategori blog
        $data_blog_categories = BlogCategory::select('id', 'name', 'slug')->orderBy('position', 'asc')->get();

        // Ambil blogs yang sesuai dengan kategori jika ada, jika tidak ambil semua
        $blogsQuery = Blog::query();

        // Jika kategori terpilih
        if ($categorySlug) {
            $category = BlogCategory::where('slug', $categorySlug)->first();
            $blogsQuery->where('blog_category_id', $category->id);  // Gunakan blog_category_id sebagai foreign key
        }

        // Jika ada query pencarian
        if ($search) {
            $blogsQuery->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('writer', 'like', '%' . $search . '%')
                    ->orWhere('reference', 'like', '%' . $search . '%')
                    ->orWhere('resume', 'like', '%' . $search . '%')
                    ->orWhereHas('blog_category', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        // Sorting berdasarkan parameter
        if ($sort == 'terlama') {
            $blogsQuery->orderBy('created_at', 'asc');  // Terlama
        } else {
            $blogsQuery->orderBy('created_at', 'desc');  // Terbaru
        }

        // Paginate dengan 10 blog per halaman
        $data_blogs = $blogsQuery->paginate(10);

        return view('front.blog', compact('title', 'subtitle', 'data_blog_categories', 'data_blogs'));
    }




    public function blog_detail($slug)
    {
        // Ambil blog berdasarkan slug
        $blog = Blog::where('slug', $slug)->firstOrFail();
    
        // Meningkatkan jumlah views
        $blog->increment('views');
    
        $title = "Detail: " . $blog->title;
        $subtitle = "Blog Detail";
    
        // Kirim data ke view
        return view('front.blog_detail', compact(
            'title',
            'subtitle',
            'blog'
        ));
    }


    public function register(Request $request)
    {
        $profil = Profil::first();
        $title = "Halaman Pendaftaran " . ($profil ? $profil->nama_profil : 'Nama Profil');
        $subtitle = "Menu Pendaftaran";
        return view('front.register', compact('title', 'subtitle'));
    }


    public function register_action(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'user' => 'required|unique:users,user',
            'email' => 'required|email|unique:users,email',
            'wa_number' => 'required',
            'password' => 'required|min:6',
            'confirm-password' => 'required|same:password',
            'about' => 'nullable'
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }
    
        // Transformasi nomor WhatsApp
        $wa_number = $request->wa_number;
        if (substr($wa_number, 0, 1) === '0') {
            $wa_number = '62' . substr($wa_number, 1);
        }
    
        // Buat user baru
        try {
            $user = new User();
            $user->user = $request->user;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->wa_number = $wa_number;
            $user->password = Hash::make($request->password);
            $user->about = $request->about;
            $user->status = 'nonactive';
            $user->save();

            
            $profil = Profil::where('id', 1)->first();
    
            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran member berhasil dilakukan, silahkan tunggu informasi selanjutnya melalui email atau nomor WhatsApp terdaftar member. Untuk pertanyaan lain bisa hubungi Nomor : ' . $profil->no_wa
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
    
}
