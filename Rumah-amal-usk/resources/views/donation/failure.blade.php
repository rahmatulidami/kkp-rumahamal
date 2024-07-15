@extends('donation.layout')

@section('content')
<div class="modal" tabindex="-1" role="dialog" id="failureModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pembayaran Gagal</h5>
      </div>
      <div class="modal-body">
        <p>Maaf, pembayaran Anda gagal. Silakan coba lagi.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="closeButton">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var failureModal = new bootstrap.Modal(document.getElementById('failureModal'));
        failureModal.show();
        
        document.getElementById('closeButton').addEventListener('click', function() {
            failureModal.hide();
            window.location.href = '/';
        });
    });
</script>
@endsection
