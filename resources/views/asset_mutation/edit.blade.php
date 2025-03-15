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
                                <li class="breadcrumb-item"><a class="text-muted text-decoration-none"
                                        href="{{ route('asset_mutations.index') }}">Halaman Mutasi Aset</a></li>
                                <li class="breadcrumb-item">{{ $subtitle }}</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <img src="{{ asset('template/back') }}/dist/images/breadcrumb/ChatBc.png" alt=""
                                class="img-fluid mb-n4">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="datatables">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <strong>Whoops!</strong> Ada beberapa masalah dengan data yang anda
                                        masukkan.<br><br>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST"
                                    action="{{ route('asset_mutations.update', $data_asset_mutations->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">




                                        <div class="form-group mb-3">
                                            <label for="mutation_date">Tanggal Mutasi <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" name="mutation_date" class="form-control"
                                                id="mutation_date" value="{{ $data_asset_mutations->mutation_date }}"
                                                required>
                                        </div>


                                        <div class="form-group mb-3">
                                            <label for="user_id">Penanggung Jawab <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control select2" name="user_id" id="user_id" required>
                                                <option value="">-- Pilih Penanggung Jawab --</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}"
                                                        {{ $data_asset_mutations->user_id == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="asset_id">Nama Aset <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="asset_id" id="asset_id" required>
                                                <option value="">-- Pilih Aset --</option>
                                                @foreach ($assets as $asset)
                                                    <option value="{{ $asset->id }}"
                                                        data-room-id="{{ $asset->room_id }}"
                                                        {{ $data_asset_mutations->asset_id == $asset->id ? 'selected' : '' }}>
                                                        {{ $asset->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="previous_room_id">Lokasi Lama <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control select2" name="previous_room_id"
                                                id="previous_room_id" required>
                                                <option value="">-- Pilih Lokasi Lama --</option>
                                                @foreach ($rooms as $room)
                                                    <option value="{{ $room->id }}"
                                                        {{ $data_asset_mutations->previous_room_id == $room->id ? 'selected' : '' }}>
                                                        {{ $room->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="new_room_id">Lokasi Baru <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="new_room_id" id="new_room_id"
                                                required>
                                                <option value="">-- Pilih Lokasi Baru --</option>
                                                @foreach ($rooms as $room)
                                                    <option value="{{ $room->id }}"
                                                        {{ $data_asset_mutations->new_room_id == $room->id ? 'selected' : '' }}>
                                                        {{ $room->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Script untuk update lokasi lama otomatis saat aset dipilih -->
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                // Ketika aset dipilih
                                                $('#asset_id').on('change', function() {
                                                    var selectedOption = $(this).find('option:selected');
                                                    var roomId = selectedOption.data('room-id');

                                                    if (roomId) {
                                                        // Set nilai previous_room_id sesuai dengan room_id aset
                                                        $('#previous_room_id').val(roomId).trigger('change');
                                                    } else {
                                                        $('#previous_room_id').val('').trigger('change');
                                                    }
                                                });

                                                // Jika ini adalah form edit dan aset sudah terpilih, kita tidak perlu
                                                // otomatis mengubah lokasi lama karena data sudah ada di database
                                            });
                                        </script>

                                        <div class="form-group mb-3">
                                            <label for="status">Status <span class="text-danger">*</span></label>
                                            <select name="status" id="status" class="form-control" required>
                                                <option value="">-Pilih Status-</option>
                                                <option value="Tersedia"
                                                    {{ $data_asset_mutations->status == 'Tersedia' ? 'selected' : '' }}>
                                                    Tersedia
                                                </option>
                                                <option value="Dipinjam"
                                                    {{ $data_asset_mutations->status == 'Dipinjam' ? 'selected' : '' }}>
                                                    Dipinjam
                                                </option>
                                                <option value="Dalam Perbaikan"
                                                    {{ $data_asset_mutations->status == 'Dalam Perbaikan' ? 'selected' : '' }}>
                                                    Dalam
                                                    Perbaikan</option>
                                            </select>
                                        </div>


                                        <div class="form-group mb-3">
                                            <label for="description">Deskripsi</label>
                                            <textarea cols="80" id="description" name="description" rows="10">{{ $data_asset_mutations->description }}</textarea>
                                        </div>




                                        <div class="form-group mb-3">
                                            <label for="image">Gambar <span class="text-danger">*</span></label>
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


                                        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                                            <button type="submit" class="btn btn-primary btn-sm mb-3"><i
                                                    class="fa fa-save"></i> Simpan</button>
                                            <a class="btn btn-warning btn-sm mb-3"
                                                href="{{ route('asset_mutations.index') }}"><i class="fa fa-undo"></i>
                                                Kembali</a>
                                        </div>
                                    </div>






                                </form>


                            </div>
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
