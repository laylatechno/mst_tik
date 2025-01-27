<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
        // Set page title and subtitle
        $title = "Parcel by Monera";
        $subtitle = "Menu Beranda";
        $produk = Product::all();


        return view('front.beranda', compact(
            'produk',
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
