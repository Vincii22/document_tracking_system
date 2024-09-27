-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2024 at 05:01 PM
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
-- Database: `evaluation_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_list`
--

CREATE TABLE `academic_list` (
  `id` int(30) NOT NULL,
  `year` text NOT NULL,
  `semester` int(30) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '0=Pending,1=Start,2=Closed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `academic_list`
--

INSERT INTO `academic_list` (`id`, `year`, `semester`, `is_default`, `status`) VALUES
(1, '2019-2020', 1, 0, 2),
(2, '2019-2020', 2, 0, 2),
(3, '2020-2021', 1, 0, 2),
(4, '2024-2025', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `class_list`
--

CREATE TABLE `class_list` (
  `id` int(30) NOT NULL,
  `curriculum` text NOT NULL,
  `level` text NOT NULL,
  `section` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_list`
--

INSERT INTO `class_list` (`id`, `curriculum`, `level`, `section`) VALUES
(1, 'BSIT', '1', 'A'),
(2, 'BSIT', '1', 'B'),
(3, 'BSIT', '1', 'C');

-- --------------------------------------------------------

--
-- Table structure for table `criteria_list`
--

CREATE TABLE `criteria_list` (
  `id` int(30) NOT NULL,
  `criteria` text NOT NULL,
  `order_by` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `criteria_list`
--

INSERT INTO `criteria_list` (`id`, `criteria`, `order_by`) VALUES
(9, 'INSTRUCTIONAL SKILL', 1),
(10, 'SUBJECT MATTER', 0),
(11, 'CLASSROOM MANAGEMENT', 2),
(12, 'PERSONAL QUALITY', 3);

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_answers`
--

CREATE TABLE `evaluation_answers` (
  `evaluation_id` int(30) NOT NULL,
  `question_id` int(30) NOT NULL,
  `rate` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `evaluation_answers`
--

INSERT INTO `evaluation_answers` (`evaluation_id`, `question_id`, `rate`) VALUES
(1, 1, 5),
(1, 6, 4),
(1, 3, 5),
(2, 1, 5),
(2, 6, 5),
(2, 3, 4),
(3, 1, 5),
(3, 6, 5),
(3, 3, 4),
(4, 1, 4),
(4, 6, 3),
(4, 3, 3),
(4, 7, 3),
(5, 8, 5),
(5, 9, 5),
(5, 10, 5),
(5, 11, 5),
(6, 8, 5),
(6, 9, 5),
(6, 10, 5),
(6, 11, 5),
(7, 8, 5),
(7, 9, 5),
(7, 10, 5),
(7, 11, 5),
(8, 8, 5),
(8, 9, 5),
(8, 10, 5),
(8, 11, 5),
(9, 8, 5),
(9, 9, 5),
(9, 10, 5),
(9, 11, 5),
(10, 8, 5),
(10, 9, 5),
(10, 10, 5),
(10, 11, 5),
(11, 8, 5),
(11, 9, 5),
(11, 10, 5),
(11, 11, 5),
(12, 8, 5),
(12, 9, 5),
(12, 10, 5),
(12, 11, 5),
(13, 8, 5),
(13, 9, 5),
(13, 10, 5),
(13, 11, 5),
(14, 8, 5),
(14, 9, 5),
(14, 10, 5),
(14, 11, 5),
(15, 8, 5),
(15, 9, 5),
(15, 10, 5),
(15, 11, 5),
(16, 8, 5),
(16, 9, 5),
(16, 10, 5),
(16, 11, 5),
(17, 8, 5),
(17, 9, 5),
(17, 10, 5),
(17, 11, 5),
(18, 8, 5),
(18, 9, 5),
(18, 10, 5),
(18, 11, 5),
(19, 8, 5),
(19, 9, 5),
(19, 10, 5),
(19, 11, 5),
(20, 8, 5),
(20, 9, 5),
(20, 10, 5),
(20, 11, 5),
(21, 8, 5),
(21, 9, 5),
(21, 10, 5),
(21, 11, 5),
(22, 8, 5),
(22, 9, 5),
(22, 10, 5),
(22, 11, 5),
(23, 8, 5),
(23, 9, 5),
(23, 10, 5),
(23, 11, 5),
(24, 8, 5),
(24, 9, 5),
(24, 10, 5),
(24, 11, 5),
(25, 8, 5),
(25, 9, 5),
(25, 10, 5),
(25, 11, 5),
(26, 8, 5),
(26, 9, 5),
(26, 10, 5),
(26, 11, 5),
(27, 8, 5),
(27, 9, 5),
(27, 10, 5),
(27, 11, 5),
(28, 8, 5),
(28, 9, 5),
(28, 10, 5),
(28, 11, 5),
(29, 8, 5),
(29, 9, 5),
(29, 10, 5),
(29, 11, 5),
(30, 8, 5),
(30, 9, 5),
(30, 10, 5),
(30, 11, 5),
(31, 8, 5),
(31, 9, 5),
(31, 10, 5),
(31, 11, 5),
(32, 8, 5),
(32, 9, 5),
(32, 10, 5),
(32, 11, 5),
(33, 8, 5),
(33, 9, 5),
(33, 10, 5),
(33, 11, 5),
(34, 8, 5),
(34, 9, 5),
(34, 10, 5),
(34, 11, 5),
(35, 8, 5),
(35, 9, 5),
(35, 10, 5),
(35, 11, 5),
(36, 8, 5),
(36, 9, 5),
(36, 10, 5),
(36, 11, 5),
(37, 8, 5),
(38, 8, 5),
(39, 8, 5),
(39, 9, 5),
(39, 10, 5),
(39, 11, 5),
(40, 8, 5),
(40, 9, 5),
(40, 10, 5),
(40, 11, 5),
(41, 8, 5),
(41, 9, 5),
(41, 10, 5),
(41, 11, 5),
(42, 8, 5),
(43, 8, 5),
(44, 8, 5),
(45, 8, 5),
(46, 8, 5),
(46, 9, 5),
(47, 8, 5),
(47, 9, 5),
(47, 10, 5),
(47, 11, 5),
(48, 8, 5),
(48, 9, 5),
(49, 8, 5),
(49, 9, 5),
(50, 8, 5),
(51, 8, 5),
(52, 8, 5),
(53, 8, 5),
(54, 8, 5),
(55, 8, 5),
(55, 9, 5),
(56, 8, 5),
(56, 9, 5),
(57, 8, 5),
(58, 8, 5),
(58, 9, 5),
(58, 10, 5),
(58, 11, 5),
(59, 8, 5),
(59, 9, 5),
(59, 10, 5),
(59, 11, 5),
(60, 8, 5),
(60, 9, 5),
(60, 10, 5),
(60, 11, 5),
(61, 8, 5),
(61, 9, 5),
(61, 10, 5),
(61, 11, 5),
(62, 8, 5),
(62, 9, 5),
(62, 10, 5),
(63, 12, 5),
(63, 13, 5),
(63, 14, 5),
(63, 15, 5),
(63, 16, 5),
(63, 22, 5),
(63, 23, 5),
(63, 24, 5),
(63, 25, 5),
(63, 26, 5),
(63, 17, 5),
(63, 19, 5),
(63, 27, 5),
(63, 28, 5),
(63, 18, 5),
(63, 29, 5),
(63, 30, 5),
(63, 31, 5),
(63, 32, 5),
(63, 33, 5),
(64, 12, 5),
(64, 13, 5),
(64, 14, 5),
(64, 15, 5),
(64, 16, 5),
(64, 22, 5),
(64, 23, 5),
(64, 24, 5),
(64, 25, 5),
(64, 26, 5),
(64, 17, 5),
(64, 19, 5),
(64, 27, 5),
(64, 28, 5),
(64, 18, 5),
(64, 29, 5),
(64, 30, 5),
(64, 31, 5),
(64, 32, 5),
(64, 33, 5);

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_list`
--

CREATE TABLE `evaluation_list` (
  `evaluation_id` int(30) NOT NULL,
  `academic_id` int(30) NOT NULL,
  `class_id` int(30) NOT NULL,
  `student_id` int(30) NOT NULL,
  `subject_id` int(30) NOT NULL,
  `faculty_id` int(30) NOT NULL,
  `restriction_id` int(30) NOT NULL,
  `date_taken` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `evaluation_list`
--

INSERT INTO `evaluation_list` (`evaluation_id`, `academic_id`, `class_id`, `student_id`, `subject_id`, `faculty_id`, `restriction_id`, `date_taken`) VALUES
(47, 4, 2, 0, 2, 1, 0, '2024-09-23 17:26:52'),
(48, 4, 2, 0, 1, 1, 0, '2024-09-23 17:29:31'),
(49, 4, 1, 0, 1, 1, 0, '2024-09-23 17:30:05'),
(50, 4, 2, 0, 1, 1, 0, '2024-09-23 17:31:20'),
(51, 4, 2, 0, 1, 1, 0, '2024-09-23 17:31:22'),
(52, 4, 2, 0, 2, 1, 0, '2024-09-23 17:31:27'),
(53, 4, 2, 0, 2, 1, 0, '2024-09-23 17:31:35'),
(54, 4, 2, 0, 2, 1, 0, '2024-09-23 17:31:43'),
(55, 4, 2, 0, 2, 1, 0, '2024-09-23 17:33:17'),
(56, 4, 1, 0, 2, 2, 0, '2024-09-23 17:33:30'),
(57, 4, 2, 0, 2, 1, 0, '2024-09-23 17:46:53'),
(58, 4, 2, 0, 2, 2, 0, '2024-09-23 17:50:11'),
(59, 4, 2, 0, 1, 2, 0, '2024-09-23 17:51:35'),
(60, 4, 1, 0, 1, 2, 0, '2024-09-23 17:52:00'),
(61, 4, 1, 0, 1, 2, 0, '2024-09-23 17:53:35'),
(62, 4, 1, 0, 1, 2, 0, '2024-09-23 17:56:36'),
(63, 4, 2, 0, 1, 1, 0, '2024-09-24 22:56:01'),
(64, 4, 2, 0, 1, 1, 0, '2024-09-24 22:56:48');

-- --------------------------------------------------------

--
-- Table structure for table `faculty_list`
--

CREATE TABLE `faculty_list` (
  `id` int(30) NOT NULL,
  `school_id` varchar(100) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `avatar` text NOT NULL DEFAULT 'no-image-available.png',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty_list`
--

INSERT INTO `faculty_list` (`id`, `school_id`, `firstname`, `lastname`, `email`, `password`, `avatar`, `date_created`) VALUES
(1, '20140623', 'George', 'Wilson', 'gwilson@sample.com', 'd40242fb23c45206fadee4e2418f274f', '1608011100_avatar.jpg', '2020-12-15 13:45:18'),
(2, '07102181', 'Edwin Erick', 'Borlasa', 'edwinerick@dwc-legazpi.edu', '3e201ce0aec7620e8a8eda8bcbfc1aa3', 'no-image-available.png', '2024-09-23 15:56:15');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `grade` decimal(5,2) DEFAULT NULL,
  `term` varchar(50) DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `faculty_id`, `grade`, `term`, `timestamp`) VALUES
(1, 1, 2, NULL, 89.00, NULL, '2024-09-24 00:06:10'),
(2, 1, 2, NULL, 89.00, NULL, '2024-09-24 00:13:07'),
(3, 2, 2, NULL, 99.00, NULL, '2024-09-24 00:13:14');

-- --------------------------------------------------------

--
-- Table structure for table `question_list`
--

CREATE TABLE `question_list` (
  `id` int(30) NOT NULL,
  `academic_id` int(30) NOT NULL,
  `question` text NOT NULL,
  `order_by` int(30) NOT NULL,
  `criteria_id` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question_list`
--

INSERT INTO `question_list` (`id`, `academic_id`, `question`, `order_by`, `criteria_id`) VALUES
(1, 3, 'Sample Question', 0, 1),
(3, 3, 'Test', 2, 2),
(5, 0, 'Question 101', 0, 1),
(6, 3, 'Sample 101', 4, 1),
(7, 3, 'How is advanced database tutorial?', 5, 4),
(8, 4, 'hgjfghfhj', 0, 5),
(9, 4, 'SDADASDASDSA', 1, 6),
(10, 4, 'dsadasda', 2, 6),
(11, 4, 'asdasdas', 3, 1),
(12, 4, 'Demonstrates Mastery of the subject matter', 0, 10),
(13, 4, 'Discusses subject matter thoroughly without directly reading from books and/or notes', 1, 10),
(14, 4, 'Relates lesson to national and local issues', 2, 10),
(15, 4, 'Covers satisfactory amount of subject matter', 3, 10),
(16, 4, 'Speak in a well-modulated voice', 4, 9),
(17, 4, 'Brings out an atmosphere conducive to learning', 10, 11),
(18, 4, 'Observes property in behavior and grooming', 14, 12),
(19, 4, 'Handles students questions and opinions objectively ', 11, 11),
(21, 4, 'asjkldhf liujdhf lkjsdhflkjasdh flkjasdhflkjasdh flkjsadhf lkjasdh zlf kjhsad lkjfahsdlkj fashdlkjf hasdkjf hasdlkjf haksldjhflkasdjhf laksdjhf alskdjhfnlkasjd hfaskdjhf asldkkjfhsalkdjfhasdlkjfhaslkj fhasdlkjf hadslkjfh ', 12, 0),
(22, 4, 'Uses teaching strategies, aids and devices that stimulates critical thinking', 5, 9),
(23, 4, 'Communicate in clear, correct coherent English that is suited to student level of comprehension ', 6, 9),
(24, 4, 'Ask a variety of questions especially through-provoking one and distributes them adequately', 7, 9),
(25, 4, 'Relates lesson to current situations and students experience ', 8, 9),
(26, 4, 'Provides necessary feedback on students learning ', 9, 9),
(27, 4, 'Begins the class on time and does not dismiss before time', 12, 11),
(28, 4, 'Holds the attention of students throughout the period', 13, 11),
(29, 4, 'Respectable and dignified in his/her action', 15, 12),
(30, 4, 'Models compassion and committed attitude towards the students', 16, 12),
(31, 4, 'Manifest self-confidence and enthusiasm for teaching', 17, 12),
(32, 4, 'Shows genuine  concern and interest for students welfare ', 18, 12),
(33, 4, 'Deals professionally with students', 19, 12);

-- --------------------------------------------------------

--
-- Table structure for table `restriction_list`
--

CREATE TABLE `restriction_list` (
  `id` int(30) NOT NULL,
  `academic_id` int(30) NOT NULL,
  `faculty_id` int(30) NOT NULL,
  `class_id` int(30) NOT NULL,
  `subject_id` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restriction_list`
--

INSERT INTO `restriction_list` (`id`, `academic_id`, `faculty_id`, `class_id`, `subject_id`) VALUES
(8, 3, 1, 1, 1),
(9, 3, 1, 2, 2),
(10, 3, 1, 3, 3),
(11, 4, 1, 2, 2),
(12, 4, 1, 1, 1),
(13, 4, 2, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `student_list`
--

CREATE TABLE `student_list` (
  `id` int(30) NOT NULL,
  `school_id` varchar(100) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `class_id` int(30) NOT NULL,
  `avatar` text NOT NULL DEFAULT 'no-image-available.png',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_list`
--

INSERT INTO `student_list` (`id`, `school_id`, `firstname`, `lastname`, `email`, `password`, `class_id`, `avatar`, `date_created`) VALUES
(1, '6231415', 'John', 'Smith', 'jsmith@sample.com', '1254737c076cf867dc53d60a0364f38e', 1, '1608012360_avatar.jpg', '2020-12-15 14:06:14'),
(2, '101497', 'Claire', 'Blake', 'cblake@sample.com', '4744ddea876b11dcb1d169fadf494418', 2, '1608012720_47446233-clean-noir-et-gradient-sombre-image-de-fond-abstrait-.jpg', '2020-12-15 14:12:03'),
(3, '123', 'Mike', 'Williams', 'mwilliams@sample.com', '3cc93e9a6741d8b40460457139cf8ced', 1, '1608034680_1605601740_download.jpg', '2020-12-15 20:18:22'),
(4, '07102296', 'Arvin', 'Milan', 'vinmilan0922@gmail.com', 'b8e3c5b1ee318ecfd32cb3646c97bfa1', 1, 'no-image-available.png', '2024-09-23 02:35:35');

-- --------------------------------------------------------

--
-- Table structure for table `subject_list`
--

CREATE TABLE `subject_list` (
  `id` int(30) NOT NULL,
  `code` varchar(50) NOT NULL,
  `subject` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject_list`
--

INSERT INTO `subject_list` (`id`, `code`, `subject`, `description`) VALUES
(1, '101', 'Sample Subject', 'Test 101'),
(2, 'ENG-101', 'English', 'English'),
(3, 'M-101', 'Math 101', 'Math - Advance Algebra ');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `cover_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `address`, `cover_img`) VALUES
(1, 'Faculty Evaluation System', 'info@sample.comm', '+6948 8542 623', '2102  Caldwell Road, Rochester, New York, 14608', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `avatar` text NOT NULL DEFAULT 'no-image-available.png',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `avatar`, `date_created`) VALUES
(1, 'Administrator', '', 'admin@admin.com', '0192023a7bbd73250516f069df18b500', '1607135820_avatar.jpg', '2020-11-26 10:57:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_list`
--
ALTER TABLE `academic_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class_list`
--
ALTER TABLE `class_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `criteria_list`
--
ALTER TABLE `criteria_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `evaluation_list`
--
ALTER TABLE `evaluation_list`
  ADD PRIMARY KEY (`evaluation_id`);

--
-- Indexes for table `faculty_list`
--
ALTER TABLE `faculty_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Indexes for table `question_list`
--
ALTER TABLE `question_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restriction_list`
--
ALTER TABLE `restriction_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_list`
--
ALTER TABLE `student_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject_list`
--
ALTER TABLE `subject_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_list`
--
ALTER TABLE `academic_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `class_list`
--
ALTER TABLE `class_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `criteria_list`
--
ALTER TABLE `criteria_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `evaluation_list`
--
ALTER TABLE `evaluation_list`
  MODIFY `evaluation_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `faculty_list`
--
ALTER TABLE `faculty_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `question_list`
--
ALTER TABLE `question_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `restriction_list`
--
ALTER TABLE `restriction_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `student_list`
--
ALTER TABLE `student_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `subject_list`
--
ALTER TABLE `subject_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student_list` (`id`),
  ADD CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject_list` (`id`),
  ADD CONSTRAINT `grades_ibfk_3` FOREIGN KEY (`faculty_id`) REFERENCES `faculty_list` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
