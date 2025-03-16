@extends('layouts.app', ['title' => 'Edit Kategori - Admin'])

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Edit Kategori</h3>
        </div>
        <div class="card-body">
            <form id="update-form">
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
                    <button id="update-btn" type="button" class="btn btn-primary mr-2">Update</button>
                    <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Tambahkan jQuery dan SweetAlert2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        $("#update-btn").click(function (e) {
            e.preventDefault();

            let form = $("#update-form")[0];
            let formData = new FormData(form);
            formData.append("_method", "PUT");
            $.ajax({
                url: "{{ route('admin.category.update', $category->id) }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    Swal.fire({
                        title: "Berhasil!",
                        text: "Data berhasil diperbarui.",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = "{{ route('admin.category.index') }}";
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
