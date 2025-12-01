<!-- Muhammad Kevin Checa Satrio - 5026221083 -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Out of Stock - Login</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- External CSS -->
  <link rel="stylesheet" href="styles.css">

  <!-- removed inline top-section styles (moved to styles.css) -->
</head>

<body>

  <!-- Top Logo Section -->
  <div class="top-section">
    <!-- use your logo file (public/img/logo.png) -->
    <img src="{{ asset('img/logo.png') }}" class="logo-img" alt="Logo">
  </div>

  <!-- Form Section -->
  <div class="form-section container">
    @if (session('error'))
      <div class="alert alert-danger mb-3">
        {{ session('error') }}
      </div>
    @endif

    <form method="POST" action="/login">
      @csrf

      <input type="text" name="username" class="form-control mb-3" placeholder="Username">
      <input type="password" name="password" class="form-control mb-2" placeholder="Password">

      <div class="text-end mb-4">
        <a href="#" class="text-light small">Forgot Password?</a>
      </div>

      <button type="submit" class="btn btn-login mb-4">Login</button>
    </form>

    <div class="d-flex align-items-center mb-3">
      <hr class="flex-grow-1 text-light">
      <span class="text-light px-2">Or</span>
      <hr class="flex-grow-1 text-light">
    </div>

    <p class="text-center register-text">
      Don’t have an account?
      <a href="/register">Register</a>
    </p>

  </div>

</body>
</html>
