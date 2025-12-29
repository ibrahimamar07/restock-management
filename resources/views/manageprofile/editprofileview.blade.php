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

        <form class="px-3 edit-form" method="POST" action="{{ route('updateProfile') }}" enctype="multipart/form-data">
            @csrf

            <div class="px-3 profile-edit-header mb-5">
                <label for="profileImageInput" class="profile-img-container">
                    <img
                        src="{{ $user->profilepic ? asset('storage/' . $user->profilepic) : asset('img/avatardefault.png') }}"
                        alt="User Profile"
                        class="profile-img"
                        id="profileImagePreview"
                    >
                    <div class="profile-img-overlay">
                        <i class="bi bi-camera"></i>
                    </div>
                </label>

                <input id="profileImageInput"
                    name="profilepic"
                    type="file"
                    accept="image/*"
                    class="visually-hidden">

                <h1 class="edit-title">
                    <span class="edit-text">Edit</span>
                    <span class="profile-text">Profile</span>
                </h1>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-4">
                <label for="nickname" class="form-label input-label">Nickname</label>
                <input
                    type="text"
                    class="form-control custom-input"
                    id="nickname"
                    name="nickname"
                    value="{{ old('nickname', $user->nickname) }}"
                >
            </div>

            <div class="mb-5">
                <label for="description" class="form-label input-label">Description</label>
                <textarea
                    class="form-control custom-input textarea-input"
                    id="description"
                    name="description"
                    rows="4"
                >{{ old('description', $user->description) }}</textarea>
            </div>

            <button type="submit" class="btn confirm-btn">Confirm</button>
        </form>

        <script>
            // Fungsionalitas preview gambar saat file dipilih
            document.getElementById('profileImageInput').addEventListener('change', function (e) {
                const file = this.files && this.files[0];
                if (!file || !file.type.startsWith('image/')) return;

                const img = document.getElementById('profileImagePreview');
                const url = URL.createObjectURL(file);
                img.src = url;
            });
        </script>
</body>
</html>
