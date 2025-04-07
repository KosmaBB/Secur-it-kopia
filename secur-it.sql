-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql301.infinityfree.com
-- Generation Time: Mar 28, 2025 at 10:20 AM
-- Server version: 10.6.19-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `secur_it`
--
CREATE DATABASE IF NOT EXISTS `secur_it` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `secur_it`;

-- --------------------------------------------------------

--
-- Table structure for table `about_company`
--

DROP TABLE IF EXISTS `about_company`;
CREATE TABLE IF NOT EXISTS `about_company` (
  `id_about_company` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  PRIMARY KEY (`id_about_company`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_company`
--

INSERT INTO `about_company` (`id_about_company`, `title`, `description`) VALUES
(1, 'Dlaczego Secur-IT?', 'Jesteśmy więcej niż dostawcą usług IT – jesteśmy Twoim partnerem technologicznym. Dzięki naszemu doświadczeniu, elastycznemu podejściu i zaangażowaniu w bezpieczeństwo, pomagamy naszym klientom osiągać cele biznesowe bez obaw o technologiczne przeszkody. Wybierz Secur-IT i zyskaj pewność, że Twoja technologia jest w najlepszych rękach.'),
(2, 'Grupa docelowa:', '<ul>\r\n<li>Małe i średnie przedsiębiorstwa: Firmy, które potrzebują wsparcia w zarządzaniu infrastrukturą IT, ale nie mają własnego działu IT.</li>\r\n<li>Korporacje: Duże organizacje poszukujące zaawansowanych rozwiązań w zakresie cyberbezpieczeństwa i optymalizacji systemów.</li>\r\n<li>Startupy: Innowacyjne firmy, które chcą budować swoje systemy od podstaw, z uwzględnieniem najnowszych technologii.</li>\r\n<li>Instytucje publiczne i edukacyjne: Organizacje wymagające bezpiecznych i stabilnych rozwiązań IT.</li>\r\n</ul>'),
(3, 'Podstawowe wartości:', '<ul>\r\n<li>Niezawodność: Zawsze dotrzymujemy słowa i dostarczamy rozwiązania, na których można polegać.</li>\r\n<li>Bezpieczeństwo: Stawiamy na najnowocześniejsze technologie, aby chronić dane i systemy naszych klientów.</li>\r\n<li>Innowacyjność: Ciągle się rozwijamy, aby oferować rozwiązania na miarę przyszłości.</li>\r\n<li>Partnerstwo: Traktujemy naszych klientów jak partnerów, słuchamy ich potrzeb i dostosowujemy się do ich wymagań.</li>\r\n<li>Profesjonalizm: Działamy z pasją, wiedzą i zaangażowaniem, aby zapewnić najwyższą jakość usług.</li>\r\n</ul>'),
(4, 'Deklaracja misji:', 'W Secur-IT wierzymy, że technologia powinna działać dla Ciebie, a nie przeciwko Tobie. Naszą misją jest dostarczanie kompleksowych, niezawodnych i bezpiecznych rozwiązań IT, które wspierają rozwój biznesu naszych klientów. Dążymy do tego, aby każda firma mogła działać sprawnie, bez obaw o awarie, cyberzagrożenia czy nieefektywne systemy.'),
(5, 'Przemysł:', 'Technologie informatyczne, cyberbezpieczeństwo, zarządzanie infrastrukturą IT');

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

DROP TABLE IF EXISTS `cars`;
CREATE TABLE IF NOT EXISTS `cars` (
  `id_car` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(50) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `production_year` date DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `mileage` varchar(15) DEFAULT NULL,
  `engine_capacity` varchar(20) DEFAULT NULL,
  `power` varchar(10) DEFAULT NULL,
  `id_fuel_type` int(11) DEFAULT NULL,
  `vin_number` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_car`),
  KEY `id_fuel_type` (`id_fuel_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
CREATE TABLE IF NOT EXISTS `companies` (
  `id_company` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(50) DEFAULT NULL,
  `additional_name` varchar(100) DEFAULT NULL,
  `tax` varchar(20) DEFAULT NULL,
  `id_country_code` int(11) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `email_address` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_company`),
  KEY `id_country_code` (`id_country_code`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id_company`, `company_name`, `additional_name`, `tax`, `id_country_code`, `phone_number`, `email_address`) VALUES
(1, 'Secur IT', NULL, 'testNIP', 145, '121212121', 'secur-it@secur-it.pl');

-- --------------------------------------------------------

--
-- Table structure for table `contact_form`
--

DROP TABLE IF EXISTS `contact_form`;
CREATE TABLE IF NOT EXISTS `contact_form` (
  `id_contact_form` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `id_country_code` int(11) DEFAULT NULL,
  `phone_number` varchar(30) DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `consent` tinyint(1) DEFAULT NULL,
  `status` enum('Przyjęto','W trakcje realizacji','Zrealizowano','Oczekuje potwierdzenia','Wysłano','Wolne','Zwrócone','Usunięto') DEFAULT NULL,
  `id_employee` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_contact_form`),
  KEY `id_country_code` (`id_country_code`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

DROP TABLE IF EXISTS `contracts`;
CREATE TABLE IF NOT EXISTS `contracts` (
  `id_contract` int(11) NOT NULL AUTO_INCREMENT,
  `id_contract_type` int(11) DEFAULT NULL,
  `contract_number` varchar(50) DEFAULT NULL,
  `PESEL` varchar(11) DEFAULT NULL,
  `insurance_number` varchar(200) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `salary` int(11) DEFAULT NULL,
  `bonus` int(5) DEFAULT NULL,
  `id_position` int(11) DEFAULT NULL,
  `id_work_location` int(11) DEFAULT NULL,
  `id_department` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_contract`),
  KEY `id_contract_type` (`id_contract_type`),
  KEY `id_position` (`id_position`),
  KEY `id_work_location` (`id_work_location`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contracts`
--

INSERT INTO `contracts` (`id_contract`, `id_contract_type`, `contract_number`, `PESEL`, `insurance_number`, `start_date`, `end_date`, `salary`, `bonus`, `id_position`, `id_work_location`, `id_department`) VALUES
(1, NULL, '2024/02/01/0001', '06250205651', NULL, '2024-02-01', NULL, NULL, NULL, 1, NULL, NULL),
(2, NULL, '2024/02/02/0001', '07251503618', NULL, '2024-02-02', NULL, NULL, NULL, 12, NULL, 1),
(3, NULL, '2024/02/02/0002', NULL, NULL, '2024-02-02', NULL, NULL, NULL, 12, NULL, 1),
(4, NULL, '2024/02/02/0003', NULL, NULL, '2024-02-02', NULL, NULL, NULL, 12, NULL, 1),
(5, NULL, '2024/02/02/0004', NULL, NULL, '2024-02-02', NULL, NULL, NULL, 30, NULL, 1),
(6, NULL, '2024/02/02/0005', NULL, NULL, '2024-02-02', NULL, NULL, NULL, 12, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `contracts_types`
--

DROP TABLE IF EXISTS `contracts_types`;
CREATE TABLE IF NOT EXISTS `contracts_types` (
  `id_contract_type` int(11) NOT NULL AUTO_INCREMENT,
  `contract_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_contract_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `country_codes`
--

DROP TABLE IF EXISTS `country_codes`;
CREATE TABLE IF NOT EXISTS `country_codes` (
  `id_country_code` int(11) NOT NULL AUTO_INCREMENT,
  `country_code` varchar(10) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_country_code`)
) ENGINE=MyISAM AUTO_INCREMENT=210 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `country_codes`
--

INSERT INTO `country_codes` (`id_country_code`, `country_code`, `country`) VALUES
(1, '+93', 'Afganistan'),
(2, '+1907', 'Alaska'),
(3, '+355', 'Albania'),
(4, '+213', 'Algieria'),
(5, '+376', 'Andora'),
(6, '+244', 'Angola'),
(7, '+599', 'Antyle Holenderskie'),
(8, '+966', 'Arabia Saudyjska'),
(9, '+54', 'Argentyna'),
(10, '+374', 'Armenia'),
(11, '+61', 'Australia'),
(12, '+43', 'Austria'),
(13, '+994', 'Azerbejdżan'),
(14, '+1242', 'Bahamy'),
(15, '+973', 'Bahrajn'),
(16, '+880', 'Bangladesz'),
(17, '+32', 'Belgia'),
(18, '+229', 'Benin'),
(19, '+375', 'Białoruś'),
(20, '+591', 'Boliwia'),
(21, '+387', 'Bośnia i Hercegowina'),
(22, '+267', 'Botswana'),
(23, '+55', 'Brazylia'),
(24, '+673', 'Brunei'),
(25, '+359', 'Bułgaria'),
(26, '+226', 'Burkina Faso'),
(27, '+257', 'Burundi'),
(28, '+56', 'Chile'),
(29, '+86', 'Chiny'),
(30, '+385', 'Chorwacja'),
(31, '+682', 'Cook’a Wyspy'),
(32, '+357', 'Cypr'),
(33, '+235', 'Czad'),
(34, '+420', 'Czechy'),
(35, '+45', 'Dania'),
(36, '+246', 'Diego Garcia'),
(37, '+1809', 'Dominikana'),
(38, '+253', 'Dżibuti'),
(39, '+20', 'Egipt'),
(40, '+593', 'Ekwador'),
(41, '+291', 'Erytrea'),
(42, '+372', 'Estonia'),
(43, '+251', 'Etiopia'),
(44, '+500', 'Falklandy'),
(45, '+679', 'Fidżi'),
(46, '+63', 'Filipiny'),
(47, '+358', 'Finlandia'),
(48, '+33', 'Francja'),
(49, '+241', 'Gabon'),
(50, '+220', 'Gambia'),
(51, '+233', 'Ghana'),
(52, '+350', 'Gibraltar'),
(53, '+30', 'Grecja'),
(54, '+299', 'Grenlandia'),
(55, '+995', 'Gruzja'),
(56, '+594', 'Gujana Francuska'),
(57, '+592', 'Gujana'),
(58, '+590', 'Gwadelupa'),
(59, '+245', 'Gwinea – Bissau'),
(60, '+240', 'Gwinea Równikowa'),
(61, '+224', 'Gwinea'),
(62, '+1808', 'Hawaje'),
(63, '+34', 'Hiszpania'),
(64, '+31', 'Holandia'),
(65, '+852', 'Hong Kong'),
(66, '+91', 'Indie'),
(67, '+62', 'Indonezja'),
(68, '+964', 'Irak'),
(69, '+98', 'Iran'),
(70, '+353', 'Irlandia'),
(71, '+354', 'Islandia'),
(72, '+972', 'Izrael'),
(73, '+81', 'Japonia'),
(74, '+967', 'Jemen'),
(75, '+962', 'Jordania'),
(76, '+381', 'Jugosławia'),
(77, '+588', 'Kambodża'),
(78, '+237', 'Kamerun'),
(79, '+1', 'Kanada'),
(80, '+34', 'Kanaryjskie Wyspy'),
(81, '+974', 'Katar'),
(82, '+7', 'Kazachstan'),
(83, '+254', 'Kenia'),
(84, '+996', 'Kirgistan'),
(85, '+686', 'Kiribati'),
(86, '+57', 'Kolumbia'),
(87, '+269', 'Komory'),
(88, '+234', 'Kongo Republika Demokrat.'),
(89, '+242', 'Kongo'),
(90, '+82', 'Korea Południowa'),
(91, '+850', 'Koreańska RL-D'),
(92, '+506', 'Kostaryka'),
(93, '+53', 'Kuba'),
(94, '+965', 'Kuwejt'),
(95, '+856', 'Laos'),
(96, '+266', 'Lesotho'),
(97, '+961', 'Liban'),
(98, '+231', 'Liberia'),
(99, '+218', 'Libia'),
(100, '+423', 'Liechtenstein'),
(101, '+370', 'Litwa'),
(102, '+352', 'Luksemburg'),
(103, '+371', 'Łotwa'),
(104, '+389', 'Macedonia'),
(105, '+261', 'Madagaskar'),
(106, '+853', 'Makau'),
(107, '+265', 'Malawi'),
(108, '+960', 'Malediwy'),
(109, '+60', 'Malezja'),
(110, '+223', 'Mali'),
(111, '+356', 'Malta'),
(112, '+212', 'Maroko'),
(113, '+692', 'Marshalla Wyspy'),
(114, '+596', 'Martynika'),
(115, '+222', 'Mauretania'),
(116, '+230', 'Mauritius'),
(117, '+52', 'Meksyk'),
(118, '+373', 'Mołdawia'),
(119, '+377', 'Monako'),
(120, '+976', 'Mongolia'),
(121, '+258', 'Mozambik'),
(122, '+95', 'Myanmar (Birma)'),
(123, '+264', 'Namibia'),
(124, '+674', 'Nauru'),
(125, '+977', 'Nepal'),
(126, '+49', 'Niemcy'),
(127, '+227', 'Niger'),
(128, '+234', 'Nigeria'),
(129, '+505', 'Nikaragua'),
(130, '+683', 'Niue'),
(131, '+672', 'Norfolk Wyspa'),
(132, '+47', 'Norwegia'),
(133, '+687', 'Nowa Kaledonia'),
(134, '+64', 'Nowa Zelandia'),
(135, '+968', 'Oman'),
(136, '+298', 'Owcze Wyspy'),
(137, '+92', 'Pakistan'),
(138, '+680', 'Palau'),
(139, '+970', 'Palestyna'),
(140, '+507', 'Panama'),
(141, '+675', 'Papua Nowa Gwinea'),
(142, '+595', 'Paragwaj'),
(143, '+51', 'Peru'),
(144, '+689', 'Polinezja Francuska'),
(145, '+48', 'Polska'),
(146, '+1787', 'Portoryko'),
(147, '+351', 'Portugalia'),
(148, '+27', 'Republika Południowej Afryki'),
(149, '+236', 'Republika Środkowoafrykańska'),
(150, '+262', 'Reunion'),
(151, '+7', 'Rosja'),
(152, '+40', 'Rumunia'),
(153, '+250', 'Rwanda'),
(154, '+1869', 'Sain Christopher i Nevis'),
(155, '+1758', 'Saint Lucia'),
(156, '+1809', 'Saint Vincent'),
(157, '+677', 'Salomona Wyspy'),
(158, '+503', 'Salwador'),
(159, '+685', 'Samoa Zachodnie'),
(160, '+684', 'Samoa'),
(161, '+378', 'San Marino'),
(162, '+221', 'Senegal'),
(163, '+248', 'Seszele'),
(164, '+232', 'Sierra Leone'),
(165, '+65', 'Singapur'),
(166, '+421', 'Słowacja'),
(167, '+386', 'Słowenia'),
(168, '+252', 'Somalia'),
(169, '+94', 'Sri Lanka'),
(170, '+1', 'Stany Zjednoczone Ameryki'),
(171, '+268', 'Suazi'),
(172, '+249', 'Sudan'),
(173, '+597', 'Surinam'),
(174, '+963', 'Syria'),
(175, '+41', 'Szwajcaria'),
(176, '+46', 'Szwecja'),
(177, '+290', 'Św. Heleny Wyspa'),
(178, '+508', 'Św. Piotra i Mikeleona Wyspy'),
(179, '+239', 'Św. Tomasza Wyspy'),
(180, '+992', 'Tadżykistan'),
(181, '+66', 'Tajlandia'),
(182, '+886', 'Tajwan'),
(183, '+255', 'Tanzania'),
(184, '+228', 'Togo'),
(185, '+690', 'Tokelau'),
(186, '+676', 'Tonga'),
(187, '+216', 'Tunezja'),
(188, '+90', 'Turcja'),
(189, '+993', 'Turkmenistan'),
(190, '+1649', 'Turks i Caicos'),
(191, '+688', 'Tuvalu'),
(192, '+256', 'Uganda'),
(193, '+380', 'Ukraina'),
(194, '+598', 'Urugwaj'),
(195, '+998', 'Uzbekistan'),
(196, '+678', 'Vanuatu'),
(197, '+681', 'Wallis i Futuna'),
(198, '+39', 'Watykan'),
(199, '+58', 'Wenezuela'),
(200, '+36', 'Węgry'),
(201, '+44', 'Wielka Brytania'),
(202, '+84', 'Wietnam'),
(203, '+39', 'Włochy'),
(204, '+247', 'Wniebowstąpienia Wyspa'),
(205, '+225', 'Wybrzeże Kości Słoniowej'),
(206, '+260', 'Zambia'),
(207, '+259', 'Zanzibar'),
(208, '+238', 'Zielonego Przylądka Wyspy'),
(209, '+263', 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
CREATE TABLE IF NOT EXISTS `departments` (
  `id_department` int(11) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_department`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id_department`, `department_name`) VALUES
(1, 'IT'),
(2, 'HR');

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

DROP TABLE IF EXISTS `discounts`;
CREATE TABLE IF NOT EXISTS `discounts` (
  `id_discount` int(11) NOT NULL AUTO_INCREMENT,
  `discount_value` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id_discount`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`id_discount`, `discount_value`) VALUES
(1, '0,01'),
(2, '0,02'),
(3, '0,03'),
(4, '0,04'),
(5, '0,05'),
(6, '0,06'),
(7, '0,07'),
(8, '0,08'),
(9, '0,09'),
(10, '0,1'),
(11, '0,11'),
(12, '0,12'),
(13, '0,13'),
(14, '0,14'),
(15, '0,15'),
(16, '0,16'),
(17, '0,17'),
(18, '0,18'),
(19, '0,19'),
(20, '0,2'),
(21, '0,21'),
(22, '0,22'),
(23, '0,23'),
(24, '0,24'),
(25, '0,25'),
(26, '0,26'),
(27, '0,27'),
(28, '0,28'),
(29, '0,29'),
(30, '0,3'),
(31, '0,31'),
(32, '0,32'),
(33, '0,33'),
(34, '0,34'),
(35, '0,35'),
(36, '0,36'),
(37, '0,37'),
(38, '0,38'),
(39, '0,39'),
(40, '0,4'),
(41, '0,41'),
(42, '0,42'),
(43, '0,43'),
(44, '0,44'),
(45, '0,45'),
(46, '0,46'),
(47, '0,47'),
(48, '0,48'),
(49, '0,49'),
(50, '0,5'),
(51, '0,51'),
(52, '0,52'),
(53, '0,53'),
(54, '0,54'),
(55, '0,55'),
(56, '0,56'),
(57, '0,57'),
(58, '0,58'),
(59, '0,59'),
(60, '0,6'),
(61, '0,61'),
(62, '0,62'),
(63, '0,63'),
(64, '0,64'),
(65, '0,65'),
(66, '0,66'),
(67, '0,67'),
(68, '0,68'),
(69, '0,69'),
(70, '0,7'),
(71, '0,71'),
(72, '0,72'),
(73, '0,73'),
(74, '0,74'),
(75, '0,75'),
(76, '0,76'),
(77, '0,77'),
(78, '0,78'),
(79, '0,79'),
(80, '0,8'),
(81, '0,81'),
(82, '0,82'),
(83, '0,83'),
(84, '0,84'),
(85, '0,85'),
(86, '0,86'),
(87, '0,87'),
(88, '0,88'),
(89, '0,89'),
(90, '0,9'),
(91, '0,91'),
(92, '0,92'),
(93, '0,93'),
(94, '0,94'),
(95, '0,95'),
(96, '0,96'),
(97, '0,97'),
(98, '0,98'),
(99, '0,99'),
(100, '1');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
  `id_employee` int(11) NOT NULL AUTO_INCREMENT,
  `home_address` varchar(200) DEFAULT NULL,
  `id_contract` int(11) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `photo` varchar(100) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL,
  `id_car` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_employee`),
  KEY `id_contract` (`id_contract`),
  KEY `id_car` (`id_car`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id_employee`, `home_address`, `id_contract`, `date_of_birth`, `photo`, `is_admin`, `id_car`) VALUES
(1, 'Heraklesa 38G, 42-221, Częstochowa, Polska', 1, '2006-05-02', '../images/pracownicy/dawid_mostowski.png', 1, NULL),
(2, 'Rębielice Szlacheckie 111, 42-165 Rębielice Szlacheckie, Polska', 2, '2007-05-15', '../images/pracownicy/oskar_radek.png', 1, NULL),
(3, 'Goździków 61,42-221, Częstochowa, Polska', 3, '2007-07-14', '../images/pracownicy/jaroslaw_kwasny.png', 1, 12, NULL),
(4, NULL, 4, '2006-11-22', '../images/pracownicy/piotr_stefanek.png', 1,  NULL),
(5, NULL, 5, '2007-10-23', '../images/pracownicy/kosma_brzezawski.png', 1, NULL),
(6, 'Długa 168, 42-133, Borowe, Polska\r\n', 6, '2006-01-12', '../images/pracownicy/mikolaj_pluta.png', 1, 12, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fuel_types`
--

DROP TABLE IF EXISTS `fuel_types`;
CREATE TABLE IF NOT EXISTS `fuel_types` (
  `id_fuel_type` int(11) NOT NULL AUTO_INCREMENT,
  `fuel_type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_fuel_type`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fuel_types`
--

INSERT INTO `fuel_types` (`id_fuel_type`, `fuel_type`) VALUES
(1, 'P - benzyna'),
(2, 'D - olej napędowy'),
(3, 'M - mieszanka paliwo-olej'),
(4, 'LPG - gaz płynny propan-butan'),
(5, 'CNG - gaz ziemny skroplony (metan)'),
(6, 'H - wodór'),
(7, 'BD - biodiesel'),
(8, 'E85 - etanol'),
(9, 'EE - energia elektryczna'),
(10, '999 - inne');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
CREATE TABLE IF NOT EXISTS `locations` (
  `id_location` int(11) NOT NULL AUTO_INCREMENT,
  `building_number` varchar(10) DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL,
  `city` varchar(200) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_location`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id_order` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `order_status` enum('Zrealizowane','W trakcie','Oczekuje potwierdzenia','Anulowano','Oczekujące','W koszyku') DEFAULT NULL,
  `id_employee` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_order`),
  KEY `id_employee` (`id_employee`),
  KEY `id_user` (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders_live`
--

DROP TABLE IF EXISTS `orders_live`;
CREATE TABLE IF NOT EXISTS `orders_live` (
  `id_order_live` int(11) NOT NULL AUTO_INCREMENT,
  `id_order` int(11) DEFAULT NULL,
  `id_service` int(11) DEFAULT NULL,
  `order_status` enum('Zrealizowane','W trakcie','Oczekuje potwierdzenia','Anulowano','Oczekujące','W koszyku','Usunięte') DEFAULT NULL,
  `change_date` datetime DEFAULT NULL,
  `id_employee` int(11) DEFAULT NULL,
  `client_description` longtext DEFAULT NULL,
  `employee_description` longtext DEFAULT NULL,
  PRIMARY KEY (`id_order_live`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

DROP TABLE IF EXISTS `positions`;
CREATE TABLE IF NOT EXISTS `positions` (
  `id_position` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_position`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id_position`, `name`) VALUES
(1, 'Prezes'),
(2, 'Współzałożyciel'),
(3, 'Administrator Baz Danych'),
(4, 'Administrator IT'),
(5, 'Administrator Linux'),
(6, 'Administrator Serwerów'),
(7, 'Administrator Sieci'),
(8, 'Administrator Systemu'),
(9, 'Analityk Biznesowy'),
(10, 'Analityk Danych'),
(11, 'Architekt Sieci'),
(12, 'Informatyk'),
(13, 'Kierownik Help Desk'),
(14, 'Konsultant ds. IT'),
(15, 'Konsultant ds. Wsparcia Technicznego'),
(16, 'Pracownik help desk'),
(17, 'Specjalista ds. Cyberzagrożeń'),
(18, 'Specjalista ds. Informatyki'),
(19, 'Specjalista ds. IT'),
(20, 'Specjalista ds. licencji'),
(21, 'Specjalista ds. ochrony danych'),
(22, 'Specjalista ds. Oprogramowania'),
(23, 'Wdrożeniowiec'),
(24, 'Front-end Developer'),
(25, 'Back-end Developer'),
(26, 'Full Stack Developer'),
(27, 'Inżynier DevOps'),
(28, 'Młodszy Programista'),
(29, 'Starszy Programista'),
(30, 'Programista'),
(31, 'Pracownik Tester'),
(32, 'Programista Aplikacji Mobilnych'),
(33, 'Programista baz danych'),
(34, 'Webdeveloper'),
(35, 'Webmaster'),
(36, 'Dyrektor ds personalnych'),
(37, 'Analityk HR'),
(38, 'HR manager'),
(39, 'Specjalista ds. rekrutacji'),
(40, 'Kierownik działu kadr'),
(41, 'Specjalista ds. płac'),
(42, 'Specjalista ds. szkoleń'),
(43, 'Inspektor ds. BHP'),
(44, 'Grafik Komputerowy');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id_post` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `id_approving_employee` int(11) DEFAULT NULL,
  `approval_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id_post`),
  KEY `id_user` (`id_user`),
  KEY `id_approving_employee` (`id_approving_employee`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id_review` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `review_date` date DEFAULT NULL,
  `review_content` longtext DEFAULT NULL,
  PRIMARY KEY (`id_review`),
  KEY `id_user` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id_service` int(11) NOT NULL AUTO_INCREMENT,
  `id_service_type` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `id_department` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_service`),
  KEY `id_service_type` (`id_service_type`),
  KEY `id_department` (`id_department`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id_service`, `id_service_type`, `name`, `description`, `price`, `id_department`) VALUES
(1, 1, 'Konfiguracja sieci firmowej', 'Projektowanie i konfiguracja sieci lokalnych dla małych i średnich firm.', '1500.00', NULL),
(2, 1, 'Diagnostyka problemów sieciowych', 'Analiza i rozwiązywanie problemów związanych z działaniem sieci.', '500.00', NULL),
(3, 1, 'Instalacja punktów dostępowych Wi-Fi', 'Montowanie i konfiguracja punktów dostępowych dla lepszego zasięgu.', '300.00', NULL),
(4, 2, 'Instalacja systemu Windows', 'Instalacja i konfiguracja systemu operacyjnego Windows wraz z niezbędnymi sterownikami.', '200.00', NULL),
(5, 2, 'Konfiguracja systemu Linux', 'Instalacja i konfiguracja dystrybucji Linux, dostosowana do potrzeb użytkownika.', '400.00', NULL),
(6, 2, 'Rozwiązywanie problemów z systemem', 'Diagnostyka i naprawa błędów systemowych w Windows lub Linux.', '250.00', NULL),
(7, 3, 'Tworzenie bazy danych', 'Projektowanie struktury i wdrożenie bazy danych zgodnie z wymaganiami klienta.', '2000.00', NULL),
(8, 3, 'Optymalizacja zapytań SQL', 'Analiza wydajności zapytań i optymalizacja kodu SQL.', '800.00', NULL),
(9, 3, 'Migracja danych', 'Migracja danych między różnymi systemami bazodanowymi.', '1200.00', NULL),
(10, 4, 'Tworzenie strony wizytówki', 'Projektowanie i wdrożenie prostej strony wizytówki dla firm.', '1000.00', NULL),
(11, 4, 'Rozbudowany serwis internetowy', 'Tworzenie serwisu internetowego z funkcjonalnościami dynamicznymi.', '5000.00', NULL),
(12, 4, 'Optymalizacja SEO', 'Dostosowanie strony internetowej do wytycznych wyszukiwarek w celu zwiększenia widoczności.', '700.00', NULL),
(13, 5, 'Czyszczenie i konserwacja sprzętu', 'Profesjonalne czyszczenie wnętrza komputera i wymiana pasty termoprzewodzącej.', '150.00', NULL),
(14, 5, 'Naprawa sprzętu komputerowego', 'Diagnostyka i naprawa usterek sprzętowych w komputerach stacjonarnych i laptopach.', '400.00', NULL),
(15, 5, 'Usuwanie wirusów i złośliwego oprogramowania', 'Skuteczne usuwanie zagrożeń i zabezpieczanie systemu.', '200.00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service_to_order`
--

DROP TABLE IF EXISTS `service_to_order`;
CREATE TABLE IF NOT EXISTS `service_to_order` (
  `id_service_to_order` int(11) NOT NULL AUTO_INCREMENT,
  `id_service` int(11) DEFAULT NULL,
  `id_order` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_service_to_order`),
  KEY `id_service` (`id_service`),
  KEY `id_order` (`id_order`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_types`
--

DROP TABLE IF EXISTS `service_types`;
CREATE TABLE IF NOT EXISTS `service_types` (
  `id_service_type` int(11) NOT NULL AUTO_INCREMENT,
  `service_type` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_service_type`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_types`
--

INSERT INTO `service_types` (`id_service_type`, `service_type`) VALUES
(1, 'Sieci Komputerowe'),
(2, 'Systemy Operacyjne'),
(3, 'Bazy Danych'),
(4, 'Strony Internetowe'),
(5, 'Serwis Komputerowy');

-- --------------------------------------------------------

--
-- Table structure for table `task_history`
--

DROP TABLE IF EXISTS `task_history`;
CREATE TABLE IF NOT EXISTS `task_history` (
  `id_task_history` int(11) NOT NULL AUTO_INCREMENT,
  `id_contact_form` int(11) DEFAULT NULL,
  `id_employee` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_task_history`),
  KEY `id_user` (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `id_employee` int(11) DEFAULT NULL,
  `id_company` int(11) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `id_country_code` int(11) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `email_address` varchar(200) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `is_company_admin` tinyint(1) DEFAULT NULL,
  `id_discount` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  KEY `id_employee` (`id_employee`),
  KEY `id_country_code` (`id_country_code`),
  KEY `id_discount` (`id_discount`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `id_employee`, `id_company`, `first_name`, `last_name`, `id_country_code`, `phone_number`, `email_address`, `username`, `password`, `is_company_admin`, `id_discount`) VALUES
(1, 1, 1, 'Dawid', 'Mostowski', 145, '535525904', 'dawid.mostowski@secur-it.pl', 'dmostowski', '0a122bc6fa5426260c1d55ecdce0bb3765725429', 1, 100),
(2, 2, 1, 'Oskar', 'Radek', 145, '730050715', 'oskar.radek@secur-it.pl', 'oradek', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 0, 50),
(4, 4, 1, 'Piotr', 'Stefanek', 145, '509946309', 'piotr.stefanek@secur-it.pl', 'pstefanek', '230864532d2449de1073852e0af072788bfa2cc1', 0, 50),
(3, 3, 1, 'Jarosław', 'Kwaśny', 145, '605151620', 'jaroslaw.kwasny@secur-it.pl', 'jkwasny', '24567c7ed615084f7e940aeb4e10ca32134078eb', 0, 50),
(8, NULL, NULL, 'Tomasz', 'Szczepanik', 145, '531241582', 't.szczepan@gmail.com', 'Bru', '7d8147deed6a2018d093c4f5093a247251e8ef86', 0, NULL),
(5, 5, 1, 'Kosma', 'Brzeżawski', 145, '534468213', 'kosma.brzezawski@secur-it.pl', 'Kosma', '84a21e493681c445b29f61648f9f3c5b82382341', 0, 50),
(6, 6, 1, 'Mikołaj', 'Pluta', 145, '730308961', 'mikolaj.pluta@secur-it.pl', 'Mikolaj', '0400fc3e6fa36f82ba6171f8cc54de742525ad6f', 0, 50),
(11, NULL, NULL, 'Piotr', 'Koryto', 145, '720879566', 'gamingwafflefn@gmail.com', 'Koki', '28f298e6492dd6309c5b58232ecb187ee432a875', 0, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
