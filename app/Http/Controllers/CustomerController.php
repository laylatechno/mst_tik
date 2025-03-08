<?php

namespace App\Http\Controllers;

use App\Models\LogHistori;
use App\Models\Customer;
use App\Models\CustomerCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:customer-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:customer-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:customer-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:customer-delete', ['only' => ['destroy']]);
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
    public function index(Request $request)
    {
        $title = "Halaman Pelanggan";
        $subtitle = "Menu Pelanggan";
        $user = auth()->user();

        if ($request->ajax()) {
            if ($user->can('user-access')) {
                $query = Customer::with(['user', 'category']);
            } else {
                $query = Customer::where('user_id', $user->id)->with(['user', 'category']);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('user_name', function ($customer) {
                    return $customer->user->name ?? 'Tidak Diketahui';
                })
                ->addColumn('category_name', function ($customer) {
                    return $customer->category->name ?? '-';
                })
               
                ->addColumn('actions', function ($customer) {
                    $btn = '<a class="btn btn-warning btn-sm" href="' . route('customers.show', $customer->id) . '"><i class="fa fa-eye"></i> Show</a>';

                    if (auth()->user()->can('customer-edit')) {
                        $btn .= ' <a class="btn btn-primary btn-sm" href="' . route('customers.edit', $customer->id) . '"><i class="fa fa-edit"></i> Edit</a>';
                    }

                    if (auth()->user()->can('customer-delete')) {
                        $btn .= ' <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(' . $customer->id . ')"><i class="fa fa-trash"></i> Delete</button>
                    <form id="delete-form-' . $customer->id . '" method="POST" action="' . route('customers.destroy', $customer->id) . '" style="display:none;">
                        ' . csrf_field() . '
                        ' . method_field("DELETE") . '
                    </form>';
                    }

                    return $btn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('customer.index', compact('title', 'subtitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $title = "Halaman Tambah Pelanggan";
        $subtitle = "Menu Tambah Pelanggan";
        $data_customer_categories = CustomerCategory::all();
        $users = User::all();
        return view('customer.create', compact('title', 'subtitle', 'data_customer_categories', 'users'));
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
            'name' => 'required|unique:customers,name',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'customer_category_id' => 'required|exists:customer_categories,id', // Validasi kategori pelanggan
            'user_id' => 'nullable|exists:users,id',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.unique' => 'Nama sudah terdaftar.',
            'email.email' => 'Format email tidak valid.',
            'phone.max' => 'Nomor telepon terlalu panjang.',
            'customer_category_id.required' => 'Kategori pelanggan wajib dipilih.',
            'customer_category_id.exists' => 'Kategori pelanggan tidak valid.',
            'user_id.exists' => 'Pengguna tidak valid.',
        ]);

        // Ambil user_id berdasarkan kondisi
        $loggedInUserId = Auth::id();
        $userIdToSave = $request->filled('user_id') && Auth::user()->can('user-access')
            ? $request->user_id
            : $loggedInUserId;

        // Simpan data customer
        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email ?? null,
            'phone' => $request->phone ?? null,
            'customer_category_id' => $request->customer_category_id, // Tambahkan kategori pelanggan
            'user_id' => $userIdToSave,
        ]);

        // Simpan log histori untuk operasi Create
        $this->simpanLogHistori('Create', 'Customer', $customer->id, $loggedInUserId, null, json_encode($customer));

        return redirect()->route('customers.index')
            ->with('success', 'Pelanggan berhasil dibuat.');
    }






    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($id): View

    {
        $title = "Halaman Lihat Pelanggan";
        $subtitle = "Menu Lihat Pelanggan";
        $data_customers = Customer::find($id);
        return view('customer.show', compact('data_customers', 'title', 'subtitle'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $title = "Halaman Edit Pelanggan";
        $subtitle = "Menu Edit Pelanggan";
        $data_customer_categories = CustomerCategory::all();
        $data_customers = Customer::with('category')->findOrFail($id); // Memuat relasi category
        $users = User::all();
        return view('customer.edit', compact('data_customers', 'title', 'subtitle', 'data_customer_categories','users'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        // Validasi input
        $this->validate($request, [
            'name' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'customer_category_id' => 'required|exists:customer_categories,id', // Validasi kategori pelanggan
            'user_id' => 'nullable|exists:users,id',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'phone.max' => 'Nomor telepon terlalu panjang.',
            'customer_category_id.required' => 'Kategori pelanggan wajib dipilih.',
            'customer_category_id.exists' => 'Kategori pelanggan tidak valid.',
            'user_id.exists' => 'Pengguna tidak valid.',
        ]);

        // Cari data berdasarkan ID
        $customer = Customer::find($id);

        // Jika data tidak ditemukan
        if (!$customer) {
            return redirect()->route('customers.index')
                ->with('error', 'Data Customer tidak ditemukan.');
        }

        // Menyimpan data lama sebelum update
        $oldCustomerData = $customer->toArray();

        // Ambil user_id berdasarkan kondisi
        $loggedInUserId = Auth::id();
        $userIdToSave = $request->filled('user_id') && Auth::user()->can('user-access')
            ? $request->user_id
            : $loggedInUserId;

        // Update data customer
        $customer->update([
            'name' => $request->name,
            'email' => $request->email ?? null,
            'phone' => $request->phone ?? null,
            'customer_category_id' => $request->customer_category_id, // Update kategori pelanggan
            'user_id' => $userIdToSave,
        ]);

        // Mendapatkan data baru setelah update
        $newCustomerData = $customer->fresh()->toArray();

        // Menyimpan log histori untuk operasi Update
        $this->simpanLogHistori('Update', 'Customer', $customer->id, $loggedInUserId, json_encode($oldCustomerData), json_encode($newCustomerData));

        return redirect()->route('customers.index')
            ->with('success', 'Pelanggan berhasil diperbarui.');
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        $customer->delete();
        $loggedInCustomerId = Auth::id();
        // Simpan log histori untuk operasi Delete dengan customer_id yang sedang login dan informasi data yang dihapus
        $this->simpanLogHistori('Delete', 'Customer', $id, $loggedInCustomerId, json_encode($customer), null);
        // Redirect kembali dengan pesan sukses
        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil dihapus');
    }
}
