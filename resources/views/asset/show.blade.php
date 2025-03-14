@extends('layouts.app')

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
                                <li class="breadcrumb-item" aria-current="page"><a class="text-muted text-decoration-none"
                                        href="{{ route('assets.index') }}">Halaman Fleet</a></li>
                                <li class="breadcrumb-item" aria-current="page">{{ $subtitle }}</li>
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

                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                        <div class="form-item">
                                            <strong>Nama Aset:</strong>
                                            {{ $data_assets->name }}
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                        <div class="form-item">
                                            <strong>Kategori:</strong>
                                            {{ $data_assets->category->name ?? '-' }}
                                        </div>

                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                        <div class="form-item">
                                            <strong>Tanggal Beli:</strong>
                                            {{ $data_assets->purchase_date }}
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                        <div class="form-item">
                                            <strong>Kode:</strong>
                                            {{ $data_assets->code }}
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                        <div class="form-item">
                                            <strong>Harga:</strong>
                                            Rp {{ number_format($data_assets->value, 0, ',', '.') }}
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                        <div class="form-item">
                                            <strong>Kondisi:</strong>
                                            {{ $data_assets->condition }}
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                        <div class="form-item">
                                            <strong>Lokasi Simpan:</strong>
                                            {{ $data_assets->room->name }}
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                        <div class="form-item">
                                            <strong>Deskripsi:</strong>
                                            {!! $data_assets->description ?? '-' !!}
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                        <div class="form-item">
                                            <strong>Status:</strong>
                                            @if ($data_assets->status == 'Tersedia')
                                                <span class="badge bg-success">{{ $data_assets->status }}</span>
                                            @elseif ($data_assets->status == 'Dipinjam')
                                                <span class="badge bg-warning text-dark">{{ $data_assets->status }}</span>
                                            @elseif ($data_assets->status == 'Dalam Perbaikan')
                                                <span class="badge bg-danger">{{ $data_assets->status }}</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $data_assets->status }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                        <div class="form-item">
                                            <strong>Penanggung Jawab:</strong>
                                            {{ $data_assets->user->name ?? '-' }}
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                        <div class="form-item">
                                            <strong>Gambar:</strong>
                                            <br>
                                            @if ($data_assets->image)
                                                <img src="{{ asset('upload/assets/' . $data_assets->image) }}"
                                                    alt="Asset Image" class="img-thumbnail" style="max-width: 200px;">
                                            @else
                                                <p class="form-control-plaintext">Tidak ada gambar</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>



                                <a class="btn btn-warning mb-2 mt-3" href="{{ route('assets.index') }}"><i
                                        class="fa fa-undo"></i> Kembali</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection

@push('script')
@endpush
