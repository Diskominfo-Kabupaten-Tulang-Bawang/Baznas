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
                                <i class="fas fa-plus me-1"></i> Tambah Program
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive" id="campaignTable">
                        {{-- @include('admin.campaign._data_table') --}}
                        <table class="table mb-0" id="datatable_1">
                            <thead class="table-light">
                                <tr>
                                    <th>Gambar</th>
                                    <th>Judul Program</th>
                                    <th>Kategori</th>
                                    <th>Target Donasi</th>
                                    <th>Tanggal Berakhir</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="dataTable">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection


@push('js')
<script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
    loadTable();

    $(document).on('click', '.edit-data', function() {
        let id = $(this).data('id');
        let link = $(this).data('link');

        $('#data-id').val(id);
        $('#data-link').val(link);

        let editModal = new bootstrap.Modal(document.getElementById('dataModal'));
        editModal.show();
    });

    $(document).on('click', '.delete-data', function() {
        let id = $(this).data('id');
        hapusData(id);
    });

    $('#data-form').on('submit', function(event) {
        event.preventDefault();
        $('#save-data').prop('disabled', true).text('Menyimpan...');

        let id = $('#data-id').val();
        let formData = new FormData(this);
        let url = id ? `/admin/campaign/${id}` : "{{ route('admin.campaign.store') }}";

        if (id) formData.append('_method', 'PUT');

        $.ajax({
            url: url,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function() {
                loadTable();
                swal("Berhasil!", "campaign berhasil diperbarui", "success");
                $('#data-form')[0].reset();
                let modal = bootstrap.Modal.getInstance(document.getElementById('dataModal'));
                modal.hide();
            },
            error: function() {
                swal("Opps!", "Terjadi kesalahan", "error");
            },
            complete: function() {
                $('#save-data').prop('disabled', false).text('Simpan');
            }
        });
    });
});

function loadTable() {
    $.ajax({
        url: "{{ url()->current() }}",
        method: "GET",
        data: { load: 'table' },
        success: function(result) {
            $('#dataTable').html(result);
        }
    });
}


async function hapusData(id) {
    const willDelete = await swal({
        title: "Yakin?",
        text: "Apakah Anda yakin untuk menghapus data ini?",
        icon: "warning",
        buttons: 'ok',
        dangerMode: true,
    });

    if (willDelete) {
        let param = {
            url: `/admin/campaign/${id}`,
            method: "DELETE",
            processData: false,
            contentType: false,
            cache: false,
        };

        try {
            await transAjax(param);
            loadTable();
            swal("Dihapus!", "Data ini berhasil dihapus", "success");
        } catch (error) {
            swal("Opps!", "Terjadi kesalahan saat menghapus data", "error");
        }
    }
}

</script>
@endpush
