@extends('layouts.layout')

@section('title', 'Donasi Berhasil | Rumah Amal USK')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Donasi Berhasil!</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 64px;"></i>
                    </div>
                    <h5 class="card-title text-center">Terima Kasih atas Donasi Anda</h5>
                    <p class="card-text text-center">
                        Donasi Anda telah berhasil diproses. Kami sangat menghargai kebaikan dan dukungan Anda.
                    </p>
                    <p class="card-text text-center">
                        Nomor referensi donasi Anda: <strong>#{{ rand(100000, 999999) }}</strong>
                    </p>
                    <div class="text-center mt-4">
                        <a href="/" class="btn btn-primary">Kembali ke Beranda</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
