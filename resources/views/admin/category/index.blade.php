@extends('layouts.app', ['title' => 'Dashboard - Admin'])

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-300">
    <div class="container-xxl">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Kategori Detail</h4>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#categoryModal">
                                <i class="fas fa-plus me-1"></i> Tambah Kategori
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div id="categoryTableContainer">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Gambar</th>
                                    <th>Nama Kategori</th>
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
    <!-- Modal Tambah/Edit Kategori -->
    <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryModalLabel">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="category-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="category-id" name="id">

                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar</label>
                            <input type="file" name="image" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Kategori</label>
                            <input type="text" name="name" id="category-name" class="form-control" placeholder="Nama Kategori" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" name="submit" id="save-category" class="btn btn-primary">Simpan</button>
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

    // Event delegation untuk tombol edit kategori
    $(document).on('click', '.edit-category', function(e) {
        e.preventDefault();
        updateKategori(this);
    });

    // Event delegation untuk tombol hapus kategori
    $(document).on('click', '.delete-category', function(e) {
        e.preventDefault();
        hapusKategori($(this).data('id'));
    });

    // Event listener untuk form submit
    $("#category-form").on("submit", async function(event) {
        event.preventDefault();
        $("#save-category").prop("disabled", true).text("Menyimpan...");

        let id = $("#category-id").val();
        let formData = new FormData(this);
        let url = id ? `/admin/category/${id}` : "{{ route('admin.category.store') }}";

        if (id) {
            formData.append('_method', 'PUT');
        }

        let param = {
            url: url,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
        };

        try {
            await transAjax(param);
            loadTable();
            swal("Berhasil!", "Kategori berhasil diperbarui", "success");

            // Reset form dan tutup modal
            $("#category-form")[0].reset();
            let editModal = bootstrap.Modal.getInstance(document.getElementById('categoryModal'));
            if (editModal) editModal.hide();
            $('.modal-backdrop').remove();
        } catch (error) {
            swal("Opps!", "Terjadi kesalahan saat memperbarui data", "error");
        } finally {
            $("#save-category").prop("disabled", false).text("Simpan");
        }
    });
});

async function loadTable() {
    let param = {
        url: "{{ url()->current() }}",
        method: "GET",
        data: { load: 'table' }
    };

    await transAjax(param).then((result) => {
        $("#dataTable").html(result);
    });
}

function updateKategori(element) {
    let id = element.getAttribute('data-id');
    let name = element.getAttribute('data-name');

    $("#category-id").val(id);
    $("#category-name").val(name);

    let editModal = new bootstrap.Modal(document.getElementById('categoryModal'));
    editModal.show();
}

async function hapusKategori(id) {
    const willDelete = await swal({
        title: "Yakin?",
        text: "Apakah Anda yakin untuk menghapus data ini?",
        icon: "warning",
        buttons: 'ok',
        dangerMode: true,
    });

    if (willDelete) {
        let param = {
            url: `/admin/category/${id}`,
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

