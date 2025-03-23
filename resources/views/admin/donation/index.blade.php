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
                                {{-- <button class="btn btn-secondary w-100" type="button" onclick="window.location.href='{{ route('admin.donation.index') }}'"><i class="fas fa-undo me-1"></i> Reset</button> --}}
                            </div>
                        </div>
                    </form>
                    <form id="category-filter-form">
                        @csrf
                        <div class="row mt-2">
                            <div class="col-md-8 mb-3 mb-md-0">
                                <label for="category-filter" class="form-label">Filter Kategori</label>
                                <select class="form-control" id="category-filter" name="category">
                                    <option value="">Semua Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button class="btn btn-secondary w-100" type="button" onclick="window.location.href='{{ route('admin.donation.index') }}'"><i class="fas fa-undo me-1"></i> Reset</button>
                            </div>
                        </div>
                    </form>

                </div><!-- end card-header -->

                <div class="card-body pt-0">
                    <div id="donationTable">
                        {{-- @include('admin.donation._data_table') --}}
                        <div class="table-responsive">
                            <table class="table mb-0">
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
                                    </tr>
                                </thead>
                                <tbody id="dataTable">
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <div id="pagination-links">
                              {{ $allDonations->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>

                </div><!-- end card-body -->
            </div> <!-- end card -->
        </div><!-- end col -->
    </div><!-- end container -->
</main>
@endsection

@push('js')
<script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
<script type="text/javascript">
        let id_kategori = "";
        $(document).ready(function() {
            loadTable();
        });


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

    $(document).ready(function () {
        $('#filterForm').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                data: $(this).serialize(),
                url: $(this).attr('action'),
                type: 'GET',
                success: function (response) {
                    $('#dataTable').html(response.table);
                    $('#pagination-links').html(response.pagination);
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

    document.getElementById('category-filter').addEventListener('change', function() {
        $.ajax({
            url: "{{ route('admin.donation.filterCategory') }}",
            type: "GET",
            data: { category: this.value },
            success: function(response) {
                $('#dataTable').html(response.table);
                $('#pagination-links').html(response.pagination);
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    });



    </script>
@endpush
