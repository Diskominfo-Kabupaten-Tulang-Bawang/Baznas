<table class="table mb-0" id="datatable_1">
    <thead class="table-light">
        <tr>
            <th>Judul Campaign</th>
            <th>Kategori</th>
            <th>Target Donasi</th>
            <th>Tanggal Berakhir</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @isset($campaigns)
            @forelse($campaigns as $campaign)
                <tr>
                    <td class="d-flex align-items-center">
                        <div class="d-flex align-items-center">
                            {{ $campaign->title }}
                        </div>
                    </td>
                    <td>{{ $campaign->category->name }}</td>
                    <td>{{ moneyFormat($campaign->target_donation) }}</td>
                    <td>{{ $campaign->max_date }}</td>
                    <td>
                        <a href="{{ route('admin.campaign.edit', $campaign->id) }}">
                            <i class="las la-pen text-secondary fs-18"></i>
                        </a>
                        <button class="delete-campaign border-0 bg-transparent" onclick="destroy(this)" data-id="{{ $campaign->id }}">
                            <i class="las la-trash-alt text-danger fs-18"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        <div class="d-flex flex-column align-items-center p-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="80" height="80" class="text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75a2.25 2.25 0 001.125 1.946c1.55.894 4.067 1.554 7.125 1.554s5.575-.66 7.125-1.554A2.25 2.25 0 0019.5 15.75M4.5 12a2.25 2.25 0 001.125 1.946c1.55.894 4.067 1.554 7.125 1.554s5.575-.66 7.125-1.554A2.25 2.25 0 0019.5 12M4.5 8.25A2.25 2.25 0 005.625 10.2c1.55.894 4.067 1.554 7.125 1.554s5.575-.66 7.125-1.554A2.25 2.25 0 0019.5 8.25M4.5 4.5a2.25 2.25 0 001.125 1.946c1.55.894 4.067 1.554 7.125 1.554s5.575-.66 7.125-1.554A2.25 2.25 0 0019.5 4.5 2.25 2.25 0 0018.375 2.554C16.825 1.66 14.308 1 11.25 1s-5.575.66-7.125 1.554A2.25 2.25 0 004.5 4.5z" />
                            </svg>
                            <p class="mt-3 text-muted">Data belum tersedia.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        @else
            <tr>
                <td colspan="5" class="text-center">
                    <div class="d-flex flex-column align-items-center p-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="80" height="80" class="text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75a2.25 2.25 0 001.125 1.946c1.55.894 4.067 1.554 7.125 1.554s5.575-.66 7.125-1.554A2.25 2.25 0 0019.5 15.75M4.5 12a2.25 2.25 0 001.125 1.946c1.55.894 4.067 1.554 7.125 1.554s5.575-.66 7.125-1.554A2.25 2.25 0 0019.5 12M4.5 8.25A2.25 2.25 0 005.625 10.2c1.55.894 4.067 1.554 7.125 1.554s5.575-.66 7.125-1.554A2.25 2.25 0 0019.5 8.25M4.5 4.5a2.25 2.25 0 001.125 1.946c1.55.894 4.067 1.554 7.125 1.554s5.575-.66 7.125-1.554A2.25 2.25 0 0019.5 4.5 2.25 2.25 0 0018.375 2.554C16.825 1.66 14.308 1 11.25 1s-5.575.66-7.125 1.554A2.25 2.25 0 004.5 4.5z" />
                        </svg>
                        <p class="mt-3 text-muted">Belum ada campaign.</p>
                    </div>
                </td>
            </tr>
        @endisset
    </tbody>
</table>
