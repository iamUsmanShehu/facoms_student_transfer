-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2024 at 12:01 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_transfer_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

CREATE TABLE `applicants` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `lga` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `next_of_kin` varchar(100) DEFAULT NULL,
  `nok_address` text DEFAULT NULL,
  `nok_email` varchar(100) DEFAULT NULL,
  `relation` varchar(50) DEFAULT NULL,
  `passport_path` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '1=accepted, 2=rejected'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `applicants`
--

INSERT INTO `applicants` (`id`, `student_id`, `phone`, `dob`, `state`, `lga`, `address`, `next_of_kin`, `nok_address`, `nok_email`, `relation`, `passport_path`, `status`) VALUES
(3, 1, '09160163113', '2023-10-26', '2', '23', 'Just Testing to see if it works!', 'Kunne', 'Gida-Dubu', 'kunne@gmail.com', 'brother', 'uploads/1599864585669.jpg', 1),
(4, 2, '09160163113', '2023-10-26', 'Jigawa', 'Gwaram', 'See if it works!', 'Sallau', 'Gida-Dubu', 'sallau@gmail.com', 'Senior brother', 'uploads/u.jpg', 0),
(5, 7, '+23499887766', '2023-12-28', '', '', 'Unguwar yan kaji', 'Testcode', 'Unguwar yan kaji', 'testcode@gmail.com', 'testing', 'uploads/IMG-20231128-WA0003.jpg', 2),
(6, 8, '09040306788', '2023-11-27', 'Jigawa', 'Gumel', 'yola, yola.', 'abubakar', 'same as the last one', 'umar@gmail.com', 'Father', 'uploads/u.jpg', 1),
(7, 6, '09160163113', '2023-10-26', '', '', 'Just Testing to see if it works!', 'Kunne', 'Gida-Dubu', 'kunne@gmail.com', 'brother', 'uploads/1599864585669.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `choice_of_study`
--

CREATE TABLE `choice_of_study` (
  `id` int(11) NOT NULL,
  `applicant_id` int(11) NOT NULL,
  `faculty` int(100) NOT NULL,
  `program` int(11) NOT NULL,
  `Present_Institution` varchar(50) NOT NULL,
  `Present_Course_of_Study` varchar(30) NOT NULL,
  `Present_Level` varchar(12) NOT NULL,
  `Year_of_Entery` varchar(12) NOT NULL,
  `University_Reg_No` varchar(20) NOT NULL,
  `Transfer_To_Course` varchar(30) NOT NULL,
  `Transfer_Level` varchar(11) NOT NULL,
  `withdraw` varchar(5) NOT NULL,
  `Reasons_for_withdrawal` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `choice_of_study`
--

INSERT INTO `choice_of_study` (`id`, `applicant_id`, `faculty`, `program`, `Present_Institution`, `Present_Course_of_Study`, `Present_Level`, `Year_of_Entery`, `University_Reg_No`, `Transfer_To_Course`, `Transfer_Level`, `withdraw`, `Reasons_for_withdrawal`) VALUES
(1, 1, 3, 1, 'Aliko Dangote University of Science & Technology, ', 'INFORMATION TECHNOLOGY', 'LEVEL - 300', '2019', 'UG20/ICTC/2017', 'MATHEMATICS', '300', 'Yes', 'Testing Reason...');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`id`, `name`) VALUES
(3, 'FACOMS');

-- --------------------------------------------------------

--
-- Table structure for table `hod_feedback`
--

CREATE TABLE `hod_feedback` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `hod_id` int(11) NOT NULL,
  `academic_year` varchar(9) NOT NULL,
  `uni_sam_exam_result` varchar(255) NOT NULL,
  `cgpa` decimal(3,2) NOT NULL,
  `remarks` text DEFAULT NULL,
  `candidate_withdrawn` varchar(11) NOT NULL DEFAULT '0',
  `reasons_for_withdrawal` text DEFAULT NULL,
  `source_hod_name` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hod_feedback`
--

INSERT INTO `hod_feedback` (`id`, `student_id`, `hod_id`, `academic_year`, `uni_sam_exam_result`, `cgpa`, `remarks`, `candidate_withdrawn`, `reasons_for_withdrawal`, `source_hod_name`, `designation`, `status`, `created_at`, `updated_at`) VALUES
(3, 1, 12, '2020/2024', 'First Semester Examination Result', '3.55', 'Good', 'no', 'dgnfjfyjgm', 'Abubakar Idrees', 'HOD Computer', 0, '2024-09-04 11:34:39', '2024-09-04 11:34:39');

-- --------------------------------------------------------

--
-- Table structure for table `jamb_results`
--

CREATE TABLE `jamb_results` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `jamb_reg_no` varchar(255) NOT NULL,
  `english` varchar(255) NOT NULL,
  `english_score` int(11) NOT NULL,
  `subject1` varchar(255) NOT NULL,
  `subject1_score` int(11) NOT NULL,
  `subject2` varchar(255) NOT NULL,
  `subject2_score` int(11) NOT NULL,
  `subject3` varchar(255) NOT NULL,
  `subject3_score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jamb_results`
--

INSERT INTO `jamb_results` (`id`, `student_id`, `jamb_reg_no`, `english`, `english_score`, `subject1`, `subject1_score`, `subject2`, `subject2_score`, `subject3`, `subject3_score`) VALUES
(1, 1, '87572011DH', 'English', 40, 'Mathematics', 20, 'Chemistry', 50, 'Hausa', 70),
(3, 8, '22344CD', 'English', 20, 'Mathematics', 30, 'Chemistry', 40, 'Hausa', 79),
(9, 7, '40306788GI', 'English', 58, 'Maths', 67, 'Biology', 31, 'Economics', 40);

-- --------------------------------------------------------

--
-- Table structure for table `lga`
--

CREATE TABLE `lga` (
  `id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lga`
--

INSERT INTO `lga` (`id`, `state_id`, `name`) VALUES
(1, 1, 'Aba North'),
(2, 1, 'Aba South'),
(3, 1, 'Arochukwu'),
(4, 1, 'Bende'),
(5, 1, 'Ikwuano'),
(6, 1, 'Isiala Ngwa North'),
(7, 1, 'Isiala Ngwa South'),
(8, 1, 'Isuikwuato'),
(9, 1, 'Obi Ngwa'),
(10, 1, 'Ohafia'),
(11, 1, 'Osisioma Ngwa'),
(12, 1, 'Ugwunagbo'),
(13, 1, 'Ukwa East'),
(14, 1, 'Ukwa West'),
(15, 1, 'Umuahia North'),
(16, 1, 'Umuahia South'),
(17, 1, 'Umunneochi'),
(18, 2, 'Demsa'),
(19, 2, 'Fufure'),
(20, 2, 'Ganye'),
(21, 2, 'Gayuk'),
(22, 2, 'Gombi'),
(23, 2, 'Grie'),
(24, 2, 'Hong'),
(25, 2, 'Jada'),
(26, 2, 'Larmurde'),
(27, 2, 'Madagali'),
(28, 2, 'Maiha'),
(29, 2, 'Mayo Belwa'),
(30, 2, 'Michika'),
(31, 2, 'Mubi North'),
(32, 2, 'Mubi South'),
(33, 2, 'Numan'),
(34, 2, 'Shelleng'),
(35, 2, 'Song'),
(36, 2, 'Toungo'),
(37, 2, 'Yola North'),
(38, 2, 'Yola South'),
(39, 3, 'Abak'),
(40, 3, 'Eastern Obolo'),
(41, 3, 'Eket'),
(42, 3, 'Esit Eket'),
(43, 3, 'Essien Udim'),
(44, 3, 'Etim Ekpo'),
(45, 3, 'Etinan'),
(46, 3, 'Ibeno'),
(47, 3, 'Ibesikpo Asutan'),
(48, 3, 'Ibiono-Ibom'),
(49, 3, 'Ika'),
(50, 3, 'Ikono'),
(51, 3, 'Ikot Abasi'),
(52, 3, 'Ikot Ekpene'),
(53, 3, 'Ini'),
(54, 3, 'Itu'),
(55, 3, 'Mbo'),
(56, 3, 'Mkpat-Enin'),
(57, 3, 'Nsit-Atai'),
(58, 3, 'Nsit-Ibom'),
(59, 3, 'Nsit-Ubium'),
(60, 3, 'Obot Akara'),
(61, 3, 'Okobo'),
(62, 3, 'Onna'),
(63, 3, 'Oron'),
(64, 3, 'Oruk Anam'),
(65, 3, 'Udung-Uko'),
(66, 3, 'Ukanafun'),
(67, 3, 'Uruan'),
(68, 3, 'Urue-Offong Oruko'),
(69, 3, 'Uyo'),
(70, 4, 'Aguata'),
(71, 4, 'Anambra East'),
(72, 4, 'Anambra West'),
(73, 4, 'Anaocha'),
(74, 4, 'Awka North'),
(75, 4, 'Awka South'),
(76, 4, 'Ayamelum'),
(77, 4, 'Dunukofia'),
(78, 4, 'Ekwusigo'),
(79, 4, 'Idemili North'),
(80, 4, 'Idemili South'),
(81, 4, 'Ihiala'),
(82, 4, 'Njikoka'),
(83, 4, 'Nnewi North'),
(84, 4, 'Nnewi South'),
(85, 4, 'Ogbaru'),
(86, 4, 'Onitsha North'),
(87, 4, 'Onitsha South'),
(88, 4, 'Orumba North'),
(89, 4, 'Orumba South'),
(90, 4, 'Oyi'),
(91, 5, 'Alkaleri'),
(92, 5, 'Bauchi'),
(93, 5, 'Bogoro'),
(94, 5, 'Damban'),
(95, 5, 'Darazo'),
(96, 5, 'Dass'),
(97, 5, 'Gamawa'),
(98, 5, 'Ganjuwa'),
(99, 5, 'Giade'),
(100, 5, 'Itas-Gadau'),
(101, 5, 'Jama are'),
(102, 5, 'Katagum'),
(103, 5, 'Kirfi'),
(104, 5, 'Misau'),
(105, 5, 'Ningi'),
(106, 5, 'Shira'),
(107, 5, 'Tafawa Balewa'),
(108, 5, 'Toro'),
(109, 5, 'Warji'),
(110, 5, 'Zaki'),
(111, 6, 'Brass'),
(112, 6, 'Ekeremor'),
(113, 6, 'Kolokuma Opokuma'),
(114, 6, 'Nembe'),
(115, 6, 'Ogbia'),
(116, 6, 'Sagbama'),
(117, 6, 'Southern Ijaw'),
(118, 6, 'Yenagoa'),
(119, 7, 'Agatu'),
(120, 7, 'Apa'),
(121, 7, 'Ado'),
(122, 7, 'Buruku'),
(123, 7, 'Gboko'),
(124, 7, 'Guma'),
(125, 7, 'Gwer East'),
(126, 7, 'Gwer West'),
(127, 7, 'Katsina-Ala'),
(128, 7, 'Konshisha'),
(129, 7, 'Kwande'),
(130, 7, 'Logo'),
(131, 7, 'Makurdi'),
(132, 7, 'Obi'),
(133, 7, 'Ogbadibo'),
(134, 7, 'Ohimini'),
(135, 7, 'Oju'),
(136, 7, 'Okpokwu'),
(137, 7, 'Oturkpo'),
(138, 7, 'Tarka'),
(139, 7, 'Ukum'),
(140, 7, 'Ushongo'),
(141, 7, 'Vandeikya'),
(142, 8, 'Abadam'),
(143, 8, 'Askira-Uba'),
(144, 8, 'Bama'),
(145, 8, 'Bayo'),
(146, 8, 'Biu'),
(147, 8, 'Chibok'),
(148, 8, 'Damboa'),
(149, 8, 'Dikwa'),
(150, 8, 'Gubio'),
(151, 8, 'Guzamala'),
(152, 8, 'Gwoza'),
(153, 8, 'Hawul'),
(154, 8, 'Jere'),
(155, 8, 'Kaga'),
(156, 8, 'Kala-Balge'),
(157, 8, 'Konduga'),
(158, 8, 'Kukawa'),
(159, 8, 'Kwaya Kusar'),
(160, 8, 'Mafa'),
(161, 8, 'Magumeri'),
(162, 8, 'Maiduguri'),
(163, 8, 'Marte'),
(164, 8, 'Mobbar'),
(165, 8, 'Monguno'),
(166, 8, 'Ngala'),
(167, 8, 'Nganzai'),
(168, 8, 'Shani'),
(169, 9, 'Abi'),
(170, 9, 'Akamkpa'),
(171, 9, 'Akpabuyo'),
(172, 9, 'Bakassi'),
(173, 9, 'Bekwarra'),
(174, 9, 'Biase'),
(175, 9, 'Boki'),
(176, 9, 'Calabar Municipal'),
(177, 9, 'Calabar South'),
(178, 9, 'Etung'),
(179, 9, 'Ikom'),
(180, 9, 'Obanliku'),
(181, 9, 'Obubra'),
(182, 9, 'Obudu'),
(183, 9, 'Odukpani'),
(184, 9, 'Ogoja'),
(185, 9, 'Yakuur'),
(186, 9, 'Yala'),
(187, 10, 'Aniocha North'),
(188, 10, 'Aniocha South'),
(189, 10, 'Bomadi'),
(190, 10, 'Burutu'),
(191, 10, 'Ethiope East'),
(192, 10, 'Ethiope West'),
(193, 10, 'Ika North East'),
(194, 10, 'Ika South'),
(195, 10, 'Isoko North'),
(196, 10, 'Isoko South'),
(197, 10, 'Ndokwa East'),
(198, 10, 'Ndokwa West'),
(199, 10, 'Okpe'),
(200, 10, 'Oshimili North'),
(201, 10, 'Oshimili South'),
(202, 10, 'Patani'),
(203, 10, 'Sapele'),
(204, 10, 'Udu'),
(205, 10, 'Ughelli North'),
(206, 10, 'Ughelli South'),
(207, 10, 'Ukwuani'),
(208, 10, 'Uvwie'),
(209, 10, 'Warri North'),
(210, 10, 'Warri South'),
(211, 10, 'Warri South West'),
(212, 11, 'Abakaliki'),
(213, 11, 'Afikpo North'),
(214, 11, 'Afikpo South'),
(215, 11, 'Ebonyi'),
(216, 11, 'Ezza North'),
(217, 11, 'Ezza South'),
(218, 11, 'Ikwo'),
(219, 11, 'Ishielu'),
(220, 11, 'Ivo'),
(221, 11, 'Izzi'),
(222, 11, 'Ohaozara'),
(223, 11, 'Ohaukwu'),
(224, 11, 'Onicha'),
(225, 12, 'Akoko-Edo'),
(226, 12, 'Egor'),
(227, 12, 'Esan Central'),
(228, 12, 'Esan North-East'),
(229, 12, 'Esan South-East'),
(230, 12, 'Esan West'),
(231, 12, 'Etsako Central'),
(232, 12, 'Etsako East'),
(233, 12, 'Etsako West'),
(234, 12, 'Igueben'),
(235, 12, 'Ikpoba Okha'),
(236, 12, 'Orhionmwon'),
(237, 12, 'Oredo'),
(238, 12, 'Ovia North-East'),
(239, 12, 'Ovia South-West'),
(240, 12, 'Owan East'),
(241, 12, 'Owan West'),
(242, 12, 'Uhunmwonde'),
(243, 13, 'Ado Ekiti'),
(244, 13, 'Efon'),
(245, 13, 'Ekiti East'),
(246, 13, 'Ekiti South-West'),
(247, 13, 'Ekiti West'),
(248, 13, 'Emure'),
(249, 13, 'Gbonyin'),
(250, 13, 'Ido Osi'),
(251, 13, 'Ijero'),
(252, 13, 'Ikere'),
(253, 13, 'Ikole'),
(254, 13, 'Ilejemeje'),
(255, 13, 'Irepodun-Ifelodun'),
(256, 13, 'Ise-Orun'),
(257, 13, 'Moba'),
(258, 13, 'Oye'),
(259, 14, 'Aninri'),
(260, 14, 'Awgu'),
(261, 14, 'Enugu East'),
(262, 14, 'Enugu North'),
(263, 14, 'Enugu South'),
(264, 14, 'Ezeagu'),
(265, 14, 'Igbo Etiti'),
(266, 14, 'Igbo Eze North'),
(267, 14, 'Igbo Eze South'),
(268, 14, 'Isi Uzo'),
(269, 14, 'Nkanu East'),
(270, 14, 'Nkanu West'),
(271, 14, 'Nsukka'),
(272, 14, 'Oji River'),
(273, 14, 'Udenu'),
(274, 14, 'Udi'),
(275, 14, 'Uzo Uwani'),
(276, 15, 'Abaji'),
(277, 15, 'Bwari'),
(278, 15, 'Gwagwalada'),
(279, 15, 'Kuje'),
(280, 15, 'Kwali'),
(281, 16, 'Akko'),
(282, 16, 'Balanga'),
(283, 16, 'Billiri'),
(284, 16, 'Dukku'),
(285, 16, 'Funakaye'),
(286, 16, 'Gombe'),
(287, 16, 'Kaltungo'),
(288, 16, 'Kwami'),
(289, 16, 'Nafada'),
(290, 16, 'Shongom'),
(291, 16, 'Yamaltu/Deba'),
(292, 17, 'Aboh Mbaise'),
(293, 17, 'Ahiazu Mbaise'),
(294, 17, 'Ehime Mbano'),
(295, 17, 'Ezinihitte Mbaise'),
(296, 17, 'Ideato North'),
(297, 17, 'Ideato South'),
(298, 17, 'Ihitte/Uboma'),
(299, 17, 'Ikeduru'),
(300, 17, 'Isiala Mbano'),
(301, 17, 'Isu'),
(302, 17, 'Mbaitoli'),
(303, 17, 'Ngor Okpala'),
(304, 17, 'Njaba'),
(305, 17, 'Nkwerre'),
(306, 17, 'Nwangele'),
(307, 17, 'Obowo'),
(308, 17, 'Oguta'),
(309, 17, 'Ohaji/Egbema'),
(310, 17, 'Okigwe'),
(311, 17, 'Orlu'),
(312, 17, 'Orsu'),
(313, 17, 'Oru East'),
(314, 17, 'Oru West'),
(315, 17, 'Owerri Municipal'),
(316, 17, 'Owerri North'),
(317, 17, 'Owerri West'),
(318, 18, 'Auyo'),
(319, 18, 'Babura'),
(320, 18, 'Biriniwa'),
(321, 18, 'Birnin Kudu'),
(322, 18, 'Buji'),
(323, 18, 'Dutse'),
(324, 18, 'Gagarawa'),
(325, 18, 'Garki'),
(326, 18, 'Gumel'),
(327, 18, 'Guri'),
(328, 18, 'Gwaram'),
(329, 18, 'Gwiwa'),
(330, 18, 'Hadejia'),
(331, 18, 'Jahun'),
(332, 18, 'Kafin Hausa'),
(333, 18, 'Kazaure'),
(334, 18, 'Kiri Kasama'),
(335, 18, 'Kiyawa'),
(336, 18, 'Kaugama'),
(337, 18, 'Maigatari'),
(338, 18, 'Malam Madori'),
(339, 18, 'Miga'),
(340, 18, 'Ringim'),
(341, 18, 'Roni'),
(342, 18, 'Sule Tankarkar'),
(343, 18, 'Taura'),
(344, 18, 'Yankwashi'),
(345, 19, 'Birnin Gwari'),
(346, 19, 'Chikun'),
(347, 19, 'Giwa'),
(348, 19, 'Igabi'),
(349, 19, 'Ikara'),
(350, 19, 'Jaba'),
(351, 19, 'Jema’a'),
(352, 19, 'Kachia'),
(353, 19, 'Kaduna North'),
(354, 19, 'Kaduna South'),
(355, 19, 'Kagarko'),
(356, 19, 'Kajuru'),
(357, 19, 'Kaura'),
(358, 19, 'Kauru'),
(359, 19, 'Kubau'),
(360, 19, 'Kudan'),
(361, 19, 'Lere'),
(362, 19, 'Makarfi'),
(363, 19, 'Sabon Gari'),
(364, 19, 'Sanga'),
(365, 19, 'Soba'),
(366, 19, 'Zangon Kataf'),
(367, 19, 'Zaria'),
(368, 20, 'Ajingi'),
(369, 20, 'Albasu'),
(370, 20, 'Bagwai'),
(371, 20, 'Bebeji'),
(372, 20, 'Bichi'),
(373, 20, 'Bunkure'),
(374, 20, 'Dala'),
(375, 20, 'Dambatta'),
(376, 20, 'Dawakin Kudu'),
(377, 20, 'Dawakin Tofa'),
(378, 20, 'Doguwa'),
(379, 20, 'Fagge'),
(380, 20, 'Gabasawa'),
(381, 20, 'Garko'),
(382, 20, 'Garun Mallam'),
(383, 20, 'Gaya'),
(384, 20, 'Gezawa'),
(385, 20, 'Gwale'),
(386, 20, 'Gwarzo'),
(387, 20, 'Kabo'),
(388, 20, 'Kano Municipal'),
(389, 20, 'Karaye'),
(390, 20, 'Kibiya'),
(391, 20, 'Kiru'),
(392, 20, 'Kumbotso'),
(393, 20, 'Kunchi'),
(394, 20, 'Kura'),
(395, 20, 'Madobi'),
(396, 20, 'Makoda'),
(397, 20, 'Minjibir'),
(398, 20, 'Nasarawa'),
(399, 20, 'Rano'),
(400, 20, 'Rimin Gado'),
(401, 20, 'Rogo'),
(402, 20, 'Shanono'),
(403, 20, 'Sumaila'),
(404, 20, 'Takai'),
(405, 20, 'Tarauni'),
(406, 20, 'Tofa'),
(407, 20, 'Tsanyawa'),
(408, 20, 'Tudun Wada'),
(409, 20, 'Ungogo'),
(410, 20, 'Warawa'),
(411, 20, 'Wudil'),
(412, 21, 'Bakori'),
(413, 21, 'Batagarawa'),
(414, 21, 'Batsari'),
(415, 21, 'Baure'),
(416, 21, 'Bindawa'),
(417, 21, 'Charanchi'),
(418, 21, 'Dan Musa'),
(419, 21, 'Dandume'),
(420, 21, 'Danja'),
(421, 21, 'Daura'),
(422, 21, 'Dutsi'),
(423, 21, 'Dutsin Ma'),
(424, 21, 'Faskari'),
(425, 21, 'Funtua'),
(426, 21, 'Ingawa'),
(427, 21, 'Jibia'),
(428, 21, 'Kafur'),
(429, 21, 'Kaita'),
(430, 21, 'Kankara'),
(431, 21, 'Kankia'),
(432, 21, 'Katsina'),
(433, 21, 'Kurfi'),
(434, 21, 'Kusada'),
(435, 21, 'Mai’adua'),
(436, 21, 'Malumfashi'),
(437, 21, 'Mani'),
(438, 21, 'Mashi'),
(439, 21, 'Matazu'),
(440, 21, 'Musawa'),
(441, 21, 'Rimi'),
(442, 21, 'Sabuwa'),
(443, 21, 'Safana'),
(444, 21, 'Sandamu'),
(445, 21, 'Zango'),
(446, 22, 'Aleiro'),
(447, 22, 'Arewa Dandi'),
(448, 22, 'Argungu'),
(449, 22, 'Augie'),
(450, 22, 'Bagudo'),
(451, 22, 'Birnin Kebbi'),
(452, 22, 'Bunza'),
(453, 22, 'Dandi'),
(454, 22, 'Fakai'),
(455, 22, 'Gwandu'),
(456, 22, 'Jega'),
(457, 22, 'Kalgo'),
(458, 22, 'Koko/Besse'),
(459, 22, 'Maiyama'),
(460, 22, 'Ngaski'),
(461, 22, 'Sakaba'),
(462, 22, 'Shanga'),
(463, 22, 'Suru'),
(464, 22, 'Wasagu/Danko'),
(465, 22, 'Yauri'),
(466, 22, 'Zuru'),
(467, 23, 'Adavi'),
(468, 23, 'Ajaokuta'),
(469, 23, 'Ankpa'),
(470, 23, 'Bassa'),
(471, 23, 'Dekina'),
(472, 23, 'Ibaji'),
(473, 23, 'Idah'),
(474, 23, 'Igalamela Odolu'),
(475, 23, 'Ijumu'),
(476, 23, 'Kabba/Bunu'),
(477, 23, 'Kogi'),
(478, 23, 'Lokoja'),
(479, 23, 'Mopa-Muro'),
(480, 23, 'Ofu'),
(481, 23, 'Ogori/Magongo'),
(482, 23, 'Okehi'),
(483, 23, 'Okene'),
(484, 23, 'Olamaboro'),
(485, 23, 'Omala'),
(486, 23, 'Yagba East'),
(487, 23, 'Yagba West'),
(488, 24, 'Asa'),
(489, 24, 'Baruten'),
(490, 24, 'Edu'),
(491, 24, 'Ekiti'),
(492, 24, 'Ifelodun'),
(493, 24, 'Ilorin East'),
(494, 24, 'Ilorin South'),
(495, 24, 'Ilorin West'),
(496, 24, 'Irepodun'),
(497, 24, 'Isin'),
(498, 24, 'Kaiama'),
(499, 24, 'Moro'),
(500, 24, 'Offa'),
(501, 24, 'Oke Ero'),
(502, 24, 'Oyun'),
(503, 24, 'Pategi'),
(504, 25, 'Agege'),
(505, 25, 'Ajeromi-Ifelodun'),
(506, 25, 'Alimosho'),
(507, 25, 'Amuwo-Odofin'),
(508, 25, 'Apapa'),
(509, 25, 'Badagry'),
(510, 25, 'Epe'),
(511, 25, 'Eti Osa'),
(512, 25, 'Ibeju-Lekki'),
(513, 25, 'Ifako-Ijaiye'),
(514, 25, 'Ikeja'),
(515, 25, 'Ikorodu'),
(516, 25, 'Kosofe'),
(517, 25, 'Lagos Island'),
(518, 25, 'Lagos Mainland'),
(519, 25, 'Mushin'),
(520, 25, 'Ojo'),
(521, 25, 'Oshodi-Isolo'),
(522, 25, 'Shomolu'),
(523, 25, 'Surulere'),
(524, 26, 'Akwanga'),
(525, 26, 'Awe'),
(526, 26, 'Doma'),
(527, 26, 'Karu'),
(528, 26, 'Keana'),
(529, 26, 'Keffi'),
(530, 26, 'Kokona'),
(531, 26, 'Lafia'),
(532, 26, 'Nasarawa'),
(533, 26, 'Nasarawa Egon'),
(534, 26, 'Obi'),
(535, 26, 'Toto'),
(536, 26, 'Wamba'),
(537, 27, 'Agaie'),
(538, 27, 'Agwara'),
(539, 27, 'Bida'),
(540, 27, 'Borgu'),
(541, 27, 'Bosso'),
(542, 27, 'Chanchaga'),
(543, 27, 'Edati'),
(544, 27, 'Gbako'),
(545, 27, 'Gurara'),
(546, 27, 'Katcha'),
(547, 27, 'Kontagora'),
(548, 27, 'Lapai'),
(549, 27, 'Lavun'),
(550, 27, 'Magama'),
(551, 27, 'Mariga'),
(552, 27, 'Mashegu'),
(553, 27, 'Mokwa'),
(554, 27, 'Moya'),
(555, 27, 'Paikoro'),
(556, 27, 'Rafi'),
(557, 27, 'Rijau'),
(558, 27, 'Shiroro'),
(559, 27, 'Suleja'),
(560, 27, 'Tafa'),
(561, 27, 'Wushishi'),
(562, 28, 'Abeokuta North'),
(563, 28, 'Abeokuta South'),
(564, 28, 'Ado-Odo Ota'),
(565, 28, 'Ewekoro'),
(566, 28, 'Ifo'),
(567, 28, 'Ijebu East'),
(568, 28, 'Ijebu North'),
(569, 28, 'Ijebu North East'),
(570, 28, 'Ijebu Ode'),
(571, 28, 'Ikenne'),
(572, 28, 'Imeko Afon'),
(573, 28, 'Ipokia'),
(574, 28, 'Obafemi Owode'),
(575, 28, 'Odeda'),
(576, 28, 'Odogbolu'),
(577, 28, 'Remo North'),
(578, 28, 'Shagamu'),
(579, 29, 'Akoko North-East'),
(580, 29, 'Akoko North-West'),
(581, 29, 'Akoko South-West'),
(582, 29, 'Akoko South-East'),
(583, 29, 'Akure North'),
(584, 29, 'Akure South'),
(585, 29, 'Ese Odo'),
(586, 29, 'Idanre'),
(587, 29, 'Ifedore'),
(588, 29, 'Ilaje'),
(589, 29, 'Ile Oluji/Okeigbo'),
(590, 29, 'Irele'),
(591, 29, 'Odigbo'),
(592, 29, 'Okitipupa'),
(593, 29, 'Ondo East'),
(594, 29, 'Ondo West'),
(595, 29, 'Ose'),
(596, 29, 'Owo'),
(597, 30, 'Boluwaduro'),
(598, 30, 'Boripe'),
(599, 30, 'Ede North'),
(600, 30, 'Ede South'),
(601, 30, 'Egbedore'),
(602, 30, 'Ejigbo'),
(603, 30, 'Ife Central'),
(604, 30, 'Ife East'),
(605, 30, 'Ife North'),
(606, 30, 'Ife South'),
(607, 30, 'Ifedayo'),
(608, 30, 'Ifelodun'),
(609, 30, 'Ila'),
(610, 30, 'Ilesa East'),
(611, 30, 'Ilesa West'),
(612, 30, 'Irepodun'),
(613, 30, 'Irewole'),
(614, 30, 'Isokan'),
(615, 30, 'Iwo'),
(616, 30, 'Obokun'),
(617, 30, 'Odo Otin'),
(618, 30, 'Ola Oluwa'),
(619, 30, 'Olorunda'),
(620, 30, 'Oriade'),
(621, 30, 'Orolu'),
(622, 30, 'Osogbo'),
(623, 31, 'Atigbo'),
(624, 31, 'Atisbo'),
(625, 31, 'Egbeda'),
(626, 31, 'Ibadan North'),
(627, 31, 'Ibadan North-East'),
(628, 31, 'Ibadan North-West'),
(629, 31, 'Ibadan South-East'),
(630, 31, 'Ibadan South-West'),
(631, 31, 'Ibarapa Central'),
(632, 31, 'Ibarapa East'),
(633, 31, 'Ibarapa North'),
(634, 31, 'Ido'),
(635, 31, 'Irepo'),
(636, 31, 'Iseyin'),
(637, 31, 'Itesiwaju'),
(638, 31, 'Iwajowa'),
(639, 31, 'Kajola'),
(640, 31, 'Lagelu'),
(641, 31, 'Ogbomosho North'),
(642, 31, 'Ogbomosho South'),
(643, 31, 'Ogo Oluwa'),
(644, 31, 'Olorunsogo'),
(645, 31, 'Oluyole'),
(646, 31, 'Ona Ara'),
(647, 31, 'Orelope'),
(648, 31, 'Ori Ire'),
(649, 31, 'Oyo West'),
(650, 31, 'Saki East'),
(651, 31, 'Saki West'),
(652, 32, 'Bokkos'),
(653, 32, 'Barkin Ladi'),
(654, 32, 'Bassa'),
(655, 32, 'Jos East'),
(656, 32, 'Jos North'),
(657, 32, 'Jos South'),
(658, 32, 'Kanam'),
(659, 32, 'Kanke'),
(660, 32, 'Langtang North'),
(661, 32, 'Langtang South'),
(662, 32, 'Mangu'),
(663, 32, 'Mikang'),
(664, 32, 'Pankshin'),
(665, 32, 'Qua’an Pan'),
(666, 32, 'Riyom'),
(667, 32, 'Shendam'),
(668, 32, 'Wase'),
(669, 33, 'Andoni'),
(670, 33, 'Asari-Toru'),
(671, 33, 'Akuku-Toru'),
(672, 33, 'Abua Odual'),
(673, 33, 'Ahoada East'),
(674, 33, 'Ahoada West'),
(675, 33, 'Eleme'),
(676, 33, 'Emuoha'),
(677, 33, 'Etche'),
(678, 33, 'Gokana'),
(679, 33, 'Ikwerre'),
(680, 33, 'Khana'),
(681, 33, 'Obio-Akpor'),
(682, 33, 'Ogba-Egbema-Ndoni'),
(683, 33, 'Ogu-Bolo'),
(684, 33, 'Okrika'),
(685, 33, 'Omuma'),
(686, 33, 'Opobo-Nkoro'),
(687, 33, 'Oyigbo'),
(688, 33, 'Port Harcourt'),
(689, 34, 'Binji'),
(690, 34, 'Bodinga'),
(691, 34, 'Dange Shuni'),
(692, 34, 'Gada'),
(693, 34, 'Goronyo'),
(694, 34, 'Gudu'),
(695, 34, 'Gwadabawa'),
(696, 34, 'Illela'),
(697, 34, 'Isa'),
(698, 34, 'Kebbe'),
(699, 34, 'Kware'),
(700, 34, 'Rabah'),
(701, 34, 'Sabon Birni'),
(702, 34, 'Shagari'),
(703, 34, 'Silame'),
(704, 34, 'Sokoto North'),
(705, 34, 'Sokoto South'),
(706, 34, 'Tambuwal'),
(707, 34, 'Tangaza'),
(708, 35, 'Ardo Kola'),
(709, 35, 'Bali'),
(710, 35, 'Donga'),
(711, 35, 'Gashaka'),
(712, 35, 'Gassol'),
(713, 35, 'Ibi'),
(714, 35, 'Jalingo'),
(715, 35, 'Karim Lamido'),
(716, 35, 'Kumi'),
(717, 35, 'Lau'),
(718, 35, 'Sardauna'),
(719, 35, 'Takum'),
(720, 35, 'Ussa'),
(721, 35, 'Wukari'),
(722, 35, 'Yorro'),
(723, 35, 'Zing'),
(724, 36, 'Bade'),
(725, 36, 'Bursari'),
(726, 36, 'Damaturu'),
(727, 36, 'Fika'),
(728, 36, 'Fune'),
(729, 36, 'Geidam'),
(730, 36, 'Gujba'),
(731, 36, 'Gulani'),
(732, 36, 'Jakusko'),
(733, 36, 'Karasuwa'),
(734, 36, 'Machina'),
(735, 36, 'Nangere'),
(736, 36, 'Nguru'),
(737, 36, 'Potiskum'),
(738, 36, 'Tarmuwa'),
(739, 36, 'Yunusari'),
(740, 36, 'Yusufari'),
(741, 37, 'Anka'),
(742, 37, 'Bakura'),
(743, 37, 'Birnin Magaji/Kiyaw'),
(744, 37, 'Bukkuyum'),
(745, 37, 'Bungudu'),
(746, 37, 'Gummi'),
(747, 37, 'Gusau'),
(748, 37, 'Kaura Namoda'),
(749, 37, 'Maradun'),
(750, 37, 'Shinkafi'),
(751, 37, 'Talata Mafara'),
(752, 37, 'Chafe'),
(753, 37, 'Zurmi');

-- --------------------------------------------------------

--
-- Table structure for table `olevel`
--

CREATE TABLE `olevel` (
  `id` int(11) NOT NULL,
  `form_flag` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `exam_type` varchar(50) NOT NULL,
  `exam_no` varchar(20) NOT NULL,
  `year` int(11) DEFAULT NULL,
  `exam_center` varchar(100) DEFAULT NULL,
  `english` varchar(50) NOT NULL,
  `english_grade` varchar(10) NOT NULL,
  `maths` varchar(50) NOT NULL,
  `maths_grade` varchar(10) NOT NULL,
  `subject1` varchar(50) NOT NULL,
  `subject1_grade` varchar(10) NOT NULL,
  `subject2` varchar(50) NOT NULL,
  `subject2_grade` varchar(10) NOT NULL,
  `subject3` varchar(50) NOT NULL,
  `subject3_grade` varchar(10) NOT NULL,
  `subject4` varchar(50) NOT NULL,
  `subject4_grade` varchar(10) NOT NULL,
  `subject5` varchar(50) DEFAULT NULL,
  `subject5_grade` varchar(10) DEFAULT NULL,
  `subject6` varchar(50) DEFAULT NULL,
  `subject6_grade` varchar(10) DEFAULT NULL,
  `subject7` varchar(50) DEFAULT NULL,
  `subject7_grade` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `olevel`
--

INSERT INTO `olevel` (`id`, `form_flag`, `student_id`, `exam_type`, `exam_no`, `year`, `exam_center`, `english`, `english_grade`, `maths`, `maths_grade`, `subject1`, `subject1_grade`, `subject2`, `subject2_grade`, `subject3`, `subject3_grade`, `subject4`, `subject4_grade`, `subject5`, `subject5_grade`, `subject6`, `subject6_grade`, `subject7`, `subject7_grade`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'WAEC', '2222222', 2018, 'Capital', 'English', 'B3', 'Mathematics', 'F9', 'ISLAMIC STUDIES', 'C6', 'CHEMISTRY', 'C6', 'YORUBA', 'C6', 'ENGLISH LANGUAGE', 'C5', 'ISLAMIC STUDIES', 'B3', 'BIOLOGY', 'B2', 'HAUSA', 'D7', '2023-12-27 13:14:07', '2024-08-28 20:34:04'),
(2, 2, 1, 'NECO', '127001', 2018, 'Fagoji', 'English', 'C4', 'Maths', 'F9', 'IGBO', 'C6', 'HAUSA', 'C4', 'GENERAL MATHEMATICS', 'E8', 'CHEMISTRY', 'C5', 'CIVIC EDUCATION', 'B2', 'AGRICULTURAL SCIENCE', 'F9', 'FURTHER MATHEMATICS', 'B2', '2023-12-27 13:16:00', '2023-12-27 13:16:00'),
(3, 1, 2, 'NABTEB', '2229991', 2020, 'Fatima Private', '', 'B2', '', 'B3', 'FINANCIAL ACCOUNTING', 'C4', 'GEOGRAPHY', 'C5', 'COMMERCE', 'A1', 'GOVERNMENT', 'C4', 'ISLAMIC STUDIES', 'C6', 'ECONOMICS', 'D7', 'CIVIC EDUCATION', 'B3', '2023-12-27 13:44:21', '2023-12-27 13:44:21'),
(4, 1, 8, 'WAEC', '2229993', 2021, 'Golden Brawn', '', 'C5', '', 'C4', 'HAUSA', 'E8', 'FURTHER MATHEMATICS', 'C5', 'COMMERCE', 'D7', 'ECONOMICS', 'C5', 'ISLAMIC STUDIES', 'B2', 'BIOLOGY', 'D7', 'CIVIC EDUCATION', 'E8', '2023-12-27 14:01:34', '2023-12-27 14:01:34');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(255) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `paid_at` datetime NOT NULL,
  `channel` varchar(255) DEFAULT NULL,
  `currency` varchar(3) NOT NULL,
  `ip_address` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `student_id`, `message`, `status`, `reference`, `amount`, `paid_at`, `channel`, `currency`, `ip_address`) VALUES
(1, 1, 'Verification successful', 'success', 'maf379034954', '400000.00', '2023-10-28 02:41:12', 'card', 'NGN', '102.91.71.105');

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `faculty_id`, `name`) VALUES
(1, 3, 'COMPUTER SCIENCE'),
(2, 3, 'INFORMATION TECHNOLOGY'),
(3, 3, 'STATISTICS');

-- --------------------------------------------------------

--
-- Table structure for table `signup`
--

CREATE TABLE `signup` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `other_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `rank` varchar(20) NOT NULL,
  `status` int(1) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `signup`
--

INSERT INTO `signup` (`id`, `first_name`, `last_name`, `other_name`, `email`, `rank`, `status`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Usman', 'Shehu', 'Ayuba', 'iamusmanshehu@gmail.com', '', 0, '$2y$10$bRPKUauL/iLIlpsApyEqsuSKRnI7Wg1P.Zk0kB8JjeRXO/yrdJjbS', '2023-10-25 00:35:39', '2023-12-28 13:50:36'),
(6, 'Musbahu', 'Makama', '', 'musbahu@gmail.com', 'Admission Officer', 1, '$2y$10$S4IfYMhV8dbbho70bTF/qeB.mEhQ4H.vB75/hD67GpjTV4y6i2TqO', '2023-11-03 11:58:02', '2023-12-27 11:26:02'),
(12, 'Abubakar', 'Idrees', '', 'hod_comp@adustech.edu.ng', 'HOD Computer', 1, '$2y$10$WDe7.PO1awJqw8WpXC1Zuex/oW7HPGLpZovyBN7m2S8t.zJY.0WDy', '2024-08-30 18:19:09', '2024-08-30 18:19:09'),
(13, 'Dr Kamfa', 'Math', '', 'hod_mathematics@adustech.edu.ng', 'HOD Mathematics', 1, '$2y$10$crJktGtS2Q6jXvJyOUySCusmPyVq6eu2JD/.ZvPZztfTpShk7882q', '2024-08-30 18:29:57', '2024-09-04 15:43:16'),
(14, 'ABEL', 'ABEL', '', 'abel@gmail.com', '', 0, '$2y$10$a7hX.hKrpF49QwZcPWKJ2e9Z.ZEoDg39J/39q7YT1gACf6j2VNCSu', '2024-08-30 19:40:40', '2024-08-30 19:40:40'),
(16, 'Abdulhamid ', 'Ado Osi', '', 'hod_statistics@adustech.edu.ng', 'HOD STATISTICS', 1, '$2y$10$ud7x73RWKsTbFmoCDJaVjuoPvb5UfH.9v7zR48AQi7PkfZBmkaoKu', '2024-09-04 15:34:29', '2024-09-04 15:34:29');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`) VALUES
(1, 'Abia'),
(2, 'Adamawa'),
(3, 'AkwaIbom'),
(4, 'Anambra'),
(5, 'Bauchi'),
(6, 'Bayelsa'),
(7, 'Benue'),
(8, 'Borno'),
(9, 'Cross River'),
(10, 'Delta'),
(11, 'Ebonyi'),
(12, 'Edo'),
(13, 'Ekiti'),
(14, 'Enugu'),
(15, 'FCT'),
(16, 'Gombe'),
(17, 'Imo'),
(18, 'Jigawa'),
(19, 'Kaduna'),
(20, 'Kano'),
(21, 'Katsina'),
(22, 'Kebbi'),
(23, 'Kogi'),
(24, 'Kwara'),
(25, 'Lagos'),
(26, 'Nasarawa'),
(27, 'Niger'),
(28, 'Ogun'),
(29, 'Ondo'),
(30, 'Osun'),
(31, 'Oyo'),
(32, 'Plateau'),
(33, 'Rivers'),
(34, 'Sokoto'),
(35, 'Taraba'),
(36, 'Yobe'),
(37, 'Zamafara');

-- --------------------------------------------------------

--
-- Table structure for table `system`
--

CREATE TABLE `system` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system`
--

INSERT INTO `system` (`id`, `name`) VALUES
(1, 'FACOMS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applicants`
--
ALTER TABLE `applicants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `choice_of_study`
--
ALTER TABLE `choice_of_study`
  ADD PRIMARY KEY (`id`),
  ADD KEY `applicant_id` (`applicant_id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hod_feedback`
--
ALTER TABLE `hod_feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jamb_results`
--
ALTER TABLE `jamb_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `lga`
--
ALTER TABLE `lga`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `olevel`
--
ALTER TABLE `olevel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `signup`
--
ALTER TABLE `signup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system`
--
ALTER TABLE `system`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `choice_of_study`
--
ALTER TABLE `choice_of_study`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `hod_feedback`
--
ALTER TABLE `hod_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jamb_results`
--
ALTER TABLE `jamb_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `lga`
--
ALTER TABLE `lga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=754;

--
-- AUTO_INCREMENT for table `olevel`
--
ALTER TABLE `olevel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `signup`
--
ALTER TABLE `signup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `system`
--
ALTER TABLE `system`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applicants`
--
ALTER TABLE `applicants`
  ADD CONSTRAINT `applicants_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `signup` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `choice_of_study`
--
ALTER TABLE `choice_of_study`
  ADD CONSTRAINT `choice_of_study_ibfk_1` FOREIGN KEY (`applicant_id`) REFERENCES `signup` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `jamb_results`
--
ALTER TABLE `jamb_results`
  ADD CONSTRAINT `jamb_results_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `signup` (`id`);

--
-- Constraints for table `olevel`
--
ALTER TABLE `olevel`
  ADD CONSTRAINT `olevel_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `signup` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `signup` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
