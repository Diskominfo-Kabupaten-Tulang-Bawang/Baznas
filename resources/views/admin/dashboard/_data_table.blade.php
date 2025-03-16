<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Donasi Details</h4>
        </div>
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
                        @forelse ($allDonations as $donation)
                        <tr>
                            <td>{{ $donation->id }}</td>
                            <td>{{ $donation->invoice }}</td>
                            <td>{{ $donation->campaign_id }}</td>
                            <td>{{ $donation->donatur_id }}</td>
                            <td>Rp {{ number_format($donation->amount, 0, ',', '.') }}</td>
                            <td>{{ $donation->pray }}</td>
                            <td>{{ $donation->created_at }}</td>
                            <td>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal{{ $donation->id }}">
                                    <img src="https://seosecret.id/placeholder/600x300/D5D5D5/584959" alt="Bukti Dukung" width="100">
                                </a>
                            </td>
                            <!-- Modal Image -->
                            <div class="modal fade" id="imageModal{{ $donation->id }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $donation->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="imageModalLabel{{ $donation->id }}">Bukti Dukung</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img src="https://seosecret.id/placeholder/600x300/D5D5D5/584959" alt="Bukti Dukung" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <td>
                                <span class="badge bg-{{ $donation->status == 'success' ? 'success' : ($donation->status == 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($donation->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="#" class="edit-button" data-bs-toggle="modal" data-bs-target="#editModal"
                                    data-id="{{ $donation->id }}" data-invoice="{{ $donation->invoice }}" data-campaign_id="{{ $donation->campaign_id }}"
                                    data-donatur_id="{{ $donation->donatur_id }}" data-amount="{{ $donation->amount }}" data-pray="{{ $donation->pray }}"
                                    data-status="{{ $donation->status }}">
                                    <i class="las la-pen text-secondary fs-18"></i>
                                </a>
                                <button class="delete-donation border-0 bg-transparent" data-id="{{ $donation->id }}">
                                    <i class="las la-trash-alt text-secondary fs-18"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">
                                <div class="d-flex flex-column align-items-center p-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="80" height="80" class="text-gray-400">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75a2.25 2.25 0 001.125 1.946c1.55.894 4.067 1.554 7.125 1.554s5.575-.66 7.125-1.554A2.25 2.25 0 0019.5 15.75M4.5 12a2.25 2.25 0 001.125 1.946c1.55.894 4.067 1.554 7.125 1.554s5.575-.66 7.125-1.554A2.25 2.25 0 0019.5 12M4.5 8.25A2.25 2.25 0 005.625 10.2c1.55.894 4.067 1.554 7.125 1.554s5.575-.66 7.125-1.554A2.25 2.25 0 0019.5 8.25M4.5 4.5a2.25 2.25 0 001.125 1.946c1.55.894 4.067 1.554 7.125 1.554s5.575-.66 7.125-1.554A2.25 2.25 0 0019.5 4.5 2.25 2.25 0 0018.375 2.554C16.825 1.66 14.308 1 11.25 1s-5.575.66-7.125 1.554A2.25 2.25 0 004.5 4.5z" />
                                    </svg>
                                    <p class="mt-3 text-muted">Data belum tersedia.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $allDonations->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Donasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="donationId" name="donation_id">

                    <div class="mb-3">
                        <label for="invoice" class="form-label">Invoice</label>
                        <input type="text" class="form-control" id="invoice" name="invoice" required>
                    </div>
                    <div class="mb-3">
                        <label for="campaign_id" class="form-label">Campaign ID</label>
                        <input type="text" class="form-control" id="campaign_id" name="campaign_id" required>
                    </div>
                    <div class="mb-3">
                        <label for="donatur_id" class="form-label">Donatur ID</label>
                        <input type="text" class="form-control" id="donatur_id" name="donatur_id" required>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="pray" class="form-label">Pray</label>
                        <textarea class="form-control" id="pray" name="pray" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="success">Success</option>
                            <option value="pending">Pending</option>
                            <option value="failed">Failed</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('donationId').value = this.dataset.id;
            document.getElementById('invoice').value = this.dataset.invoice;
            document.getElementById('campaign_id').value = this.dataset.campaign_id;
            document.getElementById('donatur_id').value = this.dataset.donatur_id;
            document.getElementById('amount').value = this.dataset.amount;
            document.getElementById('pray').value = this.dataset.pray;
            document.getElementById('status').value = this.dataset.status;
            document.getElementById('editForm').action = `/admin/donation/${this.dataset.id}`;
        });
    });

    document.getElementById('editForm').addEventListener('submit', function (event) {
        event.preventDefault();
        let form = this;
        let formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Data berhasil diperbaharui.',
                }).then(() => window.location.href = '/admin/dashboard');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Data gagal diperbaharui.',
                });
            }
        })
        .catch(() => {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan pada server.',
            });
        });
    });
});
</script>
