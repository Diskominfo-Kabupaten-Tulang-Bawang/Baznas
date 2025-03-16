@extends('layouts.app', ['title' => 'Dashboard - Admin'])

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-300">
    <div class="container-xxl">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Kategori Details</h4>
                        </div>
                        <div class="col-auto">
                            <a class="btn btn-primary mb-2" href="{{ route('admin.category.create') }}">
                                <i class="fas fa-plus me-1"></i> Tambah Kategori
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div id="categoryTableContainer">
                        @include('admin.category._data_table')
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        function loadCategories() {
            $.ajax({
                url: "{{ route('admin.category.index') }}",
                type: "GET",
                dataType: "json",
                success: function (response) {
                    $("#categoryTableContainer").html(response.html);
                }
            });
        }

        $("body").on("click", ".delete-category", function () {
            let id = $(this).data("id");
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'APAKAH KAMU YAKIN?',
                text: "DATA YANG DIHAPUS TIDAK BISA DIKEMBALIKAN!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'BATAL',
                confirmButtonText: 'YA, HAPUS!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/category/${id}`,
                        type: 'DELETE',
                        data: { "_token": token },
                        success: function (response) {
                            if (response.status === "success") {
                                Swal.fire('Berhasil', 'Data berhasil dihapus!', 'success');
                                loadCategories();
                            } else {
                                Swal.fire('Gagal', response.message, 'error');
                            }
                        },
                        error: function (xhr) {
                            Swal.fire('Gagal', xhr.responseJSON?.message || 'Terjadi kesalahan!', 'error');
                        }
                    });
                }
            });
        });

        loadCategories();
    });
</script>
@endsection
