-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2023 at 01:00 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myphotovault`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `ID` int(10) UNSIGNED NOT NULL,
  `user_ID` int(10) UNSIGNED NOT NULL,
  `image_ID` int(10) UNSIGNED NOT NULL,
  `message` varchar(280) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`ID`, `user_ID`, `image_ID`, `message`, `timestamp`) VALUES
(9, 5, 39, 'Aww, So peaceful!', '2023-12-15 22:00:45'),
(10, 5, 40, 'He must hear food.', '2023-12-15 22:01:12'),
(11, 5, 83, 'Can confirm, that\'s not how to boom.', '2023-12-15 22:26:10'),
(12, 5, 64, 'Gosig Råtta Ora Pro Nobis!', '2023-12-15 23:09:41'),
(13, 7, 91, 'That goose must be litterate!', '2023-12-15 22:49:15'),
(14, 7, 71, 'What are they planning?', '2023-12-15 22:49:36'),
(15, 7, 66, 'Hiisssssssssssss', '2023-12-15 22:49:55'),
(16, 6, 13, 'He\'s gonna be late!', '2023-12-15 22:56:43'),
(17, 6, 64, 'It\'s the Gosig Råtta!', '2023-12-15 23:10:24'),
(18, 6, 66, 'Hisssssssssss', '2023-12-15 22:58:46'),
(19, 6, 78, 'That\'s not a pizza topping...', '2023-12-15 22:59:18'),
(20, 6, 91, 'Results are skewed heavily.  Surely he can indeed read!', '2023-12-15 23:00:12'),
(21, 6, 97, 'Gnarly indeed!', '2023-12-15 23:00:47'),
(22, 8, 85, 'Boooooo!', '2023-12-15 23:06:21'),
(23, 8, 80, 'Boooooo!', '2023-12-15 23:06:32'),
(24, 8, 78, 'Boooooo!', '2023-12-15 23:06:43'),
(25, 5, 9, 'Yum!', '2023-12-15 23:07:35'),
(26, 5, 78, 'Watcha doin\' up there?', '2023-12-15 23:08:20'),
(27, 5, 50, 'Aww man, someone call the Avengers!', '2023-12-15 23:09:16'),
(28, 9, 66, 'hiisssssssssssssss', '2023-12-16 00:48:54'),
(29, 5, 66, 'hisssssssssssssssssssssssssssssssssssssssssssssssssss', '2023-12-16 00:58:14');

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `ID` int(10) UNSIGNED NOT NULL,
  `owner_ID` int(10) UNSIGNED NOT NULL,
  `time_stamp` datetime NOT NULL DEFAULT current_timestamp(),
  `visibility` tinyint(4) NOT NULL,
  `name` varchar(64) NOT NULL,
  `description` varchar(280) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`ID`, `owner_ID`, `time_stamp`, `visibility`, `name`, `description`) VALUES
(7, 5, '2023-12-15 16:26:42', 1, 'NKCyber', ''),
(8, 5, '2023-12-15 16:27:58', 1, 'Costumes', ''),
(9, 7, '2023-12-15 16:47:30', 1, 'Geese', ''),
(10, 7, '2023-12-15 16:51:47', 1, 'Carnival & Concert', ''),
(11, 6, '2023-12-15 16:53:56', 1, 'Food', ''),
(12, 6, '2023-12-15 16:54:00', 1, 'Critters', ''),
(13, 8, '2023-12-15 17:02:56', 1, 'Dogs', '');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `ID` int(10) UNSIGNED NOT NULL,
  `owner_ID` int(10) UNSIGNED NOT NULL,
  `filename` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `url` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`ID`, `owner_ID`, `filename`, `name`, `timestamp`, `url`) VALUES
(6, 5, 'image_657cb5d0a84d5.JPG', 'Mighty Joe Napping', '2023-12-15 15:23:44', 'data/images/image_657cb5d0a84d5.JPG'),
(7, 5, 'image_657cb5db7927a.JPG', 'Mighty Joe Napping', '2023-12-15 15:23:55', 'data/images/image_657cb5db7927a.JPG'),
(8, 5, 'image_657cb8e13d1e4.JPG', 'Plate of Food?', '2023-12-15 15:36:49', 'data/images/image_657cb8e13d1e4.JPG'),
(9, 5, 'image_657cb8ed708d8.JPG', 'Plate of \"Food\"', '2023-12-15 15:37:01', 'data/images/image_657cb8ed708d8.JPG'),
(10, 7, 'image_657cb916ce95d.JPG', 'Rabbit 1', '2023-12-15 15:37:42', 'data/images/image_657cb916ce95d.JPG'),
(11, 7, 'image_657cb91e4c802.JPG', 'Rabbit 2', '2023-12-15 15:37:50', 'data/images/image_657cb91e4c802.JPG'),
(12, 7, 'image_657cb92409460.JPG', 'Rabbit 3', '2023-12-15 15:37:56', 'data/images/image_657cb92409460.JPG'),
(13, 7, 'image_657cb933bb73c.JPG', 'Rabbt 4', '2023-12-15 15:38:11', 'data/images/image_657cb933bb73c.JPG'),
(14, 6, 'image_657cb96122c17.JPG', 'Clockwork Dragon Face', '2023-12-15 15:38:57', 'data/images/image_657cb96122c17.JPG'),
(15, 6, 'image_657cb9680f248.JPG', 'Clockwork Dragon', '2023-12-15 15:39:04', 'data/images/image_657cb9680f248.JPG'),
(16, 6, 'image_657cb9750f52f.JPG', 'Clockwork Dragon Gears', '2023-12-15 15:39:17', 'data/images/image_657cb9750f52f.JPG'),
(17, 7, 'image_657cb9ea72a2b.JPG', 'Flowers', '2023-12-15 15:41:14', 'data/images/image_657cb9ea72a2b.JPG'),
(18, 7, 'image_657cb9ef54d39.JPG', 'Flowes', '2023-12-15 15:41:19', 'data/images/image_657cb9ef54d39.JPG'),
(20, 5, 'image_657cba5ca2b42.JPG', 'Mighty Joe-rrito', '2023-12-15 15:43:08', 'data/images/image_657cba5ca2b42.JPG'),
(21, 5, 'image_657cba6167fa6.JPG', 'Mighty Joe-rrito', '2023-12-15 15:43:13', 'data/images/image_657cba6167fa6.JPG'),
(22, 6, 'image_657cbaac8fff9.JPG', 'Couple of Geese', '2023-12-15 15:44:28', 'data/images/image_657cbaac8fff9.JPG'),
(23, 6, 'image_657cbacb6b5b1.jpg', 'Caterpillar', '2023-12-15 15:44:59', 'data/images/image_657cbacb6b5b1.jpg'),
(24, 6, 'image_657cbadb1adce.jpg', 'Plumbing of some kind', '2023-12-15 15:45:15', 'data/images/image_657cbadb1adce.jpg'),
(25, 6, 'image_657cbaf3788bd.jpg', 'Gumdrops', '2023-12-15 15:45:39', 'data/images/image_657cbaf3788bd.jpg'),
(27, 5, 'image_657cbd54c4ac7.JPG', 'Mighty sniffing', '2023-12-15 15:55:48', 'data/images/image_657cbd54c4ac7.JPG'),
(28, 7, 'image_657cbd68a879e.JPG', 'Leaf', '2023-12-15 15:56:08', 'data/images/image_657cbd68a879e.JPG'),
(29, 5, 'image_657cbd7f60063.JPG', 'Mighty on the Trail', '2023-12-15 15:56:31', 'data/images/image_657cbd7f60063.JPG'),
(30, 5, 'image_657cbd8b0902d.JPG', 'Mighty looking twords the trail', '2023-12-15 15:56:43', 'data/images/image_657cbd8b0902d.JPG'),
(31, 5, 'image_657cbdaec2e30.jpg', 'Gnarcissus\'s ruffled feathers', '2023-12-15 15:57:18', 'data/images/image_657cbdaec2e30.jpg'),
(32, 6, 'image_657cbdd81783c.JPG', 'Bowl of somethin\'', '2023-12-15 15:58:00', 'data/images/image_657cbdd81783c.JPG'),
(33, 6, 'image_657cbded0e882.JPG', 'Parking Garage at Sunset ', '2023-12-15 15:58:21', 'data/images/image_657cbded0e882.JPG'),
(34, 6, 'image_657cbe0057ee1.JPG', 'Many Cherries', '2023-12-15 15:58:40', 'data/images/image_657cbe0057ee1.JPG'),
(35, 6, 'image_657cbe04e5a57.JPG', 'Too Many Cherries', '2023-12-15 15:58:44', 'data/images/image_657cbe04e5a57.JPG'),
(36, 7, 'image_657cbe2831d8e.JPG', 'Cone in the Ground', '2023-12-15 15:59:20', 'data/images/image_657cbe2831d8e.JPG'),
(37, 7, 'image_657cbe2ecbd78.JPG', 'Cone in the Ground', '2023-12-15 15:59:26', 'data/images/image_657cbe2ecbd78.JPG'),
(38, 7, 'image_657cbe35ca019.JPG', 'Cone in the Ground', '2023-12-15 15:59:33', 'data/images/image_657cbe35ca019.JPG'),
(39, 5, 'image_657cbe65e9c83.jpg', 'Digger Napping', '2023-12-15 16:00:21', 'data/images/image_657cbe65e9c83.jpg'),
(40, 5, 'image_657cbe8d40f29.jpg', 'Mighty Listening intently', '2023-12-15 16:01:01', 'data/images/image_657cbe8d40f29.jpg'),
(41, 5, 'image_657cbef898412.jpg', 'Emperor Zurg', '2023-12-15 16:02:48', 'data/images/image_657cbef898412.jpg'),
(42, 5, 'image_657cbefc43d7f.jpg', 'Emperor Zurg', '2023-12-15 16:02:52', 'data/images/image_657cbefc43d7f.jpg'),
(43, 5, 'image_657cbf03de587.jpg', 'Emperor Zurg', '2023-12-15 16:02:59', 'data/images/image_657cbf03de587.jpg'),
(44, 5, 'image_657cbf07773d5.jpg', 'Emperor Zurg', '2023-12-15 16:03:03', 'data/images/image_657cbf07773d5.jpg'),
(45, 6, 'image_657cbf2f0277f.JPG', 'Cool blue/pink sunset', '2023-12-15 16:03:43', 'data/images/image_657cbf2f0277f.JPG'),
(46, 6, 'image_657cbf417e400.JPG', 'Sprinkler over a tree', '2023-12-15 16:04:01', 'data/images/image_657cbf417e400.JPG'),
(47, 6, 'image_657cbf4f2cdf4.JPG', 'Sunset over a hill', '2023-12-15 16:04:15', 'data/images/image_657cbf4f2cdf4.JPG'),
(48, 6, 'image_657cbf626927e.JPG', 'Flowers at the base of a tree', '2023-12-15 16:04:34', 'data/images/image_657cbf626927e.JPG'),
(49, 7, 'image_657cbf7f63341.JPG', 'Fractured Sky', '2023-12-15 16:05:03', 'data/images/image_657cbf7f63341.JPG'),
(50, 7, 'image_657cbf9820118.jpg', 'Something\'s going on in New York!', '2023-12-15 16:05:28', 'data/images/image_657cbf9820118.jpg'),
(51, 7, 'image_657cbfb5cdf70.JPG', 'Double Beans?', '2023-12-15 16:05:57', 'data/images/image_657cbfb5cdf70.JPG'),
(52, 7, 'image_657cbfc0b45a9.JPG', 'Rainbow Lines', '2023-12-15 16:06:08', 'data/images/image_657cbfc0b45a9.JPG'),
(53, 7, 'image_657cbfcf6581a.JPG', 'Red Flowers in Fountain Square', '2023-12-15 16:06:23', 'data/images/image_657cbfcf6581a.JPG'),
(54, 6, 'image_657cbffa5cc28.jpg', 'Filming on the Carousel?', '2023-12-15 16:07:06', 'data/images/image_657cbffa5cc28.jpg'),
(55, 6, 'image_657cc0036a102.jpg', 'Carnival fun', '2023-12-15 16:07:15', 'data/images/image_657cc0036a102.jpg'),
(56, 6, 'image_657cc00b263d5.jpg', 'Spinnin\' Round', '2023-12-15 16:07:23', 'data/images/image_657cc00b263d5.jpg'),
(57, 7, 'image_657cc02827e4d.jpg', 'Swingin\' Boat', '2023-12-15 16:07:52', 'data/images/image_657cc02827e4d.jpg'),
(58, 7, 'image_657cc03065eb1.jpg', 'Weeeee', '2023-12-15 16:08:00', 'data/images/image_657cc03065eb1.jpg'),
(59, 6, 'image_657cc0426fd49.jpg', 'On a Boat!', '2023-12-15 16:08:18', 'data/images/image_657cc0426fd49.jpg'),
(60, 6, 'image_657cc04b8a459.jpg', 'Late night concert', '2023-12-15 16:08:27', 'data/images/image_657cc04b8a459.jpg'),
(61, 6, 'image_657cc05766271.jpg', 'Giant viloin?', '2023-12-15 16:08:39', 'data/images/image_657cc05766271.jpg'),
(62, 7, 'image_657cc07560588.jpg', 'Head bangin\'', '2023-12-15 16:09:09', 'data/images/image_657cc07560588.jpg'),
(63, 7, 'image_657cc07ce9654.jpg', 'Belting vocals', '2023-12-15 16:09:16', 'data/images/image_657cc07ce9654.jpg'),
(64, 7, 'image_657cc0b342052.jpg', 'Gosig Råtta', '2023-12-15 16:10:11', 'data/images/image_657cc0b342052.jpg'),
(65, 6, 'image_657cc0ee669b5.JPG', 'Griffin Lights', '2023-12-15 16:11:10', 'data/images/image_657cc0ee669b5.JPG'),
(66, 6, 'image_657cc105795a7.jpg', 'HHHIIIIIIISSSSSSSSSSSSS', '2023-12-15 16:11:33', 'data/images/image_657cc105795a7.jpg'),
(67, 6, 'image_657cc111330a4.JPG', 'Big fan of Ravenclaw', '2023-12-15 16:11:45', 'data/images/image_657cc111330a4.JPG'),
(68, 6, 'image_657cc118cfb8e.jpg', 'I am Groot', '2023-12-15 16:11:52', 'data/images/image_657cc118cfb8e.jpg'),
(69, 7, 'image_657cc13aadd7b.jpg', 'Glowing Mural', '2023-12-15 16:12:26', 'data/images/image_657cc13aadd7b.jpg'),
(70, 7, 'image_657cc14386d1d.jpg', 'Festive Archway', '2023-12-15 16:12:35', 'data/images/image_657cc14386d1d.jpg'),
(71, 7, 'image_657cc1541c70b.jpg', 'Congregation of Geese', '2023-12-15 16:12:52', 'data/images/image_657cc1541c70b.jpg'),
(72, 7, 'image_657cc15e3f42b.jpg', 'LOG', '2023-12-15 16:13:02', 'data/images/image_657cc15e3f42b.jpg'),
(73, 7, 'image_657cc1748c88f.jpg', 'Penguinion', '2023-12-15 16:13:24', 'data/images/image_657cc1748c88f.jpg'),
(74, 7, 'image_657cc17b64188.jpg', 'This little fella', '2023-12-15 16:13:31', 'data/images/image_657cc17b64188.jpg'),
(75, 7, 'image_657cc19caf33b.jpg', 'Angle Embracing the Evil Ways of the Goose\'s Honk', '2023-12-15 16:14:04', 'data/images/image_657cc19caf33b.jpg'),
(76, 5, 'image_657cc1b802184.jpg', 'NCL Player Coin Back', '2023-12-15 16:14:32', 'data/images/image_657cc1b802184.jpg'),
(77, 5, 'image_657cc1c0c586f.jpg', 'NCL Player Coin Frount', '2023-12-15 16:14:40', 'data/images/image_657cc1c0c586f.jpg'),
(78, 5, 'image_657cc1cd96139.jpg', 'Cat on the Table?', '2023-12-15 16:14:53', 'data/images/image_657cc1cd96139.jpg'),
(79, 5, 'image_657cc1d36c518.jpg', 'Camera', '2023-12-15 16:14:59', 'data/images/image_657cc1d36c518.jpg'),
(80, 5, 'image_657cc1dbe627f.jpg', 'Cat on the Prowl', '2023-12-15 16:15:07', 'data/images/image_657cc1dbe627f.jpg'),
(81, 5, 'image_657cc1f288d65.jpg', 'Gaffer Hidden in the Shadows', '2023-12-15 16:15:30', 'data/images/image_657cc1f288d65.jpg'),
(82, 5, 'image_657cc1fcc783b.jpg', 'Gaffer Gaffing', '2023-12-15 16:15:40', 'data/images/image_657cc1fcc783b.jpg'),
(83, 6, 'image_657cc2245efc2.jpg', 'That\'s not how you boom!', '2023-12-15 16:16:20', 'data/images/image_657cc2245efc2.jpg'),
(84, 6, 'image_657cc22c84767.jpg', 'Looking at waveforms?', '2023-12-15 16:16:28', 'data/images/image_657cc22c84767.jpg'),
(85, 7, 'image_657cc246762a7.jpg', 'Cat in the Window', '2023-12-15 16:16:54', 'data/images/image_657cc246762a7.jpg'),
(86, 5, 'image_657cc271d8a14.jpg', 'Wizard', '2023-12-15 16:17:37', 'data/images/image_657cc271d8a14.jpg'),
(87, 5, 'image_657cc280d7940.jpg', 'Wizzzzaaaaaaardd!', '2023-12-15 16:17:52', 'data/images/image_657cc280d7940.jpg'),
(88, 5, 'image_657cc28ee2882.jpg', 'H O R S E !', '2023-12-15 16:18:06', 'data/images/image_657cc28ee2882.jpg'),
(89, 5, 'image_657cc2955dab4.jpg', 'Shuffle', '2023-12-15 16:18:13', 'data/images/image_657cc2955dab4.jpg'),
(90, 5, 'image_657cc29d872af.JPG', 'NKCyber', '2023-12-15 16:18:21', 'data/images/image_657cc29d872af.JPG'),
(91, 5, 'image_657cc2b489698.jpg', 'Scientific studies suggest the goose cannot read :(', '2023-12-15 16:18:44', 'data/images/image_657cc2b489698.jpg'),
(92, 5, 'image_657cc2c6e2a09.jpg', 'Barty Keychain', '2023-12-15 16:19:02', 'data/images/image_657cc2c6e2a09.jpg'),
(93, 5, 'image_657cc2c9d91d8.jpg', 'Barty Keychain', '2023-12-15 16:19:05', 'data/images/image_657cc2c9d91d8.jpg'),
(94, 5, 'image_657cc2d178771.jpg', 'Red Barty Keychain', '2023-12-15 16:19:13', 'data/images/image_657cc2d178771.jpg'),
(95, 5, 'image_657cc2d4ebf2b.jpg', 'Barty Keychain', '2023-12-15 16:19:16', 'data/images/image_657cc2d4ebf2b.jpg'),
(96, 5, 'image_657cc2da75221.jpg', 'Barty Keychain', '2023-12-15 16:19:22', 'data/images/image_657cc2da75221.jpg'),
(97, 5, 'image_657cc2e5ad715.jpg', 'Gnarly Goose Powers', '2023-12-15 16:19:33', 'data/images/image_657cc2e5ad715.jpg'),
(98, 5, 'image_657cc411ac01b.jpg', 'Staredown throgh the looking glass', '2023-12-15 16:24:33', 'data/images/image_657cc411ac01b.jpg'),
(99, 5, 'image_657cc41debe16.JPG', 'Preporation', '2023-12-15 16:24:45', 'data/images/image_657cc41debe16.JPG'),
(100, 9, 'image_657ce5cadae90.png', 'Evil Wizard', '2023-12-15 18:48:26', 'data/images/image_657ce5cadae90.png'),
(101, 9, 'image_657ce66ed3b90.jpg', 'firefox', '2023-12-15 18:51:10', 'data/images/image_657ce66ed3b90.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `img_in_gal`
--

CREATE TABLE `img_in_gal` (
  `image_ID` int(10) UNSIGNED NOT NULL,
  `gallery_ID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `img_in_gal`
--

INSERT INTO `img_in_gal` (`image_ID`, `gallery_ID`) VALUES
(6, 13),
(7, 13),
(8, 11),
(9, 11),
(10, 12),
(11, 12),
(12, 12),
(13, 12),
(14, 12),
(15, 12),
(16, 12),
(20, 13),
(21, 13),
(22, 9),
(22, 12),
(23, 12),
(25, 11),
(27, 12),
(27, 13),
(29, 12),
(29, 13),
(30, 12),
(30, 13),
(31, 9),
(31, 12),
(32, 11),
(34, 11),
(35, 11),
(39, 12),
(39, 13),
(40, 12),
(40, 13),
(41, 8),
(42, 8),
(43, 8),
(44, 8),
(54, 10),
(55, 10),
(56, 10),
(57, 10),
(58, 10),
(59, 10),
(60, 10),
(61, 10),
(62, 10),
(63, 10),
(66, 9),
(66, 12),
(71, 9),
(75, 7),
(75, 9),
(76, 7),
(77, 7),
(78, 11),
(78, 12),
(80, 12),
(85, 12),
(86, 8),
(87, 8),
(90, 7),
(91, 9),
(91, 12),
(92, 7),
(93, 7),
(94, 7),
(95, 7),
(96, 7),
(97, 9),
(97, 12),
(98, 9),
(99, 11);

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `user_ID` int(10) UNSIGNED NOT NULL,
  `img_ID` int(10) UNSIGNED NOT NULL,
  `stars` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`user_ID`, `img_ID`, `stars`) VALUES
(5, 9, 1),
(5, 17, 4),
(5, 57, 5),
(5, 62, 4),
(5, 64, 5),
(5, 70, 4),
(5, 72, 5),
(5, 73, 5),
(5, 74, 3),
(5, 75, 5),
(5, 78, 1),
(5, 79, 5),
(5, 80, 5),
(5, 82, 4),
(5, 83, 4),
(5, 90, 4),
(5, 92, 1),
(5, 93, 4),
(5, 94, 2),
(5, 95, 3),
(5, 96, 5),
(5, 97, 4),
(5, 98, 4),
(5, 99, 5),
(6, 30, 4),
(6, 97, 2),
(6, 98, 5),
(6, 99, 1),
(7, 22, 3),
(7, 31, 4),
(7, 91, 2),
(7, 97, 3),
(7, 98, 5),
(8, 6, 5),
(8, 7, 5),
(8, 20, 5),
(8, 21, 5),
(8, 27, 5),
(8, 29, 5),
(8, 30, 5),
(8, 39, 5),
(8, 40, 5),
(8, 85, 1),
(8, 86, 2),
(8, 87, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_joined` datetime NOT NULL DEFAULT current_timestamp(),
  `bio` varchar(280) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `name`, `email`, `password`, `date_joined`, `bio`, `profile_image`, `status`) VALUES
(5, 'Patrick Hirsch', 'HirschP2@nku.edu', '$2y$10$emQfYy9KRUNOdU4dhN0BXu8xG/UV0SxT99HWySsk7bCl3xxluAf9y', '2023-12-15 15:21:30', 'Profile?  No, I\'m antifile', 'data/profilePhotos/5.jpg', 1),
(6, 'Luke Norberg', 'NorbergP2@nku.edu', '$2y$10$58Xl8GsCJ9L0mlI6sM0jkOFlrp9AjB6pQwTvalwF14jbQ7yX.Fzmu', '2023-12-15 15:22:28', '', 'data/profilePhotos/6.png', 1),
(7, 'Sarah Riley', 'RileyS14@nku.edu', '$2y$10$VCzNoz39nD21eVR0KqiVT.GJspQ7sUTT0V.0IGbqZuRDLIeviykuS', '2023-12-15 15:22:50', '', 'data/profilePhotos/7.png', 1),
(8, 'Dr. Nicholas Caporusso', 'CaporussoN1@nku.edu', '$2y$10$sVK.TpXB3Orj8tJvLxX9dOa9OPqzr8dofuChQOd6B1hwMuREbApBu', '2023-12-15 15:23:07', '', 'data/profilePhotos/8.jpg', 3),
(9, 'Angle Munoz', 'MunozA2@nku.edu', '$2y$10$wbsweNMiMmT9tqqkKdQPTOJTgdEyleuKUUHatrlJjbWu/4SQY/dUK', '2023-12-15 18:47:45', '', 'data/profilePhotos/9.jpg', -1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_ID` (`user_ID`,`image_ID`),
  ADD KEY `image_ID` (`image_ID`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `owner_ID` (`owner_ID`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `owner_ID` (`owner_ID`);

--
-- Indexes for table `img_in_gal`
--
ALTER TABLE `img_in_gal`
  ADD PRIMARY KEY (`image_ID`,`gallery_ID`),
  ADD KEY `image_ID` (`image_ID`,`gallery_ID`),
  ADD KEY `gallery_ID` (`gallery_ID`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`user_ID`,`img_ID`),
  ADD KEY `user_ID` (`user_ID`,`img_ID`),
  ADD KEY `img_ID` (`img_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`image_ID`) REFERENCES `images` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `galleries`
--
ALTER TABLE `galleries`
  ADD CONSTRAINT `galleries_ibfk_1` FOREIGN KEY (`owner_ID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`owner_ID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `img_in_gal`
--
ALTER TABLE `img_in_gal`
  ADD CONSTRAINT `img_in_gal_ibfk_1` FOREIGN KEY (`image_ID`) REFERENCES `images` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `img_in_gal_ibfk_2` FOREIGN KEY (`gallery_ID`) REFERENCES `galleries` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`img_ID`) REFERENCES `images` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
