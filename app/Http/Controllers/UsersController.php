<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LogHistori;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\Link;
use App\Models\Product;
use App\Services\ImageService;

class UsersController extends Controller
{
    protected $imageService;
    function __construct(ImageService $imageService)
    {
        $this->middleware('permission:user-list', ['only' => ['index']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        $this->imageService = $imageService;
    }

    private function simpanLogHistori($aksi, $tabelAsal, $idEntitas, $pengguna, $dataLama, $dataBaru)
    {
        LogHistori::create([
            'tabel_asal' => $tabelAsal,
            'id_entitas' => $idEntitas,
            'aksi' => $aksi,
            'waktu' => now(),
            'pengguna' => $pengguna,
            'data_lama' => $dataLama,
            'data_baru' => $dataBaru,
        ]);
    }

    public function index(Request $request): View
    {
        $title = "Halaman User";
        $subtitle = "Menu User";
        $user = auth()->user(); // Ambil user yang sedang login

        // Query data user
        $query = User::with('roles');

        // Jika user tidak memiliki permission 'user-access', hanya tampilkan dirinya sendiri
        if (!$user->can('user-access')) {
            $query->where('id', $user->id);
        }

        $data_user = $query->get();

        return view('user.index', compact('data_user', 'title', 'subtitle'));
    }


    public function manageLinks(User $user)
    {
        $title = "Halaman Link User";
        $subtitle = "Menu Link User";
        return view('user.link', compact('user', 'title', 'subtitle'));
    }

    public function storeLink(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'link' => 'required|url'
        ]);

        $user->links()->create([
            'name' => $request->name,
            'link' => $request->link
        ]);

        return back()->with('success', 'Link berhasil ditambahkan!');
    }

    public function deleteLink(User $user, Link $link)
    {
        $link->delete();
        return back()->with('success', 'Link berhasil dihapus!');
    }

    public function create(): View
    {
        $title = "Halaman Tambah User";
        $subtitle = "Menu Tambah User";
        $roles = Role::pluck('name', 'name');
        return view('user.create', compact('roles', 'title', 'subtitle'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'user' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:4048',
            'banner' => 'image|mimes:jpeg,png,jpg,gif,webp|max:4048'
        ], [
            'name.required' => 'Nama wajib diisi.',
            'user.required' => 'User wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.same' => 'Password dan konfirmasi password harus sama.',
            'roles.required' => 'Peran wajib dipilih.',
            'image.image' => 'Gambar harus dalam format jpeg, jpg, atau png',
            'image.mimes' => 'Format gambar harus jpeg, jpg, atau png',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 4 MB',
            'banner.image' => 'Gambar harus dalam format jpeg, jpg, atau png',
            'banner.mimes' => 'Format gambar harus jpeg, jpg, atau png',
            'banner.max' => 'Ukuran gambar tidak boleh lebih dari 4 MB'
        ]);

        // Menyiapkan data input
        $input = $request->all();

        // Proses image jika ada file yang diupload
        // if ($image = $request->file('image')) {
        //     $destinationPath = public_path('upload/users/');
        //     $originalFileName = $image->getClientOriginalName();
        //     $imageMimeType = $image->getMimeType();

        //     // Pastikan folder tujuan ada
        //     if (!file_exists($destinationPath)) {
        //         mkdir($destinationPath, 0755, true);
        //     }

        //     // Nama file baru
        //     $imageName = date('YmdHis') . '_' . str_replace(' ', '_', $originalFileName);

        //     // Pindahkan file ke folder tujuan
        //     $image->move($destinationPath, $imageName);

        //     $sourceImagePath = $destinationPath . $imageName;
        //     $webpImagePath = $destinationPath . pathinfo($imageName, PATHINFO_FILENAME) . '.webp';

        //     // Konversi ke WebP jika perlu
        //     switch ($imageMimeType) {
        //         case 'image/jpeg':
        //             $sourceImage = @imagecreatefromjpeg($sourceImagePath);
        //             break;
        //         case 'image/png':
        //             $sourceImage = @imagecreatefrompng($sourceImagePath);
        //             break;
        //         default:
        //             throw new \Exception('Tipe MIME tidak didukung.');
        //     }

        //     if ($sourceImage !== false) {
        //         imagewebp($sourceImage, $webpImagePath);
        //         imagedestroy($sourceImage);
        //         @unlink($sourceImagePath); // Hapus file asli
        //         $input['image'] = pathinfo($imageName, PATHINFO_FILENAME) . '.webp';
        //     } else {
        //         throw new \Exception('Gagal membaca gambar asli.');
        //     }
        // } else {
        //     $input['image'] = null; // Jika tidak ada gambar
        // }

        // Upload dan konversi gambar menggunakan service
        if ($request->hasFile('image')) {
            $input['image'] = $this->imageService->handleImageUpload(
                $request->file('image'),
                'upload/users'
            );
        } else {
            $input['image'] = '';
        }

        if ($request->hasFile('banner')) {
            $input['banner'] = $this->imageService->handleImageUpload(
                $request->file('banner'),
                'upload/users'
            );
        } else {
            $input['banner'] = '';
        }

        // Hash password sebelum disimpan
        $input['password'] = Hash::make($input['password']);

        // Simpan data user
        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        // Simpan log histori
        $this->simpanLogHistori('Create', 'User', $user->id, Auth::id(), null, json_encode($user));

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dibuat');
    }



    public function show($id): View
    {
        $title = "Halaman Lihat User";
        $subtitle = "Menu Lihat User";
        $data_user = User::with('roles')->find($id);

        return view('user.show', compact('data_user', 'title', 'subtitle'));
    }

    public function edit($id): View
    {
        $title = "Halaman Edit User";
        $subtitle = "Menu Edit User";
        $data_user = User::with('roles')->find($id);
        $roles = Role::pluck('name', 'name');
        $usersRole = $data_user->roles->pluck('name', 'name')->all();

        return view('user.edit', compact('data_user', 'roles', 'usersRole', 'title', 'subtitle'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'user' => 'required',
            'email' => 'required|email',
            'password' => 'same:confirm-password',
            'roles' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:4048',
            'banner' => 'image|mimes:jpeg,png,jpg,gif,webp|max:4048'
        ], [
            'name.required' => 'Nama wajib diisi.',
            'user.required' => 'User wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.same' => 'Password dan konfirmasi password harus sama.',
            'roles.required' => 'Peran wajib dipilih.',
            'image.image' => 'Gambar harus dalam format jpeg, jpg, atau png',
            'image.mimes' => 'Format gambar harus jpeg, jpg, atau png',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 4 MB',
            'banner.image' => 'Gambar harus dalam format jpeg, jpg, atau png',
            'banner.mimes' => 'Format gambar harus jpeg, jpg, atau png',
            'banner.max' => 'Ukuran gambar tidak boleh lebih dari 4 MB'
        ]);

        $user = User::find($id);
        $oldData = $user->toArray();

        // Proses data input
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, ['password']);
        }

        // Upload dan konversi gambar menggunakan service
        if ($request->hasFile('image')) {
            $input['image'] = $this->imageService->handleImageUpload(
                $request->file('image'),
                'upload/users',
                $user->image // Pass old image for deletion
            );
        } else {
            $input['image'] = $user->image; // Gunakan gambar yang sudah ada
        }

        if ($request->hasFile('banner')) {
            $input['banner'] = $this->imageService->handleImageUpload(
                $request->file('banner'),
                'upload/users',
                $user->banner // Pass old banner for deletion
            );
        } else {
            $input['banner'] = $user->banner; // Gunakan gambar yang sudah ada
        }

        // Update data user
        $user->update($input);

        // Update role
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles'));

        // Simpan log histori
        $this->simpanLogHistori('Update', 'User', $user->id, Auth::id(), json_encode($oldData), json_encode($input));

        return redirect()->route('users.index')
            ->with('success', 'User berhasil diperbaharui');
    }


    public function destroy($id): RedirectResponse
    {
        $user = User::find($id);
    
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User tidak ditemukan');
        }
    
        // Cek apakah user masih memiliki produk terkait
        $hasProducts = Product::where('user_id', $id)->exists();
    
        if ($hasProducts) {
            return redirect()->route('users.index')->with('error', 'User tidak bisa dihapus karena masih memiliki produk terkait.');
        }
    
        // Hapus gambar jika ada
        if ($user->image) {
            $imagePath = public_path('upload/users/' . $user->image);
            if (file_exists($imagePath)) {
                @unlink($imagePath); // Menghapus file gambar
            }
        }
    
        if ($user->banner) {
            $banner = public_path('upload/users/' . $user->banner);
            if (file_exists($banner)) {
                @unlink($banner); // Menghapus file banner
            }
        }
    
        // Simpan log histori
        $this->simpanLogHistori('Delete', 'User', $id, Auth::id(), json_encode($user->toArray()), null);
    
        // Hapus data pengguna
        $user->delete();
    
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }
    
}
