-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2024 at 12:47 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `beautics`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblcart`
--

CREATE TABLE `tblcart` (
  `Cart_id` int(11) NOT NULL,
  `variant_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcart`
--

INSERT INTO `tblcart` (`Cart_id`, `variant_id`, `user_id`) VALUES
(7, 21, 6),
(8, 6, 6);

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE `tblcategory` (
  `Category_id` int(11) NOT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `img_path` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  `is_disabled` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcategory`
--

INSERT INTO `tblcategory` (`Category_id`, `category_name`, `img_path`, `active`, `is_disabled`) VALUES
(1, 'Facial Care', 'pngtree-future-technological-science-background-picture-image_1205899.jpg', 1, 0),
(2, 'Hair Care', '1.jpg', 1, 0),
(3, 'Body Care', '1.jpg', 1, 0),
(4, 'Makeup', '1.jpg', 1, 0),
(5, 'Fragrances', '1.jpg', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblcity`
--

CREATE TABLE `tblcity` (
  `City_id` int(11) NOT NULL,
  `city_name` varchar(100) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  `is_disabled` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcity`
--

INSERT INTO `tblcity` (`City_id`, `city_name`, `state_id`, `active`, `is_disabled`) VALUES
(1, 'Ahmedabad', 1, 1, 0),
(2, 'Surat', 1, 1, 0),
(3, 'Vadodara', 1, 1, 0),
(4, 'Mumbai', 2, 1, 0),
(5, 'Pune', 2, 1, 0),
(6, 'Nagpur', 2, 1, 0),
(7, 'Jaipur', 3, 1, 0),
(8, 'Jodhpur', 3, 1, 0),
(9, 'Udaipur', 3, 1, 0),
(10, 'Bangalore', 4, 1, 0),
(11, 'Mysore', 4, 1, 0),
(12, 'Mangalore', 4, 1, 0),
(13, 'Chennai', 5, 1, 0),
(14, 'Coimbatore', 5, 1, 0),
(15, 'Madurai', 5, 1, 0),
(16, 'Lucknow', 6, 1, 0),
(17, 'Kanpur', 6, 1, 0),
(18, 'Varanasi', 6, 1, 0),
(19, 'Kolkata', 7, 1, 0),
(20, 'Darjeeling', 7, 1, 0),
(21, 'Howrah', 7, 1, 0),
(22, 'Amritsar', 8, 1, 0),
(23, 'Ludhiana', 8, 1, 0),
(24, 'Jalandhar', 8, 1, 0),
(25, 'Thiruvananthapuram', 9, 1, 0),
(26, 'Kochi', 9, 1, 0),
(27, 'Kozhikode', 9, 1, 0),
(28, 'Patna', 10, 1, 0),
(29, 'Gaya', 10, 1, 0),
(30, 'Muzaffarpur', 10, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblcolor`
--

CREATE TABLE `tblcolor` (
  `Color_id` int(11) NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `color_name` varchar(50) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  `is_disabled` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcolor`
--

INSERT INTO `tblcolor` (`Color_id`, `code`, `color_name`, `active`, `is_disabled`) VALUES
(1, '#FF5733', 'Fiery Red', 1, 0),
(2, '#33FF57', 'Lime Green', 1, 0),
(3, '#3357FF', 'Royal Blue', 1, 0),
(4, '#F4C542', 'Sunflower Yellow', 1, 0),
(5, '#FF33A6', 'Hot Pink', 1, 0),
(6, '#33FFF4', 'Turquoise Blue', 1, 0),
(7, '#8E44AD', 'Amethyst Purple', 1, 0),
(8, '#E74C3C', 'Cinnabar Red', 1, 0),
(9, '#2ECC71', 'Emerald Green', 1, 0),
(10, '#3498DB', 'Sky Blue', 1, 0),
(11, '#F39C12', 'Orange', 1, 0),
(12, '#1ABC9C', 'Mint Green', 1, 0),
(13, '#D35400', 'Pumpkin Orange', 1, 0),
(14, '#9B59B6', 'Purple', 1, 0),
(15, '#34495E', 'Charcoal', 1, 0),
(16, '#BDC3C7', 'Silver', 1, 0),
(17, '#E67E22', 'Carrot Orange', 1, 0),
(18, '#7F8C8D', 'Slate Gray', 1, 0),
(19, '#F1C40F', 'Golden Yellow', 1, 0),
(20, '#E74C3C', 'Red', 1, 0),
(21, '#c20000', 'asdadfasdfasdf', 1, 1),
(22, '#b02121', 'asdfasdf', 1, 1),
(23, '#000000', 'black', 1, 0),
(24, '#fafafa', 'black', 1, 1),
(25, '#ffffff', 'white', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblorder`
--

CREATE TABLE `tblorder` (
  `Order_id` int(11) NOT NULL,
  `variant_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblorder`
--

INSERT INTO `tblorder` (`Order_id`, `variant_id`, `user_id`, `quantity`, `total_price`, `order_date`, `status`) VALUES
(1, 10, 6, 5, 120.45, '2024-09-18', 'Dispatched'),
(2, 2, 6, 1, 36.49, '2024-09-24', 'Dispatched'),
(3, 20, 6, 4, 845.00, '2024-09-24', 'Confirmed');

-- --------------------------------------------------------

--
-- Table structure for table `tblpayment`
--

CREATE TABLE `tblpayment` (
  `Payment_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_amount` decimal(10,2) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `is_disabled` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblpayment`
--

INSERT INTO `tblpayment` (`Payment_id`, `order_id`, `payment_method`, `payment_amount`, `payment_date`, `is_disabled`) VALUES
(1, 1, 'Online', 120.45, '2024-09-18 19:45:35', 0),
(2, 2, 'Online', 36.49, '2024-09-24 15:34:33', 0),
(3, 3, 'Online', 845.00, '2024-09-24 15:37:37', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblproduct`
--

CREATE TABLE `tblproduct` (
  `Product_id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `ingredients` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  `is_disabled` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblproduct`
--

INSERT INTO `tblproduct` (`Product_id`, `product_name`, `description`, `ingredients`, `category_id`, `active`, `is_disabled`) VALUES
(1, 'Vitamin C Brightening Mask', 'Brightens and revitalizes skin', 'Vitamin C, Niacinamide, Green Tea', 1, 1, 0),
(2, 'Moisturizing Night Cream', 'Deep hydration during the night', 'Shea Butter, Hyaluronic Acid, Peptides', 1, 1, 0),
(3, 'Purifying Face Wash', 'Cleanses and purifies pores', 'Salicylic Acid, Tea Tree Oil', 1, 1, 0),
(4, 'Nourishing Hair Oil', 'Provides nourishment to hair and scalp', 'Coconut Oil, Argan Oil, Vitamin E', 2, 1, 0),
(5, 'Volumizing Hair Mousse', 'Adds volume and body to hair', 'Silk Protein, Biotin, Wheat Protein', 2, 1, 0),
(6, 'Deep Conditioner', 'Deeply moisturizes and detangles hair', 'Shea Butter, Olive Oil, Honey', 2, 1, 0),
(7, 'Body Butter', 'Ultra-rich moisturizer for dry skin', 'Cocoa Butter, Shea Butter, Coconut Oil', 3, 1, 0),
(8, 'Exfoliating Body Scrub', 'Gently exfoliates and smooths skin', 'Sugar, Sea Salt, Jojoba Oil', 3, 1, 0),
(9, 'Hydrating Body Lotion', 'Provides 24-hour hydration', 'Aloe Vera, Glycerin, Vitamin E', 3, 1, 0),
(10, 'Liquid Foundation', 'Provides medium coverage and a natural finish', 'Hyaluronic Acid, SPF 30, Vitamin E', 4, 1, 0),
(11, 'Matte Lipstick', 'Long-lasting matte lipstick', 'Beeswax, Shea Butter, Vitamin E', 4, 1, 0),
(12, 'Mascara', 'Lengthens and volumizes lashes', 'Jojoba Oil, Biotin, Castor Oil', 4, 1, 0),
(13, 'Eau de Parfum', 'A long-lasting floral fragrance', 'Rose, Jasmine, Vanilla', 5, 1, 0),
(14, 'Body Mist', 'Light, refreshing body mist', 'Citrus, Bergamot, Green Tea', 5, 1, 0),
(15, 'Roll-On Deodorant', 'Keeps you fresh all day long', 'Aloe Vera, Witch Hazel, Tea Tree Oil', 5, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblreview`
--

CREATE TABLE `tblreview` (
  `Review_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `review_score` int(11) DEFAULT NULL CHECK (`review_score` between 0 and 5),
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  `is_disabled` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblstate`
--

CREATE TABLE `tblstate` (
  `State_id` int(11) NOT NULL,
  `state_name` varchar(100) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  `is_disabled` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblstate`
--

INSERT INTO `tblstate` (`State_id`, `state_name`, `active`, `is_disabled`) VALUES
(1, 'Gujarat', 1, 0),
(2, 'Maharashtra', 1, 0),
(3, 'Rajasthan', 1, 0),
(4, 'Karnataka', 1, 0),
(5, 'Tamil Nadu', 1, 0),
(6, 'Uttar Pradesh', 1, 0),
(7, 'West Bengal', 1, 0),
(8, 'Punjab', 1, 0),
(9, 'Kerala', 1, 0),
(10, 'Bihar', 1, 0),
(17, 'Gujaratasd', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `User_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `flat_number` varchar(10) DEFAULT NULL,
  `floor_number` varchar(10) DEFAULT NULL,
  `building_name` varchar(50) DEFAULT NULL,
  `road_street` varchar(50) DEFAULT NULL,
  `pincode` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `profile_img` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  `is_disabled` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`User_id`, `name`, `contact`, `email`, `password`, `gender`, `flat_number`, `floor_number`, `building_name`, `road_street`, `pincode`, `city_id`, `profile_img`, `role`, `active`, `is_disabled`) VALUES
(1, 'Admin1', '2323232323', 'Admin1@gmail.com', '$2y$10$80xovqjTvLCwJVHT67hMOOUQ6PEgIGlWMoVqIVxBtZ7R1ZbrPqsUW', 'Male', 'as', '', 'sdd', 'sdf', 234334, 1, 'Designer (3).png', 'Admin', 1, 0),
(2, 'Admin2', NULL, 'Admin2@gmail.com', '$2y$10$WuJnU8yJPWirVOdLwcsEfOdC7mjRuyayvxD76zSjG3K3/6bQdQisu', 'Male', NULL, '', NULL, NULL, NULL, 1, NULL, 'Admin', 1, 0),
(3, 'Staff1', NULL, 'Staff1@gmail.com', '$2y$10$sR6D.pDcLogMBe4y4knaNeIkZrMtPJAT4ynbuDXEhTCVYkp.ocrHu', 'Male', NULL, '', NULL, NULL, NULL, 1, 'anime-boy-black-pfp-33.jpg', 'Staff', 1, 0),
(4, 'Staff2', NULL, 'Staff2@gmail.com', '$2y$10$j4v/KO1EBhIgw3aMHflg4.3MGTbGVXHStfz3fOLyx8X72c2OoB.Ua', 'Male', NULL, '', NULL, NULL, NULL, 1, NULL, 'Staff', 1, 0),
(5, 'Staff3', '', 'Staff3@gmail.com', '$2y$10$u.vECbxfzgZK3LbjKUCxzeW73rjz1uCW3y2Q02JEQu1RkAo9gsxcW', 'Female', NULL, '', NULL, NULL, NULL, 1, NULL, 'Staff', 1, 0),
(6, 'Customer1', '3423342334', 'Customer1@gmail.com', '$2y$10$YcLYMsM0aBEEmAU.K42DtOyAaZf5gQ6n4tzyeFIBoUy6W3jhWfcXy', 'Male', '12', '120', 'kiran rohouse', 'varachha', 394003, 1, 'ifoto-ai_1726738743518-removebg-previe134w.png', 'Customer', 1, 0),
(7, 'Customer2', NULL, 'Customer2@gmail.com', '$2y$10$146gQlQ8faPpPs3JttrDY.sA2hgUs/r2EbpGbKLoIVOJ7v3sEGDny', 'Male', NULL, '', NULL, NULL, NULL, 1, NULL, 'Customer', 1, 0),
(8, 'Customer3', NULL, 'Customer3@gmail.com', '$2y$10$L8VCb7bNoNpRjgnob/NBxer1D2diHFKEk4YiIPCVXreBaOldlcVbi', 'Male', NULL, '', NULL, NULL, NULL, 1, NULL, 'Customer', 1, 0),
(9, 'Customer4', '', 'Customer4@gmail.com', '$2y$10$KMLEBGBNBCpgY12QYMJTXOcB7T276pXIHWz7UweMeiBeA/qV4ZhvS', 'Female', NULL, '', NULL, NULL, NULL, 1, NULL, 'Customer', 1, 0),
(10, 'Customer5', NULL, 'Customer5@gmail.com', '$2y$10$UpNDiQ50vbsucDq8rrx5duhTl.DOVNsEsazuRAI8Su7DV1V9zR7OO', 'Male', NULL, '', NULL, NULL, NULL, 1, NULL, 'Customer', 1, 0),
(11, 'akshil', '3423453423', '21bmiit005@gmail.com', 'password', 'Male', NULL, NULL, NULL, NULL, NULL, 23, NULL, 'Customer', 1, 0),
(12, 'akshil', '3453445434', 'Ad234234min1@gmail.com', 'password', 'Male', NULL, NULL, NULL, NULL, NULL, 2, NULL, 'Customer', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblvariants`
--

CREATE TABLE `tblvariants` (
  `Variant_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL,
  `amount_type` varchar(50) DEFAULT NULL,
  `amount_value` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `img_path` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  `is_disabled` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblvariants`
--

INSERT INTO `tblvariants` (`Variant_id`, `product_id`, `color_id`, `amount_type`, `amount_value`, `price`, `quantity`, `img_path`, `active`, `is_disabled`) VALUES
(1, 1, 2, 'Size', 23.00, 123.00, 120, '3.jpg', 1, 0),
(2, 1, 1, 'ml', 50.00, 29.99, 99, '1.jpg', 1, 0),
(3, 1, 1, 'ml', 100.00, 49.99, 50, '1.jpg', 1, 0),
(4, 2, 2, 'ml', 50.00, 24.99, 150, '1.jpg', 1, 0),
(5, 2, 2, 'ml', 100.00, 44.99, 80, '1.jpg', 1, 0),
(6, 3, 3, 'ml', 150.00, 19.99, 120, '1.jpg', 1, 0),
(7, 4, 4, 'ml', 100.00, 15.99, 200, '1.jpg', 1, 0),
(8, 4, 4, 'ml', 200.00, 29.99, 150, '1.jpg', 1, 0),
(9, 5, 5, 'ml', 150.00, 17.99, 100, '1.jpg', 1, 0),
(10, 6, 6, 'ml', 200.00, 21.99, 85, '1.jpg', 1, 0),
(11, 7, 5, 'ml', 250.00, 19.99, 80, '1.jpg', 1, 0),
(12, 8, 8, 'ml', 200.00, 18.99, 60, '1.jpg', 1, 0),
(13, 9, 9, 'ml', 300.00, 14.99, 100, '1.jpg', 1, 0),
(14, 10, 10, 'ml', 30.00, 24.99, 120, '1.jpg', 1, 0),
(15, 11, 11, 'g', 3.00, 12.99, 200, '1.jpg', 1, 0),
(16, 12, 12, 'ml', 10.00, 14.99, 150, '1.jpg', 1, 0),
(17, 13, 13, 'ml', 50.00, 39.99, 80, '1.jpg', 1, 0),
(18, 14, 14, 'ml', 100.00, 19.99, 120, '1.jpg', 1, 0),
(19, 15, 15, 'ml', 50.00, 9.99, 150, '1.jpg', 1, 0),
(20, 1, 12, 'Size', 200.00, 200.00, 96, '2.jpeg', 1, 1),
(21, 1, 12, 'kg', 10.00, 800.00, 200, 'images (1).png', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblwishlist`
--

CREATE TABLE `tblwishlist` (
  `Wishlist_id` int(11) NOT NULL,
  `variant_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblcart`
--
ALTER TABLE `tblcart`
  ADD PRIMARY KEY (`Cart_id`),
  ADD KEY `variant_id` (`variant_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`Category_id`);

--
-- Indexes for table `tblcity`
--
ALTER TABLE `tblcity`
  ADD PRIMARY KEY (`City_id`),
  ADD KEY `state_id` (`state_id`);

--
-- Indexes for table `tblcolor`
--
ALTER TABLE `tblcolor`
  ADD PRIMARY KEY (`Color_id`);

--
-- Indexes for table `tblorder`
--
ALTER TABLE `tblorder`
  ADD PRIMARY KEY (`Order_id`),
  ADD KEY `variant_id` (`variant_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tblpayment`
--
ALTER TABLE `tblpayment`
  ADD PRIMARY KEY (`Payment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `tblproduct`
--
ALTER TABLE `tblproduct`
  ADD PRIMARY KEY (`Product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `tblreview`
--
ALTER TABLE `tblreview`
  ADD PRIMARY KEY (`Review_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `tblstate`
--
ALTER TABLE `tblstate`
  ADD PRIMARY KEY (`State_id`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`User_id`),
  ADD KEY `city_id` (`city_id`);

--
-- Indexes for table `tblvariants`
--
ALTER TABLE `tblvariants`
  ADD PRIMARY KEY (`Variant_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `color_id` (`color_id`);

--
-- Indexes for table `tblwishlist`
--
ALTER TABLE `tblwishlist`
  ADD PRIMARY KEY (`Wishlist_id`),
  ADD KEY `variant_id` (`variant_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblcart`
--
ALTER TABLE `tblcart`
  MODIFY `Cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `Category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tblcity`
--
ALTER TABLE `tblcity`
  MODIFY `City_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `tblcolor`
--
ALTER TABLE `tblcolor`
  MODIFY `Color_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tblorder`
--
ALTER TABLE `tblorder`
  MODIFY `Order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tblpayment`
--
ALTER TABLE `tblpayment`
  MODIFY `Payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblproduct`
--
ALTER TABLE `tblproduct`
  MODIFY `Product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tblreview`
--
ALTER TABLE `tblreview`
  MODIFY `Review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblstate`
--
ALTER TABLE `tblstate`
  MODIFY `State_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `User_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tblvariants`
--
ALTER TABLE `tblvariants`
  MODIFY `Variant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tblwishlist`
--
ALTER TABLE `tblwishlist`
  MODIFY `Wishlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblcart`
--
ALTER TABLE `tblcart`
  ADD CONSTRAINT `tblcart_ibfk_1` FOREIGN KEY (`variant_id`) REFERENCES `tblvariants` (`Variant_id`),
  ADD CONSTRAINT `tblcart_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tbluser` (`User_id`);

--
-- Constraints for table `tblcity`
--
ALTER TABLE `tblcity`
  ADD CONSTRAINT `tblcity_ibfk_1` FOREIGN KEY (`state_id`) REFERENCES `tblstate` (`State_id`);

--
-- Constraints for table `tblorder`
--
ALTER TABLE `tblorder`
  ADD CONSTRAINT `tblorder_ibfk_1` FOREIGN KEY (`variant_id`) REFERENCES `tblvariants` (`Variant_id`),
  ADD CONSTRAINT `tblorder_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tbluser` (`User_id`);

--
-- Constraints for table `tblpayment`
--
ALTER TABLE `tblpayment`
  ADD CONSTRAINT `tblpayment_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `tblorder` (`Order_id`);

--
-- Constraints for table `tblproduct`
--
ALTER TABLE `tblproduct`
  ADD CONSTRAINT `tblproduct_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `tblcategory` (`Category_id`);

--
-- Constraints for table `tblreview`
--
ALTER TABLE `tblreview`
  ADD CONSTRAINT `tblreview_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbluser` (`User_id`),
  ADD CONSTRAINT `tblreview_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `tblproduct` (`Product_id`);

--
-- Constraints for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD CONSTRAINT `tbluser_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `tblcity` (`City_id`);

--
-- Constraints for table `tblvariants`
--
ALTER TABLE `tblvariants`
  ADD CONSTRAINT `tblvariants_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `tblproduct` (`Product_id`),
  ADD CONSTRAINT `tblvariants_ibfk_2` FOREIGN KEY (`color_id`) REFERENCES `tblcolor` (`Color_id`);

--
-- Constraints for table `tblwishlist`
--
ALTER TABLE `tblwishlist`
  ADD CONSTRAINT `tblwishlist_ibfk_1` FOREIGN KEY (`variant_id`) REFERENCES `tblvariants` (`Variant_id`),
  ADD CONSTRAINT `tblwishlist_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tbluser` (`User_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
