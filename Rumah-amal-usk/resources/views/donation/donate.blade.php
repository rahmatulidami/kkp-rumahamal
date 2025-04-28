@extends('layouts.layout')

@section('title', 'Donasi | Rumah Amal USK')

@section('content')

<main class="main">

  <!-- Page Title -->
  <div class="page-title">
    <div class="heading">
      <div class="container">
        <div class="row d-flex justify-content-center text-center">
        </div>
      </div>
    </div>

    <nav class="breadcrumbs">
      <div class="container">
          <ol>
            <li><a href="/">Beranda</a></li>
            <li class="current">Pembayaran</li>
          </ol>
      </div>
    </nav>
  </div>
  <!-- End Page Title -->


<section id="pembayaran">
<div class="container mt-5" style="user-select: none;">
    <div class="row">
        <div class="col-12 col-lg-6 col-md-6 mb-3">
            <div class="card p-4 shadow-sm">
                <h3 class="mb-3">Pembayaran</h3>
                <p>Infaq</p>
                <form id="donationForm" method="POST" action="/donate">
                    @csrf
                    <input type="hidden" id="selected_payment_method" name="payment_method">
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
                                    <img src="assets/img/qris-logo.jpg" alt="QRIS" width="20%" class="me-1">
                                        <div class="payment-content">
                                            <span class="fee"></span>
                                            <span class="price"></span>
                                        </div>
                                </div>
                        </div>
                        <div class="bottom-logo">
                            <img src="assets/img/qris-logo.jpg" alt="QRIS" class="me-1">    
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
                                <img src="assets/img/shopeepay-logo.png" alt="SHOPEEPAY" class="me-1">
                                <div>
                                    <span>SHOPEEPAY</span>
                                    <span class="fee"></span>
                                    <span class="price"></span>
                                </div>
                            </div>
                            <div class="payment-method" data-method="DANA">
                                <img src="assets/img/dana-logo.png" alt="Dana" class="me-1">
                                <div>
                                    <span>Dana</span>
                                     <span class="fee"></span>
                                <span class="price"></span>
                                </div>
                            </div>
                            <div class="payment-method" data-method="OVO">
                                <img src="assets/img/ovo-logo.png" alt="OVO" class="me-1">
                                <div>
                                    <span>OVO</span>
                                     <span class="fee"></span>
                                <span class="price"></span>
                                </div>
                            </div>
                        </div>
                        <div class="bottom-logo">
                                <img src="assets/img/shopeepay-logo.png" alt="SHOPEEPAY" class="me-1">
                                <img src="assets/img/dana-logo.png" alt="DANA" class="me-1">
                                <img src="assets/img/ovo-logo.png" alt="OVO" class="me-1">   
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
                                <img src="assets/img/alfamart-logo.png" alt="Alfamart" class="me-1">
                                <div>
                                    <span>Alfamart</span>
                                     <span class="fee"></span>
                                <span class="price"></span>
                                </div>
                            </div>
                            <div class="payment-method" data-method="INDOMARET">
                                <img src="assets/img/indomaret-logo.png" alt="Indomaret" class="me-1">
                                <div>
                                    <span>Indomaret</span>
                                     <span class="fee"></span>
                                <span class="price"></span>
                                </div>
                            </div>
                        </div>
                        <div class="bottom-logo">
                            <img src="assets/img/alfamart-logo.png" alt="Alfamart" class="me-1">
                            <img src="assets/img/indomaret-logo.png" alt="Indomaret">
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
                                <img src="assets/img/bsi-logo.png" alt="BSI" class="me-1">
                                <div>
                                    <span>BSI</span>
                                     <span class="fee"></span>
                                <span class="price"></span>
                                </div>
                            </div>
                            <div class="payment-method" data-method="BNI">
                                <img src="assets/img/bni-logo.png" alt="BNI" class="me-1">
                                <div>
                                    <span>BNI</span>
                                    <span class="fee"></span>
                                    <span class="price"></span>
                                </div>
                            </div>
                            <div class="payment-method" data-method="MANDIRI">
                                <img src="assets/img/mandiri-logo.png" alt="Mandiri" class="me-1">
                                <div>
                                    <span>Mandiri</span>
                                    <span class="fee"></span>
                                    <span class="price"></span>
                                </div>
                            </div>
                        </div>
                        <div class="bottom-logo">
                            <img src="assets/img/bsi-logo.png" alt="BSI" class="me-1">
                            <img src="assets/img/bni-logo.png" alt="BNI" class="me-1">
                            <img src="assets/img/mandiri-logo.png" alt="Mandiri">
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
</section>
</main>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // === DOM Elements ===
    const paymentCategories = document.querySelectorAll('.payment-category');
    const paymentMethods = document.querySelectorAll('.payment-method');
    const amountInput = document.getElementById('amount');
    const selectedPaymentMethodInput = document.getElementById('selected_payment_method');
    const anonymousCheckbox = document.getElementById('anonymous');
    const termsCheckbox = document.getElementById('terms');
    const submitButton = document.querySelector('button[type="submit"]');
    const amountWarning = document.getElementById('amount-warning');
    const paymentMethodWarning = document.getElementById('payment-method-warning');
    const alfamartWarning = document.getElementById('alfamart-warning');
    const indomaretWarning = document.getElementById('indomaret-warning');

    // === Pricing Configuration ===
    const pricing = {
        QRIS: { fee: 0.007, fixed: false },
        SHOPEEPAY: { fee: 0.02, fixed: false },
        DANA: { fee: 0.015, fixed: false },
        OVO: { fee: 0.02, fixed: false },
        ALFAMART: { fee: 5000, fixed: true, min: 10000, max: 2500000 },
        INDOMARET: { fee: 7000, fixed: true, min: 10000, max: 5000000 },
        BSI: { fee: 4000, fixed: true },
        BNI: { fee: 4000, fixed: true },
        MANDIRI: { fee: 4000, fixed: true }
    };

    // === Core Functions ===
    const updatePricingDetails = (methodName) => {
        const feeConfig = pricing[methodName];
        const amount = parseFloat(amountInput.value) || 0;
        
        let fee, vat, totalfee;
        if (feeConfig.fixed) {
            fee = feeConfig.fee;
            vat = fee * 0.11;
            totalfee = fee + vat;
        } else {
            fee = amount * feeConfig.fee;
            vat = fee * 0.11;
            totalfee = fee + vat;
        }

        const methodElement = document.querySelector(`.payment-method[data-method="${methodName}"]`);
        if (methodElement) {
            methodElement.querySelector('.fee').textContent = `+Rp ${totalfee.toFixed(2)}`;
            methodElement.querySelector('.price').textContent = `Rp ${(amount + totalfee).toFixed(2)}`;
        }
    };

    const updateAllPricingDetails = () => {
        paymentMethods.forEach(method => {
            updatePricingDetails(method.getAttribute('data-method'));
        });
    };

    const validatePaymentMethod = (methodName, amount) => {
        if (methodName === 'ALFAMART' || methodName === 'INDOMARET') {
            const config = pricing[methodName];
            return amount >= config.min && amount <= config.max;
        }
        return true;
    };

    const checkSubmitButtonState = () => {
        const amount = parseFloat(amountInput.value) || 0;
        const method = selectedPaymentMethodInput.value;
        const isAmountValid = amount >= 1000;
        const isMethodValid = method && validatePaymentMethod(method, amount);
        const isTermsAccepted = termsCheckbox.checked;

        // Update warnings
        amountWarning.style.display = isAmountValid ? 'none' : 'block';
        paymentMethodWarning.style.display = method ? 'none' : 'block';
        alfamartWarning.style.display = (method === 'ALFAMART' && !validatePaymentMethod(method, amount)) ? 'block' : 'none';
        indomaretWarning.style.display = (method === 'INDOMARET' && !validatePaymentMethod(method, amount)) ? 'block' : 'none';

        // Toggle submit button
        submitButton.disabled = !(isAmountValid && isMethodValid && isTermsAccepted);
        submitButton.style.backgroundColor = submitButton.disabled ? '#8b8f97' : '#fece03';
    };

    // === Event Handlers ===
    paymentCategories.forEach(category => {
        const header = category.querySelector('.category-header');
        header.addEventListener('click', () => {
            // Close all categories first
            paymentCategories.forEach(cat => {
                cat.classList.remove('active');
                cat.querySelector('.category-content').style.display = 'none';
            });
            
            // Toggle current category
            category.classList.toggle('active');
            const content = category.querySelector('.category-content');
            content.style.display = category.classList.contains('active') ? 'flex' : 'none';
            
            // Update icons
            const icon = header.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-chevron-down');
                icon.classList.toggle('fa-chevron-up');
            }
        });
    });

    paymentMethods.forEach(method => {
        method.addEventListener('click', function() {
            // Update selected method
            paymentMethods.forEach(m => m.classList.remove('selected'));
            this.classList.add('selected');
            
            const methodName = this.getAttribute('data-method');
            selectedPaymentMethodInput.value = methodName;
            
            // Update pricing and validate
            updatePricingDetails(methodName);
            checkSubmitButtonState();
        });
    });

    amountInput.addEventListener('input', () => {
        updateAllPricingDetails();
        checkSubmitButtonState();
    });

    termsCheckbox.addEventListener('change', checkSubmitButtonState);

    if (anonymousCheckbox) {
        anonymousCheckbox.addEventListener('change', function() {
            const nameInput = document.getElementById('name');
            nameInput.value = this.checked ? 'Hamba Allah' : '';
            nameInput.disabled = this.checked;
        });
    }

    // === Initialization ===
    updateAllPricingDetails();
    checkSubmitButtonState();
});
</script>
@endpush