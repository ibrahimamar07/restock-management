{{-- nathaniel lado hadi winata 5026231019 --}}
{{-- VIEW INVOICE DETAIL --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(180deg, #1a2847 0%, #0d1829 100%);
            min-height: 100vh;
            color: white;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            padding-bottom: 100px;
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

        .invoice-header {
            padding: 20px;
        }

        .invoice-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .invoice-number {
            font-size: 28px;
            font-weight: 700;
            color: white;
        }

        .invoice-status {
            background: #FF9800;
            color: white;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .invoice-status.paid {
            background: #4CAF50;
        }

        .invoice-date {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.6);
        }

        .invoice-image-container {
            padding: 0 20px;
            margin-bottom: 20px;
        }

        .invoice-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 20px;
        }

        .section-card {
            background: #1e3a5f;
            border-radius: 20px;
            padding: 20px;
            margin: 0 20px 15px;
        }

        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: white;
            margin-bottom: 15px;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .item-row:last-child {
            border-bottom: none;
        }

        .item-info {
            flex: 1;
        }

        .item-name {
            font-size: 16px;
            font-weight: 600;
            color: white;
            margin-bottom: 4px;
        }

        .item-quantity {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.5);
        }

        .item-price {
            font-size: 16px;
            font-weight: 700;
            color: #5dd9e8;
        }

        .wallet-section {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .wallet-section:last-child {
            border-bottom: none;
        }

        .wallet-icon {
            width: 45px;
            height: 45px;
            background: #5dd9e8;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #0d1829;
            flex-shrink: 0;
        }

        .wallet-icon.restocking {
            background: #FF9800;
        }

        .wallet-details {
            flex: 1;
        }

        .wallet-name {
            font-size: 15px;
            font-weight: 600;
            color: white;
            margin-bottom: 2px;
        }

        .wallet-address {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.5);
        }

        .total-section {
            background: linear-gradient(135deg, #1a7a8a 0%, #156873 100%);
            border-radius: 20px;
            padding: 20px;
            margin: 0 20px 20px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .total-row:last-child {
            margin-bottom: 0;
            padding-top: 15px;
            border-top: 2px solid rgba(255, 255, 255, 0.2);
        }

        .total-label {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
        }

        .total-value {
            font-size: 14px;
            font-weight: 600;
            color: white;
        }

        .total-amount-label {
            font-size: 16px;
            font-weight: 700;
            color: white;
        }

        .total-amount-value {
            font-size: 24px;
            font-weight: 700;
            color: white;
        }

        .action-buttons {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, #0d1829 80%, transparent);
            padding: 20px;
            display: flex;
            gap: 10px;
        }

        .btn-secondary-action {
            flex: 1;
            background: transparent;
            border: 2px solid #5dd9e8;
            border-radius: 50px;
            padding: 16px;
            font-size: 16px;
            font-weight: 700;
            color: #5dd9e8;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-secondary-action:hover {
            background: rgba(93, 217, 232, 0.1);
        }

        .btn-primary-action {
            flex: 2;
            background: #5dd9e8;
            border: none;
            border-radius: 50px;
            padding: 16px;
            font-size: 16px;
            font-weight: 700;
            color: #0d1829;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary-action:hover {
            background: #4ac7d9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(93, 217, 232, 0.3);
        }

        .btn-primary-action:disabled {
            background: #6b7280;
            cursor: not-allowed;
            transform: none;
        }

        .success-badge {
            background: rgba(76, 175, 80, 0.2);
            border: 2px solid #4CAF50;
            border-radius: 15px;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin: 0 20px 20px;
        }

        .success-badge i {
            font-size: 24px;
            color: #4CAF50;
        }

        .success-badge-text {
            font-size: 16px;
            font-weight: 700;
            color: #4CAF50;
        }

        .success-timestamp {
            text-align: center;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.5);
            margin: -10px 20px 20px;
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

        <div class="invoice-header">
            <div class="invoice-title">
                <h1 class="invoice-number">Invoice - #IS002</h1>
                <span class="invoice-status" id="invoiceStatus">Pending</span>
            </div>
            <p class="invoice-date">Date of Issue: 18 Apr 2025</p>
        </div>

        <div class="invoice-image-container">
            <img src="https://images.unsplash.com/photo-1621939514649-280e2ee25f60?w=600&h=300&fit=crop" alt="Invoice Product" class="invoice-image">
        </div>

        <!-- Success Badge (only shown when paid) -->
        <div class="success-badge" id="successBadge" style="display: none;">
            <i class="bi bi-check-circle-fill"></i>
            <span class="success-badge-text">Invoice has been successfully paid!</span>
        </div>
        <div class="success-timestamp" id="successTimestamp" style="display: none;">
            18:55, 07 Apr 2025
        </div>

        <!-- Items Section -->
        <div class="section-card">
            <h2 class="section-title">Items</h2>

            <div class="item-row">
                <div class="item-info">
                    <div class="item-name">Beng-beng</div>
                    <div class="item-quantity">Qty: 10</div>
                </div>
                <div class="item-price">Rp20.000,00</div>
            </div>

            <div class="item-row">
                <div class="item-info">
                    <div class="item-name">Ultramlik</div>
                    <div class="item-quantity">Qty: 5</div>
                </div>
                <div class="item-price">Rp40.000,00</div>
            </div>

            <div class="item-row">
                <div class="item-info">
                    <div class="item-name">Air Putih</div>
                    <div class="item-quantity">Qty: 15</div>
                </div>
                <div class="item-price">Rp45.000,00</div>
            </div>

            <div class="item-row">
                <div class="item-info">
                    <div class="item-name">Javana</div>
                    <div class="item-quantity">Qty: 8</div>
                </div>
                <div class="item-price">Rp32.000,00</div>
            </div>
        </div>

        <!-- Payment Method Section -->
        <div class="section-card">
            <h2 class="section-title">Payment Method</h2>

            <div class="wallet-section">
                <div class="wallet-icon">
                    <i class="bi bi-wallet2"></i>
                </div>
                <div class="wallet-details">
                    <div class="wallet-name">Gopay</div>
                    <div class="wallet-address">+62xxxxx</div>
                </div>
            </div>
        </div>

        <!-- Restocking Wallet Section (only shown when paid) -->
        <div class="section-card" id="restockingSection" style="display: none;">
            <h2 class="section-title">Restocking Wallet</h2>

            <div class="wallet-section">
                <div class="wallet-icon restocking">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div class="wallet-details">
                    <div class="wallet-name">Aldi Wardana</div>
                    <div class="wallet-address">92xxxxxxx</div>
                </div>
            </div>
        </div>

        <!-- Total Section -->
        <div class="total-section">
            <div class="total-row">
                <span class="total-label">Subtotal</span>
                <span class="total-value">Rp137.000,00</span>
            </div>

            <div class="total-row">
                <span class="total-label">Tax (0%)</span>
                <span class="total-value">Rp0,00</span>
            </div>

            <div class="total-row">
                <span class="total-label">Discount</span>
                <span class="total-value">-Rp22.000,00</span>
            </div>

            <div class="total-row">
                <span class="total-amount-label">Total Amount</span>
                <span class="total-amount-value">Rp115.000,00</span>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons" id="actionButtons">
            <button class="btn-secondary-action" onclick="downloadInvoice()">
                <i class="bi bi-download"></i> Download
            </button>
            <button class="btn-primary-action" id="payButton" onclick="proceedToPayment()">
                Pay Invoice
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simulate invoice status (can be changed to test different states)
        let invoiceStatus = 'pending'; // 'pending' or 'paid'

        function initializePage() {
            if (invoiceStatus === 'paid') {
                showPaidState();
            } else {
                showPendingState();
            }
        }

        function showPaidState() {
            document.getElementById('invoiceStatus').textContent = 'Paid';
            document.getElementById('invoiceStatus').classList.remove('pending');
            document.getElementById('invoiceStatus').classList.add('paid');

            document.getElementById('successBadge').style.display = 'flex';
            document.getElementById('successTimestamp').style.display = 'block';
            document.getElementById('restockingSection').style.display = 'block';

            // Change action button
            const actionButtons = document.getElementById('actionButtons');
            actionButtons.innerHTML = `
                <button class="btn-secondary-action" onclick="downloadInvoice()">
                    <i class="bi bi-download"></i> Download
                </button>
                <button class="btn-secondary-action" onclick="shareInvoice()">
                    <i class="bi bi-share"></i> Share
                </button>
            `;
        }

        function showPendingState() {
            document.getElementById('invoiceStatus').textContent = 'Pending';
            document.getElementById('invoiceStatus').classList.add('pending');
        }

        function proceedToPayment() {
            console.log('Proceeding to payment...');
            // In real implementation, redirect to payment page
            // window.location.href = '/invoice/IS002/pay';
            alert('Redirecting to payment page...');
        }

        function downloadInvoice() {
            console.log('Downloading invoice...');
            alert('Invoice download started...');
            // In real implementation, trigger PDF download
        }

        function shareInvoice() {
            console.log('Sharing invoice...');
            alert('Share invoice dialog...');
            // In real implementation, open share dialog
        }

        // Initialize page on load
        initializePage();
    </script>
</body>
</html>
