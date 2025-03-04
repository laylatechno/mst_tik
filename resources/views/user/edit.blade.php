@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('template/back/dist/libs/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('template/back') }}/dist/libs/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">
<link rel="stylesheet" href="{{ asset('template/back') }}/dist/libs/ckeditor/samples/css/samples.css">
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
                            <li class="breadcrumb-item"><a class="text-muted text-decoration-none" href="{{ route('users.index') }}">Halaman User</a></li>
                            <li class="breadcrumb-item">{{ $subtitle }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3 text-center">
                    <img src="{{ asset('template/back/dist/images/breadcrumb/ChatBc.png') }}" alt="" class="img-fluid mb-n4">
                </div>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <section class="datatables">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> Ada beberapa masalah dengan data yang Anda masukkan.
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('users.update', $data_user->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Tabs Navigation -->
                            <ul class="nav nav-tabs" id="userTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab" aria-controls="basic" aria-selected="true">
                                        Informasi Dasar
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="other-tab" data-bs-toggle="tab" data-bs-target="#other" type="button" role="tab" aria-controls="other" aria-selected="false">
                                        Lainnya
                                    </button>
                                </li>
                            </ul>

                            <!-- Tabs Content -->
                            <div class="tab-content mt-3" id="userTabsContent">
                                <!-- Tab Informasi Dasar -->
                                <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="name" class="form-label"><strong>Nama:</strong></label>
                                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $data_user->name) }}">
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="user" class="form-label"><strong>User:</strong></label>
                                            <input type="text" name="user" id="user" class="form-control" value="{{ old('user', $data_user->user) }}">
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="email" class="form-label"><strong>Email:</strong></label>
                                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $data_user->email) }}">
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="password" class="form-label"><strong>Password (Kosongkan jika tidak diubah):</strong></label>
                                            <input type="password" name="password" id="password" class="form-control" placeholder="Password baru">
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label><strong>Role:</strong></label>
                                            <select name="roles[]" class="select2 form-control" multiple="multiple">
                                                <option></option>
                                                <optgroup label="--Pilih Role--">
                                                    @foreach ($roles as $value => $label)
                                                    <option value="{{ $value }}" {{ in_array($value, $usersRole) ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="image" class="form-label"><strong>Gambar:</strong></label>
                                            <input type="file" name="image" class="form-control" id="image" onchange="previewImage()">
                                            @if ($data_user->image)
                                            <img id="preview_image" src="{{ asset('upload/users/'.$data_user->image) }}" alt="Preview Gambar" style="max-width: 10%; margin-top: 10px;">
                                            @endif
                                            <canvas id="preview_canvas" style="display: none; max-width: 100%; margin-top: 10px;"></canvas>
                                            <img id="preview_image" src="#" alt="Preview Logo" style="display: none; max-width: 100%; margin-top: 10px;">

                                            <script>
                                                function previewImage() {
                                                    var previewCanvas = document.getElementById('preview_canvas');
                                                    var previewImage = document.getElementById('preview_image');
                                                    var fileInput = document.getElementById('image');
                                                    var file = fileInput.files[0];
                                                    var reader = new FileReader();

                                                    reader.onload = function(e) {
                                                        var img = new Image();
                                                        img.src = e.target.result;

                                                        img.onload = function() {
                                                            var canvasContext = previewCanvas.getContext('2d');
                                                            var maxWidth = 300; // Max width diperbesar
                                                            var scaleFactor = maxWidth / img.width;
                                                            var newHeight = img.height * scaleFactor;

                                                            // Atur dimensi canvas
                                                            previewCanvas.width = maxWidth;
                                                            previewCanvas.height = newHeight;

                                                            // Gambar ke canvas
                                                            canvasContext.drawImage(img, 0, 0, maxWidth, newHeight);

                                                            // Tampilkan pratinjau
                                                            previewCanvas.style.display = 'block';
                                                            previewImage.style.display = 'none';
                                                        };
                                                    };

                                                    if (file) {
                                                        reader.readAsDataURL(file); // Membaca file sebagai URL data
                                                    } else {
                                                        // Reset pratinjau jika tidak ada file
                                                        previewImage.src = '';
                                                        previewCanvas.style.display = 'none';
                                                    }
                                                }
                                            </script>


                                        </div>
                                    </div>
                                </div>

                                <!-- Tab Lainnya -->
                                <div class="tab-pane fade" id="other" role="tabpanel" aria-labelledby="other-tab">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="banner" class="form-label"><strong>Banner:</strong></label>
                                            <input type="file" name="banner" class="form-control" id="banner" onchange="previewBanner()">
                                            @if ($data_user->banner)
                                            <img id="preview_banner" src="{{ asset('upload/users/'.$data_user->banner) }}" alt="Preview Banner" style="max-width: 10%; margin-top: 10px;">
                                            @endif


                                            <canvas id="preview_canvas_banner" style="display: none; max-width: 100%; margin-top: 10px;"></canvas>

                                            <script>
                                                function previewBanner() {
                                                    var previewCanvas = document.getElementById('preview_canvas_banner');
                                                    var previewBanner = document.getElementById('preview_banner');
                                                    var fileInput = document.getElementById('banner');
                                                    var file = fileInput.files[0];
                                                    var reader = new FileReader();

                                                    reader.onload = function(e) {
                                                        var img = new Image();
                                                        img.src = e.target.result;

                                                        img.onload = function() {
                                                            var canvasContext = previewCanvas.getContext('2d');
                                                            var maxWidth = 300; // Max width diperbesar
                                                            var scaleFactor = maxWidth / img.width;
                                                            var newHeight = img.height * scaleFactor;

                                                            // Atur dimensi canvas
                                                            previewCanvas.width = maxWidth;
                                                            previewCanvas.height = newHeight;

                                                            // Gambar ke canvas
                                                            canvasContext.drawImage(img, 0, 0, maxWidth, newHeight);

                                                            // Tampilkan pratinjau
                                                            previewCanvas.style.display = 'block';
                                                            previewBanner.style.display = 'none';
                                                        };
                                                    };

                                                    if (file) {
                                                        reader.readAsDataURL(file); // Membaca file sebagai URL data
                                                    } else {
                                                        // Reset pratinjau jika tidak ada file
                                                        previewBanner.src = '';
                                                        previewCanvas.style.display = 'none';
                                                    }
                                                }
                                            </script>


                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="about" class="form-label"><strong>Tentang:</strong></label>
                                            <textarea name="about" id="about" class="form-control">{{ old('about', $data_user->about) }}</textarea>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="description" class="form-label"><strong>Deskripsi:</strong></label>
                                            <textarea name="description" id="description" class="form-control">{{ old('description', $data_user->description) }}</textarea>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="address" class="form-label"><strong>Alamat:</strong></label>
                                            <textarea name="address" id="address" class="form-control">{{ old('address', $data_user->address) }}</textarea>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="phone_number" class="form-label"><strong>Nomor Telepon:</strong></label>
                                            <input type="number" name="phone_number" id="phone_number" class="form-control" value="{{ old('phone_number', $data_user->phone_number) }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="wa_number" class="form-label"><strong>Nomor WhatsApp:</strong></label>
                                            <input type="number" name="wa_number" id="wa_number" class="form-control" value="{{ old('wa_number', $data_user->wa_number) }}">
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="maps" class="form-label"><strong>Maps:</strong></label>
                                            <textarea name="maps" id="maps" class="form-control" placeholder="Maps">{{ old('maps', $data_user->maps ?? '') }}</textarea>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="embed_youtube" class="form-label"><strong>Embed Youtube:</strong></label>
                                            <textarea name="embed_youtube" id="embed_youtube" class="form-control" placeholder="Youtube">{{ old('embed_youtube', $data_user->embed_youtube ?? '') }}</textarea>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="status" class="form-label"><strong>Status:</strong></label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="active" {{ old('status', $data_user->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                                <option value="nonactive" {{ old('status', $data_user->status) == 'nonactive' ? 'selected' : '' }}>Nonaktif</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Button Actions -->
                            <div class="col-md-12 mt-3">
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Simpan</button>
                                <a href="{{ route('users.index') }}" class="btn btn-warning btn-sm"><i class="fa fa-undo"></i> Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection

@push('script')
<script src="{{ asset('template/back') }}/dist/libs/ckeditor/ckeditor.js"></script>
<script src="{{ asset('template/back') }}/dist/libs/ckeditor/samples/js/sample.js"></script>
<script>
    //default
    initSample();
</script>
<script data-sample="1">
    CKEDITOR.replace("description", {
        height: 150,
    });
</script>

<script src="{{ asset('template/back/dist/libs/select2/dist/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "--Pilih Role--",
            allowClear: true
        });
    });
</script>
@endpush