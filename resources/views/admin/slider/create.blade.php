@extends('layouts.app', ['title' => 'Tambah Slider'])

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-300">
    <div class="container">
        <div class="card p-4">
            <h5 class="fw-bold">UPLOAD SLIDER</h5>
            <hr>
            <form id="slider-form" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">GAMBAR</label>
                    <input type="file" class="form-control" name="image">
                </div>
                <div class="mb-3">
                    <label class="form-label">LINK SLIDER</label>
                    <input type="text" class="form-control" name="link" value="{{ old('link') }}" placeholder="Link Promo">
                </div>
                <button id="upload-btn" type="button" class="btn btn-primary">UPLOAD</button>
            </form>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {
    $("#upload-btn").click(function (e) {
        e.preventDefault();

        let form = $("#slider-form")[0];
        let formData = new FormData(form);
        formData.append('_token', '{{ csrf_token() }}');

        $("#upload-btn").prop("disabled", true).text("Mengupload...");
        $.ajax({
            url: "{{ route('admin.slider.store') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'BERHASIL!',
                    text: 'Slider berhasil diupload!',
                    showConfirmButton: false,
                    timer: 3000
                }).then(() => {
                    window.location.href = "{{ route('admin.slider.index') }}";
                });
            },
            error: function (xhr) {
                $("#upload-btn").prop("disabled", false).text("UPLOAD");

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
