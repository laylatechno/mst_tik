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
                                        href="{{ route('letters.index') }}">Halaman Fleet</a></li>
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
                                    <!-- Nomor Surat -->
                                    <div class="col-md-12 mb-3">
                                        <div class="form-item">
                                            <strong>Nomor Surat:</strong>
                                            {{ $data_letters->letter_number }}
                                        </div>
                                    </div>

                                    <!-- Kategori Surat (incoming/outgoing) -->
                                    <div class="col-md-12 mb-3">
                                        <div class="form-item">
                                            <strong>Kategori Surat:</strong>
                                            @if ($data_letters->category === 'incoming')
                                                <span class="badge bg-success">Surat Masuk</span>
                                            @elseif ($data_letters->category === 'outgoing')
                                                <span class="badge bg-warning text-dark">Surat Keluar</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $data_letters->category }}</span>
                                            @endif
                                        </div>
                                    </div>


                                    <!-- Jenis Surat -->
                                    <div class="col-md-12 mb-3">
                                        <div class="form-item">
                                            <strong>Jenis Surat:</strong>
                                            {{ $data_letters->type }}
                                        </div>
                                    </div>

                                    <!-- Tanggal Surat -->
                                    <div class="col-md-12 mb-3">
                                        <div class="form-item">
                                            <strong>Tanggal Surat:</strong>
                                            {{ \Carbon\Carbon::parse($data_letters->date)->format('d-m-Y') }}
                                        </div>
                                    </div>

                                    <!-- Pengirim -->
                                    <div class="col-md-12 mb-3">
                                        <div class="form-item">
                                            <strong>Pengirim:</strong>
                                            {{ $data_letters->sender ? $data_letters->sender->name : '-' }}
                                        </div>
                                    </div>

                                    <!-- Penerima -->
                                    <div class="col-md-12 mb-3">
                                        <div class="form-item">
                                            <strong>Penerima:</strong>
                                            {{ $data_letters->recipient ? $data_letters->recipient->name : '-' }}
                                        </div>
                                    </div>

                                    <!-- Perihal -->
                                    <div class="col-md-12 mb-3">
                                        <div class="form-item">
                                            <strong>Perihal:</strong>
                                            {{ $data_letters->subject }}
                                        </div>
                                    </div>

                                    <!-- Isi Surat -->
                                    <div class="col-md-12 mb-3">
                                        <div class="form-item">
                                            <strong>Isi Surat:</strong>
                                            {!! $data_letters->content ?? '-' !!}
                                        </div>
                                    </div>

                                    <!-- Lampiran -->
                                    <div class="col-md-12 mb-3">
                                        <div class="form-item">
                                            <strong>Lampiran:</strong>
                                            <br>
                                            @if ($data_letters->attachment)
                                                @php
                                                    $ext = strtolower(
                                                        pathinfo($data_letters->attachment, PATHINFO_EXTENSION),
                                                    );
                                                @endphp
                                                @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif']))
                                                    <img src="{{ asset('upload/letters/' . $data_letters->attachment) }}"
                                                        alt="Lampiran" class="img-thumbnail" style="max-width:200px;">
                                                @else
                                                    <a href="{{ asset('upload/letters/' . $data_letters->attachment) }}"
                                                        target="_blank">
                                                        {{ $data_letters->attachment }}
                                                    </a>
                                                @endif
                                            @else
                                                <p>Tidak ada lampiran</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Status Surat -->
                                    <div class="col-md-12 mb-3">
                                        <div class="form-item">
                                            <strong>Status:</strong>
                                            @switch($data_letters->status)
                                                @case('pending')
                                                    <span class="badge bg-secondary">Pending</span>
                                                @break

                                                @case('processed')
                                                    <span class="badge bg-info">Processed</span>
                                                @break

                                                @case('completed')
                                                    <span class="badge bg-success">Completed</span>
                                                @break

                                                @case('draft')
                                                    <span class="badge bg-warning text-dark">Draft</span>
                                                @break

                                                @case('sent')
                                                    <span class="badge bg-primary">Sent</span>
                                                @break

                                                @default
                                                    <span class="badge bg-secondary">{{ $data_letters->status }}</span>
                                            @endswitch
                                        </div>
                                    </div>

                                    <!-- Dibuat oleh (User yang membuat surat) -->
                                    <div class="col-md-12 mb-3">
                                        <div class="form-item">
                                            <strong>Dibuat oleh:</strong>
                                            {{ $data_letters->user ? $data_letters->user->name : '-' }}
                                        </div>
                                    </div>
                                </div>



                                <a class="btn btn-warning mb-2 mt-3" href="{{ route('letters.index') }}"><i
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
