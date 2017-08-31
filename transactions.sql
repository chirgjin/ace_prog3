-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 31, 2017 at 02:11 PM
-- Server version: 5.6.35
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pokedawn_ace`
--

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `trans_id` varchar(150) NOT NULL,
  `items` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`trans_id`, `items`) VALUES
('1837487', 'Cold Drink,Chips'),
('23425435', 'Cold Drink'),
('2p45', 'Pepsie,Dew,Coke'),
('2p45e3e', 'Pepsie,Dew'),
('3254656', 'Chips,Coke,Maggie'),
('438098rtjjy', 'Sugar,Tea,Coffee'),
('438098rtjjy3', 'Pepsie,Coke,Dew'),
('438098rtjjy34', 'Coke,Tea,Coffee'),
('59a7c7d6cbdcd', 'Coffee,Sugar,Milk'),
('59a7d2e2b5405', 'Coffee,Sugar,Milk'),
('59a7d2e8af74a', 'Coffee,Sugar,Milk'),
('59a7d2f153f8a', 'Sugar,Milk,Coffee,Tea'),
('59a7d325e32e5', 'Milk,Tea,Coffee'),
('59a7d32a5344c', 'Milk,Tea,Coffee,Sugar'),
('59a7d33391204', 'Milk,Tea,Coffee,Sugar,Apple'),
('59a7d345c054e', 'Chips,Milk,Tea,Coffee,Sugar,Apple'),
('AxBx2e', 'Cold Drink,Milk'),
('eetrpoi0', 'Milk,Maggie,Coffee'),
('eetrpoi1', 'Chips,Coke,Maggie'),
('eetrpoi2', 'Chips,Maggie,Coke'),
('eetrpoi3', 'Coke,Maggie'),
('eetrpoi4', 'Chips,Coke,Maggie'),
('ewkerjkj', 'Cold Drink');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`trans_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
