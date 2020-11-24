-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2020 at 02:19 PM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `truber`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`id`, `firstname`, `lastname`, `email`, `mobile`, `password`, `date_created`) VALUES
(1, 'Rose', 'Baloyi', 'rose@gmail.com', '0612345678', 'password', '2020-02-25');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `book_id` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `start_address` varchar(500) NOT NULL,
  `end_address` varchar(500) NOT NULL,
  `coordinates` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `cust_id` varchar(255) NOT NULL,
  `driver_id` varchar(255) NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `vehicle_type` varchar(255) NOT NULL,
  `booking_status` int(11) NOT NULL,
  `driver_coord` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`book_id`, `start_time`, `end_time`, `start_address`, `end_address`, `coordinates`, `date`, `cust_id`, `driver_id`, `payment_type`, `vehicle_type`, `booking_status`, `driver_coord`) VALUES
(4, '00:00:00', '00:00:00', '3781/34 Sisulu Street, Tembisa, South Africa', 'Tembisa, South Africa', '-26.046172,28.186128|-26.008881,28.21233', '2020-11-24', '6', '4', '1234567890', '1_Ton', 4, '');

-- --------------------------------------------------------

--
-- Table structure for table `card`
--

CREATE TABLE `card` (
  `id` int(11) NOT NULL,
  `bankname` varchar(100) NOT NULL,
  `cardnumber` varchar(100) NOT NULL,
  `branch` varchar(100) NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `card`
--

INSERT INTO `card` (`id`, `bankname`, `cardnumber`, `branch`, `date_created`) VALUES
(6, 'standard-bank', '1234567890', '051001', '2020-11-23'),
(6, 'nedbank', '1234567890', '198765', '2020-11-23');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `date_created` date NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `firstname`, `lastname`, `email`, `mobile`, `password`, `date_created`, `photo`) VALUES
(2, 'George', 'Mahlangu', 'given@gmail.com', '0823207253', 'password', '2020-02-25', ''),
(5, 'Kabelo', 'Letsoalo', 'kabelo2@gmail.com', '0715268899', 'password', '2020-02-26', ''),
(6, 'fana', 'bila', 'gd@gmail.comzz', '0822222222', '12345', '2020-10-25', 'test.jpg'),
(7, 'll', 'kk', 'gda@gmail.com', '0800000000', '1234@Abc', '2020-10-25', ''),
(8, 'jj', 'j', 'goldwinfana5@gmail.com', '0800000000', '1234@Abcd', '2020-10-25', ''),
(9, 'k', 'kk', 'gda@gmail.comk', '0800000000', '1234@Abc', '2020-10-25', ''),
(11, 'll', 'jn', 'gdss@gmail.com', '0800000000', '1234@Abc', '2020-10-25', ''),
(12, 'beee', 'beees', 'gd@gmail.com', '0617235213', '12345', '2020-10-25', ''),
(14, 'rambo', 'john', 'gold@gmail.com', '0831234566', '1234@Abc', '2020-10-27', '');

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE `driver` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `date_registered` date NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `driver`
--

INSERT INTO `driver` (`id`, `firstname`, `lastname`, `email`, `mobile`, `password`, `date_registered`, `photo`) VALUES
(2, 'Erick', 'Gumede', 'sipho@gmail.com', '0856521123', 'password', '2020-02-25', 'truck.jpg'),
(5, 'fana', 'john', 'goldwin@gmail.com', '0610123456', '1234@Abc', '2020-10-31', '');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` varchar(30) NOT NULL,
  `date_created` timestamp NULL DEFAULT current_timestamp(),
  `customer_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `distance_km` double NOT NULL,
  `vehicle_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`invoice_id`, `date_created`, `customer_id`, `driver_id`, `amount`, `distance_km`, `vehicle_type`) VALUES
('Trub#GihC9v', '2020-11-24 10:03:52', 6, 2, 282, 3.3, 'Mini Van');

-- --------------------------------------------------------

--
-- Table structure for table `reason`
--

CREATE TABLE `reason` (
  `matter_id` int(11) NOT NULL,
  `reasons` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reason`
--

INSERT INTO `reason` (`matter_id`, `reasons`) VALUES
(4, 'Driver asked me to cancel.');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `name`) VALUES
(0, 'pending'),
(1, 'accepted'),
(2, 'picked'),
(3, 'finished'),
(4, 'cancelled');

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `base_price` int(11) NOT NULL,
  `price_per_km` int(11) NOT NULL,
  `image` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`id`, `name`, `base_price`, `price_per_km`, `image`) VALUES
(0, 'MiniVan', 230, 16, 'minivan.png'),
(1, '1_Ton', 374, 23, '1ton.png'),
(2, '1.5_Ton', 460, 28, '1.5ton.png'),
(3, '4_Ton', 2300, 46, '4ton.png'),
(4, '8_Ton', 4600, 54, '8ton.png');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `id` int(11) NOT NULL,
  `reg_number` varchar(20) NOT NULL,
  `type` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `model` varchar(255) NOT NULL,
  `driver_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`id`, `reg_number`, `type`, `name`, `model`, `driver_id`) VALUES
(1, '213r4234r3f', 'MiniVan', 'Hondai', '2018', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `driver`
--
ALTER TABLE `driver`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `reg_number` (`reg_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `driver`
--
ALTER TABLE `driver`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
