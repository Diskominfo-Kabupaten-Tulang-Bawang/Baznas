@extends('layouts.app', ['title' => 'Dashboard - Admin'])

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-300">
    <div class="container-xxl">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center pb-3">
                            <div class="col-9">
                                <p class="text-dark mb-0 fw-semibold fs-14">MUZAKKI</p>
                                <h3 class="mt-2 mb-0 fw-bold">{{ $donaturs }}</h3>
                            </div>
                            <div class="col-3 align-self-center">
                                <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                    <i class="fas fa-users h1 align-self-center mb-0 text-secondary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center pb-3">
                            <div class="col-9">
                                <p class="text-dark mb-0 fw-semibold fs-14">PROGRAM</p>
                                <h3 class="mt-2 mb-0 fw-bold">{{ $campaigns }}</h3>
                            </div>
                            <div class="col-3 align-self-center">
                                <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                    <i class="fas fa-chalkboard-teacher h1 align-self-center mb-0 text-secondary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center pb-3">
                            <div class="col-9">
                                <p class="text-dark mb-0 fw-semibold fs-14">Total zakat</p>
                                <h3 class="mt-2 mb-0 fw-bold">{{ moneyFormat($donations) }}</h3>
                            </div>
                            <div class="col-3 align-self-center">
                                <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                    <i class="fas fa-money-bill-wave h1 align-self-center mb-0 text-secondary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Detail zakat</h4>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                        <table class="table mb-0" id="datatable_1">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kategori</th>
                                    <th>Nama</th>
                                    <th>Jumlah</th>
                                    {{-- <th>Doa</th> --}}
                                    <th>Tanggal</th>
                                    <th>Detail</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="dataTable">

                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        <div id="pagination-links">
                            {!! $allDonations->links('pagination::bootstrap-4') !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @foreach($allDonations as $donation)
    <div class="modal fade" id="imageModal{{ $donation->id }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $donation->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel{{ $donation->id }}">Detail zakat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    {{-- <p><strong>Donation ID: {{ $donation->id }}</strong></p> <!-- Tambahkan ID di sini --> --}}
                    <img src="{{ route('stream', ['dir' => 'struk','filename' => $donation->struk]) }}" alt="Bukti Dukung - ID {{ $donation->id }}" class="img-fluid rounded">
                   <tr></tr>
                   <textarea name="" class="form-control mt-2" readonly>{{ $donation->pray }}</textarea>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Donasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="donationId" name="donation_id">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="success">Terima</option>
                                <option value="failed">Tolak</option>
                            </select>
                        </div>
                        <div class="mb-3 alasan-penolakan d-none">
                            <label for="">Alalan penolakan</label>
                            <textarea name="alasan_penolakan" class="form-control">

                            </textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('js')
<script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
<script type="text/javascript">
        let id_kategori = "";
        $(document).ready(function() {
            loadTable();

            $('#status').change(function() {
                if(this.value == 'failed') {
                    $('.alasan-penolakan').removeClass('d-none');
                }else {
                    $('.alasan-penolakan').addClass('d-none');
                }
            });
        });

        async function loadTable()
        {
            let param = {
                url: "{{ url()->current() }}",
                method: "GET",
                data: {
                    load: 'table'
                }
            }

            await transAjax(param).then((result) => {
                $("#dataTable").html(result);
            });
        }

        async function loadTable(page = 1) {
            let param = {
                url: "{{ url()->current() }}?page=" + page,
                method: "GET",
                data: {
                    load: 'table'
                }
            };

            await transAjax(param).then((result) => {
                $("#dataTable").html(result.table);
                $("#pagination-links").html(result.pagination);
            }).catch((error) => {
                console.error("Gagal memuat data:", error);
            });
        }


        $(document).ready(function () {
            $(document).on('click', '#pagination-links a', function (e) {
                e.preventDefault();
                let url = $(this).attr('href');

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (response) {
                        $('#dataTable').html(response.table);
                        $('#pagination-links').html(response.pagination);
                    },
                    error: function () {
                        swal("Gagal!", "Terjadi kesalahan dalam memuat data", "error");
                    }
                });
            });
        });

        async function updateDonasi(element) {
            // Mengambil semua data-* dari tombol yang diklik
            let id = element.getAttribute('data-id');
            let status = element.getAttribute('data-status');

            // Masukkan data ke dalam form modal
            document.getElementById("donationId").value = id;
            document.getElementById("status").value = status;

            // Tampilkan modal edit
            // let editModalx = new bootstrap.Modal(document.getElementById('editModal'));
            // editModalx.show();
        }

        // Menangani submit form update
        document.getElementById("editForm").addEventListener("submit", async function(event) {
            event.preventDefault();

            let id = document.getElementById("donationId").value;
            let formData = new FormData(this);

            let param = {
                url: `/admin/donation/${id}`,
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
            };

            await transAjax(param).then((result) => {
                loadTable();
                swal("Berhasil!", "Data donasi berhasil diperbarui", "success");
                // document.getElementById("editForm").reset();
                let editModal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
                if (editModal) {
                    editModal.hide();
                }
                // document.querySelector('.modal-backdrop')?.remove();
                }).catch((error) => {
                        swal("Opps!", "Terjadi kesalahan saat memperbarui data", "error");
            });
        });

        async function hapusDonasi(id)
        {

            const willDelete = await swal({
            title: "Yakin?",
            text: "Apakah Anda yakin untuk mengahpus data ini?",
            icon: "warning",
            dangerMode: true,
            });

            if (willDelete) {
                let param = {
                url: '/admin/donation/'+id,
                method: "DELETE",
                processData: false,
                contentType: false,
                cache: false,
                }

                await transAjax(param).then((result) => {
                    loadTable();
                    swal("Dihapus!", "Data ini berhasil dihapus", "success");
                }).catch((error) => {
                    swal("Opps!", "Internal server error!", "warning");
                });
            }
        }

    </script>
@endpush
