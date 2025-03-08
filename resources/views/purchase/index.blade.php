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

        <div class="card-body">
            <!-- Section Tutorial -->
            <div class="card mb-1" id="tutorial-section">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0" style="color: white;">Informasi Halaman Pembelian</h5>
                    <!-- Tombol Close -->
                    <button type="button" class="btn-close btn-close-white" aria-label="Close"
                        onclick="closeTutorial()"></button>
                </div>
                <div class="card-body">
                    <ol>
                        <li>
                            Pilih <b>Tambah Data</b> untuk mengisi penjualan baru.
                        </li>
                        <li>
                            Untuk Pembelian yang <b>statusnya Lunas</b> maka tidak bisa diedit dan status selain itu bisa
                            untuk diedit kembali
                        </li>
                        <li>
                            Setiap transaksi yang <b>dihapus/delete</b> maka dia akan menambah kembali amount/saldo dari Kas
                            dan mengurangi kembali stok dari produk terkait
                        </li>
                    </ol>

                </div>
            </div>
            <!-- End of Section Tutorial -->
        </div>

        <div class="card">
            <button class="btn btn-primary" id="showTutorialBtn" onclick="toggleTutorial()"><i class="fa fa-eye"></i> Lihat
                Informasi</button>
        </div>

        <section class="datatables">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="row">
                                    <div class="col-lg-12 margin-tb">
                                        @can('purchase-create')
                                            <div class="pull-right">
                                                <a class="btn btn-success mb-2" href="{{ route('purchases.create') }}"><i
                                                        class="fa fa-plus"></i> Tambah Data</a>
                                            </div>
                                        @endcan
                                    </div>
                                </div>

                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif


                                <table id="scroll_hor" class="table border table-striped table-bordered display nowrap"
                                    style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            @can('user-access')
                                                <th>Nama User</th>
                                            @endcan
                                            <th>No Pembelian</th>
                                            <th>Tanggal Pembelian</th>
                                            <th>Supplier</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Gambar</th>
                                            <th width="280px">Action</th>
                                        </tr>
                                    </thead>
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
    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('#scroll_hor')) {
            $('#scroll_hor').DataTable().destroy(); // Hancurkan DataTable lama jika sudah ada
        }

        $('#scroll_hor').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true, // Mengaktifkan scroll horizontal
            ajax: "{{ route('purchases.index') }}",
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                @can('user-access')
                {
                    data: 'user_name',
                    name: 'user.name'
                },
                @endcan
                {
                    data: 'no_purchase',
                    name: 'no_purchase'
                },
                {
                    data: 'purchase_date',
                    name: 'purchase_date'
                },
                {
                    data: 'supplier_name',
                    name: 'supplier.name'
                },
                {
                    data: 'total_cost',
                    name: 'total_cost'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'image',
                    name: 'image',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "→",
                    previous: "←"
                }
            }
        });
    });
</script>




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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Ambil status tutorial dari server
            fetch('/tutorial-status')
                .then(response => response.json())
                .then(data => {
                    if (data.tutorialClosed) {
                        // Jika tutorial sudah ditutup, sembunyikan card dan tampilkan tombol "Munculkan Informasi"
                        document.getElementById('tutorial-section').style.display = 'none';
                        document.getElementById('showTutorialBtn').style.display = 'block';
                    } else {
                        // Jika tutorial masih terbuka, tampilkan card tutorial
                        document.getElementById('tutorial-section').style.display = 'block';
                        document.getElementById('showTutorialBtn').style.display = 'none';
                    }
                });
        });

        // Fungsi untuk menutup tutorial dan menyimpan statusnya
        function closeTutorial() {
            // Menyimpan status tutorial ke file JSON
            fetch('/set-tutorial-status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        tutorialClosed: true
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Sembunyikan card tutorial dan tampilkan tombol "Munculkan Informasi"
                    document.getElementById('tutorial-section').style.display = 'none';
                    document.getElementById('showTutorialBtn').style.display = 'block';
                });
        }

        // Fungsi untuk menampilkan tutorial kembali
        function toggleTutorial() {
            // Menyimpan status tutorial ke file JSON
            fetch('/set-tutorial-status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        tutorialClosed: false
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Tampilkan card tutorial dan sembunyikan tombol
                    document.getElementById('tutorial-section').style.display = 'block';
                    document.getElementById('showTutorialBtn').style.display = 'none';
                });
        }
    </script>
@endpush
