-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 30, 2017 at 01:14 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `segar_utb`
--

-- --------------------------------------------------------

--
-- Table structure for table `stk_after_tests`
--

CREATE TABLE `stk_after_tests` (
  `id` int(10) UNSIGNED NOT NULL,
  `observation` varchar(191) DEFAULT NULL,
  `diagnostic_id` int(10) UNSIGNED NOT NULL,
  `id_prest` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  `leaving` int(11) NOT NULL,
  `arrive` int(11) NOT NULL,
  `distance` int(11) NOT NULL,
  `place` varchar(191) NOT NULL,
  `type` enum('0','1','2') NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stk_approvals`
--

CREATE TABLE `stk_approvals` (
  `id` int(11) NOT NULL,
  `ids` int(11) NOT NULL,
  `remark` text,
  `diagnostic_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stk_assurances`
--

CREATE TABLE `stk_assurances` (
  `id` int(11) NOT NULL,
  `ids` int(11) NOT NULL,
  `date` date NOT NULL,
  `site_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bus_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stk_blocks`
--

CREATE TABLE `stk_blocks` (
  `id` int(10) UNSIGNED NOT NULL,
  `shelf_id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stk_blocks`
--

INSERT INTO `stk_blocks` (`id`, `shelf_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'citroen', '2017-07-18 14:31:40', '2017-07-18 14:32:02'),
(2, 1, 'volvo', '2017-07-18 14:31:50', '2017-07-18 14:31:50'),
(3, 3, 'volvo', '2017-07-18 14:34:02', '2017-07-18 14:34:02');

-- --------------------------------------------------------

--
-- Table structure for table `stk_brands`
--

CREATE TABLE `stk_brands` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stk_brands`
--

INSERT INTO `stk_brands` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'volvo', '2017-07-18 14:21:19', '2017-07-18 14:21:19'),
(2, 'citroen', '2017-07-18 14:21:26', '2017-07-18 14:21:26'),
(3, 'combi', '2017-07-18 14:21:46', '2017-07-18 14:21:46');

-- --------------------------------------------------------

--
-- Table structure for table `stk_buses`
--

CREATE TABLE `stk_buses` (
  `id` int(11) NOT NULL,
  `ids` int(11) NOT NULL,
  `matriculation` varchar(20) NOT NULL,
  `chassis` varchar(20) NOT NULL,
  `first_circulation` date NOT NULL,
  `model_id` int(11) NOT NULL,
  `designation` varchar(50) NOT NULL,
  `site_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stk_categories`
--

CREATE TABLE `stk_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `status` enum('0','1') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stk_categories`
--

INSERT INTO `stk_categories` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'electrique', '0', '2017-07-18 14:25:36', '2017-07-18 14:25:36'),
(2, 'mecanique', '0', '2017-07-18 14:25:41', '2017-07-18 14:25:41'),
(3, 'divers', '0', '2017-07-18 14:25:46', '2017-07-18 14:25:46');

-- --------------------------------------------------------

--
-- Table structure for table `stk_countries`
--

CREATE TABLE `stk_countries` (
  `id` int(11) NOT NULL,
  `iso` char(2) NOT NULL,
  `name` varchar(80) NOT NULL,
  `nicename` varchar(80) NOT NULL,
  `iso3` char(3) DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL,
  `phonecode` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stk_countries`
--

INSERT INTO `stk_countries` (`id`, `iso`, `name`, `nicename`, `iso3`, `numcode`, `phonecode`) VALUES
(1, 'AF', 'AFGHANISTAN', 'Afghanistan', 'AFG', 4, 93),
(2, 'AL', 'ALBANIA', 'Albania', 'ALB', 8, 355),
(3, 'DZ', 'ALGERIA', 'Algeria', 'DZA', 12, 213),
(4, 'AS', 'AMERICAN SAMOA', 'American Samoa', 'ASM', 16, 1684),
(5, 'AD', 'ANDORRA', 'Andorra', 'AND', 20, 376),
(6, 'AO', 'ANGOLA', 'Angola', 'AGO', 24, 244),
(7, 'AI', 'ANGUILLA', 'Anguilla', 'AIA', 660, 1264),
(8, 'AQ', 'ANTARCTICA', 'Antarctica', NULL, NULL, 0),
(9, 'AG', 'ANTIGUA AND BARBUDA', 'Antigua and Barbuda', 'ATG', 28, 1268),
(10, 'AR', 'ARGENTINA', 'Argentina', 'ARG', 32, 54),
(11, 'AM', 'ARMENIA', 'Armenia', 'ARM', 51, 374),
(12, 'AW', 'ARUBA', 'Aruba', 'ABW', 533, 297),
(13, 'AU', 'AUSTRALIA', 'Australia', 'AUS', 36, 61),
(14, 'AT', 'AUSTRIA', 'Austria', 'AUT', 40, 43),
(15, 'AZ', 'AZERBAIJAN', 'Azerbaijan', 'AZE', 31, 994),
(16, 'BS', 'BAHAMAS', 'Bahamas', 'BHS', 44, 1242),
(17, 'BH', 'BAHRAIN', 'Bahrain', 'BHR', 48, 973),
(18, 'BD', 'BANGLADESH', 'Bangladesh', 'BGD', 50, 880),
(19, 'BB', 'BARBADOS', 'Barbados', 'BRB', 52, 1246),
(20, 'BY', 'BELARUS', 'Belarus', 'BLR', 112, 375),
(21, 'BE', 'BELGIUM', 'Belgium', 'BEL', 56, 32),
(22, 'BZ', 'BELIZE', 'Belize', 'BLZ', 84, 501),
(23, 'BJ', 'BENIN', 'Benin', 'BEN', 204, 229),
(24, 'BM', 'BERMUDA', 'Bermuda', 'BMU', 60, 1441),
(25, 'BT', 'BHUTAN', 'Bhutan', 'BTN', 64, 975),
(26, 'BO', 'BOLIVIA', 'Bolivia', 'BOL', 68, 591),
(27, 'BA', 'BOSNIA AND HERZEGOVINA', 'Bosnia and Herzegovina', 'BIH', 70, 387),
(28, 'BW', 'BOTSWANA', 'Botswana', 'BWA', 72, 267),
(29, 'BV', 'BOUVET ISLAND', 'Bouvet Island', NULL, NULL, 0),
(30, 'BR', 'BRAZIL', 'Brazil', 'BRA', 76, 55),
(31, 'IO', 'BRITISH INDIAN OCEAN TERRITORY', 'British Indian Ocean Territory', NULL, NULL, 246),
(32, 'BN', 'BRUNEI DARUSSALAM', 'Brunei Darussalam', 'BRN', 96, 673),
(33, 'BG', 'BULGARIA', 'Bulgaria', 'BGR', 100, 359),
(34, 'BF', 'BURKINA FASO', 'Burkina Faso', 'BFA', 854, 226),
(35, 'BI', 'BURUNDI', 'Burundi', 'BDI', 108, 257),
(36, 'KH', 'CAMBODIA', 'Cambodia', 'KHM', 116, 855),
(37, 'CM', 'CAMEROON', 'Cameroon', 'CMR', 120, 237),
(38, 'CA', 'CANADA', 'Canada', 'CAN', 124, 1),
(39, 'CV', 'CAPE VERDE', 'Cape Verde', 'CPV', 132, 238),
(40, 'KY', 'CAYMAN ISLANDS', 'Cayman Islands', 'CYM', 136, 1345),
(41, 'CF', 'CENTRAL AFRICAN REPUBLIC', 'Central African Republic', 'CAF', 140, 236),
(42, 'TD', 'CHAD', 'Chad', 'TCD', 148, 235),
(43, 'CL', 'CHILE', 'Chile', 'CHL', 152, 56),
(44, 'CN', 'CHINA', 'China', 'CHN', 156, 86),
(45, 'CX', 'CHRISTMAS ISLAND', 'Christmas Island', NULL, NULL, 61),
(46, 'CC', 'COCOS (KEELING) ISLANDS', 'Cocos (Keeling) Islands', NULL, NULL, 672),
(47, 'CO', 'COLOMBIA', 'Colombia', 'COL', 170, 57),
(48, 'KM', 'COMOROS', 'Comoros', 'COM', 174, 269),
(49, 'CG', 'CONGO', 'Congo', 'COG', 178, 242),
(50, 'CD', 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'Congo, the Democratic Republic of the', 'COD', 180, 242),
(51, 'CK', 'COOK ISLANDS', 'Cook Islands', 'COK', 184, 682),
(52, 'CR', 'COSTA RICA', 'Costa Rica', 'CRI', 188, 506),
(53, 'CI', 'COTE D\'IVOIRE', 'Cote D\'Ivoire', 'CIV', 384, 225),
(54, 'HR', 'CROATIA', 'Croatia', 'HRV', 191, 385),
(55, 'CU', 'CUBA', 'Cuba', 'CUB', 192, 53),
(56, 'CY', 'CYPRUS', 'Cyprus', 'CYP', 196, 357),
(57, 'CZ', 'CZECH REPUBLIC', 'Czech Republic', 'CZE', 203, 420),
(58, 'DK', 'DENMARK', 'Denmark', 'DNK', 208, 45),
(59, 'DJ', 'DJIBOUTI', 'Djibouti', 'DJI', 262, 253),
(60, 'DM', 'DOMINICA', 'Dominica', 'DMA', 212, 1767),
(61, 'DO', 'DOMINICAN REPUBLIC', 'Dominican Republic', 'DOM', 214, 1809),
(62, 'EC', 'ECUADOR', 'Ecuador', 'ECU', 218, 593),
(63, 'EG', 'EGYPT', 'Egypt', 'EGY', 818, 20),
(64, 'SV', 'EL SALVADOR', 'El Salvador', 'SLV', 222, 503),
(65, 'GQ', 'EQUATORIAL GUINEA', 'Equatorial Guinea', 'GNQ', 226, 240),
(66, 'ER', 'ERITREA', 'Eritrea', 'ERI', 232, 291),
(67, 'EE', 'ESTONIA', 'Estonia', 'EST', 233, 372),
(68, 'ET', 'ETHIOPIA', 'Ethiopia', 'ETH', 231, 251),
(69, 'FK', 'FALKLAND ISLANDS (MALVINAS)', 'Falkland Islands (Malvinas)', 'FLK', 238, 500),
(70, 'FO', 'FAROE ISLANDS', 'Faroe Islands', 'FRO', 234, 298),
(71, 'FJ', 'FIJI', 'Fiji', 'FJI', 242, 679),
(72, 'FI', 'FINLAND', 'Finland', 'FIN', 246, 358),
(73, 'FR', 'FRANCE', 'France', 'FRA', 250, 33),
(74, 'GF', 'FRENCH GUIANA', 'French Guiana', 'GUF', 254, 594),
(75, 'PF', 'FRENCH POLYNESIA', 'French Polynesia', 'PYF', 258, 689),
(76, 'TF', 'FRENCH SOUTHERN TERRITORIES', 'French Southern Territories', NULL, NULL, 0),
(77, 'GA', 'GABON', 'Gabon', 'GAB', 266, 241),
(78, 'GM', 'GAMBIA', 'Gambia', 'GMB', 270, 220),
(79, 'GE', 'GEORGIA', 'Georgia', 'GEO', 268, 995),
(80, 'DE', 'GERMANY', 'Germany', 'DEU', 276, 49),
(81, 'GH', 'GHANA', 'Ghana', 'GHA', 288, 233),
(82, 'GI', 'GIBRALTAR', 'Gibraltar', 'GIB', 292, 350),
(83, 'GR', 'GREECE', 'Greece', 'GRC', 300, 30),
(84, 'GL', 'GREENLAND', 'Greenland', 'GRL', 304, 299),
(85, 'GD', 'GRENADA', 'Grenada', 'GRD', 308, 1473),
(86, 'GP', 'GUADELOUPE', 'Guadeloupe', 'GLP', 312, 590),
(87, 'GU', 'GUAM', 'Guam', 'GUM', 316, 1671),
(88, 'GT', 'GUATEMALA', 'Guatemala', 'GTM', 320, 502),
(89, 'GN', 'GUINEA', 'Guinea', 'GIN', 324, 224),
(90, 'GW', 'GUINEA-BISSAU', 'Guinea-Bissau', 'GNB', 624, 245),
(91, 'GY', 'GUYANA', 'Guyana', 'GUY', 328, 592),
(92, 'HT', 'HAITI', 'Haiti', 'HTI', 332, 509),
(93, 'HM', 'HEARD ISLAND AND MCDONALD ISLANDS', 'Heard Island and Mcdonald Islands', NULL, NULL, 0),
(94, 'VA', 'HOLY SEE (VATICAN CITY STATE)', 'Holy See (Vatican City State)', 'VAT', 336, 39),
(95, 'HN', 'HONDURAS', 'Honduras', 'HND', 340, 504),
(96, 'HK', 'HONG KONG', 'Hong Kong', 'HKG', 344, 852),
(97, 'HU', 'HUNGARY', 'Hungary', 'HUN', 348, 36),
(98, 'IS', 'ICELAND', 'Iceland', 'ISL', 352, 354),
(99, 'IN', 'INDIA', 'India', 'IND', 356, 91),
(100, 'ID', 'INDONESIA', 'Indonesia', 'IDN', 360, 62),
(101, 'IR', 'IRAN, ISLAMIC REPUBLIC OF', 'Iran, Islamic Republic of', 'IRN', 364, 98),
(102, 'IQ', 'IRAQ', 'Iraq', 'IRQ', 368, 964),
(103, 'IE', 'IRELAND', 'Ireland', 'IRL', 372, 353),
(104, 'IL', 'ISRAEL', 'Israel', 'ISR', 376, 972),
(105, 'IT', 'ITALY', 'Italy', 'ITA', 380, 39),
(106, 'JM', 'JAMAICA', 'Jamaica', 'JAM', 388, 1876),
(107, 'JP', 'JAPAN', 'Japan', 'JPN', 392, 81),
(108, 'JO', 'JORDAN', 'Jordan', 'JOR', 400, 962),
(109, 'KZ', 'KAZAKHSTAN', 'Kazakhstan', 'KAZ', 398, 7),
(110, 'KE', 'KENYA', 'Kenya', 'KEN', 404, 254),
(111, 'KI', 'KIRIBATI', 'Kiribati', 'KIR', 296, 686),
(112, 'KP', 'KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF', 'Korea, Democratic People\'s Republic of', 'PRK', 408, 850),
(113, 'KR', 'KOREA, REPUBLIC OF', 'Korea, Republic of', 'KOR', 410, 82),
(114, 'KW', 'KUWAIT', 'Kuwait', 'KWT', 414, 965),
(115, 'KG', 'KYRGYZSTAN', 'Kyrgyzstan', 'KGZ', 417, 996),
(116, 'LA', 'LAO PEOPLE\'S DEMOCRATIC REPUBLIC', 'Lao People\'s Democratic Republic', 'LAO', 418, 856),
(117, 'LV', 'LATVIA', 'Latvia', 'LVA', 428, 371),
(118, 'LB', 'LEBANON', 'Lebanon', 'LBN', 422, 961),
(119, 'LS', 'LESOTHO', 'Lesotho', 'LSO', 426, 266),
(120, 'LR', 'LIBERIA', 'Liberia', 'LBR', 430, 231),
(121, 'LY', 'LIBYAN ARAB JAMAHIRIYA', 'Libyan Arab Jamahiriya', 'LBY', 434, 218),
(122, 'LI', 'LIECHTENSTEIN', 'Liechtenstein', 'LIE', 438, 423),
(123, 'LT', 'LITHUANIA', 'Lithuania', 'LTU', 440, 370),
(124, 'LU', 'LUXEMBOURG', 'Luxembourg', 'LUX', 442, 352),
(125, 'MO', 'MACAO', 'Macao', 'MAC', 446, 853),
(126, 'MK', 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'Macedonia, the Former Yugoslav Republic of', 'MKD', 807, 389),
(127, 'MG', 'MADAGASCAR', 'Madagascar', 'MDG', 450, 261),
(128, 'MW', 'MALAWI', 'Malawi', 'MWI', 454, 265),
(129, 'MY', 'MALAYSIA', 'Malaysia', 'MYS', 458, 60),
(130, 'MV', 'MALDIVES', 'Maldives', 'MDV', 462, 960),
(131, 'ML', 'MALI', 'Mali', 'MLI', 466, 223),
(132, 'MT', 'MALTA', 'Malta', 'MLT', 470, 356),
(133, 'MH', 'MARSHALL ISLANDS', 'Marshall Islands', 'MHL', 584, 692),
(134, 'MQ', 'MARTINIQUE', 'Martinique', 'MTQ', 474, 596),
(135, 'MR', 'MAURITANIA', 'Mauritania', 'MRT', 478, 222),
(136, 'MU', 'MAURITIUS', 'Mauritius', 'MUS', 480, 230),
(137, 'YT', 'MAYOTTE', 'Mayotte', NULL, NULL, 269),
(138, 'MX', 'MEXICO', 'Mexico', 'MEX', 484, 52),
(139, 'FM', 'MICRONESIA, FEDERATED STATES OF', 'Micronesia, Federated States of', 'FSM', 583, 691),
(140, 'MD', 'MOLDOVA, REPUBLIC OF', 'Moldova, Republic of', 'MDA', 498, 373),
(141, 'MC', 'MONACO', 'Monaco', 'MCO', 492, 377),
(142, 'MN', 'MONGOLIA', 'Mongolia', 'MNG', 496, 976),
(143, 'MS', 'MONTSERRAT', 'Montserrat', 'MSR', 500, 1664),
(144, 'MA', 'MOROCCO', 'Morocco', 'MAR', 504, 212),
(145, 'MZ', 'MOZAMBIQUE', 'Mozambique', 'MOZ', 508, 258),
(146, 'MM', 'MYANMAR', 'Myanmar', 'MMR', 104, 95),
(147, 'NA', 'NAMIBIA', 'Namibia', 'NAM', 516, 264),
(148, 'NR', 'NAURU', 'Nauru', 'NRU', 520, 674),
(149, 'NP', 'NEPAL', 'Nepal', 'NPL', 524, 977),
(150, 'NL', 'NETHERLANDS', 'Netherlands', 'NLD', 528, 31),
(151, 'AN', 'NETHERLANDS ANTILLES', 'Netherlands Antilles', 'ANT', 530, 599),
(152, 'NC', 'NEW CALEDONIA', 'New Caledonia', 'NCL', 540, 687),
(153, 'NZ', 'NEW ZEALAND', 'New Zealand', 'NZL', 554, 64),
(154, 'NI', 'NICARAGUA', 'Nicaragua', 'NIC', 558, 505),
(155, 'NE', 'NIGER', 'Niger', 'NER', 562, 227),
(156, 'NG', 'NIGERIA', 'Nigeria', 'NGA', 566, 234),
(157, 'NU', 'NIUE', 'Niue', 'NIU', 570, 683),
(158, 'NF', 'NORFOLK ISLAND', 'Norfolk Island', 'NFK', 574, 672),
(159, 'MP', 'NORTHERN MARIANA ISLANDS', 'Northern Mariana Islands', 'MNP', 580, 1670),
(160, 'NO', 'NORWAY', 'Norway', 'NOR', 578, 47),
(161, 'OM', 'OMAN', 'Oman', 'OMN', 512, 968),
(162, 'PK', 'PAKISTAN', 'Pakistan', 'PAK', 586, 92),
(163, 'PW', 'PALAU', 'Palau', 'PLW', 585, 680),
(164, 'PS', 'PALESTINIAN TERRITORY, OCCUPIED', 'Palestinian Territory, Occupied', NULL, NULL, 970),
(165, 'PA', 'PANAMA', 'Panama', 'PAN', 591, 507),
(166, 'PG', 'PAPUA NEW GUINEA', 'Papua New Guinea', 'PNG', 598, 675),
(167, 'PY', 'PARAGUAY', 'Paraguay', 'PRY', 600, 595),
(168, 'PE', 'PERU', 'Peru', 'PER', 604, 51),
(169, 'PH', 'PHILIPPINES', 'Philippines', 'PHL', 608, 63),
(170, 'PN', 'PITCAIRN', 'Pitcairn', 'PCN', 612, 0),
(171, 'PL', 'POLAND', 'Poland', 'POL', 616, 48),
(172, 'PT', 'PORTUGAL', 'Portugal', 'PRT', 620, 351),
(173, 'PR', 'PUERTO RICO', 'Puerto Rico', 'PRI', 630, 1787),
(174, 'QA', 'QATAR', 'Qatar', 'QAT', 634, 974),
(175, 'RE', 'REUNION', 'Reunion', 'REU', 638, 262),
(176, 'RO', 'ROMANIA', 'Romania', 'ROM', 642, 40),
(177, 'RU', 'RUSSIAN FEDERATION', 'Russian Federation', 'RUS', 643, 70),
(178, 'RW', 'RWANDA', 'Rwanda', 'RWA', 646, 250),
(179, 'SH', 'SAINT HELENA', 'Saint Helena', 'SHN', 654, 290),
(180, 'KN', 'SAINT KITTS AND NEVIS', 'Saint Kitts and Nevis', 'KNA', 659, 1869),
(181, 'LC', 'SAINT LUCIA', 'Saint Lucia', 'LCA', 662, 1758),
(182, 'PM', 'SAINT PIERRE AND MIQUELON', 'Saint Pierre and Miquelon', 'SPM', 666, 508),
(183, 'VC', 'SAINT VINCENT AND THE GRENADINES', 'Saint Vincent and the Grenadines', 'VCT', 670, 1784),
(184, 'WS', 'SAMOA', 'Samoa', 'WSM', 882, 684),
(185, 'SM', 'SAN MARINO', 'San Marino', 'SMR', 674, 378),
(186, 'ST', 'SAO TOME AND PRINCIPE', 'Sao Tome and Principe', 'STP', 678, 239),
(187, 'SA', 'SAUDI ARABIA', 'Saudi Arabia', 'SAU', 682, 966),
(188, 'SN', 'SENEGAL', 'Senegal', 'SEN', 686, 221),
(189, 'CS', 'SERBIA AND MONTENEGRO', 'Serbia and Montenegro', NULL, NULL, 381),
(190, 'SC', 'SEYCHELLES', 'Seychelles', 'SYC', 690, 248),
(191, 'SL', 'SIERRA LEONE', 'Sierra Leone', 'SLE', 694, 232),
(192, 'SG', 'SINGAPORE', 'Singapore', 'SGP', 702, 65),
(193, 'SK', 'SLOVAKIA', 'Slovakia', 'SVK', 703, 421),
(194, 'SI', 'SLOVENIA', 'Slovenia', 'SVN', 705, 386),
(195, 'SB', 'SOLOMON ISLANDS', 'Solomon Islands', 'SLB', 90, 677),
(196, 'SO', 'SOMALIA', 'Somalia', 'SOM', 706, 252),
(197, 'ZA', 'SOUTH AFRICA', 'South Africa', 'ZAF', 710, 27),
(198, 'GS', 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'South Georgia and the South Sandwich Islands', NULL, NULL, 0),
(199, 'ES', 'SPAIN', 'Spain', 'ESP', 724, 34),
(200, 'LK', 'SRI LANKA', 'Sri Lanka', 'LKA', 144, 94),
(201, 'SD', 'SUDAN', 'Sudan', 'SDN', 736, 249),
(202, 'SR', 'SURINAME', 'Suriname', 'SUR', 740, 597),
(203, 'SJ', 'SVALBARD AND JAN MAYEN', 'Svalbard and Jan Mayen', 'SJM', 744, 47),
(204, 'SZ', 'SWAZILAND', 'Swaziland', 'SWZ', 748, 268),
(205, 'SE', 'SWEDEN', 'Sweden', 'SWE', 752, 46),
(206, 'CH', 'SWITZERLAND', 'Switzerland', 'CHE', 756, 41),
(207, 'SY', 'SYRIAN ARAB REPUBLIC', 'Syrian Arab Republic', 'SYR', 760, 963),
(208, 'TW', 'TAIWAN, PROVINCE OF CHINA', 'Taiwan, Province of China', 'TWN', 158, 886),
(209, 'TJ', 'TAJIKISTAN', 'Tajikistan', 'TJK', 762, 992),
(210, 'TZ', 'TANZANIA, UNITED REPUBLIC OF', 'Tanzania, United Republic of', 'TZA', 834, 255),
(211, 'TH', 'THAILAND', 'Thailand', 'THA', 764, 66),
(212, 'TL', 'TIMOR-LESTE', 'Timor-Leste', NULL, NULL, 670),
(213, 'TG', 'TOGO', 'Togo', 'TGO', 768, 228),
(214, 'TK', 'TOKELAU', 'Tokelau', 'TKL', 772, 690),
(215, 'TO', 'TONGA', 'Tonga', 'TON', 776, 676),
(216, 'TT', 'TRINIDAD AND TOBAGO', 'Trinidad and Tobago', 'TTO', 780, 1868),
(217, 'TN', 'TUNISIA', 'Tunisia', 'TUN', 788, 216),
(218, 'TR', 'TURKEY', 'Turkey', 'TUR', 792, 90),
(219, 'TM', 'TURKMENISTAN', 'Turkmenistan', 'TKM', 795, 7370),
(220, 'TC', 'TURKS AND CAICOS ISLANDS', 'Turks and Caicos Islands', 'TCA', 796, 1649),
(221, 'TV', 'TUVALU', 'Tuvalu', 'TUV', 798, 688),
(222, 'UG', 'UGANDA', 'Uganda', 'UGA', 800, 256),
(223, 'UA', 'UKRAINE', 'Ukraine', 'UKR', 804, 380),
(224, 'AE', 'UNITED ARAB EMIRATES', 'United Arab Emirates', 'ARE', 784, 971),
(225, 'GB', 'UNITED KINGDOM', 'United Kingdom', 'GBR', 826, 44),
(226, 'US', 'UNITED STATES', 'United States', 'USA', 840, 1),
(227, 'UM', 'UNITED STATES MINOR OUTLYING ISLANDS', 'United States Minor Outlying Islands', NULL, NULL, 1),
(228, 'UY', 'URUGUAY', 'Uruguay', 'URY', 858, 598),
(229, 'UZ', 'UZBEKISTAN', 'Uzbekistan', 'UZB', 860, 998),
(230, 'VU', 'VANUATU', 'Vanuatu', 'VUT', 548, 678),
(231, 'VE', 'VENEZUELA', 'Venezuela', 'VEN', 862, 58),
(232, 'VN', 'VIET NAM', 'Viet Nam', 'VNM', 704, 84),
(233, 'VG', 'VIRGIN ISLANDS, BRITISH', 'Virgin Islands, British', 'VGB', 92, 1284),
(234, 'VI', 'VIRGIN ISLANDS, U.S.', 'Virgin Islands, U.s.', 'VIR', 850, 1340),
(235, 'WF', 'WALLIS AND FUTUNA', 'Wallis and Futuna', 'WLF', 876, 681),
(236, 'EH', 'WESTERN SAHARA', 'Western Sahara', 'ESH', 732, 212),
(237, 'YE', 'YEMEN', 'Yemen', 'YEM', 887, 967),
(238, 'ZM', 'ZAMBIA', 'Zambia', 'ZMB', 894, 260),
(239, 'ZW', 'ZIMBABWE', 'Zimbabwe', 'ZWE', 716, 263);

-- --------------------------------------------------------

--
-- Table structure for table `stk_deliveries`
--

CREATE TABLE `stk_deliveries` (
  `id` int(11) NOT NULL,
  `ids` varchar(191) NOT NULL,
  `number` varchar(15) NOT NULL,
  `order` varchar(15) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `supplier_id` int(11) NOT NULL,
  `image` text NOT NULL,
  `delivered_at` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stk_demands`
--

CREATE TABLE `stk_demands` (
  `id` int(11) NOT NULL,
  `ids` varchar(11) NOT NULL,
  `reference` varchar(191) NOT NULL,
  `diagnostic_id` int(11) NOT NULL,
  `state` enum('0','1','2','3') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stk_demand_pieces`
--

CREATE TABLE `stk_demand_pieces` (
  `id` int(11) NOT NULL,
  `ids` int(11) DEFAULT NULL,
  `piece` varchar(191) NOT NULL,
  `quantity` int(11) NOT NULL,
  `delivered` int(11) NOT NULL,
  `state` enum('0','1') NOT NULL,
  `demand_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stk_diagnostics`
--

CREATE TABLE `stk_diagnostics` (
  `id` int(10) UNSIGNED NOT NULL,
  `ids` varchar(11) NOT NULL,
  `reference` varchar(191) NOT NULL,
  `state_id` int(10) UNSIGNED NOT NULL,
  `type` enum('0','1','2','3') NOT NULL,
  `active` enum('0','1','2','3') NOT NULL,
  `site_id` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stk_diagnostic_employees`
--

CREATE TABLE `stk_diagnostic_employees` (
  `id` int(10) UNSIGNED NOT NULL,
  `ids` int(11) DEFAULT NULL,
  `diagnostic_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `title` varchar(191) NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stk_employees`
--

CREATE TABLE `stk_employees` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `site_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(191) NOT NULL,
  `mobile` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `matricule` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stk_employees`
--

INSERT INTO `stk_employees` (`id`, `post_id`, `site_id`, `service_id`, `image`, `username`, `mobile`, `address`, `last_name`, `first_name`, `phone`, `matricule`, `email`, `created_at`, `updated_at`) VALUES
(1, 25, 3, 2, '1507890761.png', 'kone ibrahim', '00000000', '', 'Kone', 'Ibrahim', '22430890', '', '', '2017-02-20 14:02:13', NULL),
(2, 3, 3, 4, '', 'koudou seraphin', '00000000', '', 'Koudou', 'seraphin', '22580890', '', '', '2017-02-20 14:02:13', NULL),
(3, 2, 3, 4, '', 'konate adama', '00000000', '', 'Konate', 'Adama', '24430890', '', '', '2017-02-20 14:02:13', NULL),
(4, 2, 3, 4, '', 'kouassi parfait', '00000000', '', 'Kouassi', 'Parfait', '21430890', '', '', '2017-02-20 14:02:13', NULL),
(7, 1, 3, 4, '', 'kouadio geoffroy ulrich', '44558888', '', 'KOUADIO', 'GEOFFROY ULRICH', '0288514014', '1205555488', '', '2017-02-20 14:01:14', '2017-02-20 14:01:14'),
(8, 2, 0, 4, '', 'koffi koffi paterne', '54588474', '', 'koffi', 'koffi paterne', '02228517', '225segou', '', '2017-02-20 14:02:13', '2017-02-20 14:02:13'),
(13, 3, 3, 4, '', 'kouame fabrice', '21555558', '', 'KOUAME', 'FABRICE', '454510365875', '1205', '', '2017-02-20 16:39:58', '2017-02-20 16:39:58'),
(14, 22, 0, 2, '', 'lutte patrick', '4455200', '', 'LUTH', 'LUTH', '52874510', '0225', '', '2017-02-20 17:31:12', '2017-02-20 17:31:12'),
(42, 24, 3, 2, '1487807169.jpg', 'dagou yves', '2545200587', 'lerfoffefeffefefe', 'DAGOU', 'YVES', '021544885845', '1205874', 'dagou@lo.com', '2017-02-22 23:46:09', '2017-02-22 23:46:09'),
(43, 24, 4, 3, '1487858512.jpg', 'rodrigue rodrigue', '0222222', 'ANGRE', 'RODRIGUE', 'RODRIGUE', '144875222', '12code', 'RODRIGUE@SEO.COM', '2017-02-23 14:01:52', '2017-02-23 14:01:52'),
(50, 20, 0, 3, '', 'benjamin erick', '21001269', '', 'benjamin', 'erick', '8878455', '54aaa', 'erick@utb.com', '2017-04-13 23:53:30', '2017-04-13 23:53:30'),
(54, 3, 0, 3, '', 'dagou10 dagobery02', '8787034302', '', 'dagou10', 'dagobery02', '87854222', '51rrr', 'leoleo@l.com', '2017-04-20 22:24:37', '2017-04-20 22:24:37'),
(57, 20, 0, 3, '', 'anicet mister', '02228525', '', 'anicet', 'mister', '8784552158', '55rrrr', 'anicet@live.fr', '2017-04-20 23:09:15', '2017-04-20 23:09:15'),
(58, 22, 0, 3, '', 'patco patco', '0215487', '', 'patco', 'patco', '55455222', '555ff', 'patco@lo.com', '2017-04-20 23:49:29', '2017-04-20 23:49:29'),
(59, 3, 0, 2, '', 'grgrgrgg rgrgrgrg', '101441', '', 'grgrgrgg', 'rgrgrgrg', '022222252', '25555f', 'rgrg@p.grgr', '2017-04-20 23:51:22', '2017-04-20 23:51:22'),
(60, 1, 0, 3, '', 'zegou1 armel1', '44852102', '', 'zegou1', 'armel1', '', '', 'zegou@lo.com', '2017-04-21 05:25:02', '2017-04-21 05:25:02'),
(61, 25, 0, 8, '', 'bomo ampi', '9534171', '', 'bomo', 'ampi', '', '', 'bomo@lo.com', '2017-05-02 16:44:07', '2017-05-02 16:44:07'),
(62, 2, 0, 2, '', 'ededeededede ededdededdded', '014512000', '', 'ededeededede', 'ededdededdded', '', '', 'ededeededede014@utb.com', '2017-10-13 01:49:36', '2017-10-12 23:49:36'),
(63, 2, 0, 2, '', 'frffrfrffrfrffr rfrffrfrfrffrfr', '021215400', '', 'frffrfrffrfrffr', 'rfrffrfrfrffrfr', '', '', 'frffrfrffrfrffr021@utb.com', '2017-10-13 01:55:23', '2017-10-12 23:55:23'),
(64, 2, 0, 2, '', 'eddeeedde ededdededed', '0215474112100000', '', 'eddeeedde', 'ededdededed', '', '', 'eddeeedde021@utb.com', '2017-10-13 10:26:04', '2017-10-13 08:26:04'),
(65, 2, 1, 2, '1507890875.png', 'ededeeeeded ededeeedeededed', '0215474120', '', 'ededeeeeded', 'ededeeedeededed', '', '', 'kouadioyeoyeoffr.com', '2017-10-13 10:34:35', '2017-10-13 08:34:35'),
(66, 2, 0, 2, '1507891192.png', 'eeddededddededed ededededeede', '0222251474100', '', 'eeddededddededed', 'ededededeede', '', '', 'eeddededddededed022@utb.com', '2017-10-13 10:39:52', '2017-10-13 08:39:52'),
(67, 2, 0, 2, '1507892060.png', '\'\'r\'r\'r\'r\'r\'r\'edede eddddddddddddddddd', '0215489663', '', '\'\'r\'r\'r\'r\'r\'r\'edede', 'eddddddddddddddddd', '', '', '\'\'r\'r\'r\'r\'r\'r\'edede021@utb.com', '2017-10-13 10:54:20', '2017-10-13 08:54:20'),
(68, 2, 0, 2, '1507892245.png', 'ededdeedededed eddddddddddddddddd', '021547412000', '', 'ededdeedededed', 'eddddddddddddddddd', '', '', 'ededdeedededed021@utb.com', '2017-10-13 10:57:25', '2017-10-13 08:57:25'),
(69, 2, 0, 2, '1507892635.png', 'rfrfrffrf effefeeeeeeeeeeeee', '021447845120', '', 'rfrfrffrf', 'effefeeeeeeeeeeeee', '', '', 'rfrfrffrf021@utb.com', '2017-10-13 11:03:55', '2017-10-13 09:03:55'),
(70, 2, 0, 2, '1507894106.png', 'edfedededdedede edfedededdedede', '02157745120', '', 'edfedededdedede', 'edfedededdedede', '', '', 'edfedededdedede021@utb.com', '2017-10-13 11:28:26', '2017-10-13 09:28:26'),
(71, 2, 0, 2, '1507894201.png', 'edddddddddddddd edddddddddddddd', '0214774120', '', 'edddddddddddddd', 'edddddddddddddd', '', '', 'edddddddddddddd021@utb.com', '2017-10-13 11:30:01', '2017-10-13 09:30:01'),
(72, 2, 0, 2, '1507894435.png', 'frfrfffffffffffffffffff frfrfffffffffffffffffff', '021454744120', '', 'frfrfffffffffffffffffff', 'frfrfffffffffffffffffff', '', '', 'frfrfffffffffffffffffff021@utb.com', '2017-10-13 11:33:55', '2017-10-13 09:33:55'),
(73, 2, 0, 2, '1507894506.png', 'edddddddddddd eddddddddddddddd', '02228517', '', 'edddddddddddd', 'eddddddddddddddd', '', '', 'edddddddddddd022@utb.com', '2017-10-13 11:35:06', '2017-10-13 09:35:06'),
(74, 2, 1, 2, '1507894632.png', 'eeddddddddddddddddd efffffeeeeeeeeeeeeee', '021447541200', '', 'eeddddddddddddddddd', 'efffffeeeeeeeeeeeeee', '', '', 'dedzdzdz@lo.com', '2017-10-13 11:37:12', '2017-10-13 09:37:12');

-- --------------------------------------------------------

--
-- Table structure for table `stk_entreprises`
--

CREATE TABLE `stk_entreprises` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `display_name` text NOT NULL,
  `picture` varchar(150) NOT NULL,
  `footer` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stk_entreprises`
--

INSERT INTO `stk_entreprises` (`id`, `name`, `display_name`, `picture`, `footer`, `created_at`, `updated_at`) VALUES
(1, 'UTB', 'Union Des Transport de Bouake', 'segoor.png', 'Union Des Transport de Bouake', '2017-10-28 22:56:58', '2017-10-24 15:45:32');

-- --------------------------------------------------------

--
-- Table structure for table `stk_fields`
--

CREATE TABLE `stk_fields` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` enum('0','1','2') NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stk_fields`
--

INSERT INTO `stk_fields` (`id`, `type`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, '0', 'Allume cigare', 'Allume cigare', '2017-04-07 11:17:01', '2017-04-07 11:17:01'),
(2, '0', 'RK7 / RCD', 'RK7 / RCD', '2017-04-07 11:17:01', '2017-04-07 11:17:01'),
(3, '0', 'Essuie Glace AV', 'Essuie Glace AV', '2017-04-07 11:17:01', '2017-04-07 11:17:01'),
(4, '0', 'Essuie Glace AR', 'Essuie Glace AR', '2017-04-07 11:17:02', '2017-04-07 11:17:02'),
(5, '0', 'Retro ext/int', 'Retro ext/int', '2017-04-07 11:17:02', '2017-04-07 11:17:02'),
(6, '0', 'Cric / Manivelle', 'Cric / Manivelle', '2017-04-07 11:17:02', '2017-04-07 11:17:02'),
(7, '0', 'Roue secours', ' Roue secours', '2017-04-07 11:17:02', '2017-04-07 11:17:02'),
(8, '0', 'Trousse', 'Trousse', '2017-04-07 11:17:02', '2017-04-07 11:17:02'),
(10, '1', 'avg', 'enjoliveurs avant gauche', NULL, NULL),
(11, '1', 'avd', 'enjoliveurs avant droit', NULL, NULL),
(12, '1', 'arg', 'enjoliveurs arriere gauche', NULL, NULL),
(13, '1', 'ard', 'enjoliveurs arriere droit', NULL, NULL),
(14, '2', '0', 'Niveau d\'essence 0', NULL, NULL),
(15, '2', '1/4', 'Niveau d\'essence 1/4', NULL, NULL),
(16, '2', '1/2', 'Niveau d\'essence 1/2', NULL, NULL),
(17, '2', '3/4', 'Niveau d\'essence 3/4', NULL, NULL),
(18, '2', '1', 'Niveau d\'essence 1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stk_field_states`
--

CREATE TABLE `stk_field_states` (
  `id` int(10) UNSIGNED NOT NULL,
  `ids` int(11) DEFAULT NULL,
  `state_id` int(10) UNSIGNED NOT NULL,
  `field_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stk_field_states`
--

INSERT INTO `stk_field_states` (`id`, `ids`, `state_id`, `field_id`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 2, '2017-10-18 08:38:09', '2017-10-18 08:38:09'),
(2, NULL, 1, 5, '2017-10-18 08:38:09', '2017-10-18 08:38:09'),
(3, NULL, 1, 6, '2017-10-18 08:38:09', '2017-10-18 08:38:09'),
(4, NULL, 1, 7, '2017-10-18 08:38:09', '2017-10-18 08:38:09'),
(5, NULL, 1, 11, '2017-10-18 08:38:09', '2017-10-18 08:38:09'),
(6, NULL, 2, 2, '2017-10-18 08:38:57', '2017-10-18 08:38:57'),
(7, NULL, 2, 3, '2017-10-18 08:38:57', '2017-10-18 08:38:57'),
(8, NULL, 2, 7, '2017-10-18 08:38:57', '2017-10-18 08:38:57'),
(9, NULL, 2, 12, '2017-10-18 08:38:57', '2017-10-18 08:38:57'),
(10, NULL, 3, 2, '2017-10-24 09:35:34', '2017-10-24 09:35:34'),
(11, NULL, 3, 5, '2017-10-24 09:35:34', '2017-10-24 09:35:34'),
(12, NULL, 3, 6, '2017-10-24 09:35:34', '2017-10-24 09:35:34'),
(13, NULL, 3, 11, '2017-10-24 09:35:34', '2017-10-24 09:35:34'),
(14, NULL, 4, 2, '2017-10-24 09:44:55', '2017-10-24 09:44:55'),
(15, NULL, 4, 3, '2017-10-24 09:44:55', '2017-10-24 09:44:55'),
(16, NULL, 4, 7, '2017-10-24 09:44:55', '2017-10-24 09:44:55'),
(17, NULL, 4, 12, '2017-10-24 09:44:55', '2017-10-24 09:44:55'),
(18, NULL, 5, 2, '2017-10-24 09:48:14', '2017-10-24 09:48:14'),
(19, NULL, 5, 5, '2017-10-24 09:48:14', '2017-10-24 09:48:14'),
(20, NULL, 5, 6, '2017-10-24 09:48:14', '2017-10-24 09:48:14'),
(21, NULL, 5, 12, '2017-10-24 09:48:14', '2017-10-24 09:48:14'),
(22, NULL, 6, 6, '2017-10-24 12:08:15', '2017-10-24 12:08:15'),
(23, NULL, 6, 11, '2017-10-24 12:08:15', '2017-10-24 12:08:15'),
(24, NULL, 7, 6, '2017-10-24 12:13:06', '2017-10-24 12:13:06'),
(25, NULL, 7, 8, '2017-10-24 12:13:06', '2017-10-24 12:13:06'),
(26, NULL, 7, 12, '2017-10-24 12:13:06', '2017-10-24 12:13:06'),
(27, NULL, 7, 13, '2017-10-24 12:13:06', '2017-10-24 12:13:06'),
(28, NULL, 8, 6, '2017-10-24 12:15:16', '2017-10-24 12:15:16'),
(29, NULL, 8, 8, '2017-10-24 12:15:16', '2017-10-24 12:15:16'),
(30, NULL, 8, 10, '2017-10-24 12:15:16', '2017-10-24 12:15:16'),
(31, NULL, 9, 6, '2017-10-24 12:16:35', '2017-10-24 12:16:35'),
(32, NULL, 9, 11, '2017-10-24 12:16:35', '2017-10-24 12:16:35'),
(33, NULL, 10, 6, '2017-10-24 12:41:24', '2017-10-24 12:41:24'),
(34, NULL, 10, 7, '2017-10-24 12:41:24', '2017-10-24 12:41:24'),
(35, NULL, 11, 3, '2017-10-24 13:09:46', '2017-10-24 13:09:46'),
(36, NULL, 11, 7, '2017-10-24 13:09:46', '2017-10-24 13:09:46'),
(37, NULL, 11, 11, '2017-10-24 13:09:46', '2017-10-24 13:09:46'),
(38, NULL, 12, 3, '2017-10-24 13:10:03', '2017-10-24 13:10:03'),
(39, NULL, 12, 6, '2017-10-24 13:10:03', '2017-10-24 13:10:03'),
(40, NULL, 12, 11, '2017-10-24 13:10:03', '2017-10-24 13:10:03'),
(41, NULL, 13, 7, '2017-10-24 13:10:22', '2017-10-24 13:10:22'),
(42, NULL, 13, 11, '2017-10-24 13:10:22', '2017-10-24 13:10:22'),
(43, NULL, 14, 1, '2017-10-24 15:23:14', '2017-10-24 15:23:14'),
(44, NULL, 14, 2, '2017-10-24 15:23:14', '2017-10-24 15:23:14'),
(45, NULL, 14, 6, '2017-10-24 15:23:14', '2017-10-24 15:23:14'),
(46, NULL, 14, 8, '2017-10-24 15:23:14', '2017-10-24 15:23:14'),
(47, NULL, 14, 12, '2017-10-24 15:23:14', '2017-10-24 15:23:14'),
(48, NULL, 15, 5, '2017-10-24 15:25:02', '2017-10-24 15:25:02'),
(49, NULL, 15, 6, '2017-10-24 15:25:02', '2017-10-24 15:25:02'),
(50, NULL, 15, 11, '2017-10-24 15:25:02', '2017-10-24 15:25:02'),
(51, NULL, 16, 2, '2017-10-24 23:41:04', '2017-10-24 23:41:04'),
(52, NULL, 16, 6, '2017-10-24 23:41:05', '2017-10-24 23:41:05'),
(53, NULL, 16, 7, '2017-10-24 23:41:05', '2017-10-24 23:41:05'),
(54, NULL, 16, 12, '2017-10-24 23:41:05', '2017-10-24 23:41:05'),
(55, NULL, 17, 6, '2017-10-24 23:41:33', '2017-10-24 23:41:33'),
(56, NULL, 17, 12, '2017-10-24 23:41:33', '2017-10-24 23:41:33'),
(57, NULL, 18, 6, '2017-10-24 23:41:55', '2017-10-24 23:41:55'),
(58, NULL, 18, 13, '2017-10-24 23:41:55', '2017-10-24 23:41:55'),
(59, NULL, 19, 2, '2017-10-28 21:15:44', '2017-10-28 21:15:44'),
(60, NULL, 19, 6, '2017-10-28 21:15:44', '2017-10-28 21:15:44'),
(61, NULL, 19, 11, '2017-10-28 21:15:44', '2017-10-28 21:15:44'),
(62, NULL, 19, 12, '2017-10-28 21:15:44', '2017-10-28 21:15:44'),
(63, NULL, 20, 6, '2017-10-28 21:16:44', '2017-10-28 21:16:44'),
(64, NULL, 20, 11, '2017-10-28 21:16:44', '2017-10-28 21:16:44'),
(65, NULL, 20, 12, '2017-10-28 21:16:44', '2017-10-28 21:16:44'),
(66, NULL, 21, 6, '2017-10-28 21:17:40', '2017-10-28 21:17:40'),
(67, NULL, 21, 7, '2017-10-28 21:17:40', '2017-10-28 21:17:40'),
(68, NULL, 21, 13, '2017-10-28 21:17:40', '2017-10-28 21:17:40'),
(69, NULL, 22, 7, '2017-10-28 21:23:38', '2017-10-28 21:23:38'),
(70, NULL, 22, 13, '2017-10-28 21:23:38', '2017-10-28 21:23:38'),
(71, NULL, 23, 7, '2017-10-28 21:24:47', '2017-10-28 21:24:47'),
(72, NULL, 23, 11, '2017-10-28 21:24:47', '2017-10-28 21:24:47'),
(73, NULL, 24, 2, '2017-10-28 21:26:56', '2017-10-28 21:26:56'),
(74, NULL, 24, 6, '2017-10-28 21:26:56', '2017-10-28 21:26:56'),
(75, NULL, 24, 7, '2017-10-28 21:26:56', '2017-10-28 21:26:56'),
(76, NULL, 24, 13, '2017-10-28 21:26:56', '2017-10-28 21:26:56'),
(77, NULL, 25, 6, '2017-10-28 21:34:20', '2017-10-28 21:34:20'),
(78, NULL, 25, 7, '2017-10-28 21:34:20', '2017-10-28 21:34:20'),
(79, NULL, 25, 13, '2017-10-28 21:34:20', '2017-10-28 21:34:20'),
(80, NULL, 26, 6, '2017-10-28 21:35:04', '2017-10-28 21:35:04'),
(81, NULL, 26, 7, '2017-10-28 21:35:04', '2017-10-28 21:35:04'),
(82, NULL, 26, 8, '2017-10-28 21:35:04', '2017-10-28 21:35:04'),
(83, NULL, 26, 11, '2017-10-28 21:35:05', '2017-10-28 21:35:05');

-- --------------------------------------------------------

--
-- Table structure for table `stk_images`
--

CREATE TABLE `stk_images` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `state_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stk_inventories`
--

CREATE TABLE `stk_inventories` (
  `id` int(10) UNSIGNED NOT NULL,
  `stock_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `old_quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stk_item_stocks`
--

CREATE TABLE `stk_item_stocks` (
  `id` int(10) UNSIGNED NOT NULL,
  `stock_id` int(11) NOT NULL,
  `ids` varchar(191) NOT NULL,
  `movement_stock_id` varchar(191) NOT NULL,
  `quantity` int(11) NOT NULL,
  `quantity_old` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stk_item_stocks`
--

INSERT INTO `stk_item_stocks` (`id`, `stock_id`, `ids`, `movement_stock_id`, `quantity`, `quantity_old`, `created_at`, `updated_at`) VALUES
(1, 5, '1505745064', '1', 5, 235, '2017-09-18 14:31:04', '2017-09-18 14:31:04'),
(2, 2, '1505745064', '1', 1, 130, '2017-09-18 14:31:04', '2017-09-18 14:31:04'),
(3, 2, '1505745753', '2', 2, 129, '2017-09-18 14:42:33', '2017-09-18 14:42:33'),
(4, 2, '1505745778', '3', -1, 127, '2017-09-18 14:42:58', '2017-09-18 14:42:58'),
(5, 4, '1505745803', '4', 1, 812, '2017-09-18 14:43:23', '2017-09-18 14:43:23'),
(6, 3, '1505745804', '4', 0, 196, '2017-09-18 14:43:24', '2017-09-18 14:43:24'),
(7, 4, '1505745817', '5', 1, 811, '2017-09-18 14:43:37', '2017-09-18 14:43:37'),
(8, 4, '1508551153', '6', 5, 810, '2017-10-20 23:59:13', '2017-10-20 23:59:13'),
(9, 4, '1508551172', '7', 5, 805, '2017-10-20 23:59:32', '2017-10-20 23:59:32'),
(10, 5, '1508551633', '8', 2, 230, '2017-10-21 00:07:13', '2017-10-21 00:07:13'),
(11, 5, '1508551660', '9', 1, 228, '2017-10-21 00:07:40', '2017-10-21 00:07:40'),
(12, 5, '1508551708', '10', 1, 227, '2017-10-21 00:08:28', '2017-10-21 00:08:28'),
(13, 5, '1508551773', '11', 1, 226, '2017-10-21 00:09:33', '2017-10-21 00:09:33'),
(14, 5, '1508713437', '12', 10, 225, '2017-10-22 21:03:57', '2017-10-22 21:03:57'),
(15, 3, '1508713437', '12', 15, 196, '2017-10-22 21:03:57', '2017-10-22 21:03:57'),
(16, 4, '1508838974', '13', 10, 800, '2017-10-24 07:56:14', '2017-10-24 07:56:14'),
(17, 7, '1508846032', '14', 1, 15410, '2017-10-24 09:53:52', '2017-10-24 09:53:52'),
(18, 6, '1508846032', '14', 10, 15400, '2017-10-24 09:53:52', '2017-10-24 09:53:52'),
(19, 8, '1508846142', '15', 1, 1540, '2017-10-24 09:55:42', '2017-10-24 09:55:42'),
(20, 8, '1508846142', '15', 3, 1539, '2017-10-24 09:55:42', '2017-10-24 09:55:42'),
(21, 8, '1508846229', '16', 1, 1536, '2017-10-24 09:57:09', '2017-10-24 09:57:09'),
(22, 8, '1508846230', '16', 1, 1535, '2017-10-24 09:57:10', '2017-10-24 09:57:10'),
(23, 8, '1508857121', '17', 10, 1534, '2017-10-24 12:58:41', '2017-10-24 12:58:41'),
(24, 8, '1508857122', '17', 15, 1524, '2017-10-24 12:58:42', '2017-10-24 12:58:42'),
(25, 7, '1508858937', '18', 100, 15409, '2017-10-24 13:28:57', '2017-10-24 13:28:57'),
(26, 8, '1508858963', '19', 156, 1509, '2017-10-24 13:29:23', '2017-10-24 13:29:23'),
(27, 8, '1508859016', '20', 1, 1353, '2017-10-24 13:30:16', '2017-10-24 13:30:16'),
(28, 8, '1508859063', '21', 1, 1352, '2017-10-24 13:31:03', '2017-10-24 13:31:03'),
(29, 6, '1508859133', '22', 10, 15390, '2017-10-24 13:32:13', '2017-10-24 13:32:13'),
(30, 6, '1508859133', '22', 15, 15380, '2017-10-24 13:32:13', '2017-10-24 13:32:13'),
(31, 7, '1508859171', '23', 10, 15309, '2017-10-24 13:32:51', '2017-10-24 13:32:51'),
(32, 7, '1508859229', '24', -109, 15299, '2017-10-24 13:33:49', '2017-10-24 13:33:49'),
(33, 8, '1508859265', '25', 10, 1351, '2017-10-24 13:34:25', '2017-10-24 13:34:25'),
(34, 6, '1508859434', '26', 10, 15365, '2017-10-24 13:37:14', '2017-10-24 13:37:14'),
(35, 8, '1508863077', '27', 20, 1341, '2017-10-24 14:37:57', '2017-10-24 14:37:57'),
(36, 6, '1508890961', '28', 15, 15355, '2017-10-24 22:22:41', '2017-10-24 22:22:41'),
(37, 7, '1508891348', '29', 10, 15408, '2017-10-24 22:29:08', '2017-10-24 22:29:08'),
(38, 7, '1508891671', '30', 30, 15398, '2017-10-24 22:34:31', '2017-10-24 22:34:31'),
(39, 7, '1508895410', '31', 15, 15368, '2017-10-24 23:36:50', '2017-10-24 23:36:50'),
(40, 5, '1508895878', '32', 12, 215, '2017-10-24 23:44:38', '2017-10-24 23:44:38'),
(41, 8, '1509311494', '33', 10, 1321, '2017-10-29 20:11:34', '2017-10-29 20:11:34'),
(42, 7, '1509313421', '34', 10, 15353, '2017-10-29 20:43:41', '2017-10-29 20:43:41'),
(43, 7, '1509313448', '35', 2, 15343, '2017-10-29 20:44:08', '2017-10-29 20:44:08'),
(44, 8, '1509313604', '36', 3, 1311, '2017-10-29 20:46:44', '2017-10-29 20:46:44');

-- --------------------------------------------------------

--
-- Table structure for table `stk_migrations`
--

CREATE TABLE `stk_migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stk_migrations`
--

INSERT INTO `stk_migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2017_03_23_163907_entrust_setup_tables', 1),
(4, '2017_03_26_142758_create_stock_table', 1),
(5, '2017_03_27_0000000_create_vehicle_table', 1),
(6, '2017_04_10_093023_create_services-table', 1),
(7, '2017_04_28_110625_create_store_table', 2),
(8, '2013_04_09_062329_create_revisions_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `stk_models`
--

CREATE TABLE `stk_models` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `brand_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stk_models`
--

INSERT INTO `stk_models` (`id`, `name`, `brand_id`, `created_at`, `updated_at`) VALUES
(1, 'v60', 1, '2017-07-18 14:22:07', '2017-07-18 14:22:07'),
(2, 'xv70', 1, '2017-07-18 14:22:28', '2017-07-18 14:22:28'),
(3, 'c4', 2, '2017-07-18 14:24:31', '2017-07-18 14:24:31'),
(4, 'n2024', 2, '2017-07-18 14:24:41', '2017-07-18 14:24:41'),
(5, 'c12', 3, '2017-07-18 14:24:49', '2017-07-18 14:24:49');

-- --------------------------------------------------------

--
-- Table structure for table `stk_movement_stocks`
--

CREATE TABLE `stk_movement_stocks` (
  `id` int(11) NOT NULL,
  `ids` int(11) NOT NULL,
  `reference` varchar(191) NOT NULL,
  `demand_id` int(11) DEFAULT NULL,
  `delivery_id` int(11) DEFAULT NULL,
  `type` enum('0','1','2','3') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stk_observation_operation_revisions`
--

CREATE TABLE `stk_observation_operation_revisions` (
  `id` int(11) NOT NULL,
  `revision_id` int(11) NOT NULL,
  `operation_technique_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stk_observation_operation_techniques`
--

CREATE TABLE `stk_observation_operation_techniques` (
  `id` int(11) NOT NULL,
  `visit_technique_id` int(11) NOT NULL,
  `operation_technique_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stk_observation_repairs`
--

CREATE TABLE `stk_observation_repairs` (
  `id` int(11) NOT NULL,
  `observation` text NOT NULL,
  `hours` varchar(200) NOT NULL,
  `repair_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stk_observation_revisions`
--

CREATE TABLE `stk_observation_revisions` (
  `id` int(11) NOT NULL,
  `observation` text CHARACTER SET latin1 NOT NULL,
  `hours` varchar(100) CHARACTER SET latin1 NOT NULL,
  `date` datetime NOT NULL,
  `employee_id` int(11) NOT NULL,
  `revision_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stk_observation_techniques`
--

CREATE TABLE `stk_observation_techniques` (
  `id` int(11) NOT NULL,
  `visit_technique_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `hours` varchar(100) CHARACTER SET latin1 NOT NULL,
  `observation` text CHARACTER SET latin1 NOT NULL,
  `employee_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stk_operation_revisions`
--

CREATE TABLE `stk_operation_revisions` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(191) NOT NULL,
  `type_operation_revision_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stk_operation_techniques`
--

CREATE TABLE `stk_operation_techniques` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(191) NOT NULL,
  `type_operation_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stk_password_resets`
--

CREATE TABLE `stk_password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stk_permissions`
--

CREATE TABLE `stk_permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `type` varchar(191) NOT NULL,
  `display_name` varchar(191) DEFAULT NULL,
  `description` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stk_permissions`
--

INSERT INTO `stk_permissions` (`id`, `name`, `type`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Reception du car', 'Reception du car', 'Reception du car', 'Reception du car', '2017-10-16 22:00:00', '2017-10-15 22:00:00'),
(2, 'diagnostique', 'diagnostique', 'diagnostique', 'diagnostique', '2017-10-17 22:00:00', '2017-10-12 22:00:00'),
(3, 'reparation', 'reparation', 'reparation', 'reparation', '2017-10-18 22:00:00', '2017-10-25 22:00:00'),
(4, 'revision', 'revision', 'revision', 'revision', '2017-10-10 22:00:00', '2017-10-19 22:00:00'),
(5, 'visite_technique', 'visite_technique', 'visite_technique', 'visite_technique', '2017-10-24 22:00:00', '2017-10-19 22:00:00'),
(6, 'essai apres travaux', 'essai apres travaux', 'essai apres travaux', 'essai apres travaux', '2017-10-17 22:00:00', '2017-10-26 22:00:00'),
(7, 'approbation des pieces', 'approbation des pieces', 'approbation des pieces', 'approbation des pieces', '2017-10-18 22:00:00', '2017-10-18 22:00:00'),
(8, 'gestion de stocks', 'gestion de stocks', 'gestion de stocks', 'gestion de stocks', '2017-10-10 22:00:00', '2017-10-14 22:00:00'),
(9, 'gestion des cars', 'gestion des cars', 'gestion des cars', 'gestion des cars', '2017-10-24 22:00:00', '2017-10-25 22:00:00'),
(10, 'enregistrement des employés', 'enregistrement des employés', 'enregistrement des employés', 'enregistrement des employés', '2017-10-17 22:00:00', '2017-10-10 22:00:00'),
(11, 'liste des comptes', 'liste des comptes', 'liste des comptes', 'liste des comptes', '2017-10-17 22:00:00', '2017-10-11 22:00:00'),
(12, 'gestion des acces', 'gestion des acces', 'gestion des acces', 'gestion des acces', '2017-10-17 22:00:00', '2017-10-26 22:00:00'),
(13, 'parametrage des cars', 'parametrage des cars', 'parametrage des cars', 'parametrage des cars', '2017-10-16 22:00:00', '2017-10-30 23:00:00'),
(14, 'parametrage des stocks', 'parametrage des stocks', 'parametrage des stocks', 'parametrage des stocks', '2017-10-16 22:00:00', '2017-10-23 22:00:00'),
(15, 'parametrage des services et postes', 'parametrage des services et postes', 'parametrage des services et postes', 'parametrage des services et postes', '2017-10-10 22:00:00', '2017-10-25 22:00:00'),
(16, 'parametrage des entrepots', 'parametrage des entrepots', 'parametrage des entrepots', 'parametrage des entrepots', '2017-10-17 22:00:00', '2017-10-11 22:00:00'),
(17, 'parametrage des sites', 'parametrage des sites', 'parametrage des sites', 'parametrage des sites', '2017-10-11 22:00:00', '2017-10-17 22:00:00'),
(18, 'parametrage des informations de l entréprise', 'parametrage des informations de l entréprise', 'parametrage des informations de l entréprise', 'parametrage des informations de l entréprise', '2017-10-25 22:00:00', '2017-10-19 22:00:00'),
(19, 'archives', 'archives', 'archives', 'archives', '2017-10-18 22:00:00', '2017-10-26 22:00:00'),
(20, 'documents techniques', 'documents techniques', 'documents techniques', 'documents techniques', '2017-10-18 22:00:00', '2017-10-19 22:00:00'),
(22, 'tableau de bord administration générale', 'tableau de bord administration générale', 'tableau de bord administration générale', 'tableau de bord administration générale', '2017-10-04 22:00:00', '2017-10-11 22:00:00'),
(23, 'tableau de bord admin', 'tableau de bord admin', 'tableau de bord admin', 'tableau de bord admin', '2017-10-18 22:00:00', '2017-10-25 22:00:00'),
(24, 'tableau de bord reception', 'tableau de bord reception', 'tableau de bord reception', 'tableau de bord reception', '2017-10-25 22:00:00', '2017-10-19 22:00:00'),
(25, 'tableau de bord stock', 'tableau de bord stock', 'tableau de bord stock', 'tableau de bord stock', '2017-10-17 22:00:00', '2017-10-26 22:00:00'),
(26, 'tableau de bord technicien', 'tableau de bord technicien', 'tableau de bord technicien', 'tableau de bord technicien', '2017-10-26 22:00:00', '2017-10-25 22:00:00'),
(27, 'tableau de bord chef technicien', 'tableau de bord chef technicien', 'tableau de bord chef technicien', 'tableau de bord chef technicien', '2017-10-11 22:00:00', '2017-10-04 22:00:00'),
(28, 'historique', 'historique', 'historique', 'historique', '2017-10-18 22:00:00', '2017-10-11 22:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `stk_permission_role`
--

CREATE TABLE `stk_permission_role` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stk_permission_role`
--

INSERT INTO `stk_permission_role` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(22, 1);

-- --------------------------------------------------------

--
-- Table structure for table `stk_pictures`
--

CREATE TABLE `stk_pictures` (
  `id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stk_pieces`
--

CREATE TABLE `stk_pieces` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prix` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stk_posts`
--

CREATE TABLE `stk_posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `service_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `stk_posts`
--

INSERT INTO `stk_posts` (`id`, `name`, `service_id`, `created_at`, `updated_at`) VALUES
(2, 'chef d attelier', 2, '2017-10-12 12:12:12', '2017-10-12 10:12:12'),
(25, 'gestionnaire de stock', 12, '2017-10-12 02:00:19', '2017-10-12 00:00:19'),
(26, 'chef', 14, '2017-10-13 14:33:26', '2017-10-13 12:33:26');

-- --------------------------------------------------------

--
-- Table structure for table `stk_processes`
--

CREATE TABLE `stk_processes` (
  `id` int(10) UNSIGNED NOT NULL,
  `ids` int(11) NOT NULL,
  `reference` varchar(191) NOT NULL,
  `state_id` int(10) UNSIGNED NOT NULL,
  `type` enum('0','1','2','3') NOT NULL,
  `site_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stk_rays`
--

CREATE TABLE `stk_rays` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stk_rays`
--

INSERT INTO `stk_rays` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'electrique', '2017-07-18 14:30:53', '2017-07-18 14:30:53'),
(2, 'mecanique', '2017-07-18 14:31:00', '2017-07-18 14:31:00');

-- --------------------------------------------------------

--
-- Table structure for table `stk_releases`
--

CREATE TABLE `stk_releases` (
  `id` int(11) NOT NULL,
  `after_test_id` int(11) NOT NULL,
  `observation` varchar(200) CHARACTER SET latin1 NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `type` varchar(10) CHARACTER SET latin1 NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stk_repairs`
--

CREATE TABLE `stk_repairs` (
  `id` int(11) NOT NULL,
  `ids` varchar(11) NOT NULL,
  `diagnostic_id` int(11) NOT NULL,
  `state` enum('0','1','2','3','4','5') NOT NULL,
  `site_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stk_revisionns`
--

CREATE TABLE `stk_revisionns` (
  `id` int(11) NOT NULL,
  `ids` varchar(11) NOT NULL,
  `state` enum('0','1','2','3','4','5') NOT NULL,
  `diagnostic_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stk_revisions`
--

CREATE TABLE `stk_revisions` (
  `id` int(10) UNSIGNED NOT NULL,
  `revisionable_type` varchar(191) NOT NULL,
  `revisionable_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `key` varchar(191) NOT NULL,
  `old_value` text,
  `new_value` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stk_roles`
--

CREATE TABLE `stk_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `type` varchar(191) NOT NULL,
  `display_name` varchar(191) DEFAULT NULL,
  `description` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stk_roles`
--

INSERT INTO `stk_roles` (`id`, `name`, `type`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'administrator', '', NULL, NULL, '2017-04-07 11:16:59', '2017-10-12 00:27:21'),
(40, 'stocker', '', 'gestion de stock', 'il gere le stock quoi', '2017-09-25 14:06:56', '2017-09-25 14:06:56'),
(41, 'crffrffrfrrr', '', 'crffrffrfrrr', 'crffrffrfrrr', '2017-10-11 23:40:35', '2017-10-11 23:40:35'),
(42, 'edeededede', '', 'edeededede', 'edeededede', '2017-10-11 23:51:54', '2017-10-11 23:51:54'),
(43, 'gestionnaire de stock', '', 'gestionnaire de stock', 'gestionnaire de stock', '2017-10-12 00:00:19', '2017-10-12 00:00:19'),
(44, 'chef d attelier', '', 'chef d attelier', 'chef d attelier', '2017-10-12 10:12:12', '2017-10-12 10:12:12'),
(45, 'chef', '', 'chef', 'chef', '2017-10-13 12:33:26', '2017-10-13 12:33:26');

-- --------------------------------------------------------

--
-- Table structure for table `stk_role_user`
--

CREATE TABLE `stk_role_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stk_role_user`
--

INSERT INTO `stk_role_user` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 2),
(2, 8),
(3, 5),
(3, 40),
(4, 40),
(5, 41),
(6, 1),
(7, 1),
(8, 2),
(9, 3);

-- --------------------------------------------------------

--
-- Table structure for table `stk_services`
--

CREATE TABLE `stk_services` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stk_services`
--

INSERT INTO `stk_services` (`id`, `name`, `display_name`, `created_at`, `updated_at`) VALUES
(2, 'administrator', 'administration generale', '2017-04-07 11:16:59', '2017-04-07 11:16:59'),
(3, 'commercial', 'commercial', '2017-04-07 11:16:59', '2017-04-07 11:16:59'),
(4, 'technical', 'technicien', '2017-04-07 11:16:59', '2017-04-07 11:16:59'),
(5, 'accounting', 'comptabilité', '2017-04-07 11:16:59', '2017-04-07 11:16:59'),
(6, 'computing', 'informaticien', '2017-04-07 11:16:59', '2017-04-07 11:16:59'),
(7, 'logistic', 'logisticien', '2017-04-07 11:16:59', '2017-04-07 11:16:59'),
(8, 'magasinier', 'magasinier', '2017-04-07 11:16:59', '2017-04-07 09:16:59'),
(9, 'responsable_achat', 'responsable achat', '2017-04-07 11:16:59', '2017-04-07 09:16:59'),
(11, 'responsable_garages', 'responsable garages', '2017-04-07 11:16:59', '2017-04-07 09:16:59'),
(12, 'Chef_stock', 'Chef stock', '2017-05-10 00:00:00', '2017-05-03 00:00:00'),
(13, 'Chef_Technique', 'Chef Technique', '2017-05-24 00:00:00', '2017-05-25 00:00:00'),
(14, 'chef attelier', 'chef d\'un seul attelier', '2017-10-12 01:21:17', '2017-10-11 23:23:22'),
(15, 'deeeee', 'dedede', '2017-10-12 01:29:16', '2017-10-11 23:29:16'),
(16, 'eded', 'eded', '2017-10-12 01:35:34', '2017-10-11 23:35:34');

-- --------------------------------------------------------

--
-- Table structure for table `stk_service_descriptions`
--

CREATE TABLE `stk_service_descriptions` (
  `id` int(11) NOT NULL,
  `ids` int(11) DEFAULT NULL,
  `title` varchar(191) NOT NULL,
  `description` text NOT NULL,
  `diagnostic_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stk_service_employees`
--

CREATE TABLE `stk_service_employees` (
  `id` int(11) NOT NULL,
  `ids` int(11) DEFAULT NULL,
  `diagnostic_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stk_service_employees`
--

INSERT INTO `stk_service_employees` (`id`, `ids`, `diagnostic_id`, `employee_id`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 7, '2017-09-18 14:33:40', '2017-09-18 14:33:40'),
(2, NULL, 1, 60, '2017-09-18 14:33:40', '2017-09-18 14:33:40'),
(3, NULL, 13, 60, '2017-10-24 18:57:03', '2017-10-24 18:57:03'),
(4, NULL, 13, 60, '2017-10-24 18:57:22', '2017-10-24 18:57:22'),
(5, NULL, 5, 60, '2017-10-24 18:59:16', '2017-10-24 18:59:16'),
(6, NULL, 5, 60, '2017-10-24 18:59:39', '2017-10-24 18:59:39'),
(7, NULL, 12, 60, '2017-10-24 19:00:57', '2017-10-24 19:00:57'),
(8, NULL, 4, 60, '2017-10-24 19:03:43', '2017-10-24 19:03:43'),
(9, NULL, 6, 60, '2017-10-24 19:07:37', '2017-10-24 19:07:37'),
(10, NULL, 2, 60, '2017-10-24 22:42:57', '2017-10-24 22:42:57'),
(11, NULL, 14, 60, '2017-10-24 23:03:57', '2017-10-24 23:03:57'),
(12, NULL, 8, 60, '2017-10-24 23:14:33', '2017-10-24 23:14:33'),
(13, NULL, 9, 60, '2017-10-24 23:15:18', '2017-10-24 23:15:18'),
(14, NULL, 16, 60, '2017-10-24 23:27:26', '2017-10-24 23:27:26'),
(15, NULL, 17, 60, '2017-10-24 23:37:16', '2017-10-24 23:37:16'),
(16, NULL, 20, 7, '2017-10-24 23:54:59', '2017-10-24 23:54:59'),
(17, NULL, 11, 60, '2017-10-26 18:34:10', '2017-10-26 18:34:10'),
(18, NULL, 10, 7, '2017-10-29 14:51:15', '2017-10-29 14:51:15'),
(19, NULL, 3, 60, '2017-10-29 14:58:25', '2017-10-29 14:58:25'),
(20, NULL, 1, 60, '2017-10-29 15:00:05', '2017-10-29 15:00:05'),
(21, NULL, 24, 60, '2017-10-29 15:01:58', '2017-10-29 15:01:58'),
(22, NULL, 18, 60, '2017-10-29 16:22:01', '2017-10-29 16:22:01');

-- --------------------------------------------------------

--
-- Table structure for table `stk_shelves`
--

CREATE TABLE `stk_shelves` (
  `id` int(10) UNSIGNED NOT NULL,
  `ray_id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stk_shelves`
--

INSERT INTO `stk_shelves` (`id`, `ray_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'lampe', '2017-07-18 14:31:09', '2017-07-18 14:31:09'),
(2, 1, 'ampoule', '2017-07-18 14:31:16', '2017-07-18 14:31:16'),
(3, 2, 'frein', '2017-07-18 14:31:22', '2017-07-18 14:31:22'),
(4, 2, 'bougie', '2017-07-18 14:31:28', '2017-07-18 14:31:28');

-- --------------------------------------------------------

--
-- Table structure for table `stk_sites`
--

CREATE TABLE `stk_sites` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `ville` varchar(100) NOT NULL,
  `active` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stk_sites`
--

INSERT INTO `stk_sites` (`id`, `name`, `ville`, `active`, `created_at`, `updated_at`) VALUES
(1, 'utbgroup1', 'yamoussoukro', 0, '2017-10-10 00:00:00', '2017-10-11 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `stk_states`
--

CREATE TABLE `stk_states` (
  `id` int(10) UNSIGNED NOT NULL,
  `ids` varchar(11) NOT NULL,
  `reference` varchar(11) NOT NULL,
  `bus_id` int(10) UNSIGNED NOT NULL,
  `incident` text,
  `remark` text,
  `kilometer` int(11) DEFAULT NULL,
  `state` enum('0','1') NOT NULL,
  `site_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stk_stocks`
--

CREATE TABLE `stk_stocks` (
  `id` int(10) UNSIGNED NOT NULL,
  `ids` varchar(191) NOT NULL,
  `reference` varchar(191) NOT NULL,
  `delivery_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `sub_category_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `block_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `tva` float NOT NULL,
  `site_id` int(11) NOT NULL,
  `annex` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stk_sub_categories`
--

CREATE TABLE `stk_sub_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stk_sub_categories`
--

INSERT INTO `stk_sub_categories` (`id`, `name`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'lampe', 1, '2017-07-18 14:26:17', '2017-07-18 14:26:17'),
(2, 'ampoule', 1, '2017-07-18 14:26:23', '2017-07-18 14:26:23'),
(3, 'radio', 1, '2017-07-18 14:26:29', '2017-07-18 14:26:29'),
(4, 'frein', 2, '2017-07-18 14:26:36', '2017-07-18 14:26:36'),
(5, 'bougie', 2, '2017-07-18 14:26:45', '2017-07-18 14:26:45'),
(6, 'parebrise', 3, '2017-07-18 14:26:56', '2017-07-18 14:26:56');

-- --------------------------------------------------------

--
-- Table structure for table `stk_suppliers`
--

CREATE TABLE `stk_suppliers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `rccm` varchar(191) DEFAULT NULL,
  `phone` varchar(191) NOT NULL,
  `mobile` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `address` varchar(191) DEFAULT NULL,
  `type` enum('0','1') NOT NULL,
  `country_id` int(10) UNSIGNED NOT NULL,
  `site_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stk_suppliers`
--

INSERT INTO `stk_suppliers` (`id`, `name`, `rccm`, `phone`, `mobile`, `email`, `address`, `type`, `country_id`, `site_id`, `created_at`, `updated_at`) VALUES
(1, 'particular', '', '40000000', '40000000', 'stonggle.burn@gmail.com', '', '1', 52, 3, '2017-07-12 12:41:25', '2017-07-13 14:22:47'),
(2, 'entrepriser', 'yty', '21001269', '40610327', 'co@co.cm', 'adresse', '0', 53, 3, '2017-07-12 15:47:22', '2017-07-13 14:20:18');

-- --------------------------------------------------------

--
-- Table structure for table `stk_types`
--

CREATE TABLE `stk_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stk_types`
--

INSERT INTO `stk_types` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'neuves', NULL, '2017-07-18 14:27:08', '2017-07-18 14:53:59'),
(2, 'occasion', 'wep wep', '2017-07-18 14:29:28', '2017-07-18 14:54:06');

-- --------------------------------------------------------

--
-- Table structure for table `stk_type_operations`
--

CREATE TABLE `stk_type_operations` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `display_name` varchar(191) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stk_type_operations`
--

INSERT INTO `stk_type_operations` (`id`, `name`, `display_name`, `created_at`, `updated_at`) VALUES
(2, 'visit', 'electricite', '2017-04-18 09:29:21', '2017-04-19 20:00:45'),
(3, 'revision', 'MECANIQUE', '2017-04-19 05:11:11', '2017-05-03 22:48:08'),
(15, 'revision', 'LUBRIFICATION', '2017-05-04 00:00:00', '2017-05-03 00:00:00'),
(16, 'revision', 'ELECTRICITE', '2017-05-23 00:00:00', '2017-05-25 00:00:00'),
(17, 'revision', 'PNEUMATIQUE', '2017-05-17 00:00:00', '2017-05-10 00:00:00'),
(18, 'revision', 'CARROSSERIE', '2017-05-23 00:00:00', '2017-05-10 00:00:00'),
(19, 'revision', 'ESSAI', '2017-05-04 00:00:00', '2017-05-23 00:00:00'),
(28, 'visit', 'MECANIQUE', '2017-05-22 00:00:00', '2017-05-01 00:00:00'),
(29, 'visit', 'LUBRIFICATION', '2017-05-25 00:00:00', '2017-05-31 00:00:00'),
(30, 'visit', 'ELECTRICITE', '2017-05-04 00:00:00', '2017-05-11 00:00:00'),
(31, 'visit', 'PNEUMATIQUES', '2017-05-24 00:00:00', '2017-05-24 00:00:00'),
(32, 'visit', 'CARROSSERIE', '2017-05-17 00:00:00', '2017-05-23 00:00:00'),
(33, 'visit', 'ESSAI', '2017-05-03 00:00:00', '2017-05-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `stk_users`
--

CREATE TABLE `stk_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(191) NOT NULL,
  `last_name` varchar(191) NOT NULL,
  `username` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `phone` varchar(191) NOT NULL,
  `image` varchar(191) DEFAULT NULL,
  `employee_id` int(11) NOT NULL,
  `password` varchar(191) NOT NULL,
  `connected` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stk_users`
--

INSERT INTO `stk_users` (`id`, `first_name`, `last_name`, `username`, `email`, `phone`, `image`, `employee_id`, `password`, `connected`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'maze runner', 'saikick', 'saikick maze runner', 'dev@segoor.com', '21-00-12-69', NULL, 1, '$2y$10$ajkjTFTS1FdvuLJ2Z8218O9lH32569HT/RI/M4jKwFOlcNfqyH64.', 1, 1, 'u6knT5qiLzEtATmppH4AdL5gEM8RKj8gWsthaka69Q3HpH8vfs5rmu5mbNbu', '2017-04-07 11:17:00', '2017-10-29 22:53:04'),
(2, 'ampi', 'bomo', 'bomo ampi', 'bomo@lo.com', '40-61-03-27', NULL, 3, '$2y$10$pGljdHc5EOcIPq9pcVFfDecr8fT2k52d0FgFw9KgGyARZ7LyK3yWG', 0, 0, 'NYtfuD9w0gVgUMUH3PcuFC3D5j1t10iRzU21aelssYT05IMuOdPUECD3wUyx', '2017-05-02 16:44:07', '2017-05-02 16:44:07'),
(3, 'johnson', 'magic', 'magic johnson', 'johnson@yahoo.com', '', NULL, 4, '$2y$10$sFlkuQdTDMEN8VBxayOTnOUhBW6seMuXVciw7maLI2pLDD9SMzqjC', 0, 0, NULL, '2017-09-25 15:42:20', '2017-09-25 15:42:20'),
(4, 'ededeeedeededed', 'ededeeeeded', 'ededeeeeded ededeeedeededed', 'kouadioyeo@yeoffr.com', '', NULL, 8, '$2y$10$4.i7KhIQZ4WctThUj47x7.BBkNDt6la7lbNRN3Edd8xm6dU3onxIC', 0, 0, NULL, '2017-10-13 08:34:36', '2017-10-13 11:40:12'),
(5, 'efffffeeeeeeeeeeeeee', 'eeddddddddddddddddd', 'eeddddddddddddddddd efffffeeeeeeeeeeeeee', 'dedzdzdz@lo.com', '', NULL, 7, '$2y$10$6GaQKAyvzrgXc3rCeL9QVe9cEUoqfhEQWCAIxIrhVp3fxXkdUT/dC', 0, 0, NULL, '2017-10-13 09:37:13', '2017-10-13 09:37:13');

-- --------------------------------------------------------

--
-- Table structure for table `stk_vehicles`
--

CREATE TABLE `stk_vehicles` (
  `id` int(10) UNSIGNED NOT NULL,
  `matriculation` varchar(191) NOT NULL,
  `step` int(11) DEFAULT NULL,
  `chassis` varchar(191) NOT NULL,
  `model_id` int(11) NOT NULL,
  `pmc` date NOT NULL,
  `site_id` int(11) DEFAULT NULL,
  `visit_expiration` date DEFAULT NULL,
  `insurance_expiration` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stk_visits`
--

CREATE TABLE `stk_visits` (
  `id` int(11) NOT NULL,
  `ids` int(11) NOT NULL,
  `date` date NOT NULL,
  `site_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bus_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stk_visit_techniques`
--

CREATE TABLE `stk_visit_techniques` (
  `id` int(11) NOT NULL,
  `ids` varchar(191) NOT NULL,
  `diagnostic_id` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stk_works`
--

CREATE TABLE `stk_works` (
  `id` int(11) NOT NULL,
  `ids` int(11) NOT NULL,
  `type` enum('1','2') NOT NULL,
  `state` enum('1','0','4') NOT NULL,
  `distance` int(11) NOT NULL,
  `place` varchar(191) NOT NULL,
  `description` varchar(191) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `diagnostic_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `stk_after_tests`
--
ALTER TABLE `stk_after_tests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stk_approvals`
--
ALTER TABLE `stk_approvals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ids` (`ids`);

--
-- Indexes for table `stk_assurances`
--
ALTER TABLE `stk_assurances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ids` (`ids`);

--
-- Indexes for table `stk_blocks`
--
ALTER TABLE `stk_blocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stk_brands`
--
ALTER TABLE `stk_brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stk_buses`
--
ALTER TABLE `stk_buses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ids` (`ids`);

--
-- Indexes for table `stk_categories`
--
ALTER TABLE `stk_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stk_countries`
--
ALTER TABLE `stk_countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stk_deliveries`
--
ALTER TABLE `stk_deliveries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ids` (`ids`);

--
-- Indexes for table `stk_demands`
--
ALTER TABLE `stk_demands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ids` (`ids`);

--
-- Indexes for table `stk_demand_pieces`
--
ALTER TABLE `stk_demand_pieces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stk_diagnostics`
--
ALTER TABLE `stk_diagnostics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `diagnostics_reference_unique` (`reference`),
  ADD UNIQUE KEY `ids` (`ids`);

--
-- Indexes for table `stk_diagnostic_employees`
--
ALTER TABLE `stk_diagnostic_employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ids` (`ids`);

--
-- Indexes for table `stk_employees`
--
ALTER TABLE `stk_employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employe_nom_employe_unique` (`last_name`),
  ADD KEY `employe_type_employe_id_index` (`post_id`);

--
-- Indexes for table `stk_entreprises`
--
ALTER TABLE `stk_entreprises`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stk_fields`
--
ALTER TABLE `stk_fields`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fields_name_unique` (`name`);

--
-- Indexes for table `stk_field_states`
--
ALTER TABLE `stk_field_states`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ids` (`ids`);

--
-- Indexes for table `stk_images`
--
ALTER TABLE `stk_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stk_inventories`
--
ALTER TABLE `stk_inventories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stk_item_stocks`
--
ALTER TABLE `stk_item_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_ids` (`movement_stock_id`),
  ADD KEY `ids` (`ids`);

--
-- Indexes for table `stk_migrations`
--
ALTER TABLE `stk_migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stk_models`
--
ALTER TABLE `stk_models`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stk_movement_stocks`
--
ALTER TABLE `stk_movement_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stk_observation_operation_revisions`
--
ALTER TABLE `stk_observation_operation_revisions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_visitech` (`revision_id`,`operation_technique_id`);

--
-- Indexes for table `stk_observation_operation_techniques`
--
ALTER TABLE `stk_observation_operation_techniques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_visitech` (`visit_technique_id`,`operation_technique_id`);

--
-- Indexes for table `stk_observation_repairs`
--
ALTER TABLE `stk_observation_repairs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stk_observation_revisions`
--
ALTER TABLE `stk_observation_revisions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stk_observation_techniques`
--
ALTER TABLE `stk_observation_techniques`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stk_operation_revisions`
--
ALTER TABLE `stk_operation_revisions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_operation` (`type_operation_revision_id`);

--
-- Indexes for table `stk_operation_techniques`
--
ALTER TABLE `stk_operation_techniques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_operation` (`type_operation_id`);

--
-- Indexes for table `stk_password_resets`
--
ALTER TABLE `stk_password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `stk_permissions`
--
ALTER TABLE `stk_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `stk_permission_role`
--
ALTER TABLE `stk_permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `stk_pictures`
--
ALTER TABLE `stk_pictures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stk_pieces`
--
ALTER TABLE `stk_pieces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stk_posts`
--
ALTER TABLE `stk_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_employe_libelle_type_employe_unique` (`name`);

--
-- Indexes for table `stk_processes`
--
ALTER TABLE `stk_processes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `processes_reference_unique` (`reference`),
  ADD UNIQUE KEY `ids` (`ids`);

--
-- Indexes for table `stk_rays`
--
ALTER TABLE `stk_rays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stk_releases`
--
ALTER TABLE `stk_releases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_essaiaprestavaux` (`after_test_id`);

--
-- Indexes for table `stk_repairs`
--
ALTER TABLE `stk_repairs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ids` (`ids`);

--
-- Indexes for table `stk_revisionns`
--
ALTER TABLE `stk_revisionns`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ids` (`ids`);

--
-- Indexes for table `stk_revisions`
--
ALTER TABLE `stk_revisions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `revisions_revisionable_id_revisionable_type_index` (`revisionable_id`,`revisionable_type`);

--
-- Indexes for table `stk_roles`
--
ALTER TABLE `stk_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `stk_role_user`
--
ALTER TABLE `stk_role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `stk_services`
--
ALTER TABLE `stk_services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `services_libelle_unique` (`name`);

--
-- Indexes for table `stk_service_descriptions`
--
ALTER TABLE `stk_service_descriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ids` (`ids`);

--
-- Indexes for table `stk_service_employees`
--
ALTER TABLE `stk_service_employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stk_shelves`
--
ALTER TABLE `stk_shelves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stk_sites`
--
ALTER TABLE `stk_sites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stk_states`
--
ALTER TABLE `stk_states`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ids` (`ids`),
  ADD UNIQUE KEY `reference` (`reference`);

--
-- Indexes for table `stk_stocks`
--
ALTER TABLE `stk_stocks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stocks_reference_unique` (`reference`),
  ADD KEY `ids` (`ids`);

--
-- Indexes for table `stk_sub_categories`
--
ALTER TABLE `stk_sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stk_suppliers`
--
ALTER TABLE `stk_suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `suppliers_phone_unique` (`phone`),
  ADD UNIQUE KEY `suppliers_mobile_unique` (`mobile`),
  ADD UNIQUE KEY `suppliers_email_unique` (`email`);

--
-- Indexes for table `stk_types`
--
ALTER TABLE `stk_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stk_type_operations`
--
ALTER TABLE `stk_type_operations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stk_users`
--
ALTER TABLE `stk_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `stk_vehicles`
--
ALTER TABLE `stk_vehicles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehicles_matriculation_unique` (`matriculation`),
  ADD UNIQUE KEY `vehicles_chassis_unique` (`chassis`);

--
-- Indexes for table `stk_visits`
--
ALTER TABLE `stk_visits`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ids` (`ids`);

--
-- Indexes for table `stk_visit_techniques`
--
ALTER TABLE `stk_visit_techniques`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stk_works`
--
ALTER TABLE `stk_works`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `stk_after_tests`
--
ALTER TABLE `stk_after_tests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stk_approvals`
--
ALTER TABLE `stk_approvals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stk_assurances`
--
ALTER TABLE `stk_assurances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stk_blocks`
--
ALTER TABLE `stk_blocks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `stk_brands`
--
ALTER TABLE `stk_brands`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `stk_buses`
--
ALTER TABLE `stk_buses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stk_categories`
--
ALTER TABLE `stk_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `stk_countries`
--
ALTER TABLE `stk_countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;
--
-- AUTO_INCREMENT for table `stk_deliveries`
--
ALTER TABLE `stk_deliveries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stk_demands`
--
ALTER TABLE `stk_demands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stk_demand_pieces`
--
ALTER TABLE `stk_demand_pieces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stk_diagnostics`
--
ALTER TABLE `stk_diagnostics`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stk_diagnostic_employees`
--
ALTER TABLE `stk_diagnostic_employees`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stk_employees`
--
ALTER TABLE `stk_employees`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
--
-- AUTO_INCREMENT for table `stk_entreprises`
--
ALTER TABLE `stk_entreprises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `stk_fields`
--
ALTER TABLE `stk_fields`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `stk_field_states`
--
ALTER TABLE `stk_field_states`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;
--
-- AUTO_INCREMENT for table `stk_images`
--
ALTER TABLE `stk_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stk_inventories`
--
ALTER TABLE `stk_inventories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stk_item_stocks`
--
ALTER TABLE `stk_item_stocks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `stk_migrations`
--
ALTER TABLE `stk_migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `stk_models`
--
ALTER TABLE `stk_models`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `stk_movement_stocks`
--
ALTER TABLE `stk_movement_stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stk_observation_operation_revisions`
--
ALTER TABLE `stk_observation_operation_revisions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stk_observation_operation_techniques`
--
ALTER TABLE `stk_observation_operation_techniques`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stk_observation_repairs`
--
ALTER TABLE `stk_observation_repairs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stk_observation_revisions`
--
ALTER TABLE `stk_observation_revisions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stk_observation_techniques`
--
ALTER TABLE `stk_observation_techniques`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stk_operation_revisions`
--
ALTER TABLE `stk_operation_revisions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stk_operation_techniques`
--
ALTER TABLE `stk_operation_techniques`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stk_permissions`
--
ALTER TABLE `stk_permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `stk_pictures`
--
ALTER TABLE `stk_pictures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stk_pieces`
--
ALTER TABLE `stk_pieces`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stk_posts`
--
ALTER TABLE `stk_posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `stk_processes`
--
ALTER TABLE `stk_processes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stk_rays`
--
ALTER TABLE `stk_rays`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `stk_releases`
--
ALTER TABLE `stk_releases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stk_repairs`
--
ALTER TABLE `stk_repairs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stk_revisionns`
--
ALTER TABLE `stk_revisionns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stk_revisions`
--
ALTER TABLE `stk_revisions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stk_roles`
--
ALTER TABLE `stk_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `stk_services`
--
ALTER TABLE `stk_services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `stk_service_descriptions`
--
ALTER TABLE `stk_service_descriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stk_service_employees`
--
ALTER TABLE `stk_service_employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `stk_shelves`
--
ALTER TABLE `stk_shelves`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `stk_sites`
--
ALTER TABLE `stk_sites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `stk_states`
--
ALTER TABLE `stk_states`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stk_stocks`
--
ALTER TABLE `stk_stocks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stk_sub_categories`
--
ALTER TABLE `stk_sub_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `stk_suppliers`
--
ALTER TABLE `stk_suppliers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `stk_types`
--
ALTER TABLE `stk_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `stk_type_operations`
--
ALTER TABLE `stk_type_operations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `stk_users`
--
ALTER TABLE `stk_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `stk_vehicles`
--
ALTER TABLE `stk_vehicles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stk_visits`
--
ALTER TABLE `stk_visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stk_visit_techniques`
--
ALTER TABLE `stk_visit_techniques`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stk_works`
--
ALTER TABLE `stk_works`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `stk_permission_role`
--
ALTER TABLE `stk_permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `stk_permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `stk_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
