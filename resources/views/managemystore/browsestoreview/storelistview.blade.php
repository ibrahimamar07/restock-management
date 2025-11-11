{{-- felix prajna santoso 5026231027 --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store List</title>
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
        .header {
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
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
            flex-shrink: 0;
        }
        .header-title {
            font-size: 24px;
            font-weight: 700;
            color: white;
            margin: 0;
        }
        .info-banner {
            background: rgba(93, 217, 232, 0.1);
            border-radius: 15px;
            padding: 20px;
            margin: 0 20px 30px 20px;
            display: flex;
            gap: 15px;
        }
        .info-icon {
            width: 24px;
            height: 24px;
            border: 2px solid white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 700;
            flex-shrink: 0;
        }
        .info-content h3 {
            font-size: 18px;
            font-weight: 700;
            margin: 0 0 8px 0;
        }
        .info-content p {
            font-size: 14px;
            margin: 0;
            opacity: 0.9;
            line-height: 1.4;
        }
        .store-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            margin: 0 20px 15px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            text-decoration: none;
            color: inherit;
            transition: transform 0.2s;
        }
        .store-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .store-logo {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
            overflow: hidden;
        }
        .store-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .store-info {
            flex: 1;
        }
        .store-name {
            font-size: 20px;
            font-weight: 700;
            color: #1a2847;
            margin: 0 0 5px 0;
        }
        .store-address {
            font-size: 14px;
            color: #666;
            margin: 0;
        }
        .chevron-icon {
            color: #ccc;
            font-size: 24px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <a href="#" class="back-btn">
                <i class="bi bi-chevron-left"></i>
            </a>
            <h1 class="header-title">Stores</h1>
        </div>

        <!-- Info Banner -->
        <div class="info-banner">
            <div class="info-icon">i</div>
            <div class="info-content">
                <h3>Stores</h3>
                <p>Find stores that needs their items restocked</p>
            </div>
        </div>

        <!-- Store List -->
        <div class="store-list">
            <a href="#" class="store-card">
                <div class="store-logo">
                    <i class="bi bi-shop" style="color: #1a7a8a;"></i>
                </div>
                <div class="store-info">
                    <h3 class="store-name">TC Store</h3>
                    <p class="store-address">Jl. Teknik Kimia no.1A</p>
                </div>
                <i class="bi bi-chevron-right chevron-icon"></i>
            </a>

            <a href="#" class="store-card">
                <div class="store-logo">
                    <i class="bi bi-shop" style="color: #1a7a8a;"></i>
                </div>
                <div class="store-info">
                    <h3 class="store-name">Kara Store</h3>
                    <p class="store-address">Jl. Keputih Tegal Timur VII</p>
                </div>
                <i class="bi bi-chevron-right chevron-icon"></i>
            </a>

            <a href="#" class="store-card">
                <div class="store-logo">
                    <i class="bi bi-shop" style="color: #1a7a8a;"></i>
                </div>
                <div class="store-info">
                    <h3 class="store-name">TC Store</h3>
                    <p class="store-address">Jl. Teknik Kimia Permai no.1A</p>
                </div>
                <i class="bi bi-chevron-right chevron-icon"></i>
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>