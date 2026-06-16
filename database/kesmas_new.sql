-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 23, 2026 at 11:09 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kesmas_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `active_sessions`
--

CREATE TABLE `active_sessions` (
  `id` int NOT NULL,
  `session_id` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `expires_at` datetime NOT NULL,
  `is_valid` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `active_sessions`
--

INSERT INTO `active_sessions` (`id`, `session_id`, `user_id`, `username`, `ip_address`, `user_agent`, `created_at`, `expires_at`, `is_valid`) VALUES
(1, 'rf7851gfa5cdi978njju4nnuckev4f62', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-04-20 15:35:04', '2026-04-20 17:35:04', 1),
(2, '3r063giri4jegu3dklcvh7711483rg9g', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-04-20 15:41:33', '2026-04-20 17:41:33', 1),
(3, 'hkoj4gvt6tdn82tgm5piv02b8updjse5', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-20 15:58:22', '2026-04-20 17:58:22', 1),
(4, 'hhaf2a1qrp442cekcefv3n7d86o6dpf0', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-04-20 16:00:27', '2026-04-20 18:00:27', 1),
(5, 'p8689ikh69pp5af5a39tv831pofum3te', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-20 16:03:39', '2026-04-20 18:03:39', 1),
(6, 'clbjcn0230j7gvf31uo908so4luk6qrl', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-04-20 16:06:20', '2026-04-20 18:06:20', 1),
(7, '9o9s8rlcssv9mdfca9rkemj9eeeucl3f', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-20 16:12:17', '2026-04-20 18:12:17', 1),
(8, 'ifnegdbb0hlo1d85cro7ss9nrmj3vpv2', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-20 16:19:56', '2026-04-20 18:19:56', 1),
(9, '8c506dr9uu9su2pqn82javm5tl3kqgak', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-20 16:25:48', '2026-04-20 18:25:48', 1),
(10, '66m1kv2voa4plp5ljuuppr4r27o41d87', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-20 16:31:46', '2026-04-20 18:31:46', 1),
(11, 'fdjk865of2rd042bvt07f7s4b21ruim6', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-04-20 16:57:33', '2026-04-20 18:57:33', 0),
(12, 'fldtur9ri67152g9udbvk42inf025od3', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-04-20 17:01:44', '2026-04-20 19:01:44', 0),
(13, 'ssgja93j3j5vsskbip7delajakgf43gi', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-04-20 17:02:38', '2026-04-20 19:02:38', 1),
(14, 'fmne40lhp63ejnrii7s3bcm7o7dl9b2o', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-04-20 22:08:48', '2026-04-21 00:08:48', 1),
(15, '5ta9kmjb1rjde81bb2jpnb86lhqs2kpg', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-04-20 22:15:36', '2026-04-21 00:15:36', 1),
(16, 'ukirviefcep85h4puad6hdlrm5p1alir', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-04-20 22:25:21', '2026-04-21 00:25:21', 1),
(17, 'svg787n95cp7rldsujjs58hrnblgl6al', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-04-20 22:36:19', '2026-04-21 00:36:19', 1),
(18, 'qf53s2f61q9gcvvkk1613h5cjb3u51rs', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-04-20 22:41:28', '2026-04-21 00:41:28', 1),
(19, 'ukb13pe39jfm3thd10k52h6l97v33e5o', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-04-22 14:33:45', '2026-04-22 16:33:45', 1),
(20, 'm7rvti9c3m03r588dgrfe4ve53o0u5vk', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-04-22 14:45:24', '2026-04-22 16:45:24', 1),
(21, 'qi5sh9hoobt92i2oua7ro811cr1llm1a', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-04-22 14:52:20', '2026-04-22 16:52:20', 1),
(22, 'htikf2u0id47vfdm6378t61g0hki12hc', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-04-22 15:00:49', '2026-04-22 17:00:49', 1),
(23, '6ejqageagris11hihfigbcs95uq08srp', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-04-22 15:06:04', '2026-04-22 17:06:04', 1),
(24, '0j3gmplqk8opu8rd06nukvg3q0rh28le', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-22 15:09:40', '2026-04-22 17:09:40', 1),
(25, 'r6brjtc4odsk9n1u214m84nbk9h8tm0a', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-22 15:15:18', '2026-04-22 17:15:18', 1),
(26, 'r6von79evagqnikcm58mk4n842o0askv', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-22 15:21:32', '2026-04-22 17:21:32', 1),
(27, 'iifqeuke642g79rg6lab5tujc10fuo11', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-22 15:26:38', '2026-04-22 17:26:38', 1),
(28, '9bo9sgfefgvgb7sb983pj2gnpa1sa17o', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-22 15:33:17', '2026-04-22 17:33:17', 1),
(29, '9s95h94r0t3eodp4i2jv78tomm1k0ad4', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-22 15:40:12', '2026-04-22 17:40:12', 1),
(30, 'i0jt30mq9n9h1ra5ilnreqgordmhdhmf', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-22 19:47:45', '2026-04-22 21:47:45', 1),
(31, 's705lbo634eqqbhbtcvrc4obuhldcs8b', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-04-24 19:00:43', '2026-04-24 21:00:43', 1),
(32, '2565advu92amk3s5vujaem82k214ctbc', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-04-24 19:06:34', '2026-04-24 21:06:34', 1),
(33, 'c5lieececc278s2e60nua85n9pkogovb', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-29 05:37:46', '2026-04-29 07:37:46', 1),
(34, '8mts12lt2s7v8tij62rnlglhj42l0vfb', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-29 05:50:46', '2026-04-29 07:50:46', 1),
(35, '7ccptusa21mfbp29cp9q1pfaon9gojhh', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-29 06:01:16', '2026-04-29 08:01:16', 1),
(36, 's8sqtgausv51vaadrsrta7g3s348umce', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-29 06:48:24', '2026-04-29 08:48:24', 0),
(37, 'hv61ia235f1dgs6c19b3b8k350bfd5ss', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-29 06:55:03', '2026-04-29 08:55:03', 0),
(38, 'ldf6ukq12kjvudq25vrfeu18v12fsrbv', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-29 06:59:32', '2026-04-29 08:59:32', 1),
(39, '6v6h7n81qhjostmmio10rgiaaelig1m5', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-29 07:05:10', '2026-04-29 09:05:10', 1),
(40, 'u95feqnkiogibrqtqevhsrvd3bk4vgqk', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-29 07:10:23', '2026-04-29 09:10:23', 1),
(41, 'lfl8ckptoim5jo65sj2qa87sdvpoe6vt', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-06 19:27:13', '2026-05-06 21:27:13', 1),
(42, 'k2ovumoatekrs3eq3f6klbha5b5kdkel', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-05-06 19:27:58', '2026-05-06 21:27:58', 0),
(43, 'td40hdu992uusmgae1n22nu8ruvssplv', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-06 19:36:27', '2026-05-06 21:36:27', 1),
(44, 'hpelm5r4gqdatn5fl1hsfv82vr8j6qr8', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-05-06 19:38:54', '2026-05-06 21:38:54', 1),
(45, 'la37sg8eoq6pcduupe92rkltj3tl2kmg', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-05-06 19:44:36', '2026-05-06 21:44:36', 1),
(46, 'j1ih24v8oqr12usnoak97l6o2lt8q2up', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-05-06 20:15:10', '2026-05-06 22:15:10', 1),
(47, '4n6n2acto6vlqd0gfbggqkb50p9p6bac', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-05-06 20:23:22', '2026-05-06 22:23:22', 1),
(48, 'qas8trs307cdttespbstiotsk4q6k2k5', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-11 14:57:33', '2026-05-11 16:57:33', 0),
(49, 'sfhvg67pb1et9mrcl4g4f2j802ven6h0', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-11 14:58:23', '2026-05-11 16:58:23', 0),
(50, 'h503dcmilnu3rf1veh0llhkbg57u11es', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-11 15:02:38', '2026-05-11 17:02:38', 1),
(51, 'hb5u93iepllkjluvrli5gllipoh9m8f9', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-11 15:04:52', '2026-05-11 17:04:52', 0),
(52, '3841nb1nrvffbj29tv86iphr5vjltesf', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-11 15:05:52', '2026-05-11 17:05:52', 0),
(53, 'j0s7935otonfvdke57kb94neh0ci11e4', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-11 15:29:38', '2026-05-11 17:29:38', 0),
(54, 'v0h0005h1oqna27eoln08doh1p6p2rs1', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-11 15:43:38', '2026-05-11 17:43:38', 1),
(55, 'epmeausr68thv18fcsdli8rhdl115t3p', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-12 21:45:11', '2026-05-12 23:45:11', 1),
(56, 'ah6rk21fq0s6seathhjbj0vqhofjr613', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 13:43:06', '2026-05-21 15:43:06', 1),
(57, '9j7vqfsf1lgkimdr24mqo2e2ct6816o9', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 15:44:59', '2026-05-21 17:44:59', 1),
(58, 'migavalg2nlusblu1dvpfq6jk9vj488l', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 21:36:15', '2026-05-21 23:36:15', 1),
(59, 'jb637fbr598mirqvshucnf53negv6tm9', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-21 23:42:31', '2026-05-22 01:42:31', 1),
(60, 'rdt15011jidpkujpnkorsipe7qhkbfn8', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-22 04:15:14', '2026-05-22 06:15:14', 1),
(61, 'rk624q5838m32liv7h90ppgajbo2735g', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-22 10:16:18', '2026-05-22 12:16:18', 1),
(62, 'itgsu5t97cr9fjvu9mbnvl4hbttcq4rf', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-23 16:23:23', '2026-05-23 18:23:23', 1),
(63, '2v75rmneaq05ajthq2li8jg9uv8t1o46', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.121.0 Chrome/142.0.7444.265 Electron/39.8.8 Safari/537.36', '2026-05-23 17:11:02', '2026-05-23 19:11:02', 1),
(64, 'ae0jf4ar28bdnvc5n5281tc0gd8t3obp', 1, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.121.0 Chrome/142.0.7444.265 Electron/39.8.8 Safari/537.36', '2026-05-23 17:14:02', '2026-05-23 19:14:02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `action` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'create, read, update, delete, export, print, etc',
  `module` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'kesmas, pembayaran, users, etc',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `record_id` int DEFAULT NULL COMMENT 'ID of the affected record',
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT 'JSON format of old values before change',
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT 'JSON format of new values after change',
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_pending`
--

CREATE TABLE `data_pending` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `data_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'kesmas, pembayaran, alat_lab, etc',
  `data_id` int NOT NULL COMMENT 'Reference to actual data record',
  `status` enum('pending','approved','rejected','revision_needed') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `requested_by` int NOT NULL COMMENT 'User who submitted the data',
  `approved_by` int DEFAULT NULL COMMENT 'User who approved/rejected',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `rejection_reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT 'Reason for rejection or needed revision',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `approved_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kesmas_hasil`
--

CREATE TABLE `kesmas_hasil` (
  `id` int NOT NULL,
  `permintaan_id` int NOT NULL,
  `permintaan_item_id` int NOT NULL,
  `hasil` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `paraf` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `tms_status` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tgl_jam_pemeriksaan` datetime DEFAULT NULL,
  `tgl_jam_selesai` datetime DEFAULT NULL,
  `tgl_jam_lapor` datetime DEFAULT NULL,
  `petugas_pengambilan_spesimen_id` int DEFAULT NULL,
  `input_by` int DEFAULT NULL,
  `input_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kesmas_hasil`
--

INSERT INTO `kesmas_hasil` (`id`, `permintaan_id`, `permintaan_item_id`, `hasil`, `paraf`, `keterangan`, `tms_status`, `tgl_jam_pemeriksaan`, `tgl_jam_selesai`, `tgl_jam_lapor`, `petugas_pengambilan_spesimen_id`, `input_by`, `input_at`) VALUES
(1083, 68, 1387, '4423', NULL, 'TMS', NULL, '2026-05-23 17:05:00', '2026-05-01 17:06:00', '2026-05-01 17:06:00', 5, 1, '2026-05-23 18:06:02'),
(1084, 68, 1388, '221', NULL, 'TMS', NULL, '2026-05-23 17:05:00', '2026-05-01 17:06:00', '2026-05-01 17:06:00', 5, 1, '2026-05-23 18:06:02'),
(1085, 68, 1389, '2121', NULL, 'TMS', NULL, '2026-05-23 17:05:00', '2026-05-01 17:06:00', '2026-05-01 17:06:00', 5, 1, '2026-05-23 18:06:02'),
(1086, 68, 1377, '45663', NULL, 'MS', NULL, '2026-05-23 17:05:00', '2026-05-01 17:06:00', '2026-05-01 17:06:00', 5, 1, '2026-05-23 18:06:02'),
(1087, 68, 1378, '2121', NULL, 'MS', NULL, '2026-05-23 17:05:00', '2026-05-01 17:06:00', '2026-05-01 17:06:00', 5, 1, '2026-05-23 18:06:02'),
(1088, 68, 1379, '1221', NULL, 'MS', NULL, '2026-05-23 17:05:00', '2026-05-01 17:06:00', '2026-05-01 17:06:00', 5, 1, '2026-05-23 18:06:02'),
(1089, 68, 1380, '2121', NULL, 'MS', NULL, '2026-05-23 17:05:00', '2026-05-01 17:06:00', '2026-05-01 17:06:00', 5, 1, '2026-05-23 18:06:02'),
(1090, 68, 1381, '212', NULL, 'TMS', NULL, '2026-05-23 17:05:00', '2026-05-01 17:06:00', '2026-05-01 17:06:00', 5, 1, '2026-05-23 18:06:02'),
(1091, 68, 1382, '2121', NULL, 'MS', NULL, '2026-05-23 17:05:00', '2026-05-01 17:06:00', '2026-05-01 17:06:00', 5, 1, '2026-05-23 18:06:02'),
(1092, 68, 1383, '1221', NULL, 'MS', NULL, '2026-05-23 17:05:00', '2026-05-01 17:06:00', '2026-05-01 17:06:00', 5, 1, '2026-05-23 18:06:02'),
(1093, 68, 1384, '2121', NULL, 'MS', NULL, '2026-05-23 17:05:00', '2026-05-01 17:06:00', '2026-05-01 17:06:00', 5, 1, '2026-05-23 18:06:02'),
(1094, 68, 1385, '212', NULL, 'TMS', NULL, '2026-05-23 17:05:00', '2026-05-01 17:06:00', '2026-05-01 17:06:00', 5, 1, '2026-05-23 18:06:02'),
(1095, 68, 1386, '22', NULL, 'TMS', NULL, '2026-05-23 17:05:00', '2026-05-01 17:06:00', '2026-05-01 17:06:00', 5, 1, '2026-05-23 18:06:02');

-- --------------------------------------------------------

--
-- Table structure for table `kesmas_master_pemeriksaan`
--

CREATE TABLE `kesmas_master_pemeriksaan` (
  `id` int NOT NULL,
  `kategori` varchar(50) NOT NULL COMMENT 'air_minum, air_bersih, makanan, lingkungan',
  `kelompok` varchar(50) NOT NULL COMMENT 'Fisika, Kimia Wajib, Kimia Khusus, Bakteriologi, dll',
  `nama_pemeriksaan` varchar(150) NOT NULL,
  `satuan` varchar(50) DEFAULT NULL,
  `baku_mutu` varchar(255) DEFAULT NULL,
  `baku_type` varchar(30) DEFAULT NULL COMMENT 'numeric_range,numeric_limit,text,qualitative,none',
  `baku_operator` varchar(10) DEFAULT NULL COMMENT 'e.g. <,<=,>,>=,=',
  `baku_min` double DEFAULT NULL,
  `baku_max` double DEFAULT NULL,
  `baku_text` varchar(255) DEFAULT NULL COMMENT 'raw textual rule for qualitative checks',
  `metode` varchar(150) DEFAULT NULL,
  `urutan` int NOT NULL COMMENT 'Urutan dalam masing-masing kelompok',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `nama_pemeriksaan_norm` varchar(200) GENERATED ALWAYS AS (lower(trim(regexp_replace(`nama_pemeriksaan`,_utf8mb4'[[:space:]]+',_utf8mb4' ')))) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kesmas_master_pemeriksaan`
--

INSERT INTO `kesmas_master_pemeriksaan` (`id`, `kategori`, `kelompok`, `nama_pemeriksaan`, `satuan`, `baku_mutu`, `baku_type`, `baku_operator`, `baku_min`, `baku_max`, `baku_text`, `metode`, `urutan`, `is_active`, `created_at`) VALUES
(1, 'air_minum', 'Fisika', 'Suhu', '°C', 'Suhu udara ±3 °C', NULL, NULL, NULL, NULL, NULL, 'potensiometri', 1, 1, '2026-01-08 15:09:14'),
(2, 'air_minum', 'Fisika', 'TDS (Zat Padat Terlarut)', 'mg/L', '< 300', NULL, NULL, NULL, NULL, NULL, 'potensiometri', 2, 1, '2026-01-08 15:09:14'),
(3, 'air_minum', 'Fisika', 'Kekeruhan', 'NTU', '< 3', 'numeric_limit', '<=', NULL, 3, NULL, 'turbidimetri', 3, 1, '2026-01-08 15:09:14'),
(4, 'air_minum', 'Fisika', 'Warna', 'TCU', '≤ 10', NULL, NULL, NULL, NULL, NULL, 'SNI-3554 : 2015', 4, 1, '2026-01-08 15:09:14'),
(5, 'air_minum', 'Fisika', 'Bau', '-', 'Tidak berbau', 'text', NULL, NULL, NULL, 'Tidak berbau', 'organoleptik', 5, 1, '2026-01-08 15:09:14'),
(6, 'air_minum', 'Kimia Wajib', 'pH', '-', '6,5 – 8,5', NULL, NULL, NULL, NULL, NULL, 'potensiometri', 1, 1, '2026-01-08 15:09:24'),
(7, 'air_minum', 'Kimia Wajib', 'Nitrat (NO3) (terlarut)', 'mg/L', '≤ 20', NULL, NULL, NULL, NULL, NULL, 'SNI-3554 : 2015', 2, 1, '2026-01-08 15:09:24'),
(8, 'air_minum', 'Kimia Wajib', 'Nitrit (NO2) (terlarut)', 'mg/L', '≤ 3', NULL, NULL, NULL, NULL, NULL, 'SNI-3554 : 2015', 3, 1, '2026-01-08 15:09:24'),
(9, 'air_minum', 'Kimia Wajib', 'Kromium Valensi 6 (Cr6+) (terlarut)', 'mg/L', '≤ 0,01', NULL, NULL, NULL, NULL, NULL, '-', 4, 1, '2026-01-08 15:09:24'),
(10, 'air_minum', 'Kimia Wajib', 'Besi (Fe) Terlarut', 'mg/L', '≤ 0,2', NULL, NULL, NULL, NULL, NULL, 'SNI 6989.4:2009', 5, 1, '2026-01-08 15:09:24'),
(11, 'air_minum', 'Kimia Wajib', 'Mangan (Mn) Terlarut', 'mg/L', '≤ 0,1', NULL, NULL, NULL, NULL, NULL, 'SNI 6989.5:2009', 6, 1, '2026-01-08 15:09:24'),
(12, 'air_minum', 'Kimia Wajib', 'Sisa Klor', 'mg/L', '0,2 – 0,5 dengan waktu kontak 30 menit', NULL, NULL, NULL, NULL, NULL, 'colorimetri', 7, 1, '2026-01-08 15:09:24'),
(13, 'air_minum', 'Kimia Wajib', 'Arsen (As)', 'mg/L', '≤ 0,01', NULL, NULL, NULL, NULL, NULL, '-', 8, 1, '2026-01-08 15:09:24'),
(14, 'air_minum', 'Kimia Wajib', 'Kadmium (Cd)', 'mg/L', '≤ 0,003', NULL, NULL, NULL, NULL, NULL, 'SNI 6989.16:2009', 9, 1, '2026-01-08 15:09:24'),
(15, 'air_minum', 'Kimia Wajib', 'Timbal (Pb)', 'mg/L', '≤ 0,01', NULL, NULL, NULL, NULL, NULL, 'SNI 6959.8:2009', 10, 1, '2026-01-08 15:09:24'),
(16, 'air_minum', 'Kimia Wajib', 'Fluorida (F) (terlarut)', 'mg/L', '≤ 1,5', NULL, NULL, NULL, NULL, NULL, 'SNI 3554:2015', 11, 1, '2026-01-08 15:09:24'),
(17, 'air_minum', 'Kimia Wajib', 'Aluminium (Al) (terlarut)', 'mg/L', '≤ 0,2', NULL, NULL, NULL, NULL, NULL, 'SNI 6989.34:2009', 12, 1, '2026-01-08 15:09:24'),
(18, 'air_minum', 'Kimia Khusus', 'Total Kromium (Cr)', 'mg/L', '≤ 0,05', NULL, NULL, NULL, NULL, NULL, '-', 1, 1, '2026-01-08 15:09:34'),
(19, 'air_minum', 'Kimia Khusus', 'Amonia (NH3)', 'mg/L', '≤ 1,5', NULL, NULL, NULL, NULL, NULL, '-', 2, 1, '2026-01-08 15:09:34'),
(20, 'air_minum', 'Kimia Khusus', 'Hidrogen Sulfida (H2S)', 'mg/L', '≤ 0,05', NULL, NULL, NULL, NULL, NULL, '-', 3, 1, '2026-01-08 15:09:34'),
(21, 'air_minum', 'Kimia Khusus', 'Sianida (CN)', 'mg/L', '≤ 0,07', NULL, NULL, NULL, NULL, NULL, 'SNI 3554:2015', 4, 1, '2026-01-08 15:09:34'),
(22, 'air_minum', 'Kimia Khusus', 'Tembaga (Cu)', 'mg/L', '≤ 2', NULL, NULL, NULL, NULL, NULL, 'SNI 6989.6:2009', 5, 1, '2026-01-08 15:09:34'),
(23, 'air_minum', 'Kimia Khusus', 'Selenium (Se)', 'mg/L', '≤ 0,01', NULL, NULL, NULL, NULL, NULL, '-', 6, 1, '2026-01-08 15:09:34'),
(24, 'air_minum', 'Kimia Khusus', 'Seng (Zn)', 'mg/L', '≤ 3', NULL, NULL, NULL, NULL, NULL, 'SNI 6989.7:2009', 7, 1, '2026-01-08 15:09:34'),
(25, 'air_minum', 'Kimia Khusus', 'Nikel (Ni)', 'mg/L', '≤ 0,07', NULL, NULL, NULL, NULL, NULL, '-', 8, 1, '2026-01-08 15:09:34'),
(26, 'air_minum', 'Kimia Khusus', 'Senyawa Diazo', 'mg/L', 'Negatif', NULL, NULL, NULL, NULL, NULL, '-', 9, 1, '2026-01-08 15:09:34'),
(27, 'air_minum', 'Kimia Khusus', 'Fenol', 'mg/L', '≤ 0,002', NULL, NULL, NULL, NULL, NULL, '-', 10, 1, '2026-01-08 15:09:34'),
(28, 'air_minum', 'Kimia Khusus', 'Fosfat', 'mg/L', '≤ 0,2', NULL, NULL, NULL, NULL, NULL, '-', 11, 1, '2026-01-08 15:09:34'),
(29, 'air_minum', 'Kimia Khusus', 'MBAS', 'mg/L', '≤ 0,05', NULL, NULL, NULL, NULL, NULL, '-', 12, 1, '2026-01-08 15:09:34'),
(30, 'air_minum', 'Bakteriologi', 'Escherichia coli', 'CFU/100mL', '0', NULL, NULL, NULL, NULL, NULL, 'SNI 3554:2015', 1, 1, '2026-01-08 15:09:45'),
(31, 'air_minum', 'Bakteriologi', 'Total Coliform', 'CFU/100mL', '0', NULL, NULL, NULL, NULL, NULL, 'SNI 3554:2015', 2, 1, '2026-01-08 15:09:45'),
(32, 'air_minum', 'Bakteriologi', 'ALT (Angka Lempeng Total)', 'Koloni/mL', 'Maks 1,0 x 10^2', NULL, NULL, NULL, NULL, NULL, 'SNI 3554:2015', 3, 1, '2026-01-08 15:09:45'),
(33, 'air_bersih', 'Fisika', 'Suhu', '°C', 'Suhu udara ±3 °C', NULL, NULL, NULL, NULL, NULL, 'potensiometri', 1, 1, '2026-01-08 15:12:52'),
(34, 'air_bersih', 'Fisika', 'TDS (Zat Padat Terlarut)', 'mg/L', '< 1000', NULL, NULL, NULL, NULL, NULL, 'potensiometri', 2, 1, '2026-01-08 15:12:52'),
(35, 'air_bersih', 'Fisika', 'Kekeruhan', 'NTU', '< 25', NULL, NULL, NULL, NULL, NULL, 'turbidimetri', 3, 1, '2026-01-08 15:12:52'),
(36, 'air_bersih', 'Fisika', 'Warna', 'TCU', '≤ 50', NULL, NULL, NULL, NULL, NULL, 'SNI-3554 : 2015', 4, 1, '2026-01-08 15:12:52'),
(37, 'air_bersih', 'Fisika', 'Bau', '-', 'Tidak berbau', NULL, NULL, NULL, NULL, NULL, 'organoleptik', 5, 1, '2026-01-08 15:12:52'),
(38, 'air_bersih', 'Kimia', 'pH', '-', '6,5 – 8,5', NULL, NULL, NULL, NULL, NULL, 'potensiometri', 1, 1, '2026-01-08 15:14:03'),
(39, 'air_bersih', 'Kimia', 'Nitrat', 'mg/L', '≤ 20', NULL, NULL, NULL, NULL, NULL, 'SNI-3554 : 2015', 2, 1, '2026-01-08 15:14:03'),
(40, 'air_bersih', 'Kimia', 'Nitrit', 'mg/L', '≤ 3', NULL, NULL, NULL, NULL, NULL, 'SNI-3554 : 2015', 3, 1, '2026-01-08 15:14:03'),
(41, 'air_bersih', 'Kimia', 'Kromium Valensi 6 (Cr6+) (terlarut)', 'mg/L', '≤ 0,05', NULL, NULL, NULL, NULL, NULL, '-', 4, 1, '2026-01-08 15:14:03'),
(42, 'air_bersih', 'Kimia', 'Fe (Terlarut)', 'mg/L', '≤ 1', NULL, NULL, NULL, NULL, NULL, 'SNI 6989.4:2009', 5, 1, '2026-01-08 15:14:03'),
(43, 'air_bersih', 'Kimia', 'Mangan', 'mg/L', '≤ 0,5', NULL, NULL, NULL, NULL, NULL, 'SNI 6989.5:2009', 6, 1, '2026-01-08 15:14:03'),
(50, 'air_bersih', 'Bakteriologi', 'Escherichia coli', 'CFU/mL', '0 cfu/ml', NULL, NULL, NULL, NULL, NULL, 'SNI 3554:2015', 1, 1, '2026-01-08 15:14:58'),
(51, 'air_bersih', 'Bakteriologi', 'Total Coliform', 'CFU/mL', '0 cfu/ml', NULL, NULL, NULL, NULL, NULL, 'SNI 3554:2015', 2, 1, '2026-01-08 15:14:58'),
(52, 'makanan', 'Kimia', 'Boraks', 'Kualitatif', 'Negatif', NULL, NULL, NULL, NULL, NULL, 'Test Kit / Kurkumin', 1, 1, '2026-01-08 15:17:37'),
(53, 'makanan', 'Kimia', 'Formalin', 'Kualitatif', 'Negatif', NULL, NULL, NULL, NULL, NULL, 'Colorimetri', 2, 1, '2026-01-08 15:17:37'),
(54, 'makanan', 'Kimia', 'Methanyl Yellow', 'Kualitatif', 'Negatif', NULL, NULL, NULL, NULL, NULL, 'Colorimetri', 3, 1, '2026-01-08 15:17:37'),
(55, 'makanan', 'Kimia', 'Rhodamin B', 'Kualitatif', 'Negatif', NULL, NULL, NULL, NULL, NULL, 'Colorimetri', 4, 1, '2026-01-08 15:17:37'),
(56, 'makanan', 'Kimia', 'Sakarin', 'mg/kg', 'Boleh digunakan tidak melebihi batas maksimum penggunaan dalam kategori pangan', NULL, NULL, NULL, NULL, NULL, 'Colorimetri', 5, 1, '2026-01-08 15:17:37'),
(57, 'makanan', 'Bakteriologi', 'Escherichia coli', 'MPN/g', '< 3,6', NULL, NULL, NULL, NULL, NULL, 'SNI 2897:2008', 1, 1, '2026-01-08 15:17:51'),
(58, 'makanan', 'Bakteriologi', 'Salmonella sp.', 'Negatif/25g', 'Negatif', NULL, NULL, NULL, NULL, NULL, '-', 2, 1, '2026-01-08 15:17:51'),
(59, 'makanan', 'Bakteriologi', 'Staphylococcus aureus', 'CFU/g', '1 x 10^2', NULL, NULL, NULL, NULL, NULL, '-', 3, 1, '2026-01-08 15:17:51'),
(60, 'makanan', 'Bakteriologi', 'Listeria monocytogenes', 'Negatif/25g', 'Negatif', NULL, NULL, NULL, NULL, NULL, '-', 5, 1, '2026-01-08 15:17:51'),
(61, 'makanan', 'Parasitologi', 'Parasitologi Sayuran', 'Kualitatif', 'Negatif Telur/Larva', NULL, NULL, NULL, NULL, NULL, '-', 1, 1, '2026-01-08 15:18:23'),
(62, 'lingkungan', 'Lingkungan', 'Angka Kuman Ruangan', 'CFU/m2', NULL, NULL, NULL, NULL, NULL, NULL, 'Air Sampler / Settle Plate', 1, 1, '2026-01-08 15:18:51'),
(63, 'lingkungan', 'Lingkungan', 'Angka Kuman Usap Tangan', 'CFU/cm2', '≤ 1,1', NULL, NULL, NULL, NULL, NULL, 'ALT', 2, 1, '2026-01-08 15:18:51'),
(64, 'lingkungan', 'Lingkungan', 'Angka Kuman Usap Alat Makan', 'CFU/cm2', '≤ 1,1', NULL, NULL, NULL, NULL, NULL, 'ALT', 3, 1, '2026-01-08 15:18:51'),
(65, 'air_minum', 'Kimia Khusus', 'Detergen', 'mg/L', '≤ 0,05', NULL, NULL, NULL, NULL, NULL, '-', 13, 1, '2026-01-08 15:31:05'),
(66, 'makanan', 'Kimia', 'Siklamat', 'mg/kg', 'Boleh digunakan tidak melebihi batas maksimum penggunaan dalam kategori pangan', NULL, NULL, NULL, NULL, NULL, 'Colorimetri', 6, 1, '2026-01-09 10:56:53'),
(67, 'makanan', 'Bakteriologi', 'Bacilusllus careus', 'CFU/g', '-', NULL, NULL, NULL, NULL, NULL, '-', 4, 1, '2026-01-09 11:12:09');

-- --------------------------------------------------------

--
-- Table structure for table `kesmas_penanggung_jawab_teknis`
--

CREATE TABLE `kesmas_penanggung_jawab_teknis` (
  `id` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kesmas_penanggung_jawab_teknis`
--

INSERT INTO `kesmas_penanggung_jawab_teknis` (`id`, `nama`, `nip`, `is_active`, `created_at`) VALUES
(1, 'IRLIYANDRA SST', '198608062008041001', 1, '2026-01-12 21:47:31');

-- --------------------------------------------------------

--
-- Table structure for table `kesmas_permintaan`
--

CREATE TABLE `kesmas_permintaan` (
  `id` int NOT NULL,
  `no_registrasi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_sampel` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kategori_sample` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jenis_sampel` enum('Air Minum','Air Bersih','Makanan','Lingkungan') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `volume_ml` int DEFAULT NULL,
  `tgl_pengambilan` date DEFAULT NULL,
  `jam_pengambilan` time DEFAULT NULL,
  `lokasi_pengambilan` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `petugas_pengambil_id` int DEFAULT NULL,
  `info_tambahan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `nama_pengirim` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat_pengirim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telp_pengirim` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `instansi` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tgl_permintaan` date DEFAULT NULL,
  `ttd_pengirim` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tindakan_sampel` enum('Langsung','Kiriman','Rujuk') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kategori_air` tinyint(1) NOT NULL DEFAULT '0',
  `kategori_makanan` tinyint(1) NOT NULL DEFAULT '0',
  `kategori_lingkungan` tinyint(1) NOT NULL DEFAULT '0',
  `status_kelayakan` enum('Layak','Tidak Layak') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `verified_by` int DEFAULT NULL,
  `verified_at` datetime DEFAULT NULL,
  `alasan_tidak_layak` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `jumlah_biaya` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total_dibayar` decimal(15,2) NOT NULL DEFAULT '0.00',
  `cara_bayar` enum('Tunai','Non Tunai','Lain-lain') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cara_bayar_lainnya` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_bayar` enum('Lunas','Belum Lunas') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Belum Lunas',
  `petugas_pendaftaran_id` int DEFAULT NULL,
  `petugas_pengambil_ttd_id` int DEFAULT NULL,
  `petugas_verifikasi_id` int DEFAULT NULL,
  `petugas_validasi_id` int DEFAULT NULL,
  `kk_pengambilan` datetime DEFAULT NULL,
  `kk_sampel_diterima_lab` datetime DEFAULT NULL,
  `kk_pengerjaan_sampel` datetime DEFAULT NULL,
  `kk_input_hasil` datetime DEFAULT NULL,
  `kk_cetak_hasil` datetime DEFAULT NULL,
  `paraf_pengambilan` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `paraf_diterima_lab` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `paraf_pengerjaan` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `paraf_input_hasil` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `paraf_cetak` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_by` int DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_diterima` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kesmas_permintaan`
--

INSERT INTO `kesmas_permintaan` (`id`, `no_registrasi`, `nama_sampel`, `kategori_sample`, `jenis_sampel`, `volume_ml`, `tgl_pengambilan`, `jam_pengambilan`, `lokasi_pengambilan`, `petugas_pengambil_id`, `info_tambahan`, `nama_pengirim`, `alamat_pengirim`, `telp_pengirim`, `instansi`, `tgl_permintaan`, `ttd_pengirim`, `tindakan_sampel`, `kategori_air`, `kategori_makanan`, `kategori_lingkungan`, `status_kelayakan`, `is_verified`, `verified_by`, `verified_at`, `alasan_tidak_layak`, `jumlah_biaya`, `total_dibayar`, `cara_bayar`, `cara_bayar_lainnya`, `status_bayar`, `petugas_pendaftaran_id`, `petugas_pengambil_ttd_id`, `petugas_verifikasi_id`, `petugas_validasi_id`, `kk_pengambilan`, `kk_sampel_diterima_lab`, `kk_pengerjaan_sampel`, `kk_input_hasil`, `kk_cetak_hasil`, `paraf_pengambilan`, `paraf_diterima_lab`, `paraf_pengerjaan`, `paraf_input_hasil`, `paraf_cetak`, `catatan`, `created_by`, `created_at`, `updated_by`, `updated_at`, `is_diterima`) VALUES
(42, 'KESMAS.20260414.0003', 'svdsdf', 'Lingkungan', 'Air Minum', 111, '2026-04-01', '17:52:00', 'dsff', NULL, 'dsfsafd', 'fdsvds', 'we', 'wwe', 'w', '2026-04-14', NULL, NULL, 0, 0, 0, NULL, 0, NULL, NULL, NULL, '0.00', '0.00', '', '', 'Belum Lunas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2026-04-14 17:52:47', 1, '2026-04-19 17:07:10', 2),
(58, 'bram', 'SPOG GIRIMAYA2', 'Lingkungan', 'Makanan', 200, '2026-05-01', '15:01:00', 'JL.Basuki Rachmad ', NULL, 'yhgygt', 'ades bahagia', 'jl rasakunda', '081293032923', 'pemerintah', '2026-05-11', '', '', 0, 0, 0, NULL, 0, NULL, NULL, NULL, '0.00', '0.00', '', '', 'Belum Lunas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'mm', NULL, '2026-05-11 15:01:38', 1, '2026-05-23 18:04:24', 1),
(60, 'KESMAS.20260521.0001', 'aqua', 'Lingkungan', 'Lingkungan', 200, '2026-05-01', '14:15:00', 'JL.Basuki Rachmad ', NULL, '22', 'ades bahagia', 'jl fatmawati', '081293032923', 'dinkes', '2026-05-21', NULL, NULL, 0, 0, 0, NULL, 0, NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, 'Belum Lunas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-21 14:16:18', 1, '2026-05-23 16:53:36', 2),
(62, 'KESMAS.20260521.0002', 'wqe', 'Makanan', 'Lingkungan', 200, '2026-05-01', '15:34:00', 'JL.Basuki Rachmad ', NULL, '', 'ades bahagia', 'jl rasakunda', '081293032923', 'dinkes', '2026-05-21', NULL, NULL, 0, 0, 0, NULL, 0, NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, 'Belum Lunas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-21 15:34:40', 1, '2026-05-23 16:53:13', 2),
(63, 'n', 'bb', 'Lingkungan', 'Makanan', 200, '2026-05-01', '15:39:00', 'JL.Basuki Rachmad ', NULL, '11', 'ades bahagia', 'jl rasakunda', '081293032923', 'pemerintah', '2026-05-21', NULL, NULL, 0, 0, 0, NULL, 0, NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, 'Belum Lunas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-21 15:39:53', 1, '2026-05-23 18:08:03', 1),
(64, 'KESMAS.20260521.0004', 'bb', 'Lingkungan', 'Makanan', 200, '2026-05-01', '15:39:00', 'JL.Basuki Rachmad ', NULL, '11', 'ades bahagia', 'jl rasakunda', '081293032923', 'pemerintah', '2026-05-21', NULL, NULL, 0, 0, 0, NULL, 0, NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, 'Belum Lunas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-21 15:46:23', 1, '2026-05-23 16:53:02', 2),
(65, 'KESMAS.20260521.0005', 'bb', 'Lingkungan', 'Makanan', 200, '2026-05-01', '15:39:00', 'JL.Basuki Rachmad ', NULL, '11', 'ades bahagia', 'jl rasakunda', '081293032923', 'pemerintah', '2026-05-21', NULL, NULL, 0, 0, 0, NULL, 0, NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, 'Belum Lunas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-21 16:12:49', 1, '2026-05-23 16:52:50', 2),
(66, 'KESMAS.20260522.0001', 'ddsw', 'Air', 'Air Minum', 200, '2026-05-01', '11:05:00', 'JL.Basuki Rachmad ', NULL, 'adscd', 'ades bahagia', 'jl rasakunda', '081293032923', 'dinkes', '2026-05-22', NULL, NULL, 0, 0, 0, NULL, 0, NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, 'Belum Lunas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-22 11:05:51', 1, '2026-05-23 16:52:37', 2),
(68, 'KESMAS4567', '33', 'Air', 'Air Bersih', 200, '2026-05-23', '16:50:00', 'JL.Basuki Rachmad ', 9, 'bcv', 'ades bahagia', 'jl fatmawati', '081293032923', 'dinkes', '2026-05-23', '', 'Rujuk', 0, 0, 0, 'Layak', 0, NULL, NULL, NULL, '50000.00', '0.00', 'Tunai', '', 'Belum Lunas', 5, NULL, NULL, NULL, '2026-05-01 17:04:00', NULL, NULL, '2026-05-23 18:06:02', NULL, NULL, NULL, NULL, NULL, NULL, 'dsfds', NULL, '2026-05-23 16:50:53', 1, '2026-05-23 17:53:20', 1);

-- --------------------------------------------------------

--
-- Table structure for table `kesmas_permintaan_item`
--

CREATE TABLE `kesmas_permintaan_item` (
  `id` int NOT NULL,
  `permintaan_id` int NOT NULL,
  `master_pemeriksaan_id` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kesmas_permintaan_item`
--

INSERT INTO `kesmas_permintaan_item` (`id`, `permintaan_id`, `master_pemeriksaan_id`, `created_at`) VALUES
(1150, 42, 62, '2026-04-14 17:52:47'),
(1151, 42, 63, '2026-04-14 17:52:47'),
(1152, 42, 64, '2026-04-14 17:52:47'),
(1313, 58, 62, '2026-05-11 15:01:38'),
(1314, 58, 63, '2026-05-11 15:01:38'),
(1315, 58, 64, '2026-05-11 15:01:38'),
(1319, 60, 62, '2026-05-21 14:16:18'),
(1320, 60, 63, '2026-05-21 14:16:18'),
(1321, 60, 64, '2026-05-21 14:16:18'),
(1329, 62, 62, '2026-05-21 15:34:40'),
(1330, 62, 63, '2026-05-21 15:34:40'),
(1331, 62, 64, '2026-05-21 15:34:40'),
(1332, 63, 62, '2026-05-21 15:39:53'),
(1333, 63, 63, '2026-05-21 15:39:53'),
(1334, 63, 64, '2026-05-21 15:39:53'),
(1335, 64, 62, '2026-05-21 15:46:23'),
(1336, 64, 63, '2026-05-21 15:46:23'),
(1337, 64, 64, '2026-05-21 15:46:23'),
(1338, 65, 62, '2026-05-21 16:12:49'),
(1339, 65, 63, '2026-05-21 16:12:49'),
(1340, 65, 64, '2026-05-21 16:12:49'),
(1341, 66, 1, '2026-05-22 11:05:51'),
(1342, 66, 2, '2026-05-22 11:05:51'),
(1343, 66, 3, '2026-05-22 11:05:51'),
(1344, 66, 4, '2026-05-22 11:05:51'),
(1345, 66, 5, '2026-05-22 11:05:51'),
(1346, 66, 6, '2026-05-22 11:05:51'),
(1347, 66, 7, '2026-05-22 11:05:51'),
(1348, 66, 8, '2026-05-22 11:05:51'),
(1349, 66, 9, '2026-05-22 11:05:51'),
(1350, 66, 10, '2026-05-22 11:05:51'),
(1351, 66, 11, '2026-05-22 11:05:51'),
(1352, 66, 12, '2026-05-22 11:05:51'),
(1353, 66, 13, '2026-05-22 11:05:51'),
(1354, 66, 14, '2026-05-22 11:05:51'),
(1355, 66, 15, '2026-05-22 11:05:51'),
(1356, 66, 16, '2026-05-22 11:05:51'),
(1357, 66, 17, '2026-05-22 11:05:51'),
(1358, 66, 18, '2026-05-22 11:05:51'),
(1359, 66, 19, '2026-05-22 11:05:51'),
(1360, 66, 20, '2026-05-22 11:05:51'),
(1361, 66, 21, '2026-05-22 11:05:51'),
(1362, 66, 22, '2026-05-22 11:05:51'),
(1363, 66, 23, '2026-05-22 11:05:51'),
(1364, 66, 24, '2026-05-22 11:05:51'),
(1365, 66, 25, '2026-05-22 11:05:51'),
(1366, 66, 26, '2026-05-22 11:05:51'),
(1367, 66, 27, '2026-05-22 11:05:51'),
(1368, 66, 28, '2026-05-22 11:05:51'),
(1369, 66, 29, '2026-05-22 11:05:51'),
(1370, 66, 65, '2026-05-22 11:05:51'),
(1371, 66, 30, '2026-05-22 11:05:51'),
(1372, 66, 31, '2026-05-22 11:05:51'),
(1373, 66, 32, '2026-05-22 11:05:51'),
(1377, 68, 33, '2026-05-23 16:50:53'),
(1378, 68, 34, '2026-05-23 16:50:53'),
(1379, 68, 35, '2026-05-23 16:50:53'),
(1380, 68, 36, '2026-05-23 16:50:53'),
(1381, 68, 37, '2026-05-23 16:50:53'),
(1382, 68, 38, '2026-05-23 16:50:53'),
(1383, 68, 39, '2026-05-23 16:50:53'),
(1384, 68, 40, '2026-05-23 16:50:53'),
(1385, 68, 41, '2026-05-23 16:50:53'),
(1386, 68, 42, '2026-05-23 16:50:53'),
(1387, 68, 43, '2026-05-23 16:50:53'),
(1388, 68, 50, '2026-05-23 16:50:53'),
(1389, 68, 51, '2026-05-23 16:50:53');

-- --------------------------------------------------------

--
-- Table structure for table `kesmas_petugas_sampel`
--

CREATE TABLE `kesmas_petugas_sampel` (
  `id` int NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jabatan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `no_hp` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kesmas_petugas_sampel`
--

INSERT INTO `kesmas_petugas_sampel` (`id`, `nama`, `jabatan`, `no_hp`, `is_active`, `created_at`) VALUES
(5, 'Anita Prides,S.Tr.Kes', '-', NULL, 1, '2026-01-05 10:12:16'),
(9, 'nadine', '-', NULL, 1, '2026-01-12 04:41:53'),
(10, 'nata', 'ss', NULL, 1, '2026-05-21 14:20:15');

-- --------------------------------------------------------

--
-- Table structure for table `kesmas_survei_kepuasan`
--

CREATE TABLE `kesmas_survei_kepuasan` (
  `id` int NOT NULL,
  `permintaan_id` int DEFAULT NULL,
  `skor_pelayanan` int DEFAULT NULL,
  `skor_fasilitas` int DEFAULT NULL,
  `komentar_saran` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `tgl_survei` datetime DEFAULT NULL,
  `jam_survei` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pendidikan` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pekerjaan` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `usia` int DEFAULT NULL,
  `jenis_layanan` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `q1` tinyint NOT NULL DEFAULT '0' COMMENT 'Kesesuaian persyaratan',
  `q2` tinyint NOT NULL DEFAULT '0' COMMENT 'Kemudahan prosedur',
  `q3` tinyint NOT NULL DEFAULT '0' COMMENT 'Kecepatan waktu',
  `q4` tinyint NOT NULL DEFAULT '0' COMMENT 'Kewajaran biaya',
  `q5` tinyint NOT NULL DEFAULT '0' COMMENT 'Kesesuaian produk',
  `q6` tinyint NOT NULL DEFAULT '0' COMMENT 'Kompetensi petugas',
  `q7` tinyint NOT NULL DEFAULT '0' COMMENT 'Perilaku petugas',
  `q8` tinyint NOT NULL DEFAULT '0' COMMENT 'Kualitas sarana',
  `q9` tinyint NOT NULL DEFAULT '0' COMMENT 'Penanganan pengaduan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kesmas_survei_kepuasan`
--

INSERT INTO `kesmas_survei_kepuasan` (`id`, `permintaan_id`, `skor_pelayanan`, `skor_fasilitas`, `komentar_saran`, `tgl_survei`, `jam_survei`, `jenis_kelamin`, `pendidikan`, `pekerjaan`, `usia`, `jenis_layanan`, `created_at`, `q1`, `q2`, `q3`, `q4`, `q5`, `q6`, `q7`, `q8`, `q9`) VALUES
(16, 66, NULL, NULL, 'czcds', '2026-05-22 11:06:34', '13.00 - 15.00', 'L', 'SMP', 'TNI', 44, 'Makanan', '2026-05-22 04:06:34', 4, 4, 4, 4, 4, 4, 4, 4, 4),
(17, 68, NULL, NULL, 'v', '2026-05-23 16:51:39', '08.00 - 12.00', 'P', 'S2', 'POLRI', 44, 'ujilab', '2026-05-23 09:51:39', 4, 4, 4, 4, 4, 4, 4, 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `kesmas_tindakan_sampel`
--

CREATE TABLE `kesmas_tindakan_sampel` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kesmas_tindakan_sampel`
--

INSERT INTO `kesmas_tindakan_sampel` (`id`, `nama`, `is_active`) VALUES
(1, 'Langsung', 1),
(2, 'Kiriman', 1),
(3, 'Rujuk', 1);

-- --------------------------------------------------------

--
-- Table structure for table `kesmas_verifikator`
--

CREATE TABLE `kesmas_verifikator` (
  `id` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kesmas_verifikator`
--

INSERT INTO `kesmas_verifikator` (`id`, `nama`, `jabatan`, `is_active`, `created_at`) VALUES
(1, 'dr. Andiq', 'a', 0, '2026-01-05 04:46:08'),
(2, 'tukiyem', '1', 0, '2026-01-05 07:41:15'),
(3, 'gh', '1', 0, '2026-01-05 07:41:20'),
(4, 'alex', 'Analis', 1, '2026-01-07 23:46:43'),
(5, 'as', 'ds', 0, '2026-01-11 21:40:53');

-- --------------------------------------------------------

--
-- Table structure for table `login_logs`
--

CREATE TABLE `login_logs` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('success','failed','locked') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'failed',
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `failure_reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `login_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_logs`
--

INSERT INTO `login_logs` (`id`, `user_id`, `username`, `status`, `ip_address`, `user_agent`, `failure_reason`, `login_at`) VALUES
(75, NULL, 'gcgf', 'failed', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0', 'Invalid credentials', '2026-05-23 11:07:12');

-- --------------------------------------------------------

--
-- Table structure for table `user_kesmas`
--

CREATE TABLE `user_kesmas` (
  `id` int NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jabatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','petugas','viewer') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'petugas',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_kesmas`
--

INSERT INTO `user_kesmas` (`id`, `username`, `nama`, `jabatan`, `password_hash`, `role`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrator', NULL, '$2y$10$.YBwuO4Mw7Q2JyDT6wKWIeBBBdQhOnNyzlzSURq/rrR7aGSvpiiYS', 'admin', 1, '2025-12-26 15:57:40', NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_kesmas_laporan_detail`
-- (See below for the actual view)
--
CREATE TABLE `v_kesmas_laporan_detail` (
`baku_mutu` varchar(255)
,`hasil` varchar(255)
,`jenis_sampel` enum('Air Minum','Air Bersih','Makanan','Lingkungan')
,`kategori` varchar(50)
,`kelompok` varchar(50)
,`keterangan` text
,`metode` varchar(150)
,`nama_pemeriksaan` varchar(150)
,`nama_sampel` varchar(150)
,`no_registrasi` varchar(100)
,`paraf` varchar(50)
,`permintaan_id` int
,`permintaan_item_id` int
,`satuan` varchar(50)
,`tgl_jam_lapor` datetime
,`tgl_jam_pemeriksaan` datetime
,`tgl_jam_selesai` datetime
,`tgl_permintaan` date
,`urutan` int
);

-- --------------------------------------------------------

--
-- Structure for view `v_kesmas_laporan_detail`
--
DROP TABLE IF EXISTS `v_kesmas_laporan_detail`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_kesmas_laporan_detail`  AS SELECT `p`.`id` AS `permintaan_id`, `p`.`no_registrasi` AS `no_registrasi`, `p`.`nama_sampel` AS `nama_sampel`, `p`.`jenis_sampel` AS `jenis_sampel`, `p`.`tgl_permintaan` AS `tgl_permintaan`, `m`.`kategori` AS `kategori`, `m`.`kelompok` AS `kelompok`, `m`.`nama_pemeriksaan` AS `nama_pemeriksaan`, `m`.`satuan` AS `satuan`, `m`.`baku_mutu` AS `baku_mutu`, `m`.`metode` AS `metode`, `m`.`urutan` AS `urutan`, `i`.`id` AS `permintaan_item_id`, `h`.`hasil` AS `hasil`, `h`.`paraf` AS `paraf`, `h`.`keterangan` AS `keterangan`, `h`.`tgl_jam_pemeriksaan` AS `tgl_jam_pemeriksaan`, `h`.`tgl_jam_selesai` AS `tgl_jam_selesai`, `h`.`tgl_jam_lapor` AS `tgl_jam_lapor` FROM (((`kesmas_permintaan` `p` join `kesmas_permintaan_item` `i` on((`i`.`permintaan_id` = `p`.`id`))) join `kesmas_master_pemeriksaan` `m` on((`m`.`id` = `i`.`master_pemeriksaan_id`))) left join `kesmas_hasil` `h` on((`h`.`permintaan_item_id` = `i`.`id`)))  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `active_sessions`
--
ALTER TABLE `active_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `session_id` (`session_id`),
  ADD KEY `idx_session` (`session_id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_expires` (`expires_at`);

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `action` (`action`),
  ADD KEY `module` (`module`),
  ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `data_pending`
--
ALTER TABLE `data_pending`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `data_type` (`data_type`),
  ADD KEY `status` (`status`),
  ADD KEY `requested_by` (`requested_by`),
  ADD KEY `approved_by` (`approved_by`),
  ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `kesmas_hasil`
--
ALTER TABLE `kesmas_hasil`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_hasil_per_item` (`permintaan_item_id`),
  ADD KEY `fk_hasil_petugas` (`petugas_pengambilan_spesimen_id`),
  ADD KEY `fk_hasil_user` (`input_by`),
  ADD KEY `idx_hasil_permintaan` (`permintaan_id`),
  ADD KEY `idx_kesmas_hasil_tms_status` (`tms_status`);

--
-- Indexes for table `kesmas_master_pemeriksaan`
--
ALTER TABLE `kesmas_master_pemeriksaan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_master2` (`kategori`,`kelompok`,`urutan`),
  ADD UNIQUE KEY `uniq_master_nama_norm` (`kategori`,`kelompok`,`nama_pemeriksaan_norm`);

--
-- Indexes for table `kesmas_penanggung_jawab_teknis`
--
ALTER TABLE `kesmas_penanggung_jawab_teknis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kesmas_permintaan`
--
ALTER TABLE `kesmas_permintaan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_registrasi` (`no_registrasi`),
  ADD KEY `fk_permintaan_created_by` (`created_by`),
  ADD KEY `fk_permintaan_updated_by` (`updated_by`),
  ADD KEY `fk_permintaan_petugas_pengambil` (`petugas_pengambil_id`),
  ADD KEY `idx_permintaan_tgl` (`tgl_permintaan`),
  ADD KEY `idx_permintaan_jenis` (`jenis_sampel`);

--
-- Indexes for table `kesmas_permintaan_item`
--
ALTER TABLE `kesmas_permintaan_item`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_item` (`permintaan_id`,`master_pemeriksaan_id`),
  ADD KEY `idx_item_permintaan` (`permintaan_id`),
  ADD KEY `idx_item_master` (`master_pemeriksaan_id`);

--
-- Indexes for table `kesmas_petugas_sampel`
--
ALTER TABLE `kesmas_petugas_sampel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kesmas_survei_kepuasan`
--
ALTER TABLE `kesmas_survei_kepuasan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_permintaan_id` (`permintaan_id`);

--
-- Indexes for table `kesmas_tindakan_sampel`
--
ALTER TABLE `kesmas_tindakan_sampel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kesmas_verifikator`
--
ALTER TABLE `kesmas_verifikator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_logs`
--
ALTER TABLE `login_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `username` (`username`),
  ADD KEY `status` (`status`),
  ADD KEY `login_at` (`login_at`);

--
-- Indexes for table `user_kesmas`
--
ALTER TABLE `user_kesmas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `active_sessions`
--
ALTER TABLE `active_sessions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `data_pending`
--
ALTER TABLE `data_pending`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kesmas_hasil`
--
ALTER TABLE `kesmas_hasil`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1096;

--
-- AUTO_INCREMENT for table `kesmas_master_pemeriksaan`
--
ALTER TABLE `kesmas_master_pemeriksaan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `kesmas_penanggung_jawab_teknis`
--
ALTER TABLE `kesmas_penanggung_jawab_teknis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kesmas_permintaan`
--
ALTER TABLE `kesmas_permintaan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `kesmas_permintaan_item`
--
ALTER TABLE `kesmas_permintaan_item`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1390;

--
-- AUTO_INCREMENT for table `kesmas_petugas_sampel`
--
ALTER TABLE `kesmas_petugas_sampel`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `kesmas_survei_kepuasan`
--
ALTER TABLE `kesmas_survei_kepuasan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `kesmas_tindakan_sampel`
--
ALTER TABLE `kesmas_tindakan_sampel`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kesmas_verifikator`
--
ALTER TABLE `kesmas_verifikator`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `login_logs`
--
ALTER TABLE `login_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `user_kesmas`
--
ALTER TABLE `user_kesmas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `active_sessions`
--
ALTER TABLE `active_sessions`
  ADD CONSTRAINT `active_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_kesmas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kesmas_hasil`
--
ALTER TABLE `kesmas_hasil`
  ADD CONSTRAINT `fk_hasil_item` FOREIGN KEY (`permintaan_item_id`) REFERENCES `kesmas_permintaan_item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_hasil_permintaan` FOREIGN KEY (`permintaan_id`) REFERENCES `kesmas_permintaan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_hasil_petugas` FOREIGN KEY (`petugas_pengambilan_spesimen_id`) REFERENCES `kesmas_petugas_sampel` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_hasil_user` FOREIGN KEY (`input_by`) REFERENCES `user_kesmas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `kesmas_permintaan_item`
--
ALTER TABLE `kesmas_permintaan_item`
  ADD CONSTRAINT `fk_item_master` FOREIGN KEY (`master_pemeriksaan_id`) REFERENCES `kesmas_master_pemeriksaan` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_item_permintaan` FOREIGN KEY (`permintaan_id`) REFERENCES `kesmas_permintaan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
