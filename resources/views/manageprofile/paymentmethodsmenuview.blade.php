{{-- Komang Alit Pujangga 5026231115 --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Methods</title>
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

        @if (session('success'))
            <div class="alert alert-success mt-3 px-3">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger mt-3 px-3">{{ session('error') }}</div>
        @endif

        {{-- Form tersembunyi untuk mengirim ID metode pembayaran yang dipilih --}}
        <form id="setDefaultForm" action="{{ route('setDefaultPaymentMethod') }}" method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="idUserPaymentType" id="selectedPaymentId">
        </form>

        <div class="px-3">
            <h1 class="page-title">Payment Methods</h1>
        </div>

        <div class="px-3 mt-4">
            {{-- LOOPING DATA DARI CONTROLLER --}}
            @forelse($paymentMethods as $method)
                @php
                    // Asumsi Controller mengirim data 'is_default' (boolean/int 0/1)
                    $isDefault = $method->is_default ?? 0;
                    $cardClass = $isDefault ? 'payment-card mb-4 default-selected' : 'payment-card mb-4';
                @endphp

                {{-- Tambahkan data-is-default untuk JS --}}
                <div class="{{ $cardClass }}"
                     data-id="{{ $method->idUserPaymentType }}"
                     data-is-default="{{ $isDefault }}">

                    <div class="payment-info">
                        {{-- Menampilkan nama metode pembayaran --}}
                        <p class="method-name">{{ $method->paymentName }}</p>
                        {{-- Menampilkan detail/nomor pembayaran --}}
                        <p class="method-number">{{ $method->paymentDetails }}</p>

                        {{-- Tampilkan label "Default" --}}
                        @if ($isDefault)
                            <span class="default-label">Default</span>
                        @endif
                    </div>

                    {{-- Icon Tanda Centang --}}
                    <i class="bi bi-check-circle-fill check-icon"></i>
                </div>
            @empty
                <p class="text-center text-muted">Anda belum memiliki metode pembayaran. Silakan tambahkan satu.</p>
            @endforelse
            {{-- AKHIR LOOPING --}}

            <a href="{{ route('addPaymentMethodView') }}" class="add-payment-btn" style="text-decoration:none; display: block;">
                <i class="bi bi-plus-circle-fill add-icon"></i>
                <span>Add New Payment Method</span>
            </a>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentCards = document.querySelectorAll('.payment-card');
            const form = document.getElementById('setDefaultForm');
            const inputId = document.getElementById('selectedPaymentId');

            paymentCards.forEach(card => {
                // Beri indikasi bahwa kartu bisa diklik
                card.style.cursor = 'pointer';

                card.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const isDefault = this.getAttribute('data-is-default');

                    // Jika sudah default, tidak perlu mengirim request lagi
                    if (isDefault == '1') {
                        console.log('Metode ini sudah menjadi default.');
                        return;
                    }

                    // Isi hidden input dengan ID yang dipilih
                    inputId.value = id;

                    // Submit form untuk mengatur metode pembayaran default
                    form.submit();
                });
            });
        });
    </script>
</body>
</html>
