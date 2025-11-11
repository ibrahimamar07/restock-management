{{-- ibrahim amar alfanani 5026231195 --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Up Your Store</title>
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
        }
        .main-title {
            font-size: 46px;
            font-weight: 700;
            color: #5dd9e8;
            line-height: 1.2;
            margin-top: 20px;
            margin-bottom: 30px;
        }
        .store-img-container {
            width: 180px;
            height: 180px;
            margin: 0 auto 40px;
            border-radius: 50%;
            overflow: hidden;
            background: #2a4b6f;
        }
        .store-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .form-label {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 10px;
            color: white;
        }
        .form-control {
            background: #c8e9ed;
            border: none;
            border-radius: 15px;
            padding: 15px 20px;
            font-size: 16px;
            color: #0d1829;
            font-weight: 600;
        }
        .form-control:focus {
            background: #c8e9ed;
            box-shadow: none;
            border: none;
        }
        .form-control::placeholder {
            color: #0d1829;
        }
        textarea.form-control {
            min-height: 200px;
            resize: none;
        }
        .next-btn {
            background: #1a7a8a;
            border: none;
            border-radius: 50px;
            padding: 18px;
            font-size: 18px;
            font-weight: 700;
            color: white;
            width: 100%;
            margin-top: 30px;
        }
        .next-btn:hover {
            background: #156873;
        }
    </style>
</head>
<body>
    <div class="container">

        <div class="px-3 py-3">
            <a href="#" class="back-btn">
                <i class="bi bi-chevron-left"></i>
            </a>
        </div>

        <div class="px-3">
            <h1 class="main-title">Let's set up your store!</h1>

            <div class="store-img-container">
                <img src="img\storeimage2.png" alt="Store Image">
            </div>

            <div class="mb-3">
                <label class="form-label">Store Name</label>
                <input type="text" class="form-control" value="IS Store">
            </div>

            <div class="mb-3">
                <label class="form-label">Store Address</label>
                <textarea class="form-control">Departemen Sistem Informasi, ITS</textarea>
            </div>

            <button class="next-btn">Next</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>