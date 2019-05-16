-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2019 at 12:57 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kariyer`
--

-- --------------------------------------------------------

--
-- Table structure for table `afe`
--

CREATE TABLE `afe` (
  `afe` int(11) NOT NULL,
  `efe_member` int(11) NOT NULL,
  `efe_job_adv` int(11) NOT NULL,
  `efe_message` varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL,
  `efe_status` int(11) DEFAULT '0',
  `efe_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `efe_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `efe_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name_tr` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `category_name_en` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_father` int(11) DEFAULT '0',
  `category_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name_tr`, `category_name_en`, `category_father`, `category_active`) VALUES
(10001, 'Banka/Sigorta', '', 0, 1),
(10002, 'Bilişim/Telekom', '', 0, 1),
(10003, 'Eğitim/Öğretim', '', 0, 1),
(10004, 'Güvenlik', '', 0, 1),
(10005, 'Hukuk/Avukat', '', 0, 1),
(10006, 'İnsan Kaynakları/Yönetim', '', 0, 1),
(10007, 'Lojistik/Taşımacılık/Depo', '', 0, 1),
(10008, 'Mağaza/Perakende', '', 0, 1),
(10009, 'Muhasebe/Finans', '', 0, 1),
(10010, 'Pazarlama/Reklam/Tanıtım/Tasarım', '', 0, 1),
(10011, 'Sağlık', '', 0, 1),
(10012, 'Satış/Satış Müdürü/TeleSatış', '', 0, 1),
(10013, 'Sekreter/Yönetici Asistanı', '', 0, 1),
(10014, 'Staj/Yeni Mezun/Part-Time', '', 0, 1),
(10015, 'Tekstil', '', 0, 1),
(10016, 'Turizm/Gıda/Hizmet', '', 0, 1),
(10017, 'Üretim/Endüstriyel Ürünler/Otomotiv', '', 0, 1),
(10018, 'Yapı/Mimar/İnşaat', '', 0, 1),
(10019, 'Banka/Bankacılık İşlemleri', '', 10001, 1),
(10020, 'Hazine/Kontrol/Denetim', '', 10001, 1),
(10021, 'İş Analizi/Raporlama', '', 10001, 1),
(10022, 'Müşteri Hizmetleri/İlişkileri', '', 10001, 1),
(10023, 'Portföy/Portföy Yönetimi', '', 10001, 1),
(10024, 'Proje Yönetimi', '', 10001, 1),
(10025, 'Risk Yönetimi', '', 10001, 1),
(10026, 'Sigorta/Sigorta Satış/Acente Danışmanlığı', '', 10001, 1),
(10027, 'Yatırım/Fonlar/Krediler/Mortgage', '', 10001, 1),
(10028, 'Ağ Uzmanları/Mühendisler/Güvenlik', '', 10002, 1),
(10029, 'Arayüz/Önyüz Kodlama', '', 10002, 1),
(10030, 'Bilgi İşlem/Helpdesk', '', 10002, 1),
(10031, 'BT/Yazılım/Yazılım Geliştirme', '', 10002, 1),
(10032, 'Grafik Tasarım', '', 10002, 1),
(10033, 'İş Zekası/Veritabanı Uzmanı', '', 10002, 1),
(10034, 'Mobil Programlama', '', 10002, 1),
(10035, 'Müşteri Hizmetleri/İlişkileri', '', 10002, 1),
(10036, 'Proje Yönetimi/İş Analizi', '', 10002, 1),
(10037, 'SAP/ERP/CRM', '', 10002, 1),
(10038, 'Sistem Yönetimi', '', 10002, 1),
(10039, 'Teknisyen/Tekniker', '', 10002, 1),
(10040, 'Test/Denetim', '', 10002, 1),
(10041, 'Ürün Yönetimi/Ürün Geliştirme', '', 10002, 1),
(10042, 'Web/Web Tasarım', '', 10002, 1);

-- --------------------------------------------------------

--
-- Table structure for table `certificate`
--

CREATE TABLE `certificate` (
  `certificate_id` int(11) NOT NULL,
  `certificate_member` int(11) NOT NULL,
  `certificate_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `certificate_company` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `certificate_url` varchar(1024) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#',
  `certificate_desc` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `certificate_date` date DEFAULT NULL,
  `certificate_order` int(11) DEFAULT '0',
  `certificate_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `certificate_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `certificate_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `certificate`
--

INSERT INTO `certificate` (`certificate_id`, `certificate_member`, `certificate_name`, `certificate_company`, `certificate_url`, `certificate_desc`, `certificate_date`, `certificate_order`, `certificate_insert`, `certificate_update`, `certificate_active`) VALUES
(1, 4, 'C# - 101', 'Microsoft Açık Akademi', '0', '0', '1990-11-19', 0, '2019-04-20 16:18:01', '2019-04-20 16:18:01', 1),
(2, 4, 'C# - 101', 'Microsoft Açık Akademi', '0', '0', '0000-00-00', 0, '2019-04-20 16:18:20', '2019-04-20 16:18:20', 0),
(3, 4, 'C# - 101', 'Microsoft Açık Akademi', '0', '0', '0000-00-00', 0, '2019-04-20 16:18:21', '2019-04-20 16:18:21', 1),
(4, 4, 'C# - 101', 'Microsoft Açık Akademi', '0', '0', '0000-00-00', 0, '2019-04-20 16:18:26', '2019-04-20 16:18:26', 1),
(5, 4, 'C# - 101', 'Microsoft Açık Akademi', '0', '0', '1990-11-15', 0, '2019-04-20 16:21:09', '2019-04-20 16:21:09', 1),
(6, 4, 'C# - 101', 'Microsoft Açık Akademi', '0', '0', '1990-11-19', 0, '2019-04-20 16:21:46', '2019-04-20 16:21:46', 1);

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `education_id` int(11) NOT NULL,
  `education_member` int(11) NOT NULL,
  `education_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `education_department` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `education_note` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `education_type` int(11) NOT NULL,
  `education_start` date NOT NULL,
  `education_end` date NOT NULL,
  `education_order` int(11) DEFAULT '0',
  `education_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `education_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `education_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `education`
--

INSERT INTO `education` (`education_id`, `education_member`, `education_name`, `education_department`, `education_note`, `education_type`, `education_start`, `education_end`, `education_order`, `education_insert`, `education_update`, `education_active`) VALUES
(1, 4, 'Boğaziçi', 'İşletme', '4.00', 10, '2015-05-06', '0000-00-00', 0, '2019-04-20 19:04:33', '2019-04-20 19:34:26', 0),
(2, 4, 'Boğaziçi', 'İşletme', '0', 10, '2015-05-06', '2016-06-07', 0, '2019-04-20 19:05:26', '2019-04-20 19:05:26', 1),
(3, 16, '$name', '$department', '$note', 3, '1997-12-11', '1997-12-11', 4, '2019-04-20 19:13:58', '2019-04-20 19:13:58', 1),
(4, 4, 'Boğaziçi', 'İşletme', '4.00', 10, '2015-05-06', '0000-00-00', 0, '2019-04-20 19:30:04', '2019-04-20 19:30:04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `experience`
--

CREATE TABLE `experience` (
  `experience_id` int(11) NOT NULL,
  `experience_member` int(11) NOT NULL,
  `experience_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `experience_company` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `experience_desc` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `experience_start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `experience_end` timestamp NULL DEFAULT NULL,
  `experience_order` int(11) DEFAULT '0',
  `experience_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `experience_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `experience_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `experience`
--

INSERT INTO `experience` (`experience_id`, `experience_member`, `experience_name`, `experience_company`, `experience_desc`, `experience_start`, `experience_end`, `experience_order`, `experience_insert`, `experience_update`, `experience_active`) VALUES
(1, 4, 'Seni1111or Financier', 'Berserker Co.', '0', '2019-04-20 17:32:13', '2020-12-18 21:00:00', 0, '2019-04-20 17:01:03', '2019-04-20 17:01:03', 0),
(2, 4, 'Senior Financier', 'Berserker Co.', '0', '2019-01-11 21:00:00', '2020-12-18 21:00:00', 0, '2019-04-20 17:01:21', '2019-04-20 17:01:21', 1),
(3, 4, 'Senior Financier', 'Berserker Co.', '0', '2019-01-11 21:00:00', '2020-12-18 21:00:00', 0, '2019-04-20 17:06:36', '2019-04-20 17:06:36', 1),
(4, 4, 'Senior Financier', 'Berserker Co.', '0', '2019-01-11 21:00:00', '2020-12-18 21:00:00', 0, '2019-04-20 17:07:01', '2019-04-20 17:07:01', 1),
(5, 4, 'Senior Financier', 'Berserker Co.', '0', '2019-01-11 21:00:00', '2020-12-18 21:00:00', 0, '2019-04-20 17:07:51', '2019-04-20 17:07:51', 1);

-- --------------------------------------------------------

--
-- Table structure for table `job_adv`
--

CREATE TABLE `job_adv` (
  `job_adv_id` int(11) NOT NULL,
  `job_adv_author` int(11) NOT NULL,
  `job_adv_experience` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `job_adv_title` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `job_adv_count` int(11) DEFAULT '1',
  `job_adv_type` int(11) NOT NULL,
  `job_adv_sex` int(11) DEFAULT '0',
  `job_adv_description` varchar(4096) COLLATE utf8_unicode_ci NOT NULL,
  `job_adv_view` int(11) DEFAULT '0',
  `job_adv_app` int(11) DEFAULT '0',
  `job_adv_category` int(11) DEFAULT '0',
  `job_adv_father` int(11) DEFAULT '0',
  `job_adv_close` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `job_adv_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `job_adv_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `job_adv_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `job_adv`
--

INSERT INTO `job_adv` (`job_adv_id`, `job_adv_author`, `job_adv_experience`, `job_adv_title`, `job_adv_count`, `job_adv_type`, `job_adv_sex`, `job_adv_description`, `job_adv_view`, `job_adv_app`, `job_adv_category`, `job_adv_father`, `job_adv_close`, `job_adv_insert`, `job_adv_update`, `job_adv_active`) VALUES
(1, 4, '', 'aaa1', 1, 2, 0, 'asd2', 0, 0, 10032, 0, '16.05.19', '2019-05-15 15:43:36', '2019-05-16 13:58:56', 0),
(2, 4, '', 'baaa', 1, 2, 0, 'zaaa', 0, 0, 10020, 0, NULL, '2019-05-16 11:01:19', '2019-05-16 13:50:55', 1);

-- --------------------------------------------------------

--
-- Table structure for table `job_adv_language`
--

CREATE TABLE `job_adv_language` (
  `job_adv_language_id` int(11) NOT NULL,
  `job_adv_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `job_adv_language_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_adv_location`
--

CREATE TABLE `job_adv_location` (
  `job_adv_location_id` int(11) NOT NULL,
  `job_adv_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `job_adv_location_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `job_adv_location`
--

INSERT INTO `job_adv_location` (`job_adv_location_id`, `job_adv_id`, `location_id`, `job_adv_location_active`) VALUES
(6, 1, 1451, 1),
(7, 1, 1811, 1),
(8, 1, 1959, 1),
(9, 1, 2037, 1),
(10, 2, 1246, 1),
(11, 2, 1354, 1),
(12, 2, 1425, 1);

-- --------------------------------------------------------

--
-- Table structure for table `job_adv_military`
--

CREATE TABLE `job_adv_military` (
  `job_adv_military_id` int(11) NOT NULL,
  `job_adv_military_type` int(11) NOT NULL,
  `job_adv_id` int(11) DEFAULT NULL,
  `job_adv_military_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_apply`
--

CREATE TABLE `job_apply` (
  `job_apply_id` int(11) NOT NULL,
  `job_apply_member` int(11) NOT NULL,
  `job_apply_message` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `job_apply_job_adv_id` int(11) NOT NULL,
  `job_apply_review` tinyint(1) DEFAULT '0',
  `job_apply_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `job_apply_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `job_apply_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lang`
--

CREATE TABLE `lang` (
  `lang_id` int(11) NOT NULL,
  `lang_code` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `lang_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lang`
--

INSERT INTO `lang` (`lang_id`, `lang_code`, `lang_active`) VALUES
(1, 'tr', 1),
(2, 'en', 1),
(3, 'de', 1),
(4, 'fr', 1),
(5, 'ru', 1),
(6, 'es', 1);

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
  `language_id` int(11) NOT NULL,
  `language_member` int(11) NOT NULL,
  `language_code` int(11) NOT NULL,
  `language_desc` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `language_order` int(11) DEFAULT '0',
  `language_level` int(11) DEFAULT '0',
  `language_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`language_id`, `language_member`, `language_code`, `language_desc`, `language_order`, `language_level`, `language_active`) VALUES
(1, 4, 1, '0', 0, 3, 0),
(2, 4, 1, '0', 0, 0, 1),
(3, 4, 2, '0', 0, 0, 1),
(4, 4, 1, '0', 0, 0, 1),
(5, 4, 1, '0', 0, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `licence`
--

CREATE TABLE `licence` (
  `licence_id` int(11) NOT NULL,
  `licence_member` int(11) NOT NULL,
  `licence_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `licence_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `licence_code` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `licence_order` int(11) DEFAULT '0',
  `licence_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `licence_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `licence_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `licence`
--

INSERT INTO `licence` (`licence_id`, `licence_member`, `licence_name`, `licence_date`, `licence_code`, `licence_order`, `licence_insert`, `licence_update`, `licence_active`) VALUES
(1, 4, 'Sinek Otomobil Ehliyeti', '2019-04-20 13:56:29', 'B1', 0, '2019-04-20 13:34:09', '2019-04-20 13:56:29', 0),
(2, 4, 'Binek Otomobil Ehliyeti', '0000-00-00 00:00:00', 'B1', 0, '2019-04-20 13:34:29', '2019-04-20 13:34:29', 1),
(3, 4, 'Binek Otomobil Ehliyeti', '0000-00-00 00:00:00', 'B1', 0, '2019-04-20 13:34:44', '2019-04-20 13:34:44', 1),
(4, 4, 'Binek Otomobil Ehliyeti', '0000-00-00 00:00:00', 'B1', 0, '2019-04-20 13:35:07', '2019-04-20 13:35:07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `location_id` int(11) NOT NULL,
  `location_father` int(11) DEFAULT '0',
  `location_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `location_level` int(11) DEFAULT '0',
  `location_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`location_id`, `location_father`, `location_name`, `location_level`, `location_active`) VALUES
(1, 10001, 'Adana', 1, 1),
(2, 10001, 'Adıyaman', 1, 1),
(3, 10001, 'Afyonkarahisar', 1, 1),
(4, 10001, 'Ağrı', 1, 1),
(5, 10001, 'Amasya', 1, 1),
(6, 10001, 'Ankara', 1, 1),
(7, 10001, 'Antalya', 1, 1),
(8, 10001, 'Artvin', 1, 1),
(9, 10001, 'Aydın', 1, 1),
(10, 10001, 'Balıkesir', 1, 1),
(11, 10001, 'Bilecik', 1, 1),
(12, 10001, 'Bingöl', 1, 1),
(13, 10001, 'Bitlis', 1, 1),
(14, 10001, 'Bolu', 1, 1),
(15, 10001, 'Burdur', 1, 1),
(16, 10001, 'Bursa', 1, 1),
(17, 10001, 'Çanakkale', 1, 1),
(18, 10001, 'Çankırı', 1, 1),
(19, 10001, 'Çorum', 1, 1),
(20, 10001, 'Denizli', 1, 1),
(21, 10001, 'Diyarbakır', 1, 1),
(22, 10001, 'Edirne', 1, 1),
(23, 10001, 'Elazığ', 1, 1),
(24, 10001, 'Erzincan', 1, 1),
(25, 10001, 'Erzurum', 1, 1),
(26, 10001, 'Eskişehir', 1, 1),
(27, 10001, 'Gaziantep', 1, 1),
(28, 10001, 'Giresun', 1, 1),
(29, 10001, 'Gümüşhane', 1, 1),
(30, 10001, 'Hakkari', 1, 1),
(31, 10001, 'Hatay', 1, 1),
(32, 10001, 'Isparta', 1, 1),
(33, 10001, 'Mersin', 1, 1),
(34, 10001, 'İstanbul', 1, 1),
(35, 10001, 'İzmir', 1, 1),
(36, 10001, 'Kars', 1, 1),
(37, 10001, 'Kastamonu', 1, 1),
(38, 10001, 'Kayseri', 1, 1),
(39, 10001, 'Kırklareli', 1, 1),
(40, 10001, 'Kırşehir', 1, 1),
(41, 10001, 'Kocaeli', 1, 1),
(42, 10001, 'Konya', 1, 1),
(43, 10001, 'Kütahya', 1, 1),
(44, 10001, 'Malatya', 1, 1),
(45, 10001, 'Manisa', 1, 1),
(46, 10001, 'Kahramanmaraş', 1, 1),
(47, 10001, 'Mardin', 1, 1),
(48, 10001, 'Muğla', 1, 1),
(49, 10001, 'Muş', 1, 1),
(50, 10001, 'Nevşehir', 1, 1),
(51, 10001, 'Niğde', 1, 1),
(52, 10001, 'Ordu', 1, 1),
(53, 10001, 'Rize', 1, 1),
(54, 10001, 'Sakarya', 1, 1),
(55, 10001, 'Samsun', 1, 1),
(56, 10001, 'Siirt', 1, 1),
(57, 10001, 'Sinop', 1, 1),
(58, 10001, 'Sivas', 1, 1),
(59, 10001, 'Tekirdağ', 1, 1),
(60, 10001, 'Tokat', 1, 1),
(61, 10001, 'Trabzon', 1, 1),
(62, 10001, 'Tunceli', 1, 1),
(63, 10001, 'Şanlıurfa', 1, 1),
(64, 10001, 'Uşak', 1, 1),
(65, 10001, 'Van', 1, 1),
(66, 10001, 'Yozgat', 1, 1),
(67, 10001, 'Zonguldak', 1, 1),
(68, 10001, 'Aksaray', 1, 1),
(69, 10001, 'Bayburt', 1, 1),
(70, 10001, 'Karaman', 1, 1),
(71, 10001, 'Kırıkkale', 1, 1),
(72, 10001, 'Batman', 1, 1),
(73, 10001, 'Şırnak', 1, 1),
(74, 10001, 'Bartın', 1, 1),
(75, 10001, 'Ardahan', 1, 1),
(76, 10001, 'Iğdır', 1, 1),
(77, 10001, 'Yalova', 1, 1),
(78, 10001, 'Karabük', 1, 1),
(79, 10001, 'Kilis', 1, 1),
(80, 10001, 'Osmaniye', 1, 1),
(81, 10001, 'Düzce', 1, 1),
(1101, 37, 'Abana', 2, 1),
(1102, 20, 'Acıpayam', 2, 1),
(1103, 34, 'Adalar', 2, 1),
(1104, 1, 'Seyhan', 2, 1),
(1105, 2, 'Adıyaman Merkez', 2, 1),
(1106, 13, 'Adilcevaz', 2, 1),
(1107, 46, 'Afşin', 2, 1),
(1108, 3, 'Afyonkarahisar Merkez', 2, 1),
(1109, 15, 'Ağlasun', 2, 1),
(1110, 23, 'Ağın', 2, 1),
(1111, 4, 'Ağrı Merkez', 2, 1),
(1112, 13, 'Ahlat', 2, 1),
(1113, 61, 'Akçaabat', 2, 1),
(1114, 44, 'Akçadağ', 2, 1),
(1115, 63, 'Akçakale', 2, 1),
(1116, 81, 'Akçakoca', 2, 1),
(1117, 66, 'Akdağmadeni', 2, 1),
(1118, 45, 'Akhisar', 2, 1),
(1119, 52, 'Akkuş', 2, 1),
(1120, 68, 'Aksaray Merkez', 2, 1),
(1121, 7, 'Akseki', 2, 1),
(1122, 42, 'Akşehir', 2, 1),
(1123, 54, 'Akyazı', 2, 1),
(1124, 19, 'Alaca', 2, 1),
(1125, 55, 'Alaçam', 2, 1),
(1126, 7, 'Alanya', 2, 1),
(1127, 45, 'Alaşehir', 2, 1),
(1128, 35, 'Aliağa', 2, 1),
(1129, 60, 'Almus', 2, 1),
(1130, 6, 'Altındağ', 2, 1),
(1131, 31, 'Altınözü', 2, 1),
(1132, 43, 'Altıntaş', 2, 1),
(1133, 28, 'Alucra', 2, 1),
(1134, 5, 'Amasya Merkez', 2, 1),
(1135, 33, 'Anamur', 2, 1),
(1136, 46, 'Andırın', 2, 1),
(1138, 7, 'Antalya Merkez', 2, 1),
(1139, 27, 'Araban', 2, 1),
(1140, 37, 'Araç', 2, 1),
(1141, 61, 'Araklı', 2, 1),
(1142, 76, 'Aralık', 2, 1),
(1143, 44, 'Arapgir', 2, 1),
(1144, 75, 'Ardahan Merkez', 2, 1),
(1145, 8, 'Ardanuç', 2, 1),
(1146, 53, 'Ardeşen', 2, 1),
(1147, 8, 'Arhavi', 2, 1),
(1148, 44, 'Arguvan', 2, 1),
(1149, 36, 'Arpaçay', 2, 1),
(1150, 61, 'Arsin', 2, 1),
(1151, 60, 'Artova', 2, 1),
(1152, 8, 'Artvin Merkez', 2, 1),
(1153, 25, 'Aşkale', 2, 1),
(1154, 32, 'Atabey', 2, 1),
(1155, 50, 'Avanos', 2, 1),
(1156, 57, 'Ayancık', 2, 1),
(1157, 6, 'Ayaş', 2, 1),
(1158, 52, 'Aybastı', 2, 1),
(1159, 9, 'Aydın Merkez', 2, 1),
(1160, 17, 'Ayvacık / Çanakkale', 2, 1),
(1161, 10, 'Ayvalık', 2, 1),
(1162, 37, 'Azdavay', 2, 1),
(1163, 39, 'Babaeski', 2, 1),
(1164, 55, 'Bafra', 2, 1),
(1165, 80, 'Bahçe', 2, 1),
(1166, 34, 'Bakırköy', 2, 1),
(1167, 6, 'Bala', 2, 1),
(1168, 10, 'Balıkesir Merkez', 2, 1),
(1169, 10, 'Balya', 2, 1),
(1170, 64, 'Banaz', 2, 1),
(1171, 10, 'Bandırma', 2, 1),
(1172, 74, 'Bartın Merkez', 2, 1),
(1173, 23, 'Baskil', 2, 1),
(1174, 72, 'Batman Merkez', 2, 1),
(1175, 65, 'Başkale', 2, 1),
(1176, 69, 'Bayburt Merkez', 2, 1),
(1177, 19, 'Bayat / Çorum', 2, 1),
(1178, 35, 'Bayındır', 2, 1),
(1179, 56, 'Baykan', 2, 1),
(1180, 17, 'Bayramiç', 2, 1),
(1181, 35, 'Bergama', 2, 1),
(1182, 2, 'Besni', 2, 1),
(1183, 34, 'Beşiktaş', 2, 1),
(1184, 72, 'Beşiri', 2, 1),
(1185, 34, 'Beykoz', 2, 1),
(1186, 34, 'Beyoğlu', 2, 1),
(1187, 6, 'Beypazarı', 2, 1),
(1188, 42, 'Beyşehir', 2, 1),
(1189, 73, 'Beytüşşebap', 2, 1),
(1190, 17, 'Biga', 2, 1),
(1191, 10, 'Bigadiç', 2, 1),
(1192, 11, 'Bilecik Merkez', 2, 1),
(1193, 12, 'Bingöl Merkez', 2, 1),
(1194, 63, 'Birecik', 2, 1),
(1195, 21, 'Bismil', 2, 1),
(1196, 13, 'Bitlis Merkez', 2, 1),
(1197, 48, 'Bodrum', 2, 1),
(1198, 66, 'Boğazlıyan', 2, 1),
(1199, 14, 'Bolu Merkez', 2, 1),
(1200, 3, 'Bolvadin', 2, 1),
(1201, 51, 'Bor', 2, 1),
(1202, 8, 'Borçka', 2, 1),
(1203, 35, 'Bornova', 2, 1),
(1204, 57, 'Boyabat', 2, 1),
(1205, 17, 'Bozcaada', 2, 1),
(1206, 9, 'Bozdoğan', 2, 1),
(1207, 42, 'Bozkır', 2, 1),
(1208, 37, 'Bozkurt / Kastamonu', 2, 1),
(1209, 63, 'Bozova', 2, 1),
(1210, 11, 'Bozüyük', 2, 1),
(1211, 15, 'Bucak', 2, 1),
(1212, 28, 'Bulancak', 2, 1),
(1213, 49, 'Bulanık', 2, 1),
(1214, 20, 'Buldan', 2, 1),
(1215, 15, 'Burdur Merkez', 2, 1),
(1216, 10, 'Burhaniye', 2, 1),
(1218, 38, 'Bünyan', 2, 1),
(1219, 1, 'Ceyhan', 2, 1),
(1220, 63, 'Ceylanpınar', 2, 1),
(1221, 37, 'Cide', 2, 1),
(1222, 42, 'Cihanbeyli', 2, 1),
(1223, 73, 'Cizre', 2, 1),
(1224, 20, 'Çal', 2, 1),
(1225, 51, 'Çamardı', 2, 1),
(1226, 20, 'Çameli', 2, 1),
(1227, 6, 'Çamlıdere', 2, 1),
(1228, 53, 'Çamlıhemşin', 2, 1),
(1229, 17, 'Çan', 2, 1),
(1230, 17, 'Çanakkale Merkez', 2, 1),
(1231, 6, 'Çankaya', 2, 1),
(1232, 18, 'Çankırı Merkez', 2, 1),
(1233, 20, 'Çardak', 2, 1),
(1234, 55, 'Çarşamba', 2, 1),
(1235, 25, 'Çat', 2, 1),
(1236, 65, 'Çatak', 2, 1),
(1237, 34, 'Çatalca', 2, 1),
(1238, 37, 'Çatalzeytin', 2, 1),
(1239, 3, 'Çay', 2, 1),
(1240, 67, 'Çaycuma', 2, 1),
(1241, 53, 'Çayeli', 2, 1),
(1242, 66, 'Çayıralan', 2, 1),
(1243, 24, 'Çayırlı', 2, 1),
(1244, 61, 'Çaykara', 2, 1),
(1245, 66, 'Çekerek', 2, 1),
(1246, 2, 'Çelikhan', 2, 1),
(1247, 62, 'Çemişgezek', 2, 1),
(1248, 18, 'Çerkeş', 2, 1),
(1249, 21, 'Çermik', 2, 1),
(1250, 59, 'Çerkezköy', 2, 1),
(1251, 35, 'Çeşme', 2, 1),
(1252, 75, 'Çıldır', 2, 1),
(1253, 21, 'Çınar', 2, 1),
(1254, 40, 'Çiçekdağı', 2, 1),
(1255, 26, 'Çifteler', 2, 1),
(1256, 9, 'Çine', 2, 1),
(1257, 20, 'Çivril', 2, 1),
(1258, 59, 'Çorlu', 2, 1),
(1259, 19, 'Çorum Merkez', 2, 1),
(1260, 6, 'Çubuk', 2, 1),
(1261, 30, 'Çukurca', 2, 1),
(1262, 42, 'Çumra', 2, 1),
(1263, 21, 'Çüngüş', 2, 1),
(1264, 37, 'Daday', 2, 1),
(1265, 44, 'Darende', 2, 1),
(1266, 48, 'Datça', 2, 1),
(1267, 3, 'Dazkırı', 2, 1),
(1268, 71, 'Delice', 2, 1),
(1269, 45, 'Demirci', 2, 1),
(1270, 39, 'Demirköy', 2, 1),
(1271, 20, 'Denizli Merkez', 2, 1),
(1272, 28, 'Dereli', 2, 1),
(1273, 47, 'Derik', 2, 1),
(1274, 50, 'Derinkuyu', 2, 1),
(1275, 38, 'Develi', 2, 1),
(1276, 67, 'Devrek', 2, 1),
(1277, 37, 'Devrekani', 2, 1),
(1278, 21, 'Dicle', 2, 1),
(1279, 36, 'Digor', 2, 1),
(1280, 35, 'Dikili', 2, 1),
(1281, 3, 'Dinar', 2, 1),
(1282, 58, 'Divriği', 2, 1),
(1283, 4, 'Diyadin', 2, 1),
(1284, 21, 'Diyarbakır Merkez', 2, 1),
(1285, 42, 'Doğanhisar', 2, 1),
(1286, 44, 'Doğanşehir', 2, 1),
(1287, 4, 'Doğubayazıt', 2, 1),
(1288, 43, 'Domaniç', 2, 1),
(1289, 31, 'Dörtyol', 2, 1),
(1290, 57, 'Durağan', 2, 1),
(1291, 10, 'Dursunbey', 2, 1),
(1292, 81, 'Düzce Merkez', 2, 1),
(1293, 17, 'Eceabat', 2, 1),
(1294, 10, 'Edremit / Balıkesir', 2, 1),
(1295, 22, 'Edirne Merkez', 2, 1),
(1296, 78, 'Eflani', 2, 1),
(1297, 32, 'Eğirdir', 2, 1),
(1298, 23, 'Elazığ Merkez', 2, 1),
(1299, 46, 'Elbistan', 2, 1),
(1300, 18, 'Eldivan', 2, 1),
(1301, 4, 'Eleşkirt', 2, 1),
(1302, 6, 'Elmadağ', 2, 1),
(1303, 7, 'Elmalı', 2, 1),
(1304, 43, 'Emet', 2, 1),
(1305, 34, 'Eminönü', 2, 1),
(1306, 3, 'Emirdağ', 2, 1),
(1307, 22, 'Enez', 2, 1),
(1308, 60, 'Erbaa', 2, 1),
(1309, 65, 'Erciş', 2, 1),
(1310, 10, 'Erdek', 2, 1),
(1311, 33, 'Erdemli', 2, 1),
(1312, 42, 'Ereğli / Konya', 2, 1),
(1313, 67, 'Ereğli / Zonguldak', 2, 1),
(1314, 57, 'Erfelek', 2, 1),
(1315, 21, 'Ergani', 2, 1),
(1316, 70, 'Ermenek', 2, 1),
(1317, 56, 'Eruh', 2, 1),
(1318, 24, 'Erzincan Merkez', 2, 1),
(1319, 25, 'Erzurum Merkez', 2, 1),
(1320, 28, 'Espiye', 2, 1),
(1321, 78, 'Eskipazar', 2, 1),
(1322, 26, 'Eskişehir Merkez', 2, 1),
(1323, 64, 'Eşme', 2, 1),
(1324, 28, 'Eynesil', 2, 1),
(1325, 34, 'Eyüp', 2, 1),
(1326, 17, 'Ezine', 2, 1),
(1327, 34, 'Fatih', 2, 1),
(1328, 52, 'Fatsa', 2, 1),
(1329, 1, 'Feke', 2, 1),
(1330, 38, 'Felahiye', 2, 1),
(1331, 48, 'Fethiye', 2, 1),
(1332, 53, 'Fındıklı', 2, 1),
(1333, 7, 'Finike', 2, 1),
(1334, 35, 'Foça', 2, 1),
(1336, 34, 'Gaziosmanpaşa', 2, 1),
(1337, 7, 'Gazipaşa', 2, 1),
(1338, 41, 'Gebze', 2, 1),
(1339, 43, 'Gediz', 2, 1),
(1340, 17, 'Gelibolu', 2, 1),
(1341, 32, 'Gelendost', 2, 1),
(1342, 58, 'Gemerek', 2, 1),
(1343, 16, 'Gemlik', 2, 1),
(1344, 12, 'Genç', 2, 1),
(1345, 72, 'Gercüş', 2, 1),
(1346, 14, 'Gerede', 2, 1),
(1347, 2, 'Gerger', 2, 1),
(1348, 9, 'Germencik', 2, 1),
(1349, 57, 'Gerze', 2, 1),
(1350, 65, 'Gevaş', 2, 1),
(1351, 54, 'Geyve', 2, 1),
(1352, 28, 'Giresun Merkez', 2, 1),
(1353, 46, 'Göksun', 2, 1),
(1354, 2, 'Gölbaşı / Adıyaman', 2, 1),
(1355, 41, 'Gölcük', 2, 1),
(1356, 75, 'Göle', 2, 1),
(1357, 15, 'Gölhisar', 2, 1),
(1358, 52, 'Gölköy', 2, 1),
(1359, 11, 'Gölpazarı', 2, 1),
(1360, 10, 'Gönen / Balıkesir', 2, 1),
(1361, 28, 'Görele', 2, 1),
(1362, 45, 'Gördes', 2, 1),
(1363, 5, 'Göynücek', 2, 1),
(1364, 14, 'Göynük', 2, 1),
(1365, 6, 'Güdül', 2, 1),
(1366, 33, 'Gülnar', 2, 1),
(1367, 50, 'Gülşehir', 2, 1),
(1368, 5, 'Gümüşhacıköy', 2, 1),
(1369, 29, 'Gümüşhane Merkez', 2, 1),
(1370, 7, 'Gündoğmuş', 2, 1),
(1371, 20, 'Güney', 2, 1),
(1372, 65, 'Gürpınar', 2, 1),
(1373, 58, 'Gürün', 2, 1),
(1374, 50, 'Hacıbektaş', 2, 1),
(1375, 42, 'Hadim', 2, 1),
(1376, 58, 'Hafik', 2, 1),
(1377, 30, 'Hakkari Merkez', 2, 1),
(1378, 63, 'Halfeti', 2, 1),
(1379, 4, 'Hamur', 2, 1),
(1380, 75, 'Hanak', 2, 1),
(1381, 21, 'Hani', 2, 1),
(1382, 31, 'Hassa', 2, 1),
(1383, 31, 'Hatay Merkez', 2, 1),
(1384, 10, 'Havran', 2, 1),
(1385, 22, 'Havsa', 2, 1),
(1386, 55, 'Havza', 2, 1),
(1387, 6, 'Haymana', 2, 1),
(1388, 59, 'Hayrabolu', 2, 1),
(1389, 21, 'Hazro', 2, 1),
(1390, 44, 'Hekimhan', 2, 1),
(1391, 54, 'Hendek', 2, 1),
(1392, 25, 'Hınıs', 2, 1),
(1393, 63, 'Hilvan', 2, 1),
(1394, 13, 'Hizan', 2, 1),
(1395, 8, 'Hopa', 2, 1),
(1396, 25, 'Horasan', 2, 1),
(1397, 62, 'Hozat', 2, 1),
(1398, 76, 'Iğdır Merkez', 2, 1),
(1399, 18, 'Ilgaz', 2, 1),
(1400, 42, 'Ilgın', 2, 1),
(1401, 32, 'Isparta Merkez', 2, 1),
(1402, 33, 'Mersin Merkez', 2, 1),
(1403, 73, 'İdil', 2, 1),
(1404, 3, 'İhsaniye', 2, 1),
(1405, 53, 'İkizdere', 2, 1),
(1406, 24, 'İliç', 2, 1),
(1407, 58, 'İmranlı', 2, 1),
(1408, 17, 'Gökçeada', 2, 1),
(1409, 38, 'İncesu', 2, 1),
(1410, 37, 'İnebolu', 2, 1),
(1411, 16, 'İnegöl', 2, 1),
(1412, 22, 'İpsala', 2, 1),
(1413, 31, 'İskenderun', 2, 1),
(1414, 19, 'İskilip', 2, 1),
(1415, 27, 'İslahiye', 2, 1),
(1416, 25, 'İspir', 2, 1),
(1418, 10, 'İvrindi', 2, 1),
(1420, 16, 'İznik', 2, 1),
(1421, 34, 'Kadıköy', 2, 1),
(1422, 42, 'Kadınhanı', 2, 1),
(1423, 80, 'Kadirli', 2, 1),
(1424, 36, 'Kağızman', 2, 1),
(1425, 2, 'Kahta', 2, 1),
(1426, 20, 'Kale / Denizli', 2, 1),
(1427, 6, 'Kalecik', 2, 1),
(1428, 53, 'Kalkandere', 2, 1),
(1429, 40, 'Kaman', 2, 1),
(1430, 41, 'Kandıra', 2, 1),
(1431, 58, 'Kangal', 2, 1),
(1432, 35, 'Karaburun', 2, 1),
(1433, 78, 'Karabük Merkez', 2, 1),
(1434, 16, 'Karacabey', 2, 1),
(1435, 9, 'Karacasu', 2, 1),
(1436, 64, 'Karahallı', 2, 1),
(1437, 1, 'Karaisalı', 2, 1),
(1438, 23, 'Karakoçan', 2, 1),
(1439, 70, 'Karaman Merkez', 2, 1),
(1440, 41, 'Karamürsel', 2, 1),
(1441, 42, 'Karapınar', 2, 1),
(1442, 54, 'Karasu', 2, 1),
(1443, 1, 'Karataş', 2, 1),
(1444, 25, 'Karayazı', 2, 1),
(1445, 19, 'Kargı', 2, 1),
(1446, 12, 'Karlıova', 2, 1),
(1447, 36, 'Kars Merkez', 2, 1),
(1448, 35, 'Karşıyaka', 2, 1),
(1449, 34, 'Kartal', 2, 1),
(1450, 37, 'Kastamonu Merkez', 2, 1),
(1451, 7, 'Kaş', 2, 1),
(1452, 55, 'Kavak', 2, 1),
(1453, 54, 'Kaynarca', 2, 1),
(1455, 23, 'Keban', 2, 1),
(1456, 32, 'Keçiborlu', 2, 1),
(1457, 16, 'Keles', 2, 1),
(1458, 29, 'Kelkit', 2, 1),
(1459, 24, 'Kemah', 2, 1),
(1460, 24, 'Kemaliye', 2, 1),
(1461, 35, 'Kemalpaşa / İzmir', 2, 1),
(1462, 10, 'Kepsut', 2, 1),
(1463, 71, 'Keskin', 2, 1),
(1464, 22, 'Keşan', 2, 1),
(1465, 28, 'Keşap', 2, 1),
(1466, 14, 'Kıbrıscık', 2, 1),
(1467, 35, 'Kınık', 2, 1),
(1468, 31, 'Kırıkhan', 2, 1),
(1469, 71, 'Kırıkkale Merkez', 2, 1),
(1470, 45, 'Kırkağaç', 2, 1),
(1471, 39, 'Kırklareli Merkez', 2, 1),
(1472, 40, 'Kırşehir Merkez', 2, 1),
(1473, 6, 'Kızılcahamam', 2, 1),
(1474, 47, 'Kızıltepe', 2, 1),
(1475, 12, 'Kiğı', 2, 1),
(1476, 79, 'Kilis Merkez', 2, 1),
(1477, 35, 'Kiraz', 2, 1),
(1478, 41, 'Kocaeli Merkez', 2, 1),
(1479, 9, 'Koçarlı', 2, 1),
(1480, 39, 'Kofçaz', 2, 1),
(1482, 52, 'Korgan', 2, 1),
(1483, 7, 'Korkuteli', 2, 1),
(1484, 58, 'Koyulhisar', 2, 1),
(1485, 50, 'Kozaklı', 2, 1),
(1486, 1, 'Kozan', 2, 1),
(1487, 72, 'Kozluk', 2, 1),
(1488, 48, 'Köyceğiz', 2, 1),
(1489, 45, 'Kula', 2, 1),
(1490, 21, 'Kulp', 2, 1),
(1491, 42, 'Kulu', 2, 1),
(1492, 7, 'Kumluca', 2, 1),
(1493, 52, 'Kumru', 2, 1),
(1494, 18, 'Kurşunlu', 2, 1),
(1495, 56, 'Kurtalan', 2, 1),
(1496, 74, 'Kurucaşile', 2, 1),
(1497, 9, 'Kuşadası', 2, 1),
(1498, 9, 'Kuyucak', 2, 1),
(1499, 37, 'Küre', 2, 1),
(1500, 43, 'Kütahya Merkez', 2, 1),
(1501, 55, 'Ladik', 2, 1),
(1502, 22, 'Lalapaşa', 2, 1),
(1503, 17, 'Lapseki', 2, 1),
(1504, 21, 'Lice', 2, 1),
(1505, 39, 'Lüleburgaz', 2, 1),
(1506, 23, 'Maden', 2, 1),
(1507, 61, 'Maçka', 2, 1),
(1508, 26, 'Mahmudiye', 2, 1),
(1509, 44, 'Malatya Merkez', 2, 1),
(1510, 49, 'Malazgirt', 2, 1),
(1511, 59, 'Malkara', 2, 1),
(1512, 7, 'Manavgat', 2, 1),
(1513, 45, 'Manisa Merkez', 2, 1),
(1514, 10, 'Manyas', 2, 1),
(1515, 46, 'Kahramanmaraş Merkez', 2, 1),
(1516, 47, 'Mardin Merkez', 2, 1),
(1517, 48, 'Marmaris', 2, 1),
(1518, 62, 'Mazgirt', 2, 1),
(1519, 47, 'Mazıdağı', 2, 1),
(1520, 19, 'Mecitözü', 2, 1),
(1521, 35, 'Menemen', 2, 1),
(1522, 14, 'Mengen', 2, 1),
(1523, 22, 'Meriç', 2, 1),
(1524, 5, 'Merzifon', 2, 1),
(1525, 52, 'Mesudiye', 2, 1),
(1526, 47, 'Midyat', 2, 1),
(1527, 26, 'Mihalıççık', 2, 1),
(1528, 48, 'Milas', 2, 1),
(1529, 40, 'Mucur', 2, 1),
(1530, 16, 'Mudanya', 2, 1),
(1531, 14, 'Mudurnu', 2, 1),
(1532, 48, 'Muğla Merkez', 2, 1),
(1533, 65, 'Muradiye', 2, 1),
(1534, 49, 'Muş Merkez', 2, 1),
(1535, 16, 'Mustafakemalpaşa', 2, 1),
(1536, 33, 'Mut', 2, 1),
(1537, 13, 'Mutki', 2, 1),
(1538, 59, 'Muratlı', 2, 1),
(1539, 6, 'Nallıhan', 2, 1),
(1540, 25, 'Narman', 2, 1),
(1541, 62, 'Nazımiye', 2, 1),
(1542, 9, 'Nazilli', 2, 1),
(1543, 50, 'Nevşehir Merkez', 2, 1),
(1544, 51, 'Niğde Merkez', 2, 1),
(1545, 60, 'Niksar', 2, 1),
(1546, 27, 'Nizip', 2, 1),
(1547, 47, 'Nusaybin', 2, 1),
(1548, 61, 'Of', 2, 1),
(1549, 27, 'Oğuzeli', 2, 1),
(1550, 25, 'Oltu', 2, 1),
(1551, 25, 'Olur', 2, 1),
(1552, 52, 'Ordu Merkez', 2, 1),
(1553, 16, 'Orhaneli', 2, 1),
(1554, 16, 'Orhangazi', 2, 1),
(1555, 18, 'Orta', 2, 1),
(1556, 19, 'Ortaköy / Çorum', 2, 1),
(1557, 68, 'Ortaköy / Aksaray', 2, 1),
(1558, 19, 'Osmancık', 2, 1),
(1559, 11, 'Osmaneli', 2, 1),
(1560, 80, 'Osmaniye Merkez', 2, 1),
(1561, 78, 'Ovacık / Karabük', 2, 1),
(1562, 62, 'Ovacık / Tunceli', 2, 1),
(1563, 35, 'Ödemiş', 2, 1),
(1564, 47, 'Ömerli', 2, 1),
(1565, 65, 'Özalp', 2, 1),
(1566, 23, 'Palu', 2, 1),
(1567, 25, 'Pasinler', 2, 1),
(1568, 4, 'Patnos', 2, 1),
(1569, 53, 'Pazar / Rize', 2, 1),
(1570, 46, 'Pazarcık', 2, 1),
(1571, 11, 'Pazaryeri', 2, 1),
(1572, 39, 'Pehlivanköy', 2, 1),
(1573, 52, 'Perşembe', 2, 1),
(1574, 62, 'Pertek', 2, 1),
(1575, 56, 'Pervari', 2, 1),
(1576, 38, 'Pınarbaşı / Kayseri', 2, 1),
(1577, 39, 'Pınarhisar', 2, 1),
(1578, 6, 'Polatlı', 2, 1),
(1579, 75, 'Posof', 2, 1),
(1580, 1, 'Pozantı', 2, 1),
(1581, 62, 'Pülümür', 2, 1),
(1582, 44, 'Pütürge', 2, 1),
(1583, 24, 'Refahiye', 2, 1),
(1584, 60, 'Reşadiye', 2, 1),
(1585, 31, 'Reyhanlı', 2, 1),
(1586, 53, 'Rize Merkez', 2, 1),
(1587, 78, 'Safranbolu', 2, 1),
(1588, 1, 'Saimbeyli', 2, 1),
(1589, 54, 'Sakarya Merkez', 2, 1),
(1590, 45, 'Salihli', 2, 1),
(1591, 31, 'Samandağ', 2, 1),
(1592, 2, 'Samsat', 2, 1),
(1593, 55, 'Samsun Merkez', 2, 1),
(1594, 3, 'Sandıklı', 2, 1),
(1595, 54, 'Sapanca', 2, 1),
(1596, 59, 'Saray / Tekirdağ', 2, 1),
(1597, 20, 'Sarayköy', 2, 1),
(1598, 42, 'Sarayönü', 2, 1),
(1599, 26, 'Sarıcakaya', 2, 1),
(1600, 45, 'Sarıgöl', 2, 1),
(1601, 36, 'Sarıkamış', 2, 1),
(1602, 66, 'Sarıkaya', 2, 1),
(1603, 38, 'Sarıoğlan', 2, 1),
(1604, 34, 'Sarıyer', 2, 1),
(1605, 38, 'Sarız', 2, 1),
(1606, 45, 'Saruhanlı', 2, 1),
(1607, 72, 'Sason', 2, 1),
(1608, 10, 'Savaştepe', 2, 1),
(1609, 47, 'Savur', 2, 1),
(1610, 14, 'Seben', 2, 1),
(1611, 35, 'Seferihisar', 2, 1),
(1612, 35, 'Selçuk', 2, 1),
(1613, 45, 'Selendi', 2, 1),
(1614, 36, 'Selim', 2, 1),
(1615, 32, 'Senirkent', 2, 1),
(1616, 7, 'Serik', 2, 1),
(1617, 42, 'Seydişehir', 2, 1),
(1618, 26, 'Seyitgazi', 2, 1),
(1619, 10, 'Sındırgı', 2, 1),
(1620, 56, 'Siirt Merkez', 2, 1),
(1621, 33, 'Silifke', 2, 1),
(1622, 34, 'Silivri', 2, 1),
(1623, 73, 'Silopi', 2, 1),
(1624, 21, 'Silvan', 2, 1),
(1625, 43, 'Simav', 2, 1),
(1626, 3, 'Sinanpaşa', 2, 1),
(1627, 57, 'Sinop Merkez', 2, 1),
(1628, 58, 'Sivas Merkez', 2, 1),
(1629, 64, 'Sivaslı', 2, 1),
(1630, 63, 'Siverek', 2, 1),
(1631, 23, 'Sivrice', 2, 1),
(1632, 26, 'Sivrihisar', 2, 1),
(1633, 12, 'Solhan', 2, 1),
(1634, 45, 'Soma', 2, 1),
(1635, 66, 'Sorgun', 2, 1),
(1636, 11, 'Söğüt', 2, 1),
(1637, 9, 'Söke', 2, 1),
(1638, 71, 'Sulakyurt', 2, 1),
(1639, 3, 'Sultandağı', 2, 1),
(1640, 9, 'Sultanhisar', 2, 1),
(1641, 5, 'Suluova', 2, 1),
(1642, 19, 'Sungurlu', 2, 1),
(1643, 63, 'Suruç', 2, 1),
(1644, 10, 'Susurluk', 2, 1),
(1645, 36, 'Susuz', 2, 1),
(1646, 58, 'Suşehri', 2, 1),
(1647, 61, 'Sürmene', 2, 1),
(1648, 32, 'Sütçüler', 2, 1),
(1649, 18, 'Şabanözü', 2, 1),
(1650, 58, 'Şarkışla', 2, 1),
(1651, 32, 'Şarkikaraağaç', 2, 1),
(1652, 59, 'Şarköy', 2, 1),
(1653, 8, 'Şavşat', 2, 1),
(1654, 28, 'Şebinkarahisar', 2, 1),
(1655, 66, 'Şefaatli', 2, 1),
(1656, 30, 'Şemdinli', 2, 1),
(1657, 25, 'Şenkaya', 2, 1),
(1658, 6, 'Şereflikoçhisar', 2, 1),
(1659, 34, 'Şile', 2, 1),
(1660, 29, 'Şiran', 2, 1),
(1661, 73, 'Şırnak Merkez', 2, 1),
(1662, 56, 'Şirvan', 2, 1),
(1663, 34, 'Şişli', 2, 1),
(1664, 3, 'Şuhut', 2, 1),
(1665, 33, 'Tarsus', 2, 1),
(1666, 37, 'Taşköprü', 2, 1),
(1667, 4, 'Taşlıçay', 2, 1),
(1668, 5, 'Taşova', 2, 1),
(1669, 13, 'Tatvan', 2, 1),
(1670, 20, 'Tavas', 2, 1),
(1671, 43, 'Tavşanlı', 2, 1),
(1672, 15, 'Tefenni', 2, 1),
(1673, 59, 'Tekirdağ Merkez', 2, 1),
(1674, 25, 'Tekman', 2, 1),
(1675, 24, 'Tercan', 2, 1),
(1676, 55, 'Terme', 2, 1),
(1677, 35, 'Tire', 2, 1),
(1678, 28, 'Tirebolu', 2, 1),
(1679, 60, 'Tokat Merkez', 2, 1),
(1680, 38, 'Tomarza', 2, 1),
(1681, 61, 'Tonya', 2, 1),
(1682, 35, 'Torbalı', 2, 1),
(1683, 25, 'Tortum', 2, 1),
(1684, 29, 'Torul', 2, 1),
(1685, 37, 'Tosya', 2, 1),
(1686, 61, 'Trabzon Merkez', 2, 1),
(1687, 1, 'Tufanbeyli', 2, 1),
(1688, 62, 'Tunceli Merkez', 2, 1),
(1689, 45, 'Turgutlu', 2, 1),
(1690, 60, 'Turhal', 2, 1),
(1691, 4, 'Tutak', 2, 1),
(1692, 76, 'Tuzluca', 2, 1),
(1693, 57, 'Türkeli', 2, 1),
(1694, 46, 'Türkoğlu', 2, 1),
(1695, 48, 'Ula', 2, 1),
(1696, 52, 'Ulubey / Ordu', 2, 1),
(1697, 64, 'Ulubey / Uşak', 2, 1),
(1698, 73, 'Uludere', 2, 1),
(1699, 32, 'Uluborlu', 2, 1),
(1700, 51, 'Ulukışla', 2, 1),
(1701, 74, 'Ulus', 2, 1),
(1702, 63, 'Şanlıurfa Merkez', 2, 1),
(1703, 35, 'Urla', 2, 1),
(1704, 64, 'Uşak Merkez', 2, 1),
(1705, 22, 'Uzunköprü', 2, 1),
(1706, 52, 'Ünye', 2, 1),
(1707, 50, 'Ürgüp', 2, 1),
(1708, 34, 'Üsküdar', 2, 1),
(1709, 61, 'Vakfıkebir', 2, 1),
(1710, 65, 'Van Merkez', 2, 1),
(1711, 49, 'Varto', 2, 1),
(1712, 55, 'Vezirköprü', 2, 1),
(1713, 63, 'Viranşehir', 2, 1),
(1714, 39, 'Vize', 2, 1),
(1715, 38, 'Yahyalı', 2, 1),
(1716, 77, 'Yalova Merkez', 2, 1),
(1717, 32, 'Yalvaç', 2, 1),
(1718, 18, 'Yapraklı', 2, 1),
(1719, 48, 'Yatağan', 2, 1),
(1720, 27, 'Yavuzeli', 2, 1),
(1721, 31, 'Yayladağı', 2, 1),
(1722, 17, 'Yenice / Çanakkale', 2, 1),
(1723, 6, 'Yenimahalle', 2, 1),
(1724, 9, 'Yenipazar / Aydın', 2, 1),
(1725, 16, 'Yenişehir / Bursa', 2, 1),
(1726, 66, 'Yerköy', 2, 1),
(1727, 38, 'Yeşilhisar', 2, 1),
(1728, 15, 'Yeşilova', 2, 1),
(1729, 44, 'Yeşilyurt / Malatya', 2, 1),
(1730, 81, 'Yığılca', 2, 1),
(1731, 58, 'Yıldızeli', 2, 1),
(1732, 61, 'Yomra', 2, 1),
(1733, 66, 'Yozgat Merkez', 2, 1),
(1734, 1, 'Yumurtalık', 2, 1),
(1735, 42, 'Yunak', 2, 1),
(1736, 8, 'Yusufeli', 2, 1),
(1737, 30, 'Yüksekova', 2, 1),
(1738, 58, 'Zara', 2, 1),
(1739, 34, 'Zeytinburnu', 2, 1),
(1740, 60, 'Zile', 2, 1),
(1741, 67, 'Zonguldak Merkez', 2, 1),
(1742, 48, 'Dalaman', 2, 1),
(1743, 80, 'Düziçi', 2, 1),
(1744, 6, 'Gölbaşı / Ankara', 2, 1),
(1745, 6, 'Keçiören', 2, 1),
(1746, 6, 'Mamak', 2, 1),
(1747, 6, 'Sincan', 2, 1),
(1748, 1, 'Yüreğir', 2, 1),
(1749, 50, 'Acıgöl', 2, 1),
(1750, 12, 'Adaklı', 2, 1),
(1751, 45, 'Ahmetli', 2, 1),
(1752, 38, 'Akkışla', 2, 1),
(1753, 42, 'Akören', 2, 1),
(1754, 40, 'Akpınar', 2, 1),
(1755, 32, 'Aksu / Isparta', 2, 1),
(1756, 36, 'Akyaka', 2, 1),
(1757, 1, 'Aladağ', 2, 1),
(1758, 67, 'Alaplı', 2, 1),
(1759, 26, 'Alpu', 2, 1),
(1760, 42, 'Altınekin', 2, 1),
(1761, 74, 'Amasra', 2, 1),
(1762, 23, 'Arıcak', 2, 1),
(1763, 55, 'Asarcık', 2, 1),
(1764, 43, 'Aslanapa', 2, 1),
(1765, 18, 'Atkaracalar', 2, 1),
(1766, 33, 'Aydıncık / Mersin', 2, 1),
(1767, 69, 'Aydıntepe', 2, 1),
(1768, 70, 'Ayrancı', 2, 1),
(1769, 20, 'Babadağ', 2, 1),
(1770, 65, 'Bahçesaray', 2, 1),
(1771, 3, 'Başmakçı', 2, 1),
(1772, 44, 'Battalgazi', 2, 1),
(1773, 3, 'Bayat / Afyonkarahisar', 2, 1),
(1774, 20, 'Bekilli', 2, 1),
(1775, 61, 'Beşikdüzü', 2, 1),
(1776, 35, 'Beydağ', 2, 1),
(1777, 26, 'Beylikova', 2, 1),
(1778, 19, 'Boğazkale', 2, 1),
(1779, 33, 'Bozyazı', 2, 1),
(1780, 35, 'Buca', 2, 1),
(1781, 9, 'Buharkent', 2, 1),
(1782, 34, 'Büyükçekmece', 2, 1),
(1783, 16, 'Büyükorhan', 2, 1),
(1784, 81, 'Cumayeri', 2, 1),
(1785, 46, 'Çağlayancerit', 2, 1),
(1786, 65, 'Çaldıran', 2, 1),
(1787, 47, 'Dargeçit', 2, 1),
(1788, 69, 'Demirözü', 2, 1),
(1789, 42, 'Derebucak', 2, 1),
(1790, 43, 'Dumlupınar', 2, 1),
(1791, 21, 'Eğil', 2, 1),
(1792, 31, 'Erzin', 2, 1),
(1793, 45, 'Gölmarmara', 2, 1),
(1794, 81, 'Gölyaka', 2, 1),
(1795, 52, 'Gülyalı', 2, 1),
(1796, 53, 'Güneysu', 2, 1),
(1797, 52, 'Gürgentepe', 2, 1),
(1798, 13, 'Güroymak', 2, 1),
(1799, 16, 'Harmancık', 2, 1),
(1800, 63, 'Harran', 2, 1),
(1801, 49, 'Hasköy', 2, 1),
(1802, 43, 'Hisarcık', 2, 1),
(1803, 20, 'Honaz', 2, 1),
(1804, 42, 'Hüyük', 2, 1),
(1805, 37, 'İhsangazi', 2, 1),
(1806, 1, 'İmamoğlu', 2, 1),
(1807, 9, 'İncirliova', 2, 1),
(1808, 26, 'İnönü', 2, 1),
(1809, 3, 'İscehisar', 2, 1),
(1810, 34, 'Kağıthane', 2, 1),
(1811, 7, 'Demre', 2, 1),
(1812, 25, 'Karaçoban', 2, 1),
(1813, 15, 'Karamanlı', 2, 1),
(1814, 42, 'Karatay', 2, 1),
(1815, 6, 'Kazan', 2, 1),
(1816, 15, 'Kemer / Burdur', 2, 1),
(1817, 18, 'Kızılırmak', 2, 1),
(1818, 54, 'Kocaali', 2, 1),
(1819, 35, 'Konak', 2, 1),
(1820, 23, 'Kovancılar', 2, 1),
(1821, 41, 'Körfez', 2, 1),
(1822, 29, 'Köse', 2, 1),
(1823, 34, 'Küçükçekmece', 2, 1),
(1824, 10, 'Marmara', 2, 1),
(1825, 59, 'Marmaraereğlisi', 2, 1),
(1826, 35, 'Menderes', 2, 1),
(1827, 42, 'Meram', 2, 1),
(1828, 8, 'Murgul', 2, 1),
(1829, 16, 'Nilüfer', 2, 1),
(1830, 55, '19 Mayıs', 2, 1),
(1831, 48, 'Ortaca', 2, 1),
(1832, 16, 'Osmangazi', 2, 1),
(1833, 54, 'Pamukova', 2, 1),
(1834, 60, 'Pazar / Tokat', 2, 1),
(1835, 34, 'Pendik', 2, 1),
(1836, 37, 'Pınarbaşı / Kastamonu', 2, 1),
(1837, 28, 'Piraziz', 2, 1),
(1838, 55, 'Salıpazarı', 2, 1),
(1839, 42, 'Selçuklu', 2, 1),
(1840, 20, 'Serinhisar', 2, 1),
(1841, 27, 'Şahinbey', 2, 1),
(1842, 61, 'Şalpazarı', 2, 1),
(1843, 43, 'Şaphane', 2, 1),
(1844, 27, 'Şehitkamil', 2, 1),
(1845, 37, 'Şenpazar', 2, 1),
(1846, 38, 'Talas', 2, 1),
(1847, 54, 'Taraklı', 2, 1),
(1848, 42, 'Taşkent', 2, 1),
(1849, 55, 'Tekkeköy', 2, 1),
(1850, 19, 'Uğurludağ', 2, 1),
(1851, 25, 'Uzundere', 2, 1),
(1852, 34, 'Ümraniye', 2, 1),
(1853, 24, 'Üzümlü', 2, 1),
(1854, 28, 'Yağlıdere', 2, 1),
(1855, 12, 'Yayladere', 2, 1),
(1856, 78, 'Yenice / Karabük', 2, 1),
(1857, 11, 'Yenipazar / Bilecik', 2, 1),
(1858, 60, 'Yeşilyurt / Tokat', 2, 1),
(1859, 16, 'Yıldırım', 2, 1),
(1860, 68, 'Ağaçören', 2, 1),
(1861, 68, 'Güzelyurt', 2, 1),
(1862, 70, 'Kazımkarabekir', 2, 1),
(1863, 38, 'Kocasinan', 2, 1),
(1864, 38, 'Melikgazi', 2, 1),
(1865, 25, 'Pazaryolu', 2, 1),
(1866, 68, 'Sarıyahşi', 2, 1),
(1867, 37, 'Ağlı', 2, 1),
(1868, 42, 'Ahırlı', 2, 1),
(1869, 40, 'Akçakent', 2, 1),
(1870, 58, 'Akıncılar', 2, 1),
(1871, 20, 'Pamukkale', 2, 1),
(1872, 6, 'Akyurt', 2, 1),
(1873, 23, 'Alacakaya', 2, 1),
(1874, 15, 'Altınyayla / Burdur', 2, 1),
(1875, 58, 'Altınyayla / Sivas', 2, 1),
(1876, 51, 'Altunhisar', 2, 1),
(1877, 66, 'Aydıncık / Yozgat', 2, 1),
(1878, 56, 'Tillo', 2, 1),
(1879, 55, 'Ayvacık / Samsun', 2, 1),
(1880, 71, 'Bahşili', 2, 1),
(1881, 20, 'Baklan', 2, 1),
(1882, 71, 'Balışeyh', 2, 1),
(1883, 60, 'Başçiftlik', 2, 1),
(1884, 70, 'Başyayla', 2, 1),
(1885, 18, 'Bayramören', 2, 1),
(1886, 34, 'Bayrampaşa', 2, 1),
(1887, 31, 'Belen', 2, 1),
(1888, 20, 'Beyağaç', 2, 1),
(1889, 20, 'Bozkurt / Denizli', 2, 1),
(1890, 40, 'Boztepe', 2, 1),
(1891, 52, 'Çamaş', 2, 1),
(1892, 33, 'Çamlıyayla', 2, 1),
(1893, 28, 'Çamoluk', 2, 1),
(1894, 28, 'Çanakçı', 2, 1),
(1895, 66, 'Çandır', 2, 1),
(1896, 61, 'Çarşıbaşı', 2, 1),
(1897, 52, 'Çatalpınar', 2, 1),
(1898, 43, 'Çavdarhisar', 2, 1),
(1899, 15, 'Çavdır', 2, 1),
(1900, 52, 'Çaybaşı', 2, 1),
(1901, 71, 'Çelebi', 2, 1),
(1902, 42, 'Çeltik', 2, 1),
(1903, 15, 'Çeltikçi', 2, 1),
(1904, 51, 'Çiftlik', 2, 1),
(1905, 81, 'Çilimli', 2, 1),
(1906, 3, 'Çobanlar', 2, 1),
(1907, 42, 'Derbent', 2, 1),
(1908, 53, 'Derepazarı', 2, 1),
(1909, 61, 'Dernekpazarı', 2, 1),
(1910, 57, 'Dikmen', 2, 1),
(1911, 19, 'Dodurga', 2, 1),
(1912, 28, 'Doğankent', 2, 1),
(1913, 58, 'Doğanşar', 2, 1),
(1914, 44, 'Doğanyol', 2, 1),
(1915, 37, 'Doğanyurt', 2, 1),
(1916, 14, 'Dörtdivan', 2, 1),
(1917, 61, 'Düzköy', 2, 1),
(1918, 65, 'Edremit / Van', 2, 1),
(1919, 46, 'Ekinözü', 2, 1),
(1920, 42, 'Emirgazi', 2, 1),
(1921, 68, 'Eskil', 2, 1),
(1922, 6, 'Etimesgut', 2, 1),
(1923, 3, 'Evciler', 2, 1),
(1924, 6, 'Evren', 2, 1),
(1925, 54, 'Ferizli', 2, 1),
(1926, 67, 'Gökçebey', 2, 1),
(1927, 58, 'Gölova', 2, 1),
(1928, 10, 'Gömeç', 2, 1),
(1929, 32, 'Gönen / Isparta', 2, 1),
(1930, 28, 'Güce', 2, 1),
(1931, 73, 'Güçlükonak', 2, 1),
(1932, 68, 'Gülağaç', 2, 1),
(1933, 42, 'Güneysınır', 2, 1),
(1934, 26, 'Günyüzü', 2, 1),
(1935, 16, 'Gürsu', 2, 1),
(1936, 38, 'Hacılar', 2, 1),
(1937, 42, 'Halkapınar', 2, 1),
(1938, 5, 'Hamamözü', 2, 1),
(1939, 26, 'Han', 2, 1),
(1940, 37, 'Hanönü', 2, 1),
(1941, 72, 'Hasankeyf', 2, 1),
(1942, 61, 'Hayrat', 2, 1),
(1943, 53, 'Hemşin', 2, 1),
(1944, 3, 'Hocalar', 2, 1),
(1945, 25, 'Aziziye', 2, 1),
(1946, 7, 'İbradı', 2, 1),
(1947, 52, 'İkizce', 2, 1),
(1948, 11, 'İnhisar', 2, 1),
(1949, 53, 'İyidere', 2, 1),
(1950, 52, 'Kabadüz', 2, 1),
(1951, 52, 'Kabataş', 2, 1),
(1952, 66, 'Kadışehri', 2, 1),
(1953, 44, 'Kale / Malatya', 2, 1),
(1954, 71, 'Karakeçili', 2, 1),
(1955, 54, 'Karapürçek', 2, 1),
(1956, 27, 'Karkamış', 2, 1),
(1957, 9, 'Karpuzlu', 2, 1),
(1958, 48, 'Kavaklıdere', 2, 1),
(1959, 7, 'Kemer / Antalya', 2, 1),
(1960, 16, 'Kestel', 2, 1),
(1961, 3, 'Kızılören', 2, 1),
(1962, 21, 'Kocaköy', 2, 1),
(1963, 18, 'Korgun', 2, 1),
(1964, 49, 'Korkut', 2, 1),
(1965, 45, 'Köprübaşı / Manisa', 2, 1),
(1966, 61, 'Köprübaşı / Trabzon', 2, 1),
(1967, 25, 'Köprüköy', 2, 1),
(1968, 9, 'Köşk', 2, 1),
(1969, 44, 'Kuluncak', 2, 1),
(1970, 31, 'Kumlu', 2, 1),
(1971, 29, 'Kürtün', 2, 1),
(1972, 19, 'Laçin', 2, 1),
(1973, 26, 'Mihalgazi', 2, 1),
(1974, 27, 'Nurdağı', 2, 1),
(1975, 46, 'Nurhak', 2, 1),
(1976, 19, 'Oğuzlar', 2, 1),
(1977, 24, 'Otlukbeli', 2, 1),
(1978, 38, 'Özvatan', 2, 1),
(1979, 43, 'Pazarlar', 2, 1),
(1980, 65, 'Saray / Van', 2, 1),
(1981, 57, 'Saraydüzü', 2, 1),
(1982, 66, 'Saraykent', 2, 1),
(1983, 70, 'Sarıveliler', 2, 1),
(1984, 37, 'Seydiler', 2, 1),
(1985, 2, 'Sincik', 2, 1),
(1986, 54, 'Söğütlü', 2, 1),
(1987, 60, 'Sulusaray', 2, 1),
(1988, 22, 'Süloğlu', 2, 1),
(1989, 2, 'Tut', 2, 1),
(1990, 42, 'Tuzlukçu', 2, 1),
(1991, 58, 'Ulaş', 2, 1),
(1992, 71, 'Yahşihan', 2, 1),
(1993, 55, 'Yakakent', 2, 1),
(1994, 42, 'Yalıhüyük', 2, 1),
(1995, 44, 'Yazıhan', 2, 1),
(1996, 12, 'Yedisu', 2, 1),
(1997, 14, 'Yeniçağa', 2, 1),
(1998, 66, 'Yenifakılı', 2, 1),
(2000, 9, 'Didim', 2, 1),
(2001, 32, 'Yenişarbademli', 2, 1),
(2002, 47, 'Yeşilli', 2, 1),
(2003, 34, 'Avcılar', 2, 1),
(2004, 34, 'Bağcılar', 2, 1),
(2005, 34, 'Bahçelievler', 2, 1),
(2006, 35, 'Balçova', 2, 1),
(2007, 35, 'Çiğli', 2, 1),
(2008, 75, 'Damal', 2, 1),
(2009, 35, 'Gaziemir', 2, 1),
(2010, 34, 'Güngören', 2, 1),
(2011, 76, 'Karakoyunlu', 2, 1),
(2012, 34, 'Maltepe', 2, 1),
(2013, 35, 'Narlıdere', 2, 1),
(2014, 34, 'Sultanbeyli', 2, 1),
(2015, 34, 'Tuzla', 2, 1),
(2016, 34, 'Esenler', 2, 1),
(2017, 81, 'Gümüşova', 2, 1),
(2018, 35, 'Güzelbahçe', 2, 1),
(2019, 77, 'Altınova', 2, 1),
(2020, 77, 'Armutlu', 2, 1),
(2021, 77, 'Çınarcık', 2, 1),
(2022, 77, 'Çiftlikköy', 2, 1),
(2023, 79, 'Elbeyli', 2, 1),
(2024, 79, 'Musabeyli', 2, 1),
(2025, 79, 'Polateli', 2, 1),
(2026, 77, 'Termal', 2, 1),
(2027, 80, 'Hasanbeyli', 2, 1),
(2028, 80, 'Sumbas', 2, 1),
(2029, 80, 'Toprakkale', 2, 1),
(2030, 41, 'Derince', 2, 1),
(2031, 81, 'Kaynaşlı', 2, 1),
(2032, 1, 'Sarıçam', 2, 1),
(2033, 1, 'Çukurova', 2, 1),
(2034, 6, 'Pursaklar', 2, 1),
(2035, 7, 'Aksu / Antalya', 2, 1),
(2036, 7, 'Döşemealtı', 2, 1),
(2037, 7, 'Kepez', 2, 1),
(2038, 7, 'Konyaaltı', 2, 1),
(2039, 7, 'Muratpaşa', 2, 1),
(2040, 21, 'Bağlar', 2, 1),
(2041, 21, 'Kayapınar', 2, 1),
(2042, 21, 'Sur', 2, 1),
(2043, 21, 'Yenişehir / Diyarbakır', 2, 1),
(2044, 25, 'Palandöken', 2, 1),
(2045, 25, 'Yakutiye', 2, 1),
(2046, 26, 'Odunpazarı', 2, 1),
(2047, 26, 'Tepebaşı', 2, 1),
(2048, 34, 'Arnavutköy', 2, 1),
(2049, 34, 'Ataşehir', 2, 1),
(2050, 34, 'Başakşehir', 2, 1),
(2051, 34, 'Beylikdüzü', 2, 1),
(2052, 34, 'Çekmeköy', 2, 1),
(2053, 34, 'Esenyurt', 2, 1),
(2054, 34, 'Sancaktepe', 2, 1),
(2055, 34, 'Sultangazi', 2, 1),
(2056, 35, 'Bayraklı', 2, 1),
(2057, 35, 'Karabağlar', 2, 1),
(2058, 41, 'Başiskele', 2, 1),
(2059, 41, 'Çayırova', 2, 1),
(2060, 41, 'Darıca', 2, 1),
(2061, 41, 'Dilovası', 2, 1),
(2062, 41, 'İzmit', 2, 1),
(2063, 41, 'Kartepe', 2, 1),
(2064, 33, 'Akdeniz', 2, 1),
(2065, 33, 'Mezitli', 2, 1),
(2066, 33, 'Toroslar', 2, 1),
(2067, 33, 'Yenişehir / Mersin', 2, 1),
(2068, 54, 'Adapazarı', 2, 1),
(2069, 54, 'Arifiye', 2, 1),
(2070, 54, 'Erenler', 2, 1),
(2071, 54, 'Serdivan', 2, 1),
(2072, 55, 'Atakum', 2, 1),
(2073, 55, 'Canik', 2, 1),
(2074, 55, 'İlkadım', 2, 1),
(2076, 9, 'Efeler', 2, 1),
(2077, 10, 'Altıeylül', 2, 1),
(2078, 10, 'Karesi', 2, 1),
(2079, 20, 'Merkezefendi', 2, 1),
(2080, 31, 'Antakya', 2, 1),
(2081, 31, 'Arsuz', 2, 1),
(2082, 31, 'Defne', 2, 1),
(2083, 31, 'Payas', 2, 1),
(2084, 46, 'Dulkadiroğlu', 2, 1),
(2085, 46, 'Onikişubat', 2, 1),
(2086, 45, 'Şehzadeler', 2, 1),
(2087, 45, 'Yunusemre', 2, 1),
(2088, 47, 'Artuklu', 2, 1),
(2089, 48, 'Menteşe', 2, 1),
(2090, 48, 'Seydikemer', 2, 1),
(2091, 63, 'Eyyübiye', 2, 1),
(2092, 63, 'Haliliye', 2, 1),
(2093, 63, 'Karaköprü', 2, 1),
(2094, 59, 'Ergene', 2, 1),
(2095, 59, 'Kapaklı', 2, 1),
(2096, 59, 'Süleymanpaşa', 2, 1),
(2097, 61, 'Ortahisar', 2, 1),
(2098, 65, 'İpekyolu', 2, 1),
(2099, 65, 'Tuşba', 2, 1),
(2100, 67, 'Kilimli', 2, 1),
(2101, 67, 'Kozlu', 2, 1),
(2103, 52, 'Altınordu', 2, 1),
(2105, 8, 'Kemalpaşa / Artvin', 2, 1),
(2106, 68, 'Sultanhanı', 2, 1),
(10001, 0, 'Türkiye', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `member_id` int(11) NOT NULL,
  `member_type` tinyint(1) DEFAULT '0',
  `member_power` int(11) DEFAULT '1',
  `member_email` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `member_gsm` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `member_fax` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `member_name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `member_surname` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `member_nick` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `member_email_confirm` tinyint(1) DEFAULT '1',
  `member_gsm_confirm` tinyint(1) DEFAULT '1',
  `member_password` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `member_prefix` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `member_description` varchar(4096) COLLATE utf8_unicode_ci DEFAULT NULL,
  `member_website` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `member_picture` varchar(256) COLLATE utf8_unicode_ci DEFAULT 'avatar.jpg',
  `member_gender` tinyint(1) DEFAULT '0',
  `member_military` tinyint(1) DEFAULT '0',
  `member_military_date` timestamp NULL DEFAULT NULL,
  `member_smoke` tinyint(1) DEFAULT '0',
  `member_special` tinyint(1) DEFAULT '0',
  `member_ban` tinyint(1) DEFAULT '0',
  `member_ban_date` timestamp NULL DEFAULT NULL,
  `member_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `member_update` timestamp NULL DEFAULT NULL,
  `member_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`member_id`, `member_type`, `member_power`, `member_email`, `member_gsm`, `member_fax`, `member_name`, `member_surname`, `member_nick`, `member_email_confirm`, `member_gsm_confirm`, `member_password`, `member_prefix`, `member_description`, `member_website`, `member_picture`, `member_gender`, `member_military`, `member_military_date`, `member_smoke`, `member_special`, `member_ban`, `member_ban_date`, `member_insert`, `member_update`, `member_active`) VALUES
(4, 1, 2, 'asd@gmail.com', NULL, NULL, 'cem', 'uzan', NULL, 1, 1, '63fa20e091885ddc00da6afae5267eeb1125c900', 'ToTaGHf6cNIL6lHTSOyiF17DTV3QIU4wCAAh29snMJkh7hjycbVco4dUgbYT6Mmvi45GZxU77C5mmNUJO46EarqJJrRarqmGmtmdV3BKUwD2rBS4qrWQ78JfOZr8G8NY', NULL, NULL, 'avatar.jpg', 0, 0, NULL, 0, 0, 0, NULL, '2019-04-19 16:43:32', NULL, 1),
(5, 0, 1, 'mehmet@gmail.com', NULL, NULL, 'Ali', 'Veli', NULL, 1, 1, '29f9cee4775e8d66ff85c673dbba1398690eb64a', '77jdaaExgLYIq4aD3trS3MMXynSsJaGPJktEapebSHKGyOXNqtLCpXQla8FGMtyyryWv0lcZd89LELG9i0jJKzeVzt391RzJyw1F3FjYRXYdvoYmA3XGtZRNiXIc5AH6', NULL, NULL, 'avatar.jpg', 0, 0, NULL, 0, 0, 0, NULL, '2019-04-23 20:00:12', NULL, 1),
(6, 0, 1, 'maaehmet@gmail.com', NULL, NULL, 'Ali', 'Veli', NULL, 1, 1, '649b8dcf6d5c89d2208bd3b4fac28ecd24b09c28', 'k5eE1Zwv8ojE36nYjOjLu9xZkQA88GEEsSOZqFrsmAgD5mHVVYgIZanCmuFHuNQflDdmV7oOGByXgnfoxGJn5Vp2Kt3LuNBmyWYmgkMnC0BEOdNlXhuYSlefNTbTSo9y', NULL, NULL, 'avatar.jpg', 0, 0, NULL, 0, 0, 0, NULL, '2019-04-23 20:05:25', NULL, 1),
(7, 0, 1, 'mehme33t@gmail.com', NULL, NULL, 'Ali', 'Veli', NULL, 1, 1, '241322c12336234555bbc07c436eb952aa14e4b6', 'ddvJ4wWoIIYaj8fYKR1R4hyowrelGT5wWX0SJEcqd4AII6J1zYTmWPbAPViKq0QdXDIKFt1YbyXtMGlDVHaaM1akl2OUHKhnJ0mZxdjZP58Qd8jc46g0rJcCJhQbDVVJ', NULL, NULL, 'avatar.jpg', 0, 0, NULL, 0, 0, 0, NULL, '2019-04-23 20:08:04', NULL, 1),
(8, 0, 1, 'mehme1t@gmail.com', NULL, NULL, 'Ali', 'Veli', NULL, 1, 1, '536b234a7bb6380a7657de469f921880a024e436', 'dnBjXNusgEL3TBY9nDX8nR3NR8TRVG9TCtZoz4WARiK6i1cz6WGcUR8aHVkCuJ2vgjLCtlWHXmoRo2HSDG2dttgIDTk9juCyLC5Ipw6l8HxaAjbxs1fT8etwBmUvNdSv', NULL, NULL, 'avatar.jpg', 0, 0, NULL, 0, 0, 0, NULL, '2019-04-23 20:11:46', NULL, 1),
(9, 0, 1, 'mehme1t1@gmail.com', NULL, NULL, 'Ali', 'Veli', NULL, 1, 1, '4cb5855826f905ffb96aa925f9ea98e3caeb54eb', '9BP8KOqfiG34H96Fy3xtUxE0SWPa9mKzSsGPhgRJcPp2U7ddOe5dfRM9bsQP54jqm71jlNA1HtwFIxWDRYpPXPjTftjLY6wpp8BkDhsyZW6UWYvbbP1yC6Z7C84iiCbz', NULL, NULL, 'avatar.jpg', 0, 0, NULL, 0, 0, 0, NULL, '2019-04-23 20:12:49', NULL, 1),
(10, 0, 1, 'mehmet1212@gmail.com', NULL, NULL, 'Ali', 'Veli', NULL, 1, 1, 'fcf335641870787a2b079cae2c935b19e9ec0c1d', 'FQQWDhiFdelYErRg4NkBzCnDhjRmJS1fBYkdH0PSGY5OeLyvxqBCtGh2KhDn7FU8YdgnndLQq46uWtIe90LvBgmHX6bvWZzgfosBjsBzfyaaj3GSNsAIpWAffsIPzDVG', NULL, NULL, 'avatar.jpg', 0, 0, NULL, 0, 0, 0, NULL, '2019-04-23 20:13:31', NULL, 1),
(11, 1, 1, 'asdasd@gmail.com', NULL, NULL, 'Ali', 'Veli', NULL, 1, 1, '1d44e7c482c7fcf9690577d3ab4b8cf67b3612b6', 'raYekAfaWdKJvCjwzZ9oL3f1RIUeTp3wXFYmNh8XxnBAfSIrXm2EJ4OvF3LTj1BTgC1WtbnjEgZmJHtzNxZUukVJw46fDzCORnRlxXNoq4utpEac9Ev8NMkkowdqPrrl', NULL, NULL, 'avatar.jpg', 0, 0, NULL, 0, 0, 0, NULL, '2019-04-23 21:38:44', NULL, 1),
(12, 1, 2, 'muhammedkalender@protonmail.com', NULL, NULL, 'Muhammed', 'Kalender', NULL, 1, 1, '9e4580b88aede42b72bce2b38db2caeec31c8153', '2TzUgupxn9rh5arqnOv6bOWjxXMyRbrivBhpYcqr9CUhHMWPoLU9gaEBTQX1PILAFYOmy6uBq0EZDhmxDGJqlMZqPBC2DashM2TlJrIPRp3deao98bQoJhJZq2qZGy4N', NULL, NULL, 'avatar.jpg', 0, 0, NULL, 0, 0, 0, NULL, '2019-05-13 16:02:18', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `reference`
--

CREATE TABLE `reference` (
  `reference_id` int(11) NOT NULL,
  `reference_member` int(11) NOT NULL,
  `reference_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `reference_company` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `reference_title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `reference_email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `reference_gsm` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `reference_description` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reference_order` int(11) DEFAULT '0',
  `reference_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reference_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reference_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `reference`
--

INSERT INTO `reference` (`reference_id`, `reference_member`, `reference_name`, `reference_company`, `reference_title`, `reference_email`, `reference_gsm`, `reference_description`, `reference_order`, `reference_insert`, `reference_update`, `reference_active`) VALUES
(1, 4, 'Andrew Jackson', 'US Presidente', 'Hero', 'andrew@gov.com', '+1 155 552 363 33', '0', 0, '2019-04-20 19:49:23', '2019-04-20 19:49:23', 0),
(2, 4, 'Andrew Jackson', 'US Presidente', 'Hero', 'andrew@gov.com', '+1 155 552 363 33', '0', 0, '2019-04-20 19:55:25', '2019-04-20 19:55:25', 1);

-- --------------------------------------------------------

--
-- Table structure for table `skill`
--

CREATE TABLE `skill` (
  `skill_id` int(11) NOT NULL,
  `skill_member` int(11) NOT NULL,
  `skill_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `skill_level` int(11) DEFAULT '0',
  `skill_order` int(11) DEFAULT '0',
  `skill_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `skill_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `skill_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `skill`
--

INSERT INTO `skill` (`skill_id`, `skill_member`, `skill_name`, `skill_level`, `skill_order`, `skill_insert`, `skill_update`, `skill_active`) VALUES
(1, 4, 'C11#', 3, 0, '2019-04-20 12:03:50', '2019-04-20 12:35:01', 0),
(2, 4, 'C#', 3, 0, '2019-04-20 12:05:28', '2019-04-20 12:05:28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE `token` (
  `token_id` int(11) NOT NULL,
  `token_member` int(11) NOT NULL,
  `token_key` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `token_lock` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `token_ip` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `token_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `token_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `token_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `token`
--

INSERT INTO `token` (`token_id`, `token_member`, `token_key`, `token_lock`, `token_ip`, `token_insert`, `token_update`, `token_active`) VALUES
(1, 4, 's3UrMY2LyuQkAnqP6XYIJ5F3030PeTq2As8QGS5rSoSeWnEPMWdGA8PgT7d2rqStXDREo59qxdjQ8aENoch8pbS5JlaTver0RnLMUmgoOFG1NenNabJzdByReRINyvMP', 'rKNLSkEhRMtw8guLqvOZVXW2xWMctdps28hYTS0nBSdbRyS2tt3ObSc46MU4DAdoOow3UdiZ8z3J1SBrCGe5bB5lhGidz6OTxBPTtfDD8oZYZ7d7n4hGWK6Q4qiwbWWq', '::1', '2019-04-19 16:56:12', '2019-04-20 10:14:39', 0),
(2, 4, 'iPsp2zZJlzwk2eBQB2Ji2Lzs6fyARhRS12hSosjiHF3hRcUF5BNcTT6yNEIKFGqVnbqIuufFxPqwH8mYIeX9fHFjsWdhBuTejgO5VgL0hvZpmPR76CVDiBzEiMcnKR81', 'cKIoSTJfW6epemxeCdq2E1g7WRuLflE3hrlPGeoZMS4rYH4J4sF8U7dsETqfBuooSOasOOR5e8iQgqbZUePlssFMGcdYBpHuFC8MSTHMDF36DsISKo23toIcsANdBn8O', '::1', '2019-04-20 10:14:39', '2019-04-20 10:14:43', 0),
(3, 4, 'psuQ7LuYvLYB9x9xUtfNUfsAs3EB0HyAbddxH2AtWexnaCjxk2jaw3S2cPjEx1uh8cuQ2c3GtZFRVrrfwsxPbYeoJ6KdkF2Kbva3zkH8VtdZU08e8Ac2D7FLQJfz9pmG', 'gPKFgRBtl8AUmQq0psvHiusyX8bLax3yLCZ03tft5bb5fqkBGTkn27yqAemU3bCCLIEwZ2Lp46VxJyRMynswjtIgtc2CQr3gMtEQ3JhtgggVThny2kxN8DRlLHvmcpDz', '::1', '2019-04-20 10:14:43', '2019-04-20 10:14:43', 0),
(4, 4, 'OgY32D5fPibyPH33FffXfHFccWz1vbQunmpgJjWVs92WceNlu66xyOdXsMJTxwsTQM1gd1fwp3fJTyIlmYqu3LQCYMEHURZ42NZMvCrexs9t5wGGsWQlVR7lWO4sl1RV', 'wJfSFpgQq6JFK1mzk60IsZ0puMis1k88BrpIHmlwlL9u2gmXoLTWMQx6QUN8bmZWS7WKQUhbAbCHXsIMuJ0Aoj3joB9571K6EYvOx8cmnwe8uoH0qF2LR4XfcICla3gX', '::1', '2019-04-20 10:14:43', '2019-04-20 10:17:51', 0),
(5, 4, 'Nk2nf8UFhRDThFsOCa3BGwjQDfpyQtnl9PSxwRHqSX13Jh7q6TqyEVJs6frAfknCJhHsRayyHpjHqmtaRKLsjtBb1u18q9ddstn44f119CWwiOPhbP5jtDxS0wjXoleZ', 'gF5r1DCuB9VRHGkE6hi7ofCC6tnqlf6Amr6ZqdviVyZPVJprtLJXkSr1XKR0doFaE0eXssckXVbVpju8hWfohfWNnoGGvA6li0ycw9nc8Z0eDXmHpQR1ewDtdk7jL8ZE', '::1', '2019-04-20 10:17:51', '2019-04-20 10:18:00', 0),
(6, 4, 'poANGMprrX6RknuI0qdoMks4LYsDeHEFR06zbcaXqcjMVFbMIo1nZFZx5vbawjuos0tryLBO1BX17mjaZFhuQBT3jgZOQnEG3HVEnjI3LkMFH3lQASDHCVVLQFE7qF52', '1sAA3JaoyKoMLhNv6lokWPqrcRewGTzns8tUniyYEnJGjdwxVXSGyyKuOaQcL5nhGzVI2N9hSzgzrZcyCl7QU3A63lOgnm333dCdSN2JKbAxk4sHkAR2zGcbtgMnobr6', '::1', '2019-04-20 10:18:00', '2019-04-20 10:19:22', 0),
(7, 4, 'mJ6rAOP6IM1HEKbpfMFwSTSa4vA4LiK73MUXrp66Nvig1wv0ItZAbyROymxOD4Q12jVNVc4wBHpCX2QMzHUGxL2NXpHtW02tqzOwu2EBctgprcJsfXwCB1TKD2dgA8nV', 'dtH8V6wOn1jl6gu6RbM9PYnpyPUUZC8Up9ui6B1r995RzzgN1VcF89SdRmHy3Lm54obROY67nfyS6hyNqiq9LrRC11OfWnmWRyYNsLmN0rznkqR5A8eGHEWO17PbTkng', '::1', '2019-04-20 10:19:22', '2019-04-20 10:21:14', 0),
(8, 4, 'bfBNFItzciX8fSkqWQwRZW3FU3Ve0TYRZ9UFu0Am723Lf8FAExgkfgP59cxrHRUloHfFjDUazGxOot8MXHgiAzXYYwMAn9aKKibHT3WViJkLsi45S2vmA47UKidpt7Aa', 'LJyq2E2Oh9GBgIgIAATUgIExQziDcYCEt1MHXsvnzUYzLr4BWaMIburw9vbbr2s1POFOoco7PZ48hX8vGl4fd6kYAeGiBrTbw1f1jqxfbbDa2pNZ6nYRFnNetWkK21do', '::1', '2019-04-20 10:21:14', '2019-04-20 10:21:33', 0),
(9, 4, 'L0fza4Xw0qwNVc8a4OLhig8IlktFC2Isad0EZeruTFHXJ1kDSDAYyYmMUKudXMuQ7cIKcw6b2awHRqfzaD4IXDC0YnlpNxCWPZSG7ceO1MQjn490mgQZtOowVD9VXmLg', '101OKsxI41suMwYz58NYcWmVlothRQ10ldjb1AWswwNlJ94WCMKHcTxSj41f8fHDqSKjOhZOS8mqbBsVVoXeXeBpMtcM0E4b71OyuRukkq6lLolv1TfC0sElgWibCPxP', '::1', '2019-04-20 10:21:33', '2019-04-20 10:21:33', 0),
(10, 4, 'S00Zd5jC9Q4JT6gnTmIxBEkEljvP5KVlvmt5oIxKQ9Sb4eLTG5YF3X5ja8Fp220YK3blXdIfbfNlzXX7dVbfXK7Yi5ddmob1N6SLGIlTLLfTXZbplAFbpJaRsOy1cYGz', 'jRmvxHFlIY9D9nAg1nQCmJmqc6jFCjWRXnnC0aLsJfgdgYrPnz7knQ001lqANKR3ouIAKHpm4x4AVCn5hVhiAt1pMZdfSVNUOiEsWm0TUJSzGYfGt5gwGGgyoXQSnawd', '::1', '2019-04-20 10:21:33', '2019-04-20 10:21:34', 0),
(11, 4, 'wEHmZs40XBSkeDISZXOB6PYend7uklv4qEHnZSEq9ojtNFgZUthHujUz4KS1AWPc2tX3Qs6igsf2klLNmA1PioK30d1lj6jR1UjhFlsw1L9ddGnPVqbjfNr5kWgMwaOd', 'dTj147xRfVJdrvsFMapcxmZxWEFpPSikI2xlwtysiTxXjMW0iBXoTYwHZFp86hCu1RYYhGPKTNzn3bGKETmDeacTiu8bXF7b7QW4FMT6KrkFfVAG73zXKHTya0aaDzKM', '::1', '2019-04-20 10:21:34', '2019-04-20 10:21:34', 0),
(12, 4, 'eWhtqWD0FnvQ0ptGuIoSpbOu06jI9h8dDEa8dEfe5qu2SqGJud4im7sZBVfbioD2kbG8Xe3uZ2l9FXqFhzyodHfJWVZbb8tF9akDJdOJ1CDF2Er3h3fRSTCzOWrh5h8C', 'w0fuhWi7XtIvt6zUHNTt6SMjts9SJ6Qwl2pOW52kTbP3DW1gRMXlzV94tfIspw7eM1rFkhaY40JBQ1nFzLw0VlYU6eSfcn1mAxijKsjzSrkzldjeyXe7e17wNY9gQ2FW', '::1', '2019-04-20 10:21:34', '2019-04-20 10:21:36', 0),
(13, 4, 'EzR1tzw6y2jGV2LeUvcK6XbCfsaJkLsbvFIcEVM8AGrEYntNsLqAmFITwX6ooJhtAw8ctSAnEstX4bSdBe4Wq2RNggU4DuYjEBzea5NSgzaUIed9eX78x7KTABhjBFGN', 'AHTzhQuL4bOEJWZfvNrzy0OXLQQ12hpWyMDXNX4qS4OddoSj6OzEHcYSbDTTKha6EI0GeDCKuU3KI3fP4TEwr8JVMusOXUg5t3L0wIHkQUtO2YTk2eftPTLoEsRVzqe1', '::1', '2019-04-20 10:21:36', '2019-04-20 10:23:12', 0),
(14, 4, 'VgOThf7wCQg5wiSlPOXV8NPdp3f7tXyWeWuIv1FS1uS51nnYCt8bSG7bj8Q9zfUSQeLoRceTvsPv9X1eM3wqKLS0lKcIclyqvdD1eJC477Rj7qJQgF0LCCoO1NeIaYVV', 'V2GI3vvr01jZfrgRlLplFOOp9DAt3F35x8LGZUKM1FP2tw85QmIzdSQCkjjM7CeIf9iknBpZF0l3uKmo43dTjrP4f1RaTFAk5Bz1vySCvU6CZ8S0GxEtG5buyfrxcdws', '::1', '2019-04-20 10:23:12', '2019-04-20 10:23:14', 0),
(15, 4, '1eI0KqyVFrKXW89hOk6Apqa9sw7mGVs0TAfO0pyv24ctDfJjfIbfEx3P73Ds3Liu6d1IEWsyRttefPMN4w5RIihIlvBLf8P7P24CNMVOVpk4Mf7FMGmAMEJ1Cf3TIo0g', 'TkFsnZzNItW6urs1BL7BN3qFN4XxR4jpt71lASFqgdPE3ulja5Zbi5YkFfURbALfZdXStLQrTtSZaN2gC4kW7obLyWecxqw707zwpJHMpEXgLT4Z8oZsHFWPJ17LRKmD', '::1', '2019-04-20 10:23:14', '2019-04-20 10:23:14', 0),
(16, 4, 'kr2fQj6bE5BQC1UxBwGBZtblCiuypCsT0CjxefUikWzR0fAdQRB9J0A44bh4nhRfiqiYMrpy3FWhXme8vu64GzbTBVw88XmSahQrpjL0BVfErfvDZ0L7w8z2GAs9gZNs', 'bJwp974DfCXy3PtQaXPIykls950p4hix9ThT6BGY6DySiWYswR2WBBZY7RGadRh0wtgvcfdUQoyeVPY8COj9kns1xpJZnXA1ci2XipktSNHjtgqUO0fedUFZ5cObxkAF', '::1', '2019-04-20 10:23:14', '2019-04-20 10:23:15', 0),
(17, 4, 'FnxzWpJ3FpPHyDn9qDuSZZCBvFnOMPewaq7ukei5VTUos643PEthQxSprsbdsBsJ7RCS6Wwi5egiqFVVLg5r2ytEnrqLs040OegSTJ5SPCAeNVQNQXeFmd0jsGxTJ0Bf', 's48ygdV4c6SP4Mlcuzi3wlv0sX3opkZkMHLkf53QKqw09eo5zdlUA8Mi9gjb1jpLeyCvwaV9FX8y5ILtVOekotolGWHyYomEzZQGGqZelcJkKRYOzinIrdPqtbJiJgZx', '::1', '2019-04-20 10:23:15', '2019-04-20 10:24:25', 0),
(18, 4, 'esjR5gCoeY1lmn0QRma4LKorl38oAUDSLhmOQb6yAlxBjSa8teNbjmxZlDW7FQ6hilDn9MvRZdmtVjthXiAD7AWWhWb1o6xjTE5KDMmznsh70ovjkMNl8gjDJeoIVWW7', 'b4GzCaEIQkzvsPaQFfwRzfIuvycw47ZaimHsmwR4VMDnTIAhiohx910CKgphZuZ2iBnIXEb3Un09GSRzdWq5qlKoI09EDQQ8VmYe54CF54TH8fJbaWfZPMpstugrr6EY', '::1', '2019-04-20 10:24:25', '2019-04-20 11:45:50', 0),
(19, 4, '6bmp5ABjCLM59Lj6Ayznxj8HOmKjLxU3JVHGViqtjFh6DpjVT4x13ONHERmrWEe17XdP0aoZB598OMhyrjgpZenjKybiLjmJCISbqVgRulfozine4PcDpq7KkN25nC7g', '4xEeZXV58y3YsgIKLHGCNnqIDSQQJgNcxSVBh5hWYkIfFNPhBG0L2Fir1JTvmVO7t73iSAcsJTXdiRhiBASaq7kVDs7TGfw0rk5uXD3oN4GQ08VwNzZyCakoqK74Hcx7', '::1', '2019-04-20 12:02:37', '2019-04-20 16:17:28', 0),
(20, 4, 'wt9DfRWz6zMqcMqTFsQ6atCZLx2mCaZyH7C6FQzrZV857suezsn3XLb5q3kCRbGFMRCifPIjXOqLQhpv84zWImrOPkJhGu04YJKMxtOV6DN6A4rcuRHaCN9GgUqU1n2R', 'YuqFFyhkSvyONtr5RdIGEBeJlYlOG2ypmhAEu5KyFJhc7XmLe9bTki2FzpPNbjDkmUnenrbhKRBfo8BCRZwjgB7OcKsgDzltgHFimNQgvyiOeQ1B1UkuMaLRLY6v3fqW', '::1', '2019-04-20 16:17:28', '2019-04-20 22:12:18', 0),
(21, 4, '0rMb6TSJIUN3FiAYNFzgj8eEflCADiU3cLXO6ZlZptAzlMAqCoFlzYaQvPXpPJFjpoUmkKDnRATHIbxR9MjpeKqyz47Uh5hzM85vrfhYtRbx1YIiLSjByNhXB24c1H3Q', 'klYpFDi2QNIsNCZK0CvYnmW7u8p2WX8u0MBZ7fprFB4BpwRC56mQkKiFBFAeg8B4as8KQX1vUEhqaBlcJkOS4am84ub127XS7a8cBeE9GpIpXavGgyZriCpIDCPqdFAA', '::1', '2019-04-23 21:30:14', '2019-04-23 21:31:32', 0),
(22, 4, 'gfwzuCa9VSaYB8aExqu6dmfm9HWeZNBAzWVRpgLGkEJDVmnqKUMJVmAF7EOqLN3mDkc1XJTljr9nS2dtd5czZAKyZBLwwLUpdmVBRyKPnznzA5U1nBKxLWTLV4mIGvog', '4AAxKx2KVO2ut8jEQmgSMY1u6OZQekutd3K4ryB0xewZZu8ghF5elom9e68UDeGPp7dDY015OXpmuMO6PMx5AASQTjx8R5mP5aY3zFHL82AGPnViuXeLcBq6ZbtRdbk9', '::1', '2019-04-23 21:31:41', '2019-04-23 21:31:52', 0),
(23, 4, 'J2XVnOdASG4ov8MS2LygpYuvmUAwfwR5k6AVjOCueYlQRblIS66jDhjSi66fkuK7dw1j8CasWBcaTDG10Mb6B0njXNF41rXhwaJcnJofwrBNita9RrCnaHAOIZ6qHZ1l', '7HYE1HnqKTPvAo8xiTFSgd9L78k4hFcNk5wEMxZHQSrz0T4FPzUzTuSak3TiLqTUbvsgJ9rFZ0QadrvqdKlIwiH8SzZBI0vxwGB86qMWPdL3N7lTHwIf06odLz1edvCa', '::1', '2019-04-23 21:38:20', '2019-04-23 21:38:28', 0),
(24, 4, 'NRuzEnPhsjThFVzITxBYmEOxJIAIAMT6FvVVxTnRs1CUps7uLNn8lPMduVU8X5qqXMqSfNtwBe3tBNBIYdnywLB6L0NgJ7sCDpqjjqVAirljzZxEOZlBLVue1VWSzanm', '1SKwKuLUZP3nRztSaf9DzlS4t7IJu4qmtaxUGt13X9pkDpW3BKa3ief0m6sZV8M7l5UZuttnMMDw5gzUwe6mRvgkfaJhfmmNyGpJqcgl71fnrE6h2QMzaxeApzBbs1uS', '::1', '2019-04-23 21:38:57', '2019-04-23 21:39:04', 0),
(25, 4, 'HIEfauUA8YzbFxwDBzTxp23aMqcHbp3HRzxNwdoT2mPQRfMJ4hlRFJybe3i2LfpaZppZORiyB2tdysF0YkIP9swmmIiq40nOzvfz3Uy7ADdNvi5QVVrsSk2cKHRNk10D', 'Z24Zy9HXaWCpUmks4CKC4iSM3paNcHO2vdjXbwcJVdvQZVMi8qnNCNzi2nFqCdDIDYzNf1BeDAZ9bp0aQrXZ4NEWFMWMjjdWALqabeL0qBkK1fC4aFdBSjXbaUwslG5R', '::1', '2019-05-13 14:10:38', '2019-05-13 14:11:50', 0),
(26, 4, 't5vegQLJ5SUCDZe4nGq14W9NBhjuiP6tu1aFZ0z8cUQp7mtsQiLSvTRbNx8bTykFb0UzcDJWigv6SZgdwF41dZx5z1Fc0DxeKM0KZqvUn9lj2TTaROTjHMdbYLPWA4vC', 'bUzhdydKfE0c3pXIZJpbMTibcvJngm4sfSjqwAxgho5OXlJYqkynr6iK3SihVDvn8wxmUWJdzuAU54G20XqLrFbTLzBR1L2rWWZcKkwzBJsAghWMnmA6DDI9iUpCAkZ9', '::1', '2019-05-13 14:12:55', '2019-05-13 14:12:56', 0),
(27, 4, '8mIgmVMhVncYYuVAyRmexbZ4jZAIAThApwSgrsvgRUmQbyrsRglGtldk5L5WDA5Zd8EDex9nwoTyGdIpfgbEmLIgKD5l8Iv8vUnh7mgsyjC8OcDQVLJ8I8JtJISqxK3I', 'WXLdQp2RhtrRGYVIL1s1mnI3mt6Zv4dLhh98uc13xs3nnKsOVVHxKeFuFzgm97ptpUjjzRfSmPaJz0MdsCvFvIAJEKuWQNPn3Xnqw5L8v31O5O9dUnjYNXeIvVPxqdFG', '::1', '2019-05-13 14:12:56', '2019-05-13 14:12:56', 0),
(28, 4, 'dY17EJK3wzSqV9vCtw6Kl8z0GDN41xnJh4fufyFL4CpYyShpqfS7GtClInAEkqPlLflXlqN449SGxEHSThgFXUAnGcNp5ZqyWm5QyCxuqcGrZthox55regbIcofje39c', 'D6VtQ5nIURnbSpdH8kmsQTPnwYRNfiorVg8ErBMPAKoCoVjXIBHPW3aoFOHRVoHPebPxMvGlAerUQ82u65C8zSaMaaqvmL0DjTCHbmeRkthFhh0YNS1LTTusN9P9iGTy', '::1', '2019-05-13 14:12:56', '2019-05-13 16:03:27', 0),
(29, 4, 'wLw9Nsuau2j2Iyww1hP5n5rQ7DbgIThNZjruN9CqXqgJ95w0ToVu1YC4MBTafaRfgRMQRUau38GZSNJsrkuaZczikZ9XZd3uQ8F9z81XlyjT4rbQSuBJBT6uMFVrzx9M', 'BNk6qyJ9ChVJinSKmVioWr9eW9RgVLQBIC9yE1XEalHZyoeCDD8kj573j6SsmTk7rKiPA4xlva3jOEAZ1jm5LwyNWaLrE79ob7nCVzSHKNUVhqMMr7bpPqT6KABbc72v', '::1', '2019-05-13 16:03:27', '2019-05-13 16:03:32', 0),
(30, 4, 'gMRButCSKHOqfsaEWkQVXwwizdXxxfGpE5Vwc9v4dUw93f9d1LpJbxDE4hyQ61ZqmvR1Im7cpfsV5Z9ahNIfDpBsqKq5ai9UhXRyIYHKfDey4zSH2FsBUU0zN6j7fmZY', 'lW56W79kiK0EmWP4Mbxr0UzA9LUbfZfjYtcW7aQ9bjRFk6TtnkUidLloVwAhhLO3tSnApCjvhyq9tLW5Ub6CGOzHB8278zGTtxWiXE7bCWO3XUYVfui3bAeonO4awb5H', '::1', '2019-05-13 16:03:32', '2019-05-14 18:54:27', 0),
(31, 4, 'q8dIG4l42MU24J8gg65al95RaIEMtlIVqLIxonnlmWKQBbc8IXSxF8oFN4pNlq6J821QRG8TEHDPCISWqofMepLD1a4nj0FglQubv2wjLYnnKXNrDczMfl6gILvyJxtR', '4Vd0qFMdCJKAMpNhG4UioVbMBUmAcCiInwdtBt1xqdSUEdtES7QMVKmKjqCmLxmkOZ0v6R1M6y6scWE4D5sw6QiQh0H1ELjwtyf5vsi3MStlMX0ZbscIlazyEJCKfyeO', '::1', '2019-05-14 18:54:27', '2019-05-14 20:59:49', 0),
(32, 4, 'PzOABccJmeHNyzQP940TcDFesOtr3cAZJFLGylY0SlPHU61xf2kZkkeVMzqQRMYeQq7wiUoAhzmSTn39A63soPRVk8I2Wp3TjThAx0H60jsSip1BNQ99HKwDS6LlcWHs', 'gxkH62Ak0kffXlkRPVmA32zu4b32z9aZFFZQgiJYJQ0SeoFbv4UmlIZBIAI8AoctLcjntoaJ31FmzO7I7ULZnVfkurnb3FdqEfO5MdQGQ8N6BUJqvcUd1DaNvUNelJNG', '::1', '2019-05-14 21:00:45', '2019-05-15 14:44:01', 0),
(33, 4, 'y9r2NHIGW0aYxJ6TAmA8KqISg09D6QrwsgzsabzBFwIS3GrKeO3PRiWXleZVvQpQkp3DfLUxtaC9TxQNZh1hZXpPb1HJMBLaEi6B47VGm78wb1BkZjJUASmxDp6oWIIp', 'EkJpvrHN4CdfYIK3IrmHsVLOzU919auptCmUzR412IydOduDGl74t8PL9XXcemSMn1KlzFc0FU63ay42bydeDxTvuX0HFjW6LWszksyVUAPmwJAZ6dmZBFVad6LOkUHy', '::1', '2019-05-15 14:44:01', '2019-05-16 08:08:26', 0),
(34, 4, '1sI2SNJGOYCLzl9wKJA79tIx86VbsTNY2riw83a1R6uPxtkQ5xOUtHmZLrb4UXra2Oy3wpBI04jOqbpqWnmfvp7AIbMhTnY43iPgcDLgJx9eOOvoUmSxGdAcy5SzsSYd', '5ddWniA6SBsqxuOBz6cHEKrGjpnvpp4CaCOCeVRSdUY0lYk4w4FNFY1zaPol4BMMiReYmduLOY2TmBuB0GMsTChTvVZxepy87bHyCt4LRhhkMEl7tT7VjCdcRrNOmGSt', '::1', '2019-05-16 08:08:26', '2019-05-16 08:08:26', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `afe`
--
ALTER TABLE `afe`
  ADD PRIMARY KEY (`afe`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `certificate`
--
ALTER TABLE `certificate`
  ADD PRIMARY KEY (`certificate_id`);

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`education_id`);

--
-- Indexes for table `experience`
--
ALTER TABLE `experience`
  ADD PRIMARY KEY (`experience_id`);

--
-- Indexes for table `job_adv`
--
ALTER TABLE `job_adv`
  ADD PRIMARY KEY (`job_adv_id`);

--
-- Indexes for table `job_adv_language`
--
ALTER TABLE `job_adv_language`
  ADD PRIMARY KEY (`job_adv_language_id`);

--
-- Indexes for table `job_adv_location`
--
ALTER TABLE `job_adv_location`
  ADD PRIMARY KEY (`job_adv_location_id`);

--
-- Indexes for table `job_adv_military`
--
ALTER TABLE `job_adv_military`
  ADD PRIMARY KEY (`job_adv_military_id`);

--
-- Indexes for table `job_apply`
--
ALTER TABLE `job_apply`
  ADD PRIMARY KEY (`job_apply_id`);

--
-- Indexes for table `lang`
--
ALTER TABLE `lang`
  ADD PRIMARY KEY (`lang_id`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`language_id`);

--
-- Indexes for table `licence`
--
ALTER TABLE `licence`
  ADD PRIMARY KEY (`licence_id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `reference`
--
ALTER TABLE `reference`
  ADD PRIMARY KEY (`reference_id`);

--
-- Indexes for table `skill`
--
ALTER TABLE `skill`
  ADD PRIMARY KEY (`skill_id`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`token_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `afe`
--
ALTER TABLE `afe`
  MODIFY `afe` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10043;

--
-- AUTO_INCREMENT for table `certificate`
--
ALTER TABLE `certificate`
  MODIFY `certificate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `education_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `experience`
--
ALTER TABLE `experience`
  MODIFY `experience_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `job_adv`
--
ALTER TABLE `job_adv`
  MODIFY `job_adv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `job_adv_language`
--
ALTER TABLE `job_adv_language`
  MODIFY `job_adv_language_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_adv_location`
--
ALTER TABLE `job_adv_location`
  MODIFY `job_adv_location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `job_adv_military`
--
ALTER TABLE `job_adv_military`
  MODIFY `job_adv_military_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_apply`
--
ALTER TABLE `job_apply`
  MODIFY `job_apply_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lang`
--
ALTER TABLE `lang`
  MODIFY `lang_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
  MODIFY `language_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `licence`
--
ALTER TABLE `licence`
  MODIFY `licence_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10002;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `reference`
--
ALTER TABLE `reference`
  MODIFY `reference_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `skill`
--
ALTER TABLE `skill`
  MODIFY `skill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `token`
--
ALTER TABLE `token`
  MODIFY `token_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
