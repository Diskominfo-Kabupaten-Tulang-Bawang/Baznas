
@forelse ($donations  as $index => $donation)
<tr>
    <td>{{ $index + 1 }}</td>
    <td>{{ $donation->category->name ?? 'Tidak Ada Kategori' }}</td>
    <td>{{ $donation->muzakki->name ?? 'Hamba Allah' }}</td>
    <td>Rp {{ number_format($donation->amount, 0, ',', '.') }}</td>
    <td>{{ \Carbon\Carbon::parse($donation->created_at)->format('d-m-Y') }}</td>
    <td>
        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal{{ $donation->id }}">
            <span class="badge bg-success">Lihat</span>
        </a>
    </td>
    <td>
        @if($donation->status == 'success')
            <span class="badge bg-primary">diterima</span>
            @else
            <span class="badge bg-danger">ditolak</span>
        @endif
    </td>
    <td>
        <div class="modal fade" id="imageModal{{ $donation->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Bukti Dukung</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="{{ route('stream', ['dir' => 'struk', 'filename' => $donation->struk]) }}" alt="Bukti Dukung" class="img-fluid">
                        <textarea name="" class="form-control mt-2" readonly>{{ $donation->pray }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="9" class="text-center">
        <div class="d-flex flex-column align-items-center p-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="80" height="80" class="text-gray-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75a2.25 2.25 0 001.125 1.946c1.55.894 4.067 1.554 7.125 1.554s5.575-.66 7.125-1.554A2.25 2.25 0 0019.5 15.75M4.5 12a2.25 2.25 0 001.125 1.946c1.55.894 4.067 1.554 7.125 1.554s5.575-.66 7.125-1.554A2.25 2.25 0 0019.5 12M4.5 8.25A2.25 2.25 0 005.625 10.2c1.55.894 4.067 1.554 7.125 1.554s5.575-.66 7.125-1.554A2.25 2.25 0 0019.5 8.25M4.5 4.5a2.25 2.25 0 001.125 1.946c1.55.894 4.067 1.554 7.125 1.554s5.575-.66 7.125-1.554A2.25 2.25 0 0019.5 4.5 2.25 2.25 0 0018.375 2.554C16.825 1.66 14.308 1 11.25 1s-5.575.66-7.125 1.554A2.25 2.25 0 004.5 4.5z" />
            </svg>
            <p class="mt-3 text-muted">Data belum tersedia.</p>
        </div>
    </td>
</tr>
@endforelse



