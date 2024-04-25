-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2024 at 11:24 AM
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
-- Database: `educationsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `answer_id` int(11) NOT NULL,
  `answer` varchar(255) DEFAULT NULL,
  `correct` tinyint(1) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `checkquestions`
--

CREATE TABLE `checkquestions` (
  `question_id` int(11) NOT NULL,
  `student_username` varchar(255) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `currentGrade` int(11) DEFAULT NULL,
  `graded` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE `exam` (
  `exam_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam`
--

INSERT INTO `exam` (`exam_id`, `title`) VALUES
(37, 'Test 1'),
(38, 'Test 1');

-- --------------------------------------------------------

--
-- Table structure for table `examdates`
--

CREATE TABLE `examdates` (
  `examDateID` int(11) NOT NULL,
  `dueDate` datetime DEFAULT NULL,
  `exam_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `userID` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `userID`, `password`, `type`, `name`, `email`) VALUES
(9, '1234', '1234', 'teacher', '1234', '1234@1234.com'),
(10, 'qwer', '1234', 'student', 'Jun', '1234@1234.com'),
(11, 'Jun123', '1234', 'teacher', 'teacher', 'sj@asd.com'),
(12, 'Jun1234', '1234', 'student', '1234', '1234@1234.com'),
(22, 'ndevT', 'Password123!', 'teacher', 'Teach Nick', 'teacher@gmail.com'),
(27, 'admin', 'admin', 'admin', 'ImAdmin', 'admin@gmail.com'),
(29, 'Teacher', 'Teacher1', 'teacher', 'Teacher', 'Teacher@Teacher.Teacher');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `question` varchar(255) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `exam_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_answers`
--

CREATE TABLE `student_answers` (
  `student_username` varchar(255) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_submissions`
--

CREATE TABLE `student_submissions` (
  `id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `score` int(11) NOT NULL DEFAULT 0,
  `feedback` text DEFAULT NULL,
  `graded` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_submissions`
--

INSERT INTO `student_submissions` (`id`, `assignment_id`, `student_id`, `file_path`, `submitted_at`, `score`, `feedback`, `graded`) VALUES
(26, 18, 10, 'upload_stu/submission1.txt', '2024-04-25 06:11:44', 25, 'Great job!', 1),
(27, 19, 10, 'upload_stu/submission2.txt', '2024-04-25 06:11:53', 75, 'Job well done!', 1),
(28, 20, 10, 'upload_stu/submission3.txt', '2024-04-25 06:12:03', 98, 'Wow! What a good job!', 1),
(29, 18, 12, 'upload_stu/submission1(1).txt', '2024-04-25 06:13:11', 15, 'unfortunately you had things wrong', 1),
(30, 19, 12, 'upload_stu/submission2(1).txt', '2024-04-25 06:13:20', 65, 'Minor errors in the first question, but other than that, great job!', 1),
(31, 20, 12, 'upload_stu/submission3(1).txt', '2024-04-25 06:13:27', 100, 'Wonderful!', 1);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_assignments`
--

CREATE TABLE `teacher_assignments` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `max_score` int(11) NOT NULL DEFAULT 25,
  `due_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_assignments`
--

INSERT INTO `teacher_assignments` (`id`, `title`, `description`, `file_path`, `max_score`, `due_date`) VALUES
(17, 'Assignment 1', 'This is the first assignment, please submit on time!', 'uploads/Assignment1.txt', 50, '2024-04-23 00:00:00'),
(18, 'Assignment 2', 'For those who didn\'t submit on time, please submit your files this time around!', 'uploads/Assignment2.txt', 25, '2024-04-26 00:00:00'),
(19, 'Assignment 3', 'Do what you will for this assignment, you have a lot of time!', 'uploads/Assignment3.txt', 75, '2024-05-02 00:00:00'),
(20, 'Assignment 4', 'Wow, I can\'t wait to see what is submitted here!', 'uploads/Assignment4.txt', 100, '2024-05-04 00:00:00'),
(21, 'Assignment 5', 'Test case.', 'uploads/Assignment5.txt', 125, '2024-04-24 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`answer_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `checkquestions`
--
ALTER TABLE `checkquestions`
  ADD PRIMARY KEY (`question_id`,`student_username`,`exam_id`);

--
-- Indexes for table `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`exam_id`);

--
-- Indexes for table `examdates`
--
ALTER TABLE `examdates`
  ADD PRIMARY KEY (`examDateID`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Indexes for table `student_answers`
--
ALTER TABLE `student_answers`
  ADD PRIMARY KEY (`student_username`,`exam_id`,`question_id`),
  ADD KEY `exam_id` (`exam_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `student_submissions`
--
ALTER TABLE `student_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assignment_id` (`assignment_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `teacher_assignments`
--
ALTER TABLE `teacher_assignments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `exam`
--
ALTER TABLE `exam`
  MODIFY `exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `examdates`
--
ALTER TABLE `examdates`
  MODIFY `examDateID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `student_submissions`
--
ALTER TABLE `student_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `teacher_assignments`
--
ALTER TABLE `teacher_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`exam_id`);

--
-- Constraints for table `student_answers`
--
ALTER TABLE `student_answers`
  ADD CONSTRAINT `student_answers_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`exam_id`),
  ADD CONSTRAINT `student_answers_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`);

--
-- Constraints for table `student_submissions`
--
ALTER TABLE `student_submissions`
  ADD CONSTRAINT `student_submissions_ibfk_1` FOREIGN KEY (`assignment_id`) REFERENCES `teacher_assignments` (`id`),
  ADD CONSTRAINT `student_submissions_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `login` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
