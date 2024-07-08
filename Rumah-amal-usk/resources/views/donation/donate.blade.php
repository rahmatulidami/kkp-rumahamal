@extends('donation.layout')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card p-4">
                <h3 class="mb-3">Pembayaran</h3>
                <p>Bayarlah zakatmu</p>
                <form method="POST" action="/donate">
                    @csrf
                    <div class="mb-3">
                        <label for="amount" class="form-label">Jumlah Donasi</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp.</span>
                            <input type="number" class="form-control" id="amount" name="amount" placeholder="Jumlah donasi yang ingin didonasikan" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama Lengkap">
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="anonymous" name="anonymous">
                        <label class="form-check-label" for="anonymous">Sembunyikan nama saya (Hamba Allah)</label>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">No Telepon</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="No Telepon" required>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="consent" name="consent">
                        <label class="form-check-label" for="consent">Bersedia di hubungi oleh <a href="#">Rumah Amal USK</a></label>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Pesan</label>
                        <textarea class="form-control" id="message" name="message" rows="3" placeholder="Tulis doa atau dukungan untuk project donasi ini"></textarea>
                    </div>
                </div>
            </div>
        <div class="col-12 col-md-6">
            <div class="card p-4">
                <h3 class="mb-3">Metode Pembayaran</h3>
                <p>Pilih metode pembayaran di bawah ini, untuk melanjutkan donasi</p>
                <div class="list-group">
                    <label class="list-group-item d-flex justify-content-between align-items-center">
                        <input class="form-check-input me-2" type="radio" name="payment_method" value="QRIS" required>
                        Pembayaran Qris
                        <img src="assets/img/qris-logo.jpg" alt="QRIS" class="img-fluid" width="50">
                    </label>
                    <label class="list-group-item d-flex justify-content-between align-items-center">
                        <input class="form-check-input me-2" type="radio" name="payment_method" value="BSI" required>
                        Virtual Account BSI
                        <img src="assets/img/bsi-logo.png" alt="BSI" class="img-fluid" width="50">
                    </label>
                    <label class="list-group-item d-flex justify-content-between align-items-center">
                        <input class="form-check-input me-2" type="radio" name="payment_method" value="BTN" required>
                        Virtual Account BTN
                        <img src="assets/img/btn-logo.png" alt="BTN" class="img-fluid" width="50">
                    </label>
                    <label class="list-group-item d-flex justify-content-between align-items-center">
                        <input class="form-check-input me-2" type="radio" name="payment_method" value="MANDIRI" required>
                        Virtual Account Mandiri
                        <img src="assets/img/mandiri-logo.png" alt="Mandiri" class="img-fluid" width="50">
                    </label>
                    <label class="list-group-item d-flex justify-content-between align-items-center">
                        <input class="form-check-input me-2" type="radio" name="payment_method" value="OVO" required>
                        OVO
                        <img src="assets/img/ovo-logo.png" alt="OVO" class="img-fluid" width="50">
                    </label>
                    <label class="list-group-item d-flex justify-content-between align-items-center">
                        <input class="form-check-input me-2" type="radio" name="payment_method" value="DANA" required>
                        DANA
                        <img src="assets/img/dana-logo.png" alt="DANA" class="img-fluid" width="50">
                    </label>
                </div>
                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                    <label class="form-check-label" for="terms">Saya setuju dengan syarat dan ketentuan yang berlaku</label>
                </div>
                <button type="submit" class="btn btn-warning w-100 mt-3">Lanjutkan Pembayaran</button>
            </div>
        </form>
    </div>
</div>
@endsection
