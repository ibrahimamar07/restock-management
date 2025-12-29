<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Payment Method</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('create-payment-method.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* use a CSS variable for the highlight color, fallback to prior blue */
        .checkmark { visibility: hidden; font-size: 1.25rem; color: var(--highlight-color, #0d6efd); }
        .payment-card.selected .checkmark { visibility: visible; }
    </style>
</head>

<body>

    <div class="container pt-5">

        <a href="{{ route('paymentMethodsView') }}" class="btn back-btn" title="Back">
            <i class="bi bi-chevron-left"></i>
        </a>

        <h2 class="payment-title">
            Add New<br>
            <span class="highlight">Payment Method</span>
        </h2>
    </div>

    <div class="container mt-4">

        @if (session('error'))
            <div class="alert alert-danger mb-3">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger mb-3">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (!empty($availablePaymentTypes))
            @foreach ($availablePaymentTypes as $type)
                @php
                    // Logika untuk menentukan kartu mana yang harus dipilih pertama kali (atau setelah error validasi)
                    $isSelected = ($loop->first && !old('idPaymentType')) || (old('idPaymentType') == $type->idPaymentType);
                    $cardClass = $isSelected ? 'payment-card selected' : 'payment-card';
                @endphp

                <div class="{{ $cardClass }} d-flex align-items-center justify-content-between mb-3"
                     data-payment-id="{{ $type->idPaymentType }}"
                     data-payment-name="{{ $type->paymentName }}">

                    <div class="d-flex align-items-center">
                        <div class="ms-3">
                            <div class="payment-name">{{ $type->paymentName }}</div>
                            <div class="payment-cost">Klik untuk memilih</div>
                        </div>
                    </div>

                    <i class="bi bi-check-lg checkmark"></i>
                </div>
            @endforeach
        @else
            <p class="text-center text-muted">Tidak ada metode pembayaran yang tersedia.</p>
        @endif
        </div>

    <div class="container mt-5">
        <form id="paymentForm" action="{{ route('storePaymentMethod') }}" method="POST">
            @csrf

            <input type="hidden" name="idPaymentType" id="paymentTypeInput"
                   value="{{ old('idPaymentType', $availablePaymentTypes->first()->idPaymentType ?? '') }}">

            <label for="paymentDetails" class="form-label" style="color: #FFFFFF !important;">Nomor Akun / Detail Pembayaran</label>
            <input type="text" name="paymentDetails" id="paymentDetails" class="form-control mb-3" required placeholder="Contoh: 0812xxxxxxxx" value="{{ old('paymentDetails') }}">

            <button type="submit" class="btn btn-continue w-100" id="continueButton">Add Payment</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // copy computed color from .highlight into a CSS variable so checkmarks match
            const highlightEl = document.querySelector('.highlight');
            if (highlightEl) {
                const color = getComputedStyle(highlightEl).color;
                document.documentElement.style.setProperty('--highlight-color', color);
            }

            const cards = document.querySelectorAll('.payment-card');
            const paymentTypeInput = document.getElementById('paymentTypeInput');

            cards.forEach(card => {
                card.style.cursor = 'pointer';

                card.addEventListener('click', () => {
                    cards.forEach(c => c.classList.remove('selected'));
                    card.classList.add('selected');

                    const selectedId = card.getAttribute('data-payment-id');
                    paymentTypeInput.value = selectedId;
                });
            });

            // Inisialisasi: Pastikan nilai input diatur ke kartu yang 'selected' saat DOM dimuat (penting untuk menangani old() data)
            const initialSelected = document.querySelector('.payment-card.selected');
            if (initialSelected) {
                paymentTypeInput.value = initialSelected.getAttribute('data-payment-id');
            }
        });
    </script>
</body>
</html>
