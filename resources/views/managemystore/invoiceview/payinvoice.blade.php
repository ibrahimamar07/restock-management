{{-- nathaniel lado hadi winata 5026231019 --}}
{{-- PAY INVOICE --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(180deg, #1a2847 0%, #0d1829 100%);
            min-height: 100vh;
            color: white;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            padding-bottom: 120px;
        }

        .back-btn {
            width: 40px;
            height: 40px;
            border: 2px solid #5dd9e8;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #5dd9e8;
            text-decoration: none;
            font-size: 20px;
            transition: all 0.3s;
        }

        .back-btn:hover {
            background: #5dd9e8;
            color: #0d1829;
        }

        .page-header {
            padding: 20px;
            margin-bottom: 10px;
        }

        .page-title {
            font-size: 32px;
            font-weight: 700;
            color: white;
            margin-bottom: 5px;
        }

        .invoice-number {
            font-size: 16px;
            color: #5dd9e8;
            font-weight: 600;
        }

        .section-card {
            background: #1e3a5f;
            border-radius: 20px;
            padding: 20px;
            margin: 0 20px 20px;
        }

        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: white;
            margin-bottom: 15px;
        }

        .amount-display {
            background: linear-gradient(135deg, #1a7a8a 0%, #156873 100%);
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            margin-bottom: 20px;
        }

        .amount-label {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 8px;
        }

        .amount-value {
            font-size: 36px;
            font-weight: 700;
            color: white;
        }

        .payment-method-option {
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid transparent;
            border-radius: 15px;
            padding: 15px;
            margin-bottom: 12px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .payment-method-option:hover {
            background: rgba(255, 255, 255, 0.08);
        }

        .payment-method-option.selected {
            border-color: #5dd9e8;
            background: rgba(93, 217, 232, 0.1);
        }

        .payment-icon {
            width: 50px;
            height: 50px;
            background: #5dd9e8;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #0d1829;
            flex-shrink: 0;
        }

        .payment-icon.gopay {
            background: #00AED6;
        }

        .payment-icon.ovo {
            background: #4C3494;
        }

        .payment-icon.dana {
            background: #118EEA;
        }

        .payment-icon.bank {
            background: #DC143C;
        }

        .payment-info {
            flex: 1;
        }

        .payment-name {
            font-size: 16px;
            font-weight: 600;
            color: white;
            margin-bottom: 3px;
        }

        .payment-desc {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.5);
        }

        .payment-radio {
            width: 24px;
            height: 24px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            position: relative;
            flex-shrink: 0;
        }

        .payment-method-option.selected .payment-radio {
            border-color: #5dd9e8;
        }

        .payment-method-option.selected .payment-radio::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 12px;
            height: 12px;
            background: #5dd9e8;
            border-radius: 50%;
        }

        .payment-details-section {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .payment-details-section.show {
            max-height: 500px;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-label {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 8px;
            display: block;
        }

        .input-field {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 12px 15px;
            color: white;
            font-size: 15px;
            transition: all 0.3s;
        }

        .input-field:focus {
            outline: none;
            border-color: #5dd9e8;
            background: rgba(255, 255, 255, 0.08);
        }

        .input-field::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .order-summary {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 15px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            font-size: 14px;
        }

        .summary-label {
            color: rgba(255, 255, 255, 0.7);
        }

        .summary-value {
            color: white;
            font-weight: 600;
        }

        .summary-row.total {
            border-top: 2px solid rgba(255, 255, 255, 0.1);
            margin-top: 8px;
            padding-top: 12px;
            font-size: 16px;
        }

        .summary-row.total .summary-value {
            color: #5dd9e8;
            font-size: 20px;
            font-weight: 700;
        }

        .action-buttons {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, #0d1829 80%, transparent);
            padding: 20px;
        }

        .btn-pay {
            width: 100%;
            background: #5dd9e8;
            border: none;
            border-radius: 50px;
            padding: 18px;
            font-size: 18px;
            font-weight: 700;
            color: #0d1829;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-pay:hover {
            background: #4ac7d9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(93, 217, 232, 0.3);
        }

        .btn-pay:disabled {
            background: #6b7280;
            cursor: not-allowed;
            transform: none;
        }

        .secure-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 12px;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.5);
        }

        .secure-badge i {
            color: #4CAF50;
        }

        /* Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-content {
            background: #1e3a5f;
            border-radius: 25px;
            padding: 40px 30px;
            max-width: 400px;
            width: 90%;
            text-align: center;
        }

        .modal-icon {
            width: 80px;
            height: 80px;
            background: #4CAF50;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .modal-icon i {
            font-size: 48px;
            color: white;
        }

        .modal-title {
            font-size: 24px;
            font-weight: 700;
            color: white;
            margin-bottom: 10px;
        }

        .modal-message {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 25px;
            line-height: 1.5;
        }

        .modal-btn {
            width: 100%;
            background: #5dd9e8;
            border: none;
            border-radius: 50px;
            padding: 15px;
            font-size: 16px;
            font-weight: 700;
            color: #0d1829;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="px-3 py-3">
            <a href="#" class="back-btn" onclick="history.back(); return false;">
                <i class="bi bi-chevron-left"></i>
            </a>
        </div>

        <div class="page-header">
            <h1 class="page-title">Payment</h1>
            <p class="invoice-number">Invoice #IS002</p>
        </div>

        <!-- Amount to Pay -->
        <div class="section-card">
            <div class="amount-display">
                <div class="amount-label">Total Amount to Pay</div>
                <div class="amount-value">Rp115.000,00</div>
            </div>
        </div>

        <!-- Payment Method Selection -->
        <div class="section-card">
            <h2 class="section-title">Select Payment Method</h2>

            <!-- Gopay -->
            <div class="payment-method-option" onclick="selectPaymentMethod('gopay', this)">
                <div class="payment-icon gopay">
                    <i class="bi bi-wallet2"></i>
                </div>
                <div class="payment-info">
                    <div class="payment-name">Gopay</div>
                    <div class="payment-desc">Pay with Gopay e-wallet</div>
                </div>
                <div class="payment-radio"></div>
            </div>

            <!-- OVO -->
            <div class="payment-method-option" onclick="selectPaymentMethod('ovo', this)">
                <div class="payment-icon ovo">
                    <i class="bi bi-wallet2"></i>
                </div>
                <div class="payment-info">
                    <div class="payment-name">OVO</div>
                    <div class="payment-desc">Pay with OVO e-wallet</div>
                </div>
                <div class="payment-radio"></div>
            </div>

            <!-- DANA -->
            <div class="payment-method-option" onclick="selectPaymentMethod('dana', this)">
                <div class="payment-icon dana">
                    <i class="bi bi-wallet2"></i>
                </div>
                <div class="payment-info">
                    <div class="payment-name">DANA</div>
                    <div class="payment-desc">Pay with DANA e-wallet</div>
                </div>
                <div class="payment-radio"></div>
            </div>

            <!-- Bank Transfer -->
            <div class="payment-method-option" onclick="selectPaymentMethod('bank', this)">
                <div class="payment-icon bank">
                    <i class="bi bi-bank"></i>
                </div>
                <div class="payment-info">
                    <div class="payment-name">Bank Transfer</div>
                    <div class="payment-desc">Transfer via Virtual Account</div>
                </div>
                <div class="payment-radio"></div>
            </div>
        </div>

        <!-- Payment Details Form (shown after selection) -->
        <div class="section-card payment-details-section" id="paymentDetails">
            <h2 class="section-title">Payment Details</h2>

            <div class="input-group">
                <label class="input-label">Phone Number</label>
                <input type="tel" class="input-field" placeholder="+62 xxx-xxxx-xxxx" id="phoneNumber">
            </div>

            <div class="input-group">
                <label class="input-label">PIN (Optional)</label>
                <input type="password" class="input-field" placeholder="Enter your PIN" maxlength="6" id="pin">
            </div>
        </div>

        <!-- Order Summary -->
        <div class="section-card">
            <h2 class="section-title">Order Summary</h2>

            <div class="order-summary">
                <div class="summary-row">
                    <span class="summary-label">Items (4)</span>
                    <span class="summary-value">Rp137.000,00</span>
                </div>

                <div class="summary-row">
                    <span class="summary-label">Discount</span>
                    <span class="summary-value">-Rp22.000,00</span>
                </div>

                <div class="summary-row">
                    <span class="summary-label">Tax</span>
                    <span class="summary-value">Rp0,00</span>
                </div>

                <div class="summary-row total">
                    <span class="summary-label">Total</span>
                    <span class="summary-value">Rp115.000,00</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button class="btn-pay" id="payBtn" disabled onclick="processPayment()">
                Confirm Payment
            </button>
            <div class="secure-badge">
                <i class="bi bi-shield-check"></i>
                <span>Secure payment with encryption</span>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal-overlay" id="successModal">
        <div class="modal-content">
            <div class="modal-icon">
                <i class="bi bi-check-lg"></i>
            </div>
            <h2 class="modal-title">Payment Successful!</h2>
            <p class="modal-message">Your payment has been processed successfully. Invoice #IS002 is now paid.</p>
            <button class="modal-btn" onclick="redirectToInvoice()">View Invoice</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let selectedPaymentMethod = null;

        function selectPaymentMethod(method, element) {
            // Remove selection from all options
            document.querySelectorAll('.payment-method-option').forEach(opt => {
                opt.classList.remove('selected');
            });

            // Add selection to clicked option
            element.classList.add('selected');
            selectedPaymentMethod = method;

            // Show payment details form
            const detailsSection = document.getElementById('paymentDetails');
            detailsSection.classList.add('show');

            // Enable pay button
            updatePayButton();
        }

        function updatePayButton() {
            const payBtn = document.getElementById('payBtn');
            const phoneNumber = document.getElementById('phoneNumber').value;

            if (selectedPaymentMethod && phoneNumber.length >= 10) {
                payBtn.disabled = false;
            } else {
                payBtn.disabled = true;
            }
        }

        // Listen for input changes
        document.getElementById('phoneNumber')?.addEventListener('input', updatePayButton);
        document.getElementById('pin')?.addEventListener('input', updatePayButton);

        function processPayment() {
            const phoneNumber = document.getElementById('phoneNumber').value;
            const pin = document.getElementById('pin').value;

            console.log('Processing payment...', {
                method: selectedPaymentMethod,
                phoneNumber: phoneNumber,
                amount: 115000
            });

            // Simulate payment processing
            const payBtn = document.getElementById('payBtn');
            payBtn.disabled = true;
            payBtn.textContent = 'Processing...';

            setTimeout(() => {
                showSuccessModal();
            }, 2000);
        }

        function showSuccessModal() {
            document.getElementById('successModal').classList.add('show');
        }

        function redirectToInvoice() {
            console.log('Redirecting to invoice detail...');
            // In real implementation, redirect to invoice detail page
            // window.location.href = '/invoice/IS002';
            alert('Redirecting to invoice detail page...');
        }
    </script>
</body>
</html>
