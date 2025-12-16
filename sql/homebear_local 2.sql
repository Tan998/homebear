-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th12 16, 2025 lúc 06:25 PM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `homebear_local`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `black_list_ip`
--

CREATE TABLE `black_list_ip` (
  `ip` varchar(50) NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `blocked_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `company_logo_settings`
--

CREATE TABLE `company_logo_settings` (
  `id` int(11) NOT NULL,
  `logo_filename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `company_profile`
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
-- Cấu trúc bảng cho bảng `company_profile_fields_ver2`
--

CREATE TABLE `company_profile_fields_ver2` (
  `id` int(11) NOT NULL,
  `company_profile_id` int(11) NOT NULL,
  `field_key` varchar(255) NOT NULL,
  `field_value` text NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `company_profile_images`
--

CREATE TABLE `company_profile_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_profile_id` int(10) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `company_profile_images_ver2`
--

CREATE TABLE `company_profile_images_ver2` (
  `id` int(11) NOT NULL,
  `company_profile_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `company_profile_ver2`
--

CREATE TABLE `company_profile_ver2` (
  `id` int(11) NOT NULL,
  `text_company_profile` text DEFAULT NULL,
  `text_content` text DEFAULT NULL,
  `title_img` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contact`
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
-- Cấu trúc bảng cho bảng `download_materials_form`
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
-- Cấu trúc bảng cho bảng `font_settings`
--

CREATE TABLE `font_settings` (
  `id` int(11) NOT NULL,
  `page_key` varchar(100) NOT NULL,
  `font_family` varchar(255) NOT NULL,
  `font_url` text NOT NULL,
  `css_selector` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hp_background_settings`
--

CREATE TABLE `hp_background_settings` (
  `id` int(11) NOT NULL,
  `bg_lg_filename` varchar(255) DEFAULT NULL,
  `bg_sm_filename` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
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
-- Cấu trúc bảng cho bảng `posts`
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
-- Cấu trúc bảng cho bảng `post_images`
--

CREATE TABLE `post_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `project_categories`
--

CREATE TABLE `project_categories` (
  `id` int(11) NOT NULL,
  `category_key` varchar(50) DEFAULT NULL,
  `category_name` varchar(50) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `project_items`
--

CREATE TABLE `project_items` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `construction_place` varchar(255) DEFAULT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `project_settings`
--

CREATE TABLE `project_settings` (
  `id` int(11) NOT NULL DEFAULT 1,
  `top_bg_image` varchar(255) DEFAULT NULL,
  `footer_text` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `role` varchar(20) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `youtube_videos`
--

CREATE TABLE `youtube_videos` (
  `id` int(11) NOT NULL,
  `youtube_id` varchar(50) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `black_list_ip`
--
ALTER TABLE `black_list_ip`
  ADD PRIMARY KEY (`ip`);

--
-- Chỉ mục cho bảng `company_logo_settings`
--
ALTER TABLE `company_logo_settings`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `company_profile`
--
ALTER TABLE `company_profile`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `company_profile_fields_ver2`
--
ALTER TABLE `company_profile_fields_ver2`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_profile_id` (`company_profile_id`);

--
-- Chỉ mục cho bảng `company_profile_images`
--
ALTER TABLE `company_profile_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_profile_id` (`company_profile_id`);

--
-- Chỉ mục cho bảng `company_profile_images_ver2`
--
ALTER TABLE `company_profile_images_ver2`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_profile_id` (`company_profile_id`);

--
-- Chỉ mục cho bảng `company_profile_ver2`
--
ALTER TABLE `company_profile_ver2`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `download_materials_form`
--
ALTER TABLE `download_materials_form`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `access_token` (`access_token`);

--
-- Chỉ mục cho bảng `font_settings`
--
ALTER TABLE `font_settings`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `hp_background_settings`
--
ALTER TABLE `hp_background_settings`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `post_images`
--
ALTER TABLE `post_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Chỉ mục cho bảng `project_categories`
--
ALTER TABLE `project_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_key` (`category_key`);

--
-- Chỉ mục cho bảng `project_items`
--
ALTER TABLE `project_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `project_settings`
--
ALTER TABLE `project_settings`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Chỉ mục cho bảng `youtube_videos`
--
ALTER TABLE `youtube_videos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `company_profile`
--
ALTER TABLE `company_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `company_profile_fields_ver2`
--
ALTER TABLE `company_profile_fields_ver2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `company_profile_images`
--
ALTER TABLE `company_profile_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `company_profile_images_ver2`
--
ALTER TABLE `company_profile_images_ver2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `company_profile_ver2`
--
ALTER TABLE `company_profile_ver2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `download_materials_form`
--
ALTER TABLE `download_materials_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `font_settings`
--
ALTER TABLE `font_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `hp_background_settings`
--
ALTER TABLE `hp_background_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `post_images`
--
ALTER TABLE `post_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `project_categories`
--
ALTER TABLE `project_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `project_items`
--
ALTER TABLE `project_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `youtube_videos`
--
ALTER TABLE `youtube_videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `post_images`
--
ALTER TABLE `post_images`
  ADD CONSTRAINT `post_images_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `project_items`
--
ALTER TABLE `project_items`
  ADD CONSTRAINT `project_items_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `project_categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
