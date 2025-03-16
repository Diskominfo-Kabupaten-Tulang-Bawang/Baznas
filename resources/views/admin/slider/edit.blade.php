@extends('layouts.app', ['title' => 'Dashboard - Admin'])

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3>Edit Slider</h3>
        </div>
        <div class="card-body">
            <form id="edit-slider-form" enctype="multipart/form-data">
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
                    <button id="update-btn" type="button" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.slider.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {
    $("#update-btn").click(function (e) {
        e.preventDefault();

        let form = $("#edit-slider-form")[0];
        let formData = new FormData(form);
        formData.append('_token', '{{ csrf_token() }}');

        $("#update-btn").prop("disabled", true).text("Mengupdate...");

        $.ajax({
            url: "{{ route('admin.slider.update', $slider->id) }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'BERHASIL!',
                    text: 'Slider berhasil diperbarui!',
                    showConfirmButton: false,
                    timer: 3000
                }).then(() => {
                    window.location.href = "{{ route('admin.slider.index') }}";
                });
            },
            error: function (xhr) {
                $("#update-btn").prop("disabled", false).text("Update");

                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = "";
                    $.each(errors, function (key, value) {
                        errorMessage += value[0] + "<br>";
                    });

                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Gagal!',
                        html: errorMessage,
                        confirmButtonText: 'OK'
                    });
                } else if (xhr.status === 419) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Session Habis!',
                        text: 'Silakan refresh halaman dan coba lagi.',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan pada server.',
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
    });
});
</script>
@endsection
