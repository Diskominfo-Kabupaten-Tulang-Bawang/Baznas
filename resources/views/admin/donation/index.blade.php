@extends('layouts.app', ['title' => 'Dashboard - Admin'])

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-300">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                    <form id="filterForm" action="{{ route('admin.donation.filter') }}" method="GET">
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
                    <div id="donationTable">
                        @include('admin.donation._data_table')
                    </div>
                </div><!-- end card-body -->
            </div> <!-- end card -->
        </div><!-- end col -->
    </div><!-- end container -->
</main>

<script>
   $(document).ready(function () {
    $('#filterForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            data: $(this).serialize(),
            url: $(this).attr('action'),
            type: 'GET',
            success: function (response) {
                $('#donationTable').html(response.html); // Ambil `html` dari JSON response
            },
            error: function (xhr) {
                Swal.fire({
                    title: "Error!",
                    text: xhr.responseJSON?.message || "Terjadi kesalahan.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            }
        });
    });
});

</script>

@endsection
