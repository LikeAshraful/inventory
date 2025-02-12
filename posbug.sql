-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 01, 2024 at 06:36 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `posbug`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Tupi', 1, 1, NULL, '2024-03-03 03:46:01', NULL),
(2, 'Payjama', 1, 1, NULL, '2024-03-03 03:46:14', NULL),
(3, 'Panjabi', 1, 1, NULL, '2024-03-03 03:46:28', NULL),
(4, 'Bag', 1, 1, NULL, '2024-03-03 03:46:36', NULL),
(5, 'Moshary', 1, 1, NULL, '2024-03-03 03:46:49', NULL),
(6, 'Bedding', 1, 1, NULL, '2024-03-03 03:47:08', NULL),
(7, 'Gol bag', 1, 1, NULL, '2024-03-03 03:47:31', NULL),
(8, 'sleeping bag model 71', 1, 1, NULL, '2024-03-03 03:47:40', NULL),
(9, 'shoe', 1, 1, NULL, '2024-03-03 03:47:50', NULL),
(11, 'sleeping bag model 63', 1, 1, NULL, '2024-07-01 09:19:33', NULL),
(12, 'ator', 1, 1, NULL, '2024-07-03 12:40:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shopname` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `customer_image` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `nid` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `previous_due_amount` double DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `shopname`, `name`, `customer_image`, `mobile_no`, `email`, `address`, `nid`, `note`, `previous_due_amount`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'alfaruk', 'raju', 'upload/no_image.jpg', '01673459342', 'raju@gmail.com', 'madaninagar', '2345678', NULL, 500, 1, 1, 1, '2024-08-09 13:56:49', '2024-11-30 11:50:57'),
(3, 'majynamaj', 'riyadh', NULL, '01618864442', NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '2024-11-10 14:22:29', '2024-11-30 23:32:34'),
(4, 'Tupighor', 'hasan', NULL, '015100000', NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '2024-11-10 14:29:33', '2024-11-30 23:32:34'),
(5, 'Tupighor', 'hasan', NULL, '015100000', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2024-11-10 14:29:34', '2024-11-27 09:44:02'),
(6, 'nokshibangla', 'test', NULL, '000000000', NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '2024-11-14 03:03:09', '2024-11-25 12:15:45'),
(7, 'alo', 'tania', NULL, '017000000', NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '2024-11-19 07:37:51', '2024-11-30 23:32:34'),
(8, 'kamalshop', 'kamal', NULL, '01868799280', NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '2024-11-25 12:07:25', '2024-11-30 23:32:34');

-- --------------------------------------------------------

--
-- Table structure for table `customer_invoices`
--

CREATE TABLE `customer_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `experience` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `salary` varchar(255) DEFAULT NULL,
  `vacation` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `email`, `phone`, `address`, `experience`, `image`, `salary`, `vacation`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'farjana akter', 'farjana.cse91@gmail.com', '01515262575', 'madaninagar', '3 Year', 'upload/no_image.jpg', '12000', '2', 1, 1, 1, '2024-07-26 09:28:13', '2024-07-26 09:28:29'),
(2, 'hasan', 'hmehedi91@gmail.com', '01670078952', 'madaninagar', '1 Year', 'upload/no_image.jpg', '12000', '2', 1, 1, NULL, '2024-07-26 09:28:59', NULL);

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
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `invoice_no` varchar(255) DEFAULT NULL,
  `shopname` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=Complete, 1=Draft',
  `total_amount` decimal(10,2) DEFAULT NULL,
  `return_amount` decimal(10,2) DEFAULT NULL,
  `percentage_discount` int(11) DEFAULT NULL,
  `flat_discount` decimal(10,2) DEFAULT NULL,
  `shipping` decimal(10,2) DEFAULT NULL,
  `labour` decimal(10,2) DEFAULT NULL,
  `payable_amount` decimal(10,2) DEFAULT NULL,
  `paid_amount` decimal(10,2) DEFAULT NULL,
  `due_amount` decimal(10,2) DEFAULT NULL,
  `previous_due_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `transaction_type` varchar(255) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_details`
--

CREATE TABLE `invoice_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_code` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `type` enum('sale','return') NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_02_22_175947_drop_all_tables', 1),
(6, '2024_02_27_183554_create_suppliers_table', 2),
(7, '2024_03_01_160701_create_customers_table', 3),
(8, '2024_03_02_163421_create_units_table', 4),
(9, '2024_03_02_183733_create_categories_table', 5),
(10, '2024_03_02_185200_drop_categories', 6),
(11, '2024_03_02_185408_drop_categories', 7),
(12, '2024_03_02_185828_drop_categories', 8),
(13, '2024_03_02_190132_create_categories_table', 9),
(14, '2024_03_03_180401_create_products_table', 10),
(15, '2024_03_11_173953_create_purchases_table', 11),
(16, '2024_06_18_174753_drop_purchase_table', 12),
(17, '2024_06_18_175508_create_purchase_table', 12),
(18, '2024_06_18_183015_drop_purchase_table', 13),
(19, '2024_06_18_183059_create_purchase_table', 13),
(20, '2024_06_19_202818_create_purchases_table', 14),
(21, '2024_06_19_203645_add_estimated_amount_to_purchases_table', 15),
(22, '2024_06_19_204100_drop_category_id_from_purchases_table', 16),
(23, '2024_07_03_143129_drop_purchases_tables', 17),
(24, '2024_07_03_144517_create_purchases_table', 18),
(25, '2024_07_03_150334_create_purchase_details_table', 18),
(26, '2024_07_03_185327_make_purchase_fields_nullable', 19),
(27, '2024_07_13_161543_create_invoices_table', 20),
(28, '2024_07_13_161721_create_invoice_details_table', 20),
(29, '2024_07_13_161826_create_payments_table', 20),
(30, '2024_07_13_162007_create_payment_details_table', 20),
(31, '2024_07_13_165558_create_sale_returns_table', 20),
(32, '2024_07_15_152433_create_employees_table', 21),
(33, '2024_07_25_192015_drop_employees_table', 22),
(34, '2024_07_25_192354_create_employees_table', 23),
(35, '2024_07_26_144404_drop_employees_table', 24),
(36, '2024_07_26_144530_create_employees_table', 25),
(37, '2024_07_30_165827_drop_sales_related_tables', 26),
(38, '2024_07_30_170813_create_invoices_table', 27),
(39, '2024_07_30_170853_create_invoice_details_table', 27),
(40, '2024_07_30_170941_create_payments_table', 27),
(41, '2024_07_30_171009_create_payment_details_table', 27),
(42, '2024_08_06_152456_drop_payments_table', 28),
(43, '2024_08_06_152709_create_payments_table', 29),
(44, '2024_08_08_192913_drop_invoice_details_table', 30),
(45, '2024_08_08_193238_create_invoice_details_table', 31),
(46, '2024_08_09_193600_drop_payments_table', 32),
(47, '2024_08_09_193840_create_payments_table', 33),
(48, '2024_08_09_194220_drop_customers_table', 34),
(49, '2024_08_09_194423_create_customers_table', 35),
(50, '2024_09_01_153847_drop_invoice_details_table', 36),
(51, '2024_09_01_154137_create_invoice_details_table', 37),
(52, '2024_09_02_183304_drop_payments_table', 38),
(53, '2024_09_02_183918_create_payments_table', 39),
(54, '2024_09_08_135449_drop_invoice_details_table', 40),
(55, '2024_09_08_135611_create_invoice_details_table', 41),
(56, '2024_09_08_140347_drop_payments_table', 41),
(57, '2024_09_08_140709_create_payments_table', 42),
(58, '2024_09_08_163821_add_customer_id_to_invoices_table', 43),
(59, '2024_09_08_164731_drop_invoice_details_table', 44),
(60, '2024_09_08_165553_drop_payments_table', 45),
(61, '2024_09_08_165717_drop_invoices_table', 46),
(62, '2024_09_08_165923_create_invoice_details_table', 47),
(149, '2024_09_08_170106_create_payments_table', 48),
(150, '2024_09_08_172012_create_invoices_table', 48),
(151, '2024_11_27_055749_create_invoice_details_table', 48),
(152, '2024_11_27_104044_create_payment_details_table', 48),
(153, '2024_11_27_105942_create_sale_returns_table', 48),
(154, '2024_11_28_153743_create_customer_invoices_table', 48);

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `paid_amount` decimal(8,2) DEFAULT NULL,
  `due_amount` varchar(255) DEFAULT NULL,
  `previous_due_amount` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_details`
--

CREATE TABLE `payment_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(8,2) DEFAULT NULL,
  `paid_amount` decimal(8,2) DEFAULT NULL,
  `transaction_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `product_code` varchar(255) DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `buying_date` varchar(255) DEFAULT NULL,
  `expire_date` varchar(255) DEFAULT NULL,
  `buying_price` varchar(255) DEFAULT NULL,
  `retail_sale` varchar(255) DEFAULT NULL,
  `wholesale` varchar(255) DEFAULT NULL,
  `quantity` double NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `supplier_id`, `unit_id`, `category_id`, `name`, `product_code`, `product_image`, `buying_date`, `expire_date`, `buying_price`, `retail_sale`, `wholesale`, `quantity`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(7, 5, 2, 3, 'short panjabi', 'PC07', 'upload/product/1793074119095826.webp', '2024-03-09', '2025-03-09', '500', '1000', '800', 59, 1, 1, 1, '2024-03-09 12:03:11', '2024-11-25 12:20:50'),
(8, 6, 2, 5, 'Nowka Moshary', 'PC08', 'upload/product/1793074095628992.jpg', '2024-03-10', '2025-03-10', '1000', '1200', '1100', 24, 1, 1, 1, '2024-03-09 12:11:44', '2024-11-25 08:22:50'),
(12, 4, 2, 5, 'Tabu Moshary', 'P122', 'upload/product/1792627848840505.jpg', NULL, NULL, '1000', '1200', '1100', 24, 1, NULL, 1, '2024-03-10 12:14:05', '2024-11-26 10:02:29'),
(14, 6, 2, 3, 'long panjabi', 'P144', 'upload/product/1793074230360790.webp', NULL, NULL, '200', '500', '400', 26, 1, NULL, 1, '2024-03-10 12:14:05', '2024-11-26 09:46:57'),
(16, 8, 2, 8, 'sleeping bag', 'PC09', 'upload/product/1803390342616428.jpg', '2024-07-01', '2025-05-01', '1200', '1500', '1400', 11, 1, 1, 1, '2024-07-01 09:17:32', '2024-11-25 12:07:25'),
(17, 5, 2, 11, 'sleeping bag', 'PC10', 'upload/product/1803390529901148.jpg', NULL, NULL, '1000', '1500', '1100', 219, 1, 1, 1, '2024-07-01 09:20:30', '2024-11-26 06:17:54'),
(18, 5, 2, 1, 'shahi Tupi', 'PC11', 'upload/product/1803390650602777.jpg', NULL, NULL, '300', '500', '400', 20, 1, 1, 1, '2024-07-01 09:22:26', '2024-08-13 13:05:21'),
(19, 8, 2, 4, 'ladies bag', 'PC12', 'upload/product/1803390721860996.jpg', NULL, NULL, '1000', '1200', '1100', 10, 1, 1, 1, '2024-07-01 09:23:33', '2024-08-13 13:05:12'),
(20, 6, 2, 9, 'Juta Sneakers For Men', 'PC13', 'upload/product/1803390817593513.webp', NULL, NULL, '1200', '1500', '1400', 109, 1, 1, 1, '2024-07-01 09:25:05', '2024-11-25 12:19:29'),
(22, 9, 2, 2, 'pant', 'PC14', 'upload/product/1804673670798128.jpg', NULL, NULL, '300', '500', '400', 10, 1, 1, 1, '2024-07-15 13:15:29', '2024-08-13 13:04:54'),
(25, 4, 2, 1, 'test', 'PC15', 'upload/no_image.jpg', NULL, NULL, '1000', '1200', '1100', 100, 1, 1, 1, '2024-08-12 14:09:41', '2024-08-13 13:04:43');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_no` varchar(255) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `transaction_type` varchar(255) NOT NULL,
  `discount_amount` decimal(10,2) DEFAULT NULL,
  `shipping` decimal(10,2) DEFAULT NULL,
  `paid_amount` decimal(10,2) DEFAULT NULL,
  `estimated_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `due_amount` decimal(10,2) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=Pending, 1=Approved',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `purchase_no`, `supplier_id`, `date`, `transaction_type`, `discount_amount`, `shipping`, `paid_amount`, `estimated_amount`, `due_amount`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(4, '1380', 6, '2024-07-03', 'Cash', '100.00', '100.00', '5084.00', '5400.00', '316.00', 0, NULL, 1, '2024-07-03 12:33:56', '2024-07-03 14:20:33'),
(5, '1381', 5, '2024-07-03', 'Cash', '100.00', '50.00', '1200.00', '2350.00', '1150.00', 0, NULL, NULL, '2024-07-03 12:39:15', '2024-07-03 12:39:15'),
(6, '1383', 7, '2024-07-03', 'Cash', '100.00', '80.00', '1200.00', '1980.00', '780.00', 0, NULL, NULL, '2024-07-03 12:39:59', '2024-07-03 12:39:59'),
(7, '1385', 8, '2024-07-03', 'Cash', '100.00', '50.00', '350.00', '350.00', '0.00', 0, NULL, NULL, '2024-07-03 12:43:24', '2024-07-03 12:43:24'),
(8, '1386', 4, '2024-07-03', 'Cash', '100.00', '50.00', '0.00', '950.00', '950.00', 0, 1, 1, '2024-07-03 13:00:05', '2024-07-03 14:34:39'),
(9, '1390', 6, '2024-07-04', 'Cash', '100.00', '80.00', '4000.00', '4580.00', '580.00', 0, 1, 1, '2024-07-04 13:57:40', '2024-07-04 13:58:48'),
(11, '1234', 4, '2024-08-13', 'Cash', '0.00', '0.00', '0.00', '20000.00', '20000.00', 0, 1, NULL, '2024-08-13 13:13:49', '2024-08-13 13:13:49'),
(12, '1400', 6, '2024-08-24', 'Cash', '100.00', '50.00', '10000.00', '19950.00', '9950.00', 0, 1, NULL, '2024-08-24 08:50:09', '2024-08-24 08:50:09'),
(13, '1400', 4, '2024-08-24', 'Cash', '100.00', '50.00', '10000.00', '19950.00', '9950.00', 0, 1, NULL, '2024-08-24 09:12:58', '2024-08-24 09:12:58');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_details`
--

CREATE TABLE `purchase_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `buying_qty` int(11) NOT NULL,
  `expire_date` date DEFAULT NULL,
  `buying_price` decimal(10,2) NOT NULL,
  `retail_sale` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_details`
--

INSERT INTO `purchase_details` (`id`, `purchase_id`, `product_id`, `buying_qty`, `expire_date`, `buying_price`, `retail_sale`, `total_amount`, `created_at`, `updated_at`) VALUES
(9, 5, 20, 2, NULL, '1200.00', '1500.00', '2400.00', '2024-07-03 12:39:15', '2024-07-03 12:39:15'),
(10, 6, 19, 2, NULL, '1000.00', '1200.00', '2000.00', '2024-07-03 12:39:59', '2024-07-03 12:39:59'),
(11, 7, 14, 2, NULL, '200.00', '500.00', '400.00', '2024-07-03 12:43:24', '2024-07-03 12:43:24'),
(18, 4, 12, 2, NULL, '1000.00', '1200.00', '2000.00', '2024-07-03 14:20:33', '2024-07-03 14:20:33'),
(19, 4, 14, 2, NULL, '200.00', '500.00', '400.00', '2024-07-03 14:20:33', '2024-07-03 14:20:33'),
(20, 4, 16, 2, NULL, '1200.00', '1500.00', '2400.00', '2024-07-03 14:20:33', '2024-07-03 14:20:33'),
(21, 4, 18, 2, NULL, '300.00', '500.00', '600.00', '2024-07-03 14:20:33', '2024-07-03 14:20:33'),
(24, 8, 7, 2, NULL, '500.00', '1000.00', '1000.00', '2024-07-03 14:34:39', '2024-07-03 14:34:39'),
(27, 9, 18, 2, NULL, '300.00', '500.00', '600.00', '2024-07-04 13:58:48', '2024-07-04 13:58:48'),
(28, 9, 17, 2, NULL, '1000.00', '1500.00', '2000.00', '2024-07-04 13:58:48', '2024-07-04 13:58:48'),
(29, 9, 8, 2, NULL, '1000.00', '1200.00', '2000.00', '2024-07-04 13:58:48', '2024-07-04 13:58:48'),
(35, 11, 25, 20, NULL, '1000.00', '1200.00', '20000.00', '2024-08-13 13:13:49', '2024-08-13 13:13:49'),
(36, 12, 7, 40, NULL, '500.00', '1000.00', '20000.00', '2024-08-24 08:50:09', '2024-08-24 08:50:09'),
(37, 13, 7, 40, NULL, '500.00', '1000.00', '20000.00', '2024-08-24 09:12:58', '2024-08-24 09:12:58');

-- --------------------------------------------------------

--
-- Table structure for table `sale_returns`
--

CREATE TABLE `sale_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_code` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `shopname` varchar(255) DEFAULT NULL,
  `balance` double DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `mobile_no`, `email`, `address`, `shopname`, `balance`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(4, 'raju', '01673459342', 'raju@gmail.com', 'madaninagar', 'alfaruk', 10000, 1, 1, NULL, '2024-03-02 12:11:05', '2024-03-02 12:11:05'),
(5, 'riyadh ahmed', '+8801515262575', 'riyadh@gmail.com', 'madaninagar', 'majynamaj', 10000, 1, 1, 1, '2024-03-02 12:13:27', '2024-03-02 12:14:00'),
(6, 'hasan', '01670078952', 'hasan@gmail.com', 'gulisthan', 'khoddor', NULL, 1, 1, NULL, '2024-03-03 03:50:01', NULL),
(7, 'moni', '+8801515262575', 'moni@gmail.com', 'madaninagar', 'Shoe House', NULL, 1, 1, 1, '2024-03-03 03:52:05', '2024-03-03 04:00:17'),
(8, 'manaf', '01515262575', 'manaf@gmail.com', 'madaninagar', 'Tupighor', 0, 1, 1, NULL, '2024-07-01 09:11:34', NULL),
(9, 'riyadh', '0167000000', 'riyadh@gmail.com', 'narayangonj', 'bilaty', 0, 1, 1, NULL, '2024-07-01 09:12:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, 'piece', 1, 1, 1, '2024-03-02 12:24:20', '2024-03-05 12:36:28'),
(3, 'kg', 1, 1, NULL, '2024-03-02 12:25:29', NULL),
(4, 'gm', 1, 1, NULL, '2024-07-01 09:15:14', NULL),
(5, 'liter', 1, 1, NULL, '2024-07-01 09:15:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `photo`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', '01515262575', '2024022417521730294797907431.png', NULL, '$2y$10$dXxV.St5KFDp7yDFt9tKP.osg9IRJw8JZZ5.NJJWMIomnYkX5jweC', NULL, '2024-02-22 12:02:51', '2024-02-24 11:56:32'),
(2, 'raju', 'raju@gmail.com', '01673459342', NULL, NULL, '$2y$12$v3lqPSbFnr3nZMp5lCJCbOfoA5qGh.9SMs45Dg0/UVp.Cvxda8oO2', NULL, '2024-02-23 06:46:16', '2024-02-23 06:46:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_invoices`
--
ALTER TABLE `customer_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_invoices_customer_id_foreign` (`customer_id`),
  ADD KEY `customer_invoices_invoice_id_foreign` (`invoice_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_details_purchase_id_foreign` (`purchase_id`),
  ADD KEY `purchase_details_product_id_foreign` (`product_id`);

--
-- Indexes for table `sale_returns`
--
ALTER TABLE `sale_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_returns_invoice_id_foreign` (`invoice_id`),
  ADD KEY `sale_returns_product_id_foreign` (`product_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `customer_invoices`
--
ALTER TABLE `customer_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_details`
--
ALTER TABLE `invoice_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_details`
--
ALTER TABLE `payment_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `sale_returns`
--
ALTER TABLE `sale_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer_invoices`
--
ALTER TABLE `customer_invoices`
  ADD CONSTRAINT `customer_invoices_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customer_invoices_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD CONSTRAINT `purchase_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `purchase_details_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sale_returns`
--
ALTER TABLE `sale_returns`
  ADD CONSTRAINT `sale_returns_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_returns_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
