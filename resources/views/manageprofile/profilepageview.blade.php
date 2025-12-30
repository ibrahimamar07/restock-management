{{-- Komang Alit Pujangga 5026231115 --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/profile.css">

</head>
<body>
    <div class="container profile-container">

        <div class="px-3 pt-4 pb-3">
            <a href="/home" class="back-btn">
                <i class="bi bi-chevron-left"></i>
            </a>
        </div>
        @if (session('success'))
            <div class="alert alert-success mt-3 px-3">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger mt-3 px-3">
                {{ session('error') }}
            </div>
        @endif

            <div class="px-3 profile-header mb-5">
                <img src="{{ $user->profilepic ? asset('storage/' . $user->profilepic) : asset('img/avatardefault.png') }}"
                    alt="{{ $user->nickname ?? $user->username }}"
                    class="profile-img">

                <div class="profile-info">
                    <h1 class="user-name">{{ $user->nickname ?? $user->username }}</h1>

                    <p class="user-role">{{ $user->description ?? 'Belum ada deskripsi.' }}</p>
                </div>
            </div>

        <div class="profile-menu-list">
            <a href="/profile/edit" class="menu-item top-rounded">
                <span>Edit Profile</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="/profile/changepassword" class="menu-item">
                <span>Change Password</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="/profile/paymentmethods" class="menu-item">
                <span>Payment Methods</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="#" class="menu-item bottom-rounded logout-item"
                data-bs-toggle="modal" data-bs-target="#logoutModal">
                <span>Logout</span>
                <i class="bi bi-chevron-right"></i>
            </a>
        </div>

    </div>

    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content custom-modal-content">
                <div class="modal-body text-center p-4">
                    <h2 class="modal-logout-title">Logout</h2>
                    <p class="modal-logout-message">Are you sure you want to logout?</p>

                    <div class="d-flex justify-content-center gap-3 mt-4">
                        <button type="button" class="btn modal-cancel-btn" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="button" class="btn modal-logout-btn" id="confirmLogoutBtn">
                            Logout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Dapatkan elemen tombol konfirmasi logout
            const logoutButton = document.getElementById('confirmLogoutBtn');

            // 2. Tentukan route atau URL tujuan
            const logoutRoute = '/'; // ⬅️ GANTI DENGAN ROUTE LOGOUT ANDA YANG BENAR

            if (logoutButton) {
                // 3. Tambahkan event listener untuk mendeteksi klik
                logoutButton.addEventListener('click', function() {
                    // 4. Lakukan redirect ke route logout
                    window.location.href = logoutRoute;

                    // Opsional: Jika Anda menggunakan framework seperti Laravel,
                    // Anda mungkin perlu mengirim form POST request di sini.
                    // Untuk redirect sederhana, window.location.href sudah cukup.
                });
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
