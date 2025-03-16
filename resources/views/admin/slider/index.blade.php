@extends('layouts.app', ['title' => 'Daftar Slider'])

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-300">
    <div class="container">
        <div class="mt-4">

                <div class="col-12">
                    <div class="card">
                        <div class="d-flex justify-content-between align-items-center my-4 px-3">
                            <h4 class="fw-bold">Daftar Slider</h4>
                            <a href="{{ route('admin.slider.create') }}" class="btn btn-primary">+ Tambah Slider</a>
                        </div>

                        <div class="card-body pt-0" id="sliderTable">
                            @include('admin.slider._data_table')
                        </div>
                    </div>
                </div>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function refreshTable() {
        $.ajax({
            url: "{{ route('admin.slider.index') }}",
            type: "GET",
            success: function(response) {
                $('#sliderTable').html($(response).find('#sliderTable').html());
            },
            error: function() {
                Swal.fire("Error!", "Gagal memuat data!", "error");
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".delete-slider").forEach(button => {
        button.addEventListener("click", function () {
            let sliderId = this.getAttribute("data-id");
            let deleteUrl = this.getAttribute("data-url");
            if (!sliderId || !deleteUrl) return;

            let token = document.querySelector("meta[name='csrf-token']").getAttribute("content");

            Swal.fire({
                title: 'APAKAH KAMU YAKIN?',
                text: "INGIN MENGHAPUS DATA INI!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'BATAL',
                confirmButtonText: 'YA, HAPUS!',
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(deleteUrl, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": token,
                            "Content-Type": "application/json"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === "success") {
                            Swal.fire({
                                icon: 'success',
                                title: 'BERHASIL!',
                                text: 'Data berhasil dihapus.',
                                showConfirmButton: false,
                                timer: 2000
                            });

                            // Hapus baris tabel secara langsung tanpa reload
                            document.querySelector(`button[data-id="${sliderId}"]`).closest("tr").remove();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'GAGAL!',
                                text: data.message,
                                showConfirmButton: true
                            });
                        }
                    })
                    .catch(error => {
                        console.error("Error deleting slider:", error);
                        Swal.fire({
                            icon: 'error',
                            title: 'KESALAHAN SERVER!',
                            text: 'Terjadi kesalahan saat menghapus data.',
                            showConfirmButton: true
                        });
                    });
                }
            });
        });
    });
});

</script>

@endsection

