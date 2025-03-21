@extends('layouts.auth', ['title' => 'Two Factor Challenge - Admin'])

@section('content')
<div class="flex justify-center items-center h-screen px-6" style="background: #f7f9fb">
    <div class="p-6 max-w-sm w-full bg-white shadow-md rounded-md" style="border-top: 3px solid #43A047">
        <div class="flex justify-center items-center">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e6/Logo_BAZNAS_RI-Hijau-01.png/1167px-Logo_BAZNAS_RI-Hijau-01.png" alt="Badan Amil Zakat Nasional" class="h-24">
        </div>
        <div class="flex justify-center items-center mt-4">
            <span class="text-gray-700 font-semibold text-2xl">TWO FACTOR CHALLENGE</span>
        </div>
        @if (session('status'))
        <div class="bg-green-500 p-3 rounded-md shadow-sm mt-3">
            {{ session('status') }}
        </div>
        @endif
        <form class="mt-4" action="{{ url('/two-factor-challenge') }}" method="POST">
            @csrf
            <label class="block">
                <span class="text-gray-700 text-sm">Code</span>
                <input type="text" name="code" value="{{ old('email') }}"
                    class="form-input mt-1 block w-full rounded-md focus:border-indigo-600" placeholder="Code">
                @error('email')
                <div class="inline-flex max-w-sm w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                    <div class="px-4 py-2">
                        <p class="text-gray-600 text-sm">{{ $message }}</p>
                    </div>
                </div>
                @enderror
            </label>

            <p class="text-gray-600">
                <i>Atau Anda dapat memasukkan salah satu recovery code.</i>
            </p>

            <label class="block mt-3">
                <span class="text-gray-700 text-sm">Recovery Code</span>
                <input type="text" name="recovery_code" class="form-input mt-1 block w-full rounded-md focus:border-indigo-600"
                    placeholder="Recovery Code">
                @error('password')
                <div class="inline-flex max-w-sm w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                    <div class="px-4 py-2">
                        <p class="text-gray-600 text-sm">{{ $message }}</p>
                    </div>
                </div>
                @enderror
            </label>

            <div class="mt-6">
                <button type="submit"
                    class="py-2 px-4 text-center bg-green-600 rounded-md w-full text-white text-sm hover:bg-green-500 focus:outline-none">
                    LOGIN
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
