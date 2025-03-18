@extends('layouts.app', ['title' => 'Dashboard - Admin'])

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-300">
    <div class="container-xxl">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Slider</h4>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#dataModal">
                                <i class="fas fa-plus me-1"></i> Tambah Slider
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div id="dataTableContainer">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Gambar</th>
                                    <th>Link</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="dataTable"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah/Edit Slider -->
    <div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dataModalLabel">Tambah Slider</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="data-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="data-id" name="id">
                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="link" class="form-label">Link</label>
                            <input type="url" name="link" id="data-link" class="form-control" placeholder="Masukkan URL" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" id="save-data" class="btn btn-primary">Simpan</button>
                        </div>
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
        let url = id ? `/admin/slider/${id}` : "{{ route('admin.slider.store') }}";

        if (id) formData.append('_method', 'PUT');

        $.ajax({
            url: url,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function() {
                loadTable();
                swal("Berhasil!", "Slider berhasil diperbarui", "success");
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
            url: `/admin/slider/${id}`,
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
