@extends('layouts.app', ['title' => 'Tambah Campaign - Admin'])

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3>Tambah Campaign</h3>
        </div>
        <div class="card-body">
            <form id="create-form" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label for="image">Gambar</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label for="title">Judul Campaign</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="Judul Campaign">
                </div>

                <div class="form-group mb-3">
                    <label for="category_id">Kategori</label>
                    <select name="category_id" class="form-control">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="description">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="5">{{ old('description') }}</textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="target_donation">Target Donasi</label>
                    <input type="number" name="target_donation" class="form-control" value="{{ old('target_donation') }}" placeholder="Target Donasi, Ex: 10000000">
                </div>

                <div class="form-group mb-3">
                    <label for="max_date">Tanggal Berakhir</label>
                    <input type="date" name="max_date" class="form-control" value="{{ old('max_date') }}">
                </div>

                <div class="form-group">
                    <button id="save-btn" type="button" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.campaign.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        $("#save-btn").prop("disabled", false);

        $("#save-btn").click(function (e) {
            e.preventDefault();

            let form = $("#create-form")[0];
            let formData = new FormData(form);
            formData.append('_token', '{{ csrf_token() }}');
            $("#save-btn").prop("disabled", true).text("Menyimpan...");
            $.ajax({
                url: "{{ route('admin.campaign.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    Swal.fire({
                        title: "Berhasil!",
                        text: "Campaign berhasil ditambahkan.",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = "{{ route('admin.campaign.index') }}";
                    });
                },
                error: function (xhr) {
                    $("#save-btn").prop("disabled", false).text("Simpan");

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
                    } else if (xhr.status === 419) {
                        Swal.fire({
                            title: "Session Habis!",
                            text: "Silakan refresh halaman dan coba lagi.",
                            icon: "error",
                            confirmButtonText: "OK"
                        }).then(() => {
                            location.reload();
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
