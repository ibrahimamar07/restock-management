{{-- felix prajna santoso 5026231027 --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Item to Restock</title>
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
        .status-bar {
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 600;
        }
        .header {
            padding: 20px;
        }
        .back-btn {
            width: 40px;
            height: 40px;
            border: 2px solid white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            font-size: 20px;
            background: transparent;
            cursor: pointer;
        }
        .store-header {
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .store-logo {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
            background: white;
        }
        .store-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .store-info h2 {
            font-size: 24px;
            font-weight: 700;
            color: #5dd9e8;
            margin: 0 0 5px 0;
        }
        .store-address {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.7);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .items-container {
            padding: 0 20px;
            background: white;
            border-radius: 30px 30px 0 0;
            padding-top: 25px;
            padding-bottom: 25px;
            min-height: 60vh;
        }
        .item-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .item-row:last-child {
            border-bottom: none;
        }
        .item-info h3 {
            font-size: 18px;
            font-weight: 700;
            color: #1a2847;
            margin: 0 0 5px 0;
        }
        .item-price {
            font-size: 14px;
            color: #666;
        }
        .item-controls {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .stock-badge {
            background: #e8f8f9;
            color: #1a7a8a;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            min-width: 50px;
            text-align: center;
        }
        .stock-badge.negative {
            background: #ffe6e6;
            color: #d32f2f;
        }
        .counter-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .counter-btn {
            width: 35px;
            height: 35px;
            border: 2px solid #1a7a8a;
            border-radius: 50%;
            background: white;
            color: #1a7a8a;
            font-size: 20px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        .counter-btn:hover {
            background: #1a7a8a;
            color: white;
        }
        .counter-btn:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }
        .counter-display {
            font-size: 18px;
            font-weight: 700;
            color: #1a7a8a;
            min-width: 30px;
            text-align: center;
        }
        .restock-btn-container {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            background: linear-gradient(to top, #0d1829 70%, transparent);
        }
        .restock-btn {
            background: #1a7a8a;
            border: none;
            border-radius: 50px;
            padding: 18px;
            font-size: 18px;
            font-weight: 700;
            color: white;
            width: 100%;
            transition: all 0.3s;
        }
        .restock-btn:hover {
            background: #156873;
            transform: scale(1.02);
        }
        .restock-btn:disabled {
            background: #999;
            cursor: not-allowed;
            transform: none;
        }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <!-- Header with Back Button -->
        <div class="header">
            <button class="back-btn" onclick="history.back()">
                <i class="bi bi-chevron-left"></i>
            </button>
        </div>

        <!-- Store Header -->
        <div class="store-header">
            <div class="store-logo">
                <img src="https://via.placeholder.com/60x60/1a7a8a/ffffff?text=TC" alt="TC Store">
            </div>
            <div class="store-info">
                <h2>TC Store</h2>
                <p class="store-address">
                    <i class="bi bi-geo-alt-fill"></i>
                    Departemen Teknik Informatika, ITS
                </p>
            </div>
        </div>

        <!-- Items List -->
        <div class="items-container">
            <!-- Item 1 -->
            <div class="item-row">
                <div class="item-info">
                    <h3>Beng-beng</h3>
                    <p class="item-price">Price: Rp. 2.000,00</p>
                </div>
                <div class="item-controls">
                    <span class="stock-badge negative">-20 +</span>
                    <div class="counter-controls">
                        <button class="counter-btn" onclick="decreaseCount(this)">-</button>
                        <span class="counter-display">0</span>
                        <button class="counter-btn" onclick="increaseCount(this)">+</button>
                    </div>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="item-row">
                <div class="item-info">
                    <h3>Ultramik</h3>
                    <p class="item-price">Price: Rp. 1.500,00</p>
                </div>
                <div class="item-controls">
                    <span class="stock-badge negative">-5 +</span>
                    <div class="counter-controls">
                        <button class="counter-btn" onclick="decreaseCount(this)">-</button>
                        <span class="counter-display">0</span>
                        <button class="counter-btn" onclick="increaseCount(this)">+</button>
                    </div>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="item-row">
                <div class="item-info">
                    <h3>Air Putih</h3>
                    <p class="item-price">Price: Rp. 500,00</p>
                </div>
                <div class="item-controls">
                    <span class="stock-badge negative">-10 +</span>
                    <div class="counter-controls">
                        <button class="counter-btn" onclick="decreaseCount(this)">-</button>
                        <span class="counter-display">0</span>
                        <button class="counter-btn" onclick="increaseCount(this)">+</button>
                    </div>
                </div>
            </div>

            <!-- Item 4 -->
            <div class="item-row">
                <div class="item-info">
                    <h3>Javana</h3>
                    <p class="item-price">Price: Rp. 3.500,00</p>
                </div>
                <div class="item-controls">
                    <span class="stock-badge negative">-10 +</span>
                    <div class="counter-controls">
                        <button class="counter-btn" onclick="decreaseCount(this)">-</button>
                        <span class="counter-display">0</span>
                        <button class="counter-btn" onclick="increaseCount(this)">+</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Restock Button -->
        <div class="restock-btn-container">
            <button class="restock-btn" id="restockBtn" onclick="proceedRestock()">
                Restock
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function increaseCount(button) {
            const counterDisplay = button.previousElementSibling;
            let count = parseInt(counterDisplay.textContent);
            count++;
            counterDisplay.textContent = count;
            updateRestockButton();
        }

        function decreaseCount(button) {
            const counterDisplay = button.nextElementSibling;
            let count = parseInt(counterDisplay.textContent);
            if (count > 0) {
                count--;
                counterDisplay.textContent = count;
                updateRestockButton();
            }
        }

        function updateRestockButton() {
            const allCounters = document.querySelectorAll('.counter-display');
            let totalItems = 0;
            
            allCounters.forEach(counter => {
                totalItems += parseInt(counter.textContent);
            });

            const restockBtn = document.getElementById('restockBtn');
            if (totalItems > 0) {
                restockBtn.disabled = false;
            } else {
                restockBtn.disabled = true;
            }
        }

        function proceedRestock() {
            // Collect all items with count > 0
            const items = [];
            const itemRows = document.querySelectorAll('.item-row');
            
            itemRows.forEach(row => {
                const itemName = row.querySelector('.item-info h3').textContent;
                const count = parseInt(row.querySelector('.counter-display').textContent);
                
                if (count > 0) {
                    items.push({
                        name: itemName,
                        quantity: count
                    });
                }
            });

            if (items.length > 0) {
                console.log('Items to restock:', items);
                // Redirect to next page or submit form
                // window.location.href = '/camera'; // atau route yang sesuai
                alert('Restocking ' + items.length + ' items');
            }
        }

        // Initialize button state
        updateRestockButton();
    </script>
</body>
</html>