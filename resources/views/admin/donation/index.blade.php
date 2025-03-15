@extends('layouts.app', ['title' => 'Dashboard - Admin'])

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-300">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- SweetAlert Notification --}}
    @if(session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    title: "Berhasil!",
                    text: @json(session('success')),
                    icon: "success",
                    confirmButtonText: "OK"
                });
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    title: "Gagal!",
                    text: @json(session('error')),
                    icon: "error",
                    confirmButtonText: "OK"
                });
            });
        </script>
    @endif

    <div class="container-xxl">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <form action="{{ route('admin.donation.filter') }}" method="GET">
                        <div class="row mt-3">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label for="start_date" class="form-label">Tanggal Awal</label>
                                <input type="date" class="form-control" id="start_date" name="date_from"
                                value="{{ old('date_from') ?? request()->query('date_from') }}">
                                @error('date_from')
                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                        <div class="px-4 py-2">
                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                        </div>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label for="end_date" class="form-label">Tanggal Akhir</label>
                                <input type="date" class="form-control" id="end_date" name="date_to"
                                value="{{ old('date_to') ?? request()->query('date_to') }}">
                                @error('date_to')
                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                        <div class="px-4 py-2">
                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                        </div>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button class="btn btn-success w-100 me-2" type="submit"><i class="fas fa-filter me-1"></i> Filter</button>
                                <button class="btn btn-secondary w-100" type="button" onclick="window.location.href='{{ route('admin.donation.index') }}'"><i class="fas fa-undo me-1"></i> Reset</button>
                            </div>
                        </div>
                    </form>
                </div><!-- end card-header -->

                <div class="card-body pt-0">
                    @if(isset($total))
                    <div class="alert alert-info">
                        Total Donasi: Rp {{ number_format($total, 0, ',', '.') }}
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice</th>
                                    <th>Campaign ID</th>
                                    <th>Donatur ID</th>
                                    <th>Amount</th>
                                    <th>Pray</th>
                                    <th>Bukti Dukung</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($donations as $donation)
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
                                        <div class="modal fade" id="imageModal{{ $donation->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Bukti Dukung</h5>
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
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $donations->links('pagination::bootstrap-4') }}
                    </div>
                </div><!-- end card-body -->
            </div> <!-- end card -->
        </div><!-- end col -->
    </div><!-- end container -->
</main>

@endsection
