-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 02, 2024 lúc 04:07 AM
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
-- Cơ sở dữ liệu: `db-laptop-store-laravel`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_id` int(10) UNSIGNED NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_admin`
--

INSERT INTO `tbl_admin` (`admin_id`, `admin_name`, `admin_email`, `admin_password`, `created_at`, `updated_at`) VALUES
(1, 'Lê Nguyễn Khánh Duy', 'admin@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_banner`
--

CREATE TABLE `tbl_banner` (
  `banner_id` int(10) UNSIGNED NOT NULL,
  `banner_name` varchar(255) NOT NULL,
  `banner_image` varchar(255) NOT NULL,
  `banner_status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_banner`
--

INSERT INTO `tbl_banner` (`banner_id`, `banner_name`, `banner_image`, `banner_status`, `created_at`, `updated_at`) VALUES
(1, 'abcd', 'asus-vivobook-go-15-e1504fa-r5-nj776w-glr-3_1712006270.jpg', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_brand`
--

CREATE TABLE `tbl_brand` (
  `brand_id` int(10) UNSIGNED NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `brand_slug` varchar(255) NOT NULL,
  `brand_status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_brand`
--

INSERT INTO `tbl_brand` (`brand_id`, `brand_name`, `brand_slug`, `brand_status`, `created_at`, `updated_at`) VALUES
(1, 'dell', 'dell', 1, '2024-04-01 21:08:53', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_cart`
--

CREATE TABLE `tbl_cart` (
  `cart_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_category_post`
--

CREATE TABLE `tbl_category_post` (
  `category_post_id` int(10) UNSIGNED NOT NULL,
  `category_post_name` varchar(255) NOT NULL,
  `category_post_slug` varchar(255) NOT NULL,
  `category_post_status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_category_product`
--

CREATE TABLE `tbl_category_product` (
  `category_product_id` int(10) UNSIGNED NOT NULL,
  `category_product_name` varchar(255) NOT NULL,
  `category_product_slug` varchar(255) NOT NULL,
  `category_product_parent` int(11) NOT NULL,
  `category_product_status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_category_product`
--

INSERT INTO `tbl_category_product` (`category_product_id`, `category_product_name`, `category_product_slug`, `category_product_parent`, `category_product_status`, `created_at`, `updated_at`) VALUES
(1, 'danh muc con 1', 'danh-muc-con-1', 0, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_comment`
--

CREATE TABLE `tbl_comment` (
  `comment_id` bigint(20) UNSIGNED NOT NULL,
  `comment_content` varchar(255) NOT NULL,
  `comment_reply` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `comment_status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_comment`
--

INSERT INTO `tbl_comment` (`comment_id`, `comment_content`, `comment_reply`, `user_id`, `product_id`, `comment_status`, `created_at`, `updated_at`) VALUES
(1, 'hihih', '', 1, 6, 0, '2024-04-01 19:03:40', '2024-04-01 19:03:40');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_gallery`
--

CREATE TABLE `tbl_gallery` (
  `gallery_id` int(10) UNSIGNED NOT NULL,
  `gallery_image` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_gallery`
--

INSERT INTO `tbl_gallery` (`gallery_id`, `gallery_image`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 'asus-vivobook-go-15-e1504fa-r5-nj776w-glr-2_1712006079.jpg', 1, NULL, NULL),
(2, 'asus-vivobook-go-15-e1504fa-r5-nj776w-glr-3_1712006079.jpg', 1, NULL, NULL),
(3, 'asus-vivobook-go-15-e1504fa-r5-nj776w-glr-4_1712006079.jpg', 1, NULL, NULL),
(4, 'asus-vivobook-go-15-e1504fa-r5-nj776w-glr-5_1712006079.jpg', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_order`
--

CREATE TABLE `tbl_order` (
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_code` varchar(255) NOT NULL,
  `order_name` varchar(255) NOT NULL,
  `order_address` varchar(255) NOT NULL,
  `order_phone` varchar(255) NOT NULL,
  `order_note` text NOT NULL,
  `order_payment_method` varchar(255) NOT NULL,
  `voucher_id` varchar(255) NOT NULL,
  `order_total` varchar(255) NOT NULL,
  `order_status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_order`
--

INSERT INTO `tbl_order` (`order_id`, `user_id`, `order_code`, `order_name`, `order_address`, `order_phone`, `order_note`, `order_payment_method`, `voucher_id`, `order_total`, `order_status`, `created_at`, `updated_at`) VALUES
(1, 1, 'DHSTS5ooSR2f', 'Duy', '1', '123456', '0', 'cod_payment', '0', '83960000', 0, '2024-04-01 17:52:35', '2024-04-01 17:52:35'),
(2, 1, 'DHRD3areieQt', 'Duy 1', '111', '111', '1', 'cod_payment', '0', '20990000', 0, '2024-04-01 17:55:46', '2024-04-01 17:55:46');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_order_detail`
--

CREATE TABLE `tbl_order_detail` (
  `order_detail_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `product_price` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_order_detail`
--

INSERT INTO `tbl_order_detail` (`order_detail_id`, `order_id`, `product_id`, `product_quantity`, `product_price`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 2, '20990000', NULL, NULL),
(2, 1, 3, 1, '20990000', NULL, NULL),
(3, 1, 6, 1, '20990000', NULL, NULL),
(4, 2, 6, 1, '20990000', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_post`
--

CREATE TABLE `tbl_post` (
  `post_id` int(10) UNSIGNED NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_slug` varchar(255) NOT NULL,
  `post_desc` varchar(255) NOT NULL,
  `post_content` text NOT NULL,
  `post_image` varchar(255) NOT NULL,
  `category_post_id` int(11) NOT NULL,
  `post_views` bigint(20) NOT NULL,
  `post_status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_product`
--

CREATE TABLE `tbl_product` (
  `product_id` int(10) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_slug` varchar(255) NOT NULL,
  `category_product_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `product_sold` int(11) NOT NULL,
  `product_desc` text NOT NULL,
  `product_cost` varchar(255) NOT NULL,
  `product_price` varchar(255) NOT NULL,
  `product_price_discount` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_status` int(11) NOT NULL,
  `product_views` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_product`
--

INSERT INTO `tbl_product` (`product_id`, `product_name`, `product_slug`, `category_product_id`, `brand_id`, `product_quantity`, `product_sold`, `product_desc`, `product_cost`, `product_price`, `product_price_discount`, `product_image`, `product_status`, `product_views`, `created_at`, `updated_at`) VALUES
(1, 'asus1', 'asus1', 1, 1, 10, 0, 'asus1', '17000000', '20990000', '0', 'asus-vivobook-go-15-e1504fa-r5-nj776w-glr-1_1712006066.jpg', 1, 27, NULL, NULL),
(2, 'asus11', 'asus11', 1, 1, 10, 0, 'asus1', '17000000', '20990000', '0', 'asus-vivobook-go-15-e1504fa-r5-nj776w-glr-1_1712006066.jpg', 1, 2, NULL, NULL),
(3, 'asus12', 'asus12', 1, 1, 10, 1, 'asus1', '17000000', '20990000', '0', 'asus-vivobook-go-15-e1504fa-r5-nj776w-glr-1_1712006066.jpg', 1, 2, NULL, NULL),
(4, 'asus13', 'asus13', 1, 1, 10, 0, 'asus1', '17000000', '20990000', '0', 'asus-vivobook-go-15-e1504fa-r5-nj776w-glr-1_1712006066.jpg', 1, 2, NULL, NULL),
(5, 'asus14', 'asus14', 1, 1, 10, 2, 'asus1', '17000000', '20990000', '0', 'asus-vivobook-go-15-e1504fa-r5-nj776w-glr-1_1712006066.jpg', 1, 3, NULL, NULL),
(6, ' Lorem, ipsum dolor sit amet consectetur adipisicing elit. Culpa excepturi, laudantium, dignissimos voluptatibus minus aliquam voluptas nisi, consequuntur repellat error cum aspernatur beatae accusantium quis vero? Numquam odio eius neque.', 'asus15', 1, 1, 10, 2, 'asus1', '17000000', '20990000', '0', 'asus-vivobook-go-15-e1504fa-r5-nj776w-glr-1_1712006066.jpg', 1, 22, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_social`
--

CREATE TABLE `tbl_social` (
  `social_id` int(10) UNSIGNED NOT NULL,
  `provider_user_id` varchar(255) NOT NULL,
  `provider` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_statistical`
--

CREATE TABLE `tbl_statistical` (
  `statistical_id` bigint(20) UNSIGNED NOT NULL,
  `statistical_date` varchar(255) NOT NULL,
  `statistical_sales` varchar(255) NOT NULL,
  `statistical_profit` varchar(255) NOT NULL,
  `statistical_quantity` int(11) NOT NULL,
  `statistical_total_order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_statistical`
--

INSERT INTO `tbl_statistical` (`statistical_id`, `statistical_date`, `statistical_sales`, `statistical_profit`, `statistical_quantity`, `statistical_total_order`, `created_at`, `updated_at`) VALUES
(1, '2024-04-02', '104950000', '19950000', 5, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `reset_code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `full_name`, `user_email`, `user_password`, `reset_code`, `created_at`, `updated_at`) VALUES
(1, 'Duy', 'khanhduyhby731@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '327872', '2024-04-01 12:58:51', '2024-04-01 13:00:32');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_voucher`
--

CREATE TABLE `tbl_voucher` (
  `voucher_id` int(10) UNSIGNED NOT NULL,
  `voucher_name` varchar(255) NOT NULL,
  `voucher_code` varchar(255) NOT NULL,
  `voucher_type` int(11) NOT NULL,
  `voucher_discount_amount` varchar(255) NOT NULL,
  `voucher_quantity` int(11) NOT NULL,
  `voucher_used` int(11) NOT NULL,
  `voucher_used_by_user` varchar(255) NOT NULL,
  `voucher_status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_voucher`
--

INSERT INTO `tbl_voucher` (`voucher_id`, `voucher_name`, `voucher_code`, `voucher_type`, `voucher_discount_amount`, `voucher_quantity`, `voucher_used`, `voucher_used_by_user`, `voucher_status`, `created_at`, `updated_at`) VALUES
(1, 'Mã giảm giá 1', 'VLTI4VRBCH', 1, '150000', 10, 0, '', 1, NULL, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Chỉ mục cho bảng `tbl_banner`
--
ALTER TABLE `tbl_banner`
  ADD PRIMARY KEY (`banner_id`);

--
-- Chỉ mục cho bảng `tbl_brand`
--
ALTER TABLE `tbl_brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Chỉ mục cho bảng `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Chỉ mục cho bảng `tbl_category_post`
--
ALTER TABLE `tbl_category_post`
  ADD PRIMARY KEY (`category_post_id`);

--
-- Chỉ mục cho bảng `tbl_category_product`
--
ALTER TABLE `tbl_category_product`
  ADD PRIMARY KEY (`category_product_id`);

--
-- Chỉ mục cho bảng `tbl_comment`
--
ALTER TABLE `tbl_comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Chỉ mục cho bảng `tbl_gallery`
--
ALTER TABLE `tbl_gallery`
  ADD PRIMARY KEY (`gallery_id`);

--
-- Chỉ mục cho bảng `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Chỉ mục cho bảng `tbl_order_detail`
--
ALTER TABLE `tbl_order_detail`
  ADD PRIMARY KEY (`order_detail_id`);

--
-- Chỉ mục cho bảng `tbl_post`
--
ALTER TABLE `tbl_post`
  ADD PRIMARY KEY (`post_id`);

--
-- Chỉ mục cho bảng `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`product_id`);

--
-- Chỉ mục cho bảng `tbl_social`
--
ALTER TABLE `tbl_social`
  ADD PRIMARY KEY (`social_id`);

--
-- Chỉ mục cho bảng `tbl_statistical`
--
ALTER TABLE `tbl_statistical`
  ADD PRIMARY KEY (`statistical_id`);

--
-- Chỉ mục cho bảng `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Chỉ mục cho bảng `tbl_voucher`
--
ALTER TABLE `tbl_voucher`
  ADD PRIMARY KEY (`voucher_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `admin_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `tbl_banner`
--
ALTER TABLE `tbl_banner`
  MODIFY `banner_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `tbl_brand`
--
ALTER TABLE `tbl_brand`
  MODIFY `brand_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `tbl_cart`
--
ALTER TABLE `tbl_cart`
  MODIFY `cart_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `tbl_category_post`
--
ALTER TABLE `tbl_category_post`
  MODIFY `category_post_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tbl_category_product`
--
ALTER TABLE `tbl_category_product`
  MODIFY `category_product_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `tbl_comment`
--
ALTER TABLE `tbl_comment`
  MODIFY `comment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `tbl_gallery`
--
ALTER TABLE `tbl_gallery`
  MODIFY `gallery_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `order_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `tbl_order_detail`
--
ALTER TABLE `tbl_order_detail`
  MODIFY `order_detail_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `tbl_post`
--
ALTER TABLE `tbl_post`
  MODIFY `post_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `product_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `tbl_social`
--
ALTER TABLE `tbl_social`
  MODIFY `social_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tbl_statistical`
--
ALTER TABLE `tbl_statistical`
  MODIFY `statistical_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `tbl_voucher`
--
ALTER TABLE `tbl_voucher`
  MODIFY `voucher_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
