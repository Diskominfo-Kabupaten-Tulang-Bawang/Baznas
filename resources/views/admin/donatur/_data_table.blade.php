<div id="donatur-table">
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
                <td colspan="5" class="text-center">
                    <div class="d-flex flex-column align-items-center p-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="80" height="80" class="text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75a2.25 2.25 0 001.125 1.946c1.55.894 4.067 1.554 7.125 1.554s5.575-.66 7.125-1.554A2.25 2.25 0 0019.5 15.75M4.5 12a2.25 2.25 0 001.125 1.946c1.55.894 4.067 1.554 7.125 1.554s5.575-.66 7.125-1.554A2.25 2.25 0 0019.5 12M4.5 8.25A2.25 2.25 0 005.625 10.2c1.55.894 4.067 1.554 7.125 1.554s5.575-.66 7.125-1.554A2.25 2.25 0 0019.5 8.25M4.5 4.5a2.25 2.25 0 001.125 1.946c1.55.894 4.067 1.554 7.125 1.554s5.575-.66 7.125-1.554A2.25 2.25 0 0019.5 4.5 2.25 2.25 0 0018.375 2.554C16.825 1.66 14.308 1 11.25 1s-5.575.66-7.125 1.554A2.25 2.25 0 004.5 4.5z" />
                        </svg>
                        <p class="mt-3 text-muted">Data belum tersedia.</p>
                    </div>
                </td>
            @endforelse
        </tbody>
    </table>

    @if ($donaturs->hasPages())
        <div class="bg-white p-3">
            {{ $donaturs->links('vendor.pagination.tailwind') }}
        </div>
    @endif
</div>
