@extends('layouts.app', ['title' => 'Tambah Kategori - Admin'])

@section('content')
<div class="container mt-4">

    <div class="card">
        <div class="card-header">
            <h3>Tambah Kategori</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label for="image">Gambar</label>
                    <input type="file" name="image" class="form-control">
                    @error('image')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="name">Nama Kategori</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Nama Kategori" required>
                    @error('name')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
