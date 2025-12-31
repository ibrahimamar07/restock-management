<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Detail - Restock</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(180deg, #111749 0%, #111749 100%);
            min-height: 100vh;
            color: white;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
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
        .store-header-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin: 20px;
            color: #1a2847;
            text-align: center;
        }
        .store-logo-large {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #e0e0e0;
            margin: 0 auto 15px;
            overflow: hidden;
        }
        .item-card {
            background: white;
            border-radius: 15px;
            padding: 15px;
            margin: 0 20px 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #1a2847;
        }
        .btn-restock {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
        }
        .btn-restock:hover {
            background-color: #218838;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="{{ route('browse.index') }}" class="back-btn">
                <i class="bi bi-chevron-left"></i>
            </a>
            <h1 style="font-size: 24px; font-weight: 700; margin: 0;">Store Detail</h1>
        </div>

        <div class="store-header-card">
            <div class="store-logo-large">
                @if($store->storePic)
                    <img src="{{ asset('storage/' . $store->storePic) }}" alt="{{ $store->storeName }}" style="width:100%; height:100%; object-fit:cover;">
                @else
                    <i class="bi bi-shop" style="font-size: 50px; line-height: 100px; color: #1a7a8a;"></i>
                @endif
            </div>
            <h2 style="font-weight: 700;">{{ $store->storeName }}</h2>
            <p style="margin-bottom: 0; color: #666;">{{ $store->storeAddress }}</p>
        </div>

        <h3 style="margin: 0 20px 15px 20px; font-size: 18px;">Items Available to Restock</h3>

        <div class="items-list">
            @forelse($store->items as $item)
                <div class="item-card">
                    <div>
                        <h4 style="margin: 0; font-size: 16px; font-weight: 700;">{{ $item->itemName }}</h4>
                        <p style="margin: 0; font-size: 12px; color: #666;">
                            Stock: {{ $item->itemQuantity }} | Price: Rp{{ number_format($item->itemPrice, 0, ',', '.') }}
                        </p>
                    </div>
                    <a href="{{ route('restock.create', $item->idItem) }}" class="btn-restock">
                        Select
                    </a>
                </div>
            @empty
                <p class="text-center" style="margin-top: 20px;">No items found in this store.</p>
            @endforelse
        </div>
    </div>
</body>
</html>