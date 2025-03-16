@extends('layouts.app', ['title' => 'Dashboard - Admin'])

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-300">
    <div class="container">
        <div class="container-xxl">
            @if (session('status'))
            <div class="bg-green-500 p-3 rounded-md shadow-sm mt-3">
                @if (session('status')=='profile-information-updated')
                Profile has been updated.
                @endif
                @if (session('status')=='password-updated')
                Password has been updated.
                @endif
                @if (session('status')=='two-factor-authentication-disabled')
                Two factor authentication disabled.
                @endif
                @if (session('status')=='two-factor-authentication-enabled')
                Two factor authentication enabled.
                @endif
                @if (session('status')=='recovery-codes-generated')
                Recovery codes generated.
                @endif
            </div>
            @endif

            <div class="row justify-content-center">
                <!-- Informasi Profil -->
                <div class="col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="card-title">Informasi Profil</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <form action="{{ route('user-profile-information.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group mb-3 row">
                                    <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Nama</label>
                                    <div class="col-lg-9 col-xl-8">
                                        <input class="form-control" type="text" name="name" value="{{ old('name') ?? auth()->user()->name }}">
                                        @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Alamat Email</label>
                                    <div class="col-lg-9 col-xl-8">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="las la-at"></i></span>
                                            <input type="email" class="form-control" name="email" value="{{ old('email') ?? auth()->user()->email }}" placeholder="Email" aria-describedby="basic-addon1">
                                        </div>
                                        @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-9 col-xl-8 offset-lg-3">
                                        <button type="submit" class="btn btn-primary">Kirim</button>
                                        <button type="button" class="btn btn-danger">Batal</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- TWO-FACTOR AUTHENTICATION -->
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="card-title">TWO-FACTOR AUTHENTICATION</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
                            <div class="form-group row">
                                <div class="col-lg-9 col-xl-8 offset-lg-3">
                                    @if(! auth()->user()->two_factor_secret)
                                    {{-- Enable 2FA --}}
                                    <form method="POST" action="{{ url('user/two-factor-authentication') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Enable Two-Factor</button>
                                    </form>
                                    @else
                                    {{-- Disable 2FA --}}
                                    <form method="POST" action="{{ url('user/two-factor-authentication') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Disable Two-Factor</button>
                                    </form>

                                    @if(session('status') == 'two-factor-authentication-enabled')
                                    {{-- Show SVG QR Code, After Enabling 2FA --}}
                                    <div class="mt-4">
                                        Otentikasi dua faktor sekarang diaktifkan. Pindai kode QR berikut menggunakan aplikasi pengautentikasi ponsel Anda.
                                    </div>
                                    <div class="mb-3 mt-4">
                                        {!! auth()->user()->twoFactorQrCodeSvg() !!}
                                    </div>
                                    @endif

                                    {{-- Show 2FA Recovery Codes --}}
                                    <div class="mt-4">
                                        Simpan recovery code ini dengan aman. Ini dapat digunakan untuk memulihkan akses ke akun Anda jika perangkat otentikasi dua faktor Anda hilang.
                                    </div>
                                    <div style="background: rgb(44, 44, 44);color:white" class="rounded p-3 mb-2 mt-4">
                                        @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                                        <div>{{ $code }}</div>
                                        @endforeach
                                    </div>

                                    {{-- Regenerate 2FA Recovery Codes --}}
                                    <form method="POST" action="{{ url('user/two-factor-recovery-codes') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-secondary mt-4">Regenerate Recovery Codes</button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!-- TWO-FACTOR AUTHENTICATION -->
                </div>
            <!-- Informasi Profil dan Ubah Kata Sandi -->
            <div class="col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Ubah Kata Sandi</h4>
                    </div>
                    <div class="card-body pt-0">
                        <form action="{{ route('user-password.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-3 row">
                                <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Kata Sandi Saat Ini</label>
                                <div class="col
                                    <input class="form-control" type="password" name="current_password" placeholder="Kata Sandi">
                                    <a href="#" class="text-primary font-12">Lupa kata sandi?</a>
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Kata Sandi Baru</label>
                                <div class="col-lg-9 col-xl-8">
                                    <input class="form-control" type="password" name="password" placeholder="Kata Sandi Baru">
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Konfirmasi Kata Sandi</label>
                                <div class="col-lg-9 col-xl-8">
                                    <input class="form-control" type="password" name="password_confirmation" placeholder="Ulangi Kata Sandi">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-9 col-xl-8 offset-lg-3">
                                    <button type="submit" class="btn btn-primary">Ubah Kata Sandi</button>
                                    <button type="button" class="btn btn-danger">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
</main>
@endsection
