<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->idInvoice }} - Restock Management</title>
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
            font-size: 36px;
            font-weight: 700;
            color: #7dd3fc;
            flex: 1;
            text-align: center;
            margin-right: 48px;
        }

        .items-card {
            background: rgba(125, 211, 252, 0.15);
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid rgba(125, 211, 252, 0.2);
        }

        .item-row:last-child {
            border-bottom: none;
        }

        .item-name {
            font-size: 20px;
            font-weight: 600;
            color: #2dd4bf;
        }

        .item-price {
            text-align: right;
        }

        .item-amount {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 4px;
        }

        .item-quantity {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.6);
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            margin-top: 10px;
            border-top: 2px solid rgba(125, 211, 252, 0.3);
        }

        .total-label {
            font-size: 18px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
        }

        .total-amount {
            font-size: 22px;
            font-weight: 700;
            color: #7dd3fc;
        }

        .image-section {
            margin-bottom: 20px;
            border-radius: 20px;
            overflow: hidden;
        }

        .image-section img {
            width: 100%;
            display: block;
        }

        .payment-section {
            background: rgba(125, 211, 252, 0.1);
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .payment-method-trigger {
            display: flex;
            align-items: center;
            gap: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .payment-method-trigger:hover {
            opacity: 0.8;
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
        }

        .payment-details h3 {
            font-size: 18px;
            color: #7dd3fc;
            margin-bottom: 4px;
        }

        .payment-details p {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.6);
        }

        #selectedMethodText {
            transition: all 0.3s ease;
        }

        .expand-icon {
            margin-left: auto;
            color: #7dd3fc;
            font-size: 24px;
            transition: transform 0.3s ease;
        }

        .expand-icon.rotated {
            transform: rotate(180deg);
        }

        .payment-methods-dropdown {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid rgba(125, 211, 252, 0.2);
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .payment-option {
            background: rgba(125, 211, 252, 0.05);
            border: 2px solid rgba(125, 211, 252, 0.2);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .payment-option:hover {
            background: rgba(125, 211, 252, 0.1);
            border-color: rgba(125, 211, 252, 0.4);
        }

        .payment-option.selected {
            background: rgba(45, 212, 191, 0.15);
            border-color: #2dd4bf;
        }

        .payment-radio {
            width: 20px;
            height: 20px;
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
            width: 10px;
            height: 10px;
            background: #2dd4bf;
            border-radius: 50%;
        }

        .payment-icon-small {
            width: 40px;
            height: 40px;
            background: rgba(45, 212, 191, 0.15);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .payment-info-dropdown {
            flex: 1;
        }

        .payment-name-small {
            font-size: 15px;
            font-weight: 600;
            color: #7dd3fc;
            margin-bottom: 3px;
        }

        .payment-details-small {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.6);
        }

        .pay-button {
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
            text-decoration: none;
            display: block;
            text-align: center;
        }

        .pay-button:hover {
            background: #34e4ce;
            transform: translateY(-2px);
        }

        .pay-button:disabled {
            background: rgba(45, 212, 191, 0.3);
            cursor: not-allowed;
            transform: none;
        }

        .no-payment-section {
            background: rgba(251, 146, 60, 0.1);
            border: 1px solid rgba(251, 146, 60, 0.3);
            border-radius: 15px;
            padding: 30px 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        .no-payment-section p {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 15px;
            font-size: 15px;
        }

        .add-method-button {
            display: inline-block;
            padding: 12px 24px;
            background: #fb923c;
            color: #1a1f3a;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .add-method-button:hover {
            background: #fdba74;
            transform: translateY(-2px);
        }

        .status-footer {
            text-align: center;
            padding: 30px 20px;
            font-size: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .status-footer.paid {
            color: #2dd4bf;
        }

        .status-footer.pending {
            color: #fb923c;
        }

        .status-icon-large {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .status-footer.paid .status-icon-large {
            background: rgba(45, 212, 191, 0.2);
        }

        .status-footer.pending .status-icon-large {
            background: rgba(251, 146, 60, 0.2);
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .spinner {
            animation: spin 1.5s linear infinite;
        }

        .cancel-button {
            width: 100%;
            padding: 18px;
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
            border: 2px solid #ef4444;
            border-radius: 15px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 15px;
        }

        .cancel-button:hover {
            background: rgba(239, 68, 68, 0.3);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="{{ route('invoices.index') }}" class="back-button">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M15 18l-6-6 6-6"/>
                </svg>
            </a>
            <h1 class="title">Invoice - #{{ $invoice->idInvoice }}</h1>
        </div>

        <!-- Items List -->
        <div class="items-card">
            @foreach($invoice->cart->cartItems as $cartItem)
                <div class="item-row">
                    <div class="item-name">{{ $cartItem->item->itemName }}</div>
                    <div class="item-price">
                        <div class="item-amount">Rp{{ number_format($cartItem->subTotal, 2, ',', '.') }}</div>
                        <div class="item-quantity">x{{ $cartItem->quantity }}</div>
                    </div>
                </div>
            @endforeach

            <div class="total-row">
                <div class="total-label">Total {{ $invoice->cart->cartItems->sum('quantity') }} produk</div>
                <div class="total-amount">Rp{{ number_format($invoice->totalAmount, 2, ',', '.') }}</div>
            </div>
        </div>

        <!-- Restock Proof Image -->
        @if($invoice->cart->restockProof)
            <div class="image-section">
                <img src="{{ asset('storage/restock_proof/' . $invoice->cart->restockProof) }}" alt="Restock Proof">
            </div>
        @endif

        <!-- Status-based Display -->
        @if($invoice->status === 'unpaid' && $isPayer)
            <!-- Not Paid - Show Payment Method Selection -->
            @if($paymentMethods->count() > 0)
                <form action="{{ route('invoices.processPayment', $invoice->idInvoice) }}" method="POST" id="paymentForm">
                    @csrf
                    
                    <div class="payment-section" id="paymentMethodSelector">
                        <div class="payment-method-trigger" onclick="togglePaymentMethods()">
                            <div class="payment-icon">💳</div>
                            <div class="payment-details">
                                <h3>Payment Method</h3>
                                <p id="selectedMethodText">Select payment method</p>
                            </div>
                            <div class="expand-icon" id="expandIcon">▼</div>
                        </div>

                        <div class="payment-methods-dropdown" id="paymentMethodsDropdown" style="display: none;">
                            @foreach($paymentMethods as $method)
                                <label class="payment-option" data-method="{{ $method->idUserPaymentType }}">
                                    <div class="payment-radio"></div>
                                    <div class="payment-icon-small">
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
                                    <div class="payment-info-dropdown">
                                        <div class="payment-name-small">{{ $method->paymentType->paymentName }}</div>
                                        <div class="payment-details-small">{{ $method->paymentDetails }}</div>
                                    </div>
                                    <input type="radio" name="idUserPaymentType" value="{{ $method->idUserPaymentType }}" style="display: none;" required 
                                           data-name="{{ $method->paymentType->paymentName }}" 
                                           data-details="{{ $method->paymentDetails }}">
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="pay-button" id="payButton">
                        Pay Invoice
                    </button>
                </form>

                <form action="{{ route('invoices.cancel', $invoice->idInvoice) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this invoice?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="cancel-button">Cancel Invoice</button>
                </form>
            @else
                <div class="no-payment-section">
                    <p>You don't have any payment methods set up yet.</p>
                    <a href="{{ route('addPaymentMethodView') }}" class="add-method-button">Add Payment Method</a>
                </div>
            @endif

        @elseif($invoice->status === 'unpaid' && !$isPayer)

        @elseif($invoice->status === 'unpaid' && !$isPayer)
            <!-- Pending - Waiting for Payment -->
            <div class="status-footer pending">
                <div class="status-icon-large spinner">⟳</div>
                <span>Waiting for Payment from {{ $invoice->cart->store->storeName }}</span>
            </div>

            <form action="{{ route('invoices.cancel', $invoice->idInvoice) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this invoice?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="cancel-button">Cancel Invoice</button>
            </form>

        @elseif($invoice->status === 'paid')
            <!-- Paid - Show Confirmation -->
            <div class="status-footer paid">
                <div class="status-icon-large">✓</div>
                <span>Invoice Paid</span>
            </div>
        @endif
    </div>
    <script>
        // Toggle payment methods dropdown
        function togglePaymentMethods() {
            const dropdown = document.getElementById('paymentMethodsDropdown');
            const icon = document.getElementById('expandIcon');
            
            if (dropdown.style.display === 'none' || dropdown.style.display === '') {
                dropdown.style.display = 'block';
                icon.classList.add('rotated');
            } else {
                dropdown.style.display = 'none';
                icon.classList.remove('rotated');
            }
        }

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
                
                // Update selected method text
                const methodName = radio.getAttribute('data-name');
                const methodDetails = radio.getAttribute('data-details');
                document.getElementById('selectedMethodText').textContent = methodName + ' - ' + methodDetails;
                
                // Close dropdown after selection
                document.getElementById('paymentMethodsDropdown').style.display = 'none';
                document.getElementById('expandIcon').classList.remove('rotated');
                
                // Enable pay button
                document.getElementById('payButton').disabled = false;
            });
        });

        // Form submission
        document.getElementById('paymentForm')?.addEventListener('submit', function(e) {
            const selected = document.querySelector('input[name="idUserPaymentType"]:checked');
            if (!selected) {
                e.preventDefault();
                alert('Please select a payment method');
                return false;
            }
            
            // Show loading state
            const payButton = document.getElementById('payButton');
            payButton.disabled = true;
            payButton.textContent = 'Processing...';
            
            return confirm('Are you sure you want to pay this invoice?');
        });

        // Disable pay button initially
        window.addEventListener('DOMContentLoaded', function() {
            const payButton = document.getElementById('payButton');
            if (payButton) {
                payButton.disabled = true;
            }
        });
    </script>
</body>
</html>