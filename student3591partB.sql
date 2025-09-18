-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Φιλοξενητής: webpagesdb.it.auth.gr:3306
-- Χρόνος δημιουργίας: 14 Σεπ 2024 στις 13:22:07
-- Έκδοση διακομιστή: 10.1.48-MariaDB-0ubuntu0.18.04.1
-- Έκδοση PHP: 7.1.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `student3591partB`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `announcements`
--

CREATE TABLE `announcements` (
  `id` int(10) NOT NULL,
  `date` date NOT NULL,
  `topic` text NOT NULL,
  `text` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `announcements`
--

INSERT INTO `announcements` (`id`, `date`, `topic`, `text`) VALUES
(1, '2024-09-01', 'Semester Begins', 'Welcome to the new semester! Classes will commence from September 1st.'),
(2, '2024-08-15', 'Orientation for New Students', 'The orientation session for new students will be held on August 20th. Attendance is mandatory.'),
(3, '2024-08-25', 'Library Hours', 'The library will remain open from 8 AM to 8 PM starting from August 26th.'),
(4, '2024-09-05', 'Course Registration Deadline', 'Course registrations will close on September 8th. Please ensure you have enrolled in all required courses before this date.'),
(5, '2024-09-13', 'New assignment added', 'The due date for the new assignment is 2024-09-29'),
(6, '2024-09-13', 'New assignment added', 'The due date for the new assignment is 2024-09-30');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `documents`
--

CREATE TABLE `documents` (
  `id` int(10) NOT NULL,
  `title` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `fileName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `documents`
--

INSERT INTO `documents` (`id`, `title`, `description`, `fileName`) VALUES
(1, 'Week 1', 'Week 1\'s file', 'Week 1.docx'),
(2, 'Week 2', 'Week 2\'s file', 'Week 2.docx'),
(3, 'Week 3', 'Week 3\'s file', 'Week 3.docx'),
(4, 'Week 4', 'Week 4\'s file', 'Week 4.docx');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `homework`
--

CREATE TABLE `homework` (
  `id` int(10) NOT NULL,
  `goals` text NOT NULL,
  `descriptionFileName` varchar(30) NOT NULL,
  `toTurnIn` text NOT NULL,
  `dueDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `homework`
--

INSERT INTO `homework` (`id`, `goals`, `descriptionFileName`, `toTurnIn`, `dueDate`) VALUES
(1, 'Help you comprehend in depth..., Offer a new perspective towards..., Train you in recognizing..., Revise knowledge from previous material about...', '66e4ba1f4a4d35.12781912.docx', 'A Power Point Presentation, A report in Word Document', '2024-09-29'),
(2, 'Help you comprehend in depth...', '66e4ba3c903636.51220377.docx', 'An assignment', '2024-09-30');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `users`
--

CREATE TABLE `users` (
  `firstName` varchar(30) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `loginName` varchar(30) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `Role` enum('Tutor','Student') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `users`
--

INSERT INTO `users` (`firstName`, `lastName`, `loginName`, `password`, `Role`) VALUES
('Emily', 'Johnson', 'emily.johnson@example.com', 'password123', 'Student'),
('George', 'Harrison', 'gharri@example.com', 'password123', 'Tutor'),
('John', 'Doe', 'john.doe@example.com', 'password123', 'Student'),
('Sarah', 'Williams', 'sarah.williams@example.com', 'password123', 'Student'),
('Evangelia', 'Stamoglou', 'stanikeva@csd.auth.gr', '3591', 'Tutor');

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `homework`
--
ALTER TABLE `homework`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`loginName`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT για πίνακα `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT για πίνακα `homework`
--
ALTER TABLE `homework`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
