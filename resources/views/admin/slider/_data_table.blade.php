<div class="table-responsive">
    <table class="table mb-0">
        <thead class="table-light">
            <tr>
                <th>GAMBAR</th>
                <th>LINK PROMO</th>
                <th>AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sliders as $slider)
                <tr>
                    <td>
                        <img src="{{ $slider->image }}" class="me-2 thumb-md align-self-center rounded" alt="Slider Image">
                    </td>
                    <td>{{ $slider->link }}</td>
                    <td>
                        <a href="{{ route('admin.slider.edit', $slider->id) }}" class="btn btn-link p-0">
                            <i class="las la-edit text-primary fs-18"></i>
                        </a>
                        <button type="button" class="btn btn-link p-0 delete-slider" data-id="{{ $slider->id }}" data-url="{{ route('admin.slider.destroy', $slider->id) }}">
                            <i class="las la-trash-alt text-danger fs-18"></i>
                        </button>
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
        </tbody>
    </table>
    @if ($sliders->hasPages())
        <div class="bg-white p-3">{{ $sliders->links('vendor.pagination.tailwind') }}</div>
    @endif
</div>
