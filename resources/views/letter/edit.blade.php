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
                                        href="{{ route('customers.index') }}">Halaman Blog</a></li>
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

                                <form method="POST" action="{{ route('letters.update', $data_letters->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">

                                          {{-- Jenis Surat --}}
                                        <div class="form-group mb-3">
                                            <label for="type">Jenis Surat <span class="text-danger">*</span></label>
                                            <select name="type" id="type" class="form-control" required>
                                                <option value="">-- Pilih Jenis Surat --</option>
                                                <option value="Undangan"
                                                    {{ old('type', $data_letters->type) == 'Undangan' ? 'selected' : '' }}>
                                                    Undangan</option>
                                                <option value="Undangan Pemerintahan"
                                                    {{ old('type', $data_letters->type) == 'Undangan Pemerintahan' ? 'selected' : '' }}>
                                                    Undangan Pemerintahan</option>
                                                <option value="Undangan Komunitas"
                                                    {{ old('type', $data_letters->type) == 'Undangan Komunitas' ? 'selected' : '' }}>
                                                    Undangan Komunitas</option>
                                                <option value="Peminjaman barang"
                                                    {{ old('type', $data_letters->type) == 'Peminjaman barang' ? 'selected' : '' }}>
                                                    Peminjaman barang</option>
                                                <option value="Peminjaman Tempat"
                                                    {{ old('type', $data_letters->type) == 'Peminjaman Tempat' ? 'selected' : '' }}>
                                                    Peminjaman Tempat</option>
                                                <option value="Pemberitahuan/informasi"
                                                    {{ old('type', $data_letters->type) == 'Pemberitahuan/informasi' ? 'selected' : '' }}>
                                                    Pemberitahuan/informasi</option>
                                                <option value="Surat Keterangan"
                                                    {{ old('type', $data_letters->type) == 'Surat Keterangan' ? 'selected' : '' }}>
                                                    Surat Keterangan</option>
                                                <option value="Surat Pengajuan"
                                                    {{ old('type', $data_letters->type) == 'Surat Pengajuan' ? 'selected' : '' }}>
                                                    Surat Pengajuan</option>
                                                <option value="Surat Permohonan"
                                                    {{ old('type', $data_letters->type) == 'Surat Permohonan' ? 'selected' : '' }}>
                                                    Surat Permohonan</option>
                                                <option value="Surat Kuasa"
                                                    {{ old('type', $data_letters->type) == 'Surat Kuasa' ? 'selected' : '' }}>
                                                    Surat Kuasa</option>
                                            </select>
                                        </div>


                                        {{-- Nomor Surat --}}
                                        <div class="form-group mb-3">
                                            <label for="letter_number">Nomor Surat <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="letter_number" class="form-control"
                                                id="letter_number"
                                                value="{{ old('letter_number', $data_letters->letter_number) }}" required>
                                        </div>

                                        {{-- Kategori Surat --}}
                                        <div class="form-group mb-3">
                                            <label for="category">Kategori Surat <span class="text-danger">*</span></label>
                                            <select name="category" id="category" class="form-control" required>
                                                <option value="">-- Pilih Kategori Surat --</option>
                                                <option value="incoming"
                                                    {{ old('category', $data_letters->category) == 'incoming' ? 'selected' : '' }}>
                                                    Surat Masuk
                                                </option>
                                                <option value="outgoing"
                                                    {{ old('category', $data_letters->category) == 'outgoing' ? 'selected' : '' }}>
                                                    Surat Keluar
                                                </option>
                                            </select>
                                        </div>

                                      

                                        {{-- Tanggal Surat --}}
                                        <div class="form-group mb-3">
                                            <label for="date">Tanggal Surat <span class="text-danger">*</span></label>
                                            <input type="date" name="date" class="form-control" id="date"
                                                value="{{ old('date', $data_letters->date) }}" required>
                                        </div>

                                      

                                        <div class="form-group mb-3">
                                            <label for="sender_id">Pengirim  </label>
                                            <select name="sender_id" id="sender_id" class="form-control select2">
                                                <option value="">-- Pilih Pengirim --</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}"
                                                        {{ $data_letters->sender_id == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                         <div class="form-group mb-3">
                                            <label for="recipient_id">Penerima </label>
                                            <select name="recipient_id" id="recipient_id" class="form-control select2">
                                                <option value="">-- Pilih Penerima --</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}"
                                                        {{ $data_letters->recipient_id == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Perihal --}}
                                        <div class="form-group mb-3">
                                            <label for="subject">Perihal <span class="text-danger">*</span></label>
                                            <input type="text" name="subject" class="form-control" id="subject"
                                                value="{{ old('subject', $data_letters->subject) }}" required>
                                        </div>

                                        {{-- Isi Surat --}}
                                        <div class="form-group mb-3">
                                            <label for="content">Isi Surat</label>
                                            <textarea name="content" id="content" rows="5" class="form-control">{{ old('content', $data_letters->content) }}</textarea>
                                        </div>

                                        {{-- Status Surat --}}
                                        <div class="form-group mb-3">
                                            <label for="status">Status <span class="text-danger">*</span></label>
                                            <select name="status" id="status" class="form-control" required>
                                                <option value="">-- Pilih Status --</option>
                                                <option value="pending"
                                                    {{ old('status', $data_letters->status) == 'pending' ? 'selected' : '' }}>
                                                    Pending</option>
                                                <option value="processed"
                                                    {{ old('status', $data_letters->status) == 'processed' ? 'selected' : '' }}>
                                                    Processed</option>
                                                <option value="completed"
                                                    {{ old('status', $data_letters->status) == 'completed' ? 'selected' : '' }}>
                                                    Completed</option>
                                                <option value="draft"
                                                    {{ old('status', $data_letters->status) == 'draft' ? 'selected' : '' }}>
                                                    Draft</option>
                                                <option value="sent"
                                                    {{ old('status', $data_letters->status) == 'sent' ? 'selected' : '' }}>
                                                    Sent</option>
                                            </select>
                                        </div>

                                        {{-- File Lampiran --}}
                                        <div class="form-group mb-3">
                                            <label for="attachment">Lampiran</label>
                                            <input type="file" name="attachment" class="form-control" id="attachment"
                                                onchange="previewFile()">
                                            <div id="file_preview" class="mt-2" style="display: none;">
                                                <p><strong>File Terupload:</strong> <span id="file_name"></span></p>
                                            </div>
                                            <script>
                                                function previewFile() {
                                                    const file = document.getElementById('attachment').files[0];
                                                    if (file) {
                                                        document.getElementById('file_name').textContent = file.name;
                                                        document.getElementById('file_preview').style.display = 'block';
                                                    } else {
                                                        document.getElementById('file_preview').style.display = 'none';
                                                    }
                                                }
                                            </script>
                                        </div>

                                        {{-- Tombol Aksi --}}
                                        <div class="col-md-12 mt-3">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                                                Simpan</button>
                                            <a href="{{ route('letters.index') }}" class="btn btn-warning"><i
                                                    class="fa fa-undo"></i> Kembali</a>
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
        CKEDITOR.replace("content", {
            height: 150,
        });
    </script>
@endpush
