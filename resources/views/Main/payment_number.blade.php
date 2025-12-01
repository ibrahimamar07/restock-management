<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Payment Method</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Screen CSS -->
  <link rel="stylesheet" href="payment-number.css">
  
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

  <div class="container pt-5">

      <!-- Back Button -->
      <a href="/new-method" class="btn back-btn" title="Back">
        <img src="{{ asset('img/chevron-left-circle.png') }}" alt="Back" style="width:44px;height:44px;display:block;">
      </a>

      <!-- Title -->
      <h2 class="title">
        Create a <br>
        <span class="highlight">Payment Method</span>
      </h2>

      <!-- Subtitle -->
      <p class="subtitle">Please Input your Gopay Number</p>

      <!-- Input Label -->
      <label class="form-label mt-4">Gopay Number</label>

      <!-- Number Input -->
      <input type="text" class="form-control num-input" placeholder="Gopay Number">

  </div>

  <!-- Notice -->
  <p class="notice text-center mt-5">
    Make sure the number you input is correct
  </p>

  <!-- Continue Button -->
  <div class="container mt-3 mb-4">
    <button class="btn btn-continue w-100">Continue</button>
  </div>

</body>
</html>
