@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('template/back/dist/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb Section -->
    <div class="card bg-light-info shadow-none position-relative overflow-hidden" style="border: solid 0.5px #ccc;">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">{{ $title }}</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-muted text-decoration-none" href="/">Beranda</a></li>
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

    <!-- DataTables Section -->
    <section class="datatables">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <!-- Button Tambah Data -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                @can('user-create')
                                <a class="btn btn-success mb-2" href="{{ route('users.create') }}">
                                    <i class="fa fa-plus"></i> Tambah Data
                                </a>
                                @endcan
                            </div>

                            <!-- Alert Success -->
                            @if(session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                            @endif

                            <!-- Data Table -->
                            <table id="scroll_hor" class="table border table-striped table-bordered display nowrap" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Roles</th>
                                        <th>Gambar</th>
                                        <th>Banner</th>
                                        <th width="280px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data_user as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @foreach($user->getRoleNames() as $role)
                                            <label class="badge bg-success">{{ $role }}</label>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="/upload/users/{{ $user->image }}" target="_blank">
                                                <img style="max-width:50px; max-height:50px" src="/upload/users/{{ $user->image }}" alt="">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="/upload/users/{{ $user->banner }}" target="_blank">
                                                <img style="max-width:50px; max-height:50px" src="/upload/users/{{ $user->banner }}" alt="">
                                            </a>
                                        </td>
                                        <td>
                                            <!-- Show Button -->
                                            <a class="btn btn-warning btn-sm" href="{{ route('users.show', $user->id) }}">
                                                <i class="fa fa-eye"></i> Show
                                            </a>

                                            <!-- Edit Button -->
                                            @can('user-edit')
                                            <a class="btn btn-primary btn-sm" href="{{ route('users.edit', $user->id) }}">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            @endcan
                                            <!-- Link Button -->
                                            <a class="btn btn-info btn-sm" href="{{ route('users.links', $user->id) }}">
                                                <i class="fa fa-link"></i> Links
                                            </a>
                                            <!-- Delete Button -->
                                            @can('user-delete')
                                            @if ($user->id !== auth()->id())
                                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $user->id }})">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                            <form id="delete-form-{{ $user->id }}" method="POST" action="{{ route('users.destroy', $user->id) }}" style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            @endif
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

<script src="{{ asset('template/back') }}/dist/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('template/back') }}/dist/js/datatable/datatable-basic.init.js"></script>

<script>
    function confirmDelete(userId) {
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
                document.getElementById('delete-form-' + userId).submit();
            }
        });
    }
</script>
@endpush