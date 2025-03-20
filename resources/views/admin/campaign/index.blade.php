@extends('layouts.app', ['title' => 'Dashboard - Admin'])

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-300">
    <div class="container-xxl">
        <!-- Card User Data Table -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Program</h4>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.campaign.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Add Program
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive" id="campaignTable">
                        @include('admin.campaign._data_table')
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function loadCampaigns() {
        $.ajax({
            url: "{{ route('admin.campaign.index') }}",
            type: "GET",
            dataType: "html",
            success: function(response) {
                $('#campaignTable').html(response);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }

    function destroy(button) {
        var id = button.getAttribute("data-id");
        var token = document.querySelector("meta[name='csrf-token']").getAttribute("content");

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
                fetch(`/admin/campaign/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({ id: id })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        Swal.fire({
                            icon: 'success',
                            title: 'BERHASIL!',
                            text: 'DATA BERHASIL DIHAPUS!',
                            showConfirmButton: false,
                            timer: 3000
                        }).then(() => {
                            loadCampaigns();
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
                })
                .catch(error => console.error('Error:', error));
            }
        });
    }

    $(document).ready(function() {
        loadCampaigns();
    });
</script>

@endsection
