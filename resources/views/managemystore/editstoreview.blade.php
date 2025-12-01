{{-- ibrahim amar alfanani 5026231195 --}}
{{-- resources/views/editstoreview.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('managemystore_css/editstoreview.css') }}">
</head>
<body>
    <div class="container">
        <div class="px-3 py-3">
            <a href="{{ route('stores.show', $store->idStore) }}" class="back-btn">
                <i class="bi bi-chevron-left"></i>
            </a>
        </div>

            <form action="{{ route('stores.update', $store->idStore) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="store-img-container">
                  
                    <label for="storePicInput" class="store-image-placeholder" id="fileInputLabel">
                    <img src="{{ asset('storage/storepic/' .$store->storePic) }}" alt="Storepic" class="store-img">
                    <img id="storeImagePreview" src="#" alt="Store Image Preview" style="display: none;">
                    </label>
        
                     <input type="file" name="storePic" id="storePicInput" class="form-control d-none" accept="image/*" required>
        
                @error('storePic')
                    <small class="text-danger d-block mt-2">{{ $message }}</small>
                @enderror
            </div>

                <div class="mb-3">
                    <label class="form-label">Store Name</label>
                    <input type="text" name="storeName" class="form-control" value="{{ old('storeName', $store->storeName) }}" required>
                    @error('storeName')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Store Address</label>
                    <textarea name="storeAddress" class="form-control" required>{{ old('storeAddress', $store->storeAddress) }}</textarea>
                    @error('storeAddress')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="finish-btn">Finish</button>
            </form>

            <form action="{{ route('stores.destroy', $store->idStore) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this store?')">Delete Store</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
     <script src="{{ asset('managemystore_js/setupstoreview.js') }}"></script>
</body>
</html>
