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

    <td>
        <span class="badge bg-{{ $donation->status == 'success' ? 'success' : ($donation->status == 'pending' ? 'warning' : 'danger') }}">
            {{ ucfirst($donation->status) }}
        </span>
    </td>
    <td>
        <a href="#" class="edit-button"  id="" data-bs-toggle="modal" onclick="updateDonasi(this)" data-bs-target="#editModal"
            data-id="{{ $donation->id }}" data-invoice="{{ $donation->invoice }}" data-campaign_id="{{ $donation->campaign_id }}"
            data-donatur_id="{{ $donation->donatur_id }}" data-amount="{{ $donation->amount }}" data-pray="{{ $donation->pray }}"
            data-status="{{ $donation->status }}">
            <i class="las la-pen text-secondary fs-18"></i>
        </a>
        <button class="delete-donation border-0 bg-transparent" onclick="hapusDonasi({{$donation->id}})">
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


