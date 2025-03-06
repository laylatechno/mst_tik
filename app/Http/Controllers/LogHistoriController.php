<?php

namespace App\Http\Controllers;

use App\Models\LogHistori;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LogHistoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:loghistori-list', ['only' => ['index', 'store','clear']]);
        $this->middleware('permission:loghistori-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:loghistori-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:loghistori-delete', ['only' => ['destroy']]);
    }


    public function index()
    {
        $title = "Halaman Log Histori";
        $subtitle = "Menu Log Histori";
        $data_log_histori = LogHistori::orderBy('id', 'desc')->get();
        return view('log_histori', compact('data_log_histori', 'title', 'subtitle'));
    }

    public function deleteAll()
    {
        try {
            // Use DB facade to perform a raw SQL delete query
            DB::statement('DELETE FROM log_histories');

            // Redirect back with a success message
            return redirect()->route('log_histori.index')->with('success', 'Semua data log histori berhasil dihapus.');
        } catch (\Exception $e) {
            // Redirect back with an error message if something goes wrong
            return redirect()->route('log_histori.index')->with('error', 'Failed to delete data. Please try again.');
        }
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
        $title = "Halaman Logs";
        $subtitle = "Menu Logs";
        $logPath = storage_path('logs/laravel.log');

        if (!File::exists($logPath)) {
            return view('logs', ['logContent' => 'Log file not found.']);
        }

        $logContent = File::get($logPath);
        $logContent = nl2br(e($logContent)); // Konversi newline ke <br> agar rapi

        return view('logs', compact('logContent', 'title', 'subtitle'));
    }

    public function clear()
    {
        $logPath = storage_path('logs/laravel.log');

        if (File::exists($logPath)) {
            File::put($logPath, ''); // Mengosongkan isi log
        }

        return redirect()->route('logs.show')->with('success', 'Log berhasil dihapus.');
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
