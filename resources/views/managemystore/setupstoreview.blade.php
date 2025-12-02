{{-- ibrahim amar alfanani 5026231195 --}}
{{-- resources/views/setupstoreview.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Up Your Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('managemystore_css/setupstoreview.css') }}">
</head>
<body>
    <div class="container">
        <div class="px-3 py-3">
            <a href="{{ route('stores.index') }}" class="back-btn">
                <i class="bi bi-chevron-left"></i>
            </a>
        </div>

        <div class="px-3">
            <h1 class="main-title">Let's set up your store!</h1>

            <form action="{{ route('stores.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="store-img-container">
                    <label for="storePicInput" class="store-image-placeholder" id="fileInputLabel">
                        <div class="plus-sign" id="plusSign">
                           +
                        </div>
                    <img id="storeImagePreview" src="#" alt="Store Image Preview" style="display: none;">
                    </label>
        
                     <input type="file" name="storePic" id="storePicInput" class="form-control d-none" accept="image/*" required>
        
                @error('storePic')
                    <small class="text-danger d-block mt-2">{{ $message }}</small>
                @enderror
            </div>

                <div class="mb-3">
                    <label class="form-label">Store Name</label>
                    <input type="text" name="storeName" class="form-control" placeholder="e.g., IS Store" required value="{{ old('storeName') }}">
                    @error('storeName')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Store Address</label>
                    <textarea name="storeAddress" class="form-control" placeholder="e.g., Departemen Sistem Informasi, ITS" required>{{ old('storeAddress') }}</textarea>
                    @error('storeAddress')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="next-btn">Next</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('managemystore_js/setupstoreview.js') }}"></script>
</body>
</html>