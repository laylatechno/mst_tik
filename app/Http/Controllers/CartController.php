<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class CartController extends Controller
{
    public function index()
    {
        $title = "Halaman Keranjang";
        $subtitle = "Menu Keranjang";
        $cart = session('cart', []);
    
        // Mengelompokkan produk berdasarkan user_id
        $groupedCart = collect($cart)->groupBy('user_id');
    
        // Mendapatkan data pengguna
        $users = User::whereIn('id', $groupedCart->keys())->get();
        $allCartItems = collect($cart)->values();
    
        // Memeriksa pesan sukses dari sesi
        $successMessage = session('success');
    
        return view('front.cart', compact('groupedCart', 'users', 'title', 'subtitle', 'allCartItems', 'successMessage'));
    }
    

    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);
    
        $product = Product::findOrFail($productId);
    
        $cart = Session::get('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'product_id' => $product->id, // Pastikan menggunakan 'product_id' bukan 'produk_id'
                'user_id' => $product->user_id,
                'name' => $product->name,
                'cost_price' => $product->cost_price,
                'price_before_discount' => $product->price_before_discount,
                'status_discount' => $product->status_discount,
                'image' => $product->image,
                'quantity' => $quantity,
            ];
        }
    
        Session::put('cart', $cart);
    
        return response()->json(['message' => 'Berhasil ditambahkan ke keranjang!']);
    }
    
    

    public function delete($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus.');
    }

    public function reset()
    {
        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil dikosongkan.');
    }
}
