{{-- ibrahim amar alfanani 5026231195 --}}
{{-- resources/views/storedetailview.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $store->storeName }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('managemystore_css/storedetailview.css') }}">
</head>
<body>
    <div class="container">
        <div class="px-3 py-3">
            <a href="{{ route('stores.index') }}" class="back-btn">
                <i class="bi bi-chevron-left"></i>
            </a>
        </div>

        <div class="px-3">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="store-header">
                <img src="{{ asset('storage/storepic/' .$store->storePic) }}" alt="storepic" class="store-img">
                <div class="store-info">
                    <h1>{{ $store->storeName }}</h1>
                    <p><i class="bi bi-geo-alt-fill"></i> {{ $store->storeAddress }}</p>
                    <a href="{{ route('stores.edit', $store->idStore) }}" class="edit-btn">Edit</a>
                </div>
            </div>

            @foreach($store->items as $item)
            <div class="item-card">
                <div class="item-header">
                    <div class="item-info">
                        <h3>{{ $item->itemName }}</h3>
                        <p>Price: Rp. {{ number_format($item->itemPrice, 0, ',', '.') }}</p>
                    </div>
                    <div class="item-actions">
                        <form action="{{ route('items.destroy', $item->idItem) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-item-btn" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="item-card">
                <a href="{{ route('items.create', $store->idStore) }}" class="add-item-btn">
                    <div class="add-icon">
                        <span style="margin-bottom: 10px;">+</span>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
