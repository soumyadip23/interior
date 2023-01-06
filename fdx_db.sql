-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 01, 2022 at 05:28 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fdx_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_block` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `is_block`, `created_at`, `updated_at`) VALUES
(1, 'Bertha Hermann', 'admin@admin.com', NULL, '$2y$10$pQxV/x/zh1cn4CfNoE.tmeDqQi7rsijLPf4iFtqlSXVAGmMUjNi3a', NULL, 0, '2022-08-27 22:21:27', '2022-08-27 22:21:27'),
(2, 'Dr. Kendrick Ferry Jr.', 'kyler10@example.org', '2022-08-27 22:21:27', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'NM8nFOYG2g', 0, '2022-08-27 22:21:27', '2022-08-27 22:21:27'),
(3, 'Prof. Jermey Johnston Sr.', 'schoen.chaz@example.net', '2022-08-27 22:21:27', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'n59gBer3Aw', 0, '2022-08-27 22:21:27', '2022-08-27 22:21:27'),
(4, 'Miss Alva Abshire', 'maybell.hirthe@example.com', '2022-08-27 22:21:27', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'EZTOqQxj2Q', 0, '2022-08-27 22:21:27', '2022-08-27 22:21:27'),
(5, 'Emmet Batz', 'xander.pagac@example.org', '2022-08-27 22:21:27', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ZPitJG5oU8', 0, '2022-08-27 22:21:27', '2022-08-27 22:21:27'),
(6, 'Mrs. Mabel Aufderhar', 'caleb.larson@example.net', '2022-08-27 22:21:27', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'H8iZLJlYLi', 0, '2022-08-27 22:21:27', '2022-08-27 22:21:27'),
(7, 'Dr. Elva Hamill', 'alisha.rempel@example.org', '2022-08-27 22:21:27', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'OpoRvWlSNU', 0, '2022-08-27 22:21:27', '2022-08-27 22:21:27'),
(8, 'Florida Davis', 'icartwright@example.com', '2022-08-27 22:21:27', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'DhlFYF4L3Y', 0, '2022-08-27 22:21:27', '2022-08-27 22:21:27'),
(9, 'Allison Jacobs', 'elmo.bechtelar@example.net', '2022-08-27 22:21:27', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'GOGwgS3zbt', 0, '2022-08-27 22:21:27', '2022-08-27 22:21:27'),
(10, 'Michele Hodkiewicz', 'rice.emie@example.net', '2022-08-27 22:21:27', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'M4cPEIwN8Z', 0, '2022-08-27 22:21:27', '2022-08-27 22:21:27'),
(11, 'Christine Mills', 'marks.ramon@example.org', '2022-08-27 22:21:27', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'NMKUSaEV4C', 0, '2022-08-27 22:21:27', '2022-08-27 22:21:27');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `image`, `description`, `redirect_link`, `status`, `created_at`, `updated_at`) VALUES
(1, 'This is Banner 1', 'b1.jpg', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 'https://phoneflix.in/', 1, '2020-07-25 16:00:58', '2020-07-25 16:00:58'),
(2, 'This is Banner 2', 'b2.jpg', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 'https://phoneflix.in/', 1, '2020-07-25 16:00:58', '2020-07-25 16:00:58'),
(3, 'This is Banner 3', 'b3.jpg', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 'https://phoneflix.in/', 1, '2020-07-25 16:00:58', '2020-07-25 16:00:58');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_category_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `blog_views` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Rice and Biryani', '1661920709.special_chicken_biriyani.webp', 1, '2022-08-30 23:08:29', '2022-08-30 23:08:29');

-- --------------------------------------------------------

--
-- Table structure for table `commissions`
--

CREATE TABLE `commissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_order` int(11) NOT NULL,
  `max_order` int(11) NOT NULL,
  `value` double(15,8) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `commissions`
--

INSERT INTO `commissions` (`id`, `title`, `min_order`, `max_order`, `value`, `status`, `created_at`, `updated_at`) VALUES
(2, '1-5 Orders', 1, 5, 20.00000000, 1, '2022-08-29 04:46:07', '2022-08-29 04:46:07'),
(3, '6-10 Orders', 6, 10, 25.00000000, 1, '2022-08-29 04:46:20', '2022-08-29 04:46:20'),
(4, 'Above 10 Orders', 10, 100, 30.00000000, 1, '2022-08-29 04:46:33', '2022-08-29 04:55:06');

-- --------------------------------------------------------

--
-- Table structure for table `cuisines`
--

CREATE TABLE `cuisines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cuisines`
--

INSERT INTO `cuisines` (`id`, `title`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Test Title', '1661761206.image.jpg', 1, '2022-08-29 02:50:06', '2022-08-29 02:50:06'),
(2, 'Test Title 2', '1661761218.image.jpg', 1, '2022-08-29 02:50:18', '2022-08-29 02:50:18');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_boys`
--

CREATE TABLE `delivery_boys` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicle_type` int(11) NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  `remember_token` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_boys`
--

INSERT INTO `delivery_boys` (`id`, `name`, `mobile`, `email`, `password`, `image`, `country`, `city`, `address`, `pin`, `vehicle_type`, `gender`, `date_of_birth`, `status`, `is_deleted`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test Boy1', '9898989898', 'boy1@testmail.com', '$2y$10$BQt94ftrweD95US5asD.yeSaX71aLk.b3AS1eOtak7vGt.QTIk59C', '1661775896.image.jpg', 'India', 'Kolkata', 'This is test address', '700001', 3, 'Male', '2000-01-01', 1, 0, NULL, '2022-08-29 06:54:56', '2022-08-29 07:05:38'),
(2, 'Test Boy2', '9797979797', 'boy2@testmail.com', '$2y$10$60I3Q3SFECTU/V6ehH5pJeTnnNwecIAhp8BDej.Zyubt/QWicsGPG', '1661775947.image.jpg', 'India', 'Kolkata', 'This is test address', '700001', 2, 'Male', '2000-01-01', 1, 0, NULL, '2022-08-29 06:55:47', '2022-08-29 06:55:47'),
(3, 'Test Boy3', '9696969696', 'boy3@testmail.com', '$2y$10$BQt94ftrweD95US5asD.yeSaX71aLk.b3AS1eOtak7vGt.QTIk59C', '1661775896.image.jpg', 'India', 'Kolkata', 'This is test address', '700001', 2, 'Male', '2000-01-01', 1, 0, NULL, '2022-08-29 06:54:56', '2022-08-29 06:56:08');

-- --------------------------------------------------------

--
-- Table structure for table `incentives`
--

CREATE TABLE `incentives` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_order` int(11) NOT NULL,
  `max_order` int(11) NOT NULL,
  `value` double(15,8) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `incentives`
--

INSERT INTO `incentives` (`id`, `title`, `min_order`, `max_order`, `value`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Test', 1, 5, 20.00000000, 1, '2022-08-29 04:51:14', '2022-08-29 04:56:10');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `offer_price` double NOT NULL,
  `is_veg` int(11) NOT NULL DEFAULT 0 COMMENT '1 = veg',
  `is_cutlery_required` int(11) NOT NULL DEFAULT 0,
  `min_item_for_cutlery` int(11) NOT NULL,
  `in_stock` int(11) NOT NULL DEFAULT 1 COMMENT '1= in stock',
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `restaurant_id`, `category_id`, `name`, `image`, `description`, `price`, `offer_price`, `is_veg`, `is_cutlery_required`, `min_item_for_cutlery`, `in_stock`, `status`, `created_at`, `updated_at`) VALUES
(2, 1, 1, 'Special Chicken Biryani', 'special_chicken_biriyani.webp', 'A magnificent extra large portion of chicken biryani layered with fried onions, chilies, mint, and saffron. Great for sharing.', 300, 275, 0, 0, 0, 1, 1, '2022-08-31 04:40:34', NULL),
(3, 1, 1, 'Mutton Biryani', 'mutton_biriyani.webp', 'A delightful preparartion of slow cooked aromatic rice layered with marinated mutton pieces in a delicate blend of whole spices.', 250, 225, 0, 0, 0, 1, 1, '2022-08-31 04:40:34', NULL),
(4, 1, 1, 'Special Mutton Biryani', 'special_mutton_biriyani.webp', 'Aromatic basmati rice cooked with spices and layered succulent pieces of mutton.', 330, 299, 0, 0, 0, 1, 1, '2022-08-31 04:40:34', NULL),
(5, 3, 1, 'Chicken Biryani', 'chicken_biriyani1.webp', 'A dish truly fit for a King. Succulent pieces of chicken laid on a bed of long grain rice and slow cooked dum style with the secret Arsalan spices.', 370, 335, 0, 0, 0, 1, 1, '2022-08-31 04:40:34', NULL),
(6, 3, 1, 'Mutton Biryani', 'mutton_biriyani1.webp', 'Discovered by the ancestors of Arsalan, this biryani is made with juicy mutton pieces cooked dum style in aromatic rice and bhuna spices.', 370, 335, 0, 0, 0, 1, 1, '2022-08-31 04:40:34', NULL),
(7, 1, 1, 'Navratan Pulao', '1661934975.92e8b270d962353411c31eb492168567.webp', '<p>Rice cooked with mixed vegetables garnished with fruits.</p>', 190, 170, 1, 0, 0, 1, 1, '2022-08-31 03:06:15', '2022-08-31 04:55:45');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` double(15,8) NOT NULL,
  `lng` double(15,8) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `lat`, `lng`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Salt lake Sector-V', 22.57350000, 88.43310000, 1, '2022-08-29 03:13:48', '2022-08-29 04:48:24');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(36, '2014_10_12_100000_create_password_resets_table', 1),
(37, '2019_07_14_133537_create_admins_table', 1),
(38, '2020_07_25_092543_create_banners_table', 1),
(39, '2020_07_25_163412_create_users_table', 1),
(40, '2021_12_20_121745_create_settings_table', 1),
(41, '2021_12_23_125026_create_categories_table', 1),
(42, '2021_12_25_163823_create_blogs_table', 1),
(43, '2021_12_25_180124_create_notifications_table', 1),
(46, '2022_08_29_075243_create_locations_table', 2),
(47, '2022_08_29_075636_create_cuisines_table', 2),
(48, '2022_08_29_084613_create_commissions_table', 3),
(49, '2022_08_29_084646_create_incentives_table', 3),
(50, '2022_08_29_105924_create_vehicles_table', 4),
(52, '2022_08_29_113218_create_delivery_boys_table', 5),
(55, '2022_08_29_141358_create_orders_table', 6),
(56, '2022_08_30_075651_create_restaurants_table', 6),
(57, '2022_08_30_081358_create_items_table', 6),
(58, '2022_08_31_104141_create_orderitems_table', 7),
(59, '2022_08_31_175226_create_restaurant_transactions_table', 8),
(60, '2022_08_31_184438_create_restaurant_reviews_table', 9),
(61, '2022_08_31_191652_create_sos_notifications_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int(11) NOT NULL COMMENT '1->event,2->deals,3->property',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

CREATE TABLE `orderitems` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orderitems`
--

INSERT INTO `orderitems` (`id`, `order_id`, `product_name`, `product_image`, `price`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, 'Special Chicken Biryani', 'special_chicken_biriyani.webp', 275, 2, NULL, NULL),
(2, 2, 'Mutton Biryani', 'mutton_biriyani.webp', 225, 2, '2022-08-31 10:56:33', NULL),
(3, 3, 'Special Chicken Biryani', 'special_chicken_biriyani.webp', 275, 2, NULL, NULL),
(4, 3, 'Mutton Biryani', 'mutton_biriyani.webp', 225, 2, '2022-08-31 10:56:33', NULL),
(5, 4, 'Special Chicken Biryani', 'special_chicken_biriyani.webp', 275, 2, NULL, NULL),
(6, 4, 'Mutton Biryani', 'mutton_biriyani.webp', 225, 2, '2022-08-31 10:56:33', NULL),
(7, 5, 'Special Chicken Biryani', 'special_chicken_biriyani.webp', 275, 2, NULL, NULL),
(8, 5, 'Mutton Biryani', 'mutton_biriyani.webp', 225, 2, '2022-08-31 10:56:33', NULL),
(9, 6, 'Special Chicken Biryani', 'special_chicken_biriyani.webp', 275, 2, NULL, NULL),
(10, 6, 'Mutton Biryani', 'mutton_biriyani.webp', 225, 2, '2022-08-31 10:56:33', NULL),
(11, 7, 'Special Chicken Biryani', 'special_chicken_biriyani.webp', 275, 2, NULL, NULL),
(12, 7, 'Mutton Biryani', 'mutton_biriyani.webp', 225, 2, '2022-08-31 10:56:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unique_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_landmark` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_pin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_lat` double(15,8) NOT NULL,
  `delivery_lng` double(15,8) NOT NULL,
  `amount` double NOT NULL,
  `coupon_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discounted_amount` double NOT NULL,
  `delivery_charge` double NOT NULL,
  `packing_price` double NOT NULL,
  `tax_amount` double NOT NULL,
  `total_amount` double NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1=new,2=accepted,3=delivery boy assigned,4=order on process,5=delivered,6=cancelled',
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` int(11) NOT NULL DEFAULT 0 COMMENT '1=paid',
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `unique_id`, `restaurant_id`, `user_id`, `name`, `mobile`, `email`, `delivery_address`, `delivery_landmark`, `delivery_country`, `delivery_city`, `delivery_pin`, `delivery_lat`, `delivery_lng`, `amount`, `coupon_code`, `discounted_amount`, `delivery_charge`, `packing_price`, `tax_amount`, `total_amount`, `status`, `transaction_id`, `payment_status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'FDX-000001', 1, 1, 'Test User', '1234567890', 'test@testmail.com', 'This is test address', 'Test Landmark', 'India', 'Kolkata', '700001', 22.66767000, 88.54545400, 550, '', 0, 20, 10, 29, 609, 5, 'test-1432444', 1, 0, '2022-08-31 10:38:07', NULL),
(2, 'FDX-000002', 1, 1, 'Test User', '1234567890', 'test@testmail.com', 'This is test address', 'Test Landmark', 'India', 'Kolkata', '700001', 22.66767000, 88.54545400, 450, '', 0, 20, 10, 22.5, 502.5, 5, 'test-1432445', 1, 0, '2022-08-31 10:38:07', NULL),
(3, 'FDX-000003', 1, 1, 'Test User', '1234567890', 'test@testmail.com', 'This is test address', 'Test Landmark', 'India', 'Kolkata', '700001', 22.66767000, 88.54545400, 500, '', 0, 20, 10, 25, 555, 3, 'test-1432445', 1, 0, '2022-08-31 10:38:07', NULL),
(4, 'FDX-000004', 1, 1, 'Test User', '1234567890', 'test@testmail.com', 'This is test address', 'Test Landmark', 'India', 'Kolkata', '700001', 22.66767000, 88.54545400, 500, '', 0, 20, 10, 25, 555, 1, 'test-1432445', 1, 0, '2022-08-31 10:38:07', NULL),
(5, 'FDX-000005', 1, 1, 'Test User', '1234567890', 'test@testmail.com', 'This is test address', 'Test Landmark', 'India', 'Kolkata', '700001', 22.66767000, 88.54545400, 500, '', 0, 20, 10, 25, 555, 2, 'test-1432445', 1, 0, '2022-08-31 10:38:07', NULL),
(6, 'FDX-000006', 1, 1, 'Test User', '1234567890', 'test@testmail.com', 'This is test address', 'Test Landmark', 'India', 'Kolkata', '700001', 22.66767000, 88.54545400, 500, '', 0, 20, 10, 25, 555, 4, 'test-1432445', 1, 0, '2022-08-31 10:38:07', NULL),
(7, 'FDX-000007', 1, 1, 'Test User', '1234567890', 'test@testmail.com', 'This is test address', 'Test Landmark', 'India', 'Kolkata', '700001', 22.66767000, 88.54545400, 500, '', 0, 20, 10, 25, 555, 6, 'test-1432445', 1, 0, '2022-08-31 10:38:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` double(15,8) NOT NULL,
  `lng` double(15,8) NOT NULL,
  `start_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `close_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_pure_veg` int(11) NOT NULL DEFAULT 0 COMMENT '1 = pure veg',
  `commission_rate` double(5,2) NOT NULL,
  `estimated_delivery_time` int(11) NOT NULL COMMENT 'time in minutes',
  `is_not_taking_orders` int(11) NOT NULL DEFAULT 0 COMMENT '1 = not taking orders',
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`id`, `name`, `mobile`, `email`, `password`, `image`, `description`, `address`, `location`, `lat`, `lng`, `start_time`, `close_time`, `is_pure_veg`, `commission_rate`, `estimated_delivery_time`, `is_not_taking_orders`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Shimla Biryani', '9100000000', 'simla@testmail.com', '$2y$10$BQt94ftrweD95US5asD.yeSaX71aLk.b3AS1eOtak7vGt.QTIk59C', 'bd111e9a0e1c907907b51db3401893b8.webp', 'Popular Dishes<br/>\r\nMurg Reshmi Kabab, Chicken Chaanp, Phirni, Rolls, Kebab<br/>\r\n\r\nPeople Say This Place Is Known For\r\nSeating Inside, Good for Large Groups, Courteous Service, Cleanliness, Good Quantity, Portion Size<br/>', '11/1, Topsia, Kolkata', 'Topsia, Kolkata', 22.56567670, 88.32222200, '11:00', '23:00', 0, 15.00, 30, 0, 1, '2022-08-31 03:34:52', NULL),
(3, 'Arsalan', '9200000000', 'arsalan@testmail.com', '$2y$10$Lqfr.cnZTfQ5f2n95dbfVOOKUjTpDmEmWNBo.bP9L0YS3Bf6QL1IS', '1661918119.adfd20727edb7545d5452e52dbdcfd83.webp', '<h3 class=\"sc-1sv4741-0 sc-biNVYa bNlVCI\">Popular Dishes</h3>\r\n<p class=\"sc-1hez2tp-0 sc-nUItV YQqmV\">Chicken Boneless Masala, Mutton Haleem, Special Mutton Biryani, Mughlai Food, Stew, Reshmi Kabab</p>\r\n<h3 class=\"sc-1sv4741-0 sc-biNVYa bNlVCI\">People Say This Place Is Known For</h3>\r\n<p class=\"sc-1hez2tp-0 sc-nUItV YQqmV\">Cost Worthy, Gastronomical Experience, Ample Seating Area, Authenticity, Affordable, Good Value</p>\r\n<h3 class=\"sc-1sv4741-0 sc-biNVYa bNlVCI\">Average Cost</h3>\r\n<p class=\"sc-1hez2tp-0 sc-nUItV YQqmV\">₹700 for two people (approx.)</p>\r\n<p class=\"sc-1hez2tp-0 eTUNOO\">Exclusive of applicable taxes and charges, if any</p>', '119A, Muzaffar Ahmed Street, Park Street Area, Kolkata', 'Park Street Area, Kolkata', 22.34556000, 88.77676767, '10:00', '23:00', 0, 12.00, 35, 0, 1, '2022-08-30 22:25:19', '2022-08-30 22:25:19');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_reviews`
--

CREATE TABLE `restaurant_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_ref_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` double NOT NULL,
  `review` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `restaurant_reviews`
--

INSERT INTO `restaurant_reviews` (`id`, `restaurant_id`, `user_id`, `order_ref_id`, `rating`, `review`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'FDX-000001', 4, 'This is test review. This is for testing', '2022-08-31 19:03:18', NULL),
(2, 1, 1, 'FDX-000002', 4.5, 'This is test review. This is for testing', '2022-08-31 19:11:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_transactions`
--

CREATE TABLE `restaurant_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `order_ref_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int(11) NOT NULL COMMENT '1=credit,2=deduction',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `restaurant_transactions`
--

INSERT INTO `restaurant_transactions` (`id`, `restaurant_id`, `order_ref_id`, `amount`, `note`, `type`, `created_at`, `updated_at`) VALUES
(1, 1, 'FDX-000001', 467.5, 'Payment for order id : FDX-000001', 2, '2022-08-31 18:05:34', NULL),
(2, 1, 'FDX-000002', 382.5, 'Payment for order id : FDX-000002', 2, '2022-08-31 18:05:34', NULL),
(3, 1, 'FDX-000003', 425, 'Payment for order id : FDX-000003', 2, '2022-08-31 18:05:34', NULL),
(4, 1, 'FDX-000004', 425, 'Payment for order id : FDX-000004', 2, '2022-08-31 18:05:34', NULL),
(5, 1, 'FDX-000005', 425, 'Payment for order id : FDX-000005', 2, '2022-08-31 18:05:34', NULL),
(6, 1, 'FDX-000006', 425, 'Payment for order id : FDX-000006', 2, '2022-08-31 18:05:34', NULL),
(7, 1, '', 1500, 'Credit from FDX', 1, '2022-08-31 18:26:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'FDX Online', '2022-08-29 02:26:03', '2022-08-29 02:26:03');

-- --------------------------------------------------------

--
-- Table structure for table `sos_notifications`
--

CREATE TABLE `sos_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `delivery_boy_id` int(11) NOT NULL,
  `notification` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sos_notifications`
--

INSERT INTO `sos_notifications` (`id`, `delivery_boy_id`, `notification`, `created_at`, `updated_at`) VALUES
(1, 1, 'Test Boy1 is in an emergency situation. Please contact at 9898989898', '2022-08-31 19:01:41', NULL),
(2, 2, 'Test Boy2 is in an emergency situation. Please contact at 9797979797', '2022-08-31 19:17:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp` int(11) NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `is_verified` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  `remember_token` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `mobile`, `email`, `otp`, `password`, `country`, `city`, `address`, `gender`, `date_of_birth`, `is_verified`, `status`, `is_deleted`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', '1234567890', 'test@testmail.com', 1234, '', '', '', '', 'Male', '1990-01-01', 1, 1, 0, '12334566677', '2021-07-25 16:00:58', '2021-07-25 16:00:58'),
(3, 'Test User3', '9898989898', 'test2@testmail.com', 1234, '', 'India', 'Kolkata', 'Sector V, Salt Lake, Pin 700091', 'Female', '2022-02-01', 1, 1, 0, NULL, '2022-08-27 22:51:43', '2022-08-29 03:09:52');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Bike', 1, '2022-08-29 05:59:24', '2022-08-29 05:59:24'),
(3, 'Scooty', 1, '2022-08-29 05:59:30', '2022-08-29 05:59:30'),
(4, 'Cycle', 1, '2022-08-29 05:59:36', '2022-08-29 05:59:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commissions`
--
ALTER TABLE `commissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cuisines`
--
ALTER TABLE `cuisines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_boys`
--
ALTER TABLE `delivery_boys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incentives`
--
ALTER TABLE `incentives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_reviews`
--
ALTER TABLE `restaurant_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_transactions`
--
ALTER TABLE `restaurant_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sos_notifications`
--
ALTER TABLE `sos_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `commissions`
--
ALTER TABLE `commissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cuisines`
--
ALTER TABLE `cuisines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `delivery_boys`
--
ALTER TABLE `delivery_boys`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `incentives`
--
ALTER TABLE `incentives`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orderitems`
--
ALTER TABLE `orderitems`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `restaurant_reviews`
--
ALTER TABLE `restaurant_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `restaurant_transactions`
--
ALTER TABLE `restaurant_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sos_notifications`
--
ALTER TABLE `sos_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
