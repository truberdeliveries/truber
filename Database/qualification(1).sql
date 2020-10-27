-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2019 at 08:10 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qualification`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `adminID` int(11) NOT NULL,
  `firstname` varchar(80) NOT NULL,
  `lastname` varchar(80) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(80) NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`adminID`, `firstname`, `lastname`, `email`, `password`, `date_created`) VALUES
(1, 'Sthembiso', 'Langa', 'langa@gmail.com', 'password', '2019-08-27'),
(2, 'Kamo', 'Zwane', 'kamo@gmail.com', 'password', '2019-06-01');

-- --------------------------------------------------------

--
-- Table structure for table `comparison`
--

CREATE TABLE `comparison` (
  `comparisonID` int(11) NOT NULL,
  `empID` int(20) NOT NULL,
  `qualification` varchar(80) NOT NULL,
  `experience` varchar(80) NOT NULL,
  `location` varchar(80) NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employer`
--

CREATE TABLE `employer` (
  `id` int(11) NOT NULL,
  `firstname` varchar(80) NOT NULL,
  `lastname` varchar(80) NOT NULL,
  `companyName` varchar(80) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(80) NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employer`
--

INSERT INTO `employer` (`id`, `firstname`, `lastname`, `companyName`, `email`, `password`, `date_created`) VALUES
(1, 'Shingo', 'Mogale', 'Langa Traders', 'sthembiso95@gmail.com', 'password', '2019-08-31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(100) NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `firstname`, `lastname`, `email`, `password`, `date_created`) VALUES
(5, 'Gmanrulez', 'George', 'Mahlangu', 'givenmatibe@gmail.com', 'password', '2019-08-31'),
(8, 'George_lee', 'George', 'Mahlangu', 'george@gmail.com', 'password', '2019-08-31');

-- --------------------------------------------------------

--
-- Table structure for table `vacancies`
--

CREATE TABLE `vacancies` (
  `vacancyID` int(11) NOT NULL,
  `empID` int(11) NOT NULL,
  `title` varchar(80) NOT NULL,
  `company` varchar(80) NOT NULL,
  `description` varchar(80) NOT NULL,
  `requirements` varchar(80) NOT NULL,
  `date_posted` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vacancies`
--

INSERT INTO `vacancies` (`vacancyID`, `empID`, `title`, `company`, `description`, `requirements`, `date_posted`) VALUES
(1, 0, 'Information Technology', 'Langa Traders', '0', '0', '2019-08-31'),
(2, 0, 'Information Technology', 'Langa Traders', '0', '0', '2019-08-31'),
(3, 1, 'Information Technology', 'Langa Traders', '0', '0', '2019-08-31'),
(4, 1, 'Information Technology', 'Langa Traders', 'Information Technology graduates with NQF 5 Can Apply', 'Grade 12, NQF 5', '2019-08-31'),
(5, 1, 'Engineering', 'Langa Traders', 'Yes it thend', 'ascsdvsdv', '2019-08-31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `comparison`
--
ALTER TABLE `comparison`
  ADD PRIMARY KEY (`comparisonID`);

--
-- Indexes for table `employer`
--
ALTER TABLE `employer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vacancies`
--
ALTER TABLE `vacancies`
  ADD PRIMARY KEY (`vacancyID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `comparison`
--
ALTER TABLE `comparison`
  MODIFY `comparisonID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employer`
--
ALTER TABLE `employer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `vacancies`
--
ALTER TABLE `vacancies`
  MODIFY `vacancyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
