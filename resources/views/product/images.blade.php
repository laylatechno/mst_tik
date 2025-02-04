@extends('layouts.app')
@push('css')

@endpush

@section('content')
<div class="container-fluid">
    <div class="card bg-light-info shadow-none position-relative overflow-hidden" style="border: solid 0.5px #ccc;">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">{{ $title }}</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-muted text-decoration-none" href="/">Beranda</a></li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a class="text-muted text-decoration-none" href="{{ route('products.index') }}">Halaman Produk</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">{{ $subtitle }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3 text-center mb-n5">
                    <img src="{{ asset('template/back') }}/dist/images/breadcrumb/ChatBc.png" alt="" class="img-fluid mb-n4">
                </div>
            </div>
        </div>
    </div>

    <section class="datatables">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Gambar Produk - {{ $product->name }}</h4>
                    </div>
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        <form action="{{ route('products.images.store', $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Tambah Gambar</label>
                                <input type="file" name="images[]" multiple class="form-control" id="images" accept="image/*" onchange="previewImages()" required>
                                <div id="preview_container" class="row mt-3"></div>

                                <script>
                                    function previewImages() {
                                        const previewContainer = document.getElementById('preview_container');
                                        const fileInput = document.getElementById('images');

                                        // Bersihkan preview container sebelum menambahkan preview baru
                                        previewContainer.innerHTML = '';

                                        if (fileInput.files) {
                                            Array.from(fileInput.files).forEach((file, index) => {
                                                const reader = new FileReader();

                                                reader.onload = function(e) {
                                                    // Buat container untuk setiap preview
                                                    const previewWrapper = document.createElement('div');
                                                    previewWrapper.className = 'col-md-4 mb-3';

                                                    // Buat canvas untuk preview
                                                    const canvas = document.createElement('canvas');
                                                    canvas.style.maxWidth = '100%';

                                                    const img = new Image();
                                                    img.src = e.target.result;

                                                    img.onload = function() {
                                                        const maxWidth = 300;
                                                        const scaleFactor = maxWidth / img.width;
                                                        const newHeight = img.height * scaleFactor;

                                                        // Atur dimensi canvas
                                                        canvas.width = maxWidth;
                                                        canvas.height = newHeight;

                                                        // Gambar ke canvas
                                                        const ctx = canvas.getContext('2d');
                                                        ctx.drawImage(img, 0, 0, maxWidth, newHeight);

                                                        // Tambahkan nama file di bawah preview
                                                        const fileName = document.createElement('p');
                                                        fileName.className = 'text-center mt-2';
                                                        fileName.textContent = file.name;

                                                        previewWrapper.appendChild(canvas);
                                                        previewWrapper.appendChild(fileName);
                                                        previewContainer.appendChild(previewWrapper);
                                                    };
                                                };

                                                reader.readAsDataURL(file);
                                            });
                                        }
                                    }
                                </script>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3"><i class="fa fa-upload"></i> Upload Gambar</button>
                        </form>

                        <hr>




                        <div class="row mt-4">
                            @foreach($images as $image)
                            <div class="col-md-3 mb-4">
                                <div class="card">
                                    <img src="{{ asset('upload/products/details/'.$image->image) }}" class="card-img-top" alt="Product Image">
                                    <div class="card-body">
                                        <form id="delete-form-{{ $image->id }}" action="{{ route('products.images.destroy', [$product->id, $image->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeleteImage({{ $image->id }})">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




</div>
@endsection


@push('script')

<!-- Tambahkan script ini di bagian bawah halaman -->
<script>
    function confirmDeleteImage(imageId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Gambar yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + imageId).submit();
            }
        });
    }

    // // Menampilkan SweetAlert untuk pesan sukses/error dari session
    // @if(Session::has('success'))
    // Swal.fire({
    //     icon: 'success',
    //     title: 'Berhasil!',
    //     text: "{{ Session::get('success') }}",
    // });
    // @endif

    // @if(Session::has('error'))
    // Swal.fire({
    //     icon: 'error',
    //     title: 'Oops...',
    //     text: "{{ Session::get('error') }}",
    // });
    // @endif
</script>
@endpush