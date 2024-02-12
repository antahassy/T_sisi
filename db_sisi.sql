-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2024 at 01:26 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sisi`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(11, '2014_10_12_000000_create_users_table', 1),
(12, '2014_10_12_100000_create_password_resets_table', 1),
(13, '2019_08_19_000000_create_failed_jobs_table', 1),
(14, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(15, '2023_12_26_061409_create_tb_user_table', 1),
(16, '2023_12_26_061625_create_tb_user_group_table', 1),
(17, '2023_12_26_061644_create_tb_user_menu_table', 1),
(18, '2023_12_26_061659_create_tb_user_rel_group_table', 1),
(19, '2023_12_26_061710_create_tb_user_setting_table', 1),
(20, '2023_12_26_061722_create_tb_user_group_2_table', 1),
(21, '2024_02_11_143726_create_tb_user_activity_table', 1),
(22, '2024_02_11_143748_create_tb_error_application_table', 1);

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
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_error_application`
--

CREATE TABLE `tb_error_application` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` smallint(6) NOT NULL DEFAULT 0,
  `tanggal` date NOT NULL,
  `module` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `controller` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `function` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `error_line` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `error_message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `parameter` text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `deleted_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_error_application`
--

INSERT INTO `tb_error_application` (`id`, `id_user`, `tanggal`, `module`, `controller`, `function`, `error_line`, `error_message`, `status`, `parameter`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 0, '2024-02-12', 'login', 'login', 'http://127.0.0.1:8000/admin/logins', '', 'The route admin/logins could not be found.', '', '{\"_method\":\"post\",\"login_username\":\"administrator\",\"login_password\":\"password\"}', '0', '', '', '2024-02-11 17:38:12', NULL, NULL),
(2, 0, '2024-02-12', '/admin/logins', '/admin/logins', '/admin/logins', '', 'The route admin/logins could not be found.', '', '{\"_method\":\"post\",\"login_username\":\"administrator\",\"login_password\":\"password\"}', '0', '', '', '2024-02-11 17:42:07', NULL, NULL),
(3, 1, '2024-02-12', 'http://127.0.0.1:8000/group_admin', 'http://127.0.0.1:8000/group_admin', 'http://127.0.0.1:8000/group_admin', '', 'The route group_admins could not be found.', '', '-', '1', '', '', '2024-02-11 18:34:02', NULL, NULL),
(4, 1, '2024-02-12', '/group_admin', '/group_admin', '/group_admin', '', 'The route group_admins could not be found.', '', '-', '1', '', '', '2024-02-11 18:35:07', NULL, NULL),
(5, 0, '2024-02-12', '/admin/logins', '/admin/logins', '/admin/logins', '', 'The route admin/logins could not be found.', '', '{\"_method\":\"post\",\"login_username\":\"administrator\",\"login_password\":\"password\"}', '0', '', '', '2024-02-11 18:36:34', NULL, NULL),
(6, 1, '2024-02-12', '/list_admin/1/edit', '/list_admin/1/edit', '/list_admin/1/edit', '', 'The route list_admins/1/edit could not be found.', '', '-', '1', '', '', '2024-02-11 18:39:25', NULL, NULL),
(7, 1, '2024-02-12', '/list_admin/hapus', '/list_admin/hapus', '/list_admin/hapus', '', 'The POST method is not supported for route list_admin/hapuss. Supported methods: GET, HEAD, PUT, PATCH, DELETE.', '', '1', '1', '', '', '2024-02-11 18:46:17', NULL, NULL),
(8, 1, '2024-02-12', '/group_admin/update_akses', '/group_admin/update_akses', '/group_admin/update_akses', '', 'The POST method is not supported for route group_admin/update_akse. Supported methods: GET, HEAD, PUT, PATCH, DELETE.', '', '{\"0\":{\"data\":[{\"id_menu\":1,\"akses\":[0,0,0,0]},{\"id_menu\":2,\"akses\":[0,0,0,0]},{\"id_menu\":3,\"akses\":[0,0,0,0]},{\"id_menu\":4,\"akses\":[0,0,0,0]},{\"id_menu\":5,\"akses\":[0,0,0,0]},{\"id_menu\":6,\"akses\":[1,2,3,0]}],\"id_group\":\"2\"}}', '1', '', '', '2024-02-11 19:04:51', NULL, NULL),
(9, 1, '2024-02-12', '/group_admin/update_akses', '/group_admin/update_akses', '/group_admin/update_akses', '', 'The POST method is not supported for route group_admin/update_akse. Supported methods: GET, HEAD, PUT, PATCH, DELETE.', '', '{\"0\":{\"data\":[{\"id_menu\":1,\"akses\":[0,0,0,0]},{\"id_menu\":2,\"akses\":[0,0,0,0]},{\"id_menu\":3,\"akses\":[0,0,0,0]},{\"id_menu\":4,\"akses\":[0,0,0,0]},{\"id_menu\":5,\"akses\":[0,0,0,0]},{\"id_menu\":6,\"akses\":[1,0,0,0]}],\"id_group\":\"2\"}}', '1', '', '', '2024-02-11 19:06:56', NULL, NULL),
(10, 1, '2024-02-12', '/group_admin/update_akses', '/group_admin/update_akses', '/group_admin/update_akses', '', 'Attempt to read property \"id_menu\" on array', '', '{\"0\":{\"data\":[{\"id_menu\":1,\"akses\":[0,0,0,0]},{\"id_menu\":2,\"akses\":[0,0,0,0]},{\"id_menu\":3,\"akses\":[0,0,0,0]},{\"id_menu\":4,\"akses\":[0,0,0,0]},{\"id_menu\":5,\"akses\":[0,0,0,0]},{\"id_menu\":6,\"akses\":[1,2,0,0]}],\"id_group\":\"2\"}}', '1', '', '', '2024-02-11 19:35:49', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` longtext COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `active` smallint(6) NOT NULL DEFAULT 1,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `deleted_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id`, `username`, `email`, `password`, `active`, `phone`, `image`, `nama`, `alamat`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'administrator', 'admin@admin.com', '$2y$10$4ASBOdMoDRRbns.duvFCOu981o.OLhHxcSak.iVN1mQHk2pDlQGwK', 1, '087770067003', '', 'administrator', '', 'System', '1', '', '2024-02-11 07:50:56', '2024-02-11 23:54:33', NULL),
(2, 'Admin', NULL, '$2y$10$pnEhc0ZFVz9eFdrDiXDIQe5iSGaLUAMfjkAoDIgx3u6jayf0SuZgK', 1, NULL, '1707676038-sql srver.png', 'Admin', '', '1', '1', '', '2024-02-11 18:26:49', '2024-02-11 23:55:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_activity`
--

CREATE TABLE `tb_user_activity` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` smallint(6) NOT NULL DEFAULT 0,
  `id_menu` smallint(6) NOT NULL DEFAULT 0,
  `deskripsi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `deleted_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_user_activity`
--

INSERT INTO `tb_user_activity` (`id`, `id_user`, `id_menu`, `deskripsi`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 0, 'administrator login', '', '1', '', '', '2024-02-11 23:43:25', NULL, NULL),
(2, 1, 2, 'Mengaktifkan id_user 1', '', '1', '', '', '2024-02-11 23:54:15', NULL, NULL),
(3, 1, 2, 'Mengaktifkan id_user 1', '', '1', '', '', '2024-02-11 23:54:33', NULL, NULL),
(4, 1, 2, 'Menonaktifkan id_user 2', '', '1', '', '', '2024-02-11 23:55:17', NULL, NULL),
(5, 1, 2, 'Mengaktifkan id_user 2', '', '1', '', '', '2024-02-11 23:55:27', NULL, NULL),
(6, 1, 3, 'Menambahkan id_menu 7', '', '1', '', '', '2024-02-12 00:07:09', NULL, NULL),
(7, 1, 3, 'Mengupdate id_menu 7', '', '1', '', '', '2024-02-12 00:07:31', NULL, NULL),
(8, 1, 3, 'Menghapus id_user 7', '', '1', '', '', '2024-02-12 00:07:52', NULL, NULL),
(9, 1, 0, 'Logout', '', '1', '', '', '2024-02-12 00:09:04', NULL, NULL),
(10, 1, 0, 'administrator login', '', '1', '', '', '2024-02-12 00:09:30', NULL, NULL),
(11, 1, 4, 'Mengupdate id_group 2', '', '1', '', '', '2024-02-12 00:15:56', NULL, NULL),
(12, 1, 4, 'Menambahkan id_group 3', '', '1', '', '', '2024-02-12 00:16:31', NULL, NULL),
(13, 1, 4, 'Menghapus id_group 3', '', '1', '', '', '2024-02-12 00:16:44', NULL, NULL),
(14, 1, 4, 'Mengupdate akses menu id_group 2', '', '1', '', '', '2024-02-12 00:21:14', NULL, NULL),
(15, 1, 4, 'Mengupdate akses menu id_group 2', '', '1', '', '', '2024-02-12 00:21:38', NULL, NULL),
(16, 1, 4, 'Mengupdate id_group 2', '', '1', '', '', '2024-02-12 00:22:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_group`
--

CREATE TABLE `tb_user_group` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `deleted_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_user_group`
--

INSERT INTO `tb_user_group` (`id`, `name`, `description`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Administrator', 'Super Admin', 'System', '', '', '2024-02-11 07:50:56', NULL, NULL),
(2, 'User', 'Pengguna', 'System', '1', '', '2024-02-11 07:50:56', '2024-02-12 00:21:58', NULL),
(3, 'tes', 'tes', '1', '', '1', '2024-02-12 00:16:30', NULL, '2024-02-12 00:16:42');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_group_2`
--

CREATE TABLE `tb_user_group_2` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` smallint(6) NOT NULL DEFAULT 0,
  `id_group` smallint(6) NOT NULL DEFAULT 0,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `deleted_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_user_group_2`
--

INSERT INTO `tb_user_group_2` (`id`, `id_user`, `id_group`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'System', '1', '', '2024-02-11 07:50:56', '2024-02-11 19:17:53', NULL),
(2, 2, 2, '1', '1', '1', '2024-02-11 18:26:49', '2024-02-11 18:27:18', '2024-02-11 18:47:04');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_menu`
--

CREATE TABLE `tb_user_menu` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `urutan` smallint(6) NOT NULL DEFAULT 0,
  `rel` smallint(6) NOT NULL DEFAULT 0,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `deleted_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_user_menu`
--

INSERT INTO `tb_user_menu` (`id`, `menu`, `url`, `urutan`, `rel`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Super Admin', '#', 1, 0, 'System', '', '', '2024-02-11 07:50:57', NULL, NULL),
(2, 'Daftar User', 'list_admin', 1, 1, 'System', '1', '', '2024-02-11 07:50:57', '2024-02-11 19:17:03', NULL),
(3, 'Daftar Menu', 'menu_admin', 2, 1, 'System', '', '', '2024-02-11 07:50:57', NULL, NULL),
(4, 'Daftar Group', 'group_admin', 3, 1, 'System', '', '', '2024-02-11 07:50:57', NULL, NULL),
(5, 'Daftar Pengaturan', 'setting_admin', 4, 1, 'System', '', '', '2024-02-11 07:50:57', NULL, NULL),
(6, 'Dashboard', 'admin_dashboard', 2, 0, 'System', '', '', '2024-02-11 07:50:57', NULL, NULL),
(7, 'tes menus', '#', 3, 0, '1', '1', '1', '2024-02-12 00:07:07', '2024-02-12 00:07:30', '2024-02-12 00:07:51');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_rel_group`
--

CREATE TABLE `tb_user_rel_group` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_group` smallint(6) NOT NULL DEFAULT 0,
  `id_menu` smallint(6) NOT NULL DEFAULT 0,
  `akses` smallint(6) NOT NULL DEFAULT 0,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `deleted_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_user_rel_group`
--

INSERT INTO `tb_user_rel_group` (`id`, `id_group`, `id_menu`, `akses`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 1, 'System', '', '', '2024-02-11 07:50:56', NULL, NULL),
(2, 1, 6, 1, 'System', '', '', '2024-02-11 07:50:56', NULL, NULL),
(3, 2, 6, 1, 'System', '', '', '2024-02-11 07:50:56', NULL, NULL),
(4, 1, 2, 1, 'System', '', '', '2024-02-11 07:50:56', NULL, NULL),
(5, 1, 2, 2, 'System', '', '', '2024-02-11 07:50:56', NULL, NULL),
(6, 1, 2, 3, 'System', '', '', '2024-02-11 07:50:56', NULL, NULL),
(7, 1, 2, 4, 'System', '', '', '2024-02-11 07:50:56', NULL, NULL),
(8, 1, 3, 1, 'System', '', '', '2024-02-11 07:50:56', NULL, NULL),
(9, 1, 3, 2, 'System', '', '', '2024-02-11 07:50:56', NULL, NULL),
(10, 1, 3, 3, 'System', '', '', '2024-02-11 07:50:56', NULL, NULL),
(11, 1, 3, 4, 'System', '', '', '2024-02-11 07:50:56', NULL, NULL),
(12, 1, 4, 1, 'System', '', '', '2024-02-11 07:50:56', NULL, NULL),
(13, 1, 4, 2, 'System', '', '', '2024-02-11 07:50:56', NULL, NULL),
(14, 1, 4, 3, 'System', '', '', '2024-02-11 07:50:56', NULL, NULL),
(15, 1, 4, 4, 'System', '', '', '2024-02-11 07:50:56', NULL, NULL),
(16, 1, 5, 1, 'System', '', '', '2024-02-11 07:50:57', NULL, NULL),
(17, 1, 5, 2, 'System', '', '', '2024-02-11 07:50:57', NULL, NULL),
(18, 1, 5, 3, 'System', '', '', '2024-02-11 07:50:57', NULL, NULL),
(19, 1, 5, 4, 'System', '', '', '2024-02-11 07:50:57', NULL, NULL),
(40, 2, 1, 1, '1', '', '', '2024-02-11 19:33:09', NULL, NULL),
(41, 2, 1, 2, '1', '', '1', '2024-02-11 19:33:09', NULL, '2024-02-12 00:21:36'),
(42, 2, 1, 3, '1', '', '1', '2024-02-11 19:33:09', NULL, '2024-02-12 00:21:36'),
(43, 2, 1, 4, '1', '', '1', '2024-02-11 19:33:09', NULL, '2024-02-12 00:21:36'),
(44, 2, 2, 1, '1', '', '', '2024-02-11 19:33:09', NULL, NULL),
(45, 2, 2, 2, '1', '', '1', '2024-02-11 19:33:09', NULL, '2024-02-12 00:21:36'),
(46, 2, 2, 3, '1', '', '1', '2024-02-11 19:33:09', NULL, '2024-02-12 00:21:36'),
(47, 2, 2, 4, '1', '', '1', '2024-02-11 19:33:09', NULL, '2024-02-12 00:21:36'),
(48, 2, 3, 1, '1', '', '', '2024-02-11 19:33:09', NULL, NULL),
(49, 2, 3, 2, '1', '', '1', '2024-02-11 19:33:09', NULL, '2024-02-12 00:21:36'),
(50, 2, 3, 3, '1', '', '1', '2024-02-11 19:33:09', NULL, '2024-02-12 00:21:36'),
(51, 2, 3, 4, '1', '', '1', '2024-02-11 19:33:09', NULL, '2024-02-12 00:21:36'),
(52, 2, 4, 1, '1', '', '', '2024-02-11 19:33:09', NULL, NULL),
(53, 2, 4, 2, '1', '', '1', '2024-02-11 19:33:10', NULL, '2024-02-12 00:21:36'),
(54, 2, 4, 3, '1', '', '1', '2024-02-11 19:33:10', NULL, '2024-02-12 00:21:36'),
(55, 2, 4, 4, '1', '', '1', '2024-02-11 19:33:10', NULL, '2024-02-12 00:21:36'),
(56, 2, 5, 1, '1', '', '', '2024-02-11 19:33:10', NULL, NULL),
(57, 2, 5, 2, '1', '', '1', '2024-02-11 19:33:10', NULL, '2024-02-12 00:21:36'),
(58, 2, 5, 3, '1', '', '1', '2024-02-11 19:33:10', NULL, '2024-02-12 00:21:36'),
(59, 2, 5, 4, '1', '', '1', '2024-02-11 19:33:10', NULL, '2024-02-12 00:21:36');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_setting`
--

CREATE TABLE `tb_user_setting` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `meta_data` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `deleted_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_user_setting`
--

INSERT INTO `tb_user_setting` (`id`, `meta_data`, `value`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'url', 'Nama Domain', 'System', '', '', '2024-02-11 07:50:57', NULL, NULL),
(2, 'title', 'Nama Situs - Judul', 'System', '', '', '2024-02-11 07:50:57', NULL, NULL),
(3, 'description', 'Nama Situs - Deskripsi', 'System', '', '', '2024-02-11 07:50:57', NULL, NULL),
(4, 'icon', 'icon.png', 'System', '', '', '2024-02-11 07:50:57', NULL, NULL),
(5, 'icon_text', 'icon_text.png', 'System', '', '', '2024-02-11 07:50:57', NULL, NULL),
(6, 'footer', 'Nama Situs', 'System', '', '', '2024-02-11 07:50:57', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

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
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `tb_error_application`
--
ALTER TABLE `tb_error_application`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_user_activity`
--
ALTER TABLE `tb_user_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_user_group`
--
ALTER TABLE `tb_user_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_user_group_2`
--
ALTER TABLE `tb_user_group_2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_user_menu`
--
ALTER TABLE `tb_user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_user_rel_group`
--
ALTER TABLE `tb_user_rel_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_user_setting`
--
ALTER TABLE `tb_user_setting`
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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_error_application`
--
ALTER TABLE `tb_error_application`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_user_activity`
--
ALTER TABLE `tb_user_activity`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tb_user_group`
--
ALTER TABLE `tb_user_group`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_user_group_2`
--
ALTER TABLE `tb_user_group_2`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_user_menu`
--
ALTER TABLE `tb_user_menu`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_user_rel_group`
--
ALTER TABLE `tb_user_rel_group`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `tb_user_setting`
--
ALTER TABLE `tb_user_setting`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
