<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoices - Restock Management</title>
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
            font-size: 42px;
            font-weight: 700;
            color: #7dd3fc;
            text-align: center;
            flex: 1;
            margin-right: 48px;
        }

        .tabs {
            display: flex;
            gap: 0;
            margin-bottom: 30px;
            border-bottom: 2px solid rgba(125, 211, 252, 0.3);
        }

        .tab {
            flex: 1;
            padding: 15px 0;
            text-align: center;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.6);
            transition: all 0.3s ease;
            position: relative;
        }

        .tab.active {
            color: #7dd3fc;
        }

        .tab.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 2px;
            background: #7dd3fc;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .invoice-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .invoice-card {
            background: rgba(125, 211, 252, 0.15);
            border-radius: 20px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .invoice-card:hover {
            background: rgba(125, 211, 252, 0.25);
            transform: translateY(-2px);
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
        }

        .invoice-number {
            font-size: 16px;
            font-weight: 600;
            color: #2dd4bf;
        }

        .invoice-from-to {
            font-size: 16px;
            color: #7dd3fc;
        }

        .invoice-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .invoice-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .invoice-amount {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.9);
        }

        .invoice-date {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.6);
        }

        .status-badge {
            padding: 8px 20px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .status-badge.not-paid {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }

        .status-badge.paid {
            background: rgba(45, 212, 191, 0.2);
            color: #2dd4bf;
        }

        .status-badge.pending {
            background: rgba(251, 146, 60, 0.2);
            color: #fb923c;
        }

        .status-badge.cancelled {
            background: rgba(156, 163, 175, 0.2);
            color: #9ca3af;
        }

        .status-icon {
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: rgba(255, 255, 255, 0.6);
        }

        .empty-state-icon {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.3;
        }

        .empty-state-text {
            font-size: 18px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .spinner {
            animation: spin 1s linear infinite;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="{{ route('home') }}" class="back-button">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M15 18l-6-6 6-6"/>
                </svg>
            </a>
            <h1 class="title">Invoices</h1>
        </div>

        <div class="tabs">
            <button class="tab active" data-tab="incoming">Incoming</button>
            <button class="tab" data-tab="outgoing">Outgoing</button>
        </div>

        <!-- Incoming Invoices Tab -->
        <div class="tab-content active" id="incoming">
            @if($incomingInvoices->count() > 0)
                <div class="invoice-list">
                    @foreach($incomingInvoices as $invoice)
                        <a href="{{ route('invoices.show', $invoice->idInvoice) }}" class="invoice-card">
                            <div class="invoice-header">
                                <div>
                                    <div class="invoice-number">Invoice #{{ $invoice->idInvoice }}</div>
                                    <div class="invoice-from-to">
                                        From <strong>{{ $invoice->restocker->username }}</strong> 
                                        to <strong>{{ $invoice->cart->store->storeName }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-details">
                                <div class="invoice-info">
                                    <div class="invoice-amount">Amount: Rp{{ number_format($invoice->totalAmount, 2, ',', '.') }}</div>
                                    <div class="invoice-date">{{ $invoice->invoiceDate->format('H:i d/m/Y') }}</div>
                                </div>
                                <div class="status-badge {{ $invoice->status === 'paid' ? 'paid' : ($invoice->status === 'cancelled' ? 'cancelled' : 'not-paid') }}">
                                    @if($invoice->status === 'paid')
                                        <span class="status-icon">✓</span> Paid
                                    @elseif($invoice->status === 'cancelled')
                                        <span class="status-icon">✕</span> Cancelled
                                    @else
                                        <span class="status-icon">!</span> Not Paid
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">📭</div>
                    <div class="empty-state-text">No incoming invoices</div>
                </div>
            @endif
        </div>

        <!-- Outgoing Invoices Tab -->
        <div class="tab-content" id="outgoing">
            @if($outgoingInvoices->count() > 0)
                <div class="invoice-list">
                    @foreach($outgoingInvoices as $invoice)
                        <a href="{{ route('invoices.show', $invoice->idInvoice) }}" class="invoice-card">
                            <div class="invoice-header">
                                <div>
                                    <div class="invoice-number">Invoice #{{ $invoice->idInvoice }}</div>
                                    <div class="invoice-from-to">
                                        to <strong>{{ $invoice->cart->store->storeName }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-details">
                                <div class="invoice-info">
                                    <div class="invoice-amount">Amount: Rp{{ number_format($invoice->totalAmount, 2, ',', '.') }}</div>
                                    <div class="invoice-date">{{ $invoice->invoiceDate->format('H:i d/m/Y') }}</div>
                                </div>
                                <div class="status-badge {{ $invoice->status === 'paid' ? 'paid' : ($invoice->status === 'cancelled' ? 'cancelled' : 'pending') }}">
                                    @if($invoice->status === 'paid')
                                        <span class="status-icon">✓</span> Paid
                                    @elseif($invoice->status === 'cancelled')
                                        <span class="status-icon">✕</span> Cancelled
                                    @else
                                        <span class="status-icon spinner">⟳</span> Pending
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">📭</div>
                    <div class="empty-state-text">No outgoing invoices</div>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Tab switching
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', function() {
                const targetTab = this.dataset.tab;
                
                // Remove active class from all tabs and contents
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked tab and corresponding content
                this.classList.add('active');
                document.getElementById(targetTab).classList.add('active');
            });
        });
    </script>
</body>
</html>