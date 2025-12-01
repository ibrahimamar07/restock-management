{{-- Komang Alit Pujangga 5026231115 --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
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

        <div class="px-3 profile-edit-header mb-5">
            <img src="/img/avatardefault.png" alt="User Profile" class="profile-img">
            <h1 class="edit-title">
                <span class="edit-text">Edit</span>
                <span class="profile-text">Profile</span>
            </h1>
        </div>

        <form class="px-3 edit-form">
            <div class="mb-4">
                <label for="nickname" class="form-label input-label">Nickname</label>
                <input type="text" class="form-control custom-input" id="nickname" value="Carlos">
            </div>

            <div class="mb-5">
                <label for="description" class="form-label input-label">Description</label>
                <textarea class="form-control custom-input textarea-input" id="description" rows="4">Owner of IS Store</textarea>
            </div>

            <button type="submit" class="btn confirm-btn">Confirm</button>
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
