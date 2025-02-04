<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Slider;
use App\Models\Profil;
use App\Models\Service;
use App\Models\Testimony;

class BerandaController extends Controller
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
    public function index()
    {
        // Ambil profil pertama
        $profil = Profil::first();
        // Set title dan subtitle
        $title = "Halaman " . ($profil ? $profil->nama_profil : 'Nama Profil');
        $subtitle = "Menu Beranda";


         // Menggunakan eager loading dan memilih kolom yang diperlukan
         $data_sliders = Slider::select('id', 'name', 'image', 'description')->get();
         $data_services = Service::select('id', 'name', 'image', 'description')->get();
        //  $data_travel_routes = TravelRoute::select('id', 'image', 'price', 'start', 'end')->get();
        //  $data_blogs = Blog::with(['blog_category:id,name'])->select('id', 'title', 'description', 'slug', 'posting_date', 'writer', 'image', 'blog_category_id')->get();
 
 
      
        return view('front.beranda', compact(
            'data_sliders',
            'data_services',
            'title',
            'subtitle',
        ));
    }
    


    public function katalog()
    {
        // Set page title and subtitle
        $title = "Katalog - Parcel by Monera";
        $subtitle = "Menu Katalog";
        $produk = Product::all();
        return view('front.katalog', compact(
            'title',
            'subtitle',
            'produk',
        ));
    }

    public function katalog_detail($slug)
    {
        $title = "Halaman Produk Detail";
        $subtitle = "Menu Produk Detail";
        $produk = Product::where('slug', $slug)->firstOrFail();
        $produk_lain = Product::all();
        // $kategori_produk = KategoriProduk::all();
        return view('front.katalog_detail', compact(
            'title',
            'produk',
            'produk_lain',
            'subtitle',

        ));
    }

    public function testimoni()
    {
        // Set page title and subtitle
        $title = "Testimoni - Parcel by Monera";
        $subtitle = "Menu Testimoni";
        $data_testimonial = Testimony::all();


        return view('front.testimoni', compact(
            'data_testimonial',
            'title',
            'subtitle',

        ));
    }
}
