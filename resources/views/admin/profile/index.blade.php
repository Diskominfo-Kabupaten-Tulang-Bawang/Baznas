@extends('layouts.app', ['title' => 'Dashboard - Admin'])

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-300">

                <div class="container-xxl">
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
                                    <div class="form-group mb-3 row">
                                        <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Nama</label>
                                        <div class="col-lg-9 col-xl-8">
                                            <input class="form-control" type="text" value="Rosa">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3 row">
                                        <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Alamat Email</label>
                                        <div class="col-lg-9 col-xl-8">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="las la-at"></i></span>
                                                <input type="text" class="form-control" value="rosa.dodson@demo.com" placeholder="Email" aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-9 col-xl-8 offset-lg-3">
                                            <button type="submit" class="btn btn-primary">Kirim</button>
                                            <button type="button" class="btn btn-danger">Batal</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- TWO-FACTOR AUTHENTICATION -->
                        <div class="col-md-6 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h4 class="card-title">TWO-FACTOR AUTHENTICATION</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="form-group row">
                                        <div class="col-lg-9 col-xl-8 offset-lg-3">
                                            <button type="submit" class="btn btn-primary">Verifikasi TWO Factor Auth</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Ubah Kata Sandi -->
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Ubah Kata Sandi</h4>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="form-group mb-3 row">
                                        <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Kata Sandi Saat Ini</label>
                                        <div class="col-lg-9 col-xl-8">
                                            <input class="form-control" type="password" placeholder="Kata Sandi">
                                            <a href="#" class="text-primary font-12">Lupa kata sandi?</a>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3 row">
                                        <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Kata Sandi Baru</label>
                                        <div class="col-lg-9 col-xl-8">
                                            <input class="form-control" type="password" placeholder="Kata Sandi Baru">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3 row">
                                        <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Konfirmasi Kata Sandi</label>
                                        <div class="col-lg-9 col-xl-8">
                                            <input class="form-control" type="password" placeholder="Ulangi Kata Sandi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-9 col-xl-8 offset-lg-3">
                                            <button type="submit" class="btn btn-primary">Ubah Kata Sandi</button>
                                            <button type="button" class="btn btn-danger">Batal</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

</main>
@endsection
