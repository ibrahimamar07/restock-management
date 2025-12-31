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
            background: linear-gradient(180deg, #111749 0%, #111749 100%);
            min-height: 100vh;
            color: white;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        .header { padding: 20px; display: flex; align-items: center; gap: 15px; }
        .back-btn {
            width: 40px; height: 40px; border: 2px solid #5dd9e8; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #5dd9e8; text-decoration: none; font-size: 20px; flex-shrink: 0;
        }
        .store-info-card {
            background: white; border-radius: 20px; padding: 25px; margin: 0 20px 20px;
            color: #1a2847; text-align: center;
        }
        .item-list { margin: 0 20px; }
        .item-card {
            background: white; border-radius: 15px; padding: 15px; margin-bottom: 15px;
            display: flex; justify-content: space-between; align-items: center; color: #1a2847;
        }
        .btn-select {
            background-color: #5dd9e8; color: #111749; border: none;
            padding: 8px 20px; border-radius: 8px; font-weight: 700; text-decoration: none;
        }
        .btn-select:hover { background-color: #4ccadd; color: #111749; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="{{ route('browse.index') }}" class="back-btn"><i class="bi bi-chevron-left"></i></a>
            <h1 style="font-size: 24px; font-weight: 700; margin: 0;">Select Item</h1>
        </div>

        <div class="store-info-card">
            @if($store->storePic)
                <img src="{{ asset('storage/' . $store->storePic) }}" alt="Logo" style="width:60px; height:60px; border-radius:50%; object-fit:cover; margin-bottom:10px;">
            @else
                <i class="bi bi-shop" style="font-size: 40px; color: #1a7a8a;"></i>
            @endif
            <h2 style="font-size: 22px; font-weight: 700; margin: 0;">{{ $store->storeName }}</h2>
            <p style="margin: 0; color: #666;">{{ $store->storeAddress }}</p>
        </div>

        <div class="item-list">
            <h3 style="font-size: 18px; margin-bottom: 15px;">Available Items</h3>
            
            @forelse($store->items as $item)
                <div class="item-card">
                    <div>
                        <h4 style="margin: 0; font-size: 16px; font-weight: 700;">{{ $item->itemName }}</h4>
                        <p style="margin: 0; font-size: 13px; color: #666;">
                            Stock: {{ $item->itemQuantity }} | Price: {{ number_format($item->itemPrice) }}
                        </p>
                    </div>
                    
                    <a href="{{ route('restock.create', $item->idItem) }}" class="btn-select">
                        Select
                    </a>
                </div>
            @empty
                <p class="text-center text-white">No items found in this store.</p>
            @endforelse
        </div>
    </div>
</body>
</html>