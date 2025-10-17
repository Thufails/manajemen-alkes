@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="form-group mb-2">
                <a href="{{url('master-items')}}" class="btn btn-secondary">Kembali ke Daftar Item</a>
            </div>
            <div class="mb-3 d-flex gap-2">
                <a href="{{ url('kategori/form/new') }}" class="btn btn-primary">+ Tambah Kategori</a>
            </div>

            <div class="card mb-3">
                <div class="card-header">Filter</div>
                <div class="card-body">
                    @include('kategori.index.filter')
                </div>
            </div>

            <div class="card">
                <div class="card-header">Daftar Kategori</div>
                <div class="card-body">
                    @include('kategori.index.table')
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('js')
    @include('kategori.index.js')
@endsection
