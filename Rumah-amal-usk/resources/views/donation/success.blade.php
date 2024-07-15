@extends('donation.layout')

@section('content')
<div class="modal" tabindex="-1" role="dialog" id="successModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pembayaran Berhasil</h5>
      </div>
      <div class="modal-body">
        <p>Terima kasih atas donasi Anda!</p>
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
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="closeButton">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
        
        document.getElementById('closeButton').addEventListener('click', function() {
            successModal.hide();
            window.location.href = '/';
        });
    });
</script>
@endsection
