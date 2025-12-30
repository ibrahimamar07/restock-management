<!-- Muhammad Kevin Checa Satrio - 5026221083 -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="home.css">
</head>

<body>
    <div class="page-container">

       <!-- Header -->
    @php
        $currentUser = auth()->user();
    @endphp

        <div class="header">
            <img
                src="{{ $currentUser && $currentUser->profilepic ? asset('storage/' . $currentUser->profilepic) : asset('img/profile.jpg') }}"
                class="avatar"
                alt="Profile"
            >
            <h1 class="welcome">
                Hi, {{ $currentUser ? ($currentUser->nickname ?? $currentUser->username) : 'Guest' }}
            </h1>
        </div>


        <!-- Menu -->
        <div class="menu-grid">
            <div class="menu-card">
                <img src="{{ asset('img/Shopping_Cart_01.png') }}" class="menu-icon" alt="Browse Store">
                <p>Browse Store</p>
            </div>

            <div class="menu-card">
                <img src="{{ asset('img/Files.png') }}" class="menu-icon" alt="My Invoices">
                <p>My Invoices</p>
            </div>

            <!-- changed: make entire card a link to "/" -->
            <a href="{{ route('stores.listStore') }}" class="menu-card" role="button" aria-label="My Store" style="text-decoration: none;">
                <img src="{{ asset('img/Shopping_Bag_02.png') }}" class="menu-icon" alt="My Store">
                <p>My Store</p>
            </a>

            <a href="{{ route('profile') }}" class="menu-card" role="button" aria-label="Profile" style="text-decoration: none;">
                <img src="{{ asset('img/User_Circle.png') }}" class="menu-icon" alt="Profile">
                <p>Profile</p>
            </a>
        </div>

        <!-- Recent Activities -->
        <h2 class="section-title">Recent Activities</h2>

        <div class="activities">

            <div class="activity-row">
                <span><strong>Created</strong> Invoice #IS001 to <strong>Nara Store</strong></span>
                <span class="time">12:23 22/5/2025</span>
            </div>

            <div class="activity-row">
                <span><strong>Received</strong> Invoice #NS001 From <strong>Alvin</strong> to IS Store</span>
                <span class="time">15:09 20/5/2025</span>
            </div>

            <div class="activity-row">
                <span><strong>Payment Received</strong> from Invoice #IS001</span>
                <span class="time">08:33 17/5/2025</span>
            </div>

        </div>

    </div>
</body>
</html>
