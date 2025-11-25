{{-- ibrahim amar alfanani 5026231195 --}}
{{-- resources/views/mystoreview.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('managemystore_css/mystoreview.css') }}">
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

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @forelse($stores as $store)
            <a href="{{ route('stores.show', $store->idStore) }}" class="store-card">
                <img src="{{ asset('storage/storepic/' .$store->storePic) }}" alt="Storepic" class="store-img">
                <div class="store-info flex-grow-1">
                    <h3>{{ $store->storeName }}</h3>
                    <p><i class="bi bi-geo-alt-fill"></i> {{ $store->storeAddress }}</p>
                </div>
                <i class="bi bi-chevron-right arrow-icon"></i>
            </a>
            @empty
            <p class="text-center text-white">No stores yet. Create your first store!</p>
            @endforelse

            <div class="divider"></div>

            <a href="{{ route('stores.create') }}" class="add-store-btn">
                <div class="add-icon">
                  <span style="margin-bottom: 8px;">+</span>
                </div>
                <span>Add Store</span>
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>





