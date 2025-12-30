{{-- ibrahim amar alfanani 5026231195 --}}
{{-- resources/views/additemstoreview.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Items</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('managemystore_css/additemstoreview.css') }}">
</head>
<body>
    <div class="container">
        <div class="px-3 py-3">
            <a href="{{ route('stores.showStore', $store->idStore) }}" class="back-btn">
                <i class="bi bi-chevron-left"></i>
            </a>
        </div>

        <div class="px-3">
            <h1 class="main-title">Now let's add some items you want to get restocked!</h1>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <p class="section-title">Add Item</p>

            <div class="item-card">
                <form action="{{ route('items.addItem', $store->idStore) }}" method="POST">
                    @csrf
                    <input type="text" name="itemName" class="form-control" placeholder="Item Name (e.g., Beng-beng)" required>
                    @error('itemName')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    
                    <input type="number" name="itemPrice" class="form-control" placeholder="Price (e.g., 2000)" required>
                    @error('itemPrice')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    
                    <button type="submit" class="add-item-btn">
                        <div class="add-icon">+</div>
                    </button>
                </form>
            </div>

            <a href="{{ route('stores.showStore', $store->idStore) }}" class="finish-btn" style="text-align: center; display: block; text-decoration: none;">Finish</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>