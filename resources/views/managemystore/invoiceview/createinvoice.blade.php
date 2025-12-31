 {{-- Nathaniel Lado Hadi Winata - 5026231019 --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Invoice</title>
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

        .store-info {
            background: rgba(125, 211, 252, 0.15);
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-label {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.7);
        }

        .info-value {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
        }

        .items-card {
            background: rgba(125, 211, 252, 0.15);
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #7dd3fc;
            margin-bottom: 15px;
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
            font-size: 18px;
            font-weight: 600;
            color: #2dd4bf;
        }

        .item-price {
            text-align: right;
        }

        .item-amount {
            font-size: 16px;
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

        .restock-proof {
            margin-bottom: 20px;
        }

        .restock-proof img {
            width: 100%;
            border-radius: 20px;
            display: block;
        }

        .create-button {
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

        .create-button:hover {
            background: #34e4ce;
            transform: translateY(-2px);
        }

        .error-message {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid #ef4444;
            color: #ef4444;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .warning-box {
            background: rgba(251, 146, 60, 0.15);
            border: 1px solid rgba(251, 146, 60, 0.5);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .warning-box h3 {
            color: #fb923c;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .warning-box p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="{{ url()->previous() }}" class="back-button">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M15 18l-6-6 6-6"/>
                </svg>
            </a>
            <h1 class="title">Create Invoice</h1>
        </div>

        @if(session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif

        <!-- Store Information -->
        <div class="store-info">
            <div class="info-row">
                <span class="info-label">Store Name</span>
                <span class="info-value">{{ $cart->store->storeName }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Store Owner</span>
                <span class="info-value">{{ $cart->store->user->username }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Restock Date</span>
                <span class="info-value">{{ $cart->cartDate->format('d/m/Y H:i') }}</span>
            </div>
        </div>

        <!-- Warning Box -->
        <div class="warning-box">
            <h3>⚠️ Before Creating Invoice</h3>
            <p>Once you create this invoice, it will be sent to the store owner for payment. Make sure all items and quantities are correct before proceeding.</p>
        </div>

        <!-- Items List -->
        <div class="items-card">
            <h3 class="section-title">Items to Invoice</h3>
            
            @foreach($cart->cartItems as $cartItem)
                <div class="item-row">
                    <div class="item-name">{{ $cartItem->item->itemName }}</div>
                    <div class="item-price">
                        <div class="item-amount">Rp{{ number_format($cartItem->subTotal, 2, ',', '.') }}</div>
                        <div class="item-quantity">x{{ $cartItem->quantity }}</div>
                    </div>
                </div>
            @endforeach

            <div class="total-row">
                <div class="total-label">Total {{ $cart->cartItems->sum('quantity') }} produk</div>
                <div class="total-amount">Rp{{ number_format($cart->cartItems->sum('subTotal'), 2, ',', '.') }}</div>
            </div>
        </div>

        <!-- Restock Proof -->
        @if($cart->restockProof)
            <div class="restock-proof">
                <img src="{{ asset('storage/' . $cart->restockProof) }}" alt="Restock Proof">
            </div>
        @endif

        <!-- Create Invoice Button -->
        <form action="{{ route('invoices.createInvoice', $cart->idCart) }}" method="POST" onsubmit="return confirm('Are you sure you want to create this invoice? This action cannot be undone.')">
            @csrf
            <button type="submit" class="create-button">Create Invoice</button>
        </form>
    </div>
</body>
</html>