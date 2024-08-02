
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


