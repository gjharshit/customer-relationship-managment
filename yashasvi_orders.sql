-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2017 at 11:24 AM
-- Server version: 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yashasvi_orders`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer_po`
--

DROP TABLE IF EXISTS `customer_po`;
CREATE TABLE IF NOT EXISTS `customer_po` (
  `comp_name` varchar(20) DEFAULT NULL,
  `comp_address` varchar(50) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `fin_contact_person` varchar(20) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `other` varchar(50) DEFAULT NULL,
  `order_value` varchar(10) DEFAULT NULL,
  `purchase_value` varchar(10) DEFAULT NULL,
  `margin` varchar(10) DEFAULT NULL,
  `billing_type` varchar(20) DEFAULT NULL,
  `cust_yash_date` date DEFAULT NULL,
  `payment_mode` varchar(20) DEFAULT NULL,
  `yash_inv_number` varchar(20) NOT NULL,
  `yash_inv_value` varchar(20) DEFAULT NULL,
  `yash_inv_date` date DEFAULT NULL,
  `remarks` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`yash_inv_number`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_po`
--

INSERT INTO `customer_po` (`comp_name`, `comp_address`, `city`, `pincode`, `fin_contact_person`, `phone`, `email`, `other`, `order_value`, `purchase_value`, `margin`, `billing_type`, `cust_yash_date`, `payment_mode`, `yash_inv_number`, `yash_inv_value`, `yash_inv_date`, `remarks`) VALUES
('Bosch', 'Kormangala', 'Bangalore', '560078', 'Sujay', '9994031611', 'sujaysanjeev.patil@gmail.com', 'Nothing', '1', '1', '1', 'vat', '2017-01-01', 'advance', '1', '1', '2017-01-02', 'Nothing'),
('ESI', 'Jayanagar', 'Bangalore', '560068', 'Sujay', '9994031611', 'sujaysanjeev.patil@gmail.com', 'Nothing', '2', '2', '2', 'vat', '2017-01-02', 'advance', '2', '2', '2017-01-12', 'Nothing'),
('Bosch', 'a', 'Bangalore', 'sujay', 'sujay', '991', 'sujaysanjeev.patil@gmail.com', 'sujay', '2', '2', '2', 'vat_st', '2017-01-01', 'against_delivery', '18', '2', '2017-01-12', 'b'),
('Bosch', 'Nothing', 'Bangalore', '560068', 'Sujay', '991', 'abc@xyz.com', 'Nothing', '1', '1', '1', 'st', '2017-01-01', 'against_delivery', '23', '2', '2017-01-12', 'Nothing');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(30) NOT NULL,
  `userEmail` varchar(60) NOT NULL,
  `userPass` varchar(255) NOT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `userEmail` (`userEmail`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `userName`, `userEmail`, `userPass`) VALUES
(8, 'sujay', 'abc@wxyz.com', '03dd17de03803ed7e5224688a528c2fbb7b2bfe36ef619092b460ca640ab24c2');

-- --------------------------------------------------------

--
-- Table structure for table `yashasvi_po`
--

DROP TABLE IF EXISTS `yashasvi_po`;
CREATE TABLE IF NOT EXISTS `yashasvi_po` (
  `dist_name` varchar(20) DEFAULT NULL,
  `oem_name` varchar(20) DEFAULT NULL,
  `comp_address` varchar(20) DEFAULT NULL,
  `order_value` varchar(20) DEFAULT NULL,
  `purchase_value` varchar(20) DEFAULT NULL,
  `margin` varchar(20) DEFAULT NULL,
  `billing_type` varchar(20) DEFAULT NULL,
  `payment_due` date DEFAULT NULL,
  `payment_mode` varchar(20) DEFAULT NULL,
  `disti_inv_number` varchar(20) NOT NULL,
  `disti_inv_value` varchar(20) DEFAULT NULL,
  `disti_inv_date` date DEFAULT NULL,
  `remarks` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`disti_inv_number`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `yashasvi_po`
--

INSERT INTO `yashasvi_po` (`dist_name`, `oem_name`, `comp_address`, `order_value`, `purchase_value`, `margin`, `billing_type`, `payment_due`, `payment_mode`, `disti_inv_number`, `disti_inv_value`, `disti_inv_date`, `remarks`) VALUES
('Ingram', 'Something', 'A', 'sujay', 'sujay', 'sujay', 'st', '2017-01-03', 'advance', '2', '2', '2017-01-04', 'B'),
('Ingram', 'Something', 'Something', '1', '1', '1', 'vat', '2017-01-01', 'advance', '4', '2', '2017-01-03', 'Something'),
('Ingram', 'Something', 'Something', '3', '3', '3', 'vat', '2017-01-03', 'advance', '5', '2', '2017-01-03', 'Something'),
('Ingram', 'Something', 'Something', '2', '2', '2', 'st', '2017-01-03', 'advance', '7', '2', '2017-01-03', 'Something'),
('Ingram', 'Something', 'Something', '1', '1', '1', 'vat', '2017-01-03', 'advance', '8', '2', '2017-01-04', 'Something');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
