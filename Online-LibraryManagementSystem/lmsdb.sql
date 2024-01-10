-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2020 at 02:26 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lmsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(100) NOT NULL,
  `first` varchar(100) NOT NULL,
  `last` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `first`, `last`, `username`, `password`, `email`, `contact`) VALUES
(3, 'Admin', 'Admin', 'librarian', '$2y$10$cu.Yldq2RGYFnLk2ajmoyuK7.85TdfcjJ6WufTlaaLHjshbu5nUB6', 'niteshpkpc@gmail.com', '01234567890');




--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `bookID` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `authors` varchar(100) NOT NULL,
  `edition` varchar(100) NOT NULL,
  `publisher` varchar(100) NOT NULL,
  `price` decimal(65,2) NOT NULL,
  `quantity` int(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `purchaseDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`bookID`, `name`, `authors`, `edition`, `publisher`, `price`, `quantity`, `department`, `purchaseDate`) VALUES
(1, 'Beginning Oracle SQL', 'Ben Brumm', '1st ed', 'Apress (August 6, 2019)', '27.49', 25, 'database', '2020-07-07'),
(3, 'PHP and MySQL web development', 'Welling, Luke, 1972- author; Thomson, Laura,', 'Fifth edition', 'Hoboken, NJ: Addison-Wesley, [2017]', '30.25', 20, 'Computer program language', '2020-07-06'),
(5, 'Professional ASP.NET MVC 5', 'Jon Galloway, Brad Wilson, K. Scott Allen, David Matson', 'Pap/Psc edition', 'Wrox (12 Sept. 2014)', '22.29', 21, 'Computer program language', '2020-07-07'),
(6, 'Professional JavaScript for Web Developers', 'Matt Frisbie', '4th edition', 'Wrox (25 Nov. 2019)', '26.30', 20, 'Computer program language', '2020-07-02');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `comments` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fines`
--

CREATE TABLE `fines` (
  `fineID` int(11) NOT NULL,
  `returnID` int(11) NOT NULL,
  `daysOver` int(11) NOT NULL,
  `totalFine` decimal(65,2) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `issued_book`
--

CREATE TABLE `issued_book` (
  `issueID` int(11) NOT NULL,
  `requestID` int(11) NOT NULL,
  `librarianID` int(11) NOT NULL,
  `issue_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `requested_book`
--

CREATE TABLE `requested_book` (
  `requestID` int(11) NOT NULL,
  `studentID` int(11) NOT NULL,
  `bookID` int(11) NOT NULL,
  `request_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `returned_book`
--

CREATE TABLE `returned_book` (
  `returnID` int(11) NOT NULL,
  `issueID` int(11) NOT NULL,
  `librarianID` int(11) NOT NULL,
  `returnedDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `studentID` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `enrollmentNo` int(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`bookID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fines`
--
ALTER TABLE `fines`
  ADD PRIMARY KEY (`fineID`),
  ADD KEY `returnID` (`returnID`);

--
-- Indexes for table `issued_book`
--
ALTER TABLE `issued_book`
  ADD PRIMARY KEY (`issueID`),
  ADD KEY `librarianID` (`librarianID`),
  ADD KEY `requestID` (`requestID`);

--
-- Indexes for table `requested_book`
--
ALTER TABLE `requested_book`
  ADD PRIMARY KEY (`requestID`),
  ADD KEY `studentID` (`studentID`),
  ADD KEY `bookID` (`bookID`);

--
-- Indexes for table `returned_book`
--
ALTER TABLE `returned_book`
  ADD PRIMARY KEY (`returnID`),
  ADD KEY `issueID` (`issueID`),
  ADD KEY `librarianID` (`librarianID`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`studentID`),
  ADD UNIQUE KEY `EnrollmentNo` (`enrollmentNo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `bookID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fines`
--
ALTER TABLE `fines`
  MODIFY `fineID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `issued_book`
--
ALTER TABLE `issued_book`
  MODIFY `issueID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `requested_book`
--
ALTER TABLE `requested_book`
  MODIFY `requestID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `returned_book`
--
ALTER TABLE `returned_book`
  MODIFY `returnID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `studentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fines`
--
ALTER TABLE `fines`
  ADD CONSTRAINT `fines_ibfk_1` FOREIGN KEY (`returnID`) REFERENCES `returned_book` (`returnID`);

--
-- Constraints for table `issued_book`
--
ALTER TABLE `issued_book`
  ADD CONSTRAINT `issued_book_ibfk_1` FOREIGN KEY (`librarianID`) REFERENCES `admin` (`id`),
  ADD CONSTRAINT `issued_book_ibfk_2` FOREIGN KEY (`requestID`) REFERENCES `requested_book` (`requestID`);

--
-- Constraints for table `requested_book`
--
ALTER TABLE `requested_book`
  ADD CONSTRAINT `requested_book_ibfk_1` FOREIGN KEY (`studentID`) REFERENCES `students` (`studentID`),
  ADD CONSTRAINT `requested_book_ibfk_2` FOREIGN KEY (`bookID`) REFERENCES `books` (`bookID`);

--
-- Constraints for table `returned_book`
--
ALTER TABLE `returned_book`
  ADD CONSTRAINT `returned_book_ibfk_1` FOREIGN KEY (`issueID`) REFERENCES `issued_book` (`issueID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
