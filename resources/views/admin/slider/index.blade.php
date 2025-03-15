@extends('layouts.app', ['title' => 'Dashboard - Admin'])

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-300">
    <div class="container-xxl">
        <div class="container">
            <div class="card p-4">
                <h5 class="fw-bold">UPLOAD SLIDER</h5>
                <hr>
                <form action="{{ route('admin.slider.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">GAMBAR</label>
                        <input type="file" class="form-control" name="image">
                        @error('image')
                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">LINK SLIDER</label>
                        <input type="text" class="form-control" name="link" value="{{ old('link') }}" placeholder="Link Promo">
                        @error('link')
                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">UPLOAD</button>
                </form>
            </div>

            <div class="mt-4">
                @if($sliders->isEmpty())
                    <div class="alert alert-danger text-center" role="alert">Data Belum Tersedia!</div>
                @else
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Slider Details</h4>
                            </div>
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table mb-0" id="datatable_1">
                                        <thead class="table-light">
                                            <tr>
                                                <th>GAMBAR</th>
                                                <th>LINK PROMO</th>
                                                <th>AKSI</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($sliders as $slider)
                                                <tr>
                                                    <td>
                                                        <img src="{{ asset('storage/sliders/' . $slider->image) }}" class="me-2 thumb-md align-self-center rounded" alt="...">
                                                    </td>
                                                    <td>{{ $slider->link }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.slider.edit', $slider->id) }}" class="btn btn-link p-0">
                                                            <i class="las la-edit text-primary fs-18"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-link p-0 delete-slider" name="delete" data-id="{{ $slider->id }}">
                                                            <i class="las la-trash-alt text-danger fs-18"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if ($sliders->hasPages())
                                        <div class="bg-white p-3">{{ $sliders->links('vendor.pagination.tailwind') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".delete-slider").forEach(button => {
        button.addEventListener("click", function () {
            let sliderId = this.getAttribute("data-id");
            if (!sliderId) return;

            let token = document.querySelector("meta[name='csrf-token']").getAttribute("content");

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
                    fetch(`/admin/slider/${sliderId}`, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": token,
                            "Content-Type": "application/json"
                        },
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
                                location.reload();
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
                    .catch(error => {
                        console.error("Error deleting slider:", error);
                        Swal.fire({
                            icon: 'error',
                            title: 'KESALAHAN SERVER!',
                            text: 'Terjadi kesalahan saat menghapus data.',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    });
                }
            });
        });
    });
});

</script>
@endsection
