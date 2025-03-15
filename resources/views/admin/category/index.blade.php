@extends('layouts.app', ['title' => 'Dashboard - Admin'])

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-300">

            <div class="container-xxl">
                <!--Card User Data table  -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="card-title">Kategori Details</h4>
                                </div><!--end col-->
                                <div class="col-auto">
                                    <a class="btn btn-primary mb-2" href="{{ route('admin.category.create') }}"><i class="fas fa-plus me-1"></i> Add User </a>
                            </div><!--end row-->
                        </div><!--end card-header-->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table mb-0" id="datatable_1">
                                    <thead class="table-light">
                                      <tr>
                                        <th>Gambar</th>
                                        <th>Nama Kategori</th>
                                        <th>Aksi</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($categories as $category)
                                            <tr>
                                                <td class="d-flex align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ $category->image }}" class="me-2 thumb-md align-self-center rounded" alt="...">
                                                    </div>
                                                </td>
                                                <td>{{ $category->name }}</td>
                                                <td>
                                                    <a href="{{ route('admin.category.edit', $category->id) }}"><i class="las la-pen text-secondary fs-18"></i></a>
                                                    <button class="delete-category border-0 bg-transparent" data-id="{{ $category->id }}">
                                                        <i class="las la-trash-alt text-secondary fs-18"></i>
                                                    </button>

                                                </td>
                                            </tr>
                                            @empty
                                            <div class="bg-red-500 text-white text-center p-3 rounded-sm shadow-md">
                                                Data Belum Tersedia!
                                            </div>
                                        @endforelse
                                    </tbody>
                                  </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div><!-- container -->
</main>


<script>
    $(document).ready(function () {
        $(".delete-category").click(function () {
            let id = $(this).data("id");
            let token = $("meta[name='csrf-token']").attr("content");

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
                    $.ajax({
                        url: `/admin/category/${id}`,
                        type: 'POST', // Laravel membutuhkan POST dengan _method DELETE
                        data: {
                            "_token": token,
                            "_method": "DELETE"
                        },
                        success: function (response) {
                            if (response.status === "success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'BERHASIL!',
                                    text: 'DATA BERHASIL DIHAPUS!',
                                    showConfirmButton: false,
                                    timer: 3000
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'GAGAL!',
                                    text: 'DATA GAGAL DIHAPUS!',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            }
                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'GAGAL!',
                                text: 'TERJADI KESALAHAN, COBA LAGI!',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    });
                }
            });
        });
    });
</script>

@endsection
