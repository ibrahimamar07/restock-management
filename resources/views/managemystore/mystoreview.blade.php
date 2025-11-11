{{-- ibrahim amar alfanani 5026231195 --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Store</title>
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
        .main-title {
            font-size: 56px;
            font-weight: 700;
            color: #5dd9e8;
            line-height: 1.1;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        .subtitle {
            font-size: 18px;
            color: #7dd8e6;
            margin-bottom: 40px;
        }
        .store-card {
            background: #c8e9ed;
            border-radius: 20px;
            padding: 20px;
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #0d1829;
            margin-bottom: 30px;
        }
        .store-card:hover {
            background: #b5e0e5;
        }
        .store-img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
        }
        .store-info h3 {
            font-size: 28px;
            font-weight: 700;
            margin: 0;
            color: #1a7a8a;
        }
        .store-info p {
            margin: 0;
            font-size: 14px;
            color: #1a7a8a;
            display: flex;
            align-items: center;
        }
        .store-info p i {
            margin-right: 5px;
        }
        .arrow-icon {
            margin-left: auto;
            font-size: 24px;
            color: #1a7a8a;
        }
        .divider {
            border-top: 2px solid #2a4b6f;
            margin: 30px 0;
        }
        .add-store-btn {
            background: transparent;
            border: none;
            color: white;
            font-size: 18px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 15px;
            width: 100%;
        }
        .add-icon {
            width: 40px;
            height: 40px;
            border: 3px solid white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
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
            <h1 class="main-title">My Store</h1>
            <p class="subtitle">This is where you set up your store for the restockers to see</p>

            <a href="" class="store-card">
                <img src="img\storeimage.png" alt="Store" class="store-img">
                <div class="store-info flex-grow-1">
                    <h3>IS Store</h3>
                    <p><i class="bi bi-geo-alt-fill"></i> Departemen Sistem Informasi, ITS</p>
                </div>
                <i class="bi bi-chevron-right arrow-icon"></i>
            </a>

            <div class="divider"></div>

            <button class="add-store-btn">
                <div class="add-icon">+</div>
                <span>Add Store</span>
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>