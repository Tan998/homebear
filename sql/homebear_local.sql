-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2025-11-28 07:26:27
-- サーバのバージョン： 10.4.27-MariaDB
-- PHP のバージョン: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `homebear_local`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `black_list_ip`
--

CREATE TABLE `black_list_ip` (
  `ip` varchar(50) NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `blocked_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `company_profile`
--

CREATE TABLE `company_profile` (
  `id` int(11) NOT NULL,
  `text_company_profile` text DEFAULT NULL,
  `text_content` text DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `company_address` text DEFAULT NULL,
  `company_phone` varchar(50) DEFAULT NULL,
  `establishment_date` varchar(50) DEFAULT NULL,
  `capital_stock` varchar(100) DEFAULT NULL,
  `list_staff` text DEFAULT NULL,
  `number_of_employees` varchar(50) DEFAULT NULL,
  `permits_and_licenses` text DEFAULT NULL,
  `intellectual_property` text DEFAULT NULL,
  `business_content` text DEFAULT NULL,
  `bank_info` text DEFAULT NULL,
  `title_img` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `company_profile_images`
--

CREATE TABLE `company_profile_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_profile_id` int(10) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `contact_type` varchar(50) NOT NULL,
  `customer_type` varchar(50) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_address` text DEFAULT NULL,
  `contact_text` text NOT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `ip` varchar(50) DEFAULT NULL,
  `last_submit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `download_materials_form`
--

CREATE TABLE `download_materials_form` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `customer_fname` varchar(100) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(50) NOT NULL,
  `membership_size` varchar(50) DEFAULT NULL,
  `current_operation_status` varchar(100) DEFAULT NULL,
  `submitted_at` datetime DEFAULT current_timestamp(),
  `access_token` varchar(64) NOT NULL,
  `token_expired_at` datetime NOT NULL,
  `is_used` tinyint(1) DEFAULT 0,
  `explanation_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = No, 1 = Yes',
  `showroom_tour_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = No, 1 = Yes	',
  `ip` varchar(50) DEFAULT NULL,
  `last_submit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `hp_background_settings`
--

CREATE TABLE `hp_background_settings` (
  `id` int(11) NOT NULL,
  `bg_lg_filename` varchar(255) DEFAULT NULL,
  `bg_sm_filename` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `news_title` varchar(255) NOT NULL,
  `news_content` text NOT NULL,
  `publish_date` date NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `text_content` text NOT NULL,
  `title_img` varchar(255) DEFAULT NULL,
  `publish_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `before_issue` text DEFAULT NULL,
  `after_effect` text DEFAULT NULL,
  `used_features` text DEFAULT NULL,
  `ShopName` varchar(200) DEFAULT NULL,
  `Address` varchar(500) DEFAULT NULL,
  `Link` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `post_images`
--

CREATE TABLE `post_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `role` varchar(20) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `role`) VALUES
(1, 'admin', '$2y$10$o9SV45k62WmfwfRUIY6vPe8dWxpgmKJl3Rcb.UFzgTgoRcGpRp6AK', '2025-07-01 01:49:16', 'admin'),
(3, 'user', '$2y$10$P6h6UoD.mmci9NV3isn2OuW5gBLrj3xBsD6BB2.y96nPUqzu2ypF2', '2025-07-01 02:15:15', 'user'),
(6, 'admin4', '$2y$10$pKFFc5XjPDDCwh1vwR65/OtXi20.v5RRhAaYAtdrQMCcBYObpNlui', '2025-07-01 03:25:10', 'admin'),
(7, 'admin2', '$2y$10$lF.Bff34pMYGvMQMvPR8P.2dLSr0hgdC/REEHn73g/mHSnNSMzg.a', '2025-07-01 03:25:29', 'admin');

-- --------------------------------------------------------

--
-- テーブルの構造 `youtube_videos`
--

CREATE TABLE `youtube_videos` (
  `id` int(11) NOT NULL,
  `youtube_id` varchar(50) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `black_list_ip`
--
ALTER TABLE `black_list_ip`
  ADD PRIMARY KEY (`ip`);

--
-- テーブルのインデックス `company_profile`
--
ALTER TABLE `company_profile`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `company_profile_images`
--
ALTER TABLE `company_profile_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_profile_id` (`company_profile_id`);

--
-- テーブルのインデックス `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `download_materials_form`
--
ALTER TABLE `download_materials_form`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `access_token` (`access_token`);

--
-- テーブルのインデックス `hp_background_settings`
--
ALTER TABLE `hp_background_settings`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `post_images`
--
ALTER TABLE `post_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- テーブルのインデックス `youtube_videos`
--
ALTER TABLE `youtube_videos`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `company_profile`
--
ALTER TABLE `company_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- テーブルの AUTO_INCREMENT `company_profile_images`
--
ALTER TABLE `company_profile_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `download_materials_form`
--
ALTER TABLE `download_materials_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `hp_background_settings`
--
ALTER TABLE `hp_background_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- テーブルの AUTO_INCREMENT `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `post_images`
--
ALTER TABLE `post_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- テーブルの AUTO_INCREMENT `youtube_videos`
--
ALTER TABLE `youtube_videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `post_images`
--
ALTER TABLE `post_images`
  ADD CONSTRAINT `post_images_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
