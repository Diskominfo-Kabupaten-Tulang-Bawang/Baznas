@extends('layouts.app', ['title' => 'Dashboard - Admin'])

@section('content')
<div class="container mt-4">

    <div class="card">
        <div class="card-header">
            <h3>Edit Slider</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.slider.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="link">Link</label>
                    <input type="text" name="link" class="form-control" value="{{ $slider->link }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="image">Image</label>
                    <input type="file" name="image" class="form-control">
                    <small class="form-text text-muted">Biarkan kosong jika Anda tidak ingin mengubah gambar.</small>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.slider.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
