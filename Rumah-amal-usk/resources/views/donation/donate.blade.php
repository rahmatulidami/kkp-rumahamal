@extends('layouts.layout')

@section('title', 'Donasi | Rumah Amal USK')

@section('content')
<section>
<meta name="csrf-token" content="{{ csrf_token() }}">
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

<style>

.body {
    color: #45474B;
}
.payment {
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
.payment-category {
    border: 1px solid #e0e0e0;
    border-radius: 10px;
    margin-bottom: 10px;
    overflow: hidden;
}

.payment-content {
    display: flex;
    flex-direction: column;
}

.category-header {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    padding: 15px 15px 15px 15px;
    cursor: pointer;
    /* height: px; */
    border-radius: 10px 0 0;
    color: white;
    background-color: #45474b;
    font-weight: 450;

    .d-flex{
        img{
            height: 15px;
            margin-left: 10%;}
        width: 50%;
    }
}

.bottom-logo{
    display: flex;
    align-items: flex-end;
    justify-content: flex-end;
    background-color: white;
    border-top: 1px solid #e0e0e0;
    /* height: 50px; */
    padding: 15px;
    img{
        height: 15px;
    }
}

/* .category-logos {
    width:
} */

/* #category-label {
    font-weight: 400;
    color: rgb(69, 71, 75);
    font-size: 90%;
} */

.category-content {
    display: flex;
    flex-wrap: wrap;
    gap: 1.25em;
    display: none;
    overflow: hidden;
    transition: max-height 0.3s ease;
    padding: 0px 15px 10px 15px;
    background-color: #45474b;
    /* border-top: 1px solid #e0e0e0; */
}

.payment-method {
    background-color: white;
    width: 170px;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 10px;
    border: 1px solid rgba(69, 71, 75, 0.5);
    border-radius: 10px;
    box-shadow: 2px 4px 5px rgba(0, 0, 0, 0.1);
    cursor: pointer;
    div{
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }
    img {
        height:25px;
        margin-bottom: 10px;
    }
    span {
        font-size: 70%;
        font-weight: 400;
    }
}

.fee{
    border-bottom: 1px solid #e0e0e0;
}

.payment-method:hover,
.payment-method.selected {
    border: 4px solid #707feb;
    box-shadow: 2px 2px 10px #707feb;
}

.fa-chevron-down {
    transition: transform 0.3s;
}

.payment-category .category-content {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease-out;
}

.payment-category.active .fa-chevron-down {
    transform: rotate(180deg);
}

.payment-category.active .category-content {
    max-height: 1000px;
    /* transition: max-height 0.3s ease-in; */
}

.submit{
    background-color: #8b8f97;
    border-radius: 10px;
    color: white;
    height: 35px;
    font-weight: 600;
    font-size: 90%;
}


</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('donationForm');
    const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
    let invoiceId;

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        fetch('/donate', {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.invoice_url) {
                invoiceId = data.invoice_id;
                document.getElementById('invoiceFrame').src = data.invoice_url;
                document.getElementById('invoiceContent').style.display = 'block';
                document.getElementById('successContent').style.display = 'none';
                paymentModal.show();
                startPaymentStatusCheck();
            } else if (data.error) {
                alert(data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    });

    function startPaymentStatusCheck() {
        const checkStatusInterval = setInterval(() => {
            fetch(`/check-donation-status/${invoiceId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'PAID') {
                        clearInterval(checkStatusInterval);
                        showSuccessContent(data);
                    }
                })
                .catch(error => console.error('Error:', error));
        }, 5000); // Check every 5 seconds
    }

    function showSuccessContent(data) {
        document.getElementById('invoiceContent').style.display = 'none';
        document.getElementById('successContent').style.display = 'block';
        document.getElementById('donorName').textContent = data.name;
        document.getElementById('donationAmount').textContent = `Rp ${data.amount}`;
        document.getElementById('donationStatus').textContent = data.status;
        document.getElementById('paymentModalLabel').textContent = 'Donation Successful';
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentCategories = document.querySelectorAll('.payment-category');

    paymentCategories.forEach(category => {
        const header = category.querySelector('.category-header');
        header.addEventListener('click', () => {
            const content = category.querySelector('.category-content');
            content.style.display = content.style.display === 'none' || !content.style.display ? 'flex' : 'none';
            const icon = header.querySelector('i');
            icon.classList.toggle('fa-chevron-down');
            icon.classList.toggle('fa-chevron-up');
        });
    });

    const paymentMethods = document.querySelectorAll('.payment-method');
    paymentMethods.forEach(method => {
        method.addEventListener('click', () => {
            paymentMethods.forEach(m => m.classList.remove('selected'));
            method.classList.add('selected');
            const selectedPaymentMethod = method.getAttribute('data-method');
            document.getElementById('selected_payment_method').value = selectedPaymentMethod;
        });
    });
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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

    const checkSubmitButtonState = () => {
        const amount = parseFloat(amountInput.value) || 0;
        const selectedPaymentMethod = selectedPaymentMethodInput.value;
        const termsAccepted = termsCheckbox.checked;
        let validAmount = amount >= 1000;
        let validPayment = true;

        alfamartWarning.style.display = 'none';
        indomaretWarning.style.display = 'none';

        if (selectedPaymentMethod === 'ALFAMART' || selectedPaymentMethod === 'INDOMARET') {
            const methodConfig = pricing[selectedPaymentMethod];
            validPayment = amount >= methodConfig.min && amount <= methodConfig.max;
            if (!validPayment) {
                if (selectedPaymentMethod === 'ALFAMART') {
                    alfamartWarning.style.display = 'block';
                } else if (selectedPaymentMethod === 'INDOMARET') {
                    indomaretWarning.style.display = 'block';
                }
            }
        }

        if (selectedPaymentMethod === '') {
            validPayment = false;
            paymentMethodWarning.style.display = 'block';
        } else {
            paymentMethodWarning.style.display = 'none';
        }

        if (validAmount && validPayment && termsAccepted) {
            submitButton.disabled = false;
            submitButton.style.backgroundColor = '#fece03';
        } else {
            submitButton.disabled = true;
            submitButton.style.backgroundColor = '#8b8f97';
        }
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

        const selectedMethod = document.querySelector(`.payment-method[data-method="${methodName}"]`);
        if (selectedMethod) {
            selectedMethod.querySelector('.fee').textContent = `+Rp ${totalfee.toFixed(2)}`;
            selectedMethod.querySelector('.price').textContent = `Rp ${total.toFixed(2)}`;
        }
    };

    const updateAllPricingDetails = () => {
        paymentMethods.forEach(method => {
            const methodName = method.getAttribute('data-method');
            updatePricingDetails(methodName);
        });
    };

    paymentCategories.forEach(category => {
        const header = category.querySelector('.category-header');
        header.addEventListener('click', function() {
            const isActive = category.classList.contains('active');

            paymentCategories.forEach(cat => {
                cat.classList.remove('active');
                const content = cat.querySelector('.category-content');
                content.style.display = 'none';
            });

            if (!isActive) {
                category.classList.add('active');
                const content = category.querySelector('.category-content');
                content.style.display = 'flex';

                const methodsInCategory = category.querySelectorAll('.payment-method');
                methodsInCategory.forEach(method => {
                    const methodName = method.getAttribute('data-method');
                    updatePricingDetails(methodName);
                });
            }
        });
    });

    paymentMethods.forEach(method => {
        method.addEventListener('click', function() {
            const methodName = this.getAttribute('data-method');
            selectedPaymentMethodInput.value = methodName;

            paymentMethods.forEach(m => m.classList.remove('selected'));

            this.classList.add('selected');

            const amount = parseFloat(amountInput.value) || 0;
            let validPayment = true;
            if (methodName === 'ALFAMART' || methodName === 'INDOMARET') {
                const methodConfig = pricing[methodName];
                validPayment = amount >= methodConfig.min && amount <= methodConfig.max;
                if (!validPayment) {
                    if (methodName === 'ALFAMART') {
                        alfamartWarning.style.display = 'block';
                    } else if (methodName === 'INDOMARET') {
                        indomaretWarning.style.display = 'block';
                    }
                } else {
                    alfamartWarning.style.display = 'none';
                    indomaretWarning.style.display = 'none';
                }
            } else {
                alfamartWarning.style.display = 'none';
                indomaretWarning.style.display = 'none';
            }

            if (validPayment) {
                updatePricingDetails(methodName);
            }
            checkSubmitButtonState();
        });
    });

    amountInput.addEventListener('input', function() {
        const amount = parseFloat(amountInput.value) || 0;
        if (amount >= 1000) {
            amountWarning.style.display = 'none';
            updateAllPricingDetails();
        } else {
            amountWarning.style.display = 'block';
            alfamartWarning.style.display = 'none';
            indomaretWarning.style.display = 'none';
        }
        checkSubmitButtonState();
    });

    termsCheckbox.addEventListener('change', checkSubmitButtonState);

    updateAllPricingDetails();
});

</script>

@endsection
