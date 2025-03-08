<?php

namespace App\Http\Controllers;

use App\Models\LogHistori;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:supplier-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:supplier-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:supplier-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:supplier-delete', ['only' => ['destroy']]);
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
    // public function index(Request $request): View
    // {
    //     $title = "Halaman Supplier";
    //     $subtitle = "Menu Supplier";
    //     $user = auth()->user();

    //     if ($user->can('user-access')) {
    //         $data_suppliers = Supplier::with('user')->get();
    //     } else {
    //         // Jika tidak, hanya tampilkan supplier dengan user_id yang sesuai dengan user yang login
    //         $data_suppliers = Supplier::where('user_id', $user->id)->with('user')->get();
    //     }



    //     return view('supplier.index', compact('data_suppliers', 'title', 'subtitle'));
    // }

    public function index(Request $request)
    {
        $title = "Halaman Supplier";
        $subtitle = "Menu Supplier";
        $user = auth()->user();

        if ($request->ajax()) {
            if ($user->can('user-access')) {
                $query = Supplier::with('user');
            } else {
                // Jika user tidak memiliki akses, hanya tampilkan supplier yang dibuat oleh user tersebut
                $query = Supplier::where('user_id', $user->id)->with('user');
            }

            return DataTables::of($query)
                ->addIndexColumn() // Menambahkan nomor urut otomatis
                ->addColumn('user_name', function ($supplier) {
                    return $supplier->user->name ?? 'Tidak Diketahui';
                })
                ->addColumn('actions', function ($supplier) {
                    $btn = '<a class="btn btn-warning btn-sm" href="' . route('suppliers.show', $supplier->id) . '"><i class="fa fa-eye"></i> Show</a>';

                    if (auth()->user()->can('supplier-edit')) {
                        $btn .= ' <a class="btn btn-primary btn-sm" href="' . route('suppliers.edit', $supplier->id) . '"><i class="fa fa-edit"></i> Edit</a>';
                    }

                    if (auth()->user()->can('supplier-delete')) {
                        $btn .= ' <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(' . $supplier->id . ')"><i class="fa fa-trash"></i> Delete</button>
                    <form id="delete-form-' . $supplier->id . '" method="POST" action="' . route('suppliers.destroy', $supplier->id) . '" style="display:none;">
                        ' . csrf_field() . '
                        ' . method_field("DELETE") . '
                    </form>';
                    }

                    return $btn;
                })
                ->rawColumns(['actions']) // Pastikan kolom aksi bisa dirender sebagai HTML
                ->make(true);
        }

        return view('supplier.index', compact('title', 'subtitle'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $title = "Halaman Tambah Supplier";
        $subtitle = "Menu Tambah Supplier";
        $users = User::all();
        return view('supplier.create', compact('title', 'subtitle', 'users'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'nullable|email',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'user_id' => 'nullable|exists:users,id',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'address.max' => 'Alamat terlalu panjang.',
            'phone.max' => 'Nomor telepon terlalu panjang.',
            'user_id.exists' => 'Pengguna tidak valid.',
        ]);

        // Ambil user_id berdasarkan kondisi
        $loggedInUserId = Auth::id();
        $userIdToSave = $request->filled('user_id') && Auth::user()->can('user-access')
            ? $request->user_id // Gunakan user_id dari input jika user punya permission
            : $loggedInUserId; // Jika tidak, pakai ID user yang login

        // Simpan data supplier
        $supplier = Supplier::create([
            'name' => $request->name,
            'email' => $request->email ?? null,
            'address' => $request->address ?? null,
            'phone' => $request->phone ?? null,
            'user_id' => $userIdToSave,
        ]);

        // Simpan log histori untuk operasi Create
        $this->simpanLogHistori('Create', 'Supplier', $supplier->id, $loggedInUserId, null, json_encode($supplier));

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier berhasil dibuat.');
    }







    /**
     * Display the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show($id): View

    {
        $title = "Halaman Lihat Supplier";
        $subtitle = "Menu Lihat Supplier";
        $data_suppliers = Supplier::find($id);
        return view('supplier.show', compact('data_suppliers', 'title', 'subtitle'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $title = "Halaman Edit Supplier";
        $subtitle = "Menu Edit Supplier";
        $data_suppliers = Supplier::findOrFail($id);
        $users = User::all();

        return view('supplier.edit', compact('data_suppliers', 'title', 'subtitle', 'users'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        // Validasi input
        $this->validate($request, [
            'name' => 'required',
            'email' => 'nullable|email',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'user_id' => 'nullable|exists:users,id',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'address.max' => 'Alamat terlalu panjang.',
            'phone.max' => 'Nomor telepon terlalu panjang.',
            'user_id.exists' => 'Pengguna tidak valid.',
        ]);

        // Cari data berdasarkan ID
        $supplier = Supplier::find($id);

        // Jika data tidak ditemukan
        if (!$supplier) {
            return redirect()->route('suppliers.index')
                ->with('error', 'Data Supplier tidak ditemukan.');
        }

        // Menyimpan data lama sebelum update
        $oldSupplierData = $supplier->toArray();

        // Mendapatkan ID pengguna yang sedang login
        $loggedInUserId = Auth::id();

        // Tentukan user_id berdasarkan kondisi
        $userIdToSave = $request->filled('user_id') && Auth::user()->can('user-access')
            ? $request->user_id
            : $loggedInUserId;

        // Melakukan update data
        $supplier->update([
            'name' => $request->name,
            'email' => $request->email ?? null,
            'address' => $request->address ?? null,
            'phone' => $request->phone ?? null,
            'user_id' => $userIdToSave,
        ]);

        // Mendapatkan data baru setelah update
        $newSupplierData = $supplier->fresh()->toArray();

        // Menyimpan log histori untuk operasi Update
        $this->simpanLogHistori('Update', 'Supplier', $supplier->id, $loggedInUserId, json_encode($oldSupplierData), json_encode($newSupplierData));

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier berhasil diperbaharui.');
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete();
        $loggedInSupplierId = Auth::id();
        // Simpan log histori untuk operasi Delete dengan supplier_id yang sedang login dan informasi data yang dihapus
        $this->simpanLogHistori('Delete', 'Supplier', $id, $loggedInSupplierId, json_encode($supplier), null);
        // Redirect kembali dengan pesan sukses
        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus');
    }
}
