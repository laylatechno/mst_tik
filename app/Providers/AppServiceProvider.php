<?php

namespace App\Providers;

use App\Models\MenuGroup;
use App\Models\Product;
use App\Models\Profil;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $profil = Profil::first();
        View::share('profil', $profil);



        $menus = MenuGroup::with(['items' => function ($query) {
            $query->where('status', 'Aktif');
        }])->where('status', 'Aktif')->get();

        View::share('menus', $menus);

         // Pastikan ada user yang login
    if (Auth::check()) {
        $user = Auth::user();

        // Jika user memiliki role user-access, ambil semua produk
        if ($user->can('user-access')) {
            $lowStockProducts = Product::whereColumn('stock', '<', 'reminder')->get();
        } else {
            // Jika bukan user-access, hanya ambil produk miliknya
            $lowStockProducts = Product::where('user_id', $user->id)
                ->whereColumn('stock', '<', 'reminder')
                ->get();
        }

        View::share('lowStockProducts', $lowStockProducts);
    } else {
        // Jika tidak ada user yang login, kosongkan variabel
        View::share('lowStockProducts', collect());
    }
    }
}
