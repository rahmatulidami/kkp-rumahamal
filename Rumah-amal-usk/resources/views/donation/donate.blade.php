@extends('layouts.layout')

@section('title', 'Donasi')

@section('content')
<section>
<div class="container mt-5">
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card p-4">
                <h3 class="mb-3">Pembayaran</h3>
                <p>Bayarlah zakatmu</p>
                <form id="donationForm" method="POST" action="/donate">
                    @csrf
                    <input type="hidden" id="selected_payment_method" name="payment_method">
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
                </form>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card p-4">
                <h3 class="mb-3">Pilih Pembayaran</h3>
                <div id="payment-categories">
                    <div class="payment-category" data-category="qris">
                        <div class="category-header">
                            <img src="assets/img/qris-logo.jpg" alt="QRIS" width="20%" class="category-logo">
                            <div>
                                <i class="fas fa-chevron-down"></i>
                                <span>QRIS</span>
                            </div>
                        </div>
                        <div class="category-content">
                            <div class="payment-method" data-method="QRIS">
                                <img src="assets/img/qris-logo.jpg" alt="QRIS" width="20%" class="category-logo">
                                <div>
                                    <i class="fas fa-chevron-down"></i>
                                    <span>QRIS</span>
                                </div>
                                <span class="price"></span>
                            </div>
                        </div>
                    </div>
                    <div class="payment-category" data-category="ewallet">
                        <div class="category-header">
                            <span>E-Wallet</span>
                            <div class="category-logos">
                                <img src="assets/img/gopay-logo.png" alt="GoPay">
                                <img src="assets/img/dana-logo.png" alt="DANA">
                                <img src="assets/img/ovo-logo.png" alt="OVO">
                            </div>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="category-content">
                            <div class="payment-method" data-method="GOPAY">
                                <span>GoPay</span>
                                <span class="price"></span>
                            </div>
                            <div class="payment-method" data-method="DANA">
                                <span>DANA</span>
                                <span class="price"></span>
                            </div>
                            <div class="payment-method" data-method="OVO">
                                <span>OVO</span>
                                <span class="price"></span>
                            </div>
                        </div>
                    </div>
                    <div class="payment-category" data-category="convenience-store">
                        <div class="category-header">
                            <span>Convenience Store</span>
                            <div class="category-logos">
                                <img src="assets/img/alfamart-logo.png" alt="Alfamart">
                                <img src="assets/img/indomaret-logo.png" alt="Indomaret">
                            </div>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="category-content">
                            <div class="payment-method" data-method="ALFAMART">
                                <span>Alfamart</span>
                                <span class="price"></span>
                            </div>
                            <div class="payment-method" data-method="INDOMARET">
                                <span>Indomaret</span>
                                <span class="price"></span>
                            </div>
                        </div>
                    </div>
                    <div class="payment-category" data-category="virtual-account">
                        <div class="category-header">
                            <span>Virtual Account</span>
                            <div class="category-logos">
                                <img src="assets/img/bsi-logo.png" alt="BSI">
                                <img src="assets/img/bni-logo.png" alt="BNI">
                                <img src="assets/img/mandiri-logo.png" alt="Mandiri">
                            </div>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="category-content">
                            <div class="payment-method" data-method="BSI">
                                <span>BSI</span>
                                <span class="price"></span>
                            </div>
                            <div class="payment-method" data-method="BNI">
                                <span>BNI</span>
                                <span class="price"></span>
                            </div>
                            <div class="payment-method" data-method="MANDIRI">
                                <span>Mandiri</span>
                                <span class="price"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="payment-details" class="mt-3"></div>
                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                    <label class="form-check-label" for="terms">Saya setuju dengan syarat dan ketentuan yang berlaku</label>
                </div>
                <button type="submit" class="btn btn-warning w-100 mt-3" form="donationForm">Lanjutkan Pembayaran</button>
            </div>
        </div>
    </div>
</div>
</section>

<style>
.payment-category {
    border: 1px solid #e0e0e0;
    border-radius: 10px;
    margin-bottom: 10px;
    overflow: hidden;
}

.category-header {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    padding: 15px;
    background-color: #f8f9fa;
    cursor: pointer;
}

.category-logos {
    display: flex;
    align-items: center;
}

.category-logos img {
    height: 20px;
    margin-right: 5px;
}

.category-content {
    display: grid;
  grid-template-columns: auto auto auto auto;
  grid-gap: 10px;
  background-color: #2196F3;
  padding: 10px;
}

.payment-method {
    display: flex;
    justify-content: space-between;
    padding: 10px 15px;
    border-top: 1px solid #e0e0e0;
    cursor: pointer;
}

.payment-method:hover {
    background-color: #f8f9fa;
}

.payment-method.selected {
    background-color: #e9ecef;
}

.price {
    font-weight: bold;
}

.fa-chevron-down {
    transition: transform 0.3s;
}

.payment-category.active .fa-chevron-down {
    transform: rotate(180deg);
}

.payment-category.active .category-content {
    max-height: 1000px;
    transition: max-height 0.3s ease-in;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentCategories = document.querySelectorAll('.payment-category');
    const paymentMethods = document.querySelectorAll('.payment-method');
    const paymentDetails = document.getElementById('payment-details');
    const amountInput = document.getElementById('amount');
    const selectedPaymentMethodInput = document.getElementById('selected_payment_method');
    const anonymousCheckbox = document.getElementById('anonymous');
    const pricing = {
        QRIS: { fee: 0.007, fixed: false },
        GOPAY: { fee: 0.02, fixed: false },
        DANA: { fee: 0.015, fixed: false },
        OVO: { fee: 0.02, fixed: false },
        ALFAMART: { fee: 5000, fixed: true },
        INDOMARET: { fee: 7000, fixed: true },
        BSI: { fee: 4000, fixed: true },
        BNI: { fee: 4000, fixed: true },
        MANDIRI: { fee: 4000, fixed: true }
    };

    if (anonymousCheckbox) {
        anonymousCheckbox.addEventListener('change', function() {
            const nameInput = document.getElementById('name');
            if (this.checked) {
                nameInput.value = 'Hamba Allah';
                nameInput.disabled = true;
            } else {
                nameInput.value = '';
                nameInput.disabled = false;
            }
        });
    }

    paymentCategories.forEach(category => {
        const header = category.querySelector('.category-header');
        header.addEventListener('click', function() {
            const isActive = category.classList.contains('active');
            
            // Close all categories
            paymentCategories.forEach(cat => {
                cat.classList.remove('active');
            });

            // If the clicked category wasn't active, open it
            if (!isActive) {
                category.classList.add('active');
            }
        });
    });

    const updatePricingDetails = (methodName) => {
        const feeConfig = pricing[methodName];
        const amount = parseFloat(amountInput.value) || 0;
        let fee, vat, totalfee, total;

        if (feeConfig.fixed) {
            fee = feeConfig.fee;
            vat = 0.11 * fee;
            totalfee = fee + vat;
            total = amount + totalfee;
        } else {
            fee = amount * feeConfig.fee;
            vat = 0.11 * fee;
            totalfee = fee + vat;
            total = amount + totalfee;
        }

        // paymentDetails.innerHTML = `
        //     <p>Biaya Transaksi: Rp${fee.toFixed(2)}</p>
        //     <p>VAT: Rp${vat.toFixed(2)}</p>
        //     <p>Total Pembayaran: Rp${total.toFixed(2)}</p>
        // `;

        // Update price on the payment method
        const selectedMethod = document.querySelector(`.payment-method[data-method="${methodName}"]`);
        if (selectedMethod) {
            selectedMethod.querySelector('.price').textContent = `Total: Rp${amount.toFixed(2)} + Rp${totalfee.toFixed(2)} = Rp${total.toFixed(2)}`;
            // selectedMethod.querySelector('.price').textContent = `Pajak: Rp${totalfee.toFixed(2)}`;
        }
    };

    paymentMethods.forEach(method => {
        method.addEventListener('click', function() {
            const methodName = this.getAttribute('data-method');
            selectedPaymentMethodInput.value = methodName;
            
            // Remove selection from all methods
            paymentMethods.forEach(m => m.classList.remove('selected'));
            
            // Add selection to clicked method
            this.classList.add('selected');

            updatePricingDetails(methodName);
        });
    });

    amountInput.addEventListener('input', function() {
        const selectedMethod = document.querySelector('.payment-method.selected');
        if (selectedMethod) {
            const methodName = selectedMethod.getAttribute('data-method');
            updatePricingDetails(methodName);
        }
    });
});
</script>
@endsection