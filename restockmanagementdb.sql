-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Nov 2025 pada 09.14
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restockmanagementdb`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `carts`
--

CREATE TABLE `carts` (
  `idCart` bigint(20) UNSIGNED NOT NULL,
  `idUser` bigint(20) UNSIGNED NOT NULL,
  `idStore` bigint(20) UNSIGNED NOT NULL,
  `cartDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','submitted','converted_to_invoice') NOT NULL DEFAULT 'pending',
  `restockProof` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `carts`
--

INSERT INTO `carts` (`idCart`, `idUser`, `idStore`, `cartDate`, `status`, `restockProof`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2025-11-10 02:30:00', '', 'proofs/restock_001.jpg', '2025-11-11 07:48:37', '2025-11-11 07:48:37'),
(2, 2, 2, '2025-11-11 03:15:00', '', NULL, '2025-11-11 07:48:37', '2025-11-11 07:48:37'),
(3, 2, 3, '2025-11-09 07:20:00', '', 'proofs/restock_003.jpg', '2025-11-11 07:48:37', '2025-11-11 07:48:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cart_items`
--

CREATE TABLE `cart_items` (
  `idCartItem` bigint(20) UNSIGNED NOT NULL,
  `idCart` bigint(20) UNSIGNED NOT NULL,
  `idItem` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `subTotal` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cart_items`
--

INSERT INTO `cart_items` (`idCartItem`, `idCart`, `idItem`, `quantity`, `subTotal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 50, 175000.00, '2025-11-11 07:49:02', '2025-11-11 07:49:02'),
(2, 1, 2, 30, 120000.00, '2025-11-11 07:49:02', '2025-11-11 07:49:02'),
(3, 1, 3, 20, 360000.00, '2025-11-11 07:49:02', '2025-11-11 07:49:02'),
(4, 2, 4, 25, 300000.00, '2025-11-11 07:49:02', '2025-11-11 07:49:02'),
(5, 2, 5, 15, 525000.00, '2025-11-11 07:49:02', '2025-11-11 07:49:02'),
(6, 3, 7, 40, 340000.00, '2025-11-11 07:49:02', '2025-11-11 07:49:02'),
(7, 3, 8, 25, 550000.00, '2025-11-11 07:49:02', '2025-11-11 07:49:02'),
(8, 3, 9, 30, 330000.00, '2025-11-11 07:49:02', '2025-11-11 07:49:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `invoices`
--

CREATE TABLE `invoices` (
  `idInvoice` bigint(20) UNSIGNED NOT NULL,
  `idCart` bigint(20) UNSIGNED NOT NULL,
  `idRestocker` bigint(20) UNSIGNED NOT NULL,
  `idStoreOwner` bigint(20) UNSIGNED NOT NULL,
  `invoiceDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `totalAmount` decimal(15,2) NOT NULL,
  `status` enum('unpaid','paid','cancelled') NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `invoices`
--

INSERT INTO `invoices` (`idInvoice`, `idCart`, `idRestocker`, `idStoreOwner`, `invoiceDate`, `totalAmount`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, '2025-11-10 03:00:00', 655000.00, 'paid', '2025-11-11 07:49:39', '2025-11-11 07:49:39'),
(2, 3, 2, 3, '2025-11-09 08:00:00', 1220000.00, 'paid', '2025-11-11 07:49:39', '2025-11-11 07:49:39'),
(3, 2, 2, 3, '2025-11-11 04:00:00', 825000.00, 'unpaid', '2025-11-11 07:49:39', '2025-11-11 07:49:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `items`
--

CREATE TABLE `items` (
  `idItem` bigint(20) UNSIGNED NOT NULL,
  `idStore` bigint(20) UNSIGNED NOT NULL,
  `itemName` varchar(255) NOT NULL,
  `itemPrice` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `items`
--

INSERT INTO `items` (`idItem`, `idStore`, `itemName`, `itemPrice`, `created_at`, `updated_at`) VALUES
(1, 1, 'Indomie Goreng', 3500.00, '2025-11-11 07:43:58', '2025-11-11 07:43:58'),
(2, 1, 'Aqua 600ml', 4000.00, '2025-11-11 07:43:58', '2025-11-11 07:43:58'),
(3, 1, 'Susu Ultra Milk 1L', 18000.00, '2025-11-11 07:43:58', '2025-11-11 07:43:58'),
(4, 2, 'Kopi Kapal Api', 12000.00, '2025-11-11 07:43:58', '2025-11-11 07:43:58'),
(5, 2, 'Minyak Goreng Bimoli 2L', 35000.00, '2025-11-11 07:43:58', '2025-11-11 07:43:58'),
(6, 2, 'Gula Pasir 1kg', 15000.00, '2025-11-11 07:43:58', '2025-11-11 07:43:58'),
(7, 3, 'Sabun Lifebuoy', 8500.00, '2025-11-11 07:43:58', '2025-11-11 07:43:58'),
(8, 3, 'Shampo Pantene 170ml', 22000.00, '2025-11-11 07:43:58', '2025-11-11 07:43:58'),
(9, 3, 'Pasta Gigi Pepsodent', 11000.00, '2025-11-11 07:43:58', '2025-11-11 07:43:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `payments`
--

CREATE TABLE `payments` (
  `idPayment` bigint(20) UNSIGNED NOT NULL,
  `idInvoice` bigint(20) UNSIGNED NOT NULL,
  `idUserPaymentType` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `paymentDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','comfirmed','failed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `payments`
--

INSERT INTO `payments` (`idPayment`, `idInvoice`, `idUserPaymentType`, `amount`, `paymentDate`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 655000.00, '2025-11-10 04:30:00', '', '2025-11-11 07:49:51', '2025-11-11 07:49:51'),
(2, 2, 5, 1220000.00, '2025-11-09 09:45:00', '', '2025-11-11 07:49:51', '2025-11-11 07:49:51'),
(3, 3, 5, 825000.00, '2025-11-11 05:00:00', 'pending', '2025-11-11 07:49:51', '2025-11-11 07:49:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment_types`
--

CREATE TABLE `payment_types` (
  `idPaymentType` bigint(20) UNSIGNED NOT NULL,
  `paymentName` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `payment_types`
--

INSERT INTO `payment_types` (`idPaymentType`, `paymentName`, `created_at`, `updated_at`) VALUES
(1, 'Bank Transfer - BCA', '2025-11-11 07:49:15', '2025-11-11 07:49:15'),
(2, 'Bank Transfer - Mandiri', '2025-11-11 07:49:15', '2025-11-11 07:49:15'),
(3, 'E-Wallet - GoPay', '2025-11-11 07:49:15', '2025-11-11 07:49:15'),
(4, 'E-Wallet - OVO', '2025-11-11 07:49:15', '2025-11-11 07:49:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stores`
--

CREATE TABLE `stores` (
  `idStore` bigint(20) UNSIGNED NOT NULL,
  `idUser` bigint(20) UNSIGNED NOT NULL,
  `storeName` varchar(255) NOT NULL,
  `storeAddress` text NOT NULL,
  `storePic` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `stores`
--

INSERT INTO `stores` (`idStore`, `idUser`, `storeName`, `storeAddress`, `storePic`, `created_at`, `updated_at`) VALUES
(1, 1, 'John\'s Grocery Store', 'Jl. Merdeka No. 123, Jakarta Pusat', 'Your daily needs, our priority', '2025-11-11 07:37:13', '2025-11-11 07:37:13'),
(2, 3, 'Mike\'s Mini Market', 'Jl. Sudirman No. 456, Jakarta Selatan', 'Quality products at affordable prices', '2025-11-11 07:37:13', '2025-11-11 07:37:13'),
(3, 3, 'Wilson Mart', 'Jl. Gatot Subroto No. 789, Jakarta Barat', 'One-stop shopping destination', '2025-11-11 07:37:13', '2025-11-11 07:37:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `idUser` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nickname` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `profilepic` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`idUser`, `email`, `username`, `password`, `nickname`, `description`, `profilepic`, `created_at`, `updated_at`) VALUES
(1, 'john.doe@example.com', 'johndoe', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Johnny', 'Store owner with 5 years experience', 'profiles/john.jpg', '2025-11-11 07:36:03', '2025-11-11 07:36:03'),
(2, 'jane.smith@example.com', 'janesmith', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jane', 'Professional restocker and inventory manager', 'profiles/jane.jpg', '2025-11-11 07:36:03', '2025-11-11 07:36:03'),
(3, 'mike.wilson@example.com', 'mikewilson', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Mike', 'Multi-store owner and entrepreneur', 'profiles/mike.jpg', '2025-11-11 07:36:03', '2025-11-11 07:36:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_payment_types`
--

CREATE TABLE `user_payment_types` (
  `idUserPaymentType` bigint(20) UNSIGNED NOT NULL,
  `idUser` bigint(20) UNSIGNED NOT NULL,
  `idPaymentType` bigint(20) UNSIGNED NOT NULL,
  `paymentDetails` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `user_payment_types`
--

INSERT INTO `user_payment_types` (`idUserPaymentType`, `idUser`, `idPaymentType`, `paymentDetails`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '{\"account_number\": \"1234567890\", \"account_name\": \"John Doe\"}', '2025-11-11 07:49:27', '2025-11-11 07:49:27'),
(2, 1, 3, '{\"phone\": \"081234567890\", \"name\": \"John Doe\"}', '2025-11-11 07:49:27', '2025-11-11 07:49:27'),
(3, 2, 2, '{\"account_number\": \"9876543210\", \"account_name\": \"Jane Smith\"}', '2025-11-11 07:49:27', '2025-11-11 07:49:27'),
(4, 2, 4, '{\"phone\": \"082345678901\", \"name\": \"Jane Smith\"}', '2025-11-11 07:49:27', '2025-11-11 07:49:27'),
(5, 3, 1, '{\"account_number\": \"5555666677\", \"account_name\": \"Mike Wilson\"}', '2025-11-11 07:49:27', '2025-11-11 07:49:27'),
(6, 3, 3, '{\"phone\": \"083456789012\", \"name\": \"Mike Wilson\"}', '2025-11-11 07:49:27', '2025-11-11 07:49:27');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`idCart`),
  ADD KEY `idx_idUser` (`idUser`),
  ADD KEY `idx_idStore` (`idStore`),
  ADD KEY `idx_status` (`status`);

--
-- Indeks untuk tabel `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`idCartItem`),
  ADD KEY `idx_idCart` (`idCart`),
  ADD KEY `idx_idItem` (`idItem`);

--
-- Indeks untuk tabel `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`idInvoice`),
  ADD KEY `idx_idCart` (`idCart`),
  ADD KEY `idx_idRestocker` (`idRestocker`),
  ADD KEY `idx_idStoreOwner` (`idStoreOwner`),
  ADD KEY `idx_status` (`status`);

--
-- Indeks untuk tabel `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`idItem`),
  ADD KEY `idx_idStore` (`idStore`);

--
-- Indeks untuk tabel `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`idPayment`),
  ADD KEY `idx_idInvoice` (`idInvoice`),
  ADD KEY `idx_idUserPaymentType` (`idUserPaymentType`),
  ADD KEY `idx_status` (`status`);

--
-- Indeks untuk tabel `payment_types`
--
ALTER TABLE `payment_types`
  ADD PRIMARY KEY (`idPaymentType`);

--
-- Indeks untuk tabel `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`idStore`),
  ADD KEY `idx_idUser` (`idUser`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUser`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_username` (`username`);

--
-- Indeks untuk tabel `user_payment_types`
--
ALTER TABLE `user_payment_types`
  ADD PRIMARY KEY (`idUserPaymentType`),
  ADD KEY `idx_idUser` (`idUser`),
  ADD KEY `idx_idPaymentType` (`idPaymentType`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `carts`
--
ALTER TABLE `carts`
  MODIFY `idCart` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `idCartItem` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `invoices`
--
ALTER TABLE `invoices`
  MODIFY `idInvoice` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `items`
--
ALTER TABLE `items`
  MODIFY `idItem` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `payments`
--
ALTER TABLE `payments`
  MODIFY `idPayment` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `payment_types`
--
ALTER TABLE `payment_types`
  MODIFY `idPaymentType` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `stores`
--
ALTER TABLE `stores`
  MODIFY `idStore` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `idUser` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user_payment_types`
--
ALTER TABLE `user_payment_types`
  MODIFY `idUserPaymentType` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`idStore`) REFERENCES `stores` (`idStore`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`idCart`) REFERENCES `carts` (`idCart`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`idItem`) REFERENCES `items` (`idItem`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`idCart`) REFERENCES `carts` (`idCart`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoices_ibfk_2` FOREIGN KEY (`idRestocker`) REFERENCES `users` (`idUser`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoices_ibfk_3` FOREIGN KEY (`idStoreOwner`) REFERENCES `users` (`idUser`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`idStore`) REFERENCES `stores` (`idStore`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`idInvoice`) REFERENCES `invoices` (`idInvoice`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`idUserPaymentType`) REFERENCES `user_payment_types` (`idUserPaymentType`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `stores`
--
ALTER TABLE `stores`
  ADD CONSTRAINT `fk_stores_idUser` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user_payment_types`
--
ALTER TABLE `user_payment_types`
  ADD CONSTRAINT `user_payment_types_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_payment_types_ibfk_2` FOREIGN KEY (`idPaymentType`) REFERENCES `payment_types` (`idPaymentType`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
