{{-- Nathaniel Lado Hadi Winata - 5026231019 --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Invoice #{{ $invoice->idInvoice }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #1a1f3a 0%, #2d3561 100%);
            min-height: 100vh;
            color: #ffffff;
            padding: 20px;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        .back-button {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #7dd3fc;
        }

        .back-button:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: scale(1.05);
        }

        .title {
            font-size: 32px;
            font-weight: 700;
            color: #7dd3fc;
            flex: 1;
            text-align: center;
            margin-right: 48px;
        }

        .invoice-summary {
            background: rgba(125, 211, 252, 0.15);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 25px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .summary-row:last-child {
            margin-bottom: 0;
            padding-top: 15px;
            border-top: 2px solid rgba(125, 211, 252, 0.3);
            margin-top: 15px;
        }

        .summary-label {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.7);
        }

        .summary-value {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.9);
        }

        .summary-row:last-child .summary-label {
            font-size: 18px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
        }

        .summary-row:last-child .summary-value {
            font-size: 22px;
            font-weight: 700;
            color: #7dd3fc;
        }

        .payment-methods {
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 15px;
        }

        .payment-option {
            background: rgba(125, 211, 252, 0.1);
            border: 2px solid rgba(125, 211, 252, 0.2);
            border-radius: 15px;
            padding: 18px;
            margin-bottom: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .payment-option:hover {
            background: rgba(125, 211, 252, 0.15);
            border-color: rgba(125, 211, 252, 0.4);
        }

        .payment-option.selected {
            background: rgba(45, 212, 191, 0.2);
            border-color: #2dd4bf;
        }

        .payment-radio {
            width: 24px;
            height: 24px;
            border: 2px solid rgba(125, 211, 252, 0.5);
            border-radius: 50%;
            position: relative;
            flex-shrink: 0;
        }

        .payment-option.selected .payment-radio {
            border-color: #2dd4bf;
        }

        .payment-option.selected .payment-radio::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 12px;
            height: 12px;
            background: #2dd4bf;
            border-radius: 50%;
        }

        .payment-icon {
            width: 48px;
            height: 48px;
            background: rgba(45, 212, 191, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
        }

        .payment-info {
            flex: 1;
        }

        .payment-name {
            font-size: 16px;
            font-weight: 600;
            color: #7dd3fc;
            margin-bottom: 4px;
        }

        .payment-details-text {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.6);
        }

        .submit-button {
            width: 100%;
            padding: 18px;
            background: #2dd4bf;
            color: #1a1f3a;
            border: none;
            border-radius: 15px;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .submit-button:hover:not(:disabled) {
            background: #34e4ce;
            transform: translateY(-2px);
        }

        .submit-button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .error-message {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid #ef4444;
            color: #ef4444;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .no-payment-methods {
            text-align: center;
            padding: 40px 20px;
            background: rgba(251, 146, 60, 0.1);
            border-radius: 15px;
            margin-bottom: 20px;
        }

        .no-payment-methods p {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 15px;
        }

        .add-method-link {
            display: inline-block;
            padding: 12px 24px;
            background: #fb923c;
            color: #1a1f3a;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .add-method-link:hover {
            background: #fdba74;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="{{ route('invoices.show', $invoice->idInvoice) }}" class="back-button">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M15 18l-6-6 6-6"/>
                </svg>
            </a>
            <h1 class="title">Pay Invoice</h1>
        </div>

        @if(session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif

        <!-- Invoice Summary -->
        <div class="invoice-summary">
            <div class="summary-row">
                <span class="summary-label">Invoice Number</span>
                <span class="summary-value">#{{ $invoice->idInvoice }}</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">From</span>
                <span class="summary-value">{{ $invoice->restocker->username }}</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Store</span>
                <span class="summary-value">{{ $invoice->cart->store->storeName }}</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Items</span>
                <span class="summary-value">{{ $invoice->cart->cartItems->sum('quantity') }} produk</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Total Amount</span>
                <span class="summary-value">Rp{{ number_format($invoice->totalAmount, 2, ',', '.') }}</span>
            </div>
        </div>

        @if($paymentMethods->count() > 0)
            <!-- Payment Methods -->
            <form action="{{ route('invoices.processPayment', $invoice->idInvoice) }}" method="POST" id="paymentForm">
                @csrf
                
                <div class="payment-methods">
                    <h3 class="section-title">Select Payment Method</h3>
                    
                    @foreach($paymentMethods as $method)
                        <label class="payment-option" data-method="{{ $method->idUserPaymentType }}">
                            <div class="payment-radio"></div>
                            <div class="payment-icon">
                                @if($method->paymentType->paymentName === 'Gopay')
                                    💳
                                @elseif($method->paymentType->paymentName === 'Bank Transfer')
                                    🏦
                                @elseif($method->paymentType->paymentName === 'E-Wallet')
                                    👛
                                @else
                                    💰
                                @endif
                            </div>
                            <div class="payment-info">
                                <div class="payment-name">{{ $method->paymentType->paymentName }}</div>
                                <div class="payment-details-text">{{ $method->paymentDetails }}</div>
                            </div>
                            <input type="radio" name="idUserPaymentType" value="{{ $method->idUserPaymentType }}" style="display: none;" required>
                        </label>
                    @endforeach
                </div>

                <button type="submit" class="submit-button" id="submitButton" disabled>
                    Confirm Payment
                </button>
            </form>
        @else
            <div class="no-payment-methods">
                <p>You don't have any payment methods set up yet.</p>
                <a href="{{ route('addPaymentMethodView') }}" class="add-method-link">Add Payment Method</a>
            </div>
        @endif
    </div>

    <script>
        // Payment method selection
        document.querySelectorAll('.payment-option').forEach(option => {
            option.addEventListener('click', function() {
                // Remove selected class from all options
                document.querySelectorAll('.payment-option').forEach(opt => {
                    opt.classList.remove('selected');
                });
                
                // Add selected class to clicked option
                this.classList.add('selected');
                
                // Check the radio button
                const radio = this.querySelector('input[type="radio"]');
                radio.checked = true;
                
                // Enable submit button
                document.getElementById('submitButton').disabled = false;
            });
        });

        // Form submission
        document.getElementById('paymentForm')?.addEventListener('submit', function(e) {
            const submitButton = document.getElementById('submitButton');
            submitButton.disabled = true;
            submitButton.textContent = 'Processing...';
        });
    </script>
</body>
</html>