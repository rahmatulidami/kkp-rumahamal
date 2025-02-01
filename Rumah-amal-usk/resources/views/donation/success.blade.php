@extends('donation.layout')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="display-4">Pembayaran Berhasil</h1>
            <p class="lead">Terima kasih atas donasi Anda!</p>
            <lottie-player
                src="https://lottie.host/e960d467-1d8d-413f-8bf0-063152b7a1e5/LTvUKPpKFz.json"
                background="#FFFFFF"
                speed="1"
                style="width: 50%; margin: 0 auto;"
                autoplay
                direction="1"
                mode="normal">
            </lottie-player>
            <a href="/" class="btn btn-primary mt-4">Kembali ke Beranda</a>
        </div>
    </div>
</div>

<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
@endsection
