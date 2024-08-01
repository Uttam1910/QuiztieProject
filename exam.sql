

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `email`, `password`) VALUES
(1, 'rgit@gmail.com', 'rgit');

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `qid` text NOT NULL,
  `ansid` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `answer` (`qid`, `ansid`) VALUES
-- ('5b13ed3a6e006', '5b13ed3a9436a'),
-- ('5b13ed72489d8', '5b13ed7263d70'),
('1', '1'),
('2', '5'),
('3', '11'),
('4', '16'),
('5', '17'),
('6', '21'),
('7', '25'),
('8', '29'),
('9', '34'),
('10', '37'),

('11', '44'),
('12', '45'),
('13', '49'),
('14', '53'),
('15', '57'),
('16', '61'),
('17', '65'),
('18', '69'),
('19', '76'),
('20', '78'),

('21', '81'),
('22', '86'),
('23', '89'),
('24', '93'),
('25', '100'),
('26', '101'),
('27', '105'),
('28', '109'),
('29', '113'),
('30', '117'),

('31', '121'),
('32', '127'),
('33', '130'),
('34', '135'),
('35', '138'),
('36', '142'),
('37', '147'),
('38', '149'),
('39', '153'),
('40', '157');



CREATE TABLE `history` (
  `email` varchar(50) NOT NULL,
  `eid` text NOT NULL,
  `score` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `right` int(11) NOT NULL,
  `wrong` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- Dumping data for table `history`
INSERT INTO `history` (`email`, `eid`, `score`, `level`, `right`, `wrong`, `date`) VALUES
('suryaprasadtripathy8@gmail.com', '5b141b8009cf0', 22, 10, 8, 2, '2018-06-03 16:56:00'),
('pinky@gmail.com', '5b141b8009cf0', 30, 10, 10, 0, '2018-06-03 16:57:45'),
('priyanka@gmail.com', '5b141b8009cf0', 22, 10, 8, 2, '2018-06-03 16:59:06'),
('suryaprasadtripathy8@gmail.com', '5b141f1e8399e', 26, 10, 9, 1, '2018-06-03 17:17:26');
-- --------------------------------------------------------
--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `qid` varchar(50) NOT NULL,
  `option` varchar(5000) NOT NULL,
  `optionid` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`qid`, `option`, `optionid`) VALUES
-- Placeholder options
-- ('5b13ed3a6e006', 'sdb', '11'),
-- ('5b13ed3a6e006', 'jsdb', '12'),
-- ('5b13ed3a6e006', 'dsbv', '13'),
-- ('5b13ed3a6e006', 'jbdv', '14'),
-- ('5b13ed72489d8', 'vsdv', '15'),
-- ('5b13ed72489d8', 'vsdv', '16'),
-- ('5b13ed72489d8', 'vsdv', '17'),
-- ('5b13ed72489d8', 'vsdv', '18'),

('1', 'Rasmus Lerdorf', '1'),
('1', 'Willam Makepiece', '2'),
('1', 'Drek Kolkevi', '3'),
('1', 'List Barely', '4'),
('2', 'Personal Home Page', '5'),
('2', 'Private Home Page', '6'),
('2', 'Hypertext Processor', '7'),
('2', 'Preprocessor Home Page', '8'),
('3', '.html', '9'),
('3', '.ph', '10'),
('3', '.php', '11'),
('3', '.xml', '12'),
('4', 'for loop', '13'),
('4', 'do-while loop', '14'),
('4', 'foreach loop', '15'),
('4', 'All of the above', '16'),
('5', 'echo (Hello World);', '17'),
('5', 'print (Hello World);', '18'),
('5', 'printf (Hello World);', '19'),
('5', 'All of the above', '20'),
('6', 'function file()', '21'),
('6', 'arr_file()', '22'),
('6', 'arrfile()', '23'),
('6', 'file_arr()', '24'),
('7', 'Magic Function', '25'),
('7', 'Inbuilt Function', '26'),
('7', 'Default Function', '27'),
('7', 'User Defined Function', '28'),
('8', 'CREATE TABLE table_name (column_name column_type);', '29'),
('8', 'CREATE table_name (column_type column_name);', '30'),
('8', 'CREATE table_name (column_name column_type);', '31'),
('8', 'CREATE TABLE table_name (column_type column_name);', '32'),
('9', 'get_array() and get_row()', '33'),
('9', 'mysqli_fetch_array() and mysqli_fetch_row()', '34'),
('9', 'get_array() and get_column()', '35'),
('9', 'fetch_array() and fetch_column()', '36'),
('10', 'explode()', '37'),
('10', 'implode()', '38'),
('10', 'concat()', '39'),
('10', 'concatenate()', '40'),

('11', 'KF', '41'),
('11', 'RX', '42'),
('11', 'SH', '43'),
('11', 'TS', '44'),
('12', 'E/8, F/10', '45'),
('12', 'E/12, F/14', '46'),
('12', 'E/10, F/12', '47'),
('12', 'D/10, E/10', '48'),
('13', 'Energy', '49'),
('13', 'Power', '50'),
('13', 'Terminals', '51'),
('13', 'Cells', '52'),
('14', '₹14444.25', '53'),
('14', '₹14705.24', '54'),
('14', '₹14322.10', '55'),
('14', '₹14321.10', '56'),
('15', 'EOHYZKBB', '57'),
('15', 'FOHYZJBB', '58'),
('15', 'FOHZZKAB', '59'),
('15', 'HOHYBJBA', '60'),
('16', '11', '61'),
('16', '22', '62'),
('16', '0.5', '63'),
('16', '0.7', '64'),
('17', 'Mother-in-law', '65'),
('17', 'Cousin', '66'),
('17', 'Sister-in-law', '67'),
('17', 'Mother', '68'),
('18', '4', '69'),
('18', '3', '70'),
('18', '2', '71'),
('18', '1', '72'),
('19', 'Vapid', '73'),
('19', 'Innocent', '74'),
('19', 'Ignorant', '75'),
('19', 'Heinous', '76'),
('20', 'Priestly', '77'),
('20', 'Secular', '78'),
('20', 'Celestial', '79'),
('20', 'Scholarly', '80'),

-- What is the value of π (pi)?
('21', '3.14', '81'),
('21', '2.71', '82'),
('21', '1.62', '83'),
('21', '1.41', '84'),

-- Solve the equation: 2x + 3 = 7. What is the value of x?
('22', '1', '85'),
('22', '2', '86'),
('22', '3', '87'),
('22', '4', '88'),

-- What is the derivative of sin(x)?
('23', 'cos(x)', '89'),
('23', 'sin(x)', '90'),
('23', '-sin(x)', '91'),
('23', '-cos(x)', '92'),

-- What is the integral of 1/x dx?
('24', 'ln(x)', '93'),
('24', 'e^x', '94'),
('24', '1/x', '95'),
('24', 'x^2', '96'),

-- If a triangle has sides of lengths 3, 4, and 5, what type of triangle is it?
('25', 'Equilateral', '97'),
('25', 'Isosceles', '98'),
('25', 'Scalene', '99'),
('25', 'Right-angled', '100'),

-- What is the sum of the angles in a triangle?
('26', '180 degrees', '101'),
('26', '360 degrees', '102'),
('26', '90 degrees', '103'),
('26', '270 degrees', '104'),

-- Solve for x: x^2 - 4 = 0.
('27', 'x = 2 or x = -2', '105'),
('27', 'x = 2 or x = 2', '106'),
('27', 'x = -2 or x = -2', '107'),
('27', 'x = 4 or x = -4', '108'),

-- What is the area of a circle with radius r?
('28', 'πr^2', '109'),
('28', '2πr', '110'),
('28', 'πr', '111'),
('28', 'r^2', '112'),

-- What is the quadratic formula?
('29', 'x = (-b ± √(b^2 - 4ac)) / 2a', '113'),
('29', 'x = (-b ± √(b^2 - 2ac)) / 2a', '114'),
('29', 'x = (-b ± √(b^2 - 4ac)) / a', '115'),
('29', 'x = (b ± √(b^2 - 4ac)) / 2a', '116'),

-- What is the probability of flipping a fair coin and getting heads?
('30', '1/2', '117'),
('30', '1/3', '118'),
('30', '1/4', '119'),
('30', '2/3', '120'),

-- What is the capital of France?
('31', 'Paris', '121'),
('31', 'Berlin', '122'),
('31', 'Madrid', '123'),
('31', 'Rome', '124'),

-- Which is the largest desert in the world?
('32', 'Sahara', '125'),
('32', 'Gobi', '126'),
('32', 'Antarctic', '127'),
('32', 'Arctic', '128'),

-- What river flows through the city of Cairo?
('33', 'Amazon', '129'),
('33', 'Nile', '130'),
('33', 'Thames', '131'),
('33', 'Danube', '132'),

-- Mount Everest is located in which mountain range?
('34', 'Rocky Mountains', '133'),
('34', 'Andes', '134'),
('34', 'Himalayas', '135'),
('34', 'Alps', '136'),

-- What is the longest river in the world?
('35', 'Amazon', '137'),
('35', 'Nile', '138'),
('35', 'Yangtze', '139'),
('35', 'Mississippi', '140'),

-- Which continent is known as the "Dark Continent"?
('36', 'Asia', '141'),
('36', 'Africa', '142'),
('36', 'South America', '143'),
('36', 'Australia', '144'),

-- What is the smallest country in the world by area?
('37', 'Monaco', '145'),
('37', 'San Marino', '146'),
('37', 'Vatican City', '147'),
('37', 'Liechtenstein', '148'),

-- Which country has the most natural lakes?
('38', 'Canada', '149'),
('38', 'Russia', '150'),
('38', 'USA', '151'),
('38', 'Brazil', '152'),

-- In which country would you find the Great Barrier Reef?
('39', 'Australia', '153'),
('39', 'Indonesia', '154'),
('39', 'Philippines', '155'),
('39', 'Fiji', '156'),

-- What is the capital city of Japan?
('40', 'Tokyo', '157'),
('40', 'Beijing', '158'),
('40', 'Seoul', '159'),
('40', 'Bangkok', '160');




-- --------------------------------------------------------
--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `eid` text NOT NULL,
  `qid` text NOT NULL,
  `qns` text NOT NULL,
  `choice` int(10) NOT NULL,
  `sn` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`eid`, `qid`, `qns`, `choice`, `sn`) VALUES

('5b13ed30cd71f', '5b13ed3a6e006', 'dbjb', 4, 1),
('5b13ed6bb8bcd', '5b13ed72489d8', 'dvsd', 4, 1),

('1', '1', 'Who is the father of PHP?', 4, 1),
('1', '2', 'What does PHP stand for?', 4, 2),
('1', '3', 'PHP files have a default file extension of?', 4, 3),
('1', '4', 'Which of the looping statements is/are supported by PHP?', 4, 4),
('1', '5', 'Which of the following PHP statements will output Hello World on the screen?', 4, 5),
('1', '6', 'Which one of the following function is capable of reading a file into an array?', 4, 6),
('1', '7', 'A function in PHP which starts with __ (double underscore) is know as..', 4, 7),
('1', '8', 'Which one of the following statements is used to create a table?', 4, 8),
('1', '9', 'Which of the methods are used to manage result sets using both associative and indexed arrays?', 4, 9),
('1', '10', 'Which one of the following functions can be used to concatenate array elements to form a single delimited string?', 4, 10),


('2', '11', 'Various terms of an alphabet series are given with one or more terms missing. Select the missing terms from the choices. AZ, GT, MN, ?, YB.?', 4, 1),
('2', '12', 'The various terms of an alpha-numerical series have been given with one or more terms missing. Choose the missing terms from the choices. A/2, B/4, C/6, D/8 ', 4, 2),
('2', '13', 'Poles: Magnet::? : Battery ', 4, 3),
('2', '14', 'What is the compound interest on a sum of ₹40,000 for 33 years at the rate of 11% per annum?', 4, 4),
('2', '15', 'If Ajith writes code for COUNSEL as BITIRAK, how will he write GUIDANCE?', 4, 5),
('2', '16', '16384, 8192, 2048, 256, 16, ?, 16384, 8192, 2048, 256,16', 4, 6),
('2', '17', 'Kamal pointed to a photograph and says. "The lady in the photograph is my nephews maternal grandmother." How is the lady in the picture related to the Kamlas sister if he has no sister of his own?', 4, 7),
('2', '18', 'Six members of a family, M, N, O, P, and Q are travelling together. M is the son of N, but N is not the mother of M. L and N are a married couple. P is the brother of N. O is the daughter of L. Q is the brother of M. How many male members are there in the family?', 4, 8),
('2', '19', 'Antonym of Flagitious', 4, 9),
('2', '20', 'Synonym of Temporal', 4, 10),

('3', '21', 'What is the value of π (pi)?', 4, 1),
('3', '22', 'Solve the equation: 2x + 3 = 7. What is the value of x?', 4, 2),
('3', '23', 'What is the derivative of sin(x)?', 4, 3),
('3', '24', 'What is the integral of 1/x dx?', 4, 4),
('3', '25', 'If a triangle has sides of lengths 3, 4, and 5, what type of triangle is it?', 4, 5),
('3', '26', 'What is the sum of the angles in a triangle?', 4, 6),
('3', '27', 'Solve for x: x^2 - 4 = 0.', 4, 7),
('3', '28', 'What is the area of a circle with radius r?', 4, 8),
('3', '29', 'What is the quadratic formula?', 4, 9),
('3', '30', 'What is the probability of flipping a fair coin and getting heads?', 4, 10),


('4', '31', 'What is the capital of France?', 4, 1),
('4', '32', 'Which is the largest desert in the world?', 4, 2),
('4', '33', 'What river flows through the city of Cairo?', 4, 3),
('4', '34', 'Mount Everest is located in which mountain range?', 4, 4),
('4', '35', 'What is the longest river in the world?', 4, 5),
('4', '36', 'Which continent is known as the "Dark Continent"?', 4, 6),
('4', '37', 'What is the smallest country in the world by area?', 4, 7),
('4', '38', 'Which country has the most natural lakes?', 4, 8),
('4', '39', 'In which country would you find the Great Barrier Reef?', 4, 9),
('4', '40', 'What is the capital city of Japan?', 4, 10);



-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `eid` text NOT NULL,
  `title` varchar(100) NOT NULL,
  `right` int(11) NOT NULL,
  `wrong` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`eid`, `title`, `right`, `wrong`, `total`, `date`) VALUES
('1', 'Php & Mysqli', 3, 1, 10, '2023-02-16 16:46:56'),
('2', 'Aptitude', 3, 1, 10, '2023-02-16 03:40:00'),
('3', 'Math', 3, 1, 10, '2023-07-28 10:00:00'),
('4', 'Geography', 3, 1, 10, '2023-07-28 10:10:00');

-- --------------------------------------------------------
--
-- Table structure for table `rank`
--

CREATE TABLE `rank` (
  `email` varchar(50) NOT NULL,
  `score` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rank`
--
-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `name` varchar(50) NOT NULL,
  `college` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`email`);



--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

