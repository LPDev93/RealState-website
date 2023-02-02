-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2023 at 06:42 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `home_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `password`) VALUES
('BcjKNX58e4x7bIqIvxG7', 'admin', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` varchar(10) NOT NULL,
  `message` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `property`
--

CREATE TABLE `property` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `property_name` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `price` varchar(10) NOT NULL,
  `type` varchar(10) NOT NULL,
  `offer` varchar(10) NOT NULL,
  `status` varchar(50) NOT NULL,
  `furnished` varchar(50) NOT NULL,
  `bhk` varchar(10) NOT NULL,
  `deposite` varchar(10) NOT NULL,
  `bedroom` varchar(10) NOT NULL,
  `bathroom` varchar(10) NOT NULL,
  `balcony` varchar(10) NOT NULL,
  `carpet` varchar(10) NOT NULL,
  `age` varchar(2) NOT NULL,
  `total_floors` varchar(2) NOT NULL,
  `room_floor` varchar(2) NOT NULL,
  `loan` varchar(50) NOT NULL,
  `lift` varchar(3) NOT NULL DEFAULT 'no',
  `security_guard` varchar(3) NOT NULL DEFAULT 'no',
  `play_ground` varchar(3) NOT NULL DEFAULT 'no',
  `garden` varchar(3) NOT NULL DEFAULT 'no',
  `water_supply` varchar(3) NOT NULL DEFAULT 'no',
  `power_backup` varchar(3) NOT NULL DEFAULT 'no',
  `parking_area` varchar(3) NOT NULL DEFAULT 'no',
  `gym` varchar(3) NOT NULL DEFAULT 'no',
  `shopping_mall` varchar(3) NOT NULL DEFAULT 'no',
  `hospital` varchar(3) NOT NULL DEFAULT 'no',
  `school` varchar(3) NOT NULL DEFAULT 'no',
  `market_area` varchar(3) NOT NULL DEFAULT 'no',
  `image_01` varchar(50) NOT NULL,
  `image_02` varchar(50) NOT NULL,
  `image_03` varchar(50) NOT NULL,
  `image_04` varchar(50) NOT NULL,
  `image_05` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`id`, `user_id`, `property_name`, `address`, `price`, `type`, `offer`, `status`, `furnished`, `bhk`, `deposite`, `bedroom`, `bathroom`, `balcony`, `carpet`, `age`, `total_floors`, `room_floor`, `loan`, `lift`, `security_guard`, `play_ground`, `garden`, `water_supply`, `power_backup`, `parking_area`, `gym`, `shopping_mall`, `hospital`, `school`, `market_area`, `image_01`, `image_02`, `image_03`, `image_04`, `image_05`, `description`, `date`) VALUES
('OskuD7poGVNZiTJuu6OV', 'H2YdhHWLbZuAmSiLmhHt', 'Casa de tres pisos amoblada para una familia', 'Calle Los Ganzos 666, Surquillo', '250000', 'house', 'sale', 'ready to move', 'furnished', '5', '25000', '5', '6', '2', '50', '10', '4', '1', 'available', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'no', 'no', 'no', 'cYcT3rLmttBc7uP3q6Pj.jpg', 'YQz5u3ITxyBRdqcskwRW.jpg', 'fzfEB86Jj9QnSiESzJtx.jpg', 'T8ndyC6K3TTIAtSFRsj1.jpg', 'm41AI7JXJfs4tBbGDswn.jpg', 'Casa de tres pisos ubicado en la zona administrativa entre Surquillo y San Isidro.', '2023-02-01'),
('O12zggCLRTKLkUmHu4ex', 'H2YdhHWLbZuAmSiLmhHt', 'Departamento para ideal para una pareja', 'Av. Arenales 1040, Lince', '75000', 'flat', 'sale', 'under construction', 'unfurnished', '3', '7500', '2', '3', '1', '25', '1', '1', '1', 'available', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'no', 'no', 'IDe0uKIGl9MvMHfF9aSu.jpg', '43N3cJvGwbFqEB6ixgC2.jpg', 'YIYx8FKAWQGkLzYte9UK.jpg', 'a2QKXYa94U5aHGbtt5AO.jpg', '', 'Departamento de ensueño para pareja ubicado en una zona comercial y cerca de una avenida principal.', '2023-02-01'),
('BVwZ1HNehHWmFzzz8EmJ', 'jBjlPgHjByD1uAvckOwt', 'Departamento para una persona', 'Los Leones 1213, San Isidro', '1500', 'flat', 'rent', 'under construction', 'semi-furnished', '1', '0', '1', '1', '1', '10', '5', '1', '1', 'not available', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'no', 'no', 'no', 'no', 'no', 'AZvCgfhrLv6A0XTMCC0Y.jpg', 'GiAaU25p9eztyQfRxmqS.jpg', 'sgIUkZ2wq3CRaAggnLfA.jpg', '', '', 'Departamento ubicado en la mejor zona comercial. Viene con una cama y un tocador largo.', '2023-02-01'),
('pKIqWFv9DxM89v9FzKl7', 'jBjlPgHjByD1uAvckOwt', 'Departamentos de estreno para familia y mascota', 'Calle Los Gatos 1204, San Borja', '150000', 'flat', 'sale', 'ready to move', 'unfurnished', '3', '20000', '3', '4', '1', '35', '1', '1', '1', 'not available', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'no', 'no', '3zHZ6Xf3g6cdIiMqRqKY.jpg', 'QmZcvHgwh4Zmp2bMhPKO.jpg', '', '', '', 'Departamentos en estreno en una zona con vegatación en San Borja. Ideal para una familia pequeña.', '2023-02-01');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` varchar(20) NOT NULL,
  `property_id` varchar(20) NOT NULL,
  `sender` varchar(20) NOT NULL,
  `receiver` varchar(20) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `property_id`, `sender`, `receiver`, `date`) VALUES
('nV9d1ivAsmLEGOgdOnxn', 'OskuD7poGVNZiTJuu6OV', 'jBjlPgHjByD1uAvckOwt', 'H2YdhHWLbZuAmSiLmhHt', '2023-02-01'),
('DmPlE6y12HIeAWqDkaqD', 'pKIqWFv9DxM89v9FzKl7', 'H2YdhHWLbZuAmSiLmhHt', 'jBjlPgHjByD1uAvckOwt', '2023-02-02'),
('VH4ImsXNOquwq5ZR0sxG', 'BVwZ1HNehHWmFzzz8EmJ', 'H2YdhHWLbZuAmSiLmhHt', 'jBjlPgHjByD1uAvckOwt', '2023-02-02');

-- --------------------------------------------------------

--
-- Table structure for table `saved`
--

CREATE TABLE `saved` (
  `id` varchar(20) NOT NULL,
  `property_id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `saved`
--

INSERT INTO `saved` (`id`, `property_id`, `user_id`) VALUES
('eU7LWQTUMmXWkvkytFSf', 'OskuD7poGVNZiTJuu6OV', 'jBjlPgHjByD1uAvckOwt'),
('xYTrlEWcV1KiLaUcNfAh', 'pKIqWFv9DxM89v9FzKl7', 'H2YdhHWLbZuAmSiLmhHt'),
('HqPv988KeLysIElM5lmf', 'BVwZ1HNehHWmFzzz8EmJ', 'H2YdhHWLbZuAmSiLmhHt');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `number`, `email`, `password`) VALUES
('H2YdhHWLbZuAmSiLmhHt', 'Luigui Albertti', '966230373', 'lparodi@preciso.pe', 'ca2e74914607b8c1c8d6a9893daf38d3daf88a49'),
('jBjlPgHjByD1uAvckOwt', 'Prueba', '123456789', 'prueba@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
