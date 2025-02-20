@extends('layouts.app')
@push('css')
<link rel="stylesheet" href="{{ asset('template/back') }}/dist/libs/select2/dist/css/select2.min.css">
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
                                <a class="text-muted text-decoration-none" href="{{ route('cash.index') }}">Halaman Kas</a>
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

                        <form method="POST" action="{{ route('cash.store') }}">
                            @csrf
                            <div class="row">
                                @can('user-access')
                                <div class="form-group mb-3">
                                    <label for="user_id">Pengguna</label>
                                    <span class="text-danger">*</span>
                                    <select name="user_id" id="user_id" class="form-control select2" required>
                                        <option value="">-- Pilih Pengguna --</option>
                                        @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ auth()->id() == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                @endcan
                                <div class="form-group mb-3">
                                    <label for="name">Nama Kas</label>
                                    <input type="text" name="name" class="form-control" id="name" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="amount">Saldo</label>
                                    <input type="text" name="amount" class="form-control" id="amount" oninput="formatPrice(this)" value="0">
                                </div>
                                <script>
                                    function formatPrice(input) {
                                        let value = input.value.replace(/[^0-9.]/g, '');
                                        let parts = value.split('.');
                                        if (parts.length > 2) parts = [parts[0], parts[1]];
                                        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                                        input.value = parts.join('.');
                                    }
                                </script>
                                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                                    <button type="submit" class="btn btn-primary btn-sm mb-3"><i class="fa fa-save"></i> Simpan</button>
                                    <a class="btn btn-warning btn-sm mb-3" href="{{ route('cash.index') }}"><i class="fa fa-undo"></i> Kembali</a>
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

<script src="{{ asset('template/back') }}/dist/libs/select2/dist/js/select2.full.min.js"></script>
<script src="{{ asset('template/back') }}/dist/libs/select2/dist/js/select2.min.js"></script>
<script src="{{ asset('template/back') }}/dist/js/forms/select2.init.js"></script>

<script>
    
    $(document).ready(function() {
        $('#user_id').select2();
      
    });
</script>
@endpush