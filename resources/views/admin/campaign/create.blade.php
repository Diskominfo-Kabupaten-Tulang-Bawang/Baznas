@extends('layouts.app', ['title' => 'Tambah Campaign - Admin'])

@section('content')
<div class="container mt-4">

    <div class="card">
        <div class="card-header">
            <h3>Tambah Campaign</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.campaign.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label for="image">Gambar</label>
                    <input type="file" name="image" class="form-control">
                    @error('image')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="title">Judul Campaign</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="Judul Campaign">
                    @error('title')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="category_id">Kategori</label>
                    <select name="category_id" class="form-control">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="description">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="5">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="target_donation">Target Donasi</label>
                    <input type="number" name="target_donation" class="form-control" value="{{ old('target_donation') }}" placeholder="Target Donasi, Ex: 10000000">
                    @error('target_donation')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="max_date">Tanggal Berakhir</label>
                    <input type="date" name="max_date" class="form-control" value="{{ old('max_date') }}">
                    @error('max_date')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.campaign.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
