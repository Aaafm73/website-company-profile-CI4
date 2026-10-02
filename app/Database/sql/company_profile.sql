-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2026 at 03:59 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `company_profile`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `role` enum('admin','editor') NOT NULL DEFAULT 'editor',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `email`, `password`, `full_name`, `role`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@vegetarian.com', '$2y$10$VcgMjP4EHWo5jvt8NaY7be78wNqs/aKBYEE80nPuUOJyty4bk97Rq', 'Administrator', 'admin', 1, '2026-09-30 14:47:00', '2026-05-17 08:59:53', '2026-09-30 14:47:00');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(3, 'Dessert'),
(6, 'Lainnya'),
(5, 'Makanan Jadi'),
(2, 'Minuman'),
(1, 'Protein'),
(4, 'Sayuran');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('new','read','replied') NOT NULL DEFAULT 'new',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `subject`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Afif Firman', 'afif.firman19@gmail.com', '082262121210', 'pengajuan kerja sama', 'lorem ipsum doloor sit ametw', 'read', '2026-05-17 23:54:34', '2026-05-17 23:55:06'),
(2, 'Afif Firman', 'afif.firman19@gmail.com', '082262121210', 'pengajuan kerja sama', 'lorem ipsum dolor sit amet nyan varuq golar patikaj burij', 'replied', '2026-05-19 14:16:18', '2026-05-19 14:17:31'),
(3, 'Afif Firman', 'afif.firman19@gmail.com', '082262121210', 'pengajuan kerja sama', 'saya tertarik untuk menjalin kerja sama dengan vegetarian paradise.', 'read', '2026-05-26 04:34:01', '2026-05-26 04:34:20');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2024-01-01-000001', 'App\\Database\\Migrations\\CreateProductsTable', 'default', 'App', 1779008381, 1),
(2, '2024-01-01-000002', 'App\\Database\\Migrations\\CreateOrdersTable', 'default', 'App', 1779008381, 1),
(3, '2024-01-01-000003', 'App\\Database\\Migrations\\CreateOrderItemsTable', 'default', 'App', 1779008381, 1),
(4, '2024-01-01-000004', 'App\\Database\\Migrations\\CreateContactsTable', 'default', 'App', 1779008381, 1),
(5, '2024-01-01-000005', 'App\\Database\\Migrations\\CreateAdminUsersTable', 'default', 'App', 1779008381, 1),
(6, '2024-01-01-000006', 'App\\Database\\Migrations\\CreateSettingsTable', 'default', 'App', 1779008381, 1),
(7, '2024-01-01-000007', 'App\\Database\\Migrations\\NormalizeProductCategories', 'default', 'App', 1790588473, 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) UNSIGNED NOT NULL,
  `order_number` varchar(100) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `customer_address` text NOT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `status` enum('pending','confirmed','processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `payment_method` varchar(100) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `customer_name`, `customer_email`, `customer_phone`, `customer_address`, `total_amount`, `status`, `payment_method`, `notes`, `created_at`, `updated_at`) VALUES
(2, 'ORD-20260519-0001', 'Jojo', 'jojo@speedwagon.com', '082262121210', 'rumahku', 75000.00, 'delivered', 'cod', 'mau lawan zombie', '2026-05-19 03:41:19', '2026-05-19 03:43:20'),
(3, 'ORD-20260519-0002', 'Afif Firman', 'afif.firman19@gmail.com', '082262121210', 'Lamandau', 45000.00, 'delivered', 'transfer', '', '2026-05-19 14:46:00', '2026-05-19 14:46:47'),
(4, 'ORD-20260526-0003', 'Afif Firman', 'afif.firman19@gmail.com', '082262121210', 'Lamandau', 24000.00, 'delivered', 'cod', 'saya mau cepat nyobain', '2026-05-26 04:31:03', '2026-05-30 04:41:18'),
(5, 'ORD-20260526-0004', 'Afif Firman', 'afif.firman19@gmail.com', '082262121210', 'Lamandau', 10000.00, 'shipped', 'cod', 'semoga hewannya sejahtera', '2026-05-26 04:38:54', '2026-05-26 04:39:58'),
(6, 'ORD-20260530-0005', 'Afif Firman', 'afif.firman19@gmail.com', '082262121210', 'Lamandau', 12000.00, 'delivered', 'cod', '', '2026-05-30 02:50:17', '2026-05-30 02:57:32'),
(7, 'ORD-20260530-0006', 'Afif Firman', 'afif.firman19@gmail.com', '082262121210', 'Lamandau', 12000.00, 'delivered', 'transfer', '', '2026-05-30 03:03:07', '2026-05-30 04:40:27'),
(8, 'ORD-20260530-0007', 'Afif Firman', 'afif.firman19@gmail.com', '082262121210', 'Lamandau', 10000.00, 'delivered', 'transfer', 'hallo', '2026-05-30 04:42:24', '2026-05-30 04:47:03'),
(9, 'ORD-20260530-0008', 'Afif Firman', 'afif.firman19@gmail.com', '082262121210', 'Lamandau', 90000.00, 'delivered', 'transfer', '', '2026-05-30 04:47:53', '2026-05-30 04:48:19'),
(10, 'ORD-20260602-0009', 'Afif Firman', 'afif.firman19@gmail.com', '082262121210', 'Lamandau', 75000.00, 'delivered', 'cod', '', '2026-06-02 04:15:28', '2026-09-28 09:47:50'),
(11, 'ORD-20260928-0010', 'Afif Firman', 'afif.firman19@gmail.com', '082262121210', 'Lamandau', 30000.00, 'delivered', 'cod', 'pesan yang segar', '2026-09-28 09:43:55', '2026-09-28 09:45:45'),
(12, 'ORD-20260928-0011', 'Afif Firman', 'afif.firman19@gmail.com', '082262121210', 'Lamandau', 33000.00, 'delivered', 'cod', '', '2026-09-28 10:42:13', '2026-09-28 10:43:01');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) UNSIGNED NOT NULL,
  `order_id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `subtotal`) VALUES
(2, 2, 11, 1, 75000.00, 75000.00),
(3, 3, 9, 1, 45000.00, 45000.00),
(4, 4, 2, 2, 12000.00, 24000.00),
(5, 5, 12, 2, 5000.00, 10000.00),
(6, 6, 2, 1, 12000.00, 12000.00),
(7, 7, 2, 1, 12000.00, 12000.00),
(8, 8, 12, 2, 5000.00, 10000.00),
(9, 9, 9, 2, 45000.00, 90000.00),
(10, 10, 11, 1, 75000.00, 75000.00),
(11, 11, 1, 2, 15000.00, 30000.00),
(12, 12, 5, 1, 18000.00, 18000.00),
(13, 12, 1, 1, 15000.00, 15000.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `category_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `stock`, `created_at`, `updated_at`, `category_id`) VALUES
(1, 'Tahu Organik Segar', 'Tahu organik berkualitas premium yang dibuat dari kacang kedelai pilihan.', 15000.00, 'uploads/products/1779017447_df5af4d352c6b77ecc84.jpg', 48, '2026-05-17 08:59:53', '2026-05-17 23:47:15', 1),
(2, 'Tempe Goreng', 'Tempe goreng renyah dengan cita rasa tradisional yang nikmat.', 12000.00, 'uploads/products/1779017432_cdc3166fb746f7ae30c1.jpg', 56, '2026-05-17 08:59:53', '2026-05-30 03:03:07', 1),
(5, 'Jus Buah Segar', 'Jus buah segar tanpa pengawet, dibuat fresh setiap hari.', 18000.00, 'uploads/products/1779074894_ed8fd7db9f112c2255b6.jpg', 70, '2026-05-17 08:59:53', '2026-05-18 03:28:14', 2),
(6, 'Salad Buah Premium', 'Salad buah premium dengan dressing madu yang sehat dan lezat.', 35000.00, 'uploads/products/1779074911_a904d81fa2def47d1d7f.jpg', 25, '2026-05-17 08:59:53', '2026-05-19 03:33:26', 3),
(7, 'Selada Segar Organik', 'Selada segar yang dibudidayakan tanpa pupuk kimia dan pestisida. Sepenuhnya menggunakan pupuk organik.', 20000.00, 'uploads/products/1779075076_0ea595df5c81e21ff40f.jpg', 30, '2026-05-18 03:31:16', '2026-05-18 03:33:04', 4),
(8, 'Kripik Buah dan Sayur MIX', 'dari buah dan sayur segar yang dikeringkan dan diolah menjadi kripik yang sehat dan lezat.', 40000.00, 'uploads/products/1779075174_acfd7e7766902496b93a.jpg', 50, '2026-05-18 03:32:54', '2026-05-18 03:32:54', 5),
(9, 'Brokoli Organik', 'Brokoli segar yang dibudidayakan tanpa bahan kimia dan sepenuhnya organik.', 45000.00, 'uploads/products/1779075278_2468dd1b204a73f89b94.jpg', 24, '2026-05-18 03:34:38', '2026-05-30 04:48:19', 4),
(11, 'Jamur', 'Bisa melawan Zombie', 75000.00, 'uploads/products/1779161532_e95e63b5d8670331083c.jpg', 7, '2026-05-19 03:32:12', '2026-06-02 04:16:54', 6),
(12, 'Telur Asin', 'ini telur asin berkualitas, dari hewan ternak bahagia.', 5000.00, 'uploads/products/1779770256_1ce22907c8d869b3e7d8.jpg', 16, '2026-05-26 04:37:36', '2026-05-30 04:42:24', 5);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) UNSIGNED NOT NULL,
  `key` varchar(100) NOT NULL,
  `value` longtext NOT NULL,
  `description` text DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `description`, `updated_at`) VALUES
(1, 'company_name', 'Vegetarian Paradise', 'Nama perusahaan', '2026-09-30 01:45:38'),
(2, 'company_tagline', 'Hidup Sehat Dimulai dari Pilihan Makanan yang Tepat', 'Tagline perusahaan', '2026-09-30 01:45:38'),
(3, 'company_description', 'Kami adalah perusahaan yang berkomitmen menyediakan produk vegetarian berkualitas tinggi untuk mendukung gaya hidup sehat Anda.', 'Deskripsi perusahaan', '2026-09-30 01:45:38'),
(4, 'company_phone', '+62 822 6212 1210', 'Nomor telepon perusahaan', '2026-09-30 01:45:38'),
(5, 'company_email', 'info@vegetarian.com', 'Email perusahaan', '2026-09-30 01:45:38'),
(6, 'company_address', 'Jl. Ahmad Yani, Sematu Jaya, Lamandau, Kalimantan Tengah', 'Alamat perusahaan', '2026-09-30 01:45:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_number` (`order_number`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`key`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
