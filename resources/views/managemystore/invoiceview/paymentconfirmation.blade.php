<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            max-width: 700px;
            width: 100%;
            text-align: center;
        }

        .success-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 30px;
            background: rgba(45, 212, 191, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: scaleIn 0.5s ease;
        }

        .success-icon svg {
            width: 60px;
            height: 60px;
            stroke: #2dd4bf;
            stroke-width: 3;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        h1 {
            font-size: 32px;
            color: #7dd3fc;
            margin-bottom: 15px;
            animation: fadeIn 0.5s ease 0.2s both;
        }

        .timestamp {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 40px;
            animation: fadeIn 0.5s ease 0.3s both;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .details-card {
            background: rgba(125, 211, 252, 0.15);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            animation: fadeIn 0.5s ease 0.4s both;
        }

        .amount-label {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 10px;
        }

        .amount-value {
            font-size: 42px;
            font-weight: 700;
            color: #2dd4bf;
            margin-bottom: 30px;
        }

        .ref-number {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid rgba(125, 211, 252, 0.2);
            margin-bottom: 15px;
        }

        .ref-label {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.6);
        }

        .ref-value {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
        }

        .wallet-section {
            background: rgba(125, 211, 252, 0.1);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 15px;
        }

        .wallet-title {
            font-size: 16px;
            color: #7dd3fc;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .wallet-info {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 0;
        }

        .wallet-info:first-child {
            border-bottom: 1px solid rgba(125, 211, 252, 0.2);
        }

        .avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: rgba(45, 212, 191, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .wallet-details {
            flex: 1;
            text-align: left;
        }

        .wallet-name {
            font-size: 16px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 4px;
        }

        .wallet-provider {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.6);
        }

        .wallet-number {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.5);
        }

        .done-button {
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
            animation: fadeIn 0.5s ease 0.5s both;
        }

        .done-button:hover {
            background: #34e4ce;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-icon">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M20 6L9 17L4 12" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>

        <h1>Invoice has been successfully paid!</h1>
        {{-- <p class="timestamp">{{ $invoice->payments->first()->paymentDate->format('H:i, d F Y') }}</p> --}}

        <div class="details-card">
            <div class="amount-label">Total Amount</div>
            <div class="amount-value">Rp{{ number_format($invoice->totalAmount, 2, ',', '.') }}</div>

            <div class="ref-number">
                <span class="ref-label">Ref No.</span>
                <span class="ref-value">#IS{{ str_pad($invoice->idInvoice, 4, '0', STR_PAD_LEFT) }}</span>
            </div>

            <div class="wallet-section">
                <div class="wallet-title">Source Wallet</div>
                <div class="wallet-info">
                    <div class="avatar">👤</div>
                    <div class="wallet-details">
                        <div class="wallet-name">{{ $invoice->storeOwner->username }}</div>
                        <div class="wallet-provider">{{ $invoice->payments->first()->userPaymentType->paymentType->paymentName }}</div>
                        <div class="wallet-number">{{ $invoice->payments->first()->userPaymentType->paymentDetails }}</div>
                    </div>
                </div>
            </div>

            <div class="wallet-section">
                <div class="wallet-title">Receiving Wallet</div>
                <div class="wallet-info">
                    <div class="avatar">👤</div>
                    <div class="wallet-details">
                        <div class="wallet-name">{{ $invoice->restocker->username }}</div>
                        @if($invoice->restocker->userPaymentTypes->count() > 0)
                            <div class="wallet-provider">{{ $invoice->restocker->userPaymentTypes->first()->paymentType->paymentName }}</div>
                            <div class="wallet-number">{{ $invoice->restocker->userPaymentTypes->first()->paymentDetails }}</div>
                        @else
                            <div class="wallet-provider">Payment Method</div>
                            <div class="wallet-number">Payment received</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <a href="{{ route('invoices.index') }}" class="done-button">Done</a>
    </div>
</body>
</html>