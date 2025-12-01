-- Hapus semua sintaks MySQL/phpMyAdmin header yang tidak dikenali SQL Server
-- SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
-- START TRANSACTION;
-- SET time_zone = "+00:00";
-- /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
-- /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
-- /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
-- /*!40101 SET NAMES utf8mb4 */;

--------------------------------------------------------
-- Database: `restockmanagementdb`
-- (Asumsikan Anda sudah membuat database kosong dengan nama yang sama)
-- USE restockmanagementdb;

--------------------------------------------------------
-- Struktur dari tabel `users`
--------------------------------------------------------

CREATE TABLE users (
  -- Ganti bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT menjadi bigint IDENTITY(1,1) PRIMARY KEY
  idUser bigint IDENTITY(1,1) PRIMARY KEY NOT NULL,
  email varchar(255) NOT NULL UNIQUE, -- Tambah UNIQUE di sini
  username varchar(100) NOT NULL UNIQUE, -- Tambah UNIQUE di sini
  password varchar(255) NOT NULL,
  nickname varchar(100) NULL,
  description text NULL,
  profilepic varchar(255) NULL,
  -- Ganti timestamp menjadi datetime
  created_at datetime NULL,
  updated_at datetime NULL
);

-- Dumping data untuk tabel `users`
SET IDENTITY_INSERT users ON; -- Perlu agar bisa memasukkan nilai idUser secara manual
INSERT INTO users (idUser, email, username, password, nickname, description, profilepic, created_at, updated_at) VALUES
(1, 'john.doe@example.com', 'johndoe', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Johnny', 'Store owner with 5 years experience', 'profiles/john.jpg', '2025-11-11 07:36:03', '2025-11-11 07:36:03'),
(2, 'jane.smith@example.com', 'janesmith', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jane', 'Professional restocker and inventory manager', 'profiles/jane.jpg', '2025-11-11 07:36:03', '2025-11-11 07:36:03'),
(3, 'mike.wilson@example.com', 'mikewilson', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Mike', 'Multi-store owner and entrepreneur', 'profiles/mike.jpg', '2025-11-11 07:36:03', '2025-11-11 07:36:03');
SET IDENTITY_INSERT users OFF;

--------------------------------------------------------
-- Struktur dari tabel `stores`
--------------------------------------------------------

CREATE TABLE stores (
  idStore bigint IDENTITY(1,1) PRIMARY KEY NOT NULL,
  idUser bigint NOT NULL,
  storeName varchar(255) NOT NULL,
  storeAddress text NOT NULL,
  storePic text NULL,
  created_at datetime NULL,
  updated_at datetime NULL
);

-- Dumping data untuk tabel `stores`
SET IDENTITY_INSERT stores ON;
INSERT INTO stores (idStore, idUser, storeName, storeAddress, storePic, created_at, updated_at) VALUES
(1, 1, 'John''s Grocery Store', 'Jl. Merdeka No. 123, Jakarta Pusat', 'Your daily needs, our priority', '2025-11-11 07:37:13', '2025-11-11 07:37:13'),
(2, 3, 'Mike''s Mini Market', 'Jl. Sudirman No. 456, Jakarta Selatan', 'Quality products at affordable prices', '2025-11-11 07:37:13', '2025-11-11 07:37:13'),
(3, 3, 'Wilson Mart', 'Jl. Gatot Subroto No. 789, Jakarta Barat', 'One-stop shopping destination', '2025-11-11 07:37:13', '2025-11-11 07:37:13');
SET IDENTITY_INSERT stores OFF;

--------------------------------------------------------
-- Struktur dari tabel `payment_types`
--------------------------------------------------------

CREATE TABLE payment_types (
  idPaymentType bigint IDENTITY(1,1) PRIMARY KEY NOT NULL,
  paymentName varchar(100) NOT NULL,
  created_at datetime NULL,
  updated_at datetime NULL
);

-- Dumping data untuk tabel `payment_types`
SET IDENTITY_INSERT payment_types ON;
INSERT INTO payment_types (idPaymentType, paymentName, created_at, updated_at) VALUES
(1, 'Bank Transfer - BCA', '2025-11-11 07:49:15', '2025-11-11 07:49:15'),
(2, 'Bank Transfer - Mandiri', '2025-11-11 07:49:15', '2025-11-11 07:49:15'),
(3, 'E-Wallet - GoPay', '2025-11-11 07:49:15', '2025-11-11 07:49:15'),
(4, 'E-Wallet - OVO', '2025-11-11 07:49:15', '2025-11-11 07:49:15');
SET IDENTITY_INSERT payment_types OFF;

--------------------------------------------------------
-- Struktur dari tabel `user_payment_types`
--------------------------------------------------------

CREATE TABLE user_payment_types (
  idUserPaymentType bigint IDENTITY(1,1) PRIMARY KEY NOT NULL,
  idUser bigint NOT NULL,
  idPaymentType bigint NOT NULL,
  paymentDetails text NULL,
  created_at datetime NULL,
  updated_at datetime NULL
);

-- Dumping data untuk tabel `user_payment_types`
SET IDENTITY_INSERT user_payment_types ON;
INSERT INTO user_payment_types (idUserPaymentType, idUser, idPaymentType, paymentDetails, created_at, updated_at) VALUES
(1, 1, 1, '{"account_number": "1234567890", "account_name": "John Doe"}', '2025-11-11 07:49:27', '2025-11-11 07:49:27'),
(2, 1, 3, '{"phone": "081234567890", "name": "John Doe"}', '2025-11-11 07:49:27', '2025-11-11 07:49:27'),
(3, 2, 2, '{"account_number": "9876543210", "account_name": "Jane Smith"}', '2025-11-11 07:49:27', '2025-11-11 07:49:27'),
(4, 2, 4, '{"phone": "082345678901", "name": "Jane Smith"}', '2025-11-11 07:49:27', '2025-11-11 07:49:27'),
(5, 3, 1, '{"account_number": "5555666677", "account_name": "Mike Wilson"}', '2025-11-11 07:49:27', '2025-11-11 07:49:27'),
(6, 3, 3, '{"phone": "083456789012", "name": "Mike Wilson"}', '2025-11-11 07:49:27', '2025-11-11 07:49:27');
SET IDENTITY_INSERT user_payment_types OFF;

--------------------------------------------------------

-- Struktur dari tabel `carts`
--------------------------------------------------------

CREATE TABLE carts (
  idCart bigint IDENTITY(1,1) PRIMARY KEY NOT NULL,
  idUser bigint NOT NULL,
  idStore bigint NOT NULL,
  -- Ganti current_timestamp() menjadi GETDATE()
  cartDate datetime NOT NULL DEFAULT GETDATE(), 
  -- Ganti ENUM menjadi VARCHAR(50)
  status varchar(50) NOT NULL DEFAULT 'pending', 
  restockProof varchar(255) NULL,
  created_at datetime NULL,
  updated_at datetime NULL
);

-- Dumping data untuk tabel `carts`
SET IDENTITY_INSERT carts ON;
INSERT INTO carts (idCart, idUser, idStore, cartDate, status, restockProof, created_at, updated_at) VALUES
(1, 2, 1, '2025-11-10 02:30:00', 'submitted', 'proofs/restock_001.jpg', '2025-11-11 07:48:37', '2025-11-11 07:48:37'), -- Diperbaiki status menjadi nilai valid
(2, 2, 2, '2025-11-11 03:15:00', 'pending', NULL, '2025-11-11 07:48:37', '2025-11-11 07:48:37'), -- Diperbaiki status menjadi nilai valid
(3, 2, 3, '2025-11-09 07:20:00', 'submitted', 'proofs/restock_003.jpg', '2025-11-11 07:48:37', '2025-11-11 07:48:37'); -- Diperbaiki status menjadi nilai valid
SET IDENTITY_INSERT carts OFF;

--------------------------------------------------------
-- Struktur dari tabel `items`
--------------------------------------------------------

CREATE TABLE items (
  idItem bigint IDENTITY(1,1) PRIMARY KEY NOT NULL,
  idStore bigint NOT NULL,
  itemName varchar(255) NOT NULL,
  -- DECIMAL(15,2) tetap sama
  itemPrice decimal(15,2) NOT NULL,
  created_at datetime NULL,
  updated_at datetime NULL
);

-- Dumping data untuk tabel `items`
SET IDENTITY_INSERT items ON;
INSERT INTO items (idItem, idStore, itemName, itemPrice, created_at, updated_at) VALUES
(1, 1, 'Indomie Goreng', 3500.00, '2025-11-11 07:43:58', '2025-11-11 07:43:58'),
(2, 1, 'Aqua 600ml', 4000.00, '2025-11-11 07:43:58', '2025-11-11 07:43:58'),
(3, 1, 'Susu Ultra Milk 1L', 18000.00, '2025-11-11 07:43:58', '2025-11-11 07:43:58'),
(4, 2, 'Kopi Kapal Api', 12000.00, '2025-11-11 07:43:58', '2025-11-11 07:43:58'),
(5, 2, 'Minyak Goreng Bimoli 2L', 35000.00, '2025-11-11 07:43:58', '2025-11-11 07:43:58'),
(6, 2, 'Gula Pasir 1kg', 15000.00, '2025-11-11 07:43:58', '2025-11-11 07:43:58'),
(7, 3, 'Sabun Lifebuoy', 8500.00, '2025-11-11 07:43:58', '2025-11-11 07:43:58'),
(8, 3, 'Shampo Pantene 170ml', 22000.00, '2025-11-11 07:43:58', '2025-11-11 07:43:58'),
(9, 3, 'Pasta Gigi Pepsodent', 11000.00, '2025-11-11 07:43:58', '2025-11-11 07:43:58');
SET IDENTITY_INSERT items OFF;

--------------------------------------------------------
-- Struktur dari tabel `cart_items`
--------------------------------------------------------

CREATE TABLE cart_items (
  idCartItem bigint IDENTITY(1,1) PRIMARY KEY NOT NULL,
  idCart bigint NOT NULL,
  idItem bigint NOT NULL,
  quantity int NOT NULL DEFAULT 1,
  subTotal decimal(15,2) NOT NULL,
  created_at datetime NULL,
  updated_at datetime NULL
);

-- Dumping data untuk tabel `cart_items`
SET IDENTITY_INSERT cart_items ON;
INSERT INTO cart_items (idCartItem, idCart, idItem, quantity, subTotal, created_at, updated_at) VALUES
(1, 1, 1, 50, 175000.00, '2025-11-11 07:49:02', '2025-11-11 07:49:02'),
(2, 1, 2, 30, 120000.00, '2025-11-11 07:49:02', '2025-11-11 07:49:02'),
(3, 1, 3, 20, 360000.00, '2025-11-11 07:49:02', '2025-11-11 07:49:02'),
(4, 2, 4, 25, 300000.00, '2025-11-11 07:49:02', '2025-11-11 07:49:02'),
(5, 2, 5, 15, 525000.00, '2025-11-11 07:49:02', '2025-11-11 07:49:02'),
(6, 3, 7, 40, 340000.00, '2025-11-11 07:49:02', '2025-11-11 07:49:02'),
(7, 3, 8, 25, 550000.00, '2025-11-11 07:49:02', '2025-11-11 07:49:02'),
(8, 3, 9, 30, 330000.00, '2025-11-11 07:49:02', '2025-11-11 07:49:02');
SET IDENTITY_INSERT cart_items OFF;

--------------------------------------------------------
-- Struktur dari tabel `invoices`
--------------------------------------------------------

CREATE TABLE invoices (
  idInvoice bigint IDENTITY(1,1) PRIMARY KEY NOT NULL,
  idCart bigint NOT NULL,
  idRestocker bigint NOT NULL,
  idStoreOwner bigint NOT NULL,
  invoiceDate datetime NOT NULL DEFAULT GETDATE(),
  totalAmount decimal(15,2) NOT NULL,
  -- Ganti ENUM menjadi VARCHAR(50)
  status varchar(50) NOT NULL DEFAULT 'unpaid', 
  created_at datetime NULL,
  updated_at datetime NULL
);

-- Dumping data untuk tabel `invoices`
SET IDENTITY_INSERT invoices ON;
INSERT INTO invoices (idInvoice, idCart, idRestocker, idStoreOwner, invoiceDate, totalAmount, status, created_at, updated_at) VALUES
(1, 1, 2, 1, '2025-11-10 03:00:00', 655000.00, 'paid', '2025-11-11 07:49:39', '2025-11-11 07:49:39'),
(2, 3, 2, 3, '2025-11-09 08:00:00', 1220000.00, 'paid', '2025-11-11 07:49:39', '2025-11-11 07:49:39'),
(3, 2, 2, 3, '2025-11-11 04:00:00', 825000.00, 'unpaid', '2025-11-11 07:49:39', '2025-11-11 07:49:39');
SET IDENTITY_INSERT invoices OFF;

--------------------------------------------------------
-- Struktur dari tabel `payments`
--------------------------------------------------------

CREATE TABLE payments (
  idPayment bigint IDENTITY(1,1) PRIMARY KEY NOT NULL,
  idInvoice bigint NOT NULL,
  idUserPaymentType bigint NOT NULL,
  amount decimal(15,2) NOT NULL,
  paymentDate datetime NOT NULL DEFAULT GETDATE(),
  -- Ganti ENUM menjadi VARCHAR(50)
  status varchar(50) NOT NULL DEFAULT 'pending', 
  created_at datetime NULL,
  updated_at datetime NULL
);

-- Dumping data untuk tabel `payments`
SET IDENTITY_INSERT payments ON;
INSERT INTO payments (idPayment, idInvoice, idUserPaymentType, amount, paymentDate, status, created_at, updated_at) VALUES
(1, 1, 1, 655000.00, '2025-11-10 04:30:00', 'comfirmed', '2025-11-11 07:49:51', '2025-11-11 07:49:51'), -- Diperbaiki status menjadi nilai valid
(2, 2, 5, 1220000.00, '2025-11-09 09:45:00', 'comfirmed', '2025-11-11 07:49:51', '2025-11-11 07:49:51'), -- Diperbaiki status menjadi nilai valid
(3, 3, 5, 825000.00, '2025-11-11 05:00:00', 'pending', '2025-11-11 07:49:51', '2025-11-11 07:49:51');
SET IDENTITY_INSERT payments OFF;

--------------------------------------------------------
-- Penambahan Foreign Key Constraints (FK) di akhir
--------------------------------------------------------

-- FK untuk `stores`
ALTER TABLE stores
ADD CONSTRAINT FK_stores_idUser FOREIGN KEY (idUser) 
REFERENCES users (idUser) 
ON DELETE NO ACTION -- 1. FIX: Mencegah jalur ganda users -> carts
ON UPDATE NO ACTION;

-- FK untuk `carts`
ALTER TABLE carts
ADD CONSTRAINT FK_carts_idUser FOREIGN KEY (idUser) 
REFERENCES users (idUser) 
ON DELETE CASCADE -- Dipertahankan: Menghapus cart jika user (restocker) dihapus
ON UPDATE NO ACTION,
CONSTRAINT FK_carts_idStore FOREIGN KEY (idStore) 
REFERENCES stores (idStore) 
ON DELETE NO ACTION -- 2. FIX: Mencegah jalur ganda stores -> cart_items
ON UPDATE NO ACTION;

-- FK untuk `items`
ALTER TABLE items
ADD CONSTRAINT FK_items_idStore FOREIGN KEY (idStore) 
REFERENCES stores (idStore) 
ON DELETE NO ACTION -- Mencegah jalur ganda stores -> cart_items (Dipertahankan dari solusi sebelumnya)
ON UPDATE NO ACTION;

-- FK untuk `cart_items`
ALTER TABLE cart_items
ADD CONSTRAINT FK_cart_items_idCart FOREIGN KEY (idCart) 
REFERENCES carts (idCart) 
ON DELETE CASCADE -- Dipertahankan: Cart Item harus dihapus jika Cart dihapus
ON UPDATE NO ACTION,
CONSTRAINT FK_cart_items_idItem FOREIGN KEY (idItem) 
REFERENCES items (idItem) 
ON DELETE CASCADE -- Dipertahankan: Cart Item harus dihapus jika Item dihapus
ON UPDATE NO ACTION;

-- FK untuk `invoices`
ALTER TABLE invoices
ADD CONSTRAINT FK_invoices_idCart FOREIGN KEY (idCart) 
REFERENCES carts (idCart) 
ON DELETE CASCADE -- Dipertahankan: Invoice harus dihapus jika Cart dihapus
ON UPDATE NO ACTION,
CONSTRAINT FK_invoices_idRestocker FOREIGN KEY (idRestocker) 
REFERENCES users (idUser) 
ON DELETE NO ACTION -- Dipertahankan: Restocker dihapus, Invoice tidak otomatis dihapus
ON UPDATE NO ACTION,
CONSTRAINT FK_invoices_idStoreOwner FOREIGN KEY (idStoreOwner) 
REFERENCES users (idUser) 
ON DELETE NO ACTION -- Dipertahankan: Store Owner dihapus, Invoice tidak otomatis dihapus
ON UPDATE NO ACTION;

-- FK untuk `user_payment_types`
ALTER TABLE user_payment_types
ADD CONSTRAINT FK_upt_idUser FOREIGN KEY (idUser) 
REFERENCES users (idUser) 
ON DELETE CASCADE -- Dipertahankan: User Payment Type dihapus jika User dihapus
ON UPDATE NO ACTION,
CONSTRAINT FK_upt_idPaymentType FOREIGN KEY (idPaymentType) 
REFERENCES payment_types (idPaymentType) 
ON DELETE CASCADE -- Dipertahankan: User Payment Type dihapus jika Payment Type dihapus
ON UPDATE NO ACTION;

-- FK untuk `payments`
ALTER TABLE payments
ADD CONSTRAINT FK_payments_idInvoice FOREIGN KEY (idInvoice) 
REFERENCES invoices (idInvoice) 
ON DELETE CASCADE -- Dipertahankan: Payment harus dihapus jika Invoice dihapus
ON UPDATE NO ACTION,
CONSTRAINT FK_payments_idUserPaymentType FOREIGN KEY (idUserPaymentType) 
REFERENCES user_payment_types (idUserPaymentType) 
ON DELETE NO ACTION -- 3. FIX: Mencegah jalur ganda users -> payments (Error terakhir Anda)
ON UPDATE NO ACTION;
