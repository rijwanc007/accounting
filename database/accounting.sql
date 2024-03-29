-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2022 at 01:02 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `accounting`
--

-- --------------------------------------------------------

--
-- Table structure for table `accountings`
--

CREATE TABLE `accountings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `particular` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `account_type`, `status`, `created_at`, `updated_at`) VALUES
(1, 'production', 'Yes', '2019-12-02 02:31:14', '2019-12-02 02:31:14'),
(2, 'manufacturing', 'Yes', '2019-12-02 02:31:34', '2019-12-02 02:33:04'),
(3, 'equipment', 'Yes', '2019-12-02 02:33:30', '2019-12-02 02:33:43');

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `user_id`, `date`, `time`, `message`, `created_at`, `updated_at`) VALUES
(1, '1', '2022-01-03', '17:38:57', 'Created Sister Concern', '2022-01-03 05:38:57', '2022-01-03 05:38:57');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `creator_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creator_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creator_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `announcement_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `announcement_description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `creator_id`, `creator_name`, `creator_email`, `announcement_name`, `announcement_description`, `created_at`, `updated_at`) VALUES
(2, NULL, 'rijwan chowdhury', 'rijwanc007@gmail.com', 'off day announcement', 'these announcement is going for test purpose', '2019-12-01 04:43:15', '2019-12-01 04:43:15'),
(3, NULL, 'rijwan chowdhury', 'rijwanc007@gmail.com', 'another', 'this is a also another test purpose announcement', '2019-12-01 04:43:45', '2019-12-01 04:43:45'),
(4, NULL, 'rijwan chowdhury', 'rijwanc007@gmail.com', 'final', 'these is final announcement', '2019-12-01 04:44:01', '2019-12-01 04:44:01'),
(6, NULL, 'jahid hossain', 'jahid@gmail.com', 'Setcol', 'Vacation On', '2019-12-01 22:34:40', '2019-12-01 22:34:40');

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sister_concern_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ledger_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chartofaccounts`
--

CREATE TABLE `chartofaccounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sister_concern_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `head_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `head_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_head_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_head_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `child_head_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `child_head_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `narration` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cheques`
--

CREATE TABLE `cheques` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pay_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ac_payee` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contra_journals`
--

CREATE TABLE `contra_journals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `voucher_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sister_concern_id_from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sister_concern_id_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `narration` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transfer_amount_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit_amount_overview` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transfer_amount_from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit_amount_overview` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `credit_vouchers`
--

CREATE TABLE `credit_vouchers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sister_concern_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `voucher_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `voucher_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `naration` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transfer_amount_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit_overview` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit_amount_overview` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transfer_amount_from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit_overview` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit_amount_overview` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `debit_vouchers`
--

CREATE TABLE `debit_vouchers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sister_concern_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `voucher_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `voucher_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `naration` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transfer_amount_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit_overview` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit_amount_overview` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transfer_amount_from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit_overview` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit_amount_overview` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `journals`
--

CREATE TABLE `journals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sister_concern_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `voucher_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `voucher_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `naration` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transfer_amount_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit_overview` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit_amount_overview` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transfer_amount_from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit_overview` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit_amount_overview` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `main_heads`
--

CREATE TABLE `main_heads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_account` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `receiver_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receiver_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `sender_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sender_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sender_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `receiver_id`, `receiver_name`, `receiver_email`, `message`, `sender_id`, `sender_image`, `sender_name`, `sender_email`, `created_at`, `updated_at`) VALUES
(2, 3, 'rifat chowdhury', 'rifat@gmail.com', 'hello rifat how are you', 1, '1575177980.jpg', 'rijwan chowdhury', 'rijwanc007@gmail.com', '2019-11-25 23:55:43', '2019-11-30 23:26:20'),
(3, 1, 'rijwan chowdhury', 'rijwanc007@gmail.com', 'hello brother ,how are you today.i received your mail yesterday.i will complete my task tomorrow..', 3, '1574668270.jpg', 'rifat chowdhury', 'rifat@gmail.com', '2019-11-26 02:05:11', '2019-11-26 02:05:11'),
(12, 9, 'Himel Hsaahn', 'himel@gmail.com', 'this message is going for test purpose', 1, '1575177980.jpg', 'rijwan chowdhury', 'rijwanc007@gmail.com', '2019-11-28 05:03:50', '2019-11-30 23:26:20'),
(14, 7, 'Adib Hasan', 'mahmudul@gmail.com', 'this message is going for test purpose', 1, '1575177980.jpg', 'rijwan chowdhury', 'rijwanc007@gmail.com', '2019-11-28 05:03:50', '2019-11-30 23:26:20'),
(16, 5, 'Abir Hossain', 'abir@gmail.com', 'this message is going for test purpose', 1, '1575177980.jpg', 'rijwan chowdhury', 'rijwanc007@gmail.com', '2019-11-28 05:03:50', '2019-11-30 23:26:20'),
(18, 3, 'rifat chowdhury', 'rifat@gmail.com', 'this message is going for test purpose', 1, '1575177980.jpg', 'rijwan chowdhury', 'rijwanc007@gmail.com', '2019-11-28 05:03:50', '2019-11-30 23:26:20'),
(19, 2, 'jahid hossain', 'jahid@gmail.com', 'this message is going for test purpose', 1, '1575177980.jpg', 'rijwan chowdhury', 'rijwanc007@gmail.com', '2019-11-28 05:03:50', '2019-11-30 23:26:20'),
(20, 10, 'supol chowdhury', 'supol@gmail.com', 'test purpose', 1, '1575177980.jpg', 'rijwan chowdhury', 'rijwanc007@gmail.com', '2019-12-01 03:45:38', '2019-12-01 03:45:38'),
(21, 9, 'Himel Hsaahn', 'himel@gmail.com', 'another test', 1, '1575177980.jpg', 'rijwan chowdhury', 'rijwanc007@gmail.com', '2019-12-01 03:46:17', '2019-12-01 03:46:17'),
(22, 10, 'supol chowdhury', 'supol@gmail.com', 'these input is going for final test', 1, '1575177980.jpg', 'rijwan chowdhury', 'rijwanc007@gmail.com', '2019-12-01 03:50:39', '2019-12-01 03:50:39'),
(23, 9, 'Himel Hsaahn', 'himel@gmail.com', 'these input is going for final test', 1, '1575177980.jpg', 'rijwan chowdhury', 'rijwanc007@gmail.com', '2019-12-01 03:50:39', '2019-12-01 03:50:39'),
(24, 7, 'Adib Hasan', 'mahmudul@gmail.com', 'these input is going for final test', 1, '1575177980.jpg', 'rijwan chowdhury', 'rijwanc007@gmail.com', '2019-12-01 03:50:39', '2019-12-01 03:50:39'),
(25, 5, 'Abir Hossain', 'abir@gmail.com', 'these input is going for final test', 1, '1575177980.jpg', 'rijwan chowdhury', 'rijwanc007@gmail.com', '2019-12-01 03:50:39', '2019-12-01 03:50:39'),
(27, 2, 'jahid hossain', 'jahid@gmail.com', 'these input is going for final test', 1, '1575177980.jpg', 'rijwan chowdhury', 'rijwanc007@gmail.com', '2019-12-01 03:50:39', '2019-12-01 03:50:39'),
(28, 3, 'rifat chowdhury', 'rifat@gmail.com', 'okay', 1, '1575177980.jpg', 'rijwan chowdhury', 'rijwanc007@gmail.com', '2019-12-01 04:19:16', '2019-12-01 04:19:16'),
(29, 9, 'Himel Hsaahn', 'himel@gmail.com', 'hi', 1, '1575177980.jpg', 'rijwan chowdhury', 'rijwanc007@gmail.com', '2019-12-01 04:21:45', '2019-12-01 04:21:45'),
(30, 3, 'rifat chowdhury', 'rifat@gmail.com', 'done', 1, '1575177980.jpg', 'rijwan chowdhury', 'rijwanc007@gmail.com', '2019-12-01 04:21:58', '2019-12-01 04:21:58'),
(31, 1, 'rijwan chowdhury', 'rijwanc007@gmail.com', 'thank you', 3, '1574668270.jpg', 'rifat chowdhury', 'rifat@gmail.com', '2019-12-01 04:22:47', '2019-12-01 04:22:47'),
(32, 10, 'supol chowdhury', 'supol@gmail.com', 'yo', 1, '1575177980.jpg', 'rijwan chowdhury', 'rijwanc007@gmail.com', '2019-12-01 04:36:34', '2019-12-01 04:36:34'),
(33, 9, 'Himel Hsaahn', 'himel@gmail.com', 'yo', 1, '1575177980.jpg', 'rijwan chowdhury', 'rijwanc007@gmail.com', '2019-12-01 04:36:34', '2019-12-01 04:36:34'),
(34, 7, 'Adib Hasan', 'mahmudul@gmail.com', 'yo', 1, '1575177980.jpg', 'rijwan chowdhury', 'rijwanc007@gmail.com', '2019-12-01 04:36:34', '2019-12-01 04:36:34'),
(35, 5, 'Abir Hossain', 'abir@gmail.com', 'yo', 1, '1575177980.jpg', 'rijwan chowdhury', 'rijwanc007@gmail.com', '2019-12-01 04:36:34', '2019-12-01 04:36:34'),
(36, 3, 'rifat chowdhury', 'rifat@gmail.com', 'yo', 1, '1575177980.jpg', 'rijwan chowdhury', 'rijwanc007@gmail.com', '2019-12-01 04:36:34', '2019-12-01 04:36:34'),
(37, 2, 'jahid hossain', 'jahid@gmail.com', 'yo', 1, '1575177980.jpg', 'rijwan chowdhury', 'rijwanc007@gmail.com', '2019-12-01 04:36:34', '2019-12-01 04:36:34');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_11_21_045033_create_sub_heads_table', 2),
(5, '2019_11_21_045057_create_sub_sub_heads_table', 2),
(6, '2019_11_23_102347_add_columns_users_table', 2),
(8, '2019_11_25_074445_add_another_column_user_table', 3),
(11, '2019_11_26_050616_create_messages_table', 4),
(13, '2019_12_01_054414_create_announcements_table', 5),
(14, '2019_12_01_093808_add_columns_message_table', 6),
(16, '2019_12_01_111650_create_accounts_table', 7),
(17, '2019_11_21_040928_create_main_heads_table', 8),
(18, '2019_08_19_000000_create_failed_jobs_table', 9),
(19, '2020_11_21_043302_create_banks_table', 9),
(20, '2020_12_27_105312_create_journals_table', 9),
(21, '2021_03_13_122329_create_sisterconcerns_table', 9),
(22, '2021_03_18_122024_create_cheques_table', 9),
(23, '2021_04_03_104540_create_contra_journals_table', 9),
(24, '2021_07_08_091035_add_column_banks_table', 9),
(25, '2021_08_13_183849_create_chartofaccounts_table', 9),
(26, '2021_08_13_194052_create_debit_vouchers_table', 9),
(27, '2021_08_13_194114_create_credit_vouchers_table', 9),
(28, '2021_08_26_035915_create_activities_table', 9),
(29, '2021_09_13_140003_create_accountings_table', 9),
(30, '2021_11_18_121856_add_sister_concern_id_to_users_table', 9),
(31, '2021_12_13_171945_add_new_column_to_chartofaccount', 9);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sisterconcerns`
--

CREATE TABLE `sisterconcerns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sisterconcerns`
--

INSERT INTO `sisterconcerns` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'setcolbd', 'Active', '2022-01-03 05:38:57', '2022-01-03 05:38:57');

-- --------------------------------------------------------

--
-- Table structure for table `sub_heads`
--

CREATE TABLE `sub_heads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_sub_heads`
--

CREATE TABLE `sub_sub_heads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sister_concern_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nid` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_person` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `sister_concern_id`, `first_name`, `last_name`, `name`, `image`, `email`, `phone`, `address`, `nid`, `position`, `about`, `created_person`, `status`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '0', 'rijwan', 'chowdhury', 'rijwan chowdhury', '1575177980.jpg', 'rijwanc007@gmail.com', '01986348224', '135/1 matikata,dhaka-cantonment,dhaka-1206', '1993586547986', 'software engineer', 'handle hole team', 'rijwan chowdhury', 'hide', NULL, '$2y$10$sLWwY9S2b4/kEEYBMw02Z.iz2FXRX.vCNhI20.rbntwFxm4t4ykPW', NULL, '2019-11-15 22:30:36', '2019-11-30 23:27:16'),
(2, '0', 'jahid', 'hossain', 'jahid hossain', '1574667826.jpg', 'jahid@gmail.com', '01521434247', 'block-e,road-6,bonoshri rampura', '1994586547123', 'junior software engineer', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.\r\n\r\nThe standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.', 'rijwan chowdhury', 'show', NULL, '$2y$10$uighXOuITT4hMNQuiv8BxuqGAOtUCouRFVd6zCFcLIDhJVmFbN6BS', NULL, '2019-11-25 01:43:46', '2019-11-25 01:43:46'),
(3, '0', 'rifat', 'chowdhury', 'rifat chowdhury', '1574668270.jpg', 'rifat@gmail.com', '01824318212', 'dscc 329/4,deamra dhaka', '1994586547124', 'junior software engineer', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.\r\n\r\nThe standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.', 'rijwan chowdhury', 'show', NULL, '$2y$10$7935GZ1iLoYlx.tw/Av4bO7NKGPD3/hhtPdL8ppNSJZ2rDuk.i15K', NULL, '2019-11-25 01:51:10', '2019-11-25 01:51:10'),
(5, '0', 'Abir', 'Hossain', 'Abir Hossain', '1574741282.jpg', 'abir@gmail.com', '1245678912', 'banasree Rampura dhaka', '1234567891234', 'student', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.\r\n\r\nThe standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.', 'rijwan chowdhury', 'show', NULL, '$2y$10$.99BulBz97s30wTSrUwsJ.1tTQYVvtDPyyFxGawI.SsTlqJOohq4m', NULL, '2019-11-25 22:08:02', '2019-11-25 22:08:02'),
(7, '0', 'Adib', 'Hasan', 'Adib Hasan', '1574741470.png', 'mahmudul@gmail.com', '45657891234', 'Badda', '7896543215975', 'Student', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.\r\n\r\nThe standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.', 'rijwan chowdhury', 'show', NULL, '$2y$10$M7fkOzoNd1FFvi.VN1XShecLfqPHlMOE55HhJe5.uf9n/1v4t.jbq', NULL, '2019-11-25 22:11:10', '2019-11-25 22:11:10'),
(9, '0', 'Himel', 'Hsaahn', 'Himel Hsaahn', '1574741564.png', 'himel@gmail.com', '45678912348', 'nikunj', '7598463218642', 'studentm', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.\r\n\r\nThe standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.', 'rijwan chowdhury', 'show', NULL, '$2y$10$lMGlqKahru2iWK.F/Axaw.hJovGi21HPa9HPc3BEXejBVgHH5j/16', NULL, '2019-11-25 22:12:44', '2019-11-25 22:12:44'),
(10, '0', 'supol', 'chowdhury', 'supol chowdhury', '1575172960.jpg', 'supol@gmail.com', '01986348225', '135/1 matikata,dhaka-cantonment,dhaka-1206', '0156249835264', 'engineer', 'these output is going for test purpose', 'rijwan chowdhury', 'show', NULL, '$2y$10$XimmO1Y7FcdkzSsv5XRMfuLm4A5bH9nBjASZksLJR58Y.sb6zEsI.', NULL, '2019-11-30 22:02:41', '2019-11-30 22:02:41'),
(11, '0', 'Nadim', 'Hridoy', 'Nadim Hridoy', '1575260727.jpg', 'nadim@gmail.com', '01552987430', 'ffsf', '8745632158987', 'SE', 'ssgsg', 'rifat chowdhury', 'show', NULL, '$2y$10$um4ELCOp7/BV.n9ryvYzPuYvovBMkX8rtWs.LSJ1W0wrsyKeE9z8K', NULL, '2019-12-01 22:25:27', '2019-12-01 22:25:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accountings`
--
ALTER TABLE `accountings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chartofaccounts`
--
ALTER TABLE `chartofaccounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cheques`
--
ALTER TABLE `cheques`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contra_journals`
--
ALTER TABLE `contra_journals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `credit_vouchers`
--
ALTER TABLE `credit_vouchers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `debit_vouchers`
--
ALTER TABLE `debit_vouchers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journals`
--
ALTER TABLE `journals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `main_heads`
--
ALTER TABLE `main_heads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `sisterconcerns`
--
ALTER TABLE `sisterconcerns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_heads`
--
ALTER TABLE `sub_heads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_sub_heads`
--
ALTER TABLE `sub_sub_heads`
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
-- AUTO_INCREMENT for table `accountings`
--
ALTER TABLE `accountings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chartofaccounts`
--
ALTER TABLE `chartofaccounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cheques`
--
ALTER TABLE `cheques`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contra_journals`
--
ALTER TABLE `contra_journals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `credit_vouchers`
--
ALTER TABLE `credit_vouchers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `debit_vouchers`
--
ALTER TABLE `debit_vouchers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `journals`
--
ALTER TABLE `journals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `main_heads`
--
ALTER TABLE `main_heads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `sisterconcerns`
--
ALTER TABLE `sisterconcerns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sub_heads`
--
ALTER TABLE `sub_heads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_sub_heads`
--
ALTER TABLE `sub_sub_heads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
