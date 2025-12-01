{{-- Komang Alit Pujangga 5026231115 --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/css/profile.css">
</head>
<body>
    <div class="container profile-container">

        <div class="px-3 pt-4 pb-4">
            <a href="/profile" class="back-btn">
                <i class="bi bi-chevron-left"></i>
            </a>
        </div>

        <form class="px-3 mt-5 change-password-form">

            <div class="mb-4">
                <label for="oldPassword" class="form-label input-label">Old Password</label>
                <input type="password" class="form-control custom-input" id="oldPassword" required>
            </div>

            <div class="mb-4">
                <label for="newPassword" class="form-label input-label">New Password</label>
                <input type="password" class="form-control custom-input" id="newPassword" required>
            </div>

            <div class="mb-5">
                <label for="confirmPassword" class="form-label input-label">New Password Confirmation</label>
                <input type="password" class="form-control custom-input" id="confirmPassword" required>
            </div>

            <button type="submit" class="btn confirm-btn">Confirm</button>
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
