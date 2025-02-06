<?php

namespace App\Http\Controllers;

use App\Models\LogHistori;


use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
 




class BackupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:backupdatabase-list|backupdatabase-create|backupdatabase-edit|backupdatabase-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:backupdatabase-create', ['only' => ['create', 'store', 'manualBackup', 'autoBackup','restore']]);
        $this->middleware('permission:backupdatabase-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:backupdatabase-delete', ['only' => ['destroy', 'restoreDatabase']]);
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
        $title = "Halaman Back Up Database";
        $subtitle = "Menu Back Up Database";
        $backups = File::files(base_path('public/backup'));
        return view('backupdatabase.index', compact('title', 'backups', 'subtitle'));
    }

    public function manualBackup()
    {
        // Path tempat menyimpan backup
        $backupPath = public_path('backup/' . date('Y-m-d_H-i-s') . '_backup.sql');

        // Gunakan full path ke mysqldump
        $mysqldumpPath = "C:\\xampp\\mysql\\bin\\mysqldump.exe"; // Windows
        // $mysqldumpPath = "/usr/bin/mysqldump"; // Linux/macOS

        // Pastikan folder backup ada
        if (!file_exists(public_path('backup'))) {
            mkdir(public_path('backup'), 0777, true);
        }

        // Jalankan perintah backup
        $command = "\"{$mysqldumpPath}\" -h 127.0.0.1 -u root db_masterkit > \"{$backupPath}\"";
        exec($command, $output, $return_var);

        if ($return_var !== 0) {
            return response()->json(['error' => 'Backup gagal!'], 500);
        }

        return response()->download($backupPath);
    }



    public function restore(Request $request)
    {
        $request->validate([
            'sql_file' => 'required|mimes:sql|max:2048',
        ]);

        // Upload file SQL
        $file = $request->file('sql_file');
        $filePath = $file->storeAs('backups', $file->getClientOriginalName());

        // Proses restore
        $this->restoreDatabase(storage_path('app/' . $filePath));

        return redirect()->back()->with('success', 'Database has been restored successfully.');

    }

    private function restoreDatabase($filePath)
    {
        $databaseConfig = config('database.connections.mysql');
    
        // Tentukan perintah untuk restore database
        $command = sprintf(
            'mysql -u%s -p%s %s < %s',
            $databaseConfig['username'],
            $databaseConfig['password'],
            $databaseConfig['database'],
            $filePath
        );
    
        // Debug: tampilkan perintah untuk memastikan benar
        \Log::info('Restore command: ' . $command);
    
        // Jalankan perintah untuk restore database
        exec($command, $output, $status);
    
        // Debug: tampilkan hasil perintah
        \Log::info('Restore status: ' . $status);
        \Log::info('Output: ' . implode("\n", $output));
    }
    




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View {}




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
     * @param  \App\Adjustments  $adjustment
     * @return \Illuminate\Http\Response
     */
    public function show($id) {}

    public function print($id) {}



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Adjustments  $adjustment
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View {}





    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Adjustments  $adjustment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {}







    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Adjustments  $adjustment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {}
}
