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
                                <p class="text-dark mb-0 fw-semibold fs-14">Dzakat</p>
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
                    <h4 class="card-title">Donasi Details</h4>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                        <table class="table mb-0" id="datatable_1">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice</th>
                                    <th>Campaign ID</th>
                                    <th>Donatur ID</th>
                                    <th>Amount</th>
                                    <th>Pray</th>
                                    <th>Tanggal</th>
                                    <th>Bukti Dukung</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="dataTable">

                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $allDonations->links('pagination::bootstrap-4') }}
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
                    <h5 class="modal-title" id="imageModalLabel{{ $donation->id }}">Bukti Dukung - ID {{ $donation->id }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p><strong>Donation ID: {{ $donation->id }}</strong></p> <!-- Tambahkan ID di sini -->
                    <img src="{{ $donation->bukti_dukung ?? 'https://seosecret.id/placeholder/600x300/D5D5D5/584959' }}" alt="Bukti Dukung - ID {{ $donation->id }}" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
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
                            <label for="invoice" class="form-label">Invoice</label>
                            <input type="text" class="form-control" id="invoice" name="invoice" required>
                        </div>
                        <div class="mb-3">
                            <label for="campaign_id" class="form-label">Campaign ID</label>
                            <input type="text" class="form-control" id="campaign_id" name="campaign_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="donatur_id" class="form-label">Donatur ID</label>
                            <input type="text" class="form-control" id="donatur_id" name="donatur_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount" required>
                        </div>
                        <div class="mb-3">
                            <label for="pray" class="form-label">Pray</label>
                            <textarea class="form-control" id="pray" name="pray" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="success">Success</option>
                                <option value="pending">Pending</option>
                                <option value="failed">Failed</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save changes</button>
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

        async function updateDonasi(element) {
            // Mengambil semua data-* dari tombol yang diklik
            let id = element.getAttribute('data-id');
            let invoice = element.getAttribute('data-invoice');
            let campaignId = element.getAttribute('data-campaign_id');
            let donaturId = element.getAttribute('data-donatur_id');
            let amount = element.getAttribute('data-amount');
            let pray = element.getAttribute('data-pray');
            let status = element.getAttribute('data-status');

            // Masukkan data ke dalam form modal
            document.getElementById("donationId").value = id;
            document.getElementById("invoice").value = invoice;
            document.getElementById("campaign_id").value = campaignId;
            document.getElementById("donatur_id").value = donaturId;
            document.getElementById("amount").value = amount;
            document.getElementById("pray").value = pray;
            document.getElementById("status").value = status;

            // Tampilkan modal edit
            let editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
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
                document.getElementById("editForm").reset();
                let editModal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
                if (editModal) {
                    editModal.hide();
                }
                document.querySelector('.modal-backdrop')?.remove();
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
