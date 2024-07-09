@extends('donation.layout')

@section('content')
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
                        <label for="pre-amount" class="form-label">Jumlah Donasi</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp.</span>
                            <input type="number" class="form-control" id="pre-amount" name="pre-amount" placeholder="Jumlah donasi yang ingin didonasikan" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="number" class="form-control" style="display: none;" id="amount" name="amount" placeholder="Jumlah donasi yang ingin didonasikan" required>
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
                <h3 class="mb-3">Metode Pembayaran</h3>
                <p>Pilih kategori metode pembayaran di bawah ini untuk melanjutkan donasi</p>
                <div class="list-group" id="payment-categories">
                    <button class="list-group-item list-group-item-action" data-category="qris">QRIS</button>
                    <button class="list-group-item list-group-item-action" data-category="ewallet">E-Wallet</button>
                    <button class="list-group-item list-group-item-action" data-category="convenience-store">Convenience Store</button>
                    <button class="list-group-item list-group-item-action" data-category="virtual-account">Virtual Account</button>
                </div>
                <div id="payment-methods" class="mt-3">
                    <div class="payment-category d-none" data-category="qris">
                        <label class="list-group-item d-flex justify-content-between align-items-center payment-method">
                            <div class="payment-label"><span>QRIS</span></div>
                            <img src="assets/img/qris-logo.jpg" alt="QRIS" class="img-fluid" width="50">
                            <input type="radio" name="payment_method" value="QRIS" class="d-none">
                        </label>
                    </div>
                    <div class="payment-category d-none" data-category="ewallet">
                        @foreach(['GoPay', 'Dana', 'OVO'] as $method)
                        <label class="list-group-item d-flex justify-content-between align-items-center payment-method">
                            <div class="payment-label"><span>{{ $method }}</span></div>
                            <img src="assets/img/{{ strtolower($method) }}-logo.png" alt="{{ $method }}" class="img-fluid" width="50">
                            <input type="radio" name="payment_method" value="{{ $method }}" class="d-none">
                        </label>
                        @endforeach
                    </div>
                    <div class="payment-category d-none" data-category="convenience-store">
                        @foreach(['Alfamart', 'Indomaret'] as $method)
                        <label class="list-group-item d-flex justify-content-between align-items-center payment-method">
                            <div class="payment-label"><span>{{ $method }}</span></div>
                            <img src="assets/img/{{ strtolower($method) }}-logo.png" alt="{{ $method }}" class="img-fluid" width="50">
                            <input type="radio" name="payment_method" value="{{ $method }}" class="d-none">
                        </label>
                        @endforeach
                    </div>
                    <div class="payment-category d-none" data-category="virtual-account">
                        @foreach(['BSI', 'BNI', 'MANDIRI'] as $method)
                        <label class="list-group-item d-flex justify-content-between align-items-center payment-method">
                            <div class="payment-label"><span>{{ $method }}</span></div>
                            <img src="assets/img/{{ strtolower($method) }}-logo.png" alt="{{ $method }}" class="img-fluid" width="50">
                            <input type="radio" name="payment_method" value="{{ $method }}" class="d-none">
                        </label>
                        @endforeach
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const paymentCategories = document.querySelectorAll('#payment-categories .list-group-item');
    const paymentMethods = document.querySelectorAll('.payment-method');
    const paymentDetails = document.getElementById('payment-details');
    const amountInput = document.getElementById('pre-amount');
    const paymentCategoryDivs = document.querySelectorAll('.payment-category');
    const selectedPaymentMethodInput = document.getElementById('selected_payment_method');
    const pricing = {
        QRIS: 0.007,
        GoPay: 0.02,
        Dana: 0.015,
        OVO: 0.02,
        Alfamart: 0.01,
        Indomaret: 0.01,
        BSI: 0.0025,
        BNI: 0.0025,
        MANDIRI: 0.0025
    };
    const anonymousCheckbox = document.getElementById('anonymous');
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
        category.addEventListener('click', function() {
            const selectedCategory = this.getAttribute('data-category');
            paymentCategoryDivs.forEach(div => {
                if (div.getAttribute('data-category') === selectedCategory) {
                    div.classList.remove('d-none');
                } else {
                    div.classList.add('d-none');
                }
            });
        });
    });

    const updatePricingDetails = (methodName) => {
        const feePercentage = pricing[methodName];
        const amount = parseFloat(amountInput.value) || 0;
        const fee = amount * feePercentage;
        const total = amount + fee;
        const detailsDiv = paymentDetails.querySelector(`.payment-details-${methodName}`);
        if (detailsDiv) {
            detailsDiv.innerHTML = `
                <p>Biaya Transaksi: Rp${fee.toFixed(2)}</p>
                <p>Total Pembayaran: Rp${total.toFixed(2)}</p>
            `;
        }
        document.getElementById('amount').value = total;
    };

    paymentMethods.forEach(method => {
        method.addEventListener('click', function() {
            paymentMethods.forEach(m => m.classList.remove('selected'));
            this.classList.add('selected');
            const methodName = this.querySelector('.payment-label span').innerText;
            selectedPaymentMethodInput.value = methodName;  // Update hidden input value
            const methodInput = this.querySelector('input[name="payment_method"]');
            methodInput.checked = true;

            let detailsDiv = paymentDetails.querySelector(`.payment-details-${methodName}`);
            if (!detailsDiv) {
                detailsDiv = document.createElement('div');
                detailsDiv.classList.add(`payment-details-${methodName}`);
                paymentDetails.appendChild(detailsDiv);
            }
            paymentDetails.querySelectorAll('div').forEach(div => div.classList.add('d-none'));
            detailsDiv.classList.remove('d-none');
            updatePricingDetails(methodName);
        });
    });

    amountInput.addEventListener('input', function() {
        const selectedMethod = document.querySelector('.payment-method.selected');
        if (selectedMethod) {
            const methodName = selectedMethod.querySelector('.payment-label span').innerText;
            updatePricingDetails(methodName);
        }
    });
});

</script>

<style>
    .payment-method {
        cursor: pointer;
        border: 2px solid transparent;
        transition: border 0.3s, box-shadow 0.3s;
    }
    .payment-method.selected {
        border: 2px solid #007bff;
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
    }
    .payment-details div {
        display: none;
    }
</style>
@endsection
