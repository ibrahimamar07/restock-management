<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IS Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(180deg, #1a2847 0%, #0d1829 100%);
            min-height: 100vh;
            color: white;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        .status-bar {
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 600;
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
        }
        .store-header {
            display: flex;
            align-items: center;
            margin-top: 30px;
            margin-bottom: 40px;
        }
        .store-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 20px;
        }
        .store-info h1 {
            font-size: 48px;
            font-weight: 700;
            color: #5dd9e8;
            margin: 0;
        }
        .store-info p {
            margin: 5px 0 0 0;
            font-size: 14px;
            color: #5dd9e8;
            display: flex;
            align-items: center;
        }
        .store-info p i {
            margin-right: 5px;
        }
        .edit-btn {
            background: #5a5d8a;
            border: none;
            border-radius: 10px;
            padding: 8px 20px;
            font-size: 14px;
            font-weight: 600;
            color: white;
            margin-top: 10px;
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
            margin: 0;
            font-size: 14px;
            color: #1a7a8a;
        }
        .item-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .edit-item-btn {
            background: #9b9fc9;
            border: none;
            border-radius: 10px;
            padding: 8px 15px;
            font-size: 14px;
            font-weight: 600;
            color: white;
        }
        .checkbox-custom {
            width: 30px;
            height: 30px;
            border: 3px solid #1a7a8a;
            border-radius: 5px;
            background: white;
            cursor: pointer;
        }
        .add-item-btn {
            background: transparent;
            border: none;
            width: 100%;
            padding: 20px;
            display: flex;
            justify-content: center;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="px-3 py-3">
            <a href="#" class="back-btn">
                <i class="bi bi-chevron-left"></i>
            </a>
        </div>

        <div class="px-3">
            <div class="store-header">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120'%3E%3Crect fill='%23555555' width='120' height='120'/%3E%3C/svg%3E" alt="Store" class="store-img">
                <div class="store-info">
                    <h1>IS Store</h1>
                    <p><i class="bi bi-geo-alt-fill"></i> Departemen Sistem Informasi, ITS</p>
                    <button class="edit-btn">Edit</button>
                </div>
            </div>

            <div class="item-card">
                <div class="item-header">
                    <div class="item-info">
                        <h3>Beng-beng</h3>
                        <p>Price: Rp. 2.000,00</p>
                    </div>
                    <div class="item-actions">
                        <button class="edit-item-btn">Edit</button>
                        <div class="checkbox-custom"></div>
                    </div>
                </div>
                <button class="add-item-btn">
                    <div class="add-icon">+</div>
                </button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>