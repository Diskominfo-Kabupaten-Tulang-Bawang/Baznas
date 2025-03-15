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
                                    <h4 class="card-title">Muzakki Details</h4>
                                </div><!--end col-->

                            </div><!--end row-->
                        </div><!--end card-header-->
                        <div class="card-body pt-0">
                            <div class="table-responsive table-responsive-sm">
                                <table class="table-responsive table mb-0" id="datatable_1">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Gambar</th>
                                            <th>Nama Lengkap</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($donaturs as $donatur)
                                            <tr>
                                                <td><img src="{{ $donatur->avatar }}" class="avatar-xs rounded-circle"></td>
                                                <td>{{ $donatur->name }}</td>
                                                <td>{{ $donatur->email }}</td>
                                            </tr>
                                        @empty
                                            <div class="bg-red-500 text-white text-center p-3 rounded-sm shadow-md">
                                                Data Belum Tersedia!
                                            </div>
                                        @endforelse

                                    </tbody>
                                </table>
                                @if ($donaturs->hasPages())
                                    <div class="bg-white p-3">
                                        {{ $donaturs->links('vendor.pagination.tailwind') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div><!-- container -->
</main>
@endsection
