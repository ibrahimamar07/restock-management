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

        .payment-method {
            display: flex;
            align-items: center;
            gap: 15px;
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

        .expand-icon {
            margin-left: auto;
            color: #7dd3fc;
            font-size: 24px;
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
            <!-- Not Paid - Show Payment Button -->
            <div class="payment-section">
                <div class="payment-method">
                    <div class="payment-icon">💳</div>
                    <div class="payment-details">
                        <h3>Payment Method</h3>
                        <p>Select payment method</p>
                    </div>
                    <div class="expand-icon">▼</div>
                </div>
            </div>

            <a href="{{ route('invoices.payInvoiceView', $invoice->idInvoice) }}" class="pay-button">
                Pay Invoice
            </a>

            @if(!$isPayer)
                <form action="{{ route('invoices.cancel', $invoice->idInvoice) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this invoice?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="cancel-button">Cancel Invoice</button>
                </form>
            @endif

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
</body>
</html>