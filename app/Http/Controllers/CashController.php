<?php

namespace App\Http\Controllers;

use App\Models\LogHistori;
use App\Models\Cash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:cash-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:cash-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:cash-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:cash-delete', ['only' => ['destroy']]);
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
    public function index(Request $request): View
    {
        $title = "Halaman Cash";
        $subtitle = "Menu Cash";
        $user = auth()->user(); // Ambil user yang sedang login 
        if ($user->can('user-access')) {
            $data_cashs = Cash::with('user')->get();
        } else {
            // Jika tidak, hanya tampilkan supplier dengan user_id yang sesuai dengan user yang login
            $data_cashs = Cash::where('user_id', $user->id)->with('user')->get();
        }
        return view('cash.index', compact('data_cashs', 'title', 'subtitle'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $title = "Halaman Tambah Cash";
        $subtitle = "Menu Tambah Cash";
        $users = User::all();
        return view('cash.create', compact('title', 'subtitle', 'users'));
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
            'name' => 'required|unique:cash,name',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.unique' => 'Nama sudah terdaftar.',
        ]);

        // Menghapus separator ',' dan '.' pada amount
        $amount = str_replace([',', '.'], '', $request->input('amount'));

        // Ambil user_id berdasarkan kondisi
        $loggedInUserId = Auth::id();
        $userIdToSave = $request->filled('user_id') && Auth::user()->can('user-access')
            ? $request->user_id
            : $loggedInUserId;

        // Membuat data baru dengan user_id
        $cash = Cash::create(array_merge(
            $request->except('amount', 'user_id'),
            ['amount' => $amount, 'user_id' => $userIdToSave]
        ));


        $loggedInUserId = Auth::id();
        // Simpan log histori untuk operasi Create dengan user_id yang sedang login
        $this->simpanLogHistori('Create', 'Cash', $cash->id, $loggedInUserId, null, json_encode($cash));

        return redirect()->route('cash.index')
            ->with('success', 'Cash berhasil dibuat.');
    }





    /**
     * Display the specified resource.
     *
     * @param  \App\Cash  $cash
     * @return \Illuminate\Http\Response
     */
    public function show($id): View

    {
        $title = "Halaman Lihat Cash";
        $subtitle = "Menu Lihat Cash";
        $data_cashs = Cash::find($id);
        return view('cash.show', compact('data_cashs', 'title', 'subtitle'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cash  $cash
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $title = "Halaman Edit Cash";
        $subtitle = "Menu Edit Cash";
        $data_cashs = Cash::findOrFail($id); // Data menu item yang sedang diedit
        $users = User::all();
        return view('cash.edit', compact('data_cashs', 'title', 'subtitle', 'users'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cash  $cash
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        // Validasi input
        $this->validate($request, [
            'name' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi.',
        ]);

        // Cari data berdasarkan ID
        $cash = Cash::find($id);

        // Jika data tidak ditemukan
        if (!$cash) {
            return redirect()->route('cash.index')
                ->with('error', 'Data Cash tidak ditemukan.');
        }

        // Menyimpan data lama sebelum update
        $oldCashsnData = $cash->toArray();

        // Menghapus separator ',' dan '.' pada amount
        $amount = str_replace([',', '.'], '', $request->input('amount'));

        // Ambil user_id berdasarkan kondisi
        $loggedInUserId = Auth::id();
        $userIdToSave = $request->filled('user_id') && Auth::user()->can('user-access')
            ? $request->user_id
            : $cash->user_id; // Jika tidak punya izin, user_id tetap sama

        // Melakukan update data
        $cash->update(array_merge(
            $request->except('amount', 'user_id'),
            ['amount' => $amount, 'user_id' => $userIdToSave]
        ));


        // Mendapatkan ID pengguna yang sedang login
        $loggedInUserId = Auth::id();

        // Mendapatkan data baru setelah update
        $newCashsnData = $cash->fresh()->toArray();

        // Menyimpan log histori untuk operasi Update
        $this->simpanLogHistori('Update', 'Cash', $cash->id, $loggedInUserId, json_encode($oldCashsnData), json_encode($newCashsnData));

        return redirect()->route('cash.index')
            ->with('success', 'Cash berhasil diperbaharui');
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cash  $cash
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cash = Cash::find($id);
        $cash->delete();
        $loggedInCashId = Auth::id();
        // Simpan log histori untuk operasi Delete dengan cash_id yang sedang login dan informasi data yang dihapus
        $this->simpanLogHistori('Delete', 'Cash', $id, $loggedInCashId, json_encode($cash), null);
        // Redirect kembali dengan pesan sukses
        return redirect()->route('cash.index')->with('success', 'Cash berhasil dihapus');
    }
}
