-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2025-12-30 07:56:25
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `my_store`
--

-- --------------------------------------------------------

--
-- 資料表結構 `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `part_name` varchar(100) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `brand` varchar(50) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('有現貨','缺貨中','需預訂') DEFAULT '有現貨'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `products`
--

INSERT INTO `products` (`id`, `part_name`, `category`, `brand`, `price`, `stock`, `description`, `updated_at`, `status`) VALUES
(1, 'Core i7-13700K', 'CPU', 'Intel', 12500, 15, '16核心 24執行緒', '2025-12-30 06:47:57', '有現貨'),
(2, 'GeForce RTX 4070 Ti', '顯示卡', 'ASUS', 24990, 8, '12GB GDDR6X', '2025-12-30 06:47:57', '缺貨中'),
(3, 'Vengeance RGB DDR5', '記憶體', 'Corsair', 3200, 40, '32GB (16x2) 6000MHz', '2025-12-30 06:47:57', '有現貨'),
(4, 'Samsung 990 Pro 2TB', 'SSD', 'Samsung', 5600, 25, 'PCIe 4.0 NVMe M.2', '2025-12-30 06:47:57', '有現貨'),
(5, 'Crucial T705 1TB', 'SSD', 'Micron', 4200, 12, 'Gen5 NVMe 超高速固態硬碟', '2025-12-30 06:47:57', '有現貨'),
(6, 'NH-D15 chromax.black', '散熱器', 'Noctua', 3600, 10, '頂級雙塔風冷散熱器', '2025-12-30 06:47:57', '有現貨'),
(7, 'Kraken Elite 360', '散熱器', 'NZXT', 8900, 6, '360mm 一體式水冷帶 LCD 螢幕', '2025-12-30 06:47:57', '有現貨'),
(8, 'H9 Flow', '機殼', 'NZXT', 4990, 15, '全景鋼化玻璃中塔機殼', '2025-12-30 06:47:57', '有現貨'),
(9, 'Torrent White TG', '機殼', 'Fractal Design', 6500, 8, '極致風道設計大型機殼', '2025-12-30 06:47:57', '有現貨');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
