<!-- success.blade.php -->
@extends('donation.layout')

@section('content')
<div class="container">
    <div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-8 text-center">
            <div class="alert alert-success">
                <h3 class="alert-heading">Donasi Anda Berhasil!</h3>
                <p>Terima kasih atas donasi Anda. Semoga bermanfaat bagi yang membutuhkan.</p>
            </div>
            <lottie-player 
                src="https://lottie.host/e960d467-1d8d-413f-8bf0-063152b7a1e5/LTvUKPpKFz.json" 
                background="#FFFFFF" 
                speed="1" 
                style="width: 20%; margin: 0 auto;" 
                autoplay 
                direction="1" 
                mode="normal">
            </lottie-player>
        </div>
    </div>
</div>
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
@endsection
