@extends('layouts.app', ['title' => 'Edit Program - Admin'])

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Edit Program</h3>
        </div>
        <div class="card-body">
            <form id="edit-form" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="image">Gambar</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label for="title">Judul Program</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $campaign->title) }}" placeholder="Judul Program">
                    @error('title')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="category_id">Kategori</label>
                    <select name="category_id" class="form-control">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @if($campaign->category_id == $category->id) selected @endif>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="description">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="5">{{ old('description', $campaign->description) }}</textarea>
                    @error('description')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="target_donation">Target Donasi</label>
                    <input type="number" name="target_donation" class="form-control" value="{{ old('target_donation', $campaign->target_donation) }}" placeholder="Target Donasi, Ex: 10000000">
                    @error('target_donation')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="max_date">Tanggal Berakhir</label>
                    <input type="date" name="max_date" class="form-control" value="{{ old('max_date', $campaign->max_date) }}">
                    @error('max_date')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button id="update-btn" type="button" class="btn btn-primary mr-2">Update</button>
                    <a href="{{ route('admin.campaign.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Tambahkan jQuery dan SweetAlert2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- TinyMCE -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.7.0/tinymce.min.js"></script>
<script>
    // tinymce.init({ selector:'textarea' });

    $(document).ready(function () {
        $("#update-btn").click(function (e) {
            e.preventDefault();

            let form = $("#edit-form")[0];
            let formData = new FormData(form);

            $.ajax({
                url: "{{ route('admin.campaign.update', $campaign->id) }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    Swal.fire({
                        title: "Berhasil!",
                        text: "Campaign berhasil diperbarui.",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = "{{ route('admin.campaign.index') }}";
                    });
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = "";

                        $.each(errors, function (key, value) {
                            errorMessage += value[0] + "<br>";
                        });

                        Swal.fire({
                            title: "Validasi Gagal!",
                            html: errorMessage,
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                    } else {
                        Swal.fire({
                            title: "Gagal!",
                            text: "Terjadi kesalahan pada server.",
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                    }
                }
            });
        });
    });
</script>

@endsection
