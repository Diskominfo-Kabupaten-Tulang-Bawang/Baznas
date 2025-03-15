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
                                <!--end col-->
                                <div class="col-3 align-self-center">
                                    <divNew Sessions Today
                                        class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                        <?xml version="1.0" encoding="UTF-8"?><svg width="40px" height="40px" viewBox="0 0 24 24" stroke-width="1.4" fill="none" xmlns="http://www.w3.org/2000/svg" color="#bababa"><path d="M7 18V17C7 14.2386 9.23858 12 12 12V12C14.7614 12 17 14.2386 17 17V18" stroke="#bababa" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"></path><path d="M1 18V17C1 15.3431 2.34315 14 4 14V14" stroke="#bababa" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"></path><path d="M23 18V17C23 15.3431 21.6569 14 20 14V14" stroke="#bababa" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"></path><path d="M12 12C13.6569 12 15 10.6569 15 9C15 7.34315 13.6569 6 12 6C10.3431 6 9 7.34315 9 9C9 10.6569 10.3431 12 12 12Z" stroke="#bababa" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"></path><path d="M4 14C5.10457 14 6 13.1046 6 12C6 10.8954 5.10457 10 4 10C2.89543 10 2 10.8954 2 12C2 13.1046 2.89543 14 4 14Z" stroke="#bababa" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"></path><path d="M20 14C21.1046 14 22 13.1046 22 12C22 10.8954 21.1046 10 20 10C18.8954 10 18 10.8954 18 12C18 13.1046 18.8954 14 20 14Z" stroke="#bababa" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                    </divNew>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->
                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center pb-3">
                                <div class="col-9">
                                    <p class="text-dark mb-0 fw-semibold fs-14">PROGRAM</p>
                                    <h3 class="mt-2 mb-0 fw-bold">{{ $campaigns }}</h3>
                                </div>
                                <!--end col-->
                                <div class="col-3 align-self-center">
                                    <div
                                        class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                        <i class="fas fa-chalkboard-teacher h1 align-self-center mb-0 text-secondary"></i>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->

                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->
                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center pb-3">
                                <div class="col-9">
                                    <p class="text-dark mb-0 fw-semibold fs-14">Dzakat</p>
                                    <h3 class="mt-2 mb-0 fw-bold">{{ moneyFormat($donations) }}</h3>
                                </div>
                                <!--end col-->
                                <div class="col-3 align-self-center">
                                    <div
                                        class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                        <i
                                            class="fas fa-money-bill-wave h1 align-self-center mb-0 text-secondary"></i>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->

                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->
            </div>
            <!--end row-->

            <!--Card User Data table  -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="card-title">Donasi Details</h4>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end card-header-->
                    <div class="card-body pt-0">
                        <div class="table-responsive">
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
                                <tbody>
                                    @if($allDonations->count())
                                    @foreach ($allDonations as $donation)
                                    <tr>
                                        <td>{{ $donation->id }}</td>
                                        <td>{{ $donation->invoice }}</td>
                                        <td>{{ $donation->campaign_id }}</td>
                                        <td>{{ $donation->donatur_id }}</td>
                                        <td>Rp {{ number_format((float) $donation->amount, 0, ',', '.') }}</td>
                                        <td>{{ $donation->pray }}</td>
                                        <td>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal{{ $donation->id }}">
                                                <img src="https://seosecret.id/placeholder/600x300/D5D5D5/584959" alt="Bukti Dukung" width="100">
                                            </a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="imageModal{{ $donation->id }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $donation->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="imageModalLabel{{ $donation->id }}">Bukti Dukung</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="https://seosecret.id/placeholder/600x300/D5D5D5/584959" alt="Bukti Dukung" class="img-fluid">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($donation->created_at)->format('Y-m-d') }}</td>
                                        <td>
                                            <span class="badge
                                                @if($donation->status == 'success') bg-success
                                                @elseif($donation->status == 'pending') bg-warning
                                                @else bg-danger
                                                @endif">
                                                {{ ucfirst($donation->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#editModal{{ $donation->id }}"><i class="las la-pen text-secondary fs-18"></i></a>
                                            <button class="delete-donation border-0 bg-transparent" data-id="{{ $donation->id }}">
                                                <i class="las la-trash-alt text-secondary fs-18"></i>
                                            </button>

                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $donation->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $donation->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel{{ $donation->id }}">Edit Donation</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('admin.donation.update', $donation->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label for="invoice" class="form-label">Invoice</label>
                                                            <input type="text" class="form-control" id="invoice" name="invoice" value="{{ $donation->invoice }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="amount" class="form-label">Amount</label>
                                                            <input type="text" class="form-control" id="amount" name="amount" value="{{ $donation->amount }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="status" class="form-label">Status</label>
                                                            <select class="form-select" id="status" name="status">
                                                                <option value="success" @if($donation->status == 'success') selected @endif>Success</option>
                                                                <option value="pending" @if($donation->status == 'pending') selected @endif>Pending</option>
                                                                <option value="failed" @if($donation->status == 'failed') selected @endif>Failed</option>
                                                            </select>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="10" class="text-center">No donations available</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $allDonations->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div><!-- container -->
    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.delete-donation').forEach(button => {
            button.addEventListener('click', function () {
                let donationId = this.getAttribute('data-id');

                Swal.fire({
                    title: "Yakin ingin menghapus donasi ini?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Ya, hapus!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/admin/donation/${donationId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            if (!response.ok) throw new Error("Gagal menghapus donasi");
                            return response.json();
                        })
                        .then(() => {
                            Swal.fire("Terhapus!", "Donasi telah dihapus.", "success")
                                .then(() => location.reload());
                        })
                        .catch(() => {
                            Swal.fire("Gagal!", "Donasi gagal dihapus.", "error");
                        });
                    }
                });
            });
        });


    });
    </script>

@endsection
