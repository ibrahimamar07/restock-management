{{-- nathaniel lado hadi winata 5026231019 --}}
{{-- CREATE INVOICE VIEW --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(180deg, #1a2847 0%, #0d1829 100%);
            min-height: 100vh;
            color: white;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
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
        .main-title {
            font-size: 40px;
            font-weight: 700;
            color: #5dd9e8;
            line-height: 1.2;
            margin-top: 20px;
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
            color: white;
        }
        .item-card {
            background: #c8e9ed;
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 15px;
            position: relative;
        }
        .item-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }
        .item-info h3 {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
            color: #1a7a8a;
        }
        .item-info p {
            margin: 5px 0 0 0;
            font-size: 14px;
            color: #1a7a8a;
        }
        .item-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .edit-btn {
            background: #9b9fc9;
            border: none;
            border-radius: 10px;
            padding: 8px 15px;
            font-size: 14px;
            font-weight: 600;
            color: white;
            cursor: pointer;
            transition: background 0.3s;
        }
        .edit-btn:hover {
            background: #8a8eb8;
        }
        .checkbox-custom {
            width: 30px;
            height: 30px;
            border: 3px solid #1a7a8a;
            border-radius: 5px;
            background: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        .checkbox-custom.checked {
            background: #1a7a8a;
        }
        .checkbox-custom.checked::after {
            content: '✓';
            color: white;
            font-size: 18px;
            font-weight: bold;
        }
        .quantity-control {
            display: flex;
            align-items: center;
            gap: 15px;
            justify-content: center;
            margin-top: 10px;
        }
        .quantity-btn {
            width: 40px;
            height: 40px;
            border: 3px solid #1a7a8a;
            border-radius: 50%;
            background: white;
            color: #1a7a8a;
            font-size: 24px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        .quantity-btn:hover {
            background: #1a7a8a;
            color: white;
        }
        .quantity-display {
            font-size: 24px;
            font-weight: 700;
            color: #1a7a8a;
            min-width: 40px;
            text-align: center;
        }
        .add-item-section {
            background: transparent;
            border: 3px dashed rgba(13, 24, 41, 0.5);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        .add-item-section:hover {
            border-color: #0d1829;
            background: rgba(200, 233, 237, 0.1);
        }
        .add-icon {
            width: 60px;
            height: 60px;
            border: 4px solid #0d1829;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            color: #0d1829;
            background: transparent;
        }
        .finish-btn {
            background: #1a7a8a;
            border: none;
            border-radius: 50px;
            padding: 18px;
            font-size: 18px;
            font-weight: 700;
            color: white;
            width: 100%;
            margin-top: 30px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .finish-btn:hover {
            background: #156873;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 122, 138, 0.3);
        }
        .finish-btn:disabled {
            background: #6b7280;
            cursor: not-allowed;
            transform: none;
        }
        .item-card.hidden {
            display: none;
        }
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: rgba(255, 255, 255, 0.5);
        }
        .empty-state i {
            font-size: 48px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="px-3 py-3">
            <a href="#" class="back-btn" onclick="history.back(); return false;">
                <i class="bi bi-chevron-left"></i>
            </a>
        </div>

        <div class="px-3">
            <h1 class="main-title">Now let's add some items you want to get restocked!</h1>

            <p class="section-title">Add Item</p>

            <!-- Item Cards Container -->
            <div id="itemsContainer">
                <!-- Sample Item Card 1 -->
                <div class="item-card" data-item-id="1">
                    <div class="item-header">
                        <div class="item-info">
                            <h3>Beng-beng</h3>
                            <p>Price: Rp. 2.000,00</p>
                        </div>
                        <div class="item-actions">
                            <button class="edit-btn" onclick="editItem(1)">Edit</button>
                            <div class="checkbox-custom" onclick="toggleItem(this, 1)"></div>
                        </div>
                    </div>
                    <div class="quantity-control" style="display: none;">
                        <div class="quantity-btn" onclick="decreaseQuantity(1)">−</div>
                        <div class="quantity-display" id="quantity-1">1</div>
                        <div class="quantity-btn" onclick="increaseQuantity(1)">+</div>
                    </div>
                </div>

                <!-- Sample Item Card 2 -->
                <div class="item-card" data-item-id="2">
                    <div class="item-header">
                        <div class="item-info">
                            <h3>Ultramlik</h3>
                            <p>Price: Rp. 8.000,00</p>
                        </div>
                        <div class="item-actions">
                            <button class="edit-btn" onclick="editItem(2)">Edit</button>
                            <div class="checkbox-custom" onclick="toggleItem(this, 2)"></div>
                        </div>
                    </div>
                    <div class="quantity-control" style="display: none;">
                        <div class="quantity-btn" onclick="decreaseQuantity(2)">−</div>
                        <div class="quantity-display" id="quantity-2">1</div>
                        <div class="quantity-btn" onclick="increaseQuantity(2)">+</div>
                    </div>
                </div>

                <!-- Sample Item Card 3 -->
                <div class="item-card" data-item-id="3">
                    <div class="item-header">
                        <div class="item-info">
                            <h3>Air Putih</h3>
                            <p>Price: Rp. 3.000,00</p>
                        </div>
                        <div class="item-actions">
                            <button class="edit-btn" onclick="editItem(3)">Edit</button>
                            <div class="checkbox-custom" onclick="toggleItem(this, 3)"></div>
                        </div>
                    </div>
                    <div class="quantity-control" style="display: none;">
                        <div class="quantity-btn" onclick="decreaseQuantity(3)">−</div>
                        <div class="quantity-display" id="quantity-3">1</div>
                        <div class="quantity-btn" onclick="increaseQuantity(3)">+</div>
                    </div>
                </div>

                <!-- Sample Item Card 4 -->
                <div class="item-card" data-item-id="4">
                    <div class="item-header">
                        <div class="item-info">
                            <h3>Javana</h3>
                            <p>Price: Rp. 4.000,00</p>
                        </div>
                        <div class="item-actions">
                            <button class="edit-btn" onclick="editItem(4)">Edit</button>
                            <div class="checkbox-custom" onclick="toggleItem(this, 4)"></div>
                        </div>
                    </div>
                    <div class="quantity-control" style="display: none;">
                        <div class="quantity-btn" onclick="decreaseQuantity(4)">−</div>
                        <div class="quantity-display" id="quantity-4">1</div>
                        <div class="quantity-btn" onclick="increaseQuantity(4)">+</div>
                    </div>
                </div>
            </div>

            <!-- Add New Item Button -->
            <div class="add-item-section" onclick="addNewItem()">
                <div class="add-icon">+</div>
            </div>

            <button class="finish-btn" id="finishBtn" onclick="createInvoice()">Finish</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let selectedItems = new Set();
        let quantities = {};

        function toggleItem(checkbox, itemId) {
            checkbox.classList.toggle('checked');
            const card = checkbox.closest('.item-card');
            const quantityControl = card.querySelector('.quantity-control');

            if (checkbox.classList.contains('checked')) {
                selectedItems.add(itemId);
                quantities[itemId] = 1;
                quantityControl.style.display = 'flex';
            } else {
                selectedItems.delete(itemId);
                delete quantities[itemId];
                quantityControl.style.display = 'none';
            }

            updateFinishButton();
        }

        function increaseQuantity(itemId) {
            if (quantities[itemId]) {
                quantities[itemId]++;
                document.getElementById(`quantity-${itemId}`).textContent = quantities[itemId];
            }
        }

        function decreaseQuantity(itemId) {
            if (quantities[itemId] && quantities[itemId] > 1) {
                quantities[itemId]--;
                document.getElementById(`quantity-${itemId}`).textContent = quantities[itemId];
            }
        }

        function updateFinishButton() {
            const finishBtn = document.getElementById('finishBtn');
            if (selectedItems.size > 0) {
                finishBtn.disabled = false;
            } else {
                finishBtn.disabled = true;
            }
        }

        function editItem(itemId) {
            alert(`Edit item ${itemId} - Modal form will open here`);
            // In real implementation, open a modal to edit item details
        }

        function addNewItem() {
            alert('Add new item - Modal form will open here');
            // In real implementation, open a modal to add new item
        }

        function createInvoice() {
            if (selectedItems.size === 0) {
                alert('Please select at least one item');
                return;
            }

            const invoiceData = {
                items: Array.from(selectedItems).map(itemId => ({
                    id: itemId,
                    quantity: quantities[itemId]
                })),
                createdAt: new Date().toISOString()
            };

            console.log('Creating invoice with data:', invoiceData);

            // In real implementation, send to backend API
            alert(`Invoice created with ${selectedItems.size} items!`);

            // Redirect to invoice list or detail page
            // window.location.href = '/invoices';
        }

        // Initialize
        updateFinishButton();
    </script>
</body>
</html>
