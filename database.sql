-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Час створення: Січ 13 2025 р., 00:12
-- Версія сервера: 8.0.19
-- Версія PHP: 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `woodmadecommerceproject`
--

-- --------------------------------------------------------

--
-- Структура таблиці `cart`
--

CREATE TABLE `cart` (
  `id` int NOT NULL,
  `productID` int NOT NULL,
  `quantity` int DEFAULT '1',
  `userID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `cart`
--

INSERT INTO `cart` (`id`, `productID`, `quantity`, `userID`) VALUES
(7, 49, 1, 10);

-- --------------------------------------------------------

--
-- Структура таблиці `category`
--

CREATE TABLE `category` (
  `categoryID` int NOT NULL,
  `categoryName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `category`
--

INSERT INTO `category` (`categoryID`, `categoryName`) VALUES
(0, 'Lifestyle'),
(1, 'Furniture'),
(2, 'Kitchenware'),
(3, 'Workspace'),
(4, 'Outdoor'),
(5, 'Gifts');

-- --------------------------------------------------------

--
-- Структура таблиці `orders`
--

CREATE TABLE `orders` (
  `orderID` int NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apartment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `postalCode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `shippingMethod` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `price` float DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `productID` int NOT NULL,
  `userID` int NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Placed' COMMENT 'Stages:\r\r\n  ● Placed\r\r\n  ● Processed\r\r\n  ● Packing\r\r\n  ● Shipping\r\r\n  ● Awaiting\r\r\n  ● Complete\r\r\n  ● Canceled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `orders`
--

INSERT INTO `orders` (`orderID`, `email`, `country`, `firstname`, `lastname`, `company`, `address`, `apartment`, `city`, `postalCode`, `phone`, `shippingMethod`, `quantity`, `price`, `datetime`, `productID`, `userID`, `status`) VALUES
(103, 'user@woodmade.commerce', 'United States of America', 'John', 'Doe', '', '123 Oak Street', 'Apt 5', 'New York', '10001', '+1 023-456-7890', 'Small parcel', 1, 28.5, '2024-12-29 19:58:54', 49, 12, 'Placed');

-- --------------------------------------------------------

--
-- Структура таблиці `product`
--

CREATE TABLE `product` (
  `productID` int NOT NULL,
  `productName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `productMaterial` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `productShortName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descriptionTitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descriptionText` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` float DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `sales` int DEFAULT '0',
  `categoryID` int NOT NULL,
  `subcategoryName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `added` datetime NOT NULL,
  `sellerID` int NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dimensions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `origin` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `material` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `product`
--

INSERT INTO `product` (`productID`, `productName`, `productMaterial`, `productShortName`, `descriptionTitle`, `descriptionText`, `price`, `quantity`, `sales`, `categoryID`, `subcategoryName`, `added`, `sellerID`, `image`, `dimensions`, `origin`, `material`) VALUES
(49, '<i>Premium </i>Handmade Wooden Cutting Board', 'Oak Wood', 'Cutting Board', 'A Chef’s Trusted Companion', '<p>This premium oak cutting board offers <i>durability </i>and <i>elegance</i>. Perfect for preparing meals or serving appetizers with <i>style</i>.</p><p><br data-cke-filler=\"true\"></p>', 30, 48, 1, 2, 'Cutting Boards', '2024-12-23 00:13:14', 10, '49_6769de71eaa18', '15 x 15 x 1 inches', 'USA', 'Solid Oak Wood'),
(50, '<i><strong>Wall-Mounted</strong></i> Wooden Shelves Set', 'Natural, light-colored wood', 'Wooden Wall Shelves', 'Stylish Wooden Wall Shelves', '<p>Elevate your interior with this versatile set of wall-mounted wooden shelves. Perfect for organizing books, plants, candles, or decorative items, these shelves combine functionality and modern design. Crafted from natural wood, they add warmth and charm to any room while maximizing space efficiency. Ideal for living rooms, bedrooms, or workspaces.</p>', 75, 30, 0, 3, 'Wall Shelves', '2025-01-12 22:50:40', 10, '50_67842b214ea78', '24 x 8 x 6 inches per shelf', 'Handcrafted locally', '100% natural wood'),
(51, 'Wooden Phone Stand &amp; Organizer', 'High-quality natural wood', 'Phone Stand Organizer', 'Elegant Wooden Phone Stand & Organizer', '<p>Simplify your daily routine with this stylish wooden phone stand and organizer. Perfect for keeping your phone, keys, and small accessories in one place, it’s a seamless blend of form and function. Crafted from smooth, polished wood, this compact yet versatile accessory adds a touch of natural charm to your desk, bedside table, or entryway.</p>', 20, 50, 0, 0, 'Accessories', '2025-01-12 23:00:12', 10, '51_67842d5d6f858', '6 x 4 x 2 inches', 'Handcrafted locally', '100% natural wood'),
(52, 'Modern Wooden Storage Box', 'High-quality natural oak wood', 'Wooden Storage Organizer', 'Elegance in Simplicity', '<p>Keep your home or office organized with this stylish wooden storage box. Crafted from premium oak, its minimalist design is perfect for storing small essentials such as stationery, jewelry, or remote controls. With smooth edges and a natural finish, it seamlessly blends functionality with aesthetic appeal.</p>', 50, 40, 0, 1, 'Storage', '2025-01-12 23:11:08', 10, '52_67842fec97824', ' 10 x 8 x 6 inches', 'Handcrafted locally', '100% Natural Oak Wood');

-- --------------------------------------------------------

--
-- Структура таблиці `subcategory`
--

CREATE TABLE `subcategory` (
  `subcategoryName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoryID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `subcategory`
--

INSERT INTO `subcategory` (`subcategoryName`, `categoryID`) VALUES
('Accessories', 0),
('Decor', 0),
('Organizers', 0),
('Seating', 1),
('Shelves', 1),
('Storage', 1),
('Tables', 1),
('Cutting Boards', 2),
('Serveware', 2),
('Wine & Bar', 2),
('Desk Accessories', 3),
('Stands', 3),
('Wall Shelves', 3),
('Birdhouses', 4),
('Furniture', 4),
('Planters', 4),
('Custom Engravings', 5),
('Gift Sets', 5),
('Seasonal Gifts', 5);

-- --------------------------------------------------------

--
-- Структура таблиці `user`
--

CREATE TABLE `user` (
  `UserID` int NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthdayDate` date DEFAULT NULL,
  `gender` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apartment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postalCode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `access` int NOT NULL DEFAULT '1' COMMENT 'Access level (1-3)',
  `registrationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `user`
--

INSERT INTO `user` (`UserID`, `email`, `password`, `firstname`, `lastname`, `birthdayDate`, `gender`, `address`, `apartment`, `city`, `postalCode`, `country`, `telephone`, `access`, `registrationDate`) VALUES
(9, 'admin@woodmade.commerce', '$2y$10$7j8x22m4EwrfoFnS99VNv.u04fmaGc2rQVfOEBS2ecslb7vWeA.9.', NULL, NULL, NULL, 'Male', NULL, NULL, NULL, NULL, 'Ukraine', '+1 123 456 7889', 3, '2024-12-19 20:50:34'),
(10, 'seller@woodmade.commerce', '$2y$10$/zs0cjNOTULH0ppFol6uyuqjT2xP1BSge0FvdCdmeBBvmBv/JDGjC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2024-12-21 17:08:15'),
(12, 'user@woodmade.commerce', '$2y$10$4EBT3OtIW5dqBWPVqClNPOdHxvPlQJp1XHJ8VpQ8YGWwj43rLeo1W', 'John', 'Doe', NULL, 'Male', '123 Oak Street', 'Apt 5', 'New York', '10001', 'United States of America', '+1 023-456-7890', 1, '2025-01-12 22:15:49');

--
-- admin@woodmade.commerce
-- Password: Iadmin
--
-- seller@woodmade.commerce
-- Password: Iseller
--
-- user@woodmade.commerce
-- Password: IAmUser

--

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ProductId_cart_product_FK` (`productID`),
  ADD KEY `UserId_cart_users_FK` (`userID`);

--
-- Індекси таблиці `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryID`);

--
-- Індекси таблиці `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `ProductId_orders_product_FK` (`productID`),
  ADD KEY `UserId_orders_users_FK` (`userID`);

--
-- Індекси таблиці `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productID`),
  ADD KEY `CategoryId_product_category_FK` (`categoryID`),
  ADD KEY `SellerId_product_users_FK` (`sellerID`),
  ADD KEY `SubcategoryName_product_subcategory_FK` (`subcategoryName`);

--
-- Індекси таблиці `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`subcategoryName`),
  ADD UNIQUE KEY `subcategoryName` (`subcategoryName`),
  ADD KEY `CategoryId_subcategory_category_FK` (`categoryID`);

--
-- Індекси таблиці `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблиці `category`
--
ALTER TABLE `category`
  MODIFY `categoryID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT для таблиці `orders`
--
ALTER TABLE `orders`
  MODIFY `orderID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT для таблиці `product`
--
ALTER TABLE `product`
  MODIFY `productID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT для таблиці `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `ProductId_cart_product_FK` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`),
  ADD CONSTRAINT `UserId_cart_users_FK` FOREIGN KEY (`userID`) REFERENCES `user` (`UserID`);

--
-- Обмеження зовнішнього ключа таблиці `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `ProductId_orders_product_FK` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`),
  ADD CONSTRAINT `UserId_orders_users_FK` FOREIGN KEY (`userID`) REFERENCES `user` (`UserID`);

--
-- Обмеження зовнішнього ключа таблиці `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `CategoryId_product_category_FK` FOREIGN KEY (`categoryID`) REFERENCES `category` (`categoryID`),
  ADD CONSTRAINT `SellerId_product_users_FK` FOREIGN KEY (`sellerID`) REFERENCES `user` (`UserID`),
  ADD CONSTRAINT `SubcategoryName_product_subcategory_FK` FOREIGN KEY (`subcategoryName`) REFERENCES `subcategory` (`subcategoryName`);

--
-- Обмеження зовнішнього ключа таблиці `subcategory`
--
ALTER TABLE `subcategory`
  ADD CONSTRAINT `CategoryId_subcategory_category_FK` FOREIGN KEY (`categoryID`) REFERENCES `category` (`categoryID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
