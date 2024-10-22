-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2023 at 11:47 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: library
--

-- --------------------------------------------------------

--
-- Table structure for table admin
--

CREATE TABLE admin (
  username varchar(50) NOT NULL,
  password varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table admin
--

INSERT INTO admin (username, password) VALUES
('rishav', '12345'),
('shreesh', '12345'),
('tanishk', '12345'),
('aditya', '12345');

-- --------------------------------------------------------

--
-- Table structure for table authors
--

CREATE TABLE authors (
  BookID int(11) DEFAULT NULL,
  AuthorName varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table authors
--

INSERT INTO authors (BookID, AuthorName) VALUES
(102, 'Amrita Pritam'),
(103, 'Amrita Pritam'),
(104, 'Charles Darwin'),
(105, 'charles Darwin'),
(106, 'Mohan Rakesh'),
(107, 'Bankim C chatarjee'),
(101, 'William Shakespeare'),
(108, 'Jerome.k.Jerome');

-- --------------------------------------------------------

--
-- Table structure for table books
--

CREATE TABLE books (
  BookID int(11) NOT NULL,
  Title varchar(30) DEFAULT NULL,
  PublisherName varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table books
--

INSERT INTO books (BookID, Title, PublisherName) VALUES
(101, 'Julius Caesar', 'bharati'),
(102, 'A revenue stamp', 'westland'),
(103, 'Pinjar', 'penguin random'),
(104, 'Tale of two cities', 'roli'),
(105, 'Oliver Twist', 'rupa'),
(106, 'Aadhe Adhure', 'rupa'),
(107, 'Anand Math', 'jaico'),
(108, 'Three Men in a boat', 'universal');

-- --------------------------------------------------------

--
-- Table structure for table copies
--

CREATE TABLE copies (
  BookID int(11) DEFAULT NULL,
  Genre varchar(40) DEFAULT NULL,
  No_Of_Copies int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table copies
--

INSERT INTO copies (BookID, Genre, No_Of_Copies) VALUES
(102, 'autobiography', 3),
(103, 'social novel', 6),
(104, 'historical fiction', 2),
(105, 'fiction', 1),
(106, 'Soap opera', 9),
(107, 'historical fiction', 12),
(101, 'Political drama', 10),
(108, 'Comedy Novel', 15);

-- --------------------------------------------------------

--
-- Table structure for table prices
--

CREATE TABLE prices (
  BookID int(11) NOT NULL,
  price int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table prices
--

INSERT INTO prices (BookID, price) VALUES
(101, 500),
(102, 450),
(103, 350),
(104, 300),
(105, 400),
(106, 600),
(107, 375),
(108, 300);

-- --------------------------------------------------------

--
-- Table structure for table purchases
--

CREATE TABLE purchases (
  customer_name varchar(50) NOT NULL,
  BookID int(11) NOT NULL,
  Purchase_date date NOT NULL,
  count int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table purchases
--

INSERT INTO purchases (customer_name, BookID, Purchase_date, count) VALUES
('parasar', 105, '2023-04-08', 2),
('rishav', 101, '2023-04-07', 2),
('Rishav Parasar', 101, '2023-04-08', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table authors
--
ALTER TABLE authors
  ADD KEY BookID (BookID);

--
-- Indexes for table books
--
ALTER TABLE books
  ADD PRIMARY KEY (BookID);

--
-- Indexes for table copies
--
ALTER TABLE copies
  ADD KEY BookID (BookID);

--
-- Indexes for table prices
--
ALTER TABLE prices
  ADD KEY BookID (BookID);

--
-- Indexes for table purchases
--
ALTER TABLE purchases
  ADD PRIMARY KEY (customer_name),
  ADD KEY BookID (BookID);

--
-- Constraints for dumped tables
--

--
-- Constraints for table authors
--
ALTER TABLE authors
  ADD CONSTRAINT authors_ibfk_1 FOREIGN KEY (BookID) REFERENCES books (BookID);

--
-- Constraints for table copies
--
ALTER TABLE copies
  ADD CONSTRAINT copies_ibfk_1 FOREIGN KEY (BookID) REFERENCES books (BookID);

--
-- Constraints for table prices
--
ALTER TABLE prices
  ADD CONSTRAINT prices_ibfk_1 FOREIGN KEY (BookID) REFERENCES books (BookID);

--
-- Constraints for table purchases
--
ALTER TABLE purchases
  ADD CONSTRAINT purchases_ibfk_1 FOREIGN KEY (BookID) REFERENCES books (BookID);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
