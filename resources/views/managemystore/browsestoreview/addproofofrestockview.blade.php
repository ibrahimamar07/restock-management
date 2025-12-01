{{-- felix prajna santoso 5026231027 --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Proof of Restock</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(180deg, #1a2847 0%, #0d1829 100%);
            min-height: 100vh;
            color: white;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        .header {
            padding: 20px;
        }
        .back-btn {
            width: 40px;
            height: 40px;
            border: 2px solid white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            font-size: 20px;
            background: transparent;
            cursor: pointer;
        }
        .content-container {
            padding: 0 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .camera-preview {
            background: white;
            border-radius: 25px;
            aspect-ratio: 4/3;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }
        .camera-icon-container {
            text-align: center;
        }
        .camera-icon {
            font-size: 80px;
            color: #1a7a8a;
            margin-bottom: 10px;
        }
        .preview-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .remove-image-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #d32f2f;
            font-size: 20px;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            display: none;
        }
        .camera-preview.has-image .remove-image-btn {
            display: flex;
        }
        .instruction-text {
            text-align: center;
            font-size: 14px;
            line-height: 1.5;
            opacity: 0.9;
            margin: 10px 0;
        }
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
            padding-bottom: 30px;
        }
        .action-btn {
            background: #1a7a8a;
            border: none;
            border-radius: 50px;
            padding: 18px;
            font-size: 18px;
            font-weight: 700;
            color: white;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s;
        }
        .action-btn:hover {
            background: #156873;
            transform: scale(1.02);
        }
        .action-btn:active {
            transform: scale(0.98);
        }
        .file-input {
            display: none;
        }
        .multiple-images-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        .image-preview-item {
            position: relative;
            aspect-ratio: 1;
            border-radius: 20px;
            overflow: hidden;
            background: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .image-preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .remove-item-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 30px;
            height: 30px;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #d32f2f;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <!-- Header -->
        <div class="header">
            <button class="back-btn" onclick="history.back()">
                <i class="bi bi-chevron-left"></i>
            </button>
        </div>

        <!-- Content -->
        <div class="content-container">
            <!-- Camera Preview / Uploaded Images -->
            <div id="singleImageContainer">
                <div class="camera-preview" id="cameraPreview">
                    <div class="camera-icon-container" id="placeholderIcon">
                        <i class="bi bi-camera camera-icon"></i>
                    </div>
                    <img id="previewImage" class="preview-image" style="display: none;" alt="Preview">
                    <button class="remove-image-btn" id="removeImageBtn" onclick="removeImage()">
                        <i class="bi bi-x"></i>
                    </button>
                </div>

                <!-- Instruction Text -->
                <p class="instruction-text">
                    Take a picture of proof or add them from<br>your gallery
                </p>
            </div>

            <!-- Multiple Images Preview (shown after uploading) -->
            <div id="multipleImagesContainer" class="multiple-images-container" style="display: none;">
                <!-- Images will be dynamically added here -->
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <button class="action-btn" onclick="triggerFileInput()">
                    <i class="bi bi-image me-2"></i>Add From Gallery
                </button>
                <button class="action-btn" id="continueBtn" onclick="continueToInvoice()" style="opacity: 0.5;" disabled>
                    Continue
                </button>
            </div>
        </div>
    </div>

    <!-- Hidden File Input -->
    <input type="file" id="fileInput" class="file-input" accept="image/*" multiple onchange="handleFileSelect(event)">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let uploadedImages = [];

        function triggerFileInput() {
            document.getElementById('fileInput').click();
        }

        function handleFileSelect(event) {
            const files = event.target.files;
            
            if (files.length === 0) return;

            // Clear previous images
            uploadedImages = [];

            // Handle single image preview (first image)
            if (files.length === 1) {
                const file = files[0];
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    uploadedImages.push({
                        file: file,
                        dataUrl: e.target.result
                    });
                    
                    showSingleImage(e.target.result);
                    enableContinueButton();
                };
                
                reader.readAsDataURL(file);
            } 
            // Handle multiple images
            else {
                Array.from(files).forEach((file, index) => {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        uploadedImages.push({
                            file: file,
                            dataUrl: e.target.result,
                            id: Date.now() + index
                        });
                        
                        if (uploadedImages.length === files.length) {
                            showMultipleImages();
                            enableContinueButton();
                        }
                    };
                    
                    reader.readAsDataURL(file);
                });
            }
        }

        function showSingleImage(imageSrc) {
            const cameraPreview = document.getElementById('cameraPreview');
            const previewImage = document.getElementById('previewImage');
            const placeholderIcon = document.getElementById('placeholderIcon');
            const singleContainer = document.getElementById('singleImageContainer');
            const multipleContainer = document.getElementById('multipleImagesContainer');

            // Show single image view
            singleContainer.style.display = 'block';
            multipleContainer.style.display = 'none';

            previewImage.src = imageSrc;
            previewImage.style.display = 'block';
            placeholderIcon.style.display = 'none';
            cameraPreview.classList.add('has-image');
        }

        function showMultipleImages() {
            const singleContainer = document.getElementById('singleImageContainer');
            const multipleContainer = document.getElementById('multipleImagesContainer');

            // Hide single view, show multiple view
            singleContainer.style.display = 'none';
            multipleContainer.style.display = 'grid';
            multipleContainer.innerHTML = '';

            uploadedImages.forEach((img, index) => {
                const imageItem = document.createElement('div');
                imageItem.className = 'image-preview-item';
                imageItem.innerHTML = `
                    <img src="${img.dataUrl}" alt="Preview ${index + 1}">
                    <button class="remove-item-btn" onclick="removeImageFromList(${img.id})">
                        <i class="bi bi-x"></i>
                    </button>
                `;
                multipleContainer.appendChild(imageItem);
            });
        }

        function removeImage() {
            const cameraPreview = document.getElementById('cameraPreview');
            const previewImage = document.getElementById('previewImage');
            const placeholderIcon = document.getElementById('placeholderIcon');

            previewImage.src = '';
            previewImage.style.display = 'none';
            placeholderIcon.style.display = 'block';
            cameraPreview.classList.remove('has-image');
            
            uploadedImages = [];
            disableContinueButton();
            
            // Reset file input
            document.getElementById('fileInput').value = '';
        }

        function removeImageFromList(imageId) {
            uploadedImages = uploadedImages.filter(img => img.id !== imageId);
            
            if (uploadedImages.length === 0) {
                // Show empty camera preview
                document.getElementById('singleImageContainer').style.display = 'block';
                document.getElementById('multipleImagesContainer').style.display = 'none';
                
                const cameraPreview = document.getElementById('cameraPreview');
                const previewImage = document.getElementById('previewImage');
                const placeholderIcon = document.getElementById('placeholderIcon');
                
                previewImage.style.display = 'none';
                placeholderIcon.style.display = 'block';
                cameraPreview.classList.remove('has-image');
                
                disableContinueButton();
            } else if (uploadedImages.length === 1) {
                showSingleImage(uploadedImages[0].dataUrl);
            } else {
                showMultipleImages();
            }
        }

        function enableContinueButton() {
            const continueBtn = document.getElementById('continueBtn');
            continueBtn.style.opacity = '1';
            continueBtn.disabled = false;
        }

        function disableContinueButton() {
            const continueBtn = document.getElementById('continueBtn');
            continueBtn.style.opacity = '0.5';
            continueBtn.disabled = true;
        }

        function continueToInvoice() {
            if (uploadedImages.length === 0) {
                alert('Please add at least one image');
                return;
            }

            // Here you can handle form submission or navigation
            console.log('Uploaded images:', uploadedImages);
            
            // Example: Redirect to invoice page
            // window.location.href = '/invoice';
            
            // Or submit via form/AJAX
            alert(`Proceeding with ${uploadedImages.length} image(s)`);
        }
    </script>
</body>
</html>