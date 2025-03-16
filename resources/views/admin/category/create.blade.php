@extends('layouts.app', ['title' => 'Tambah Kategori - Admin'])

@section('content')
<div class="container mt-4">

    <div class="card">
        <div class="card-header">
            <h3>Tambah Kategori</h3>
        </div>
        <div class="card-body">
            <form id="create-form" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <input type="file" name="image" class="form-control">
                    <label for="image">Gambar</label>
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
                    <button id="create-btn" type="button" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">Batal</a>
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
        $("#create-btn").click(function (e) {
            e.preventDefault();

            let form = $("#create-form")[0];
            let formData = new FormData(form);

            $.ajax({
                url: "{{ route('admin.category.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    Swal.fire({
                        title: "Berhasil!",
                        text: "Kategori berhasil ditambahkan.",
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
