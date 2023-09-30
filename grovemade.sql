-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 01 2022 г., 00:18
-- Версия сервера: 5.7.33-log
-- Версия PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `grovemade`
--
CREATE DATABASE IF NOT EXISTS `grovemade` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `grovemade`;

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `quantity` int(11) DEFAULT '1',
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `cart`
--

INSERT INTO `cart` (`id`, `productID`, `quantity`, `userID`) VALUES
(1, 43, 1, 8),
(2, 46, 1, 8);

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `categoryID` int(11) NOT NULL,
  `categoryName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`categoryID`, `categoryName`) VALUES
(1, 'Mouse/Desk Pads'),
(2, 'Stands'),
(3, 'Tools'),
(4, 'Keyboard'),
(5, 'Wall Mounted');

-- --------------------------------------------------------

--
-- Структура таблицы `order`
--

CREATE TABLE `order` (
  `orderID` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apartment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postalCode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shippingMethod` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `productID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Placed' COMMENT 'Stages:\r\n● Placed\r\n● Processed\r\n● Packing\r\n● Shipping\r\n● Awaiting\r\n● Complete\r\n● Canceled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `order`
--

INSERT INTO `order` (`orderID`, `email`, `country`, `firstname`, `lastname`, `company`, `address`, `apartment`, `city`, `postalCode`, `phone`, `shippingMethod`, `quantity`, `price`, `datetime`, `productID`, `userID`, `status`) VALUES
(1, 'bilyoleksandr@gmail.com', 'Ukraine', 'Oleksandr', 'Bily', '', 'Ivana Mazepu, 98', '', 'Zhytomyr', '10000', '+380687088962', 'UPS International', 3, 85.5, '2023-09-28 21:26:29', 42, 5, 'Awaiting'),
(2, 'bilyoleksandr@gmail.com', 'Ukraine', 'Oleksandr', 'Bily', '', 'Ivana Mazepu, 98', '', 'Zhytomyr', '10000', '+380687088962', 'UPS International', 1, 52.25, '2023-09-28 21:26:29', 44, 5, 'Complete'),
(3, 'johndoemail@exmpl.com', 'United States of America', 'John', 'Doe', '', '14 174th St, Queens', '', 'New York', 'NY 11366', '+11234567890', 'Small parcel', 1, 55, '2023-09-28 22:55:26', 44, 3, 'Shipping'),
(4, 'johndoemail@exmpl.com', 'United States of America', 'John', 'Doe', '', '14 174th St, Queens', '', 'New York', 'NY 11366', '+11234567890', 'Small parcel', 2, 580, '2023-09-29 22:58:10', 35, 3, 'Packing'),
(5, 'honghong_gild@exmpl.com', 'United States of America', 'Hong', 'Gildong', '', '31 188th St, Queens', '', 'New York', 'NY 11367', '+1123456344', 'UPS International', 2, 256, '2023-09-29 23:07:47', 41, 3, 'Processed'),
(6, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'Small parcel', 1, 420, '2023-09-29 23:19:57', 48, 5, 'Placed'),
(7, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'UPS International', 1, 200, '2023-09-30 23:28:07', 47, 5, 'Canceled'),
(8, 'johndoemail@exmpl.com', 'United States of America', 'John', 'Doe', '', '14 174th St, Queens', '', 'New York', 'NY 11366', '+11234567890', 'Small parcel', 1, 55, '2023-09-30 22:55:26', 44, 8, 'Complete'),
(9, 'johndoemail@exmpl.com', 'United States of America', 'John', 'Doe', '', '14 174th St, Queens', '', 'New York', 'NY 11366', '+11234567890', 'Small parcel', 2, 580, '2023-09-30 22:58:10', 35, 8, 'Complete'),
(10, 'honghong_gild@exmpl.com', 'United States of America', 'Hong', 'Gildong', '', '31 188th St, Queens', '', 'New York', 'NY 11367', '+1123456344', 'UPS International', 2, 256, '2023-09-01 23:07:47', 41, 8, 'Complete'),
(11, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'Small parcel', 1, 420, '2023-09-01 23:19:57', 48, 8, 'Complete'),
(12, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'UPS International', 1, 200, '2023-09-01 23:28:07', 47, 8, 'Complete'),
(13, 'bilyoleksandr@gmail.com', 'Ukraine', 'Oleksandr', 'Bily', '', 'Ivana Mazepu, 98', '', 'Zhytomyr', '10000', '+380687088962', 'UPS International', 3, 85.5, '2023-09-02 21:26:29', 42, 5, 'Awaiting'),
(14, 'bilyoleksandr@gmail.com', 'Ukraine', 'Oleksandr', 'Bily', '', 'Ivana Mazepu, 98', '', 'Zhytomyr', '10000', '+380687088962', 'UPS International', 1, 52.25, '2023-09-02 21:26:29', 44, 5, 'Complete'),
(15, 'johndoemail@exmpl.com', 'United States of America', 'John', 'Doe', '', '14 174th St, Queens', '', 'New York', 'NY 11366', '+11234567890', 'Small parcel', 1, 55, '2023-09-02 22:55:26', 44, 3, 'Shipping'),
(16, 'johndoemail@exmpl.com', 'United States of America', 'John', 'Doe', '', '14 174th St, Queens', '', 'New York', 'NY 11366', '+11234567890', 'Small parcel', 2, 580, '2023-09-03 22:58:10', 35, 3, 'Packing'),
(17, 'honghong_gild@exmpl.com', 'United States of America', 'Hong', 'Gildong', '', '31 188th St, Queens', '', 'New York', 'NY 11367', '+1123456344', 'UPS International', 2, 256, '2023-09-03 23:07:47', 41, 3, 'Processed'),
(18, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'Small parcel', 1, 420, '2023-09-03 23:19:57', 48, 5, 'Placed'),
(19, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'UPS International', 1, 200, '2023-09-04 23:28:07', 47, 5, 'Canceled'),
(20, 'johndoemail@exmpl.com', 'United States of America', 'John', 'Doe', '', '14 174th St, Queens', '', 'New York', 'NY 11366', '+11234567890', 'Small parcel', 1, 55, '2023-09-04 22:55:26', 44, 8, 'Complete'),
(21, 'johndoemail@exmpl.com', 'United States of America', 'John', 'Doe', '', '14 174th St, Queens', '', 'New York', 'NY 11366', '+11234567890', 'Small parcel', 2, 580, '2023-09-04 22:58:10', 35, 8, 'Complete'),
(22, 'honghong_gild@exmpl.com', 'United States of America', 'Hong', 'Gildong', '', '31 188th St, Queens', '', 'New York', 'NY 11367', '+1123456344', 'UPS International', 2, 256, '2023-09-05 23:07:47', 41, 8, 'Complete'),
(23, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'Small parcel', 1, 420, '2023-09-05 23:19:57', 48, 8, 'Complete'),
(24, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'UPS International', 1, 200, '2023-09-05 23:28:07', 47, 8, 'Complete'),
(25, 'bilyoleksandr@gmail.com', 'Ukraine', 'Oleksandr', 'Bily', '', 'Ivana Mazepu, 98', '', 'Zhytomyr', '10000', '+380687088962', 'UPS International', 3, 85.5, '2023-09-06 21:26:29', 42, 5, 'Awaiting'),
(26, 'bilyoleksandr@gmail.com', 'Ukraine', 'Oleksandr', 'Bily', '', 'Ivana Mazepu, 98', '', 'Zhytomyr', '10000', '+380687088962', 'UPS International', 1, 52.25, '2023-09-06 21:26:29', 44, 5, 'Complete'),
(27, 'johndoemail@exmpl.com', 'United States of America', 'John', 'Doe', '', '14 174th St, Queens', '', 'New York', 'NY 11366', '+11234567890', 'Small parcel', 1, 55, '2023-09-06 22:55:26', 44, 3, 'Shipping'),
(28, 'johndoemail@exmpl.com', 'United States of America', 'John', 'Doe', '', '14 174th St, Queens', '', 'New York', 'NY 11366', '+11234567890', 'Small parcel', 2, 580, '2023-09-07 22:58:10', 35, 3, 'Packing'),
(29, 'honghong_gild@exmpl.com', 'United States of America', 'Hong', 'Gildong', '', '31 188th St, Queens', '', 'New York', 'NY 11367', '+1123456344', 'UPS International', 2, 256, '2023-09-07 23:07:47', 41, 3, 'Processed'),
(30, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'Small parcel', 1, 420, '2023-09-08 23:19:57', 48, 5, 'Placed'),
(31, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'UPS International', 1, 200, '2023-09-08 23:28:07', 47, 5, 'Canceled'),
(32, 'johndoemail@exmpl.com', 'United States of America', 'John', 'Doe', '', '14 174th St, Queens', '', 'New York', 'NY 11366', '+11234567890', 'Small parcel', 1, 55, '2023-09-08 22:55:26', 44, 8, 'Complete'),
(33, 'johndoemail@exmpl.com', 'United States of America', 'John', 'Doe', '', '14 174th St, Queens', '', 'New York', 'NY 11366', '+11234567890', 'Small parcel', 2, 580, '2023-09-09 22:58:10', 35, 8, 'Complete'),
(34, 'honghong_gild@exmpl.com', 'United States of America', 'Hong', 'Gildong', '', '31 188th St, Queens', '', 'New York', 'NY 11367', '+1123456344', 'UPS International', 2, 256, '2023-09-09 23:07:47', 41, 8, 'Complete'),
(35, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'Small parcel', 1, 420, '2023-09-09 23:19:57', 48, 8, 'Complete'),
(36, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'UPS International', 1, 200, '2023-09-10 23:28:07', 47, 8, 'Complete'),
(37, 'bilyoleksandr@gmail.com', 'Ukraine', 'Oleksandr', 'Bily', '', 'Ivana Mazepu, 98', '', 'Zhytomyr', '10000', '+380687088962', 'UPS International', 3, 85.5, '2023-09-10 21:26:29', 42, 5, 'Awaiting'),
(38, 'bilyoleksandr@gmail.com', 'Ukraine', 'Oleksandr', 'Bily', '', 'Ivana Mazepu, 98', '', 'Zhytomyr', '10000', '+380687088962', 'UPS International', 1, 52.25, '2023-09-10 21:26:29', 44, 5, 'Complete'),
(39, 'johndoemail@exmpl.com', 'United States of America', 'John', 'Doe', '', '14 174th St, Queens', '', 'New York', 'NY 11366', '+11234567890', 'Small parcel', 1, 55, '2023-09-11 22:55:26', 44, 3, 'Shipping'),
(40, 'johndoemail@exmpl.com', 'United States of America', 'John', 'Doe', '', '14 174th St, Queens', '', 'New York', 'NY 11366', '+11234567890', 'Small parcel', 2, 580, '2023-09-11 22:58:10', 35, 3, 'Packing'),
(41, 'honghong_gild@exmpl.com', 'United States of America', 'Hong', 'Gildong', '', '31 188th St, Queens', '', 'New York', 'NY 11367', '+1123456344', 'UPS International', 2, 256, '2023-09-11 23:07:47', 41, 3, 'Processed'),
(42, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'Small parcel', 1, 420, '2023-09-12 23:19:57', 48, 5, 'Complete'),
(43, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'UPS International', 1, 200, '2023-09-12 23:28:07', 47, 5, 'Canceled'),
(44, 'johndoemail@exmpl.com', 'United States of America', 'John', 'Doe', '', '14 174th St, Queens', '', 'New York', 'NY 11366', '+11234567890', 'Small parcel', 1, 55, '2023-09-12 22:55:26', 44, 8, 'Complete'),
(45, 'johndoemail@exmpl.com', 'United States of America', 'John', 'Doe', '', '14 174th St, Queens', '', 'New York', 'NY 11366', '+11234567890', 'Small parcel', 2, 580, '2023-09-13 22:59:10', 35, 8, 'Complete'),
(46, 'honghong_gild@exmpl.com', 'United States of America', 'Hong', 'Gildong', '', '31 188th St, Queens', '', 'New York', 'NY 11367', '+1123456344', 'UPS International', 2, 256, '2023-09-13 23:07:47', 41, 8, 'Complete'),
(47, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'Small parcel', 1, 420, '2023-09-13 23:19:57', 48, 8, 'Complete'),
(48, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'UPS International', 1, 200, '2023-09-14 23:28:07', 47, 8, 'Complete'),
(49, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'UPS International', 1, 200, '2023-09-14 23:28:07', 47, 8, 'Complete'),
(50, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'UPS International', 1, 200, '2023-09-14 23:28:07', 47, 8, 'Complete'),
(51, 'bilyoleksandr@gmail.com', 'Ukraine', 'Oleksandr', 'Bily', '', 'Ivana Mazepu, 98', '', 'Zhytomyr', '10000', '+380687088962', 'UPS International', 3, 85.5, '2023-09-15 21:26:29', 42, 5, 'Awaiting'),
(52, 'bilyoleksandr@gmail.com', 'Ukraine', 'Oleksandr', 'Bily', '', 'Ivana Mazepu, 98', '', 'Zhytomyr', '10000', '+380687088962', 'UPS International', 1, 52.25, '2023-09-15 21:26:29', 44, 5, 'Complete'),
(53, 'johndoemail@exmpl.com', 'United States of America', 'John', 'Doe', '', '14 174th St, Queens', '', 'New York', 'NY 11366', '+11234567890', 'Small parcel', 1, 55, '2023-09-15 22:55:26', 44, 3, 'Shipping'),
(54, 'johndoemail@exmpl.com', 'United States of America', 'John', 'Doe', '', '14 174th St, Queens', '', 'New York', 'NY 11366', '+11234567890', 'Small parcel', 2, 580, '2023-09-16 22:58:10', 35, 3, 'Packing'),
(55, 'honghong_gild@exmpl.com', 'United States of America', 'Hong', 'Gildong', '', '31 188th St, Queens', '', 'New York', 'NY 11367', '+1123456344', 'UPS International', 2, 256, '2023-09-16 23:07:47', 41, 3, 'Processed'),
(56, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'Small parcel', 1, 420, '2023-09-16 23:19:57', 48, 5, 'Placed'),
(57, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'UPS International', 1, 200, '2023-09-17 23:28:07', 47, 5, 'Canceled'),
(58, 'johndoemail@exmpl.com', 'United States of America', 'John', 'Doe', '', '14 174th St, Queens', '', 'New York', 'NY 11366', '+11234567890', 'Small parcel', 1, 55, '2023-09-17 22:55:26', 44, 8, 'Complete'),
(59, 'johndoemail@exmpl.com', 'United States of America', 'John', 'Doe', '', '14 174th St, Queens', '', 'New York', 'NY 11366', '+11234567890', 'Small parcel', 2, 580, '2023-09-17 22:58:10', 35, 8, 'Complete'),
(60, 'honghong_gild@exmpl.com', 'United States of America', 'Hong', 'Gildong', '', '31 188th St, Queens', '', 'New York', 'NY 11367', '+1123456344', 'UPS International', 2, 256, '2023-09-18 23:07:47', 41, 8, 'Complete'),
(61, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'Small parcel', 1, 420, '2023-09-18 23:19:57', 48, 8, 'Complete'),
(62, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'UPS International', 1, 200, '2023-09-18 23:28:07', 47, 8, 'Complete'),
(63, 'bilyoleksandr@gmail.com', 'Ukraine', 'Oleksandr', 'Bily', '', 'Ivana Mazepu, 98', '', 'Zhytomyr', '10000', '+380687088962', 'UPS International', 3, 85.5, '2023-09-19 21:26:29', 42, 5, 'Awaiting'),
(64, 'bilyoleksandr@gmail.com', 'Ukraine', 'Oleksandr', 'Bily', '', 'Ivana Mazepu, 98', '', 'Zhytomyr', '10000', '+380687088962', 'UPS International', 1, 52.25, '2023-09-19 21:26:29', 44, 5, 'Complete'),
(65, 'johndoemail@exmpl.com', 'United States of America', 'John', 'Doe', '', '14 174th St, Queens', '', 'New York', 'NY 11366', '+11234567890', 'Small parcel', 1, 55, '2023-09-19 22:55:26', 44, 3, 'Shipping'),
(66, 'johndoemail@exmpl.com', 'United States of America', 'John', 'Doe', '', '14 174th St, Queens', '', 'New York', 'NY 11366', '+11234567890', 'Small parcel', 2, 580, '2023-09-20 22:58:10', 35, 3, 'Packing'),
(67, 'honghong_gild@exmpl.com', 'United States of America', 'Hong', 'Gildong', '', '31 188th St, Queens', '', 'New York', 'NY 11367', '+1123456344', 'UPS International', 2, 256, '2023-09-20 23:07:47', 41, 3, 'Processed'),
(68, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'Small parcel', 1, 420, '2023-09-20 23:19:57', 48, 5, 'Placed'),
(69, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'UPS International', 1, 200, '2023-09-21 23:28:07', 47, 5, 'Canceled'),
(70, 'johndoemail@exmpl.com', 'United States of America', 'John', 'Doe', '', '14 174th St, Queens', '', 'New York', 'NY 11366', '+11234567890', 'Small parcel', 1, 55, '2023-09-21 22:55:26', 44, 8, 'Complete'),
(71, 'johndoemail@exmpl.com', 'United States of America', 'John', 'Doe', '', '14 174th St, Queens', '', 'New York', 'NY 11366', '+11234567890', 'Small parcel', 2, 580, '2023-09-21 22:58:10', 35, 8, 'Complete'),
(72, 'honghong_gild@exmpl.com', 'United States of America', 'Hong', 'Gildong', '', '31 188th St, Queens', '', 'New York', 'NY 11367', '+1123456344', 'UPS International', 2, 256, '2023-09-22 23:07:47', 41, 8, 'Complete'),
(73, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'Small parcel', 1, 420, '2023-09-22 23:19:57', 48, 8, 'Complete'),
(74, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'UPS International', 1, 200, '2023-09-22 23:28:07', 47, 8, 'Complete'),
(75, 'bilyoleksandr@gmail.com', 'Ukraine', 'Oleksandr', 'Bily', '', 'Ivana Mazepu, 98', '', 'Zhytomyr', '10000', '+380687088962', 'UPS International', 3, 85.5, '2023-09-23 21:26:29', 42, 5, 'Awaiting'),
(76, 'bilyoleksandr@gmail.com', 'Ukraine', 'Oleksandr', 'Bily', '', 'Ivana Mazepu, 98', '', 'Zhytomyr', '10000', '+380687088962', 'UPS International', 1, 52.25, '2023-09-23 21:26:29', 44, 5, 'Complete'),
(77, 'johndoemail@exmpl.com', 'United States of America', 'John', 'Doe', '', '14 174th St, Queens', '', 'New York', 'NY 11366', '+11234567890', 'Small parcel', 1, 55, '2023-09-23 22:55:26', 44, 3, 'Shipping'),
(78, 'johndoemail@exmpl.com', 'United States of America', 'John', 'Doe', '', '14 174th St, Queens', '', 'New York', 'NY 11366', '+11234567890', 'Small parcel', 2, 580, '2023-09-24 22:58:10', 35, 3, 'Packing'),
(79, 'honghong_gild@exmpl.com', 'United States of America', 'Hong', 'Gildong', '', '31 188th St, Queens', '', 'New York', 'NY 11367', '+1123456344', 'UPS International', 2, 256, '2023-09-24 23:07:47', 41, 3, 'Processed'),
(80, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'Small parcel', 1, 420, '2023-09-24 23:19:57', 48, 5, 'Packing'),
(81, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'UPS International', 1, 200, '2023-09-25 23:28:07', 47, 5, 'Canceled'),
(82, 'johndoemail@exmpl.com', 'United States of America', 'John', 'Doe', '', '14 174th St, Queens', '', 'New York', 'NY 11366', '+11234567890', 'Small parcel', 1, 55, '2023-09-25 22:55:26', 44, 8, 'Complete'),
(83, 'johndoemail@exmpl.com', 'United States of America', 'John', 'Doe', '', '14 174th St, Queens', '', 'New York', 'NY 11366', '+11234567890', 'Small parcel', 2, 580, '2023-09-25 22:58:10', 35, 8, 'Complete'),
(84, 'honghong_gild@exmpl.com', 'United States of America', 'Hong', 'Gildong', '', '31 188th St, Queens', '', 'New York', 'NY 11367', '+1123456344', 'UPS International', 2, 256, '2023-09-26 23:07:47', 41, 8, 'Complete'),
(85, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'Small parcel', 1, 420, '2023-09-26 23:19:57', 48, 8, 'Complete'),
(86, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'UPS International', 1, 200, '2023-09-26 23:28:07', 47, 8, 'Complete'),
(87, 'bilyoleksandr@gmail.com', 'Ukraine', 'Oleksandr', 'Bily', '', 'Ivana Mazepu, 98', '', 'Zhytomyr', '10000', '+380687088962', 'UPS International', 3, 85.5, '2023-09-27 21:26:29', 42, 5, 'Awaiting'),
(88, 'bilyoleksandr@gmail.com', 'Ukraine', 'Oleksandr', 'Bily', '', 'Ivana Mazepu, 98', '', 'Zhytomyr', '10000', '+380687088962', 'UPS International', 1, 52.25, '2023-09-27 21:26:29', 44, 5, 'Complete'),
(89, 'johndoemail@exmpl.com', 'United States of America', 'John', 'Doe', '', '14 174th St, Queens', '', 'New York', 'NY 11366', '+11234567890', 'Small parcel', 1, 55, '2023-09-27 22:55:26', 44, 3, 'Shipping'),
(90, 'johndoemail@exmpl.com', 'United States of America', 'John', 'Doe', '', '14 174th St, Queens', '', 'New York', 'NY 11366', '+11234567890', 'Small parcel', 2, 580, '2023-09-28 22:58:10', 35, 3, 'Packing'),
(91, 'honghong_gild@exmpl.com', 'United States of America', 'Hong', 'Gildong', '', '31 188th St, Queens', '', 'New York', 'NY 11367', '+1123456344', 'UPS International', 2, 256, '2023-09-28 23:07:47', 41, 3, 'Processed'),
(92, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'Small parcel', 1, 420, '2023-09-28 23:19:57', 48, 5, 'Placed'),
(93, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'UPS International', 1, 200, '2023-09-28 23:28:07', 47, 5, 'Canceled'),
(94, 'johndoemail@exmpl.com', 'United States of America', 'John', 'Doe', '', '14 174th St, Queens', '', 'New York', 'NY 11366', '+11234567890', 'Small parcel', 1, 55, '2023-09-28 22:55:26', 44, 8, 'Complete'),
(95, 'johndoemail@exmpl.com', 'United States of America', 'John', 'Doe', '', '14 174th St, Queens', '', 'New York', 'NY 11366', '+11234567890', 'Small parcel', 2, 580, '2023-09-29 22:59:10', 35, 8, 'Complete'),
(96, 'honghong_gild@exmpl.com', 'United States of America', 'Hong', 'Gildong', '', '31 188th St, Queens', '', 'New York', 'NY 11367', '+1123456344', 'UPS International', 2, 256, '2023-09-29 23:07:47', 41, 8, 'Complete'),
(97, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'Small parcel', 1, 420, '2023-09-29 23:19:57', 48, 8, 'Complete'),
(98, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'UPS International', 1, 200, '2023-09-30 23:28:07', 47, 8, 'Complete'),
(99, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'UPS International', 1, 200, '2023-09-30 23:28:07', 47, 8, 'Complete'),
(100, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'UPS International', 1, 200, '2023-09-30 23:28:07', 47, 8, 'Complete'),
(101, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'UPS International', 2, 190, '2023-09-31 08:09:25', 40, 3, 'Placed'),
(102, 'winslow12211@gmail.com', 'United States of America', 'Adam', 'Winslow', '', ' 9701 Pearl St, Thornton', '101', 'Denver', 'CO 80229', '+17001223132121', 'UPS International', 2, 209, '2023-09-31 08:09:25', 39, 3, 'Placed');

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE `product` (
  `productID` int(11) NOT NULL,
  `productName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `productMaterial` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `productShortName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descriptionTitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descriptionText` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` float DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `sales` int(11) DEFAULT '0',
  `categoryID` int(11) NOT NULL,
  `subcategoryName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added` datetime NOT NULL,
  `sellerID` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dimensions` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `origin` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `material` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`productID`, `productName`, `productMaterial`, `productShortName`, `descriptionTitle`, `descriptionText`, `price`, `quantity`, `sales`, `categoryID`, `subcategoryName`, `added`, `sellerID`, `image`, `dimensions`, `origin`, `material`) VALUES
(1, '<i>Desk</i> Shelf', 'Walnut Plywood', 'Walnut Desk Shelf (Medium)', 'Elevated and Organized', '<p>The Grovemade Desk Shelf provides an ergonomic lift and multiple sizes to fit all your devices and screens. It’s designed to last a lifetime and is suited to the modern work configuration. We craft it from 15-ply premium hardwood plywood, aluminum, and natural cork hand stained with Japanese calligraphy ink.&nbsp;</p><p><br data-cke-filler=\"true\"></p><p><i><strong>Supports monitors up to 50 lbs.</strong></i></p>', 200, 790, 0, 2, 'Desc Shelves', '2022-06-30 17:15:02', 2, '32_62e53ce65dced', 'Small - 18.5\" Wide x 9\" Deep x 4.5\" Tall<br>Medium - 31.5\" Wide x 9\" Deep x 4.5\" Tall<br>Large - 46\" Wide x 9\" Deep x 4.5\" Tall<br>Monitors in photo are 25” screens (diagonal). Works with almost all monitors, including 27” Apple displays.', 'Designed by Grovemade in Portland, OR<br>Manufactured with vendor partners in Portland, OR and Milwaukee, WI', 'Natural Cork / Ebonized Cork with Sumi ink<br>American Walnut / Eastern Hardrock Maple Plywood (15-ply)<br>American Solid Walnut / Eastern Hardrock Maple<br>Matte Black / Matte White Powder Coated Medium Density Fiberboard<br>5052 Aluminum'),
(33, '<i>Desk</i> Shelf', 'Matte Black', 'Matte Black Desk Shelf (Medium)', 'Elevated and Organized', '<p>The Grovemade Desk Shelf provides an ergonomic lift and multiple sizes to fit all your devices and screens. It’s designed to last a lifetime and is suited to the modern work configuration, with a clean, minimalist look and matte finish. We craft it from powdercoated engineered wood, aluminum, and natural cork hand stained with Japanese calligraphy ink.<br><br data-cke-filler=\"true\"></p><p>⁠⁠⁠⁠⁠⁠⁠<br><i><strong>Supports monitors up to 50 lbs.</strong></i></p>', 220, 720, 0, 2, 'Desc Shelves', '2022-06-30 17:34:54', 2, '33_62e5418ed2db0', 'Small - 18.5\" Wide x 9\" Deep x 4.5\" Tall<br>Medium - 31.5\" Wide x 9\" Deep x 4.5\" Tall<br>Large - 46\" Wide x 9\" Deep x 4.5\" Tall<br>Monitors in photo are 25” screens (diagonal). Works with almost all monitors, including 27” Apple displays.', 'Designed by Grovemade in Portland, OR<br>Manufactured with vendor partners in Portland, OR and Milwaukee, WI', 'Natural Cork / Ebonized Cork with Sumi ink<br>American Walnut / Eastern Hardrock Maple Plywood (15-ply)<br>American Solid Walnut / Eastern Hardrock Maple<br>Matte Black / Matte White Powder Coated Medium Density Fiberboard<br>5052 Aluminum'),
(34, '<i>Desk</i> Shelf', 'Walnut Plywood', 'Walnut Desk Shelf (Large)', 'Elevated and Organized', '<p>The Grovemade Desk Shelf provides an ergonomic lift and multiple sizes to fit all your devices and screens. It’s designed to last a lifetime and is suited to the modern work configuration. We craft it from 15-ply premium hardwood plywood, aluminum, and natural cork hand stained with Japanese calligraphy ink.<br><br data-cke-filler=\"true\"></p><p>⁠⁠⁠⁠⁠⁠⁠<br><i><strong>Supports monitors up to 50 lbs</strong></i></p>', 260, 500, 0, 2, 'Desc Shelves', '2022-06-30 17:40:13', 2, '34_62e542cd66623', 'Small - 18.5\" Wide x 9\" Deep x 4.5\" Tall<br>Medium - 31.5\" Wide x 9\" Deep x 4.5\" Tall<br>Large - 46\" Wide x 9\" Deep x 4.5\" Tall<br>Monitors in photo are 25” screens (diagonal). Works with almost all monitors, including 27” Apple displays.', 'Designed by Grovemade in Portland, OR<br>Manufactured with vendor partners in Portland, OR and Milwaukee, WI', 'Natural Cork / Ebonized Cork with Sumi ink<br>American Walnut / Eastern Hardrock Maple Plywood (15-ply)<br>American Solid Walnut / Eastern Hardrock Maple<br>Matte Black / Matte White Powder Coated Medium Density Fiberboard<br>5052 Aluminum'),
(35, '<i>Desk</i> Shelf', 'Matte Black', 'Matte Black Desk Shelf (Large)', 'Elevated and Organized', '<p>The Grovemade Desk Shelf provides an ergonomic lift and multiple sizes to fit all your devices and screens. It’s designed to last a lifetime and is suited to the modern work configuration, with a clean, minimalist look and matte finish. We craft it from powdercoated engineered wood, aluminum, and natural cork hand stained with Japanese calligraphy ink.<br><br data-cke-filler=\"true\"></p><p>⁠⁠⁠⁠⁠⁠⁠<br><i><strong>Supports monitors up to 50 lbs.</strong></i></p>', 290, 498, 34, 2, 'Desc Shelves', '2022-06-30 17:42:24', 2, '35_62e543504abaf', 'Large - 46\" Wide x 9\" Deep x 4.5\" Tall<br>Monitors in photo are 25” screens (diagonal). Works with almost all monitors, including 27” Apple displays.', 'Designed by Grovemade in Portland, OR<br>Manufactured with vendor partners in Portland, OR and Milwaukee, WI', 'Natural Cork / Ebonized Cork with Sumi ink<br>American Walnut / Eastern Hardrock Maple Plywood (15-ply)<br>American Solid Walnut / Eastern Hardrock Maple<br>Matte Black / Matte White Powder Coated Medium Density Fiberboard<br>5052 Aluminum'),
(36, '<i>Wood</i> MacBook Dock', 'Walnut', 'Walnut MacBook Dock', 'Get Vertical', '<p>Designed to save you space on your desk, the Grovemade MacBook Dock is an elegant vertical laptop stand that transforms your workspace. Premium hardwood and stainless steel provide beautiful heft for easy one handed operation. Your MacBook is cradled and protected by a lining of merino wool felt. Natural cork feet protect your desktop.&nbsp;<br><br data-cke-filler=\"true\"></p><p><i>Compatible with late 2016 and newer MacBook Pros (13\" / 14” / 15\" / 16\") and 13” MacBook Air.</i></p>', 130, 280, 0, 2, 'Laptop Stands', '2022-06-30 17:55:53', 6, '36_62e54679c4362', 'Weight: 2.2 lbs<br>Length: 8\"<br>Width: 3.6\"<br>Height: 3.75\"<br>Slot Width: 0.75\"', 'Design & manufacturing by Grovemade in Portland, OR', 'American Black Walnut / Eastern Hardrock Maple<br>Stainless Steel<br>Premium German Wool Felt<br>Natural Cork Foot'),
(37, '<i>Wood</i> Laptop Riser', 'Walnut', 'Walnut Laptop Riser', 'Most Elevated', '<p>Our laptop riser lifts your screen extra high for ideal ergonomics, combined with a small, stable footprint that fits into the tight spaces at your desk. Integrated cord management keeps things tidy and merino wool felt protects and cushions your device.</p>', 180, 200, 0, 2, 'Laptop Stands', '2022-06-30 17:58:25', 6, '37_62e54730bc9c1', 'Width: 10\"<br>Depth: 9.7\"<br>Height: 8.6\"<br>Footprint: 10\" x 6.9\"', 'Design & die cutting by Grovemade in Portland, OR<br>Manufactured with vendor partners in Portland, OR and Waynesboro, MS', 'American Black Walnut / Eastern Hardrock Maple Plywood (7-ply)<br>Premium German Merino Wool Felt<br>8 and 11 Gauge Brushed Aluminum'),
(38, '<i>Wood</i> Monitor Stand', 'Walnut', 'Walnut Monitor Stand', 'Elevate Your Work', '<p>The Grovemade Monitor Stand is a graceful ergonomic boost for your posture and your desktop, bringing your monitor to eye level while you work. Constructed from premium molded plywood, it supports up to 200 pounds, while its minimal footprint provides ample space below to stow your desktop accessories.</p>', 150, 0, 0, 2, 'Monitor Shelves', '2022-07-30 18:39:34', 6, '38_62e550b6e8014', 'Length: 21\"<br>Width: 9\"<br>Stand Surface: 14\" x 9.2\"<br>Height: 4.2\"<br>Thickness: 0.5\"<br>Weight: 2 lb 15.4 oz', 'Design & final machining by Grovemade in Portland, OR<br>Manufactured with vendor partners in Waynesboro, MS', 'American Black Walnut / Eastern Hardrock Maple Plywood (7-ply)<br>Natural Cork Feet'),
(39, '<i>Wood</i> Apple Keyboard Tray', 'Walnut', 'Walnut Apple Keyboard Tray', 'Precision Fit', '<p>The Grovemade Keyboard Tray is a distinguished landing spot for your Apple wireless keyboard. Carved from solid American hardwood, it adds a handsome accent to your workspace. Natural cork lines the base, protecting your desk and keeping your keyboard in place. Each tray is hand sanded and oiled for a rich, lustrous finish.<br><br><i>Keyboard not included.</i></p>', 110, 113, 2, 4, 'Apple Keyboard Tray', '2022-07-30 18:42:18', 6, '39_62e5515a6dab0', 'Design & manufacturing by Grovemade in Portland, OR', 'Apple Magic Keyboard<br>11.5\" L x 5.625\" W<br>Max Height: 0.75\" / Min Height: 0.35\"<br><br>Apple Magic Keyboard with Numeric Keypad<br>17.3\" L x 5.6\" W<br>Max Height: 0.69\" / Min Height: 0.25\"', 'American Black Walnut / Eastern Hard Rock Maple<br>5052 Aluminum Reinforcement<br>Natural Cork Base'),
(40, '<i>Leather</i> <i>&amp; Wood </i>Keyboard Wrist Rest', 'Walnut', 'Leather & Wood Keyboard Wrist Rest', 'Modern Support', '<p>The Grovemade Keyboard Wrist Rest features a panel of supple vegetable-tanned leather seated on a bed of hand sanded hardwood. The wrist rest elevates and provides cushioning as you type. With use, the leather will soften and develop a rich patina.</p>', 100, 118, 2, 4, 'Wrist Rests', '2022-07-30 18:45:30', 6, '40_62e5521aa8ede', 'Apple Magic Keyboard: 11.8\"x 3” x 0.3”<br>Apple Magic Keyboard w/ Numeric Keypad: 17.3” x 3” x 0.3”<br>Apple Magic Trackpad: 7.125\" x 3\" x 0.3\"', 'Design & manufacturing by Grovemade in Portland, OR', 'American Black Walnut / Eastern Hard Rock Maple<br>Premium Vegetable Tanned Leather<br>Aluminum Reinforcement<br>Natural Cork Base'),
(41, '<i>Leather</i> Desk Pad', 'Black', 'Leather Desk Pad (Medium / Black)', 'Set Your Workspace Apart', '<p>The leather desk pad brings visual structure and organization to your workspace. The premium, vegetable-tanned leather is buttery soft to the touch and dynamic, with distinguished character that will age and develop as you use it.</p>', 160, 118, 34, 1, 'Desc Pads', '2022-07-30 18:49:33', 6, '41_62e5530d932cb', '3.5 mm thick<br>Medium - 11.5” x 38”', 'Design & manufacturing by Grovemade in Portland, OR', 'Wickett & Craig Premium Vegetable-Tanned American Leather<br>Natural cork'),
(42, '<i>Wool</i> Felt Coaster Set', 'Dark', 'Wool Felt Coaster Set', 'Use a Coaster!', '<p>Our set of four (4) coasters are made of 3mm thick virgin Merino Wool Felt. They’re ideal for hot and cold drinks, and the simple profile and soft material are designed to work within the context of your workspace or home</p>', 30, 205, 39, 1, 'Coasters', '2022-07-30 18:52:14', 6, '42_62e553ae1ecab', '4” x 4”<br>3mm thick', 'Designed by Grovemade in Portland, OR<br>Manufactured with vendor partners in Portland, OR, Lackawanna, NY, and Apodaca, Mexico', 'Premium German Merino Wool Felt'),
(43, '<i>Brass</i> Task Knife', '', 'Brass Task Knife', 'A Fresh Cut', '<p>The Grovemade Task Knife is designed specifically for light-duty uses at your desk—the edge geometry excels at opening boxes, while intentionally not being as sharp as a pocket knife. It’s machined from solid brass with a raw finish that preserves the machining marks—it’s more difficult than bead blasting or tumbling, but it makes a more unique product. It’s an heirloom quality tool that’s practically indestructible. Hefty and delicate at the same time, it feels excellent in hand.<br><br><i>Manufactured entirely in the Portland area to ensure the highest quality.</i></p>', 120, 400, 0, 3, 'Knives', '2022-07-30 18:58:11', 7, '43_62e555138b69d', 'Knife:<br>4.75\" x 0.65\" x 0.25\"<br>2.7 oz<br>Blade Length: 1.44\"', 'Design, custom packaging & polishing by Grovemade in Portland, OR<br>Manufactured with vendor partner in Vancouver, WA', '360 Brass'),
(44, '<i>Matte</i> Notebook', 'Navy', 'Matte Notebook', 'Write It Down', '<p>The Grovemade refillable slim notebook is designed to fit into the tight spaces on your desk. Intentionally coordinated with our Desk Collection, it lines up with your keyboard tray and desk pad to make your integrated workspace work even better.</p><p>Use it in both the horizontal and vertical orientation to slot into spaces that other notebooks can’t. The natural matte cover is smooth and firm to the touch, with just the right amount of pliability. The durable cover and brass discs will age beautifully.</p>', 55, 444, 30, 3, 'Notebooks', '2022-07-30 19:00:28', 7, '44_62e5559c473f2', 'Medium: 5.75” x 7.7”<br>Large: 7.75” x 10”<br>Slim: 8.55” x 3.7”', 'Design & manufacturing by Grovemade in Portland, OR<br>Metal component machined by vendor partner in Vancouver, WA', 'Natural linoleum<br>70# paper<br>Solid C360 brass discs'),
(45, '<i>Wood</i> iPad Stand', 'Walnut', 'Walnut iPad Stand', 'Just Right', '<p>Our iPad stand is designed to hold your iPad at just the right angle for viewing and working. It\'s built with premium American hardwood and stainless steel, with merino wool felt to cushion and protect your device. Integrated cord management keeps your desk tidy.</p><p><br data-cke-filler=\"true\"></p><p><i><strong>Compatible with all iPads &amp; most tablets.</strong></i></p>', 130, 240, 0, 2, 'iPad Stands', '2022-07-30 19:02:37', 7, '45_62e5561d41553', 'Weight: 1.2 lbs<br>Width: 6.25\"<br>Depth: 4.45\"<br>Height: 4.5\"<br>iPad Angle: 20°', 'Designed & manufacturing by Grovemade in Portland, OR', 'American Black Walnut / Eastern Hardrock Maple<br>Stainless Steel<br>Premium German Wool Felt<br>Natural Cork Foot'),
(46, '<i>Wood</i> MagSafe Stand', 'Walnut', 'Walnut MagSafe Stand', 'Lifted Performance', '<p>Our stand is purpose-built to capitalize on the speed and convenience of MagSafe charging while also being a delight to use. A solid steel base securely anchors your device, and hand sanded hardwood and vegetable-tanned leather create a unique modern look.</p><p><br data-cke-filler=\"true\"></p><p><i><strong>Requires Apple MagSafe Charger (not included). Compatible with all iPhone 12 / 13 models.</strong></i></p>', 155, 250, 0, 2, 'iPhone Docks', '2022-07-30 19:05:34', 7, '46_62e556ce30b70', 'Steel Weight: 2.9 lbs<br>Brass Weight: 3.75 lbs<br>Height: 5.2\"<br>Depth: 4.1\"<br>Width: 4.1\"<br>Base thickness: 0.75\"', 'Design & manufacturing by Grovemade in Portland, OR<br>Metal components made by vendor partners in Portland, OR', 'Eastern Hard Rock Maple / American Black Walnut<br>Vegetable-tanned Leather<br>Arm: Stainless Steel / C360 Brass<br>Base: Cerakote Ceramic Coated Steel / Brass<br>Natural Cork Foot'),
(47, '<i>Wood</i> Catch-All', 'Walnut', 'Walnut Catch-All', 'Right Where You Left It', '<p>A distinctive home for your phone, wallet, and other everyday items, our wall mounted catch-all keeps your essentials in one easy-to-access place. Sculpted premium plywood adds depth and warmth, while the Merino wool felt lining protects your stuff from scratches. A trio of hidden brass hooks are perfect for keys.</p>', 200, 99, 21, 5, 'Catch-All', '2022-07-30 19:08:33', 2, '47_62e5578175702', 'Width: 19\"<br>Height: 3.5\"<br>Front edge to wall: 5\"', 'Design, die cutting & assembly by Grovemade in Portland, OR<br>Manufactured with vendor partners in Portland, OR and Waynesboro, MS', 'American Walnut / Maple Plywood (7-ply)<br>Premium German Wool Felt<br>5052 Aluminum<br>260 astm b-135 Brass Pegs<br>Cork'),
(48, '<i>Wood</i> Wall Shelf', 'Walnut', 'Walnut Wall Shelf Bundle', 'Showcase What Matters', '<p>Our wood shelf is designed to hold the things you hold dear. Available in two convenient bundles or individually, to fit a variety of spaces from home to office. We craft each from 15-ply premium walnut plywood, aluminum and natural cork hand stained with Japanese calligraphy ink.</p>', 420, 99, 17, 5, 'Wall Shelves', '2022-07-30 19:10:19', 2, '48_62e557eb22bb6', 'Width: 38\" / 54\"<br>Depth: 7 ½\"<br>Thickness: ¾\"<br>Bracket Height: 7 ¾\"<br>Usable distance between brackets: 31\" / 47\"', 'Design, cork processing & assembly by Grovemade in Portland, OR<br>Manufactured with vendor partners in Portland, OR', 'Natural Cork / Ebonized Natural Cork with Sumi Ink<br>Aluminum<br>American Walnut / Maple Plywood (15-ply)');

-- --------------------------------------------------------

--
-- Структура таблицы `subcategory`
--

CREATE TABLE `subcategory` (
  `subcategoryName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoryID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `subcategory`
--

INSERT INTO `subcategory` (`subcategoryName`, `categoryID`) VALUES
('Coasters', 1),
('Desc Pads', 1),
('Mouse Pads', 1),
('Desc Shelves', 2),
('Headphone Stands', 2),
('iPad Stands', 2),
('iPhone Docks', 2),
('Laptop Stands', 2),
('Monitor Shelves', 2),
('Knives', 3),
('Notebooks', 3),
('Pen Cups & Planters', 3),
('Pens', 3),
('Stationery', 3),
('Trays', 3),
('Apple Keyboard Tray', 4),
('Apple Trackpad Tray', 4),
('Wrist Rests', 4),
('Catch-All', 5),
('Wall Shelves', 5);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthdayDate` date DEFAULT NULL,
  `gender` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apartment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postalCode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `access` int(11) NOT NULL DEFAULT '1' COMMENT 'Access level (0-3)',
  `registrationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`UserID`, `email`, `password`, `firstname`, `lastname`, `birthdayDate`, `gender`, `address`, `apartment`, `city`, `postalCode`, `country`, `telephone`, `access`, `registrationDate`) VALUES
(1, 'admin_Alex@grovemade.com', '200ceb26807d6bf99fd6f4f0d1ca54d4', 'Alex', 'Reign', '2000-01-01', 'Male', '1851 Giben Rd SW', '', 'Atlanta', 'GA 30315', 'United States of America', '+1 700-143-5554', 3, '2022-07-30 00:52:58'),
(2, 'alexwhitepost@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'Alex', 'White', '1987-02-14', 'Male', NULL, NULL, NULL, NULL, NULL, '+380678234912', 2, '2022-07-30 00:53:52'),
(3, 'somevisitor@grove.com', '96e79218965eb72c92a549dd5a330112', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2022-07-30 00:54:56'),
(5, 'somevisitor2@grove.com', '25d55ad283aa400af464c76d713c07ad', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2022-07-30 14:54:15'),
(6, 'seller_exmpl@grove.com', '25d55ad283aa400af464c76d713c07ad', NULL, NULL, NULL, 'male', NULL, NULL, NULL, NULL, NULL, NULL, 2, '2022-07-30 17:49:01'),
(7, 'seller2_exmpl@grove.com', '25d55ad283aa400af464c76d713c07ad', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2022-07-30 18:53:29'),
(8, 'somevisitor3@grove.com', '25d55ad283aa400af464c76d713c07ad', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2022-07-31 15:45:54');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ProductId_cart_product_FK` (`productID`),
  ADD KEY `UserId_cart_users_FK` (`userID`);

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryID`);

--
-- Индексы таблицы `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `ProductId_orders_product_FK` (`productID`),
  ADD KEY `UserId_orders_users_FK` (`userID`);

--
-- Индексы таблицы `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productID`),
  ADD KEY `CategoryId_product_category_FK` (`categoryID`),
  ADD KEY `SellerId_product_users_FK` (`sellerID`),
  ADD KEY `SubcategoryName_product_subcategory_FK` (`subcategoryName`);

--
-- Индексы таблицы `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`subcategoryName`),
  ADD UNIQUE KEY `subcategoryName` (`subcategoryName`),
  ADD KEY `CategoryId_subcategory_category_FK` (`categoryID`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `categoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `order`
--
ALTER TABLE `order`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT для таблицы `product`
--
ALTER TABLE `product`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `ProductId_cart_product_FK` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`),
  ADD CONSTRAINT `UserId_cart_users_FK` FOREIGN KEY (`userID`) REFERENCES `user` (`UserID`);

--
-- Ограничения внешнего ключа таблицы `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `ProductId_orders_product_FK` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`),
  ADD CONSTRAINT `UserId_orders_users_FK` FOREIGN KEY (`userID`) REFERENCES `user` (`UserID`);

--
-- Ограничения внешнего ключа таблицы `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `CategoryId_product_category_FK` FOREIGN KEY (`categoryID`) REFERENCES `category` (`categoryID`),
  ADD CONSTRAINT `SellerId_product_users_FK` FOREIGN KEY (`sellerID`) REFERENCES `user` (`UserID`),
  ADD CONSTRAINT `SubcategoryName_product_subcategory_FK` FOREIGN KEY (`subcategoryName`) REFERENCES `subcategory` (`subcategoryName`);

--
-- Ограничения внешнего ключа таблицы `subcategory`
--
ALTER TABLE `subcategory`
  ADD CONSTRAINT `CategoryId_subcategory_category_FK` FOREIGN KEY (`categoryID`) REFERENCES `category` (`categoryID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
