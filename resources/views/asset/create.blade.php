@extends('layouts.app')
@push('css')
    <link rel="stylesheet"
        href="{{ asset('template/back') }}/dist/libs/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">
    <link rel="stylesheet" href="{{ asset('template/back') }}/dist/libs/ckeditor/samples/css/samples.css">
    <link rel="stylesheet" href="{{ asset('template/back') }}/dist/libs/select2/dist/css/select2.min.css">

    <style>
        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #888 transparent transparent transparent;
            border-style: solid;
            border-width: 5px 4px 0 4px;
            height: 0;
            left: 50%;
            margin-left: -4px;
            margin-top: 20px;
            position: absolute;
            top: 50%;
            width: 0;
        }
    </style>
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
                                <li class="breadcrumb-item"><a class="text-muted text-decoration-none"
                                        href="/">Beranda</a></li>
                                <li class="breadcrumb-item" aria-current="page">
                                    <a class="text-muted text-decoration-none" href="{{ route('assets.index') }}">Halaman
                                        Aset</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">{{ $subtitle }}</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3 text-center mb-n5">
                        <img src="{{ asset('template/back') }}/dist/images/breadcrumb/ChatBc.png" alt=""
                            class="img-fluid mb-n4">
                    </div>
                </div>
            </div>
        </div>

        <section class="datatables">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> Ada beberapa masalah dengan data yang anda masukkan.
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('assets.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-group mb-3">
                                        <label for="title">Nama Aset <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" id="title"
                                            value="{{ old('name') }}" required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="category">Kategori <span class="text-danger">*</span></label>
                                        <select class="select2 form-control" style="width: 100%; height: 36px"
                                            name="asset_category_id" id="asset_category_id" required>
                                            <option value="">--Pilih Kategori--</option>
                                            @foreach ($data_asset_categories as $p)
                                                <option value="{{ $p->id }}">
                                                    {{ $p->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="code">Kode <span class="text-danger">*</span></label>
                                        <input type="text" name="code" class="form-control" id="code"
                                            value="{{ old('code') }}" required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="purchase_date">Tanggal Beli <span class="text-danger">*</span></label>
                                        <input type="date" name="purchase_date" class="form-control" id="purchase_date"
                                            value="{{ old('purchase_date', date('Y-m-d')) }}" required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="value">Harga <span class="text-danger">*</span></label>
                                        <input type="text" name="value" class="form-control" id="value"
                                            value="{{ old('value') }}" required oninput="formatPrice(this)">
                                    </div>

                                    <script>
                                        function formatPrice(input) {
                                            let value = input.value.replace(/[^0-9]/g, ''); // Hanya ambil angka
                                            if (!value) {
                                                input.value = '';
                                                return;
                                            }

                                            // Format separator ribuan dengan koma
                                            value = parseInt(value, 10).toLocaleString('en-US');

                                            input.value = value;
                                        }
                                    </script>


                                    <div class="form-group mb-3">
                                        <label for="condition">Kondisi <span class="text-danger">*</span></label>
                                        <select name="condition" id="condition" class="form-control" required>
                                            <option value="">-Pilih Kondisi-</option>
                                            <option value="Baru" {{ old('condition') == 'Baru' ? 'selected' : '' }}>Baru
                                            </option>
                                            <option value="Bekas Baik"
                                                {{ old('condition') == 'Bekas Baik' ? 'selected' : '' }}>Bekas Baik
                                            </option>
                                            <option value="Bekas Perlu Perbaikan"
                                                {{ old('condition') == 'Bekas Perlu Perbaikan' ? 'selected' : '' }}>Bekas
                                                Perlu Perbaikan</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="room_id">Lokasi Simpan <span class="text-danger">*</span></label>
                                        <select class="form-control select2" name="room_id" id="room_id" required>
                                            <option value="">-- Pilih Lokasi --</option>
                                            @foreach ($rooms as $room)
                                                <option value="{{ $room->id }}"
                                                    {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                                    {{ $room->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="description">Deskripsi</label>
                                        <textarea cols="80" id="description" name="description" rows="10" data-sample="1" data-sample-short>{{ old('description') }}</textarea>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-control" required>
                                            <option value="">-Pilih Status-</option>
                                            <option value="Tersedia" {{ old('status') == 'Tersedia' ? 'selected' : '' }}>
                                                Tersedia</option>
                                            <option value="Dipinjam" {{ old('status') == 'Dipinjam' ? 'selected' : '' }}>
                                                Dipinjam</option>
                                            <option value="Dalam Perbaikan"
                                                {{ old('status') == 'Dalam Perbaikan' ? 'selected' : '' }}>Dalam Perbaikan
                                            </option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="user_id">Penanggung Jawab <span class="text-danger">*</span></label>
                                        <select name="user_id" id="user_id" class="form-control select2" required>
                                            <option value="">-- Pilih PJ --</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ auth()->id() == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="image">Gambar</label>
                                        <input type="file" name="image" class="form-control" id="image"
                                            onchange="previewImage()">

                                        <canvas id="preview_canvas"
                                            style="display: none; max-width: 100%; margin-top: 10px;"></canvas>
                                        <img id="preview_image" src="#" alt="Preview Logo"
                                            style="display: none; max-width: 100%; margin-top: 10px;">

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
                                                        var maxWidth = 300;
                                                        var scaleFactor = maxWidth / img.width;
                                                        var newHeight = img.height * scaleFactor;

                                                        previewCanvas.width = maxWidth;
                                                        previewCanvas.height = newHeight;

                                                        canvasContext.drawImage(img, 0, 0, maxWidth, newHeight);

                                                        previewCanvas.style.display = 'block';
                                                        previewImage.style.display = 'none';
                                                    };
                                                };

                                                if (file) {
                                                    reader.readAsDataURL(file);
                                                } else {
                                                    previewImage.src = '';
                                                    previewCanvas.style.display = 'none';
                                                }
                                            }
                                        </script>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                                        <button type="submit" class="btn btn-primary btn-sm mb-3"><i
                                                class="fa fa-save"></i> Simpan</button>
                                        <a class="btn btn-warning btn-sm mb-3" href="{{ route('assets.index') }}"><i
                                                class="fa fa-undo"></i> Kembali</a>
                                    </div>
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
    <!-- ---------------------------------------------- -->
    <script src="{{ asset('template/back') }}/dist/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="{{ asset('template/back') }}/dist/libs/select2/dist/js/select2.min.js"></script>
    <script src="{{ asset('template/back') }}/dist/js/forms/select2.init.js"></script>


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
@endpush
