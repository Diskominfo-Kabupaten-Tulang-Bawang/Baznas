
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
                                    <h4 class="card-title">Program Details</h4>
                                </div><!--end col-->
                                <div class="col-auto">
                                    <a href="{{ route('admin.campaign.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Add User </a>
                                </div><!--end col-->
                            </div><!--end row-->
                        </div><!--end card-header-->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table mb-0" id="datatable_1">
                                    <thead class="table-light">
                                      <tr>
                                        <th>Judul Campingan</th>
                                        <th>Kategori</th>
                                        <th>Target Donasi</th>
                                        <th>Tanggal Berakhir</th>
                                        <th>Aksi</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($campaigns as $campaign)
                                            <tr>
                                                <td class="d-flex align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        {{ $campaign->title }}
                                                    </div>
                                                </td>
                                                <td>{{ $campaign->category->name }}</td>
                                                <td>{{ moneyFormat($campaign->target_donation) }}</td>
                                                <td> {{ $campaign->max_date }}</td>
                                                <td>
                                                    <a href="{{ route('admin.campaign.edit', $campaign->id) }}"><i class="las la-pen text-secondary fs-18"></i></a>
                                                    <button class="delete-category border-0 bg-transparent" data-id="{{ $campaign->id }}">
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
    //ajax delete
    function destroy(id) {
        var id = id;
        var token = $("meta[name='csrf-token']").attr("content");

        Swal.fire({
            title: 'APAKAH KAMU YAKIN ?',
            text: "INGIN MENGHAPUS DATA INI!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'BATAL',
            confirmButtonText: 'YA, HAPUS!',
        }).then((result) => {
            if (result.isConfirmed) {
                //ajax delete
                jQuery.ajax({
                    url: `/admin/campaign/${id}`,
                    data: {
                        "id": id,
                        "_token": token
                    },
                    type: 'DELETE',
                    success: function (response) {
                        if (response.status == "success") {
                            Swal.fire({
                                icon: 'success',
                                title: 'BERHASIL!',
                                text: 'DATA BERHASIL DIHAPUS!',
                                showConfirmButton: false,
                                timer: 3000
                            }).then(function () {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'GAGAL!',
                                text: 'DATA GAGAL DIHAPUS!',
                                showConfirmButton: false,
                                timer: 3000
                            }).then(function () {
                                location.reload();
                            });
                        }
                    }
                });
            }
        })
    }
</script>
@endsection
