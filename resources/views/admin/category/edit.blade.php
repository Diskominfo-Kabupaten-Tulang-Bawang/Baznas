@extends('layouts.app', ['title' => 'Edit Kategori - Admin'])

@section('content')
<div class="container">

    <div class="card">
        <div class="card-header">
            <h3>Edit Kategori</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="image">Gambar</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label for="name">Nama Kategori</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" placeholder="Nama Kategori">
                    @error('name')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary mr-2">Update</button>
                    <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
