<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create a Payment Method</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Dedicated CSS -->
  <link rel="stylesheet" href="create-payment-method.css">

  <!-- show checkmark only on selected card -->
  <style>
    /* use a CSS variable for the highlight color, fallback to prior blue */
    .checkmark { visibility: hidden; font-size: 1.25rem; color: var(--highlight-color, #0d6efd); }
    .payment-card.selected .checkmark { visibility: visible; }
  </style>
</head>

<body>

  <!-- Top Section -->
  <div class="container pt-5">

      <a href="/new-profile" class="btn back-btn" title="Back">
        <img src="{{ asset('img/chevron-left-circle.png') }}" alt="Back" style="width:44px;height:44px;display:block;">
      </a>

      <h2 class="payment-title">
        Create a<br>
        <span class="highlight">Payment Method</span>
      </h2>
  </div>

  <!-- Payment Options -->
  <div class="container mt-4">

    <!-- Gopay (selected) -->
    <div class="payment-card selected d-flex align-items-center justify-content-between mb-3">
        <div class="d-flex align-items-center">
            <img src="https://upload.wikimedia.org/wikipedia/commons/2/2c/Logo_GoPay.svg" class="payment-logo">
            <div class="ms-3">
                <div class="payment-name">Gopay</div>
                <div class="payment-cost">Admin Cost: Rp1.000,00</div>
            </div>
        </div>

        <i class="bi bi-check-lg checkmark"></i>
    </div>

    <!-- ShopeePay -->
    <div class="payment-card d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <img src="https://upload.wikimedia.org/wikipedia/commons/0/0b/ShopeePay_logo.png" class="payment-logo">
            <div class="ms-3">
                <div class="payment-name">ShopeePay</div>
                <div class="payment-cost">Admin Cost: -</div>
            </div>
        </div>

        <i class="bi bi-check-lg checkmark"></i>
    </div>

  </div>

  <!-- Continue Button -->
  <div class="container mt-5">
      <a href="/payment-number" class="btn btn-continue w-100">Continue</a>
  </div>

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <script>
    // set the --highlight-color variable to match the .highlight element,
    // and make a clicked payment card the only selected one
    document.addEventListener('DOMContentLoaded', function () {
      // copy computed color from .highlight into a CSS variable so checkmarks match
      const highlightEl = document.querySelector('.highlight');
      if (highlightEl) {
        const color = getComputedStyle(highlightEl).color;
        document.documentElement.style.setProperty('--highlight-color', color);
      }

      const cards = document.querySelectorAll('.payment-card');
      cards.forEach(card => {
        // show pointer to indicate clickable
        card.style.cursor = 'pointer';

        card.addEventListener('click', () => {
          cards.forEach(c => c.classList.remove('selected'));
          card.classList.add('selected');
        });
      });
    });
  </script>

</body>
</html>
