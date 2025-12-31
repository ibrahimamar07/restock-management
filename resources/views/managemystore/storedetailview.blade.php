{{-- ibrahim amar alfanani 5026231195 --}}
{{-- resources/views/storedetailview.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $store->storeName }}</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('managemystore_css/storedetailview.css') }}">
</head>
<body>
    <div class="container">
        <div class="px-3 py-3">
            <a href="{{ route('stores.listStore') }}" class="back-btn">
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
                        <a href="{{ route('stores.editStoreView', $store->idStore) }}" class="edit-btn">Edit Store</a>
                </div>
            </div>
            
            <h1>{{ $store->name }}</h1>

            <div class="items-list">
                @foreach($store->items as $item)
                    <div class="item-card">
                        <h4>{{ $item->name }}</h4>
                        <p>Stok Saat Ini: {{ $item->quantity }}</p>
            
                        <a href="{{ route('restock.create', $item->id) }}" class="btn-restock">
                            Select to Restock
                        </a>
                </div>
                @endforeach
            </div>
            <h2 class="mt-4 mb-3" style="color: #5dd9e8;">Daftar Item</h2>

            @foreach($items as $item)
            <div class="item-card">
                <div class="item-header">
                    <div class="item-info">
                        <h3>{{ $item->itemName }}</h3>
                        <p>Price: Rp. {{ number_format($item->itemPrice, 0, ',', '.') }}</p>
                    </div>
                   
                    <div class="item-actions">
                        
                        {{-- Tombol Edit Item (Membuka Modal) --}}
                        <button type="button" class="edit-item-btn" 
                            data-bs-toggle="modal" 
                            data-bs-target="#editItemModal"
                            data-item-id="{{ $item->idItem }}"
                            data-item-name="{{ $item->itemName }}"
                            data-item-price="{{ $item->itemPrice }}"
                            data-update-url="{{ route('items.updateItem', $item->idItem) }}">
                            Edit
                        </button>
                        
                        {{-- Form Delete Item --}}
                        <form id="delete-form-{{ $item->idItem }}"
                             action="{{ route('items.deleteItem', $item->idItem) }}"
                             method="POST" 
                             style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-item-btn" id="delete-item" onclick="konfirmasiHapus('delete-form-{{ $item->idItem }}')">Delete</button>
                        </form>
                    </div>
                   
                </div>
            </div>
            @endforeach

           
            <div class="item-card" style="display: flex; justify-content: center; align-items: center; border: 2px dashed #5a5d8a; background: #1a2847;">
                <a href="{{ route('items.createItemView', $store->idStore) }}" class="add-item-btn" style="color: #5dd9e8; font-weight: bold;">
                    <div class="add-icon" style="border-color: #5dd9e8; color: #5dd9e8;">
                        <i class="bi bi-plus-lg"></i>
                    </div>
                    
                </a>
            </div>
           
        </div>
    </div>

    
    {{-- MODAL EDIT ITEM --}}
    <div class="modal fade" id="editItemModal" tabindex="-1" aria-labelledby="editItemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editItemModalLabel">Edit Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- Form action akan diisi oleh JavaScript saat modal dibuka --}}
                <form id="editItemForm" method="POST">
                    @csrf
                    @method('PUT') 
                    
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_itemName" class="form-label">Nama Item</label>
                            <input type="text" class="form-control @error('itemName') is-invalid @enderror" id="edit_itemName" name="itemName" required>
                            @error('itemName')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="edit_itemPrice" class="form-label">Harga Item (Rp)</label>
                            <input type="number" class="form-control @error('itemPrice') is-invalid @enderror" id="edit_itemPrice" name="itemPrice" required min="0">
                            @error('itemPrice')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
     <script src="{{ asset('managemystore_js/storedetailview.js') }}"></script>
</body>
</html>