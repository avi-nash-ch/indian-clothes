-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2025 at 05:42 PM
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
-- Database: `indianclothes`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `house_address` varchar(255) DEFAULT NULL,
  `street_address` varchar(255) DEFAULT NULL,
  `locality` varchar(255) DEFAULT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `long` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `customer_id`, `house_address`, `street_address`, `locality`, `landmark`, `pincode`, `lat`, `long`, `created_at`, `updated_at`) VALUES
(1, 1, '226', 'Gopal Nagar', 'Baben', 'Sugar Factory, Bardoli', '394601', '', '', '2025-03-23 09:44:48', '2025-03-23 09:44:48');

-- --------------------------------------------------------

--
-- Table structure for table `best_sellers`
--

CREATE TABLE `best_sellers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `type` tinyint(4) DEFAULT NULL COMMENT '1 = Explorer, 1 = Shop By Store, 3 = Party Time, 4 = Mobile And Accessories',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Shirts', 'admin/uploads/category/1742711162MoffIl4iRjUUlYGW-generated_image.jpg', 1, '2025-03-23 06:26:02', '2025-03-23 06:26:02'),
(2, 'Pants', 'admin/uploads/category/1742711306jkCdajcMSWaC0KrU-generated_image.jpg', 1, '2025-03-23 06:28:26', '2025-03-23 06:28:26'),
(3, 'Dresses', 'admin/uploads/category/1742711442ABWeylzz3jkdNZpk-generated_image.jpg', 1, '2025-03-23 06:30:42', '2025-03-23 06:30:42'),
(4, 'Jackets', 'admin/uploads/category/1742711566EA7XCLe6bwqyPbiy-generated_image.jpg', 1, '2025-03-23 06:32:46', '2025-03-23 06:32:46'),
(5, 'Skirts', 'admin/uploads/category/1742711690EUgfhB6vqF86Qtzr-generated_image.jpg', 1, '2025-03-23 06:34:50', '2025-03-23 06:34:50'),
(6, 'Sweaters', 'admin/uploads/category/1742711780bAygzX1gA43b5oxQ-generated_image.jpg', 1, '2025-03-23 06:36:20', '2025-03-23 06:36:20'),
(7, 'Shorts', 'admin/uploads/category/1742712279stylish_shorts.jpg', 1, '2025-03-23 06:44:39', '2025-03-23 06:44:39');

-- --------------------------------------------------------

--
-- Table structure for table `coupon_codes`
--

CREATE TABLE `coupon_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_code` varchar(255) NOT NULL,
  `offer` varchar(255) NOT NULL,
  `maximum_user` varchar(255) NOT NULL,
  `minimum_amount` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `simple_password` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `fcm` varchar(500) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = Unblock, 1 = Block',
  `mobile` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `address`, `password`, `simple_password`, `token`, `fcm`, `status`, `mobile`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Avinash Chaurasiya', 'avianshchaurasiya@gmail.com', NULL, '$2y$12$Pi0iTbwYQmruPTKV/2PYAOYCe8cawq5BH1QKb86JAxd5hogQGUol.', '1234', 'ccbe6ffe2d98db9ed5413ffdb6657368', NULL, 0, '8264886960', '2025-03-23 09:37:10', '2025-03-23 09:44:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `deliveryboy_payment_statuses`
--

CREATE TABLE `deliveryboy_payment_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `deliveryboy_id` bigint(20) UNSIGNED NOT NULL,
  `amount` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_boy_management`
--

CREATE TABLE `delivery_boy_management` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `simple_password` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `fcm` varchar(500) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = Unblock, 1 = Block',
  `address` varchar(255) DEFAULT NULL,
  `adhar_no` varchar(255) DEFAULT NULL,
  `license_no` varchar(12) DEFAULT NULL,
  `pan_no` varchar(10) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `wallet` varchar(255) DEFAULT NULL,
  `delivery_charge` varchar(255) DEFAULT NULL,
  `vehicle_no` varchar(255) DEFAULT NULL,
  `vehicle_desc` varchar(255) DEFAULT NULL,
  `delivery_amount` varchar(255) DEFAULT NULL,
  `salary` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_charges`
--

CREATE TABLE `delivery_charges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `min` varchar(255) NOT NULL,
  `max` varchar(255) NOT NULL,
  `delivery_charge` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2023_12_15_104822_create_sessions_table', 1),
(7, '2024_03_04_152231_create_customers_table', 1),
(8, '2024_03_04_161825_create_otps_table', 1),
(9, '2024_03_11_103411_create_promotional_banners_table', 1),
(10, '2024_03_11_111337_create_offer_banners_table', 1),
(11, '2024_03_11_114325_create_categories_table', 1),
(12, '2024_03_11_123748_create_sub_categories_table', 1),
(13, '2024_03_11_131758_create_products_table', 1),
(14, '2024_03_11_163809_create_settings_table', 1),
(15, '2024_03_11_180345_add_column_to_customers_table', 1),
(16, '2024_03_11_182813_add_status_column_to_customers_table', 1),
(17, '2024_03_11_184124_create_delivery_boy_management_table', 1),
(18, '2024_03_12_105110_create_delivery_charges_table', 1),
(19, '2024_03_12_111953_create_addresses_table', 1),
(20, '2024_03_12_112040_create_orders_table', 1),
(21, '2024_03_12_132045_create_reports_table', 1),
(22, '2024_03_12_155605_add_newcolumn_to_settings_table', 1),
(23, '2024_03_12_164639_add_newcolumn_to_products_table', 1),
(24, '2024_03_13_111350_change_email_column_nullable_to_customers_table', 1),
(25, '2024_03_13_111904_create_units_table', 1),
(26, '2024_03_13_120328_add_unit_to_products_table', 1),
(27, '2024_03_13_152105_create_sponsored_banners_table', 1),
(28, '2024_03_14_112124_create_carts_table', 1),
(29, '2024_03_14_165251_add_column_to_delivery_boy_management_table', 1),
(30, '2024_03_14_173342_add_deliverycharge_to_delivery_boy_management_table', 1),
(31, '2024_03_14_190133_add_assign_deliveryboy_to_orders_table', 1),
(32, '2024_03_15_114253_drop_orders_table', 1),
(33, '2024_03_15_114414_create_orders_table', 1),
(34, '2024_03_15_115049_create_order_mapped_products_table', 1),
(35, '2024_03_15_120600_add_dicountprice_to_products_table', 1),
(36, '2024_03_15_122231_add_disountprice_to_products_table', 1),
(37, '2024_03_15_125917_add_column_to_orders_table', 1),
(38, '2024_03_15_150645_create_offer_products_table', 1),
(39, '2024_03_19_111559_dropcolumn_to_addresses_table', 1),
(40, '2024_03_19_111750_add_column_to_addresses_table', 1),
(41, '2024_03_19_113727_dropcolumn_to_orders_table', 1),
(42, '2024_03_19_113815_add_column_to_orders_table', 1),
(43, '2024_03_20_125840_dropcolumn_to_products_table', 1),
(44, '2024_03_20_130237_add_column_to_products_table', 1),
(45, '2024_03_20_135409_create_best_sellers_table', 1),
(46, '2024_03_20_174122_add_column_to_sub_categories_table', 1),
(47, '2024_03_21_114407_add_column_to_orders_table', 2),
(48, '2024_03_21_120105_add_column_to_orders_table', 3),
(49, '2024_03_21_121733_add_column_to_order_mapped_products_table', 3),
(50, '2024_03_26_125156_drop_column_to_delivery_boy_management_table', 3),
(51, '2024_03_26_142343_add_column_to_delivery_boy_management_table', 3),
(52, '2024_03_27_150754_create_promotional_banner_products_table', 3),
(53, '2024_03_27_151145_create_sponsored_banner_products_table', 3),
(54, '2024_03_27_155417_add_column_to_categories_table', 3),
(55, '2024_03_27_162312_add_column_to_delivery_boy_management_table', 4),
(56, '2024_03_27_170447_create_deliveryboy_payment_statuses_table', 4),
(57, '2024_03_28_093923_add_column_to_deliveryboy_payment_statuses_table', 4),
(58, '2024_04_01_115127_add_column_to_products_table', 4),
(59, '2024_04_01_152547_add_column_to_addresses_table', 4),
(60, '2024_04_01_153255_add_column_to_orders_table', 4),
(61, '2024_04_01_153818_add_column_to_orders_table', 5),
(62, '2024_04_01_162654_add_column_to_sponsored_banner_products_table', 5),
(63, '2024_04_04_173124_add_column_to_orders_table', 6),
(64, '2024_04_05_105332_create_coupon_codes_table', 6),
(65, '2024_04_05_161811_create_party_time_products_table', 6),
(66, '2024_04_05_161943_create_mobile_and_accessories_products_table', 6),
(67, '2024_04_05_173427_add_column_to_products_table', 6),
(68, '2024_04_11_180709_add_expirydate_to_products_table', 6),
(69, '2024_04_13_132350_add_column_to_customers_table', 6),
(70, '2024_04_15_150101_add_column_to_settings_table', 7),
(71, '2024_04_16_143848_add_deleted_at_to_products_table', 7),
(72, '2024_04_16_145114_add_column_to_settings_table', 8),
(73, '2024_04_18_162501_add_column_to_orders_table', 9),
(74, '2024_04_24_101959_add_column_to_settings_table', 10),
(75, '2024_08_07_182056_add_new_column_to_settings_table', 10),
(76, '2024_08_12_182805_add_new_column_to_delivery_boy_management_table', 11),
(77, '2024_08_16_084747_alter_image_nullable_in_delivery_boy_management_table', 11),
(78, '2024_08_16_090646_add_new_column_to_delivery_boy_management', 12),
(79, '2024_08_16_095635_create_pincodes_table', 12),
(80, '2024_08_21_103855_create_recent_searches_table', 12),
(81, '2024_08_21_111151_add_tags_to_products_table', 12),
(82, '2024_09_11_174407_add_invoice_path_to_orders_table', 13),
(83, '2024_09_26_111643_add_comments_to_orders_table', 14),
(84, '2024_09_26_132001_add_column_to_settings_table', 15),
(85, '2024_10_09_162148_add_column_to_order_mapped_products_table', 15),
(86, '2024_10_09_182734_add_column_to_order_mapped_products_table', 15),
(87, '2024_10_10_101707_add_column_to_orders_table', 16),
(88, '2024_11_05_123429_update_delivery_boy_management_table', 16),
(89, '2024_11_05_125043_drop_coupon_discount_from_order_mapped_products', 16),
(90, '2024_11_29_192542_add_deleted_at_to_best_sellers_table', 16),
(91, '2024_11_30_120501_add_deleted_at_to_party_time_products_table', 16),
(92, '2024_11_30_120739_add_deleted_at_to_mobile_and_accessories_products_table', 16),
(93, '2024_11_30_121004_add_deleted_at_to_sponsored_banner_products_table', 16),
(94, '2025_03_13_182151_create_responses_table', 16),
(95, '2025_03_17_131156_remove_columns_from_responses_table', 16);

-- --------------------------------------------------------

--
-- Table structure for table `mobile_and_accessories_products`
--

CREATE TABLE `mobile_and_accessories_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offer_banners`
--

CREATE TABLE `offer_banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offer_products`
--

CREATE TABLE `offer_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `offer_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `address_id` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = Pending, 1 = In Process, 2 = Dispatched, 3 = Delivered',
  `delivery_boy_id` varchar(255) DEFAULT NULL,
  `coupon_code` varchar(255) DEFAULT NULL,
  `coupon_discount` decimal(8,2) DEFAULT NULL,
  `total_amount` double(8,2) DEFAULT NULL,
  `house_address` varchar(255) DEFAULT NULL,
  `street_address` varchar(255) DEFAULT NULL,
  `locality` varchar(255) DEFAULT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `long` varchar(255) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `refund_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `invoice_path` varchar(255) DEFAULT NULL,
  `payment_type` tinyint(4) DEFAULT NULL COMMENT '0 = COD, 1 = Online',
  `delivery_charge` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_mapped_products`
--

CREATE TABLE `order_mapped_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `mrp` varchar(255) NOT NULL,
  `price` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) NOT NULL,
  `amount` double(8,2) NOT NULL,
  `coupon_discount` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `otps`
--

CREATE TABLE `otps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mobile` text NOT NULL,
  `otp` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `party_time_products`
--

CREATE TABLE `party_time_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pincodes`
--

CREATE TABLE `pincodes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pincode` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` varchar(255) DEFAULT NULL,
  `sub_category_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `purchase_price` varchar(255) NOT NULL,
  `sale_price` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL,
  `image4` varchar(255) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `weight` varchar(255) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `trending` varchar(255) NOT NULL DEFAULT '0' COMMENT '0 = No, 1 = Yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `discount_price` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `sub_category_id`, `name`, `tags`, `description`, `purchase_price`, `sale_price`, `quantity`, `image`, `image1`, `image2`, `image3`, `image4`, `unit_id`, `weight`, `expiry_date`, `trending`, `created_at`, `updated_at`, `discount_price`, `deleted_at`) VALUES
(1, '1', NULL, 'Formal Shirt', 'Formal Shirt, shirt', '<p>Formal shirts are typically paired with dress pants, suits, and ties, making them essential attire for professional and formal occasions.</p>', '130', '200', '50', 'admin/uploads/product/1742728106th.jfif', NULL, NULL, NULL, NULL, 1, '150', '2029-01-23', '1', '2025-03-23 11:08:26', '2025-03-23 11:08:26', '159', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `promotional_banners`
--

CREATE TABLE `promotional_banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotional_banner_products`
--

CREATE TABLE `promotional_banner_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `banner_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recent_searches`
--

CREATE TABLE `recent_searches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `search_term` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `responses`
--

CREATE TABLE `responses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`full_response`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('lJ6CF25kviREjjcyIA7z2HWSz2bni6WN4ojIJuH9', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoic0E2ZmlMaUZXanN4MWtvVDZYcm9qQjVqUXFvdVZqc1FPYTJ0NjNBOSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1742728533);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contact_us` text DEFAULT NULL,
  `terms_and_condition` text DEFAULT NULL,
  `refund` text DEFAULT NULL,
  `cancellation` text DEFAULT NULL,
  `privacy_policy` text DEFAULT NULL,
  `delivery_note` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `delivery_charge` varchar(255) DEFAULT NULL,
  `location_range` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sponsored_banners`
--

CREATE TABLE `sponsored_banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sponsored_banners`
--

INSERT INTO `sponsored_banners` (`id`, `name`, `image`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Indian Clothes', 'admin/uploads/sponsored-banner/1742728139fcuqJJPiIkoZCVUa-generated_image.jpg', NULL, '2025-03-23 11:08:59', '2025-03-23 11:08:59');

-- --------------------------------------------------------

--
-- Table structure for table `sponsored_banner_products`
--

CREATE TABLE `sponsored_banner_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `banner_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sponsored_banner_products`
--

INSERT INTO `sponsored_banner_products` (`id`, `banner_id`, `product_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, '2025-03-23 11:08:59', '2025-03-23 11:08:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'gram', NULL, '2025-03-23 11:03:40', '2025-03-23 11:03:40'),
(2, 'pieces', NULL, '2025-03-23 11:03:51', '2025-03-23 11:03:51'),
(3, 'M', NULL, '2025-03-23 11:04:09', '2025-03-23 11:04:32'),
(4, 'L', NULL, '2025-03-23 11:04:22', '2025-03-23 11:04:22'),
(5, 'XL', NULL, '2025-03-23 11:04:41', '2025-03-23 11:04:41'),
(6, 'XXL', NULL, '2025-03-23 11:04:52', '2025-03-23 11:04:52'),
(7, 'XXXL', NULL, '2025-03-23 11:05:05', '2025-03-23 11:05:05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '$2y$12$UrQnV.fkqQFoCs3hQJzp7OiBlOMtrgDpXwrhQzgXIu0syNxLnE1Uu', NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-23 06:21:40', '2025-03-23 06:21:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `best_sellers`
--
ALTER TABLE `best_sellers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `best_sellers_product_id_foreign` (`product_id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_customer_id_foreign` (`customer_id`),
  ADD KEY `carts_product_id_foreign` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon_codes`
--
ALTER TABLE `coupon_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deliveryboy_payment_statuses`
--
ALTER TABLE `deliveryboy_payment_statuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `deliveryboy_payment_statuses_deliveryboy_id_foreign` (`deliveryboy_id`);

--
-- Indexes for table `delivery_boy_management`
--
ALTER TABLE `delivery_boy_management`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_charges`
--
ALTER TABLE `delivery_charges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mobile_and_accessories_products`
--
ALTER TABLE `mobile_and_accessories_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mobile_and_accessories_products_product_id_foreign` (`product_id`);

--
-- Indexes for table `offer_banners`
--
ALTER TABLE `offer_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offer_products`
--
ALTER TABLE `offer_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `offer_products_offer_id_foreign` (`offer_id`),
  ADD KEY `offer_products_product_id_foreign` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `order_mapped_products`
--
ALTER TABLE `order_mapped_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_mapped_products_order_id_foreign` (`order_id`),
  ADD KEY `order_mapped_products_customer_id_foreign` (`customer_id`),
  ADD KEY `order_mapped_products_product_id_foreign` (`product_id`);

--
-- Indexes for table `otps`
--
ALTER TABLE `otps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `party_time_products`
--
ALTER TABLE `party_time_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `party_time_products_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pincodes`
--
ALTER TABLE `pincodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promotional_banners`
--
ALTER TABLE `promotional_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promotional_banner_products`
--
ALTER TABLE `promotional_banner_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promotional_banner_products_banner_id_foreign` (`banner_id`),
  ADD KEY `promotional_banner_products_product_id_foreign` (`product_id`);

--
-- Indexes for table `recent_searches`
--
ALTER TABLE `recent_searches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recent_searches_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `responses`
--
ALTER TABLE `responses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sponsored_banners`
--
ALTER TABLE `sponsored_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sponsored_banner_products`
--
ALTER TABLE `sponsored_banner_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sponsored_banner_products_banner_id_foreign` (`banner_id`),
  ADD KEY `sponsored_banner_products_product_id_foreign` (`product_id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_categories_category_id_foreign` (`category_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `best_sellers`
--
ALTER TABLE `best_sellers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `coupon_codes`
--
ALTER TABLE `coupon_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `deliveryboy_payment_statuses`
--
ALTER TABLE `deliveryboy_payment_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_boy_management`
--
ALTER TABLE `delivery_boy_management`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_charges`
--
ALTER TABLE `delivery_charges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `mobile_and_accessories_products`
--
ALTER TABLE `mobile_and_accessories_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offer_banners`
--
ALTER TABLE `offer_banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offer_products`
--
ALTER TABLE `offer_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_mapped_products`
--
ALTER TABLE `order_mapped_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `otps`
--
ALTER TABLE `otps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `party_time_products`
--
ALTER TABLE `party_time_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pincodes`
--
ALTER TABLE `pincodes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `promotional_banners`
--
ALTER TABLE `promotional_banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promotional_banner_products`
--
ALTER TABLE `promotional_banner_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recent_searches`
--
ALTER TABLE `recent_searches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `responses`
--
ALTER TABLE `responses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sponsored_banners`
--
ALTER TABLE `sponsored_banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sponsored_banner_products`
--
ALTER TABLE `sponsored_banner_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `best_sellers`
--
ALTER TABLE `best_sellers`
  ADD CONSTRAINT `best_sellers_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `deliveryboy_payment_statuses`
--
ALTER TABLE `deliveryboy_payment_statuses`
  ADD CONSTRAINT `deliveryboy_payment_statuses_deliveryboy_id_foreign` FOREIGN KEY (`deliveryboy_id`) REFERENCES `delivery_boy_management` (`id`);

--
-- Constraints for table `mobile_and_accessories_products`
--
ALTER TABLE `mobile_and_accessories_products`
  ADD CONSTRAINT `mobile_and_accessories_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `offer_products`
--
ALTER TABLE `offer_products`
  ADD CONSTRAINT `offer_products_offer_id_foreign` FOREIGN KEY (`offer_id`) REFERENCES `offer_banners` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `offer_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `order_mapped_products`
--
ALTER TABLE `order_mapped_products`
  ADD CONSTRAINT `order_mapped_products_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `order_mapped_products_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_mapped_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `party_time_products`
--
ALTER TABLE `party_time_products`
  ADD CONSTRAINT `party_time_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `promotional_banner_products`
--
ALTER TABLE `promotional_banner_products`
  ADD CONSTRAINT `promotional_banner_products_banner_id_foreign` FOREIGN KEY (`banner_id`) REFERENCES `promotional_banners` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `promotional_banner_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recent_searches`
--
ALTER TABLE `recent_searches`
  ADD CONSTRAINT `recent_searches_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sponsored_banner_products`
--
ALTER TABLE `sponsored_banner_products`
  ADD CONSTRAINT `sponsored_banner_products_banner_id_foreign` FOREIGN KEY (`banner_id`) REFERENCES `sponsored_banners` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sponsored_banner_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
