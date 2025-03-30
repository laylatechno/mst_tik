<?php

namespace App\Http\Controllers;

use App\Models\LogHistori;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\ImageService;
use Yajra\DataTables\Facades\DataTables;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $imageService;
    function __construct(ImageService $imageService)
    {
        $this->middleware('permission:blog-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:blog-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:blog-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:blog-delete', ['only' => ['destroy']]);
        $this->imageService = $imageService;
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
        $title = "Halaman Blog";
        $subtitle = "Menu Blog";

        if ($request->ajax()) {
            $query = Blog::select('id', 'posting_date', 'title', 'writer', 'resume', 'position', 'image');

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('image', function ($blog) {
                    return '<a href="/upload/blogs/' . $blog->image . '" target="_blank">
                            <img style="max-width:50px; max-height:50px" src="/upload/blogs/' . $blog->image . '" alt="">
                        </a>';
                })
                ->addColumn('actions', function ($blog) {
                    $btn = '<a class="btn btn-warning btn-sm" href="' . route('blogs.show', $blog->id) . '">
                        <i class="fa fa-eye"></i> Show
                    </a>';

                    if (auth()->user()->can('blog-edit')) {
                        $btn .= ' <a class="btn btn-primary btn-sm" href="' . route('blogs.edit', $blog->id) . '">
                            <i class="fa fa-edit"></i> Edit
                          </a>';
                    }

                    if (auth()->user()->can('blog-delete')) {
                        $btn .= ' <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(' . $blog->id . ')">
                            <i class="fa fa-trash"></i> Delete
                          </button>
                          <form id="delete-form-' . $blog->id . '" method="POST" action="' . route('blogs.destroy', $blog->id) . '" style="display:none;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                          </form>';
                    }

                    return $btn;
                })
                ->rawColumns(['image', 'actions'])
                ->make(true);
        }

        return view('blog.index', compact('title', 'subtitle'));
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $title = "Halaman Tambah Blog";
        $subtitle = "Menu Tambah Blog";
        $data_blog_categories = BlogCategory::all();

        // Kirim data ke view
        return view('blog.create', compact('title', 'subtitle', 'data_blog_categories'));
    }



    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'title' => 'required|string|max:255|unique:blogs,title',
            'position' => 'nullable|integer|min:0',
            'image' => 'image|mimes:jpeg,jpg,png|max:4096',
            'blog_category_id' => 'required',
            'posting_date' => 'required',
        ], [
            'title.required' => 'Nama Blog wajib diisi.',
            'title.string' => 'Nama Blog harus berupa teks.',
            'title.max' => 'Nama Blog tidak boleh lebih dari 255 karakter.',
            'title.unique' => 'Judul Blog sudah ada.',

            'posting_date.required' => 'Tanggal Posting wajib diisi.',
            'blog_category_id.required' => 'Kategori wajib diisi.',

            'position.integer' => 'Urutan harus berupa angka.',
            'position.min' => 'Urutan tidak boleh kurang dari 0.',

            'image.image' => 'Gambar harus berupa file gambar.',
            'image.mimes' => 'Format gambar harus jpeg, jpg, atau png.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 4 MB.',
        ]);



        // Mengambil semua input dan memproses harga
        $input = $request->all();



        // Upload dan konversi gambar menggunakan service
        if ($request->hasFile('image')) {
            $input['image'] = $this->imageService->handleImageUpload(
                $request->file('image'),
                'upload/blogs'
            );
        } else {
            $input['image'] = '';
        }

        $blog = Blog::create($input);

        $loggedInUserId = Auth::id();
        $this->simpanLogHistori('Create', 'Blog', $blog->id, $loggedInUserId, null, json_encode($blog));

        return redirect()->route('blogs.index')->with('success', 'Data berhasil disimpan');
    }











    /**
     * Display the specified resource.
     *
     * @param  \App\Blogs  $blog
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        // Judul untuk halaman
        $title = "Halaman Lihat Blog";
        $subtitle = "Menu Lihat Blog";



        // Ambil data blog berdasarkan ID
        $data_blogs = Blog::with('blog_category')->find($id);


        // Kembalikan view dengan membawa data produk
        return view('blog.show', compact(
            'title',
            'subtitle',

            'data_blogs',
        ));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Blogs  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $title = "Halaman Edit Blog";
        $subtitle = "Menu Edit Blog";


        // Ambil data blog berdasarkan ID
        $data_blogs = Blog::findOrFail($id);
        $data_blog_categories = BlogCategory::all();

        // Kirim data ke view
        return view('blog.edit', compact(
            'title',
            'subtitle',
            'data_blogs',
            'data_blog_categories',
        ));
    }


    public function update(Request $request, Blog $blog): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'position' => 'nullable|integer|min:0',
            'image' => 'image|mimes:jpeg,jpg,png|max:4096',
            'blog_category_id' => 'required',
            'posting_date' => 'required',
        ], [
            'title.required' => 'Nama Blog wajib diisi.',
            'title.string' => 'Nama Blog harus berupa teks.',
            'title.max' => 'Nama Blog tidak boleh lebih dari 255 karakter.',

            'posting_date.required' => 'Tanggal Posting wajib diisi.',
            'blog_category_id.required' => 'Kategori wajib diisi.',

            'position.integer' => 'Urutan harus berupa angka.',
            'position.min' => 'Urutan tidak boleh kurang dari 0.',

            'image.image' => 'Gambar harus berupa file gambar.',
            'image.mimes' => 'Format gambar harus jpeg, jpg, atau png.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 4 MB.',
        ]);


        // Simpan data lama untuk log
        $oldData = $blog->toArray();

        $input = $request->all();


        // Upload dan konversi gambar menggunakan service
        if ($request->hasFile('image')) {
            $input['image'] = $this->imageService->handleImageUpload(
                $request->file('image'),
                'upload/blogs',
                $blog->image // Pass old image for deletion
            );
        } else {
            $input['image'] = $blog->image; // Gunakan gambar yang sudah ada
        }

        // Update data blog
        $blog->update($input);

        // Simpan log histori
        $loggedInUserId = Auth::id();
        $this->simpanLogHistori(
            'Update',
            'Blog',
            $blog->id,
            $loggedInUserId,
            json_encode($oldData),
            json_encode($blog->toArray())
        );

        return redirect()->route('blogs.index')->with('success', 'Data berhasil diperbarui');
    }









    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blogs  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Cari blog berdasarkan ID
        $blog = Blog::findOrFail($id);


        try {


            // Hapus file gambar jika ada
            if (!empty($blog->image)) {
                $imagePath = public_path('upload/blogs/' . $blog->image);
                if (file_exists($imagePath)) {
                    @unlink($imagePath); // Menghapus file gambar
                }
            }



            // Hapus blog dari tabel blogs
            $blog->delete();

            // Mendapatkan ID pengguna yang sedang login
            $loggedInUserId = Auth::id();

            // Simpan log histori untuk operasi Delete
            $this->simpanLogHistori('Delete', 'Blog', $id, $loggedInUserId, json_encode($blog), null);

            // Commit blog
            DB::commit();

            // Redirect kembali dengan pesan sukses
            return redirect()->route('blogs.index')->with('success', 'Blog berhasil dihapus');
        } catch (\Exception $e) {
            // Rollback blog jika terjadi error
            DB::rollBack();

            // Kembalikan pesan error
            return redirect()->route('blogs.index')->with('error', 'Gagal menghapus blog: ' . $e->getMessage());
        }
    }
}
