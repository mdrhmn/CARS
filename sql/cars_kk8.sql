-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 25, 2020 at 05:09 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cars_kk8`
--

-- --------------------------------------------------------

--
-- Table structure for table `activityBureau_T`
--

CREATE TABLE `activityBureau_T` (
  `activityID` int(10) UNSIGNED DEFAULT NULL,
  `bureau_available` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activityBureau_T`
--

INSERT INTO `activityBureau_T` (`activityID`, `bureau_available`) VALUES
(2, 'Logistic'),
(2, 'Multimedia'),
(2, 'Publicity'),
(2, 'Relation'),
(4, 'Protocol'),
(4, 'Multimedia'),
(4, 'Publicity'),
(4, 'Relation'),
(9, 'Protocol'),
(9, 'Logistic'),
(9, 'Relation');

-- --------------------------------------------------------

--
-- Table structure for table `activityTime_T`
--

CREATE TABLE `activityTime_T` (
  `activityID` int(10) UNSIGNED DEFAULT NULL,
  `time_slot_available` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activityTime_T`
--

INSERT INTO `activityTime_T` (`activityID`, `time_slot_available`) VALUES
(1, '8:00AM - 11:30PM'),
(3, '10:00AM - 5:00PM'),
(3, '7:30PM - 11:45PM'),
(5, '9:00AM - 12:30PM,'),
(6, '10:30AM - 11:30AM'),
(6, '3:30PM - 6:00PM'),
(6, '7:30PM - 11:45PM'),
(7, '2:30PM - 5:00PM'),
(7, '8:30PM - 11:30PM'),
(8, '8:00AM - 12:30PM (12-4-2020)'),
(8, '8:00AM - 12:30PM (13-4-2020)'),
(8, '8:00AM - 12:30PM (14-4-2020)'),
(9, 'Audition Time A1: 10:00AM (1-4-2020)'),
(9, 'Audition Time B1: 3:00PM (1-4-2020)'),
(9, 'Audition Time C1: 8:30PM (1-4-2020)'),
(9, 'Audition Time A2: 10:00AM (2-4-2020)'),
(9, 'Audition Time B2: 3:00PM (2-4-2020)'),
(9, 'Audition Time C2: 8:30PM (2-4-2020)'),
(10, '2:00PM - 4:30PM (Audition Time)'),
(10, '8:30PM - 11:00PM (Audition Time)'),
(11, '9:00AM - 12:30PM'),
(12, '10:00AM - 1:30PM'),
(12, '3:00PM - 6:30PM'),
(13, '8:30AM - 1:30PM');

-- --------------------------------------------------------

--
-- Table structure for table `activity_T`
--

CREATE TABLE `activity_T` (
  `activityID` int(10) UNSIGNED NOT NULL,
  `activity_name` varchar(50) NOT NULL,
  `activity_jtk` varchar(50) NOT NULL,
  `activity_desc_short` varchar(100) NOT NULL,
  `activity_desc_long` varchar(9000) NOT NULL,
  `activity_date_start` date NOT NULL,
  `activity_date_end` date DEFAULT NULL,
  `activity_venue` varchar(50) NOT NULL,
  `activity_image_path` varchar(1000) NOT NULL,
  `activity_status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activity_T`
--

INSERT INTO `activity_T` (`activityID`, `activity_name`, `activity_jtk`, `activity_desc_short`, `activity_desc_long`, `activity_date_start`, `activity_date_end`, `activity_venue`, `activity_image_path`, `activity_status`) VALUES
(1, 'Training Of Facilitators', 'ADIN', 'Ever wanted to be a facilitator?<br>Join us now!', 'Being a facilitator is hard work especially for those who have never been on before. Ever wonder where can you get prepare before that important event? Well, look no further! We got all the tips and tricks that you will need to make sure that the event is being executed smoothly and safely.<br><strong>Join us now!</strong><br><small>*Breakfast, Lunch and Dinner are provided<br> Fee is RM7.00</small>', '2020-04-23', NULL, 'DEWAN KK8', 'imgs/adin/traning of facilitators.jpg', 'In Progress'),
(2, 'Charitable Journey', 'ADIN', 'Want to help those in need?<br>We got the thing for you!', 'Join us as we travel to schools across Kuala Lumpur and meet those who are not as fortunate as ourselves. We will spend time with the kids and show them a great time.<br><br><strong>Phase 1</strong> of the project will begin next month in October where we will reach out to any companies or organization for donations/sponsorships to aids theses unfortunate kids.<br><strong>Phase 2</strong> of the project will involve us going around the school and handing out the donations for ones who need it. Three days will be spent on this phase from 13/12/2020 till 16/12/2020. Currently, the plan is to visit 2 schools per day. If there more sponsors were to be acquired, we will extend the date of phase 2<br>Join us now!', '2019-12-13', '2019-12-16', 'DEWAN KK8', 'imgs/adin/charitable Journey.jpg', 'In Progress'),
(3, 'Entrepreneurship Day', 'KEMAS', 'SALE! SALE! SALE! Let\'s make some money!', 'Have a business in mind just waiting to happen?<br>\r\nSo, why wait anymore! on 13 December 2020, we will have our annual  Entrepreneurship Day here in Kolej Kediaman Kinabalu!. You are allowed to sell many things from foods and drinks like burgers and boba tea to apparels such as t-shirts and headscarf. If you have even bright ideas, make sure to inform our project manager for confirmation first. Well register now and start preparing the goods for selling!<br>Good luck!<br><small>*for those who are selling foods, to practice basic hygiene is compulsory like wearing gloves and hairnet<br>*registration fee is RM50</small>', '2019-12-13', NULL, 'Court Bola Tampar KK8', 'imgs/kemas/entrepreneurship day.jpg', 'In Progress'),
(4, 'Volunteers International Project', 'KEMAS', 'Come with us as we travle to Bali, Thiland to do good deeds.', 'It is time to travel the world and help others in need. This year, the VIP (Volunteers International Project) is taking a flight to Bali, Thailand and do some good there. We will spend 15 days there at a local village and help them with their daily needs. We would also help with some construction or renovation needed to houses and buildings in the area.<br>The flights going to and from will be sponsored by AirAsia but other expenses will be dependent on how well we can get sponsorship from other companies. Seats are limited as we are only going to bring 20 people to Bali. We will be select based on your previous contribution to the college/university and also your personality. Health condition is also a big factor for the selection.<br>So come and with us on this adventure!', '2020-01-05', '2020-01-20', 'Bali, Thailand', 'imgs/kemas/international volunteers (vip).jpg', 'In Progress'),
(5, 'Perarakan Maulidur Rasul', 'KEP', 'Let\'s celebrate the bitrh of Prophet Muhammad', 'Prophet Muhammad’s birthday is also called Maulud Nabi in Malaysia, and is commonly marked by religious lectures and readings of the Quran.<br>Muhammad’s birth was approximately in the year 570 (in the Gregorian Calendar). His uncle raised him after both the boy’s parents died while he was very young. Prophet Muhammad learned the trades of the merchant and of shepherding.<br>He began to preach around the age of 40. Eventually, he and his followers numbering around ten thousand took control of Mecca. Muhammad died from an illness in 632 after uniting Arabia into a single Muslim entity.<br><br>We will be having a march on this day as a celebration! So join us now! The more the marrier!', '2019-10-29', NULL, 'Dewan Tunku Canselor', 'imgs/kep/perarakan MD.jpg', 'In Progress'),
(6, 'Pesta Kebudayaan Cina', 'KEP', 'Let\'s celebrate Chinese culture! Try some moon cakes and watch the dragon dance!', 'Pesta Kebudayaan Cina LONG', '2020-03-18', NULL, 'Dewan KK8', 'imgs/kep/PESTA KEBUDAYAAN CINA.jpg', 'In Progress'),
(7, 'Seni Warisan Melayu', 'KEP', 'Seni Warisan Melayu SHORT', 'Seni Warisan Melayu LONG', '2020-03-12', NULL, 'Dewan KK8', 'imgs/kep/SENI WARISAN MELAYU.jpg', 'In Progress'),
(8, 'Malam Apresiasi Borneo', 'KEP', 'Malam Apresiasi Borneo SHORT', 'Malam Apresiasi Borneo LONG', '2020-04-12', '2020-04-14', 'Dewan KK8', 'imgs/kep/malam borneo.jpg', 'In Progress'),
(9, 'Karviter', 'SENI', 'Wanna be in the spotlight? Join the KK8 Karviter Crew', 'Every year UM holds an important battle between all the college. The battle of acting! This heated battle has been going on for a long time. Last year our Karviter crew steal the show!<br><br>We received these following awards:<br>- JUARA KARVITER 2020<br> - Anugerah Pengarah Terbaik<br> - Anugerah Pelakun Lelaki Terbaik<br> - Anugerah Pelakun Wanita Terbaik<br> - Anugerah Pelakon Harapan<br> - Anugerah Poster Terbaik<br> - Anugerah Penataan Busana & Tatarias Terbaik<br> - Anugerah Integrasi Kaum<br><br>Join the crew now and carry on the legacy! We will be having auditions and will pick the best. Be prepared and act on!', '2020-04-01', '2020-04-09', 'Dewan KK8', 'imgs/kreative/karviter.jpg', 'In Progress'),
(10, 'Tarian Tradisional Kebangsaan', 'SENI', 'Tarian Tradisional Kebangsaan SHORT', 'Tarian Tradisional Kebangsaan LONG', '2019-03-12', NULL, 'Dewan KK8', 'imgs/kreative/tarian tradisional kebangsaan.jpg', 'In Progress'),
(11, 'Race For Fitness', 'SUKAN', 'Run around Tasik Varsiti and complete fun challenges along the way', 'Race For Fitness LONG', '2019-03-28', NULL, 'Tasik Varsiti', 'imgs/sukeria/race for fitness.jpg', 'In Progress'),
(12, 'Kayak', 'SUKAN', 'Kayak SHORT', 'Kayak LONG', '2019-02-05', NULL, 'Tasik Varsiti', 'imgs/sukeria/kayak.jpg', 'In Progress'),
(13, 'Bola Tampar League', 'SUKAN', 'Wanna play some volleyball? Wanna test your ability?', 'Bolar Tampar Leauge LONG', '2019-03-02', NULL, 'Court Bola Tampar KK8', 'imgs/sukeria/bola tampar.jpg', 'In Progress');

-- --------------------------------------------------------

--
-- Table structure for table `category_T`
--

CREATE TABLE `category_T` (
  `id` int(11) NOT NULL,
  `complaint_category` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category_T`
--

INSERT INTO `category_T` (`id`, `complaint_category`) VALUES
(1, 'Indoor'),
(2, 'Outdoor'),
(3, 'Pantry'),
(4, 'Room');

-- --------------------------------------------------------

--
-- Table structure for table `complaint_T`
--

CREATE TABLE `complaint_T` (
  `studentID` int(10) UNSIGNED DEFAULT NULL,
  `complaintID` int(10) UNSIGNED NOT NULL,
  `complaint_category` varchar(255) DEFAULT NULL,
  `complaint_type` varchar(50) NOT NULL,
  `complaint_details` varchar(255) DEFAULT NULL,
  `complaint_phoneNo` varchar(11) NOT NULL,
  `complaint_location` varchar(255) NOT NULL,
  `complaint_file` varchar(255) DEFAULT NULL,
  `complaint_status` varchar(255) DEFAULT NULL,
  `complaint_date` datetime NOT NULL DEFAULT current_timestamp(),
  `complaint_rate` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `registration_T`
--

CREATE TABLE `registration_T` (
  `studentID` int(10) UNSIGNED DEFAULT NULL,
  `activityID` int(10) UNSIGNED DEFAULT NULL,
  `category` varchar(20) NOT NULL,
  `time_slot_picked` varchar(50) DEFAULT NULL,
  `bureau_picked` varchar(50) DEFAULT NULL,
  `reason_joining` varchar(1000) DEFAULT NULL,
  `sent_file` varchar(50) DEFAULT NULL,
  `reg_status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `student_exp_T`
--

CREATE TABLE `student_exp_T` (
  `studentID` int(10) UNSIGNED DEFAULT NULL,
  `experienceID` int(10) UNSIGNED NOT NULL,
  `position` varchar(50) NOT NULL,
  `project` varchar(50) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `details` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `student_T`
--

CREATE TABLE `student_T` (
  `studentID` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `profile_pic_path` varchar(1000) DEFAULT NULL,
  `faculty` varchar(100) DEFAULT NULL,
  `biography` varchar(240) DEFAULT NULL,
  `phone_no` varchar(11) DEFAULT NULL,
  `twitter_acc` varchar(50) DEFAULT NULL,
  `facebook_acc` varchar(50) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `zip` int(5) DEFAULT NULL,
  `question` varchar(100) NOT NULL,
  `answer` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_T`
--

INSERT INTO `student_T` (`studentID`, `username`, `password`, `email`, `first_name`, `last_name`, `profile_pic_path`, `faculty`, `biography`, `phone_no`, `twitter_acc`, `facebook_acc`, `address`, `city`, `state`, `zip`, `question`, `answer`) VALUES
(17138489, 'mdrhmn', '$2y$10$J2KRDOmHsOqzPwYZPX0on.kHq1bECN0HLi5uyr/8l8Jv1xvYLzXCy', 'mdrhmn99@siswa.um.edu.my', 'Muhammad Rahiman', 'Abdulmanab', 'test.jpg', 'Faculty of Computer Science & Information Technology', 'Luctor Et Emergo', '0148912758', '', '', 'No. 53G, Lot 12684, Yen Yen Park; Jalan Matang', 'Kuching', 'Sarawak', 93050, 'What\'s your favorite color?', 'Black');

-- --------------------------------------------------------

--
-- Table structure for table `type_T`
--

CREATE TABLE `type_T` (
  `id` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `category` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `type_T`
--

INSERT INTO `type_T` (`id`, `name`, `category`) VALUES
(1, 'Air-conditioner', 'Room'),
(2, 'Autogate-barrier', 'Outdoor'),
(3, 'Bed', 'Room'),
(4, 'Bookshelf', 'Room'),
(5, 'Cabinet', 'Room'),
(6, 'Ceiling', 'Room'),
(7, 'Chair', 'Room'),
(8, 'Cleanliness', 'Outdoor'),
(9, 'Clogged', 'Outdoor'),
(10, 'Cloth hanger', 'Room'),
(11, 'Counter Service', 'Outdoor'),
(12, 'Curtain', 'Room'),
(13, 'Door', 'Room'),
(14, 'Door lock', 'Room'),
(15, 'Drain', 'Outdoor'),
(16, 'Drawer/Cupboard', 'Room'),
(17, 'Fan', 'Room'),
(18, 'Iron', 'Pantry'),
(19, 'Lamp', 'Room'),
(20, 'Leaked', 'Outdoor'),
(21, 'Lift', 'Outdoor'),
(22, 'Mattress', 'Room'),
(23, 'Mirror', 'Room'),
(24, 'Piping', 'Outdoor'),
(25, 'Plug', 'Room'),
(26, 'Roof', 'Outdoor'),
(27, 'Shower', 'Indoor'),
(28, 'Sink', 'Indoor'),
(29, 'Table', 'Room'),
(30, 'Tile/Floor', 'Room'),
(31, 'Toilet bowl', 'Indoor'),
(32, 'Water boiler', 'Pantry'),
(33, 'Water dispenser', 'Pantry'),
(34, 'Window', 'Room');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activityBureau_T`
--
ALTER TABLE `activityBureau_T`
  ADD KEY `activityID` (`activityID`);

--
-- Indexes for table `activity_T`
--
ALTER TABLE `activity_T`
  ADD PRIMARY KEY (`activityID`);

--
-- Indexes for table `category_T`
--
ALTER TABLE `category_T`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complaint_T`
--
ALTER TABLE `complaint_T`
  ADD PRIMARY KEY (`complaintID`),
  ADD KEY `studentID` (`studentID`);

--
-- Indexes for table `registration_T`
--
ALTER TABLE `registration_T`
  ADD KEY `studentID` (`studentID`),
  ADD KEY `activityID` (`activityID`);

--
-- Indexes for table `student_exp_T`
--
ALTER TABLE `student_exp_T`
  ADD PRIMARY KEY (`experienceID`),
  ADD KEY `studentID` (`studentID`);

--
-- Indexes for table `student_T`
--
ALTER TABLE `student_T`
  ADD PRIMARY KEY (`studentID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_T`
--
ALTER TABLE `activity_T`
  MODIFY `activityID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `category_T`
--
ALTER TABLE `category_T`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `complaint_T`
--
ALTER TABLE `complaint_T`
  MODIFY `complaintID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `student_exp_T`
--
ALTER TABLE `student_exp_T`
  MODIFY `experienceID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activityBureau_T`
--
ALTER TABLE `activityBureau_T`
  ADD CONSTRAINT `activitybureau_t_ibfk_1` FOREIGN KEY (`activityID`) REFERENCES `activity_T` (`activityID`);

--
-- Constraints for table `complaint_T`
--
ALTER TABLE `complaint_T`
  ADD CONSTRAINT `complaint_t_ibfk_1` FOREIGN KEY (`studentID`) REFERENCES `student_T` (`studentID`);

--
-- Constraints for table `registration_T`
--
ALTER TABLE `registration_T`
  ADD CONSTRAINT `registration_t_ibfk_1` FOREIGN KEY (`studentID`) REFERENCES `student_T` (`studentID`),
  ADD CONSTRAINT `registration_t_ibfk_2` FOREIGN KEY (`activityID`) REFERENCES `activity_T` (`activityID`);

--
-- Constraints for table `student_exp_T`
--
ALTER TABLE `student_exp_T`
  ADD CONSTRAINT `student_exp_t_ibfk_1` FOREIGN KEY (`studentID`) REFERENCES `student_T` (`studentID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
