@extends('layouts.app', ['title' => 'Tambah Campaign - Admin'])

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3>Tambah Campaign</h3>
        </div>
        <div class="card-body">
            <form id="create-form" enctype="multipart/form-data" novalidate>
                @csrf

                <div class="form-group mb-3">
                    <label for="image">Gambar</label>
                    <input type="file" name="image" class="form-control" required>
                    <div class="invalid-feedback">Gambar wajib diunggah.</div>
                </div>

                <div class="form-group mb-3">
                    <label for="title">Judul Campaign</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="Judul Campaign" required>
                    <div class="invalid-feedback">Judul campaign wajib diisi.</div>
                </div>

                <div class="form-group mb-3">
                    <label for="category_id">Kategori</label>
                    <select name="category_id" class="form-control" required>
                        <option value="" disabled selected>Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Kategori wajib dipilih.</div>
                </div>

                <div class="form-group mb-3">
                    <label for="description">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="5" required>{{ old('description') }}</textarea>
                    <div class="invalid-feedback">Deskripsi wajib diisi.</div>
                </div>

                <div class="form-group mb-3">
                    <label for="target_donation">Target Donasi</label>
                    <input type="number" name="target_donation" class="form-control" value="{{ old('target_donation') }}" placeholder="Target Donasi, Ex: 10000000" required>
                    <div class="invalid-feedback">Target donasi wajib diisi dan harus berupa angka.</div>
                </div>

                <div class="form-group mb-3">
                    <label for="max_date">Tanggal Berakhir</label>
                    <input type="date" name="max_date" class="form-control" value="{{ old('max_date') }}" required>
                    <div class="invalid-feedback">Tanggal berakhir wajib diisi.</div>
                </div>

                <div class="form-group">
                    <button id="save-btn" type="submit" class="btn btn-primary">Simpan</button>
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
        $("#create-form").on("submit", function (e) {
            e.preventDefault();
            let form = $(this)[0];
            if (!form.checkValidity()) {
                e.stopPropagation();
                form.classList.add('was-validated');
                Swal.fire({
                    title: "Validasi Gagal!",
                    text: "Harap isi semua bidang yang wajib.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
                return;
            }
            let formData = new FormData(form);
            $("#save-btn").prop("disabled", true).text("Menyimpan...");
            $.ajax({
                url: "{{ route('admin.campaign.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function () {
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
                    let errorMessage = "Terjadi kesalahan, silakan coba lagi.";
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        errorMessage = Object.values(errors).map(err => err[0]).join("<br>");
                    } else if (xhr.status === 419) {
                        errorMessage = "Session habis. Silakan refresh halaman dan coba lagi.";
                    }
                    Swal.fire({
                        title: "Gagal!",
                        html: errorMessage,
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                }
            });
        });
    });
</script>
@endsection
