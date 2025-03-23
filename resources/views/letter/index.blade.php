@extends('layouts.app')
@section('title', $title)
@section('subtitle', $subtitle)

@push('css')
    <link rel="stylesheet" href="{{ asset('template/back/dist/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
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
                                <li class="breadcrumb-item" aria-current="page">{{ $subtitle }}</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3 text-center mb-n5">
                        <img src="{{ asset('template/back/dist/images/breadcrumb/ChatBc.png') }}" alt=""
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
                            <div class="table-responsive">
                                <div class="row">
                                    <div class="col-lg-12 margin-tb">
                                        @can('asset-create')
                                            <div class="pull-right">
                                                <a class="btn btn-success mb-2" href="{{ route('letters.create') }}"><i
                                                        class="fa fa-plus"></i> Tambah Data</a>
                                            </div>
                                        @endcan
                                    </div>
                                </div>

                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                <table id="scroll_hor" class="table border table-striped table-bordered display nowrap"
                                    style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th>Status</th>
                                            <th>Tanggal Surat</th>
                                            <th>Nomor Surat</th>
                                            <th>Kategori</th>
                                            <th>Jenis Surat</th>
                                            <th>Pengirim/Penerima</th>
                                            <th>Perihal</th>
                                            <th>Lampiran</th>
                                            <th width="280px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data_letters as $letter)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    @if ($letter->status === 'pending')
                                                        <span class="badge bg-secondary">Pending</span>
                                                    @elseif ($letter->status === 'processed')
                                                        <span class="badge bg-info">Processed</span>
                                                    @elseif ($letter->status === 'completed')
                                                        <span class="badge bg-success">Completed</span>
                                                    @elseif ($letter->status === 'draft')
                                                        <span class="badge bg-warning text-dark">Draft</span>
                                                    @elseif ($letter->status === 'sent')
                                                        <span class="badge bg-primary">Sent</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ $letter->status }}</span>
                                                    @endif
                                                </td>

                                                <td>{{ $letter->date ? date('d-m-Y', strtotime($letter->date)) : '-' }}</td>
                                                <td>{{ $letter->letter_number }}</td>
                                                <td>
                                                    @if ($letter->category === 'incoming')
                                                        <span class="badge bg-success">Masuk</span>
                                                    @elseif ($letter->category === 'outgoing')
                                                        <span class="badge bg-warning text-dark">Keluar</span>
                                                    @endif
                                                </td>
                                                <td>{{ $letter->type }}</td>
                                                <td>
                                                    {{ $letter->sender?->name ?? '-' }} /
                                                    {{ $letter->recipient?->name ?? '-' }}
                                                </td>

                                                <td>{{ $letter->subject }}</td>
                                                <td>
                                                    @if ($letter->attachment)
                                                        <a href="{{ asset('upload/letters/' . $letter->attachment) }}"
                                                            target="_blank">
                                                            @if (in_array(pathinfo($letter->attachment, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                                                <img style="max-width:50px; max-height:50px"
                                                                    src="{{ asset('upload/letters/' . $letter->attachment) }}"
                                                                    alt="Lampiran">
                                                            @else
                                                                📎 {{ $letter->attachment }}
                                                            @endif
                                                        </a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                <td>
                                                    <a class="btn btn-warning btn-sm"
                                                        href="{{ route('letters.show', $letter->id) }}">
                                                        <i class="fa fa-eye"></i> Show
                                                    </a>
                                                    @can('letter-edit')
                                                        <a class="btn btn-primary btn-sm"
                                                            href="{{ route('letters.edit', $letter->id) }}">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>
                                                    @endcan
                                                    @can('letter-delete')
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            onclick="confirmDelete({{ $letter->id }})">
                                                            <i class="fa fa-trash"></i> Delete
                                                        </button>
                                                        <form id="delete-form-{{ $letter->id }}" method="POST"
                                                            action="{{ route('letters.destroy', $letter->id) }}"
                                                            style="display:none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('script')
    <script>
        function confirmDelete(roleId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + roleId).submit();
                }
            });
        }
    </script>

    <script src="{{ asset('template/back/dist/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/back/dist/js/datatable/datatable-basic.init.js') }}"></script>
@endpush
