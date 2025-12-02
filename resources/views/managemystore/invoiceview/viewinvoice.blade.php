{{-- nathaniel lado hadi winata 5026231019 --}}
{{-- VIEW INVOICE --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoices</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(180deg, #1a2847 0%, #0d1829 100%);
            min-height: 100vh;
            color: white;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .header {
            padding: 20px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 32px;
            font-weight: 700;
            margin: 0;
            color: white;
        }

        .tabs {
            display: flex;
            gap: 30px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
            padding: 0 20px;
            margin-bottom: 20px;
        }

        .tab {
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.5);
            font-size: 16px;
            font-weight: 600;
            padding: 10px 0;
            position: relative;
            cursor: pointer;
            transition: color 0.3s;
        }

        .tab.active {
            color: #5dd9e8;
        }

        .tab.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 2px;
            background: #5dd9e8;
        }

        .invoice-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
            padding: 0 20px 30px;
        }

        .invoice-card {
            background: #1e3a5f;
            border-radius: 20px;
            padding: 20px;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            position: relative;
            overflow: hidden;
        }

        .invoice-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(93, 217, 232, 0.2);
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .invoice-number {
            font-size: 18px;
            font-weight: 700;
            color: white;
        }

        .invoice-status {
            background: #4CAF50;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .invoice-status.pending {
            background: #FF9800;
        }

        .invoice-status.paid {
            background: #4CAF50;
        }

        .invoice-items {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 15px;
            max-height: 150px;
            overflow-y: auto;
        }

        .invoice-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .invoice-item:last-child {
            border-bottom: none;
        }

        .item-name {
            font-size: 14px;
            color: white;
            font-weight: 500;
        }

        .item-price {
            font-size: 14px;
            color: #5dd9e8;
            font-weight: 600;
        }

        .invoice-image {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 15px;
        }

        .invoice-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 2px solid rgba(255, 255, 255, 0.1);
        }

        .total-label {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 600;
        }

        .total-amount {
            font-size: 20px;
            font-weight: 700;
            color: #5dd9e8;
        }

        .invoice-date {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.5);
            margin-top: 8px;
        }

        .invoice-footer {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .wallet-info {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .wallet-icon {
            width: 30px;
            height: 30px;
            background: #5dd9e8;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: #0d1829;
        }

        .wallet-name {
            font-size: 13px;
            color: white;
            font-weight: 600;
        }

        .wallet-address {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.5);
        }

        .success-icon {
            width: 60px;
            height: 60px;
            background: #4CAF50;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }

        .success-icon i {
            font-size: 32px;
            color: white;
        }

        .success-text {
            text-align: center;
            font-size: 14px;
            color: white;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .success-date {
            text-align: center;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.5);
        }

        .paid-badge {
            background: rgba(76, 175, 80, 0.2);
            border: 2px solid #4CAF50;
            border-radius: 15px;
            padding: 8px 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 15px;
        }

        .paid-badge-text {
            font-size: 14px;
            font-weight: 700;
            color: #4CAF50;
        }

        .waiting-badge {
            background: rgba(255, 152, 0, 0.2);
            border: 2px solid #FF9800;
            border-radius: 15px;
            padding: 8px 16px;
            margin-top: 15px;
            text-align: center;
        }

        .waiting-badge-text {
            font-size: 12px;
            font-weight: 600;
            color: #FF9800;
        }

        .invoice-items::-webkit-scrollbar {
            width: 4px;
        }

        .invoice-items::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }

        .invoice-items::-webkit-scrollbar-thumb {
            background: rgba(93, 217, 232, 0.5);
            border-radius: 10px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: rgba(255, 255, 255, 0.5);
            grid-column: 1 / -1;
        }

        .empty-state i {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state p {
            font-size: 16px;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="header">
            <h1>Invoices</h1>
        </div>

        <div class="tabs">
            <button class="tab" onclick="switchTab('watching')">Watching</button>
            <button class="tab active" onclick="switchTab('ongoing')">Ongoing</button>
        </div>

        <div class="invoice-grid" id="invoiceGrid">
            <!-- Invoice Card 1 - Pending Payment -->
            <div class="invoice-card" data-status="ongoing" onclick="viewInvoiceDetail('IS002')">
                <div class="invoice-header">
                    <span class="invoice-number">Invoice - #IS002</span>
                    <span class="invoice-status pending">Pending</span>
                </div>

                <div class="invoice-items">
                    <div class="invoice-item">
                        <span class="item-name">Beng-beng</span>
                        <span class="item-price">Rp2.000,00</span>
                    </div>
                    <div class="invoice-item">
                        <span class="item-name">Ultramlik</span>
                        <span class="item-price">Rp8.000,00</span>
                    </div>
                    <div class="invoice-item">
                        <span class="item-name">Air Putih</span>
                        <span class="item-price">Rp3.000,00</span>
                    </div>
                    <div class="invoice-item">
                        <span class="item-name">Javana</span>
                        <span class="item-price">Rp4.000,00</span>
                    </div>
                </div>

                <img src="https://images.unsplash.com/photo-1621939514649-280e2ee25f60?w=400&h=200&fit=crop" alt="Product" class="invoice-image">

                <div class="invoice-total">
                    <span class="total-label">Total Amount</span>
                    <span class="total-amount">Rp115.000,00</span>
                </div>

                <div class="invoice-date">Date of Issue: 18 Apr 2025</div>

                <div class="invoice-footer">
                    <div class="wallet-icon">
                        <i class="bi bi-wallet2"></i>
                    </div>
                    <div>
                        <div class="wallet-name">Gopay</div>
                        <div class="wallet-address">+62xxxxx</div>
                    </div>
                </div>
            </div>

            <!-- Invoice Card 2 - Paid -->
            <div class="invoice-card" data-status="ongoing" onclick="viewInvoiceDetail('IS001')">
                <div class="invoice-header">
                    <span class="invoice-number">Invoice - #IS001</span>
                    <span class="invoice-status paid">Paid</span>
                </div>

                <div class="success-icon">
                    <i class="bi bi-check-lg"></i>
                </div>

                <div class="success-text">Invoice has been successfully paid!</div>
                <div class="success-date">18:55, 07 Apr 2025</div>

                <div class="invoice-total" style="margin-top: 20px;">
                    <span class="total-label">Total Amount</span>
                    <span class="total-amount">Rp115.000,00</span>
                </div>

                <div class="invoice-footer">
                    <div class="wallet-icon">
                        <i class="bi bi-wallet2"></i>
                    </div>
                    <div>
                        <div class="wallet-name">Gopay</div>
                        <div class="wallet-address">+62xxxxx</div>
                    </div>
                </div>

                <div class="invoice-footer" style="border: none; padding-top: 0;">
                    <div class="wallet-icon" style="background: #FF9800;">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div>
                        <div class="wallet-name">Restocking Wallet</div>
                        <div class="wallet-address">Aldi Wardana (92xxxxxxx)</div>
                    </div>
                </div>

                <div class="paid-badge">
                    <i class="bi bi-check-circle-fill" style="color: #4CAF50; font-size: 18px;"></i>
                    <span class="paid-badge-text">Invoice Paid</span>
                </div>
            </div>

            <!-- Invoice Card 3 - Waiting Payment -->
            <div class="invoice-card" data-status="watching" onclick="viewInvoiceDetail('TC002')">
                <div class="invoice-header">
                    <span class="invoice-number">Invoice - #TC002</span>
                    <span class="invoice-status pending">Pending</span>
                </div>

                <div class="invoice-items">
                    <div class="invoice-item">
                        <span class="item-name">Beng-beng</span>
                        <span class="item-price">Rp2.000,00</span>
                    </div>
                    <div class="invoice-item">
                        <span class="item-name">Ultramlik</span>
                        <span class="item-price">Rp8.000,00</span>
                    </div>
                    <div class="invoice-item">
                        <span class="item-name">Air Putih</span>
                        <span class="item-price">Rp3.000,00</span>
                    </div>
                    <div class="invoice-item">
                        <span class="item-name">Javana</span>
                        <span class="item-price">Rp4.000,00</span>
                    </div>
                </div>

                <img src="https://images.unsplash.com/photo-1621939514649-280e2ee25f60?w=400&h=200&fit=crop" alt="Product" class="invoice-image">

                <div class="invoice-total">
                    <span class="total-label">Total Amount</span>
                    <span class="total-amount">Rp115.000,00</span>
                </div>

                <div class="invoice-date">Date of Issue: 18 Apr 2025</div>

                <div class="waiting-badge">
                    <span class="waiting-badge-text">Waiting for Payment from TC Store</span>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function switchTab(tab) {
            // Update active tab
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            event.target.classList.add('active');

            // Filter invoices
            const invoiceCards = document.querySelectorAll('.invoice-card');
            let visibleCount = 0;

            invoiceCards.forEach(card => {
                if (tab === 'watching') {
                    if (card.dataset.status === 'watching') {
                        card.style.display = 'block';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                } else {
                    if (card.dataset.status === 'ongoing') {
                        card.style.display = 'block';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                }
            });

            // Show empty state if no invoices
            showEmptyState(visibleCount === 0, tab);
        }

        function showEmptyState(show, tab) {
            const grid = document.getElementById('invoiceGrid');
            let emptyState = document.querySelector('.empty-state');

            if (show && !emptyState) {
                emptyState = document.createElement('div');
                emptyState.className = 'empty-state';
                emptyState.innerHTML = `
                    <i class="bi bi-inbox"></i>
                    <p>No ${tab} invoices found</p>
                `;
                grid.appendChild(emptyState);
            } else if (!show && emptyState) {
                emptyState.remove();
            }
        }

        function viewInvoiceDetail(invoiceId) {
            console.log('View invoice detail:', invoiceId);
            // In real implementation, redirect to detail page
            // window.location.href = `/invoice/${invoiceId}`;
            alert(`Redirecting to invoice detail: ${invoiceId}`);
        }
    </script>
</body>
</html>
