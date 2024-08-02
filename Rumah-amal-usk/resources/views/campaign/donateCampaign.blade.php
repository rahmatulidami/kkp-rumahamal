@extends('layouts.layout')

@section('title', $campaign['title']['rendered'])

@section('content')
<section>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{ asset('assets/css/donate-style.css') }}" rel="stylesheet">
<script src="{{ asset('assets/js/donate-js.js') }}"></script>
<div class="container mt-5" style="user-select: none;">
    <div class="row">
        <div class="col-12 col-lg-6 col-md-6 mb-3">
            <div class="card p-4 shadow-sm">
                <div class="campaign d-flex flex-row justify-content-between">
                    <div class="d-flex column  align-items-center">
                        <h4>{{ $campaign['title']['rendered']}}
                        </h4>
                    </div>
                    <img src="{{ $campaign['image'] }}" alt="">
                </div>
                <form id="donationForm" method="POST" action="/donate">
                    @csrf
                    <input type="hidden" id="selected_payment_method" name="payment_method">
                    <input type="hidden" id="campaign_name" name="campaign_name" value="{{ $campaign['title']['rendered'] }}">
                    <div class="mb-3">
                        <label for="amount" class="form-label">Jumlah Donasi</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp.</span>
                            <input type="number" class="form-control" id="amount" name="amount" placeholder="Jumlah donasi yang ingin didonasikan" required>
                        </div>
                        <div id="amount-warning" class="text-danger" style="display: none;">Minimal donasi adalah Rp. 1000</div>
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
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
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
                    {{-- <input type="text" class="form-control" id="CampaignName" name="CampaignName" placeholder="CampaignName" value="{{ $campaign['title']['rendered']}}"> --}}
                </form>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-md-6 mb-3">
            <div class="card p-4 payment shadow-sm">
                <h3 class="mb-3 ">Pilih Metode Pembayaran</h3>
                <div id="payment-categories">
                    <!-- Payment Categories Here -->
                    <div class="payment-category" data-category="qris">
                        <div class="category-header">
                            <div id="category-label">
                                <i class="fas fa-chevron-down"></i>
                                <span>QRIS</span>
                            </div>
                        </div>
                        <div class="category-content">
                            <div class="payment-method" data-method="QRIS" required>
                                    <img src="{{asset("assets/img/qris-logo.jpg")}}" alt="QRIS" height="20%" class="me-1">
                                    {{-- <script src="{{ asset('assets/js/donate-js.js') }}"></script>     --}}
                                    <div class="payment-content">
                                            <span class="fee"></span>
                                            <span class="price"></span>
                                        </div>
                                </div>
                        </div>
                        <div class="bottom-logo">
                            <img src="{{asset("assets/img/qris-logo.jpg")}}" alt="QRIS" class="me-1">
                        </div>
                    </div>
                    <div class="payment-category" data-category="ewallet">
                        <div class="category-header">
                            <div id="category-label">
                                <i class="fas fa-chevron-down"></i>
                                <span>E-Wallet</span>
                            </div>
                        </div>
                        <div class="category-content">
                            <div class="payment-method" data-method="SHOPEEPAY">
                                <img src="{{asset("assets/img/shopeepay-logo.png")}}" alt="SHOPEEPAY" class="me-1">
                                <div>
                                    <span>SHOPEEPAY</span>
                                    <span class="fee"></span>
                                    <span class="price"></span>
                                </div>
                            </div>
                            <div class="payment-method" data-method="DANA">
                                <img src="{{asset("assets/img/dana-logo.png")}}" alt="Dana" class="me-1">
                                <div>
                                    <span>Dana</span>
                                     <span class="fee"></span>
                                <span class="price"></span>
                                </div>
                            </div>
                            <div class="payment-method" data-method="OVO">
                                <img src="{{asset("assets/img/ovo-logo.png")}}" alt="OVO" class="me-1">
                                <div>
                                    <span>OVO</span>
                                     <span class="fee"></span>
                                <span class="price"></span>
                                </div>
                            </div>
                        </div>
                        <div class="bottom-logo">
                                <img src="{{asset("assets/img/shopeepay-logo.png")}}" alt="SHOPEEPAY" class="me-1">
                                <img src="{{asset("assets/img/dana-logo.png")}}" alt="DANA" class="me-1">
                                <img src="{{asset("assets/img/ovo-logo.png")}}" alt="OVO" class="me-1">
                        </div>
                    </div>
                    <div class="payment-category" data-category="convenience-store">
                        <div class="category-header">
                            <div id="category-label">
                                <i class="fas fa-chevron-down"></i>
                                <span>Convenience Store</span>
                            </div>
                        </div>
                        <div class="category-content">
                            <div class="payment-method" data-method="ALFAMART">
                                <img src="{{asset("assets/img/alfamart-logo.png")}}" alt="Alfamart" class="me-1">
                                <div>
                                    <span>Alfamart</span>
                                     <span class="fee"></span>
                                <span class="price"></span>
                                </div>
                            </div>
                            <div class="payment-method" data-method="INDOMARET">
                                <img src="{{asset("assets/img/indomaret-logo.png")}}" alt="Indomaret" class="me-1">
                                <div>
                                    <span>Indomaret</span>
                                     <span class="fee"></span>
                                <span class="price"></span>
                                </div>
                            </div>
                        </div>
                        <div class="bottom-logo">
                            <img src="{{asset("assets/img/alfamart-logo.png")}}" alt="Alfamart" class="me-1">
                            <img src="{{asset("assets/img/indomaret-logo.png")}}" alt="Indomaret">
                        </div>
                    </div>
                    </div>
                    <div class="payment-category" data-category="virtual-account">
                        <div class="category-header">
                            <div id="category-label">
                                <i class="fas fa-chevron-down"></i>
                                <span>Virtual Account</span>
                            </div>
                        </div>
                        <div class="category-content">
                            <div class="payment-method" data-method="BSI">
                                <img src="{{asset("assets/img/bsi-logo.png")}}" alt="BSI" class="me-1">
                                <div>
                                    <span>BSI</span>
                                     <span class="fee"></span>
                                <span class="price"></span>
                                </div>
                            </div>
                            <div class="payment-method" data-method="BNI">
                                <img src="{{asset("assets/img/bni-logo.png")}}" alt="BNI" class="me-1">
                                <div>
                                    <span>BNI</span>
                                    <span class="fee"></span>
                                    <span class="price"></span>
                                </div>
                            </div>
                            <div class="payment-method" data-method="MANDIRI">
                                <img src="{{asset("assets/img/mandiri-logo.png")}}" alt="Mandiri" class="me-1">
                                <div>
                                    <span>Mandiri</span>
                                    <span class="fee"></span>
                                    <span class="price"></span>
                                </div>
                            </div>
                        </div>
                        <div class="bottom-logo">
                            <img src="{{asset("assets/img/bsi-logo.png")}}" alt="BSI" class="me-1">
                            <img src="{{asset("assets/img/bni-logo.png")}}" alt="BNI" class="me-1">
                            <img src="{{asset("assets/img/mandiri-logo.png")}}" alt="Mandiri">
                        </div>
                    </div>
                <div id="payment-details" class="mt-3"></div>
                <div id="payment-method-warning" class="text-danger" style="display: none;">Silakan pilih metode pembayaran</div>
                <div id="alfamart-warning" class="text-danger" style="display: none;">Donasi melalui Alfamart minimal Rp. 10.000</div>
                <div id="indomaret-warning" class="text-danger" style="display: none;">Donasi melalui Indomaret minimal Rp. 10.000</div>
                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                    <label class="form-check-label" for="terms">Saya setuju dengan syarat dan ketentuan yang berlaku</label>
                </div>
                <button type="submit" class="submit" form="donationForm" disabled>Lanjutkan Pembayaran</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="invoiceContent">
                    <iframe id="invoiceFrame" width="100%" height="600px" frameborder="0"></iframe>
                </div>
                <div id="successContent" style="display: none;">
                    <h4>Donasi mu berhasil dilakukan</h4>
                    <p>Nama pendonasi: <span id="donorName"></span></p>
                    <p>Jumlah: <span id="donationAmount"></span></p>
                    <p>Status: <span id="donationStatus"></span></p>
                    <p>Terima kasih sudah berdonasi!</p>
                </div>
            </div>
        </div>
    </div>
</div>

</section>


@endsection
