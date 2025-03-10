<?php

namespace App\Http\Controllers;

use App\Models\Visitor;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VisitorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:visitor-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:visitor-deleteall', ['only' => ['delete']]);
     
    }


    public function index(Request $request)
    {
        $title = "Halaman Visitor";
        $subtitle = "Menu Visitor";

        // Cek apakah request datang dari AJAX (DataTables)
        if ($request->ajax()) {
            $query = Visitor::with('user')->select('visitor_id', 'page_type', 'user_id', 'visit_time', 'ip_address', 'user_agent', 'platform', 'device', 'browser');

            return DataTables::of($query)
                ->addIndexColumn() // Tambahkan nomor urut otomatis
                ->addColumn('user_name', function ($visitor) {
                    return $visitor->user ? $visitor->user->name : 'Home';
                })
                ->rawColumns(['user_name']) // Kolom ini bisa berisi HTML (jika perlu)
                ->make(true);
        }

        return view('visitor', compact('title', 'subtitle'));
    }

    public function delete()
    {
        Visitor::truncate(); // Menghapus semua data dalam tabel
        return redirect()->route('visitor.index')->with('success', 'Semua data visitor berhasil dihapus.');
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {}


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        
    }

     

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {}


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id) {}



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {}
}
