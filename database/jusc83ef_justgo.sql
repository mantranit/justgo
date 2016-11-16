-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Nov 16, 2016 at 11:16 AM
-- Server version: 5.6.34
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jusc83ef_justgo`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', 87, 2147483647),
('admin', 88, NULL),
('member', 89, NULL),
('member', 90, 1445323466),
('member', 91, 1445324644),
('member', 92, NULL),
('member', 93, 1445395052),
('member', 94, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, 'Administrator of this application', NULL, NULL, 1427867249, 1427867249),
('adminArticle', 2, 'Allows admin+ roles to manage articles', NULL, NULL, 1427867248, 1427867248),
('createArticle', 2, 'Allows editor+ roles to create articles', NULL, NULL, 1427867248, 1427867248),
('deleteArticle', 2, 'Allows admin+ roles to delete articles', NULL, NULL, 1427867248, 1427867248),
('editor', 1, 'Editor of this application', NULL, NULL, 1427867248, 1427867248),
('manageUsers', 2, 'Allows admin+ roles to manage users', NULL, NULL, 1427867248, 1427867248),
('member', 1, 'Registered users, members of this site', NULL, NULL, 1427867248, 1427867248),
('premium', 1, 'Premium members. They have more permissions than normal members', NULL, NULL, 1427867248, 1427867248),
('support', 1, 'Support staff', NULL, NULL, 1427867248, 1427867248),
('theCreator', 1, 'You!', NULL, NULL, 1427867249, 1427867249),
('updateArticle', 2, 'Allows editor+ roles to update articles', NULL, NULL, 1427867248, 1427867248),
('updateOwnArticle', 2, 'Update own article', 'isAuthor', NULL, 1427867248, 1427867248),
('usePremiumContent', 2, 'Allows premium+ roles to use premium content', NULL, NULL, 1427867247, 1427867247);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('theCreator', 'admin'),
('editor', 'adminArticle'),
('editor', 'createArticle'),
('admin', 'deleteArticle'),
('admin', 'editor'),
('admin', 'manageUsers'),
('support', 'member'),
('support', 'premium'),
('editor', 'support'),
('admin', 'updateArticle'),
('updateOwnArticle', 'updateArticle'),
('editor', 'updateOwnArticle'),
('premium', 'usePremiumContent');

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_rule`
--

INSERT INTO `auth_rule` (`name`, `data`, `created_at`, `updated_at`) VALUES
('isAuthor', 'O:28:"common\\rbac\\rules\\AuthorRule":3:{s:4:"name";s:8:"isAuthor";s:9:"createdAt";i:1427867247;s:9:"updatedAt";i:1427867247;}', 1427867247, 1427867247);

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1427866981),
('m141022_115823_create_user_table', 1427866985),
('m141022_115912_create_rbac_tables', 1427866987),
('m141022_115922_create_session_table', 1427866987),
('m150104_153617_create_article_table', 1427866988);

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE IF NOT EXISTS `session` (
  `id` char(64) COLLATE utf8_unicode_ci NOT NULL,
  `expire` int(11) NOT NULL,
  `data` longblob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`id`, `expire`, `data`) VALUES
('1806ltg4glah36t8lvh7mm8uc6', 1477422606, 0x5f5f666c6173687c613a303a7b7d5f5f72657475726e55726c7c733a32333a222f61646d696e2f736974652f3f3d393335343338253430223b),
('1kvb0u2uri91vttet3fmj7mq47', 1478165926, 0x5f5f666c6173687c613a303a7b7d5f5f72657475726e55726c7c733a32363a222f61646d696e2f63617465676f72792f7570646174652f333234223b),
('2f0f1tk4v19jqlfgoacf1jm7o7', 1477735217, 0x5f5f666c6173687c613a303a7b7d5f5f72657475726e55726c7c733a373a222f61646d696e2f223b),
('4bcf62p78ju0dis7he5br4em27', 1478151360, 0x5f5f666c6173687c613a303a7b7d5f5f72657475726e55726c7c733a32313a222f61646d696e2f63617465676f72792f696e646578223b),
('6rf2k0468vgar4516o8ojmq5b0', 1477901118, 0x5f5f666c6173687c613a303a7b7d5f5f72657475726e55726c7c733a32313a222f61646d696e2f63617465676f72792f696e646578223b),
('7nsrkgtlr9fbjj3s62dmk4f882', 1477422605, 0x5f5f666c6173687c613a303a7b7d5f5f72657475726e55726c7c733a373a222f61646d696e2f223b),
('7v3eljv7qi5lb8k717k2n8lrf0', 1477883339, 0x5f5f666c6173687c613a303a7b7d5f5f636170746368612f736974652f636170746368617c733a363a22666561657977223b5f5f636170746368612f736974652f63617074636861636f756e747c693a313b),
('9eqreqoe372v3832n0l9vkhf17', 1477735313, 0x5f5f666c6173687c613a303a7b7d5f5f636170746368612f736974652f636170746368617c733a363a22626f7465637a223b5f5f636170746368612f736974652f63617074636861636f756e747c693a313b),
('bjhdlgsdlsr4ue0gd6ilnde807', 1479123383, 0x5f5f666c6173687c613a303a7b7d5f5f636170746368612f736974652f636170746368617c733a373a226e696c766a6f70223b5f5f636170746368612f736974652f63617074636861636f756e747c693a313b),
('c7tbs057qjq5a76i2c4igj0of4', 1479020979, 0x5f5f666c6173687c613a303a7b7d5f5f636170746368612f736974652f636170746368617c733a363a2262796c696975223b5f5f636170746368612f736974652f63617074636861636f756e747c693a313b),
('ffce8svaupfibefrl5c5mqhag3', 1477422591, 0x5f5f666c6173687c613a303a7b7d5f5f636170746368612f736974652f636170746368617c733a363a2277617169626e223b5f5f636170746368612f736974652f63617074636861636f756e747c693a313b),
('j93pivpggbicjfotjr46ghhff4', 1479123257, 0x5f5f666c6173687c613a303a7b7d5f5f636170746368612f736974652f636170746368617c733a363a226b696e616b6f223b5f5f636170746368612f736974652f63617074636861636f756e747c693a313b),
('krkcpg40a8b95je37qc4qk7cl4', 1477676964, 0x5f5f666c6173687c613a303a7b7d5f5f72657475726e55726c7c733a31323a222f61646d696e2f696e646578223b),
('l00205nc5aqr09ms6ddrim2br5', 1478492928, 0x5f5f666c6173687c613a303a7b7d5f5f72657475726e55726c7c733a373a222f61646d696e2f223b5f5f69647c693a38383b),
('mpcbah88nheg487gunnkf1on53', 1477422606, 0x5f5f666c6173687c613a303a7b7d5f5f636170746368612f736974652f636170746368617c733a373a2277707968646166223b5f5f636170746368612f736974652f63617074636861636f756e747c693a313b),
('oda9nllc88dkb4emal769c1p90', 1478665510, 0x5f5f666c6173687c613a303a7b7d5f5f72657475726e55726c7c733a32373a222f61646d696e2f636f6e6669672f73706c6173682d73637265656e223b5f5f69647c693a38383b),
('oqjbakcfc2k9jhaa3r8lg31ti1', 1478154944, 0x5f5f666c6173687c613a303a7b7d5f5f72657475726e55726c7c733a32363a222f61646d696e2f63617465676f72792f7570646174652f333232223b),
('u2macu2hiovptcj9gi9lgmgmc3', 1478674574, 0x5f5f666c6173687c613a303a7b7d);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_arrangement`
--

CREATE TABLE IF NOT EXISTS `tbl_arrangement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_id` int(11) NOT NULL,
  `content_type` enum('product','news') NOT NULL,
  `sorting` int(11) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=102 ;

--
-- Dumping data for table `tbl_arrangement`
--

INSERT INTO `tbl_arrangement` (`id`, `content_id`, `content_type`, `sorting`, `deleted`) VALUES
(76, 749, 'product', 2, 0),
(78, 744, 'product', 3, 0),
(101, 832, 'product', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE IF NOT EXISTS `tbl_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `slug` varchar(128) NOT NULL,
  `description` text,
  `general` text,
  `cat_type` int(11) NOT NULL DEFAULT '0',
  `seo_title` varchar(256) DEFAULT NULL,
  `seo_keyword` varchar(512) DEFAULT NULL,
  `seo_description` varchar(512) DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `sorting` int(11) NOT NULL DEFAULT '0',
  `show_in_menu` tinyint(1) NOT NULL DEFAULT '1',
  `activated` tinyint(1) NOT NULL DEFAULT '1',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=333 ;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`id`, `name`, `slug`, `description`, `general`, `cat_type`, `seo_title`, `seo_keyword`, `seo_description`, `parent_id`, `sorting`, `show_in_menu`, `activated`, `deleted`) VALUES
(271, 'Bộ phát wifi giá rẻ', 'bo-phat-wifi-gia-re', '', NULL, 0, 'Bộ phát wifi giá rẻ || DTC chuyên cung cấp bộ phát wifi giá rẻ, bộ phát wifi tenda, Tplink', 'bo phat wifi, bộ phát wifi, bo phat wifi gia re, bộ phát wifi giá rẻ, bo phat wifi tenda, bộ phát wifi tenda', 'Duy Tân Comuter chuyên cung cấp thiết bị mạng, bộ phát wifi giá rẻ đáp của các hãng nổi tiếng trên thị trường như bộ phát wifi tenda, bộ phát wifi Tplink, đáp ứng mọi nhu cầu làm việc và học tập của bạn.', 239, 7, 1, 1, 0),
(272, 'Bộ thu sóng wifi', 'bo-thu-song-wifi', '<h1>&nbsp;<a href="http://vitinhgiatot.com">vitinhgiatot.com</a> cung cấp usb thu s&oacute;ng wifi gi&aacute; rẻ&nbsp;</h1>\r\n\r\n<p>Bạn đang sử dụng m&aacute;y vi t&iacute;nh để b&agrave;n? bạn đang sử dụng m&aacute;y t&iacute;nh x&aacute;ch tay m&agrave; kh&ocirc;ng c&oacute; chức năng <strong>thu wifi</strong> ?</p>\r\n\r\n<p>Nhưng bạn kh&ocirc;ng muốn k&eacute;o d&acirc;y mạng đi khắp nh&agrave;, <strong>USB thu s&oacute;ng wifi </strong>sẽ giải quyết vấn đề đ&oacute; cho bạn, với một thiết bị như một USB lư trữ th&ocirc;ng thường, nhỏ gọn, nhưng c&oacute; chức năng thu wifi.&nbsp;</p>\r\n\r\n<p>Lợi &iacute;ch của việc sử dụng <strong>USB thu s&oacute;ng wifi</strong> l&agrave; rất dể di chuyển , kh&ocirc;ng đi d&acirc;y mạng chằng chịt trong nh&agrave;, kh&ocirc;ng mất thẩm mỹ cho ng&ocirc;i nh&agrave; hoặc căn ph&ograve;ng của bạn, c&oacute; thể x&agrave;i trong ph&ograve;ng m&aacute;y lạnh k&iacute;n kh&ocirc;ng c&oacute; chổ k&eacute;o d&acirc;y mạng,&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n', NULL, 0, 'Bộ thu sóng wifi giá rẻ || Duy Tân Computer chuyên cung cấp bộ thu sóng wifi giá rẻ, chất lượng', 'bo thu song wifi, bộ thu sóng wifi, bộ thu sóng wifi giá rẻ, bo thu song wifi gia re', 'Duy Tân Computer chuyên cung cấp thiết bị mạng, bộ thu phát sóng wifi giá rẻ và chất lượng nhất.', 239, 8, 1, 1, 0),
(292, 'Máy bộ HP DC 7900', 'may-bo-hp-dc-7900', '', NULL, 0, '', '', '', 262, 17, 1, 1, 0),
(293, 'Máy bộ Hp DC 7700', 'may-bo-hp-dc-7700', '', NULL, 0, '', '', '', 262, 19, 1, 1, 0),
(294, 'máy bộ HP DC7800', 'may-bo-hp-dc7800', '', NULL, 0, '', '', '', 262, 18, 1, 1, 0),
(295, 'Máy bộ HP 6000 Pro', 'may-bo-hp-6000-pro', '', NULL, 0, '', '', '', 262, 20, 1, 1, 0),
(296, 'Máy bộ Dell Optiplex 740', 'may-bo-dell-optiplex-740', '', NULL, 0, '', '', '', 261, 21, 1, 1, 0),
(297, 'Máy bộ Dell Optiplex 755', 'may-bo-dell-optiplex-755', '', NULL, 0, '', '', '', 261, 22, 1, 1, 0),
(298, 'Máy bộ Dell Optiplex 760', 'may-bo-dell-optiplex-760', '', NULL, 0, '', '', '', 261, 23, 1, 1, 0),
(299, 'Máy bộ Dell Optiplex 780', 'may-bo-dell-optiplex-780', '<p>&nbsp;</p>\r\n\r\n<h1 style="text-align:center">M&aacute;y t&iacute;nh đồng bộ Dell Optiplex 780 gi&aacute; rẻ&nbsp;</h1>\r\n\r\n<h2 style="margin-left:40px">* C&aacute;c đặc điểm nổi bật của m&aacute;y bộ Dell OPtiplex 780</h2>\r\n\r\n<p>&nbsp;-&nbsp;<strong>M&aacute;y bộ Dell Optiplex 780&nbsp;</strong>sử dụng chipset Q45. Hỗ trợ gần hết c&aacute;c d&ograve;ng CPU socket 755 từ core 2 duo đến core 2 quad &nbsp;. <strong>Sử dụng bộ nhớ DDR3</strong> gi&uacute;p tăng tố độ xử l&yacute; dữ liệu l&ecirc;n nhiều lần. Ngo&agrave;i ra&nbsp;<strong>m&aacute;y bộ dell Optiplex 780&nbsp;</strong>c&ograve;n được t&iacute;ch hợp card đồ họa onboarb GMA 4500HD l&ecirc;n đến 1GB, <strong>Dell optiplex 780</strong>&nbsp;hỗ trợ tốt cho người d&ugrave;ng với c&aacute;c nhu cầu giải tr&iacute; như xem phim HD, chơi c&aacute;c game nhẹ, xử l&yacute; đồ họa Photsshop, Autocad.&nbsp;</p>\r\n\r\n<h2 style="margin-left:40px">&nbsp;</h2>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n', NULL, 0, '', '', '', 261, 24, 1, 1, 0),
(300, 'Máy bộ Dell Optiplex 790 ( Core i3, i5, i7)', 'may-bo-dell-optiplex-790-core-i3-i5-i7', '', NULL, 0, '', '', '', 261, 25, 1, 1, 0),
(301, 'Máy bộ Dell Optiplex 960', 'may-bo-dell-optiplex-960', '', NULL, 0, '', '', '', 261, 26, 1, 1, 0),
(302, 'Máy bộ Dell Vostro / Inpiron', 'may-bo-dell-vostro-inpiron', '', NULL, 0, '', '', '', 261, 35, 1, 1, 0),
(303, 'Máy bộ Dell XPS / Studio', 'may-bo-dell-xps-studio', '', NULL, 0, '', '', '', 261, 34, 1, 1, 0),
(304, 'Máy bộ Dell Optiplex 380', 'may-bo-dell-optiplex-380', '', NULL, 0, '', '', '', 261, 36, 1, 1, 0),
(311, 'Máy bộ Dell core i3', 'may-bo-dell-core-i3', '', '', 0, '', '', '', 261, 27, 1, 1, 0),
(312, 'Máy bộ Dell core i5', 'may-bo-dell-core-i5', '', '', 0, '', '', '', 261, 28, 1, 1, 0),
(313, 'Máy bộ Dell core i7', 'may-bo-dell-core-i7', '', '', 0, '', '', '', 261, 29, 1, 1, 0),
(314, 'MÁY BỘ HP 8100 ELITE ( CORE I3, I5)', 'may-bo-hp-8100-elite-core-i3-i5', '', '', 0, '', '', '', 262, 37, 1, 1, 0),
(315, 'Lều trẻ em', 'leu-tre-em', '', '', 0, '', '', '', 322, 44, 1, 1, 0),
(316, 'Lều xông hơi', 'leu-xong-hoi', '', '', 0, '', '', '', 322, 38, 1, 1, 1),
(317, 'Lều 1 người', 'leu-1-nguoi', '', '', 0, '', '', '', 322, 39, 1, 1, 0),
(318, 'Lều 2 người', 'leu-2-nguoi', '', '', 0, '', '', '', 322, 40, 1, 1, 0),
(319, 'Lều 4 người', 'leu-3-nguoi', '', '', 0, '', '', '', 322, 41, 1, 1, 0),
(320, 'Lều 6 người', 'leu-6-nguoi', '', '', 0, '', '', '', 322, 42, 1, 1, 0),
(321, 'Lều 8 - 12 người', 'leu-8-nguoi', '', '', 0, '', '', '', 322, 43, 1, 1, 0),
(322, 'Lều Du Lịch', 'leu-cam-trai', '', '', 0, '', '', '', 0, 45, 1, 1, 0),
(323, 'Balo - Túi du lịch', 'balo-tui-du-lich', '', '', 0, '', '', '', 0, 46, 1, 1, 0),
(324, 'Đồ bảo hộ- thời trang', 'trang-phuc-di-phuot', '', '', 0, '', '', '', 0, 47, 1, 1, 0),
(325, 'Thiết bị công nghệ - Điện tử', 'thiet-bi-cong-nghe-dien-tu', '', '', 0, '', '', '', 0, 48, 1, 1, 0),
(326, 'Phụ kiện đi phượt', 'phu-kien-di-phuot', '', '', 0, '', '', '', 0, 49, 1, 1, 0),
(327, 'Áo giáp', 'ao-giap', '', '', 0, '', '', '', 324, 50, 1, 1, 0),
(328, 'Quần giáp', 'quan-giap', '', '', 0, '', '', '', 324, 51, 1, 1, 0),
(329, 'Bó gối', 'bo-goi', '', '', 0, '', '', '', 324, 52, 1, 1, 0),
(330, 'Giày ', 'giay-', '', '', 0, '', '', '', 324, 53, 1, 1, 0),
(331, 'Găng tay', 'gang-tay', '', '', 0, '', '', '', 324, 54, 1, 1, 0),
(332, 'Lều xông hơi', 'leu-xong-hoi1', '', '', 0, '', '', '', 322, 55, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_config`
--

CREATE TABLE IF NOT EXISTS `tbl_config` (
  `key` varchar(32) NOT NULL,
  `value` text NOT NULL,
  `group` varchar(32) NOT NULL,
  `sorting` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_config`
--

INSERT INTO `tbl_config` (`key`, `value`, `group`, `sorting`) VALUES
('ADDRESS', '10/26 Hoàng Hoa Thám, Phường 7, Quận Bình Thạnh, TP Hồ Chí Minh', 'CONFIG', 1),
('BANNER_WIDTH', '140', 'CONFIG', 6),
('EMAIL', 'duytancomputer350@gmail.com', 'CONFIG', 2),
('FACEBOOK_ADMINS', '100000862339139', 'SOCIAL', 2),
('FACEBOOK_APP_ID', '385946311598320', 'SOCIAL', 3),
('FACEBOOK_FANPAGE', 'https://www.facebook.com/maytinhdebandongbo', 'SOCIAL', 4),
('GOOGLE_ANALYTIC', 'UA-49182948-1', 'SOCIAL', 12),
('GOOGLE_API_KEY', 'AIzaSyADsBdwvuWj97mEVXRigKivd0aK1KPy6sw', 'SOCIAL', 11),
('GOOGLE_PUBLISHER', '108386168130570085938', 'SOCIAL', 13),
('LATITUDE', '10.805010538623224', 'SOCIAL', 9),
('LINK_FACEBOOK', 'https://www.facebook.com/maytinhdebandongbo', 'SOCIAL', 7),
('LINK_GOOGLE_PLUS', '', 'SOCIAL', 8),
('LONGITUDE', '106.69242064285277', 'SOCIAL', 10),
('PHONE', '0938 176 671', 'CONFIG', 3),
('PHONE_2', '08 62788887', 'CONFIG', 4),
('POPUP_CONTENT', '<h2>Nơi bắt đầu những chuyến đi....</h2>\r\n', '', 0),
('POPUP_ENABLED', '0', '', 0),
('POPUP_OPTIONS', '''autoSize'': false, ''width'': 500, ''height'': 300, ''padding'': 0', '', 0),
('SEO_DESCRIPTION', '', 'SEO', 3),
('SEO_KEYWORD', 'lều du lịch, lều cắm trại, lều xông hơi, lều trẻ em', 'SEO', 2),
('SEO_TITLE', 'JustGo - Mình thích thì mình đi thôi', 'SEO', 1),
('SUPPORT', '{"0":{"type":"yahoo","name":"Bán hàng 1","nickname":"duytan_computer350","phone":"0938176671"},"1":{"type":"yahoo","name":"Bán hàng 2","nickname":"tanold272","phone":"(08) 62788887"},"3":{"type":"skype","name":"Bán hàng 3","nickname":"achilles0905","phone":"0938176671"}}', 'SUPPORT', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_content`
--

CREATE TABLE IF NOT EXISTS `tbl_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) CHARACTER SET utf8 NOT NULL,
  `slug` varchar(128) CHARACTER SET utf8 NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `content_type` enum('page','news','slider','widget','banner') CHARACTER SET utf8 NOT NULL,
  `using_page_builder` tinyint(1) NOT NULL DEFAULT '0',
  `summary` text CHARACTER SET utf8 NOT NULL,
  `content` text CHARACTER SET utf8,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `status` enum('draft','published','waiting') CHARACTER SET utf8 NOT NULL DEFAULT 'draft',
  `published_date` int(10) NOT NULL DEFAULT '0',
  `seo_title` varchar(256) CHARACTER SET utf8 DEFAULT NULL,
  `seo_keyword` varchar(512) CHARACTER SET utf8 DEFAULT NULL,
  `seo_description` varchar(512) CHARACTER SET utf8 DEFAULT NULL,
  `show_in_menu` tinyint(1) NOT NULL DEFAULT '1',
  `updated_date` int(10) NOT NULL DEFAULT '0',
  `sorting` int(11) NOT NULL DEFAULT '0',
  `created_date` int(10) NOT NULL DEFAULT '0',
  `created_by` varchar(32) CHARACTER SET utf8 NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=44 ;

--
-- Dumping data for table `tbl_content`
--

INSERT INTO `tbl_content` (`id`, `name`, `slug`, `image_id`, `content_type`, `using_page_builder`, `summary`, `content`, `parent_id`, `status`, `published_date`, `seo_title`, `seo_keyword`, `seo_description`, `show_in_menu`, `updated_date`, `sorting`, `created_date`, `created_by`, `deleted`) VALUES
(2, 'Giới thiệu', 'gioi-thieu', NULL, 'page', 0, '', '<p>The following Documentation will help you better understand theme settings and configuration options. Please note: this documentation is related to the theme itself. If you need more information on working with Shopify please refer to <a href="http://docs.shopify.com/">Shopify official documentation</a>.</p>\r\n\r\n<h2>Theme Features</h2>\r\n\r\n<ol>\r\n	<li><strong>Responsive design</strong> - theme works fine on all resolutions starting from 320px.</li>\r\n	<li><strong>Bootstrap framework</strong> - theme layout and styles are based on popular CSS framework Bootstrap.</li>\r\n	<li><strong>Theme settings</strong> - theme is provided with various options that allow you to tune theme according to your needs.</li>\r\n	<li><strong>Extended color options</strong> - multiple color options selectors included so you can change theme colors the way you want.</li>\r\n	<li><strong>Dropdown menu</strong> - allows to display extra content in main navigation.</li>\r\n	<li><strong>MailChimp newsletter</strong> - theme has an integrated <a href="http://mailchimp.com/">MailChimp</a> newsletter system</li>\r\n	<li><strong>Customers account</strong> - theme allows customer registration and accounts.</li>\r\n	<li><strong>Product image zoom</strong> - view full product image in pop-up.</li>\r\n	<li><strong>Contact form</strong> - theme contains fully functional contacts page with Google map and contact form.</li>\r\n	<li><strong>Currency switcher</strong> - with single click allows to display product prices in desired currency.</li>\r\n	<li><strong>Customizable slider</strong> - with theme settings you can edit home page slider content.</li>\r\n	<li><strong>Payment methods widget</strong> - allows to display logos of the payment methods available for your store.</li>\r\n</ol>\r\n\r\n<h2>Theme settings</h2>\r\n\r\n<h3>General</h3>\r\n\r\n<p>Here you can select if you want to upload and use your logo image or display store name instead. Also you can define if you want to use custom logo for checkout pages. Last checkbox allows you to disable &quot;Designed by&quot; copyright notification from the store footer.</p>\r\n\r\n<ul>\r\n	<li><strong>Use custom logo</strong> - allows you display image logo instead of store name.</li>\r\n	<li><strong>Custom logo</strong> - allows to upload custom logo image.</li>\r\n	<li><strong>Use custom logo for checkout page</strong> - display custom logo image at the checkout page.</li>\r\n	<li><strong>Display copyright</strong> - displays copyright notification in store footer if checked.</li>\r\n</ul>\r\n\r\n<p><img src="http://cdn.shopify.com/s/files/1/0286/8480/files/1-logo.jpg?2259" /></p>\r\n\r\n<h3>Typography</h3>\r\n\r\n<p>Allows to select font options for base font and heading tags. You can define font size, line height and font family. You can also add Google Font.</p>\r\n\r\n<ul>\r\n	<li><strong>Base Font</strong> - font settings (font size, line height, font family) for the base body font. Base font is used for text paragraphs, lists, definition lists etc.</li>\r\n	<li><strong>Links</strong> - here you can define link colors</li>\r\n	<li><strong>Page heading</strong> - here you can define font styling for page headings. You can also define if you want to use custom Google Font font for website headings.</li>\r\n	<li><strong>Product name</strong> - allows to define font size and color for product names.</li>\r\n</ul>\r\n\r\n<p><img src="http://cdn.shopify.com/s/files/1/0286/8480/files/2-typohraphy.jpg?2260" /></p>\r\n\r\n<h3>Layout settings</h3>\r\n\r\n<ul>\r\n	<li><strong>Main Navigation</strong> - select navigation to be used as theme main navigation.</li>\r\n	<li><strong>Left/right sidebars</strong> - options allow to enable/disable sidebars.</li>\r\n	<li><strong>Best Sellers</strong> - here you can select collection for Bestsellers block.</li>\r\n	<li><strong>Homepage products listing</strong> - allows to define Collection that will be displayed at the home page, number of products, number of columns, product images size.</li>\r\n	<li><strong>Collection products listing</strong> - allows to configure collection listing page. Set number of products, number of columns, product images size.</li>\r\n	<li><strong>Breadcrumbs</strong> - displays breadcrumbs if enabled.</li>\r\n</ul>\r\n\r\n<p><img src="http://cdn.shopify.com/s/files/1/0286/8480/files/3-layout.jpg?2261" /></p>\r\n\r\n<h3>Style - Colors</h3>\r\n\r\n<p>Color options allow you to define colors for various aspects of the theme. Every theme color can be changed here.</p>\r\n\r\n<p><img src="http://cdn.shopify.com/s/files/1/0286/8480/files/4-colors.jpg?2262" /></p>\r\n\r\n<h3>Money Options</h3>\r\n\r\n<p>Our themes are provided with currency switcher implemented.</p>\r\n\r\n<ul>\r\n	<li><strong>Show currency selector</strong> - displays currency selector in store header if checked.</li>\r\n	<li><strong>Money format</strong> - allows to select prices display format for the store.</li>\r\n	<li><strong>Currencies</strong> - type currency codes divided by &#39;space&#39; that you want to be available in your store.</li>\r\n	<li><strong>Default currency</strong> - select default store currency.</li>\r\n</ul>\r\n\r\n<p><img src="//cdn.shopify.com/s/files/1/0315/6917/files/5-money.jpg?1645" /></p>\r\n\r\n<h3>Slider settings</h3>\r\n\r\n<p>Here you can configure home page slider.</p>\r\n\r\n<ul>\r\n	<li><strong>Enable slider script</strong> - if checked slider script will be initiated and slider will work. Otherwise all slides will be displayed as separate images. Useful to disable slider when you have a single slide.</li>\r\n	<li><strong>Enable slide</strong> - allows to enable/disable slides.</li>\r\n	<li><strong>Image</strong> - allows to upload slide image.</li>\r\n	<!-- <li><b>Caption</b> - slider captions consists of several lines and you can edit text for each of them. </li>\r\n                            <li><b>Caption button link</b> - allow to define slider ''read more'' button link. </li> -->\r\n</ul>\r\n\r\n<p><img src="http://cdn.shopify.com/s/files/1/0286/8480/files/6-slider.jpg?2263" /></p>\r\n\r\n<h3>Custom blocks</h3>\r\n\r\n<p>This section contain configuration settings for every custom block. You can define text, images, links for every banner.</p>\r\n\r\n<p><img src="http://cdn.shopify.com/s/files/1/0286/8480/files/7-custom-blocks.jpg?2264" /></p>\r\n\r\n<h3>Mailing List</h3>\r\n\r\n<p>Here you can define MailChimp newsletter system for your store.</p>\r\n\r\n<p><img src="//cdn.shopify.com/s/files/1/0315/6917/files/8-mailing-list.jpg?1648" /></p>\r\n\r\n<h3>Payment methods</h3>\r\n\r\n<p>Allows you to select what payment logos will be available at the checkout page.</p>\r\n\r\n<p style="text-align:left"><img src="//cdn.shopify.com/s/files/1/0315/6917/files/9-payment.jpg?1649" /><a href="mailto:shopify@template-help.com"> </a></p>\r\n', 0, 'published', 1435121532, '', '', '', 1, 1435739001, 0, 1435121512, 'admin', 0),
(3, 'Bảng giá', 'bang-gia', NULL, 'page', 0, '', '', 0, 'published', 1435131579, '', '', '', 1, 1435739074, 0, 1435131539, 'admin', 0),
(6, 'Hướng dẫn mua hàng', 'huong-dan-mua-hang', NULL, 'page', 0, 'sdfdsf sdf sdf', '<ul>\r\n	<li>Qu&yacute; kh&aacute;ch tại tp HCM th&igrave; vui l&ograve;ng đến địa chỉ: &nbsp;vi t&iacute;nh Duy T&acirc;n , <strong>10/26 Ho&agrave;ng Hoa Th&aacute;m, f7, B&igrave;nh Thạnh, tp HCM</strong> để giao dịch trực tiếp.</li>\r\n</ul>\r\n\r\n<div>\r\n<p>Trước khi đến qu&yacute; kh&aacute;ch vui l&ograve;ng gọi số &nbsp;điện thoại&nbsp;<strong>(08) 62788887</strong>&nbsp;hoặc<strong>0938 176 671</strong>&nbsp;&nbsp; để biết chi tiết v&agrave; t&igrave;nh trạng m&oacute;n h&agrave;ng qu&yacute; kh&aacute;ch cần mua</p>\r\n\r\n<p><strong>Qu&yacute; kh&aacute;ch ở tỉnh th&igrave; c&aacute;ch thức mua h&agrave;ng như sau:</strong></p>\r\n\r\n<ol>\r\n	<li>Qu&yacute; kh&aacute;ch vui l&ograve;ng gọi đi&ecirc;n thoại đặt h&agrave;ng qua số điện thoại ở tr&ecirc;n hoặc đặt h&agrave;ng qua nick yahoo: <strong>duytan_computer350</strong>; <strong>vitinh_giatot</strong></li>\r\n	<li>Sau đ&oacute; qu&yacute; kh&aacute;ch chuyển tiền v&agrave;o 1 trong c&aacute;c số t&agrave;i khoản ng&acirc;n h&agrave;ng sau đ&acirc;y:&nbsp;</li>\r\n</ol>\r\n\r\n<table class="table table-striped">\r\n	<tbody>\r\n		<tr>\r\n			<td style="vertical-align:middle"><strong>T&Ecirc;N NG&Acirc;N H&Agrave;NG&nbsp;</strong></td>\r\n			<td style="vertical-align:middle"><strong>SỐ TK</strong></td>\r\n			<td style="vertical-align:middle"><strong>CHỦ TK</strong></td>\r\n			<td style="vertical-align:middle"><strong>CHI NH&Aacute;NH</strong></td>\r\n		</tr>\r\n		<tr>\r\n			<td style="vertical-align:middle"><strong>NG&Acirc;N H&Agrave;NG Đ&Ocirc;NG &Aacute;</strong></td>\r\n			<td style="vertical-align:middle"><strong>0102158814</strong></td>\r\n			<td style="vertical-align:middle"><strong>NGUYỄN DUY T&Acirc;N</strong></td>\r\n			<td style="vertical-align:middle"><strong>TP HCM</strong></td>\r\n		</tr>\r\n		<tr>\r\n			<td style="vertical-align:middle"><strong>NG&Acirc;N H&Agrave;NG AGRIBANK</strong></td>\r\n			<td style="vertical-align:middle"><strong>6380205140611</strong></td>\r\n			<td style="vertical-align:middle"><strong>NGUYỄN DUY T&Acirc;N</strong></td>\r\n			<td style="vertical-align:middle"><strong>B&Igrave;NH THẠNH, TP HCM</strong></td>\r\n		</tr>\r\n		<tr>\r\n			<td style="vertical-align:middle">&nbsp;<strong>NG&Acirc;N H&Agrave;NG VIETCOMBANK</strong></td>\r\n			<td style="vertical-align:middle"><strong>0071000783732&nbsp;</strong></td>\r\n			<td style="vertical-align:middle"><strong>&nbsp;NGUYỄN QUỐC VIỆT</strong></td>\r\n			<td style="vertical-align:middle"><strong>&nbsp;B&Igrave;NH THẠNH, HCM</strong></td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>- &nbsp;Khi nhận được tiền ch&uacute;ng t&ocirc;i sẽ li&ecirc;n hệ x&aacute;c nhận v&agrave; sẽ chuyển h&agrave;ng cho qu&yacute; kh&aacute;ch trong thời gian nhanh nhất &nbsp;</p>\r\n</div>\r\n', 0, 'published', 1435739869, '', '', '', 1, 1445573167, 0, 1435739583, 'admin', 0),
(9, 'Hướng dẫn chọn mua máy tính để bàn cũ và địa chỉ uy tín', 'huong-dan-chon-mua-may-tinh-de-ban-cu-va-dia-chi-uy-tin', 624, 'news', 0, 'Chắc chắn nhưng ai gõ google để tìm đến bài viết này cũng đều trả lời được câu hỏi mình đặt ra này. Lý do chủ yếu là chọn một bộ máy tiếc kiệm chi phí nhưng vẫn phù hợp với như cầu sử dụng.', '<div>&nbsp;</div>\r\n\r\n<div>\r\n<p>Tại sao n&ecirc;n chọn mua m&aacute;y t&iacute;nh để b&agrave;n cũ ?</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Chắc chắn nhưng ai g&otilde; google để t&igrave;m đến b&agrave;i viết n&agrave;y cũng đều trả lời được c&acirc;u hỏi m&igrave;nh đặt ra n&agrave;y. L&yacute; do chủ yếu l&agrave; chọn một bộ m&aacute;y tiếc kiệm chi ph&iacute; nhưng vẫn ph&ugrave; hợp với như cầu sử dụng. Thật vậy, việc chọn một bộ&nbsp;<strong>m&aacute;y t&iacute;nh để b&agrave;n cũ</strong>&nbsp;thực sự tiếc kiệm chi ph&iacute;., v&igrave; c&ugrave;ng một cấu h&igrave;nh mong muốn, gi&aacute; cả một bộ m&aacute;y b&agrave;n cũ c&oacute; thể chỉ bằng 2/3 so với&nbsp;<strong>m&aacute;y&nbsp; t&iacute;nh để b&agrave;n&nbsp;</strong>mới.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p style="text-align:center">&nbsp;</p>\r\n\r\n<table border="1" cellpadding="1" cellspacing="1" style="line-height:20.7999992370605px; width:600px">\r\n	<tbody>\r\n		<tr>\r\n			<td style="text-align:center"><a href="http://vitinhgiatot.com/san-pham/261/may-bo-dell.html">M&aacute;y&nbsp;t&iacute;nh để b&agrave;n Dell</a></td>\r\n			<td style="text-align:center"><a href="http://vitinhgiatot.com/san-pham/262/may-bo-hp.html">M&aacute;y&nbsp;t&iacute;nh để b&agrave;n Hp</a></td>\r\n			<td style="text-align:center"><a href="http://vitinhgiatot.com/san-pham/264/may-tinh-cu-gia-re-lap-rap.html">M&aacute;y&nbsp;t&iacute;nh để b&agrave;n lắp r&aacute;p</a></td>\r\n		</tr>\r\n		<tr>\r\n			<td style="text-align:center">\r\n			<p><img alt="may-bo-dell" src="/upload/images/980sff2.jpg" style="height:150px; width:150px" /></p>\r\n\r\n			<p><strong>M&aacute;y t&iacute;nh để b&agrave;n dell từ core 2 đến core i3, i5, i7</strong></p>\r\n			</td>\r\n			<td style="text-align:center">\r\n			<p><img alt="" src="http://vitinhgiatot.com/images/product/811_3000PRO%20QUAD.jpg" style="height:100px; width:150px" /></p>\r\n\r\n			<p>&nbsp;</p>\r\n\r\n			<p>&nbsp;</p>\r\n\r\n			<p><strong>M&aacute;y t&iacute;nh để b&agrave;n hp từ core 2 đến core i3,i5,i7</strong></p>\r\n			</td>\r\n			<td style="text-align:center">\r\n			<p><img alt="may--tinh-cu-gia-re" src="/upload/images/6509.gif" style="height:150px; width:150px" /></p>\r\n\r\n			<p><strong>M&aacute;y t&iacute;nh để b&agrave;n</strong>&nbsp;lắp r&aacute;p theo y&ecirc;u cầu của kh&aacute;ch h&agrave;ng với c&aacute;c cấu h&igrave;nh th&ocirc;ng dụng</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p style="text-align:center">&nbsp;</p>\r\n\r\n<p style="text-align:center">&nbsp;</p>\r\n\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Nếu biết chọn mua, kiểm tra m&aacute;y th&igrave; th&igrave; bạn c&oacute; thể chọn được cho m&igrave;nh một&nbsp;<strong>bộ m&aacute;y t&iacute;nh để b&agrave;n</strong>&nbsp;bền bỉ, thời gian sử dụng c&oacute; thể l&ecirc;n đến v&agrave;i năm m&agrave; ko hư hỏng g&igrave;. Tỉ lệ hư hỏng đối với m&aacute;y&nbsp;<strong>t&iacute;nh để b&agrave;n cũ</strong>&nbsp;sau một thời gian ngắn sử dụng cao hơn so với m&aacute;y t&iacute;nh mới. Biết kiểm tra m&aacute;y trước khi mua l&agrave; bạn đ&atilde; l&agrave;m giảm tỉ lẹ n&agrave;y xuống gần ngang bằng với mua một&nbsp;<strong>bộ m&aacute;y t&iacute;nh để b&agrave;n mới</strong>. M&igrave;nh sẽ n&ecirc;u một v&agrave;i kinh nghiệm nhỏ của m&igrave;nh để gi&uacute;p bạn t&igrave;m được một bộ m&aacute;y như &yacute;.</p>\r\n\r\n<h2>Chọn mua một bộ m&aacute;y t&iacute;nh để b&agrave;n cũ như thế n&agrave;o ?</h2>\r\n\r\n<p style="text-align:center">&nbsp;<img alt="" src="/upload/images/1722440-dell-optiplex-755-sff.jpg" style="height:450px; width:600px" /></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Đầu ti&ecirc;n th&igrave; n&ecirc;n xem x&eacute;t qua một v&agrave;i bộ&nbsp;<strong>m&aacute;y t&iacute;nh để b&agrave;n cũ</strong>&nbsp;đ&aacute;ng mua c&aacute;i đ&atilde; n&agrave;o. Về gi&aacute; cả thị trường thị m&igrave;nh sẽ n&oacute;i ở phần sau. C&oacute; 2 lựa chọn lớn d&agrave;nh cho bạn. Một l&agrave; c&aacute;c d&ograve;ng m&aacute;y t&iacute;nh nguy&ecirc;n bộ của c&aacute;c h&atilde;ng Dell, HP, IBM. Hai l&agrave; c&aacute;c m&aacute;y t&iacute;nh lắp r&aacute;p.C&ugrave;ng một cấu h&igrave;nh th&igrave; gi&aacute; cả giữa c&aacute; d&ograve;ng m&aacute;y bộ v&agrave;&nbsp;<strong>m&aacute;y t&iacute;nh để b&agrave;n</strong>&nbsp;lắp r&aacute;p cũng kh&ocirc;ng ch&ecirc;nh lệch bao nhi&ecirc;u. Nhưng theo &yacute; kiến của một số cửa h&agrave;ng m&igrave;nh biết th&igrave; c&aacute;c d&ograve;ng m&aacute;y bộ được xem l&agrave; n&ecirc;n mua hơn v&igrave; n&oacute; ổn định hơn v&agrave; &iacute;t hư hỏng vặt.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Việc đầu ti&ecirc;n khi đ&atilde; chọn được cửa h&agrave;ng tin tưởng. Ta c&ugrave;ng test m&aacute;y n&agrave;o: Tổng quan ch&uacute;t nhen. Phải xem thử c&oacute; đ&uacute;ng cấu h&igrave;nh m&aacute;y đ&atilde; chọn kh&ocirc;ng đ&atilde;. Chắc c&aacute;c bạn đi mua m&aacute;y th&igrave; cũng biết ch&uacute;t ch&uacute;t về m&aacute;y t&iacute;nh rồi nền m&igrave;nh ko n&oacute;i nhiều ở đ&acirc;y nhen. Bạn cũng c&oacute; thể hỏi kĩ&nbsp; thuật vi&ecirc;n ở cửa h&agrave;ng gi&uacute;p bạn kiểm tra thử xem.. chẳng ai từ chối đ&acirc;u . Nếu muốn th&igrave; cứ y&ecirc;u cầu mở th&ugrave;ng m&aacute;y cho bạn xem &quot;nội thất&quot; b&ecirc;n trong ch&uacute;t x&iacute;u. Th&ecirc;m một việc nữa l&agrave; xem m&aacute;y c&oacute; nhận đủ hết driver hay chưa Click chuột phải v&agrave;o My Computer &gt; Manage &gt; Device Manager.</p>\r\n\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Rồi.. đ&uacute;ng m&aacute;y cần mua rồi, cắm c&aacute;p mạng, cắm loa. V&agrave;o thử mp3.zing.vn nghe thử một b&agrave;i h&aacute;t n&agrave;o.. Ok lu&ocirc;n phải kh&ocirc;ng bạn..dzậy l&agrave; tạm được rồi. thử lu&ocirc;n cổng usb với ở đĩa xem c&oacute; đọc kh&ocirc;ng nhen. Ri&ecirc;ng đối với ổ đĩa DVD hay CD th&igrave; l&uacute;c chạy đĩa bạn để &yacute; xem c&oacute; đọc bị chậm hay cơ bị k&ecirc;u kh&ocirc;ng, nữa l&agrave; cứ mở khay đĩa với đ&oacute;ng lại xem c&oacute; bị kẹt kh&ocirc;ng nha..</p>\r\n\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- C&aacute;c bước tr&ecirc;n OK th&igrave; sang bước tiếp theo n&egrave;. Kiểm tra ram một c&aacute;ch tổng quan nhất nhen. Mở Task Manager l&ecirc;n&nbsp; (Ctrl+ Alt+Delete) sau đ&oacute; mở tr&igrave;nh duyệt bất k&igrave;, mở c&agrave;ng nhiều Tab c&agrave;ng tốt.. khi thấy ram đầy m&agrave; m&aacute;y kh&ocirc;ng bị m&agrave;n h&igrave;nh xanh l&agrave; đc rồi.</p>\r\n\r\n<p style="text-align:center"><img alt="" src="/upload/images/980sff2.jpg" style="height:550px; width:550px" /></p>\r\n\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Trong l&uacute;c x&agrave;i bạn để &yacute;&nbsp; thử xem ổ cứng như thế n&agrave;o kh&ocirc;ng nhen..&nbsp;<strong>Ổ cứng m&aacute;y t&iacute;nh để b&agrave;n</strong>&nbsp;b&igrave;nh thường nếu c&ograve;n tốt th&igrave; chạy rất &ecirc;m.</p>\r\n\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Như vậy l&agrave; c&aacute;c bước kiểm tra đ&atilde; xong 90% rồi. Nếu bạn l&agrave; người kĩ t&iacute;nh th&igrave; c&oacute; thể kiểm tra ram v&agrave; ổ cứng ngay tại chổ bằng hirent&#39;s boot. Tuy nhi&ecirc;n l&agrave; c&aacute;ch n&agrave;y kh&aacute; l&acirc;u c&oacute; thể k&eacute;o d&agrave;i cả tiếng. M&aacute;y t&iacute;nh để b&agrave;n cũ được bảo h&agrave;nh v&agrave;i th&aacute;ng n&ecirc;n bạn c&oacute; thể test xem thử bất cứ l&uacute;c n&agrave;o. C&ograve;n lại chỉ cần thử xem m&aacute;y c&oacute; chạy trơn tru một số chương tr&igrave;nh phục vụ c&ocirc;ng việc của bạn hay kh&ocirc;ng l&agrave; OK rồi. Hirent&#39;s boot th&igrave; m&igrave;nh nghĩ chắc cửa h&agrave;ng n&agrave;o cũng c&oacute;. C&ograve;n nếu muốn cho chắc ăn th&igrave; bạn cứ mang theo :D. Ch&eacute;p th&ecirc;m cả source AutoCad hay PhotoShop để chạy thử nếu như bạn l&agrave; d&acirc;n đồ họa&nbsp; (c&aacute;i n&agrave;y bạn c&oacute; thể y&ecirc;u cầu cửa h&agrave;ng c&agrave;i gi&uacute;p nha)</p>\r\n\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - Việc kiểm tra ổ cứng v&agrave; ram bằng phần m&ecirc;m trong Hirent&#39;s boot m&igrave;nh để b&agrave;i sau nha.</p>\r\n\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Tiếp theo l&agrave; đến việc chọn&nbsp;<strong>m&agrave;n h&igrave;nh m&aacute;y t&iacute;nh</strong>. C&aacute;c bạn xem hướng dẫn&nbsp;<strong>chọn m&agrave;n h&igrave;nh m&aacute;y t&iacute;nh cũ</strong>&nbsp;tại đ&acirc;y nhen : chọn mua&nbsp;<a href="http://vitinhgiatot.com/tin-tuc-xem/10/man-hinh-may-tinh-cu-gia-re-va-huong-dan-test-va-chon-mua-man-hinh-may-tinh-cu-gia-re.html">m&agrave;n h&igrave;nh m&aacute;y t&iacute;nh</a>&nbsp;cũ.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h2 style="text-align:center"><img alt="" src="/upload/images/LCD%20DELL%2017%20550.jpg" style="height:550px; width:550px" /></h2>\r\n\r\n<h2>&nbsp;Gi&aacute; cả thị trường của m&aacute;y t&iacute;nh để b&agrave;n cũ&nbsp; !!</h2>\r\n\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Thời điểm hiện tại l&uacute;c m&igrave;nh viết b&agrave;i n&agrave;y l&agrave; th&aacute;ng 3/2014. Gi&aacute; cả c&oacute; thể thay đổi thường xuy&ecirc;n. Nếu như bạn l&agrave; d&acirc;n văn ph&ograve;ng, chỉ x&agrave;i một số chương tr&igrave;nh nghe nhạc, xem phim, bắn picachu, word, excell th&igrave; một bộ m&aacute;y tầm gi&aacute; khoảng 3.500.000 đến 4.500.000 vnđ bao gồm cả m&agrave;n h&igrave;nh m&aacute;y t&iacute;nh l&agrave; c&oacute; thể x&agrave;i tạm được rồi. Với gi&aacute; cả thị trường hiện nay c&ugrave;ng với tốc độc ph&aacute;t triển v&agrave; đổi mứoi của phần cứng qu&aacute; nhanh. T&igrave;m mua được nhưng bộ&nbsp;<strong>m&aacute;y t&iacute;nh&nbsp; để b&agrave;n dell hay m&aacute;y t&iacute;nh để b&agrave;n hp core i3, i5, i7</strong>&nbsp;l&agrave; điều kh&aacute; dễ v&agrave; hợp với t&uacute;i tiền của nhiều người d&ugrave;ng. Tất nhi&ecirc;n đ&acirc;y kh&ocirc;ng phải l&agrave; gi&aacute; thấp nhất một bộ m&aacute;y t&iacute;nh c&oacute; thể c&oacute;. Bạn c&oacute; thể xem tại đ&acirc;y để xem&nbsp;<strong>gi&aacute; m&aacute;y t&iacute;nh để b&agrave;n</strong>&nbsp;thường xuy&ecirc;n :&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h2>&nbsp;</h2>\r\n\r\n<table border="1" cellpadding="1" cellspacing="1" style="line-height:20.7999992370605px; width:600px">\r\n	<tbody>\r\n		<tr>\r\n			<td style="text-align:center"><a href="http://vitinhgiatot.com/san-pham/261/may-bo-dell.html">M&aacute;y&nbsp;t&iacute;nh để b&agrave;n Dell</a></td>\r\n			<td style="text-align:center"><a href="http://vitinhgiatot.com/san-pham/262/may-bo-hp.html">M&aacute;y&nbsp;t&iacute;nh để b&agrave;n Hp</a></td>\r\n			<td style="text-align:center"><a href="http://vitinhgiatot.com/san-pham/264/may-tinh-cu-gia-re-lap-rap.html">M&aacute;y&nbsp;t&iacute;nh để b&agrave;n lắp r&aacute;p</a></td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><img alt="may-bo-dell" src="/upload/images/980sff2.jpg" style="height:150px; width:150px" /></p>\r\n\r\n			<p style="text-align:center"><strong>M&aacute;y t&iacute;nh để b&agrave;n dell từ core 2 đến core i3, i5, i7</strong></p>\r\n			</td>\r\n			<td>\r\n			<p><img alt="" src="http://vitinhgiatot.com/images/product/811_3000PRO%20QUAD.jpg" style="height:100px; width:150px" /></p>\r\n\r\n			<p style="text-align:center">&nbsp;</p>\r\n\r\n			<p style="text-align:center">&nbsp;</p>\r\n\r\n			<p style="text-align:center"><strong>M&aacute;y t&iacute;nh để b&agrave;n hp từ core 2 đến core i3,i5,i7</strong></p>\r\n			</td>\r\n			<td>\r\n			<p><img alt="may--tinh-cu-gia-re" src="/upload/images/6509.gif" style="height:150px; width:150px" /></p>\r\n\r\n			<p style="text-align:center"><strong>M&aacute;y t&iacute;nh để b&agrave;n</strong>&nbsp;lắp r&aacute;p theo y&ecirc;u cầu của kh&aacute;ch h&agrave;ng với c&aacute;c cấu h&igrave;nh th&ocirc;ng dụng</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p style="text-align:center">&nbsp;</p>\r\n\r\n<h2>&nbsp;Mua m&aacute;y t&iacute;nh để b&agrave;n cũ ở đ&acirc;u ?</h2>\r\n\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; C&aacute;i n&agrave;y th&igrave; đơn giản. Việc t&igrave;m một cửa h&agrave;ng vi t&iacute;nh gần nơi bạn ở l&agrave; kh&ocirc;ng kh&oacute;. C&aacute;i kh&oacute; l&agrave; t&igrave;m nơi thật uy t&iacute;n. H&atilde;y li&ecirc;n hệ cửa h&agrave;ng vi t&iacute;nh Duy T&acirc;n bất cứ l&uacute;c n&agrave;o bạn muốn để được tư vấn chọn bộ m&aacute;y t&iacute;nh ph&ugrave; hợp với nhu cầu của bạn.</p>\r\n\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; ** Tất cả m&aacute;y t&iacute;nh để b&agrave;n, linh kiện m&aacute;y t&iacute;nh tại cửa h&agrave;ng vi T&iacute;nh Duy T&acirc;n đều được kiểm tra rất kĩ khi nhập về v&agrave; trước khi b&aacute;n ra cho kh&aacute;ch h&agrave;ng.</p>\r\n\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ** C&ugrave;ng với chế độ bảo h&agrave;nh chu đ&aacute;o, qu&yacute; kh&aacute;ch c&oacute; thẻ ho&agrave;n to&agrave;n an t&acirc;m về chất lượng m&aacute;y t&iacute;nh. Mỗi bộ m&aacute;y t&iacute;nh b&aacute;n ra, vi t&iacute;nh Duy T&acirc;n sẽ hỗ trợ kĩ thuật v&agrave; c&agrave;i đặt hệ điều h&agrave;nh miễn ph&iacute; suốt đời m&aacute;y.&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>\r\n\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Hoặc truy cập webssite vi t&iacute;nh gi&aacute; tốt .com&nbsp;<a href="http://vitinhgiatot.com">vitinhgiatot.com</a>&nbsp;để để xem c&aacute;c cấu h&igrave;nh m&aacute;y t&iacute;nh tham khảo. Qu&yacute; kh&aacute;ch c&oacute; thể thay đổi n&acirc;ng cấp linh kiện bất k&igrave; như Ram, &ocirc; cứng, card m&agrave;n h&igrave;nh,...Vi t&iacute;nh duy t&acirc;n chuy&ecirc;n cung cấp m&aacute;y t&iacute;nh để b&agrave;n cũ gi&aacute; rẻ, bảo h&agrave;nh chu đ&aacute;o nhất tại khu vực tp HCM</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p style="text-align:center">&nbsp;</p>\r\n\r\n<p style="text-align:center">&nbsp;</p>\r\n\r\n<p style="text-align:center">&nbsp;</p>\r\n\r\n<p style="text-align:center">Cửa h&agrave;ng vi t&iacute;nh Duy T&acirc;n. H&acirc;n hạnh được phục vụ qu&yacute; kh&aacute;ch !</p>\r\n\r\n<p style="text-align:center">&nbsp;Add: 10/13 Ho&agrave;ng Hoa Th&aacute;m, F.7, Q. B&igrave;nh Thạnh</p>\r\n\r\n<div style="text-align:center">Hotline: 0938176671 hoặc (08) 62975591</div>\r\n\r\n<div style="text-align:center">FB:&nbsp;<a href="https://www.facebook.com/maytinhdebandongbo?ref=hl">https://www.facebook.com/maytinhdebandongbo</a></div>\r\n</div>\r\n', 0, 'published', 1393573276, '', '', '', 1, 1445580857, 0, 1393573276, 'admin', 0),
(10, 'Hướng dẫn test và chọn mua màn hình máy tính cũ giá rẻ', 'huong-dan-test-va-chon-mua-man-hinh-may-tinh-cu-gia-re', 625, 'news', 0, 'Trong bài viết trước mình có nói về vấn đề này rồi. Giá cả vẫn là lí do chính yếu. Đơn cử như một màn hình máy tính 17inch giá mới tầm 1.700.000 vnd thì màn hình máy tính cũ giá có thể rẻ hơn tới 700.000vnd .', '<p>&nbsp;<strong>Tại sao lại chọn mua m&agrave;n h&igrave;nh m&aacute;y t&iacute;nh cũ ?</strong></p>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Trong b&agrave;i viết trước m&igrave;nh c&oacute; n&oacute;i về vấn đề n&agrave;y rồi. Gi&aacute; cả vẫn l&agrave; l&iacute; do ch&iacute;nh yếu.&nbsp;Đơn cử như một&nbsp;<strong>m&agrave;n h&igrave;nh m&aacute;y t&iacute;nh</strong>&nbsp;17inch gi&aacute; mới tầm 1.700.000 vnd th&igrave; m&agrave;n h&igrave;nh m&aacute;y t&iacute;nh cũ gi&aacute; c&oacute; thể rẻ hơn tới 700.000vnd . Đ&acirc;y l&agrave; một con số kh&ocirc;ng hề nhỏ đối với ng c&oacute; t&uacute;i tiền eo hẹp. Tất nhi&ecirc;n ở đ&acirc;y m&igrave;nh đang n&oacute;i đến m&agrave;n h&igrave;nh lcd chứ kh&ocirc;ng phải CRT ng&agrave;y xưa nh&eacute;.</div>\r\n\r\n<div style="text-align:center">&nbsp;</div>\r\n\r\n<div style="text-align:center">&nbsp;</div>\r\n\r\n<div style="text-align:center">Bảng gi&aacute; tham khảo (7-7-2014) xem bảng gi&aacute; ch&iacute;nh thức tại&nbsp;<a href="http://vitinhgiatot.com/san-pham/233/man-hinh-lcd-cu.html">đ&acirc;y</a></div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div style="text-align:center"><img alt="" src="/upload/images/bang-gia-man-hinh-lcd-cu.jpg" style="height:390px; width:480px" /></div>\r\n\r\n<div><img alt="" src="/upload/images/bang%20gia%20man%20hinh%20lcd%20cu.PNG" style="height:0px; width:0px" /></div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>Bảng gi&aacute; v&agrave;i m&agrave;n h&igrave;nh m&aacute;y t&iacute;nh cũ tại vi t&iacute;nh Duy T&acirc;n tại đ&acirc;y :&nbsp;<a href="http://vitinhgiatot.com/san-pham/233/man-hinh-lcd-cu.html" style="color: rgb(0, 51, 204); margin: 0px; outline: 0px; padding: 0px; text-decoration: none;">m&agrave;n h&igrave;nh m&aacute;y t&iacute;nh</a></div>\r\n\r\n<div><strong>Chọn m&agrave;n h&igrave;nh m&aacute;y t&iacute;nh cũ như thế n&agrave;o?</strong></div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Đầu ti&ecirc;n l&agrave; x&eacute;t về ngoại h&igrave;nh ch&uacute;t đ&atilde;. C&aacute;i n&agrave;y th&igrave; t&ugrave;y từng người. Li&ecirc;n quan đến vấn đề thẩm mĩ th&igrave; m&igrave;nh kh&ocirc;ng x&eacute;t nhiều ở đ&acirc;y. Chắc chắn ai cũng muốn c&oacute; một&nbsp;<strong>m&agrave;n h&igrave;nh m&aacute;y t&iacute;nh</strong>&nbsp;thật đẹp v&agrave; hợp với căn ph&ograve;ng của m&igrave;nh rồi. C&ograve;n nếu kh&ocirc;ng qu&aacute; xem trọng điều n&agrave;y. Ta h&atilde;y đến bước tiếp theo.</div>\r\n\r\n<div style="text-align:center"><img alt="" src="/upload/images/LCD%20hP%2017%205501.jpg" style="height:300px; width:300px" /></div>\r\n\r\n<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Xem thử tem tr&ecirc;n&nbsp;<strong>m&agrave;n h&igrave;nh m&aacute;y t&iacute;nh</strong>&nbsp;c&ograve;n hay kh&ocirc;ng. Trước đ&acirc;y th&igrave; việc n&agrave;y rất c&oacute; &iacute;ch v&igrave; c&oacute; thể biets được&nbsp;<strong>m&agrave;n h&igrave;nh</strong>&nbsp;n&agrave;y đ&atilde; bung ra sửa chữa hay chưa. Nhưng hiện nay đối với c&aacute;c của h&agrave;ng d&aacute;n một con tem&nbsp;<strong>l&ecirc;n m&agrave;n h&igrave;nh m&aacute;y t&iacute;nh</strong>&nbsp;kh&aacute; dễ d&agrave;ng. Thay v&agrave;o đ&oacute;, bạn h&atilde;y coi kĩ viền giữa c&aacute;c khớ nối m&agrave;n h&igrave;nh c&oacute; dấu hiệu &quot;được&quot; nạy ra hay chưa. V&igrave; c&aacute;c&nbsp;<strong>m&agrave;n h&igrave;nh m&aacute;y t&iacute;nh</strong>&nbsp;chưa bao giờ th&aacute;o sửa thường rất kh&iacute;t v&agrave; b&eacute;n n&ecirc;n việc nạy ra sẽ để lại dấu kh&aacute; r&otilde;. Bạn sẽ chẳng muốn mua một m&agrave;n h&igrave;nh m&agrave; kh&ocirc;ng biết trước đ&oacute; n&oacute; bị bệnh g&igrave; v&agrave; sau n&agrave;y c&oacute; lặp lại nữa hay kh&ocirc;ng. Nhưng cũng kh&ocirc;ng hẳn l&agrave; c&aacute;c&nbsp;<strong>m&agrave;n h&igrave;nh m&aacute;y t&iacute;nh</strong>&nbsp;đ&atilde; được sửa chữa n&agrave;y kh&ocirc;ng bền qua thời gian nữa.&nbsp;V&igrave; vậy c&ugrave;ng kiểm tra b&ecirc;n trong n&egrave;.</div>\r\n\r\n<div>Nếu 2 bước tr&ecirc;n kh&ocirc;ng vấn đề g&igrave; rồi. Th&igrave; giờ mở m&aacute;y kiểm tra n&egrave; . M&agrave;n h&igrave;nh m&aacute;y t&iacute;nh cũ thường c&oacute; 3 lỗi ch&iacute;nh c&oacute; thể thấy được đ&oacute; l&agrave; :&nbsp;<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>\r\n\r\n<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +Trầy m&agrave;n h&igrave;nh: c&aacute;i n&agrave;y th&igrave; c&oacute; thể thấy r&otilde; l&uacute;c kiểm tra. Tuy nhi&ecirc;n, những&nbsp;<strong>m&agrave;n h&igrave;nh m&aacute;y t&iacute;nh</strong>&nbsp;như thế n&agrave;y thường được c&aacute;c của h&agrave;ng b&aacute;n rẻ cho kh&aacute;ch kh&ocirc;ng y&ecirc;u cầu cao về việc n&agrave;y.<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +Điểm chết : Bạn đổi m&agrave;u desktop về một m&agrave;u&nbsp; như đen, trắng, đỏ, xanh l&aacute; hay xanh dương.. nếu c&oacute; điểm chết tr&ecirc;n m&agrave;n h&igrave;nh.. những điểm n&agrave;y rất nhỏ nhưng m&agrave;u sắc sẽ kh&aacute;c hẳn với m&agrave;u desktop n&ecirc;n dễ d&agrave;ng nhận ra. Đối&nbsp;<strong>với m&agrave;n h&igrave;nh t&iacute;nh cũ</strong>&nbsp;hay mới. Th&igrave; việc m&agrave;n h&igrave;nh xuất hiện 3 điểm chết trở xuống cũng đc xem l&agrave; m&agrave;n h&igrave;nh tốt. Tuy nhi&ecirc;n c&aacute;i n&agrave;y c&ograve;n t&ugrave;y cảm nhận của người d&ugrave;ng. Chắc chắn ai cũng muốn n&oacute; thật sự ho&agrave;n hảo.<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +Bụi : c&aacute;i n&agrave;y kh&aacute;c điểm chết l&agrave; thường hay xuất hiện c&aacute;c chấm li ti tr&ecirc;n&nbsp;<strong>m&agrave;n h&igrave;nh m&aacute;y t&iacute;nh cũ</strong>&nbsp;do bụi bặm lọt v&agrave;o b&ecirc;n trong.</div>\r\n\r\n<div style="text-align:center">&nbsp;<img alt="" src="/upload/images/dell_e2009wt_2.jpg" style="height:305px; width:300px" /></div>\r\n\r\n<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; C&aacute;c điểm tr&ecirc;n c&oacute; thể thấy r&otilde; n&ecirc;n m&igrave;nh chỉ n&ecirc;u ra những điều cần ch&uacute; &yacute; khi xem x&eacute;t mua&nbsp;<strong>m&agrave;n h&igrave;nh m&aacute;y t&iacute;nh cũ</strong>.</div>\r\n\r\n<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Tiếp theo kiểm tra c&aacute;c menu tr&ecirc;n m&agrave;n h&igrave;nh xem c&ograve;n x&agrave;i được kh&ocirc;ng. &nbsp;C&aacute;c ph&iacute;m n&agrave;y thường hay bị d&iacute;nh, kẹt, hay lờn phải ấn mạnh tay mới được.</div>\r\n\r\n<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Điểm cuối c&ugrave;ng đối với việc chọn mua m&agrave;n h&igrave;nh m&aacute;y t&iacute;nh cũ l&agrave; bạn chỉnh độ s&aacute;ng của m&agrave;n h&igrave;nh nằm từ khoảng 75-85 %. nếu m&agrave;n h&igrave;nh c&oacute; độ s&aacute;ng vừa mắt l&agrave; c&ograve;n kh&aacute; tốt. ko bị xuống đ&egrave;n v&agrave; n&ecirc;n chọn những m&agrave;n h&igrave;nh c&oacute; m&agrave;u sắc trung thực rất cần thiết với c&aacute;c bạn thường xuy&ecirc;n l&agrave;m đồ họa.</div>\r\n\r\n<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; B&ecirc;n tr&ecirc;n l&agrave; một số kinh nghiệm nhỏ khi&nbsp;<strong>mua m&agrave;n h&igrave;nh m&aacute;y t&iacute;nh</strong>&nbsp;cũ m&agrave; cửa h&agrave;ng vi t&iacute;nh Duy T&acirc;n cũng &aacute;p dụng đối với việc test v&agrave; nhập m&agrave;n h&igrave;nh cũ. Mong g&oacute;p phần nhỏ gi&uacute;p c&aacute;c bạn chọn&nbsp;<strong>được m&agrave;n h&igrave;nh m&aacute;y t&iacute;nh cũ</strong>&nbsp;vừa &yacute;.</div>\r\n\r\n<div><strong>M&agrave;n h&igrave;nh m&aacute;y t&iacute;nh cũ với gi&aacute; n&agrave;o được xem l&agrave; vừa v&agrave; rẻ ?</strong></div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Thời điểm viết b&agrave;i n&agrave;y l&agrave; th&aacute;ng 2/2014.&nbsp;<strong>C&aacute;c m&agrave;n h&igrave;nh m&aacute;y t&iacute;nh cũ 17inch</strong>&nbsp;c&oacute; gi&aacute; tầm 1.000.000 đến 1.200.00 vnđ.&nbsp;&nbsp;<strong>M&agrave;n h&igrave;nh m&aacute;y t&iacute;nh 19 inch</strong>&nbsp;c&oacute; gi&aacute; tầm 1.300.000 đến 1.500.000 vnđ. Hay bạn c&oacute; thể tham khảo gi&aacute; tại bảng gi&aacute; linh kiện m&aacute;y t&iacute;nh cũ tại đ&acirc;y hoặc h&igrave;nh ảnh&nbsp;<strong>m&agrave;n h&igrave;nh m&aacute;y t&iacute;nh cũ</strong>&nbsp;c&oacute; tại vi t&iacute;nh Duy T&acirc;n tại :&nbsp;<a href="http://vitinhgiatot.com/san-pham/233/man-hinh-lcd-cu.html" style="color: rgb(0, 51, 204); margin: 0px; outline: 0px; padding: 0px; text-decoration: none;">m&agrave;n h&igrave;nh lcd cũ</a></div>\r\n\r\n<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Hiện nay c&oacute; rất nhiều cửa h&agrave;ng b&aacute;n m&agrave;n h&igrave;nh với gi&aacute; kh&aacute; rẻ so với &nbsp;thị trường, bảo h&agrave;nh l&ecirc;n đến 6 hoặc 12 th&aacute;ng. Tuy nhi&ecirc;n rất dễ mua&nbsp; phải h&agrave;ng đ&atilde; sửa chữa nhiều lần v&agrave; được b&aacute;n rẻ lại. Việc người mua chọn một m&oacute;n h&agrave;ng bảo h&agrave;nh l&acirc;u cũng l&agrave; điều dễ hiểu. Nhưng nếu cứ kh&ocirc;ng may, c&oacute; thể h&agrave;ng th&aacute;ng bạn phải mang đi bảo h&agrave;nh trong suốt 12 th&aacute;ng.</div>\r\n\r\n<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tất cả&nbsp;<strong>m&aacute;y t&iacute;nh để b&agrave;n</strong>,&nbsp;<strong>linh kiện m&aacute;y t&iacute;nh</strong>&nbsp;tại cửa h&agrave;ng&nbsp;<strong>vi T&iacute;nh Duy T&acirc;n</strong>&nbsp;đều được kiểm tra rất kĩ khi nhập về v&agrave; trước khi b&aacute;n ra cho kh&aacute;ch h&agrave;ng.&nbsp;C&ugrave;ng với chế độ bảo h&agrave;nh chu đ&aacute;o, qu&yacute; kh&aacute;ch c&oacute; thể ho&agrave;n to&agrave;n an t&acirc;m về chất lượng, gi&aacute; cả.&nbsp;H&atilde;y li&ecirc;n hệ tới Duy T&acirc;n để tham khảo &yacute; kiến bất cứ l&uacute;c n&agrave;o bạn cần.&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</div>\r\n\r\n<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>Cửa h&agrave;ng vi t&iacute;nh Duy T&acirc;n.</div>\r\n\r\n<div>H&acirc;n hạnh được phục vụ qu&yacute; kh&aacute;ch ! Ch&uacute;c qu&yacute; kh&aacute;ch một ng&agrave;y l&agrave;m việc vui vẻ !!</div>\r\n\r\n<div>&nbsp;Add:&nbsp;10/13 Ho&agrave;ng Hoa Th&aacute;m, F.7, Q. B&igrave;nh Thạnh</div>\r\n\r\n<div>Hotline:&nbsp;0938 176 671&nbsp;hoặc&nbsp;(08) 62975591</div>\r\n\r\n<div>FB:&nbsp;<a href="https://www.facebook.com/maytinhdebandongbo?ref=hl">https://www.facebook.com/maytinhdebandongbo</a></div>\r\n', 0, 'published', 1400035700, '', '', '', 1, 1445580809, 0, 1400035700, 'admin', 0),
(12, 'Tặng màn hình Lcd khi mua máy tính để bàn', 'tang-man-hinh-lcd-khi-mua-may-tinh-de-ban', 623, 'news', 0, 'Nhân dịp khai trương địa chỉ mới, khách hàng mua máy tính để bàn tại vi tính Duy Tân sẽ được tặng ngay 1 màn hình lcd 15 inch...', '<p style="text-align:center">&nbsp;Mua m&aacute;y t&iacute;nh để b&agrave;n- Tặng m&agrave;n h&igrave;nh&nbsp;lcd</p>\r\n\r\n<p>&nbsp;10/26 Ho&agrave;ng Hoa Th&aacute;m, B&igrave;nh Thạnh, Tp. HCM.&nbsp;Vi t&iacute;nh Duy T&acirc;n gửi đến qu&yacute; kh&aacute;ch h&agrave;ng 2 chương t&igrave;nh khuyến m&atilde;i sau:</p>\r\n\r\n<p style="margin-left:40px; text-align:center">&nbsp;</p>\r\n\r\n<p style="margin-left:40px; text-align:center">&nbsp;</p>\r\n\r\n<p style="margin-left:40px; text-align:center">&nbsp;</p>\r\n\r\n<p style="margin-left:40px; text-align:center">***Tặng m&agrave;n h&igrave;nh lcd ***</p>\r\n\r\n<p style="margin-left:40px; text-align:center">&nbsp;</p>\r\n\r\n<p style="margin-left:40px; text-align:center">&nbsp;</p>\r\n\r\n<p style="margin-left:40px">Theo đ&oacute;, nay cho đến 30/6/2015 khi qu&yacute; kh&aacute;ch h&agrave;ng mua m&aacute;y t&iacute;nh để b&agrave;n tại vi t&iacute;nh Duy T&acirc;n sẽ được tặng 1 m&agrave;n h&igrave;nh lcd 17 inch (c&oacute; sẵn tại cửa h&agrave;ng ). Chương tr&igrave;nh &aacute;p dụng cho kh&aacute;ch h&agrave;ng mua m&aacute;y t&iacute;nh model Dell Optiplex 740 SFF 2 cấu h&igrave;nh dưới đ&acirc;y:</p>\r\n\r\n<p style="margin-left:40px">&nbsp;</p>\r\n\r\n<p style="margin-left:40px; text-align:center">1. Dell Optiplex 740 CH2:<br />\r\nAMD 4050<br />\r\nRam 1Gb<br />\r\nHDD 80GB</p>\r\n\r\n<p style="margin-left:40px; text-align:center"><a href="http://vitinhgiatot.com/san-pham-xem/832/may-bo-dell-optiplex-740-sff-ch2-case-mini.html">Chi tiết tại đ&acirc;y</a></p>\r\n\r\n<p style="margin-left:40px; text-align:center">&nbsp;</p>\r\n\r\n<p style="margin-left:40px; text-align:center">2. Dell OPtiplex 740 CH3:<br />\r\nAMD 4050&nbsp;<br />\r\nRam 2Gb<br />\r\nHDD 160GB</p>\r\n\r\n<p style="margin-left:40px; text-align:center"><a href="http://vitinhgiatot.com/san-pham-xem/833/may-bo-dell-optiplex-740sff-ch3-case-mini.html">Chi tiết tại đ&acirc;y</a></p>\r\n\r\n<p style="margin-left:40px; text-align:center"><img alt="" src="/upload/images/740.jpg" style="height:225px; width:225px" /><img alt="" src="/upload/images/lcd.jpg" style="height:185px; width:180px" /></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p style="text-align:center">To&agrave;n bộ được bảo h&agrave;nh 3 th&aacute;ng tại vi t&iacute;nh Duy T&acirc;n</p>\r\n\r\n<p style="text-align:center">&nbsp;</p>\r\n\r\n<p style="text-align:center">&nbsp;</p>\r\n\r\n<p style="text-align:center">&nbsp;</p>\r\n\r\n<p style="text-align:center">&nbsp;</p>\r\n\r\n<p style="text-align:center">&nbsp;</p>\r\n\r\n<p>&nbsp;***Điều kiện tham gia:</p>\r\n\r\n<p>-Tất cả kh&aacute;ch h&agrave;ng mua h&agrave;ng tại vi t&iacute;nh Duy T&acirc;n.</p>\r\n\r\n<p>-Chỉ &aacute;p dụng cho c&aacute;c model n&ecirc;u tr&ecirc;n.</p>\r\n\r\n<p>-Thời gian khuyến m&atilde;i từ nay cho đến hết 30/6/2015. Hoặc cho đến hết 50 m&aacute;y đầu ti&ecirc;n ( T&ugrave;y điều kiện n&agrave;o đến trước)</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>FB:&nbsp;<a href="https://www.facebook.com/maytinhdebandongbo?ref=hl">https://www.facebook.com/maytinhdebandongbo</a></p>\r\n\r\n<p>&nbsp;</p>\r\n', 0, 'published', 1405583906, '', '', '', 1, 1445580833, 0, 1405583906, 'admin', 0),
(20, '39', 'goi-ngay-duong-day-nong', 331, 'slider', 0, '/uploads/userupload/slide/slider_s39.jpg', '/uploads/userupload/slide/slider_s39.jpg', 0, 'published', 1436930690, NULL, NULL, NULL, 1, 1445501390, 3, 1436930432, 'admin', 0),
(21, '38', 'mien-phi-van-chuyen', 330, 'slider', 0, '/uploads/userupload/slide/slider_s38.jpg', '/uploads/userupload/slide/slider_s38.jpg', 0, 'published', 1436930940, NULL, NULL, NULL, 1, 1445501372, 2, 1436930907, 'admin', 0),
(22, '37', 'giam-gia-len-toi', 337, 'slider', 0, '/uploads/userupload/slide/slider_s37.jpg', '/uploads/userupload/slide/slider_s37.jpg', 0, 'published', 1436930995, NULL, NULL, NULL, 1, 1445501355, 1, 1436930955, 'admin', 0),
(28, 'Banner 73', 'banner-73', NULL, 'banner', 0, '/uploads/userupload/banner/banner_s73.gif', '', 0, 'published', 1437033372, NULL, NULL, NULL, 0, 1445501102, 1, 1437033356, 'admin', 0),
(29, 'Banner 74', 'banner-74', NULL, 'banner', 0, '/uploads/userupload/banner/banner_s74.gif', '', 1, 'published', 1437033472, NULL, NULL, NULL, 0, 1445501111, 2, 1437033450, 'admin', 0),
(31, 'Banner 66', 'banner-75', NULL, 'banner', 0, '/uploads/userupload/banner/le1bb81u-tre1babb-em-3.jpg', 'http://vitinhgiatot.dev/', 2, 'published', 1445309778, NULL, NULL, NULL, 1, 1475387109, 3, 1437040868, 'admin', 0),
(38, '67', '67', NULL, 'banner', 0, '/uploads/userupload/banner/banner_s67.jpg', '', 2, 'published', 1445501231, NULL, NULL, NULL, 0, 1445501238, 5, 1445501221, 'admin', 0),
(39, '68', '68', NULL, 'banner', 0, '/uploads/userupload/banner/banner_s68.jpg', '', 2, 'published', 1445501251, NULL, NULL, NULL, 0, 1445501259, 4, 1445501244, 'admin', 0),
(40, '69', '69', NULL, 'banner', 0, '/uploads/userupload/banner/leu-xong-hoi-sau-sinh-lxh11.jpg', '', 2, 'published', 1445501271, NULL, NULL, NULL, 1, 1475387128, 6, 1445501263, 'admin', 0),
(41, '70', '70', NULL, 'banner', 0, '/uploads/userupload/banner/leu-6-10-nguoi-outwell.jpg', '', 2, 'published', 1445501285, NULL, NULL, NULL, 1, 1475387140, 7, 1445501277, 'admin', 0),
(42, '42', '42', NULL, 'slider', 0, '/uploads/userupload/slide/slider_s42.JPG', '/uploads/userupload/slide/slider_s42.JPG', 0, 'published', 1445501409, NULL, NULL, NULL, 0, 1445501409, 4, 1445501395, 'admin', 0),
(43, 'Cung đường PHƯỢT', 'cung-duong-phuot', NULL, 'page', 0, 'summary of Cung đường PHƯỢT', '', 0, 'published', 1478664026, '', '', '', 1, 1478664026, 0, 1478663980, 'admin', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_content_element`
--

CREATE TABLE IF NOT EXISTS `tbl_content_element` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL DEFAULT '',
  `content_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `element_type` enum('text','image','textarea','row','column') NOT NULL,
  `content` text,
  `sorting` int(11) NOT NULL DEFAULT '0',
  `hide` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_content_file`
--

CREATE TABLE IF NOT EXISTS `tbl_content_file` (
  `content_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`content_id`,`file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_content_file`
--

INSERT INTO `tbl_content_file` (`content_id`, `file_id`, `deleted`) VALUES
(9, 624, 0),
(10, 625, 0),
(12, 623, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_content_tag`
--

CREATE TABLE IF NOT EXISTS `tbl_content_tag` (
  `content_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`content_id`,`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_file`
--

CREATE TABLE IF NOT EXISTS `tbl_file` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `caption` varchar(1024) DEFAULT NULL,
  `media` enum('image','document','audio','video') NOT NULL,
  `show_url` varchar(128) NOT NULL,
  `directory` varchar(128) NOT NULL,
  `dimension` varchar(16) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `file_name` varchar(64) NOT NULL,
  `file_type` varchar(16) NOT NULL,
  `file_size` varchar(16) NOT NULL DEFAULT '0',
  `file_ext` varchar(8) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=642 ;

--
-- Dumping data for table `tbl_file`
--

INSERT INTO `tbl_file` (`id`, `name`, `caption`, `media`, `show_url`, `directory`, `dimension`, `width`, `height`, `file_name`, `file_type`, `file_size`, `file_ext`, `deleted`) VALUES
(355, '909815hp-dc-7800-mtjpg', NULL, 'image', '/uploads/images/909815hp-dc-7800-mtjpg/', '\\images\\909815hp-dc-7800-mtjpg\\', '480x390', 480, 390, '909815hp-dc-7800-mtjpg', 'image/jpeg', '0', 'jpg', 0),
(356, '908815hp-dc-7800-mtjpg', NULL, 'image', '/uploads/images/908815hp-dc-7800-mtjpg/', '\\images\\908815hp-dc-7800-mtjpg\\', '480x390', 480, 390, '908815hp-dc-7800-mtjpg', 'image/jpeg', '0', 'jpg', 0),
(357, '907hp-dc7800jpg', NULL, 'image', '/uploads/images/907hp-dc7800jpg/', '\\images\\907hp-dc7800jpg\\', '480x390', 480, 390, '907hp-dc7800jpg', 'image/jpeg', '0', 'jpg', 0),
(358, '906hp-dc7800jpg', NULL, 'image', '/uploads/images/906hp-dc7800jpg/', '\\images\\906hp-dc7800jpg\\', '480x390', 480, 390, '906hp-dc7800jpg', 'image/jpeg', '0', 'jpg', 0),
(359, '905optiplex-790sffjpg', NULL, 'image', '/uploads/images/905optiplex-790sffjpg/', '\\images\\905optiplex-790sffjpg\\', '480x390', 480, 390, '905optiplex-790sffjpg', 'image/jpeg', '0', 'jpg', 0),
(360, '904optiplex-790sffjpg', NULL, 'image', '/uploads/images/904optiplex-790sffjpg/', '\\images\\904optiplex-790sffjpg\\', '480x390', 480, 390, '904optiplex-790sffjpg', 'image/jpeg', '0', 'jpg', 0),
(361, '9032jpg', NULL, 'image', '/uploads/images/9032jpg/', '\\images\\9032jpg\\', '606x606', 606, 606, '9032jpg', 'image/jpeg', '0', 'jpg', 0),
(362, '903fghfghjpg', NULL, 'image', '/uploads/images/903fghfghjpg/', '\\images\\903fghfghjpg\\', '770x433', 770, 433, '903fghfghjpg', 'image/jpeg', '0', 'jpg', 0),
(363, '903vcxvjpg', NULL, 'image', '/uploads/images/903vcxvjpg/', '\\images\\903vcxvjpg\\', '1123x1058', 1123, 1058, '903vcxvjpg', 'image/jpeg', '0', 'jpg', 0),
(364, '902380sffjpg', NULL, 'image', '/uploads/images/902380sffjpg/', '\\images\\902380sffjpg\\', '480x390', 480, 390, '902380sffjpg', 'image/jpeg', '0', 'jpg', 0),
(365, '902optiplex-780jpg', NULL, 'image', '/uploads/images/902optiplex-780jpg/', '\\images\\902optiplex-780jpg\\', '1200x754', 1200, 754, '902optiplex-780jpg', 'image/jpeg', '0', 'jpg', 0),
(366, '901380sffjpg', NULL, 'image', '/uploads/images/901380sffjpg/', '\\images\\901380sffjpg\\', '480x390', 480, 390, '901380sffjpg', 'image/jpeg', '0', 'jpg', 0),
(367, '90112jpg', NULL, 'image', '/uploads/images/90112jpg/', '\\images\\90112jpg\\', '160x130', 160, 130, '90112jpg', 'image/jpeg', '0', 'jpg', 0),
(368, '900720jpg', NULL, 'image', '/uploads/images/900720jpg/', '\\images\\900720jpg\\', '800x600', 800, 600, '900720jpg', 'image/jpeg', '0', 'jpg', 0),
(369, '899dell-xps420jpg', NULL, 'image', '/uploads/images/899dell-xps420jpg/', '\\images\\899dell-xps420jpg\\', '450x371', 450, 371, '899dell-xps420jpg', 'image/jpeg', '0', 'jpg', 0),
(370, '899420jpg', NULL, 'image', '/uploads/images/899420jpg/', '\\images\\899420jpg\\', '450x306', 450, 306, '899420jpg', 'image/jpeg', '0', 'jpg', 0),
(371, '899dellxps420jpg', NULL, 'image', '/uploads/images/899dellxps420jpg/', '\\images\\899dellxps420jpg\\', '435x265', 435, 265, '899dellxps420jpg', 'image/jpeg', '0', 'jpg', 0),
(372, '898420jpg', NULL, 'image', '/uploads/images/898420jpg/', '\\images\\898420jpg\\', '450x306', 450, 306, '898420jpg', 'image/jpeg', '0', 'jpg', 0),
(373, '898dell-xps420jpg', NULL, 'image', '/uploads/images/898dell-xps420jpg/', '\\images\\898dell-xps420jpg\\', '450x371', 450, 371, '898dell-xps420jpg', 'image/jpeg', '0', 'jpg', 0),
(374, '897hp-dc5750-desktopjpg', NULL, 'image', '/uploads/images/897hp-dc5750-desktopjpg/', '\\images\\897hp-dc5750-desktopjpg\\', '336x253', 336, 253, '897hp-dc5750-desktopjpg', 'image/jpeg', '0', 'jpg', 0),
(375, '896hpdc790043jpg', NULL, 'image', '/uploads/images/896hpdc790043jpg/', '\\images\\896hpdc790043jpg\\', '400x300', 400, 300, '896hpdc790043jpg', 'image/jpeg', '0', 'jpg', 0),
(376, '895hpdc790043jpg', NULL, 'image', '/uploads/images/895hpdc790043jpg/', '\\images\\895hpdc790043jpg\\', '400x300', 400, 300, '895hpdc790043jpg', 'image/jpeg', '0', 'jpg', 0),
(377, '894hpdc790043jpg', NULL, 'image', '/uploads/images/894hpdc790043jpg/', '\\images\\894hpdc790043jpg\\', '400x300', 400, 300, '894hpdc790043jpg', 'image/jpeg', '0', 'jpg', 0),
(378, '893c03710315png', NULL, 'image', '/uploads/images/893c03710315png/', '\\images\\893c03710315png\\', '474x356', 474, 356, '893c03710315png', 'image/png', '0', 'png', 0),
(379, '892530sjpg', NULL, 'image', '/uploads/images/892530sjpg/', '\\images\\892530sjpg\\', '480x390', 480, 390, '892530sjpg', 'image/jpeg', '0', 'jpg', 0),
(380, '892dell-inpiron-530spng', NULL, 'image', '/uploads/images/892dell-inpiron-530spng/', '\\images\\892dell-inpiron-530spng\\', '500x319', 500, 319, '892dell-inpiron-530spng', 'image/png', '0', 'png', 0),
(381, '892dellainspiron-530sjpg', NULL, 'image', '/uploads/images/892dellainspiron-530sjpg/', '\\images\\892dellainspiron-530sjpg\\', '576x432', 576, 432, '892dellainspiron-530sjpg', 'image/jpeg', '0', 'jpg', 0),
(382, '891530sjpg', NULL, 'image', '/uploads/images/891530sjpg/', '\\images\\891530sjpg\\', '480x390', 480, 390, '891530sjpg', 'image/jpeg', '0', 'jpg', 0),
(383, '891dell-inpiron-530spng', NULL, 'image', '/uploads/images/891dell-inpiron-530spng/', '\\images\\891dell-inpiron-530spng\\', '500x319', 500, 319, '891dell-inpiron-530spng', 'image/png', '0', 'png', 0),
(384, '891dellainspiron-530sjpg', NULL, 'image', '/uploads/images/891dellainspiron-530sjpg/', '\\images\\891dellainspiron-530sjpg\\', '576x432', 576, 432, '891dellainspiron-530sjpg', 'image/jpeg', '0', 'jpg', 0),
(385, '890wbo1255079376jpg', NULL, 'image', '/uploads/images/890wbo1255079376jpg/', '\\images\\890wbo1255079376jpg\\', '350x279', 350, 279, '890wbo1255079376jpg', 'image/jpeg', '0', 'jpg', 0),
(386, '8891908wfptrimjpg', NULL, 'image', '/uploads/images/8891908wfptrimjpg/', '\\images\\8891908wfptrimjpg\\', '560x458', 560, 458, '8891908wfptrimjpg', 'image/jpeg', '0', 'jpg', 0),
(387, '888dell-optiplex-755-dtjpg', NULL, 'image', '/uploads/images/888dell-optiplex-755-dtjpg/', '\\images\\888dell-optiplex-755-dtjpg\\', '300x200', 300, 200, '888dell-optiplex-755-dtjpg', 'image/jpeg', '0', 'jpg', 0),
(388, '887may-tinh-de-ban-delljpg', NULL, 'image', '/uploads/images/887may-tinh-de-ban-delljpg/', '\\images\\887may-tinh-de-ban-delljpg\\', '720x480', 720, 480, '887may-tinh-de-ban-delljpg', 'image/jpeg', '0', 'jpg', 0),
(389, '88651dkngfsvblsx300jpg', NULL, 'image', '/uploads/images/88651dkngfsvblsx300jpg/', '\\images\\88651dkngfsvblsx300jpg\\', '300x225', 300, 225, '88651dkngfsvblsx300jpg', 'image/jpeg', '0', 'jpg', 0),
(390, '88551dkngfsvblsx300jpg', NULL, 'image', '/uploads/images/88551dkngfsvblsx300jpg/', '\\images\\88551dkngfsvblsx300jpg\\', '300x225', 300, 225, '88551dkngfsvblsx300jpg', 'image/jpeg', '0', 'jpg', 0),
(391, '884dell-optiplex-755-dtjpg', NULL, 'image', '/uploads/images/884dell-optiplex-755-dtjpg/', '\\images\\884dell-optiplex-755-dtjpg\\', '300x200', 300, 200, '884dell-optiplex-755-dtjpg', 'image/jpeg', '0', 'jpg', 0),
(392, '883dimension-9200cjpg', NULL, 'image', '/uploads/images/883dimension-9200cjpg/', '\\images\\883dimension-9200cjpg\\', '640x480', 640, 480, '883dimension-9200cjpg', 'image/jpeg', '0', 'jpg', 0),
(393, '883cimg5074jpg', NULL, 'image', '/uploads/images/883cimg5074jpg/', '\\images\\883cimg5074jpg\\', '1803x1243', 1803, 1243, '883cimg5074jpg', 'image/jpeg', '0', 'jpg', 0),
(394, '882dell-optiplex-760-sffjpg', NULL, 'image', '/uploads/images/882dell-optiplex-760-sffjpg/', '\\images\\882dell-optiplex-760-sffjpg\\', '480x390', 480, 390, '882dell-optiplex-760-sffjpg', 'image/jpeg', '0', 'jpg', 0),
(395, '882maybodell-755sffjpg', NULL, 'image', '/uploads/images/882maybodell-755sffjpg/', '\\images\\882maybodell-755sffjpg\\', '350x240', 350, 240, '882maybodell-755sffjpg', 'image/jpeg', '0', 'jpg', 0),
(396, '881dell-optiplex-760-sffjpg', NULL, 'image', '/uploads/images/881dell-optiplex-760-sffjpg/', '\\images\\881dell-optiplex-760-sffjpg\\', '480x390', 480, 390, '881dell-optiplex-760-sffjpg', 'image/jpeg', '0', 'jpg', 0),
(397, '881maybodell-755sffjpg', NULL, 'image', '/uploads/images/881maybodell-755sffjpg/', '\\images\\881maybodell-755sffjpg\\', '350x240', 350, 240, '881maybodell-755sffjpg', 'image/jpeg', '0', 'jpg', 0),
(398, '880hpcompaq4000prosff1100753g3jpg', NULL, 'image', '/uploads/images/880hpcompaq4000prosff1100753g3jpg/', '\\images\\880hpcompaq4000prosff1100753g3jpg\\', '606x403', 606, 403, '880hpcompaq4000prosff1100753g3jpg', 'image/jpeg', '0', 'jpg', 0),
(399, '879itm0015458171ljpg', NULL, 'image', '/uploads/images/879itm0015458171ljpg/', '\\images\\879itm0015458171ljpg\\', '365x365', 365, 365, '879itm0015458171ljpg', 'image/jpeg', '0', 'jpg', 0),
(400, '8786300sff-pentiumjpg', NULL, 'image', '/uploads/images/8786300sff-pentiumjpg/', '\\images\\8786300sff-pentiumjpg\\', '300x200', 300, 200, '8786300sff-pentiumjpg', 'image/jpeg', '0', 'jpg', 0),
(401, '877hpcompaq4000prosff1100753g3jpg', NULL, 'image', '/uploads/images/877hpcompaq4000prosff1100753g3jpg/', '\\images\\877hpcompaq4000prosff1100753g3jpg\\', '606x403', 606, 403, '877hpcompaq4000prosff1100753g3jpg', 'image/jpeg', '0', 'jpg', 0),
(402, '876votro260mtjpg', NULL, 'image', '/uploads/images/876votro260mtjpg/', '\\images\\876votro260mtjpg\\', '480x390', 480, 390, '876votro260mtjpg', 'image/jpeg', '0', 'jpg', 0),
(403, '876260mtjpg', NULL, 'image', '/uploads/images/876260mtjpg/', '\\images\\876260mtjpg\\', '600x400', 600, 400, '876260mtjpg', 'image/jpeg', '0', 'jpg', 0),
(404, '876260mtcopyjpg', NULL, 'image', '/uploads/images/876260mtcopyjpg/', '\\images\\876260mtcopyjpg\\', '480x390', 480, 390, '876260mtcopyjpg', 'image/jpeg', '0', 'jpg', 0),
(405, '876dell-vostro-260-mt-51365421-4-1jpg', NULL, 'image', '/uploads/images/876dell-vostro-260-mt-51365421-4-1jpg/', '\\images\\876dell-vostro-260-mt-51365421-4-1jpg\\', '1162x2100', 1162, 2100, '876dell-vostro-260-mt-51365421-4-1jpg', 'image/jpeg', '0', 'jpg', 0),
(406, '876vostro260mtjpg', NULL, 'image', '/uploads/images/876vostro260mtjpg/', '\\images\\876vostro260mtjpg\\', '139x300', 139, 300, '876vostro260mtjpg', 'image/jpeg', '0', 'jpg', 0),
(407, '875vostro270dellpng', NULL, 'image', '/uploads/images/875vostro270dellpng/', '\\images\\875vostro270dellpng\\', '330x293', 330, 293, '875vostro270dellpng', 'image/png', '0', 'png', 0),
(408, '875del270mt95jpg', NULL, 'image', '/uploads/images/875del270mt95jpg/', '\\images\\875del270mt95jpg\\', '358x247', 358, 247, '875del270mt95jpg', 'image/jpeg', '0', 'jpg', 0),
(409, '874pecision-t35001jpg', NULL, 'image', '/uploads/images/874pecision-t35001jpg/', '\\images\\874pecision-t35001jpg\\', '480x390', 480, 390, '874pecision-t35001jpg', 'image/jpeg', '0', 'jpg', 0),
(410, '874t35001jpg', NULL, 'image', '/uploads/images/874t35001jpg/', '\\images\\874t35001jpg\\', '480x390', 480, 390, '874t35001jpg', 'image/jpeg', '0', 'jpg', 0),
(411, '874dell-t3500-1jpg', NULL, 'image', '/uploads/images/874dell-t3500-1jpg/', '\\images\\874dell-t3500-1jpg\\', '480x390', 480, 390, '874dell-t3500-1jpg', 'image/jpeg', '0', 'jpg', 0),
(412, '873dx-7500-1jpg', NULL, 'image', '/uploads/images/873dx-7500-1jpg/', '\\images\\873dx-7500-1jpg\\', '650x488', 650, 488, '873dx-7500-1jpg', 'image/jpeg', '0', 'jpg', 0),
(413, '873103726800jpg', NULL, 'image', '/uploads/images/873103726800jpg/', '\\images\\873103726800jpg\\', '350x203', 350, 203, '873103726800jpg', 'image/jpeg', '0', 'jpg', 0),
(414, '872dx-7500-1jpg', NULL, 'image', '/uploads/images/872dx-7500-1jpg/', '\\images\\872dx-7500-1jpg\\', '650x488', 650, 488, '872dx-7500-1jpg', 'image/jpeg', '0', 'jpg', 0),
(415, '872103726800jpg', NULL, 'image', '/uploads/images/872103726800jpg/', '\\images\\872103726800jpg\\', '350x203', 350, 203, '872103726800jpg', 'image/jpeg', '0', 'jpg', 0),
(416, '871103726800jpg', NULL, 'image', '/uploads/images/871103726800jpg/', '\\images\\871103726800jpg\\', '350x203', 350, 203, '871103726800jpg', 'image/jpeg', '0', 'jpg', 0),
(417, '872103726800jpg-2', NULL, 'image', '/uploads/images/872103726800jpg-2/', '\\images\\872103726800jpg-2\\', '350x203', 350, 203, '872103726800jpg-2', 'image/jpeg', '0', 'jpg', 0),
(418, '871dx-7500-1jpg', NULL, 'image', '/uploads/images/871dx-7500-1jpg/', '\\images\\871dx-7500-1jpg\\', '650x488', 650, 488, '871dx-7500-1jpg', 'image/jpeg', '0', 'jpg', 0),
(419, '870untitled-2jpg', NULL, 'image', '/uploads/images/870untitled-2jpg/', '\\images\\870untitled-2jpg\\', '480x390', 480, 390, '870untitled-2jpg', 'image/jpeg', '0', 'jpg', 0),
(420, '870optiplex-desktop-7010-tooltip9png', NULL, 'image', '/uploads/images/870optiplex-desktop-7010-tooltip9png/', '\\images\\870optiplex-desktop-7010-tooltip9png\\', '330x255', 330, 255, '870optiplex-desktop-7010-tooltip9png', 'image/png', '0', 'png', 0),
(421, '870untitled-1jpg', NULL, 'image', '/uploads/images/870untitled-1jpg/', '\\images\\870untitled-1jpg\\', '480x390', 480, 390, '870untitled-1jpg', 'image/jpeg', '0', 'jpg', 0),
(422, '869dell-optiplex-360jpg', NULL, 'image', '/uploads/images/869dell-optiplex-360jpg/', '\\images\\869dell-optiplex-360jpg\\', '640x480', 640, 480, '869dell-optiplex-360jpg', 'image/jpeg', '0', 'jpg', 0),
(423, '8694jpg', NULL, 'image', '/uploads/images/8694jpg/', '\\images\\8694jpg\\', '600x320', 600, 320, '8694jpg', 'image/jpeg', '0', 'jpg', 0),
(424, '869calculator-dell-optiplex-360dt-second-handjpg', NULL, 'image', '/uploads/images/869calculator-dell-optiplex-360dt-second-handjpg/', '\\images\\869calculator-dell-optiplex-360dt-second-handjpg\\', '503x232', 503, 232, '869calculator-dell-optiplex-360dt-second-handjpg', 'image/jpeg', '0', 'jpg', 0),
(425, '868img5755jpg', NULL, 'image', '/uploads/images/868img5755jpg/', '\\images\\868img5755jpg\\', '3966x2256', 3966, 2256, '868img5755jpg', 'image/jpeg', '0', 'jpg', 0),
(426, '868optiplex-780jpg', NULL, 'image', '/uploads/images/868optiplex-780jpg/', '\\images\\868optiplex-780jpg\\', '1200x754', 1200, 754, '868optiplex-780jpg', 'image/jpeg', '0', 'jpg', 0),
(427, '867img5755jpg', NULL, 'image', '/uploads/images/867img5755jpg/', '\\images\\867img5755jpg\\', '3966x2256', 3966, 2256, '867img5755jpg', 'image/jpeg', '0', 'jpg', 0),
(428, '867optiplex-780jpg', NULL, 'image', '/uploads/images/867optiplex-780jpg/', '\\images\\867optiplex-780jpg\\', '1200x754', 1200, 754, '867optiplex-780jpg', 'image/jpeg', '0', 'jpg', 0),
(429, '866dell-960-sff-3jpg', NULL, 'image', '/uploads/images/866dell-960-sff-3jpg/', '\\images\\866dell-960-sff-3jpg\\', '480x390', 480, 390, '866dell-960-sff-3jpg', 'image/jpeg', '0', 'jpg', 0),
(430, '866dell-optiplex-960-sffjpg', NULL, 'image', '/uploads/images/866dell-optiplex-960-sffjpg/', '\\images\\866dell-optiplex-960-sffjpg\\', '480x390', 480, 390, '866dell-optiplex-960-sffjpg', 'image/jpeg', '0', 'jpg', 0),
(431, '866optiplex-960jpg', NULL, 'image', '/uploads/images/866optiplex-960jpg/', '\\images\\866optiplex-960jpg\\', '440x330', 440, 330, '866optiplex-960jpg', 'image/jpeg', '0', 'jpg', 0),
(432, '866optiplex-960sffjpg', NULL, 'image', '/uploads/images/866optiplex-960sffjpg/', '\\images\\866optiplex-960sffjpg\\', '480x390', 480, 390, '866optiplex-960sffjpg', 'image/jpeg', '0', 'jpg', 0),
(433, '865optiplex-960sffjpg', NULL, 'image', '/uploads/images/865optiplex-960sffjpg/', '\\images\\865optiplex-960sffjpg\\', '480x390', 480, 390, '865optiplex-960sffjpg', 'image/jpeg', '0', 'jpg', 0),
(434, '865dell-960-sff-3jpg', NULL, 'image', '/uploads/images/865dell-960-sff-3jpg/', '\\images\\865dell-960-sff-3jpg\\', '480x390', 480, 390, '865dell-960-sff-3jpg', 'image/jpeg', '0', 'jpg', 0),
(435, '865dell-optiplex-960-sffjpg', NULL, 'image', '/uploads/images/865dell-optiplex-960-sffjpg/', '\\images\\865dell-optiplex-960-sffjpg\\', '480x390', 480, 390, '865dell-optiplex-960-sffjpg', 'image/jpeg', '0', 'jpg', 0),
(436, '865optiplex-960jpg', NULL, 'image', '/uploads/images/865optiplex-960jpg/', '\\images\\865optiplex-960jpg\\', '440x330', 440, 330, '865optiplex-960jpg', 'image/jpeg', '0', 'jpg', 0),
(437, '86420mjpg', NULL, 'image', '/uploads/images/86420mjpg/', '\\images\\86420mjpg\\', '500x500', 500, 500, '86420mjpg', 'image/jpeg', '0', 'jpg', 0),
(438, '86315mjpg', NULL, 'image', '/uploads/images/86315mjpg/', '\\images\\86315mjpg\\', '200x200', 200, 200, '86315mjpg', 'image/jpeg', '0', 'jpg', 0),
(439, '86210mjpg', NULL, 'image', '/uploads/images/86210mjpg/', '\\images\\86210mjpg\\', '1200x938', 1200, 938, '86210mjpg', 'image/jpeg', '0', 'jpg', 0),
(440, '8615mjpg', NULL, 'image', '/uploads/images/8615mjpg/', '\\images\\8615mjpg\\', '540x330', 540, 330, '8615mjpg', 'image/jpeg', '0', 'jpg', 0),
(441, '8603mjpg', NULL, 'image', '/uploads/images/8603mjpg/', '\\images\\8603mjpg\\', '500x375', 500, 375, '8603mjpg', 'image/jpeg', '0', 'jpg', 0),
(443, '85915mjpg-2', NULL, 'image', '/uploads/images/85915mjpg-2/', '\\images\\85915mjpg-2\\', '500x375', 500, 375, '85915mjpg-2', 'image/jpeg', '0', 'jpg', 0),
(444, '858chuot-khong-day-rapoo-1620jpg', NULL, 'image', '/uploads/images/858chuot-khong-day-rapoo-1620jpg/', '\\images\\858chuot-khong-day-rapoo-1620jpg\\', '500x500', 500, 500, '858chuot-khong-day-rapoo-1620jpg', 'image/jpeg', '0', 'jpg', 0),
(445, '857chuot-khong-day-logitech-m185jpg', NULL, 'image', '/uploads/images/857chuot-khong-day-logitech-m185jpg/', '\\images\\857chuot-khong-day-logitech-m185jpg\\', '440x347', 440, 347, '857chuot-khong-day-logitech-m185jpg', 'image/jpeg', '0', 'jpg', 0),
(446, '856chuot-khong-day-2jpg', NULL, 'image', '/uploads/images/856chuot-khong-day-2jpg/', '\\images\\856chuot-khong-day-2jpg\\', '1024x1024', 1024, 1024, '856chuot-khong-day-2jpg', 'image/jpeg', '0', 'jpg', 0),
(447, '856chuot-khong-day-1jpg', NULL, 'image', '/uploads/images/856chuot-khong-day-1jpg/', '\\images\\856chuot-khong-day-1jpg\\', '3008x2000', 3008, 2000, '856chuot-khong-day-1jpg', 'image/jpeg', '0', 'jpg', 0),
(448, '856chuot-khong-dayjpg', NULL, 'image', '/uploads/images/856chuot-khong-dayjpg/', '\\images\\856chuot-khong-dayjpg\\', '500x500', 500, 500, '856chuot-khong-dayjpg', 'image/jpeg', '0', 'jpg', 0),
(449, '8553330mtjpg', NULL, 'image', '/uploads/images/8553330mtjpg/', '\\images\\8553330mtjpg\\', '400x300', 400, 300, '8553330mtjpg', 'image/jpeg', '0', 'jpg', 0),
(450, '8543130mtjpg', NULL, 'image', '/uploads/images/8543130mtjpg/', '\\images\\8543130mtjpg\\', '500x466', 500, 466, '8543130mtjpg', 'image/jpeg', '0', 'jpg', 0),
(453, '8523130mtjpg', NULL, 'image', '/uploads/images/8523130mtjpg/', '\\images\\8523130mtjpg\\', '500x466', 500, 466, '8523130mtjpg', 'image/jpeg', '0', 'jpg', 0),
(454, '8533130mtjpg', NULL, 'image', '/uploads/images/8533130mtjpg/', '\\images\\8533130mtjpg\\', '500x466', 500, 466, '8533130mtjpg', 'image/jpeg', '0', 'jpg', 0),
(455, '851owh1364875172jpg', NULL, 'image', '/uploads/images/851owh1364875172jpg/', '\\images\\851owh1364875172jpg\\', '1268x951', 1268, 951, '851owh1364875172jpg', 'image/jpeg', '0', 'jpg', 0),
(456, '850owh1364875172jpg', NULL, 'image', '/uploads/images/850owh1364875172jpg/', '\\images\\850owh1364875172jpg\\', '1268x951', 1268, 951, '850owh1364875172jpg', 'image/jpeg', '0', 'jpg', 0),
(458, '849-intel-celeron-e3400-jpg', NULL, 'image', '/uploads/images/849-intel-celeron-e3400-jpg/', '\\images\\849-intel-celeron-e3400-jpg\\', '320x320', 320, 320, '849-intel-celeron-e3400-jpg', 'image/jpeg', '0', 'jpg', 0),
(459, '848604371462-500x500jpg', NULL, 'image', '/uploads/images/848604371462-500x500jpg/', '\\images\\848604371462-500x500jpg\\', '500x500', 500, 500, '848604371462-500x500jpg', 'image/jpeg', '0', 'jpg', 0),
(460, '847j2932jpg', NULL, 'image', '/uploads/images/847j2932jpg/', '\\images\\847j2932jpg\\', '320x240', 320, 240, '847j2932jpg', 'image/jpeg', '0', 'jpg', 0),
(461, '846634483078859036282jpg', NULL, 'image', '/uploads/images/846634483078859036282jpg/', '\\images\\846634483078859036282jpg\\', '350x250', 350, 250, '846634483078859036282jpg', 'image/jpeg', '0', 'jpg', 0),
(462, '845acer-veriton-x2610gjpg', NULL, 'image', '/uploads/images/845acer-veriton-x2610gjpg/', '\\images\\845acer-veriton-x2610gjpg\\', '1215x1200', 1215, 1200, '845acer-veriton-x2610gjpg', 'image/jpeg', '0', 'jpg', 0),
(463, '844del-vostro-230s1jpg', NULL, 'image', '/uploads/images/844del-vostro-230s1jpg/', '\\images\\844del-vostro-230s1jpg\\', '480x390', 480, 390, '844del-vostro-230s1jpg', 'image/jpeg', '0', 'jpg', 0),
(464, '844vostro-230s11-1jpg', NULL, 'image', '/uploads/images/844vostro-230s11-1jpg/', '\\images\\844vostro-230s11-1jpg\\', '480x390', 480, 390, '844vostro-230s11-1jpg', 'image/jpeg', '0', 'jpg', 0),
(465, '843del-vostro-230s1jpg', NULL, 'image', '/uploads/images/843del-vostro-230s1jpg/', '\\images\\843del-vostro-230s1jpg\\', '480x390', 480, 390, '843del-vostro-230s1jpg', 'image/jpeg', '0', 'jpg', 0),
(466, '843vostro-230s11-1jpg', NULL, 'image', '/uploads/images/843vostro-230s11-1jpg/', '\\images\\843vostro-230s11-1jpg\\', '480x390', 480, 390, '843vostro-230s11-1jpg', 'image/jpeg', '0', 'jpg', 0),
(467, '842dell-vostro-vostro-420-mtjpg', NULL, 'image', '/uploads/images/842dell-vostro-vostro-420-mtjpg/', '\\images\\842dell-vostro-vostro-420-mtjpg\\', '800x600', 800, 600, '842dell-vostro-vostro-420-mtjpg', 'image/jpeg', '0', 'jpg', 0),
(469, '841vostro-220sjpg-2', NULL, 'image', '/uploads/images/841vostro-220sjpg-2/', '\\images\\841vostro-220sjpg-2\\', '625x455', 625, 455, '841vostro-220sjpg-2', 'image/jpeg', '0', 'jpg', 0),
(470, '840dell-inspiron-580jpg', NULL, 'image', '/uploads/images/840dell-inspiron-580jpg/', '\\images\\840dell-inspiron-580jpg\\', '295x295', 295, 295, '840dell-inspiron-580jpg', 'image/jpeg', '0', 'jpg', 0),
(471, '839untitled-21jpg', NULL, 'image', '/uploads/images/839untitled-21jpg/', '\\images\\839untitled-21jpg\\', '480x390', 480, 390, '839untitled-21jpg', 'image/jpeg', '0', 'jpg', 0),
(472, '839may-bo-dell-vostro-470jpg', NULL, 'image', '/uploads/images/839may-bo-dell-vostro-470jpg/', '\\images\\839may-bo-dell-vostro-470jpg\\', '360x428', 360, 428, '839may-bo-dell-vostro-470jpg', 'image/jpeg', '0', 'jpg', 0),
(473, '839untitled-13jpg', NULL, 'image', '/uploads/images/839untitled-13jpg/', '\\images\\839untitled-13jpg\\', '480x390', 480, 390, '839untitled-13jpg', 'image/jpeg', '0', 'jpg', 0),
(474, '839dell-vostro-470mtjpg', NULL, 'image', '/uploads/images/839dell-vostro-470mtjpg/', '\\images\\839dell-vostro-470mtjpg\\', '300x200', 300, 200, '839dell-vostro-470mtjpg', 'image/jpeg', '0', 'jpg', 0),
(475, '838dell-inspiron-660jpg', NULL, 'image', '/uploads/images/838dell-inspiron-660jpg/', '\\images\\838dell-inspiron-660jpg\\', '550x373', 550, 373, '838dell-inspiron-660jpg', 'image/jpeg', '0', 'jpg', 0),
(476, '837832mtwlelqmzqh2up5fsa8wwjpg', NULL, 'image', '/uploads/images/837832mtwlelqmzqh2up5fsa8wwjpg/', '\\images\\837832mtwlelqmzqh2up5fsa8wwjpg\\', '225x172', 225, 172, '837832mtwlelqmzqh2up5fsa8wwjpg', 'image/jpeg', '0', 'jpg', 0),
(477, '8367900sffjpg', NULL, 'image', '/uploads/images/8367900sffjpg/', '\\images\\8367900sffjpg\\', '480x390', 480, 390, '8367900sffjpg', 'image/jpeg', '0', 'jpg', 0),
(478, '8362050467jpg', NULL, 'image', '/uploads/images/8362050467jpg/', '\\images\\8362050467jpg\\', '600x380', 600, 380, '8362050467jpg', 'image/jpeg', '0', 'jpg', 0),
(479, '836dc7900-1jpg', NULL, 'image', '/uploads/images/836dc7900-1jpg/', '\\images\\836dc7900-1jpg\\', '800x600', 800, 600, '836dc7900-1jpg', 'image/jpeg', '0', 'jpg', 0),
(480, '8357900sffjpg', NULL, 'image', '/uploads/images/8357900sffjpg/', '\\images\\8357900sffjpg\\', '480x390', 480, 390, '8357900sffjpg', 'image/jpeg', '0', 'jpg', 0),
(481, '8352050467jpg', NULL, 'image', '/uploads/images/8352050467jpg/', '\\images\\8352050467jpg\\', '600x380', 600, 380, '8352050467jpg', 'image/jpeg', '0', 'jpg', 0),
(482, '835dc7900-1jpg', NULL, 'image', '/uploads/images/835dc7900-1jpg/', '\\images\\835dc7900-1jpg\\', '800x600', 800, 600, '835dc7900-1jpg', 'image/jpeg', '0', 'jpg', 0),
(483, '834lcd-aoc-19-inch-1jpg', NULL, 'image', '/uploads/images/834lcd-aoc-19-inch-1jpg/', '\\images\\834lcd-aoc-19-inch-1jpg\\', '459x750', 459, 750, '834lcd-aoc-19-inch-1jpg', 'image/jpeg', '0', 'jpg', 0),
(484, '834lcd-aoc-19-inch-3jpg', NULL, 'image', '/uploads/images/834lcd-aoc-19-inch-3jpg/', '\\images\\834lcd-aoc-19-inch-3jpg\\', '400x300', 400, 300, '834lcd-aoc-19-inch-3jpg', 'image/jpeg', '0', 'jpg', 0),
(485, '833740sffjpg', NULL, 'image', '/uploads/images/833740sffjpg/', '\\images\\833740sffjpg\\', '480x390', 480, 390, '833740sffjpg', 'image/jpeg', '0', 'jpg', 0),
(486, '833832mtwlelqmzqh2up5fsa8wwjpg', NULL, 'image', '/uploads/images/833832mtwlelqmzqh2up5fsa8wwjpg/', '\\images\\833832mtwlelqmzqh2up5fsa8wwjpg\\', '225x172', 225, 172, '833832mtwlelqmzqh2up5fsa8wwjpg', 'image/jpeg', '0', 'jpg', 0),
(487, '833833mtwlelqmzqh2up5fsa8ww-copyjpg', NULL, 'image', '/uploads/images/833833mtwlelqmzqh2up5fsa8ww-copyjpg/', '\\images\\833833mtwlelqmzqh2up5fsa8ww-copyjpg\\', '225x172', 225, 172, '833833mtwlelqmzqh2up5fsa8ww-copyjpg', 'image/jpeg', '0', 'jpg', 0),
(488, '832740sffjpg', NULL, 'image', '/uploads/images/832740sffjpg/', '\\images\\832740sffjpg\\', '480x390', 480, 390, '832740sffjpg', 'image/jpeg', '0', 'jpg', 0),
(489, '832832mtwlelqmzqh2up5fsa8wwjpg', NULL, 'image', '/uploads/images/832832mtwlelqmzqh2up5fsa8wwjpg/', '\\images\\832832mtwlelqmzqh2up5fsa8wwjpg\\', '225x172', 225, 172, '832832mtwlelqmzqh2up5fsa8wwjpg', 'image/jpeg', '0', 'jpg', 0),
(490, '831lcd-a154vwjpg', NULL, 'image', '/uploads/images/831lcd-a154vwjpg/', '\\images\\831lcd-a154vwjpg\\', '180x185', 180, 185, '831lcd-a154vwjpg', 'image/jpeg', '0', 'jpg', 0),
(491, '831man-hinh-lcd-cujpg', NULL, 'image', '/uploads/images/831man-hinh-lcd-cujpg/', '\\images\\831man-hinh-lcd-cujpg\\', '600x699', 600, 699, '831man-hinh-lcd-cujpg', 'image/jpeg', '0', 'jpg', 0),
(492, '830may-tinh-de-ban-delljpg', NULL, 'image', '/uploads/images/830may-tinh-de-ban-delljpg/', '\\images\\830may-tinh-de-ban-delljpg\\', '720x480', 720, 480, '830may-tinh-de-ban-delljpg', 'image/jpeg', '0', 'jpg', 0),
(493, '830delloptiplex3020mtjpg', NULL, 'image', '/uploads/images/830delloptiplex3020mtjpg/', '\\images\\830delloptiplex3020mtjpg\\', '300x300', 300, 300, '830delloptiplex3020mtjpg', 'image/jpeg', '0', 'jpg', 0),
(494, '829c03710410png', NULL, 'image', '/uploads/images/829c03710410png/', '\\images\\829c03710410png\\', '474x356', 474, 356, '829c03710410png', 'image/png', '0', 'png', 0),
(495, '829c03710492png', NULL, 'image', '/uploads/images/829c03710492png/', '\\images\\829c03710492png\\', '474x356', 474, 356, '829c03710492png', 'image/png', '0', 'png', 0),
(496, '827may-tinh-de-ban-1jpg', NULL, 'image', '/uploads/images/827may-tinh-de-ban-1jpg/', '\\images\\827may-tinh-de-ban-1jpg\\', '640x480', 640, 480, '827may-tinh-de-ban-1jpg', 'image/jpeg', '0', 'jpg', 0),
(497, '827may-tinh-de-banjpg', NULL, 'image', '/uploads/images/827may-tinh-de-banjpg/', '\\images\\827may-tinh-de-banjpg\\', '600x450', 600, 450, '827may-tinh-de-banjpg', 'image/jpeg', '0', 'jpg', 0),
(498, '826may-tinh-de-ban-1jpg', NULL, 'image', '/uploads/images/826may-tinh-de-ban-1jpg/', '\\images\\826may-tinh-de-ban-1jpg\\', '640x480', 640, 480, '826may-tinh-de-ban-1jpg', 'image/jpeg', '0', 'jpg', 0),
(499, '826may-tinh-de-banjpg', NULL, 'image', '/uploads/images/826may-tinh-de-banjpg/', '\\images\\826may-tinh-de-banjpg\\', '600x450', 600, 450, '826may-tinh-de-banjpg', 'image/jpeg', '0', 'jpg', 0),
(500, '8253751jpg', NULL, 'image', '/uploads/images/8253751jpg/', '\\images\\8253751jpg\\', '300x300', 300, 300, '8253751jpg', 'image/jpeg', '0', 'jpg', 0),
(501, '824dell-optiplex-755sff-1jpg', NULL, 'image', '/uploads/images/824dell-optiplex-755sff-1jpg/', '\\images\\824dell-optiplex-755sff-1jpg\\', '500x500', 500, 500, '824dell-optiplex-755sff-1jpg', 'image/jpeg', '0', 'jpg', 0),
(502, '823dc7700sffjpg', NULL, 'image', '/uploads/images/823dc7700sffjpg/', '\\images\\823dc7700sffjpg\\', '300x200', 300, 200, '823dc7700sffjpg', 'image/jpeg', '0', 'jpg', 0),
(503, '822dell-e2210h-lcd-monitorjpg', NULL, 'image', '/uploads/images/822dell-e2210h-lcd-monitorjpg/', '\\images\\822dell-e2210h-lcd-monitorjpg\\', '553x409', 553, 409, '822dell-e2210h-lcd-monitorjpg', 'image/jpeg', '0', 'jpg', 0),
(504, '821monitordell2009wfjpg', NULL, 'image', '/uploads/images/821monitordell2009wfjpg/', '\\images\\821monitordell2009wfjpg\\', '640x480', 640, 480, '821monitordell2009wfjpg', 'image/jpeg', '0', 'jpg', 0),
(505, '820untitled-1jpg', NULL, 'image', '/uploads/images/820untitled-1jpg/', '\\images\\820untitled-1jpg\\', '300x200', 300, 200, '820untitled-1jpg', 'image/jpeg', '0', 'jpg', 0),
(506, '819390dt0jpg', NULL, 'image', '/uploads/images/819390dt0jpg/', '\\images\\819390dt0jpg\\', '300x200', 300, 200, '819390dt0jpg', 'image/jpeg', '0', 'jpg', 0),
(507, '818190sjpg', NULL, 'image', '/uploads/images/818190sjpg/', '\\images\\818190sjpg\\', '300x200', 300, 200, '818190sjpg', 'image/jpeg', '0', 'jpg', 0),
(508, '8176300sff-corei7jpg', NULL, 'image', '/uploads/images/8176300sff-corei7jpg/', '\\images\\8176300sff-corei7jpg\\', '300x200', 300, 200, '8176300sff-corei7jpg', 'image/jpeg', '0', 'jpg', 0),
(509, '8166300sff-corei5jpg', NULL, 'image', '/uploads/images/8166300sff-corei5jpg/', '\\images\\8166300sff-corei5jpg\\', '300x200', 300, 200, '8166300sff-corei5jpg', 'image/jpeg', '0', 'jpg', 0),
(510, '8156300sff-corei3jpg', NULL, 'image', '/uploads/images/8156300sff-corei3jpg/', '\\images\\8156300sff-corei3jpg\\', '300x200', 300, 200, '8156300sff-corei3jpg', 'image/jpeg', '0', 'jpg', 0),
(511, '8146300sff-pentiumjpg', NULL, 'image', '/uploads/images/8146300sff-pentiumjpg/', '\\images\\8146300sff-pentiumjpg\\', '300x200', 300, 200, '8146300sff-pentiumjpg', 'image/jpeg', '0', 'jpg', 0),
(512, '813g570jpg', NULL, 'image', '/uploads/images/813g570jpg/', '\\images\\813g570jpg\\', '1280x786', 1280, 786, '813g570jpg', 'image/jpeg', '0', 'jpg', 0),
(513, '813erphoto14787752jpg', NULL, 'image', '/uploads/images/813erphoto14787752jpg/', '\\images\\813erphoto14787752jpg\\', '755x604', 755, 604, '813erphoto14787752jpg', 'image/jpeg', '0', 'jpg', 0),
(514, '813lenovo-g570jpg', NULL, 'image', '/uploads/images/813lenovo-g570jpg/', '\\images\\813lenovo-g570jpg\\', '300x200', 300, 200, '813lenovo-g570jpg', 'image/jpeg', '0', 'jpg', 0),
(515, '813ntk1328548615jpg', NULL, 'image', '/uploads/images/813ntk1328548615jpg/', '\\images\\813ntk1328548615jpg\\', '940x475', 940, 475, '813ntk1328548615jpg', 'image/jpeg', '0', 'jpg', 0),
(517, '812laptop-asus-k42jjpg-2', NULL, 'image', '/uploads/images/812laptop-asus-k42jjpg-2/', '\\images\\812laptop-asus-k42jjpg-2\\', '300x200', 300, 200, '812laptop-asus-k42jjpg-2', 'image/jpeg', '0', 'jpg', 0),
(518, '8113000pro-quadjpg', NULL, 'image', '/uploads/images/8113000pro-quadjpg/', '\\images\\8113000pro-quadjpg\\', '300x200', 300, 200, '8113000pro-quadjpg', 'image/jpeg', '0', 'jpg', 0),
(519, '811hqdefaultjpg', NULL, 'image', '/uploads/images/811hqdefaultjpg/', '\\images\\811hqdefaultjpg\\', '480x360', 480, 360, '811hqdefaultjpg', 'image/jpeg', '0', 'jpg', 0),
(520, '8103000pro-quadjpg', NULL, 'image', '/uploads/images/8103000pro-quadjpg/', '\\images\\8103000pro-quadjpg\\', '300x200', 300, 200, '8103000pro-quadjpg', 'image/jpeg', '0', 'jpg', 0),
(521, '810hp6000jpg', NULL, 'image', '/uploads/images/810hp6000jpg/', '\\images\\810hp6000jpg\\', '350x478', 350, 478, '810hp6000jpg', 'image/jpeg', '0', 'jpg', 0),
(522, '810hp-compaq-6000-pro-microtower-mt-la427pa1jpg', NULL, 'image', '/uploads/images/810hp-compaq-6000-pro-microtower-mt-la427pa1jpg/', '\\images\\810hp-compaq-6000-pro-microtower-mt-la427pa1jpg\\', '400x400', 400, 400, '810hp-compaq-6000-pro-microtower-mt-la427pa1jpg', 'image/jpeg', '0', 'jpg', 0),
(523, '810hqdefaultjpg', NULL, 'image', '/uploads/images/810hqdefaultjpg/', '\\images\\810hqdefaultjpg\\', '480x360', 480, 360, '810hqdefaultjpg', 'image/jpeg', '0', 'jpg', 0),
(524, '8093000pro-core-2-duojpg', NULL, 'image', '/uploads/images/8093000pro-core-2-duojpg/', '\\images\\8093000pro-core-2-duojpg\\', '300x200', 300, 200, '8093000pro-core-2-duojpg', 'image/jpeg', '0', 'jpg', 0),
(525, '808dc7700sff1jpg', NULL, 'image', '/uploads/images/808dc7700sff1jpg/', '\\images\\808dc7700sff1jpg\\', '300x200', 300, 200, '808dc7700sff1jpg', 'image/jpeg', '0', 'jpg', 0),
(526, '807dc7700sff1jpg', NULL, 'image', '/uploads/images/807dc7700sff1jpg/', '\\images\\807dc7700sff1jpg\\', '300x200', 300, 200, '807dc7700sff1jpg', 'image/jpeg', '0', 'jpg', 0),
(527, '805dell-vostro-200-dtjpg', NULL, 'image', '/uploads/images/805dell-vostro-200-dtjpg/', '\\images\\805dell-vostro-200-dtjpg\\', '225x225', 225, 225, '805dell-vostro-200-dtjpg', 'image/jpeg', '0', 'jpg', 0),
(528, '805may-bo-dell-cu-vostro-200-dtjpg', NULL, 'image', '/uploads/images/805may-bo-dell-cu-vostro-200-dtjpg/', '\\images\\805may-bo-dell-cu-vostro-200-dtjpg\\', '259x194', 259, 194, '805may-bo-dell-cu-vostro-200-dtjpg', 'image/jpeg', '0', 'jpg', 0),
(529, '804lcd-hp17jpg', NULL, 'image', '/uploads/images/804lcd-hp17jpg/', '\\images\\804lcd-hp17jpg\\', '300x200', 300, 200, '804lcd-hp17jpg', 'image/jpeg', '0', 'jpg', 0),
(530, '803790mtjpg', NULL, 'image', '/uploads/images/803790mtjpg/', '\\images\\803790mtjpg\\', '300x200', 300, 200, '803790mtjpg', 'image/jpeg', '0', 'jpg', 0),
(531, '803may-bo-dell-optiplex-390mtjpg', NULL, 'image', '/uploads/images/803may-bo-dell-optiplex-390mtjpg/', '\\images\\803may-bo-dell-optiplex-390mtjpg\\', '300x200', 300, 200, '803may-bo-dell-optiplex-390mtjpg', 'image/jpeg', '0', 'jpg', 0),
(532, '802dell-optiplex-980-i7jpg', NULL, 'image', '/uploads/images/802dell-optiplex-980-i7jpg/', '\\images\\802dell-optiplex-980-i7jpg\\', '300x200', 300, 200, '802dell-optiplex-980-i7jpg', 'image/jpeg', '0', 'jpg', 0),
(533, '801may-bo-dell-optiplex-980sffjpg', NULL, 'image', '/uploads/images/801may-bo-dell-optiplex-980sffjpg/', '\\images\\801may-bo-dell-optiplex-980sffjpg\\', '300x200', 300, 200, '801may-bo-dell-optiplex-980sffjpg', 'image/jpeg', '0', 'jpg', 0),
(534, '800lcd-dell-17-chan-vjpg', NULL, 'image', '/uploads/images/800lcd-dell-17-chan-vjpg/', '\\images\\800lcd-dell-17-chan-vjpg\\', '500x500', 500, 500, '800lcd-dell-17-chan-vjpg', 'image/jpeg', '0', 'jpg', 0),
(535, '800dell-v-17-1jpg', NULL, 'image', '/uploads/images/800dell-v-17-1jpg/', '\\images\\800dell-v-17-1jpg\\', '300x200', 300, 200, '800dell-v-17-1jpg', 'image/jpeg', '0', 'jpg', 0),
(536, '789delloptiplex-755sffjpg', NULL, 'image', '/uploads/images/789delloptiplex-755sffjpg/', '\\images\\789delloptiplex-755sffjpg\\', '500x500', 500, 500, '789delloptiplex-755sffjpg', 'image/jpeg', '0', 'jpg', 0),
(537, '789dell-optiplex-755-dtjpg', NULL, 'image', '/uploads/images/789dell-optiplex-755-dtjpg/', '\\images\\789dell-optiplex-755-dtjpg\\', '300x200', 300, 200, '789dell-optiplex-755-dtjpg', 'image/jpeg', '0', 'jpg', 0),
(538, '788dell-optiplex-755-dtjpg', NULL, 'image', '/uploads/images/788dell-optiplex-755-dtjpg/', '\\images\\788dell-optiplex-755-dtjpg\\', '300x200', 300, 200, '788dell-optiplex-755-dtjpg', 'image/jpeg', '0', 'jpg', 0),
(539, '788delloptiplex-755sffjpg', NULL, 'image', '/uploads/images/788delloptiplex-755sffjpg/', '\\images\\788delloptiplex-755sffjpg\\', '500x500', 500, 500, '788delloptiplex-755sffjpg', 'image/jpeg', '0', 'jpg', 0),
(540, '787dell-optiplex-755-dtjpg', NULL, 'image', '/uploads/images/787dell-optiplex-755-dtjpg/', '\\images\\787dell-optiplex-755-dtjpg\\', '300x200', 300, 200, '787dell-optiplex-755-dtjpg', 'image/jpeg', '0', 'jpg', 0),
(541, '787delloptiplex-755sffjpg', NULL, 'image', '/uploads/images/787delloptiplex-755sffjpg/', '\\images\\787delloptiplex-755sffjpg\\', '500x500', 500, 500, '787delloptiplex-755sffjpg', 'image/jpeg', '0', 'jpg', 0),
(542, '786delloptiplex-755sffjpg', NULL, 'image', '/uploads/images/786delloptiplex-755sffjpg/', '\\images\\786delloptiplex-755sffjpg\\', '500x500', 500, 500, '786delloptiplex-755sffjpg', 'image/jpeg', '0', 'jpg', 0),
(543, '785delloptiplex-755sffjpg', NULL, 'image', '/uploads/images/785delloptiplex-755sffjpg/', '\\images\\785delloptiplex-755sffjpg\\', '500x500', 500, 500, '785delloptiplex-755sffjpg', 'image/jpeg', '0', 'jpg', 0),
(544, '784dell-755mtjpg', NULL, 'image', '/uploads/images/784dell-755mtjpg/', '\\images\\784dell-755mtjpg\\', '300x300', 300, 300, '784dell-755mtjpg', 'image/jpeg', '0', 'jpg', 0),
(545, '784dell-optiplex-760jpg', NULL, 'image', '/uploads/images/784dell-optiplex-760jpg/', '\\images\\784dell-optiplex-760jpg\\', '480x390', 480, 390, '784dell-optiplex-760jpg', 'image/jpeg', '0', 'jpg', 0),
(546, '782case-sp-6509jpg', NULL, 'image', '/uploads/images/782case-sp-6509jpg/', '\\images\\782case-sp-6509jpg\\', '373x588', 373, 588, '782case-sp-6509jpg', 'image/jpeg', '0', 'jpg', 0),
(547, '781dell2420vitinhgiatotjpg', NULL, 'image', '/uploads/images/781dell2420vitinhgiatotjpg/', '\\images\\781dell2420vitinhgiatotjpg\\', '780x568', 780, 568, '781dell2420vitinhgiatotjpg', 'image/jpeg', '0', 'jpg', 0),
(548, '781dell2420vitinhgiatot1jpg', NULL, 'image', '/uploads/images/781dell2420vitinhgiatot1jpg/', '\\images\\781dell2420vitinhgiatot1jpg\\', '278x181', 278, 181, '781dell2420vitinhgiatot1jpg', 'image/jpeg', '0', 'jpg', 0),
(549, '781dell2420vitinhgiatot2jpg', NULL, 'image', '/uploads/images/781dell2420vitinhgiatot2jpg/', '\\images\\781dell2420vitinhgiatot2jpg\\', '800x800', 800, 800, '781dell2420vitinhgiatot2jpg', 'image/jpeg', '0', 'jpg', 0),
(550, '781dell2420vitinhgiatot3jpg', NULL, 'image', '/uploads/images/781dell2420vitinhgiatot3jpg/', '\\images\\781dell2420vitinhgiatot3jpg\\', '470x470', 470, 470, '781dell2420vitinhgiatot3jpg', 'image/jpeg', '0', 'jpg', 0),
(551, '780201212130923178543jpg', NULL, 'image', '/uploads/images/780201212130923178543jpg/', '\\images\\780201212130923178543jpg\\', '1000x1000', 1000, 1000, '780201212130923178543jpg', 'image/jpeg', '0', 'jpg', 0),
(552, '780w311ma04jpg', NULL, 'image', '/uploads/images/780w311ma04jpg/', '\\images\\780w311ma04jpg\\', '755x708', 755, 708, '780w311ma04jpg', 'image/jpeg', '0', 'jpg', 0),
(553, '780w311ma-1jpg', NULL, 'image', '/uploads/images/780w311ma-1jpg/', '\\images\\780w311ma-1jpg\\', '600x600', 600, 600, '780w311ma-1jpg', 'image/jpeg', '0', 'jpg', 0),
(554, '7790jpg', NULL, 'image', '/uploads/images/7790jpg/', '\\images\\7790jpg\\', '480x360', 480, 360, '7790jpg', 'image/jpeg', '0', 'jpg', 0),
(555, '7793017799542c53e9f3c2eda5851f81277fa6792jpg', NULL, 'image', '/uploads/images/7793017799542c53e9f3c2eda5851f81277fa6792jpg/', '\\images\\7793017799542c53e9f3c2eda5851f81277fa6792jpg\\', '1600x1200', 1600, 1200, '7793017799542c53e9f3c2eda5851f81277fa6792jpg', 'image/jpeg', '0', 'jpg', 0),
(556, '779103334351102637888623940d4d061e4ec4318b7fff0af2b87ae7f292bjpg', NULL, 'image', '/uploads/images/779103334351102637888623940d4d061e4ec4318b7fff0af2b87ae7f292bjpg/', '\\images\\779103334351102637888623940d4d061e4ec4318b7fff0af2b87ae7f292bjpg\\', '800x600', 800, 600, '779103334351102637888623940d4d061e4ec4318b7fff0af2b87ae7f292bjpg', 'image/jpeg', '0', 'jpg', 0),
(557, '779105200969105118493018c09e620f8a0ac6b39c17112869d396a44566cjpg', NULL, 'image', '/uploads/images/779105200969105118493018c09e620f8a0ac6b39c17112869d396a44566cjpg/', '\\images\\779105200969105118493018c09e620f8a0ac6b39c17112869d396a44566cjpg\\', '500x333', 500, 333, '779105200969105118493018c09e620f8a0ac6b39c17112869d396a44566cjpg', 'image/jpeg', '0', 'jpg', 0),
(558, '7791313759795img6344jpg', NULL, 'image', '/uploads/images/7791313759795img6344jpg/', '\\images\\7791313759795img6344jpg\\', '1210x908', 1210, 908, '7791313759795img6344jpg', 'image/jpeg', '0', 'jpg', 0),
(559, '778adapter-asus-19v-474a-1jpg', NULL, 'image', '/uploads/images/778adapter-asus-19v-474a-1jpg/', '\\images\\778adapter-asus-19v-474a-1jpg\\', '500x500', 500, 500, '778adapter-asus-19v-474a-1jpg', 'image/jpeg', '0', 'jpg', 0),
(560, '778adapter-asus-19v-474a-2jpg', NULL, 'image', '/uploads/images/778adapter-asus-19v-474a-2jpg/', '\\images\\778adapter-asus-19v-474a-2jpg\\', '360x360', 360, 360, '778adapter-asus-19v-474a-2jpg', 'image/jpeg', '0', 'jpg', 0),
(561, '777adapter-laptop-toshiba-19v-474ajpg', NULL, 'image', '/uploads/images/777adapter-laptop-toshiba-19v-474ajpg/', '\\images\\777adapter-laptop-toshiba-19v-474ajpg\\', '453x340', 453, 340, '777adapter-laptop-toshiba-19v-474ajpg', 'image/jpeg', '0', 'jpg', 0),
(562, '776adapter-laptop-sony-19v-39ajpg', NULL, 'image', '/uploads/images/776adapter-laptop-sony-19v-39ajpg/', '\\images\\776adapter-laptop-sony-19v-39ajpg\\', '500x400', 500, 400, '776adapter-laptop-sony-19v-39ajpg', 'image/jpeg', '0', 'jpg', 0),
(563, '775adapter-laptop-hp-185v-35a-aau-vangjpg', NULL, 'image', '/uploads/images/775adapter-laptop-hp-185v-35a-aau-vangjpg/', '\\images\\775adapter-laptop-hp-185v-35a-aau-vangjpg\\', '400x300', 400, 300, '775adapter-laptop-hp-185v-35a-aau-vangjpg', 'image/jpeg', '0', 'jpg', 0),
(564, '774adapter-laptop-hp-19v-474ajpg', NULL, 'image', '/uploads/images/774adapter-laptop-hp-19v-474ajpg/', '\\images\\774adapter-laptop-hp-19v-474ajpg\\', '300x300', 300, 300, '774adapter-laptop-hp-19v-474ajpg', 'image/jpeg', '0', 'jpg', 0),
(565, '773adapter-laptop-lenovo-20v-325ajpg', NULL, 'image', '/uploads/images/773adapter-laptop-lenovo-20v-325ajpg/', '\\images\\773adapter-laptop-lenovo-20v-325ajpg\\', '282x282', 282, 282, '773adapter-laptop-lenovo-20v-325ajpg', 'image/jpeg', '0', 'jpg', 0),
(566, '772adapter-lenovo-20v-45ajpg', NULL, 'image', '/uploads/images/772adapter-lenovo-20v-45ajpg/', '\\images\\772adapter-lenovo-20v-45ajpg\\', '300x290', 300, 290, '772adapter-lenovo-20v-45ajpg', 'image/jpeg', '0', 'jpg', 0),
(567, '771adapter-laptop-acer-19v-342ajpg', NULL, 'image', '/uploads/images/771adapter-laptop-acer-19v-342ajpg/', '\\images\\771adapter-laptop-acer-19v-342ajpg\\', '400x300', 400, 300, '771adapter-laptop-acer-19v-342ajpg', 'image/jpeg', '0', 'jpg', 0),
(568, '768adapter-laptop-dell-195v-334ajpg', NULL, 'image', '/uploads/images/768adapter-laptop-dell-195v-334ajpg/', '\\images\\768adapter-laptop-dell-195v-334ajpg\\', '453x340', 453, 340, '768adapter-laptop-dell-195v-334ajpg', 'image/jpeg', '0', 'jpg', 0),
(569, '767dell-optiplex-760jpg', NULL, 'image', '/uploads/images/767dell-optiplex-760jpg/', '\\images\\767dell-optiplex-760jpg\\', '480x390', 480, 390, '767dell-optiplex-760jpg', 'image/jpeg', '0', 'jpg', 0),
(570, '767dell-optiplex-760mtjpg', NULL, 'image', '/uploads/images/767dell-optiplex-760mtjpg/', '\\images\\767dell-optiplex-760mtjpg\\', '600x600', 600, 600, '767dell-optiplex-760mtjpg', 'image/jpeg', '0', 'jpg', 0),
(571, '766genise-ns-6000jpg', NULL, 'image', '/uploads/images/766genise-ns-6000jpg/', '\\images\\766genise-ns-6000jpg\\', '300x300', 300, 300, '766genise-ns-6000jpg', 'image/jpeg', '0', 'jpg', 0),
(572, '764380sff-1jpg', NULL, 'image', '/uploads/images/764380sff-1jpg/', '\\images\\764380sff-1jpg\\', '300x487', 300, 487, '764380sff-1jpg', 'image/jpeg', '0', 'jpg', 0),
(573, '764t2ec16nhjh8e9qseu6hcbrpnuiktg601jpg', NULL, 'image', '/uploads/images/764t2ec16nhjh8e9qseu6hcbrpnuiktg601jpg/', '\\images\\764t2ec16nhjh8e9qseu6hcbrpnuiktg601jpg\\', '300x400', 300, 400, '764t2ec16nhjh8e9qseu6hcbrpnuiktg601jpg', 'image/jpeg', '0', 'jpg', 0),
(574, '764380sff2jpg', NULL, 'image', '/uploads/images/764380sff2jpg/', '\\images\\764380sff2jpg\\', '400x131', 400, 131, '764380sff2jpg', 'image/jpeg', '0', 'jpg', 0),
(575, '7641111jpg', NULL, 'image', '/uploads/images/7641111jpg/', '\\images\\7641111jpg\\', '250x250', 250, 250, '7641111jpg', 'image/jpeg', '0', 'jpg', 0),
(576, '7631-1jpg', NULL, 'image', '/uploads/images/7631-1jpg/', '\\images\\7631-1jpg\\', '475x425', 475, 425, '7631-1jpg', 'image/jpeg', '0', 'jpg', 0),
(577, '7632jpg', NULL, 'image', '/uploads/images/7632jpg/', '\\images\\7632jpg\\', '1264x1280', 1264, 1280, '7632jpg', 'image/jpeg', '0', 'jpg', 0),
(578, '763tl-wr841n80-p1jpg', NULL, 'image', '/uploads/images/763tl-wr841n80-p1jpg/', '\\images\\763tl-wr841n80-p1jpg\\', '1280x853', 1280, 853, '763tl-wr841n80-p1jpg', 'image/jpeg', '0', 'jpg', 0),
(579, '7626701139339jpg', NULL, 'image', '/uploads/images/7626701139339jpg/', '\\images\\7626701139339jpg\\', '800x600', 800, 600, '7626701139339jpg', 'image/jpeg', '0', 'jpg', 0),
(580, '762hp-elitebook-2540pjpg', NULL, 'image', '/uploads/images/762hp-elitebook-2540pjpg/', '\\images\\762hp-elitebook-2540pjpg\\', '550x413', 550, 413, '762hp-elitebook-2540pjpg', 'image/jpeg', '0', 'jpg', 0),
(581, '760dell-3460jpg', NULL, 'image', '/uploads/images/760dell-3460jpg/', '\\images\\760dell-3460jpg\\', '927x539', 927, 539, '760dell-3460jpg', 'image/jpeg', '0', 'jpg', 0),
(582, '760dell34602jpg', NULL, 'image', '/uploads/images/760dell34602jpg/', '\\images\\760dell34602jpg\\', '3009x1941', 3009, 1941, '760dell34602jpg', 'image/jpeg', '0', 'jpg', 0),
(583, '759755-84001-1jpg', NULL, 'image', '/uploads/images/759755-84001-1jpg/', '\\images\\759755-84001-1jpg\\', '480x390', 480, 390, '759755-84001-1jpg', 'image/jpeg', '0', 'jpg', 0),
(584, '759755-e84003jpg', NULL, 'image', '/uploads/images/759755-e84003jpg/', '\\images\\759755-e84003jpg\\', '480x390', 480, 390, '759755-e84003jpg', 'image/jpeg', '0', 'jpg', 0),
(585, '759dell-755mtjpg', NULL, 'image', '/uploads/images/759dell-755mtjpg/', '\\images\\759dell-755mtjpg\\', '300x300', 300, 300, '759dell-755mtjpg', 'image/jpeg', '0', 'jpg', 0),
(586, '759dell-optiplex-755mt-2jpg', NULL, 'image', '/uploads/images/759dell-optiplex-755mt-2jpg/', '\\images\\759dell-optiplex-755mt-2jpg\\', '480x390', 480, 390, '759dell-optiplex-755mt-2jpg', 'image/jpeg', '0', 'jpg', 0),
(587, '757755-84001-1jpg', NULL, 'image', '/uploads/images/757755-84001-1jpg/', '\\images\\757755-84001-1jpg\\', '480x390', 480, 390, '757755-84001-1jpg', 'image/jpeg', '0', 'jpg', 0),
(588, '757755-e84003jpg', NULL, 'image', '/uploads/images/757755-e84003jpg/', '\\images\\757755-e84003jpg\\', '480x390', 480, 390, '757755-e84003jpg', 'image/jpeg', '0', 'jpg', 0),
(589, '757dell-755mtjpg', NULL, 'image', '/uploads/images/757dell-755mtjpg/', '\\images\\757dell-755mtjpg\\', '300x300', 300, 300, '757dell-755mtjpg', 'image/jpeg', '0', 'jpg', 0),
(590, '757dell-optiplex-755mt-2jpg', NULL, 'image', '/uploads/images/757dell-optiplex-755mt-2jpg/', '\\images\\757dell-optiplex-755mt-2jpg\\', '480x390', 480, 390, '757dell-optiplex-755mt-2jpg', 'image/jpeg', '0', 'jpg', 0),
(591, '752755-e84003jpg', NULL, 'image', '/uploads/images/752755-e84003jpg/', '\\images\\752755-e84003jpg\\', '480x390', 480, 390, '752755-e84003jpg', 'image/jpeg', '0', 'jpg', 0),
(592, '752dell-optiplex-755mt-2jpg', NULL, 'image', '/uploads/images/752dell-optiplex-755mt-2jpg/', '\\images\\752dell-optiplex-755mt-2jpg\\', '480x390', 480, 390, '752dell-optiplex-755mt-2jpg', 'image/jpeg', '0', 'jpg', 0),
(593, '752744dell-755mtjpg', NULL, 'image', '/uploads/images/752744dell-755mtjpg/', '\\images\\752744dell-755mtjpg\\', '300x300', 300, 300, '752744dell-755mtjpg', 'image/jpeg', '0', 'jpg', 0),
(594, '752755-84001-1jpg', NULL, 'image', '/uploads/images/752755-84001-1jpg/', '\\images\\752755-84001-1jpg\\', '480x390', 480, 390, '752755-84001-1jpg', 'image/jpeg', '0', 'jpg', 0),
(595, '750tl-wr740njpg', NULL, 'image', '/uploads/images/750tl-wr740njpg/', '\\images\\750tl-wr740njpg\\', '300x300', 300, 300, '750tl-wr740njpg', 'image/jpeg', '0', 'jpg', 0),
(596, '750tplinkjpg', NULL, 'image', '/uploads/images/750tplinkjpg/', '\\images\\750tplinkjpg\\', '154x160', 154, 160, '750tplinkjpg', 'image/jpeg', '0', 'jpg', 0),
(597, '749dell-optiplex-755sff-1jpg', NULL, 'image', '/uploads/images/749dell-optiplex-755sff-1jpg/', '\\images\\749dell-optiplex-755sff-1jpg\\', '500x500', 500, 500, '749dell-optiplex-755sff-1jpg', 'image/jpeg', '0', 'jpg', 0),
(598, '749gx755sffjpg', NULL, 'image', '/uploads/images/749gx755sffjpg/', '\\images\\749gx755sffjpg\\', '1600x1600', 1600, 1600, '749gx755sffjpg', 'image/jpeg', '0', 'jpg', 0),
(599, '749optiplex-745sffjpg', NULL, 'image', '/uploads/images/749optiplex-745sffjpg/', '\\images\\749optiplex-745sffjpg\\', '500x500', 500, 500, '749optiplex-745sffjpg', 'image/jpeg', '0', 'jpg', 0),
(600, '748epsonjpg', NULL, 'image', '/uploads/images/748epsonjpg/', '\\images\\748epsonjpg\\', '300x300', 300, 300, '748epsonjpg', 'image/jpeg', '0', 'jpg', 0),
(601, '747vi-tinh-duy-tanjpg', NULL, 'image', '/uploads/images/747vi-tinh-duy-tanjpg/', '\\images\\747vi-tinh-duy-tanjpg\\', '2717x2245', 2717, 2245, '747vi-tinh-duy-tanjpg', 'image/jpeg', '0', 'jpg', 0),
(602, '746cay-paletpng', NULL, 'image', '/uploads/images/746cay-paletpng/', '\\images\\746cay-paletpng\\', '500x676', 500, 676, '746cay-paletpng', 'image/png', '0', 'png', 0),
(603, '745lenovo-6088-a2jjpg', NULL, 'image', '/uploads/images/745lenovo-6088-a2jjpg/', '\\images\\745lenovo-6088-a2jjpg\\', '500x500', 500, 500, '745lenovo-6088-a2jjpg', 'image/jpeg', '0', 'jpg', 0),
(604, '744dell-755tled-3jpg', NULL, 'image', '/uploads/images/744dell-755tled-3jpg/', '\\images\\744dell-755tled-3jpg\\', '480x390', 480, 390, '744dell-755tled-3jpg', 'image/jpeg', '0', 'jpg', 0),
(605, '744dellop755jpg', NULL, 'image', '/uploads/images/744dellop755jpg/', '\\images\\744dellop755jpg\\', '276x182', 276, 182, '744dellop755jpg', 'image/jpeg', '0', 'jpg', 0),
(606, '744dell-755mtjpg', NULL, 'image', '/uploads/images/744dell-755mtjpg/', '\\images\\744dell-755mtjpg\\', '300x300', 300, 300, '744dell-755mtjpg', 'image/jpeg', '0', 'jpg', 0),
(607, '744dell-755-mt-1jpg', NULL, 'image', '/uploads/images/744dell-755-mt-1jpg/', '\\images\\744dell-755-mt-1jpg\\', '480x390', 480, 390, '744dell-755-mt-1jpg', 'image/jpeg', '0', 'jpg', 0),
(608, '741111jpg', NULL, 'image', '/uploads/images/741111jpg/', '\\images\\741111jpg\\', '160x130', 160, 130, '741111jpg', 'image/jpeg', '0', 'jpg', 0),
(609, '741rdt201ljpg', NULL, 'image', '/uploads/images/741rdt201ljpg/', '\\images\\741rdt201ljpg\\', '240x240', 240, 240, '741rdt201ljpg', 'image/jpeg', '0', 'jpg', 0),
(610, '741untitled-1jpg', NULL, 'image', '/uploads/images/741untitled-1jpg/', '\\images\\741untitled-1jpg\\', '160x130', 160, 130, '741untitled-1jpg', 'image/jpeg', '0', 'jpg', 0),
(611, '739keocpu1jpg', NULL, 'image', '/uploads/images/739keocpu1jpg/', '\\images\\739keocpu1jpg\\', '558x431', 558, 431, '739keocpu1jpg', 'image/jpeg', '0', 'jpg', 0),
(612, '738sa-day-ratjpg', NULL, 'image', '/uploads/images/738sa-day-ratjpg/', '\\images\\738sa-day-ratjpg\\', '336x367', 336, 367, '738sa-day-ratjpg', 'image/jpeg', '0', 'jpg', 0),
(613, '738su-day-rut-denjpg', NULL, 'image', '/uploads/images/738su-day-rut-denjpg/', '\\images\\738su-day-rut-denjpg\\', '440x285', 440, 285, '738su-day-rut-denjpg', 'image/jpeg', '0', 'jpg', 0);
INSERT INTO `tbl_file` (`id`, `name`, `caption`, `media`, `show_url`, `directory`, `dimension`, `width`, `height`, `file_name`, `file_type`, `file_size`, `file_ext`, `deleted`) VALUES
(614, '7371jpg', NULL, 'image', '/uploads/images/7371jpg/', '\\images\\7371jpg\\', '500x500', 500, 500, '7371jpg', 'image/jpeg', '0', 'jpg', 0),
(615, '736kb-110-usbjpg', NULL, 'image', '/uploads/images/736kb-110-usbjpg/', '\\images\\736kb-110-usbjpg\\', '1280x731', 1280, 731, '736kb-110-usbjpg', 'image/jpeg', '0', 'jpg', 0),
(616, '735nguan-spjpg', NULL, 'image', '/uploads/images/735nguan-spjpg/', '\\images\\735nguan-spjpg\\', '1594x1594', 1594, 1594, '735nguan-spjpg', 'image/jpeg', '0', 'jpg', 0),
(617, '7336508jpg', NULL, 'image', '/uploads/images/7336508jpg/', '\\images\\7336508jpg\\', '300x200', 300, 200, '7336508jpg', 'image/jpeg', '0', 'jpg', 0),
(618, '7327511jpg', NULL, 'image', '/uploads/images/7327511jpg/', '\\images\\7327511jpg\\', '300x200', 300, 200, '7327511jpg', 'image/jpeg', '0', 'jpg', 0),
(619, '729untitled-1jpg', NULL, 'image', '/uploads/images/729untitled-1jpg/', '\\images\\729untitled-1jpg\\', '300x200', 300, 200, '729untitled-1jpg', 'image/jpeg', '0', 'jpg', 0),
(620, '728tenda-w311r-1jpg', NULL, 'image', '/uploads/images/728tenda-w311r-1jpg/', '\\images\\728tenda-w311r-1jpg\\', '574x431', 574, 431, '728tenda-w311r-1jpg', 'image/jpeg', '0', 'jpg', 0),
(621, '728tenda-w311r-2jpg', NULL, 'image', '/uploads/images/728tenda-w311r-2jpg/', '\\images\\728tenda-w311r-2jpg\\', '593x544', 593, 544, '728tenda-w311r-2jpg', 'image/jpeg', '0', 'jpg', 0),
(622, '728thiet-bi-phat-wifi-tendajpg', NULL, 'image', '/uploads/images/728thiet-bi-phat-wifi-tendajpg/', '\\images\\728thiet-bi-phat-wifi-tendajpg\\', '640x480', 640, 480, '728thiet-bi-phat-wifi-tendajpg', 'image/jpeg', '0', 'jpg', 0),
(623, 'newss12jpg', NULL, 'image', '/uploads/images/newss12jpg/', '\\images\\newss12jpg\\', '225x225', 225, 225, 'newss12jpg', 'image/jpeg', '0', 'jpg', 0),
(624, 'newss9jpg', NULL, 'image', '/uploads/images/newss9jpg/', '\\images\\newss9jpg\\', '259x194', 259, 194, 'newss9jpg', 'image/jpeg', '0', 'jpg', 0),
(625, 'newss10jpg', NULL, 'image', '/uploads/images/newss10jpg/', '\\images\\newss10jpg\\', '300x225', 300, 225, 'newss10jpg', 'image/jpeg', '0', 'jpg', 0),
(626, '123jpg', NULL, 'image', '/uploads/images/123jpg/', '\\images\\123jpg\\', '480x390', 480, 390, '123jpg', 'image/jpeg', '0', 'jpg', 0),
(627, '123jpg-2', NULL, 'image', '/uploads/images/123jpg-2/', '\\images\\123jpg-2\\', '480x390', 480, 390, '123jpg-2', 'image/jpeg', '0', 'jpg', 0),
(628, '123jpg-3', NULL, 'image', '/uploads/images/123jpg-3/', '\\images\\123jpg-3\\', '480x390', 480, 390, '123jpg-3', 'image/jpeg', '0', 'jpg', 0),
(629, '874hp-8100-i3-elitejpg-2', NULL, 'image', '/uploads/images/874hp-8100-i3-elitejpg-2/', '\\images\\874hp-8100-i3-elitejpg-2\\', '480x390', 480, 390, '874hp-8100-i3-elitejpg-2', 'image/jpeg', '0', 'jpg', 0),
(630, '875hp-8100-elite-i5-hot-1jpg-2', NULL, 'image', '/uploads/images/875hp-8100-elite-i5-hot-1jpg-2/', '\\images\\875hp-8100-elite-i5-hot-1jpg-2\\', '480x390', 480, 390, '875hp-8100-elite-i5-hot-1jpg-2', 'image/jpeg', '0', 'jpg', 0),
(631, 'dell-0-i3jpg', NULL, 'image', '/uploads/images/dell-0-i3jpg/', '\\images\\dell-0-i3jpg\\', '800x800', 800, 800, 'dell-0-i3jpg', 'image/jpeg', '0', 'jpg', 0),
(632, '1397275025jpg', NULL, 'image', '/uploads/images/1397275025jpg/', '\\images\\1397275025jpg\\', '500x374', 500, 374, '1397275025jpg', 'image/jpeg', '0', 'jpg', 0),
(634, 'precision-t1500jpg', NULL, 'image', '/uploads/images/precision-t1500jpg/', '\\images\\precision-t1500jpg\\', '362x364', 362, 364, 'precision-t1500jpg', 'image/jpeg', '0', 'jpg', 0),
(636, 'precision-t1500jpg-2', NULL, 'image', '/uploads/images/precision-t1500jpg-2/', '\\images\\precision-t1500jpg-2\\', '362x364', 362, 364, 'precision-t1500jpg-2', 'image/jpeg', '0', 'jpg', 0),
(638, '1397275025jpg-2', NULL, 'image', '/uploads/images/1397275025jpg-2/', '\\images\\1397275025jpg-2\\', '500x374', 500, 374, '1397275025jpg-2', 'image/jpeg', '0', 'jpg', 0),
(639, 'leu-du-lich-2-nguoi-lt01-xdjpg-10154503040216jpg', NULL, 'image', '/uploads/images/leu-du-lich-2-nguoi-lt01-xdjpg-10154503040216jpg/', '\\images\\leu-du-lich-2-nguoi-lt01-xdjpg-10154503040216jpg\\', '500x400', 500, 400, 'leu-du-lich-2-nguoi-lt01-xdjpg-10154503040216jpg', 'image/jpeg', '0', 'jpg', 0),
(640, 'leu-6-10-nguoi-outwelljpg', NULL, 'image', '/uploads/images/leu-6-10-nguoi-outwelljpg/', '\\images\\leu-6-10-nguoi-outwelljpg\\', '1280x720', 1280, 720, 'leu-6-10-nguoi-outwelljpg', 'image/jpeg', '0', 'jpg', 0),
(641, 'balo-chong-nuoc-superdry-den-backpackjpg-09593695110915jpg', NULL, 'image', '/uploads/images/balo-chong-nuoc-superdry-den-backpackjpg-09593695110915jpg/', '\\images\\balo-chong-nuoc-superdry-den-backpackjpg-09593695110915jpg\\', '500x400', 500, 400, 'balo-chong-nuoc-superdry-den-backpackjpg-09593695110915jpg', 'image/jpeg', '0', 'jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE IF NOT EXISTS `tbl_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `slug` varchar(128) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `description` text,
  `general` text,
  `info_tech` text,
  `price_init` decimal(10,0) NOT NULL DEFAULT '0',
  `price` decimal(10,0) NOT NULL DEFAULT '0',
  `discount` decimal(10,0) DEFAULT '0',
  `price_string` text NOT NULL,
  `is_hot` tinyint(1) NOT NULL DEFAULT '0',
  `is_discount` tinyint(1) NOT NULL DEFAULT '0',
  `viewed` int(11) DEFAULT NULL,
  `status` enum('draft','waiting','instock') DEFAULT NULL,
  `seo_title` varchar(256) DEFAULT NULL,
  `seo_keyword` varchar(512) DEFAULT NULL,
  `seo_description` varchar(512) DEFAULT NULL,
  `published_date` int(10) NOT NULL DEFAULT '0',
  `updated_date` int(10) NOT NULL DEFAULT '0',
  `created_date` int(10) NOT NULL DEFAULT '0',
  `created_by` varchar(32) NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '1',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=921 ;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`id`, `name`, `slug`, `image_id`, `description`, `general`, `info_tech`, `price_init`, `price`, `discount`, `price_string`, `is_hot`, `is_discount`, `viewed`, `status`, `seo_title`, `seo_keyword`, `seo_description`, `published_date`, `updated_date`, `created_date`, `created_by`, `activated`, `deleted`) VALUES
(918, 'Lều Ereka 2 người', 'leu-ereka-2-nguoi', 639, '', '<p>-Xuất xứ: H&agrave;ng Việt Nam</p>\r\n\r\n<p>-Bả</p>\r\n\r\n<p>-Vải lều: Vải Polyeste tr&aacute;ng bạc, độ&nbsp;d&agrave;y vải 190t, độ chống&nbsp;nước pu= 1000mm, chống được sương v&agrave; mưa nhỏ<br />\r\n-Khung lều: đường k&iacute;nh 7.9mm, sợi cacbon fiber glass li&ecirc;n kết rỗng , độ cứng v&agrave; đ&agrave;n hồi W=4.5<br />\r\n-SIZE: cao 1.2m; d&agrave;i 2.0m; rộng 1.25m<br />\r\n-Khối lượng: 1.4kg<br />\r\n&ndash; Số cửa: 01 cửa<br />\r\n-M&ocirc; tả th&ecirc;m: Đỉnh lều c&oacute;phần&nbsp;th&ocirc;ng gi&oacute;. Cửa ra v&agrave;o c&oacute; 2 lớp v&agrave; c&oacute; m&agrave;n chống muỗi.<br />\r\n&ndash;&nbsp;Th&iacute;ch hợp cho c&aacute;c chuyến du lịch ngắn ng&agrave;y v&agrave; kh&ocirc;ng thường xuy&ecirc;n</p>\r\n\r\n<p>Made in: Việt Nam<br />\r\nBảo h&agrave;nh:&nbsp;12 th&aacute;ng, ri&ecirc;ng khung lều BH vĩnh viễn</p>\r\n', '', '0', '550000', '0', '{"month3":{"current":"550.000đ","old":"0đ"},"month12":{"current":"0đ","old":"0đ"}}', 0, 0, NULL, 'instock', '', '', '', 1476936109, 0, 1476936012, 'admin', 1, 0),
(919, 'Lều 2 người 2 lớp Eureka Apex 2xt (Loại II)', 'leu-2-nguoi-2-lop-eureka-apex-2xt-loai-ii', 640, '', '<p>&nbsp;</p>\r\n\r\n<p>Lều 2 người 2 lớp Eureka Apex 2xt (Loại II)<br />\r\n-Vải lều: Vải 100% Polyester , độ d&agrave;y vải 190T, độ chống nước&nbsp;pu= 1500mm-2000mm, chống được mưa tương đối trong điều kiện c&oacute; gi&oacute;<br />\r\n-Khung lều: đường k&iacute;nh khung 8.5mm, sợi cacbon fiber glass li&ecirc;n kết rỗng, độ cứng v&agrave; độ đ&agrave;n hồi chống g&atilde;y W=&nbsp;5.5<br />\r\n-SIZE: cao 1.4m; d&agrave;i 2.1m; rộng 1.4m<br />\r\n-Khối lượng: 2.5kg<br />\r\n&ndash; Số cửa: 02&nbsp;cửa<br />\r\n-M&ocirc; tả th&ecirc;m: Đường chỉ may được &eacute;p keo chống thấm. Đỉnh lều c&oacute; phần th&ocirc;ng gi&oacute;. Cửa ra v&agrave;o c&oacute; 2 lớp v&agrave; c&oacute; m&agrave;n chống muỗi.<br />\r\n-Th&iacute;ch hợp cho c&aacute;c chuyến du lịch ngắn ng&agrave;y&nbsp;v&agrave; kh&ocirc;ng thường xuy&ecirc;n</p>\r\n\r\n<p>Made in: Việt Nam</p>\r\n\r\n<p>Bảo h&agrave;nh:&nbsp;12 th&aacute;ng, ri&ecirc;ng khung lều BH vĩnh viễn</p>\r\n', '', '0', '0', '0', '{"month3":{"current":"0đ","old":"0đ"},"month12":{"current":"0đ","old":"0đ"}}', 0, 0, NULL, 'instock', '', '', '', 1476936301, 0, 1476936273, 'admin', 1, 0),
(920, 'Balo chống nước Superdry- Đen', 'balo-chong-nuoc-superdry-den', 641, '', '', '', '0', '450000', '0', '{"month3":{"current":"450.000đ","old":"0đ"},"month12":{"current":"0đ","old":"0đ"}}', 0, 0, NULL, 'instock', '', '', '', 1476936518, 0, 1476936400, 'admin', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_category`
--

CREATE TABLE IF NOT EXISTS `tbl_product_category` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_id`,`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_product_category`
--

INSERT INTO `tbl_product_category` (`product_id`, `category_id`, `deleted`) VALUES
(728, 271, 0),
(744, 261, 0),
(744, 297, 0),
(749, 297, 0),
(750, 239, 0),
(752, 261, 0),
(752, 297, 0),
(757, 261, 0),
(757, 297, 0),
(759, 261, 0),
(759, 297, 0),
(760, 230, 0),
(762, 230, 0),
(763, 271, 0),
(764, 261, 0),
(767, 298, 0),
(779, 230, 0),
(780, 272, 0),
(781, 230, 0),
(784, 298, 0),
(785, 297, 0),
(786, 261, 0),
(786, 297, 0),
(787, 297, 0),
(788, 297, 0),
(789, 297, 0),
(800, 233, 0),
(801, 261, 0),
(802, 261, 0),
(803, 261, 0),
(804, 233, 0),
(805, 302, 0),
(807, 293, 0),
(808, 293, 0),
(809, 307, 0),
(810, 295, 0),
(811, 295, 0),
(812, 230, 0),
(813, 230, 0),
(814, 307, 0),
(815, 307, 0),
(816, 307, 0),
(817, 307, 0),
(818, 233, 0),
(819, 261, 0),
(820, 307, 0),
(821, 233, 0),
(822, 233, 0),
(823, 293, 0),
(824, 261, 0),
(825, 307, 0),
(826, 280, 0),
(827, 280, 0),
(829, 307, 0),
(830, 261, 0),
(831, 233, 0),
(832, 296, 0),
(833, 296, 0),
(834, 233, 0),
(835, 262, 0),
(835, 292, 0),
(836, 262, 0),
(836, 292, 0),
(837, 296, 0),
(838, 302, 0),
(839, 302, 0),
(840, 302, 0),
(841, 302, 0),
(842, 302, 0),
(843, 302, 0),
(844, 302, 0),
(845, 280, 0),
(846, 280, 0),
(847, 280, 0),
(848, 280, 0),
(849, 280, 0),
(850, 295, 0),
(851, 295, 0),
(852, 307, 0),
(853, 307, 0),
(854, 307, 0),
(855, 307, 0),
(856, 282, 0),
(857, 282, 0),
(858, 282, 0),
(859, 284, 0),
(860, 284, 0),
(861, 284, 0),
(862, 284, 0),
(863, 284, 0),
(864, 284, 0),
(865, 301, 0),
(866, 301, 0),
(867, 299, 0),
(868, 299, 0),
(869, 261, 0),
(870, 313, 0),
(871, 307, 0),
(872, 307, 0),
(873, 307, 0),
(874, 285, 0),
(875, 302, 0),
(876, 302, 0),
(877, 307, 0),
(878, 307, 0),
(879, 307, 0),
(880, 307, 0),
(881, 298, 0),
(882, 298, 0),
(883, 261, 0),
(884, 261, 0),
(885, 300, 0),
(886, 300, 0),
(887, 300, 0),
(888, 261, 0),
(889, 233, 0),
(890, 233, 0),
(891, 302, 0),
(892, 302, 0),
(893, 307, 0),
(894, 292, 0),
(895, 292, 0),
(896, 307, 0),
(897, 307, 0),
(898, 285, 0),
(899, 285, 0),
(900, 285, 0),
(901, 304, 0),
(902, 304, 0),
(903, 230, 0),
(904, 261, 0),
(904, 300, 0),
(904, 310, 0),
(904, 311, 0),
(905, 261, 0),
(905, 300, 0),
(905, 310, 0),
(905, 312, 0),
(906, 262, 0),
(906, 294, 0),
(907, 262, 0),
(907, 294, 0),
(908, 294, 0),
(909, 294, 0),
(910, 299, 0),
(911, 299, 0),
(912, 299, 0),
(913, 262, 0),
(913, 310, 0),
(913, 314, 0),
(914, 262, 0),
(914, 310, 0),
(914, 314, 0),
(915, 261, 0),
(915, 310, 0),
(915, 311, 0),
(916, 261, 0),
(916, 285, 0),
(916, 310, 0),
(916, 313, 0),
(917, 261, 0),
(917, 285, 0),
(917, 310, 0),
(917, 311, 0),
(918, 318, 0),
(919, 318, 0),
(920, 323, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_file`
--

CREATE TABLE IF NOT EXISTS `tbl_product_file` (
  `product_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_id`,`file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_product_file`
--

INSERT INTO `tbl_product_file` (`product_id`, `file_id`, `deleted`) VALUES
(728, 620, 0),
(728, 621, 0),
(728, 622, 0),
(729, 619, 0),
(732, 618, 0),
(733, 617, 0),
(735, 616, 0),
(736, 615, 0),
(737, 614, 0),
(738, 612, 0),
(738, 613, 0),
(739, 611, 0),
(741, 608, 0),
(741, 609, 0),
(741, 610, 0),
(744, 604, 0),
(744, 605, 0),
(744, 606, 0),
(744, 607, 0),
(745, 603, 0),
(746, 602, 0),
(747, 601, 0),
(748, 600, 0),
(749, 597, 0),
(749, 598, 0),
(749, 599, 0),
(750, 595, 0),
(750, 596, 0),
(752, 591, 0),
(752, 592, 0),
(752, 593, 0),
(752, 594, 0),
(757, 587, 0),
(757, 588, 0),
(757, 589, 0),
(757, 590, 0),
(759, 583, 0),
(759, 584, 0),
(759, 585, 0),
(759, 586, 0),
(760, 581, 0),
(760, 582, 0),
(762, 579, 0),
(762, 580, 0),
(763, 576, 0),
(763, 577, 0),
(763, 578, 0),
(764, 572, 0),
(764, 573, 0),
(764, 574, 0),
(764, 575, 0),
(766, 571, 0),
(767, 569, 0),
(767, 570, 0),
(768, 568, 0),
(771, 567, 0),
(772, 566, 0),
(773, 565, 0),
(774, 564, 0),
(775, 563, 0),
(776, 562, 0),
(777, 561, 0),
(778, 559, 0),
(778, 560, 0),
(779, 554, 0),
(779, 555, 0),
(779, 556, 0),
(779, 557, 0),
(779, 558, 0),
(780, 551, 0),
(780, 552, 0),
(780, 553, 0),
(781, 547, 0),
(781, 548, 0),
(781, 549, 0),
(781, 550, 0),
(782, 546, 0),
(784, 544, 0),
(784, 545, 0),
(785, 543, 0),
(786, 542, 0),
(787, 540, 0),
(787, 541, 0),
(788, 538, 0),
(788, 539, 0),
(789, 536, 0),
(789, 537, 0),
(800, 534, 0),
(800, 535, 0),
(801, 533, 0),
(802, 532, 0),
(803, 530, 0),
(803, 531, 0),
(804, 529, 0),
(805, 527, 0),
(805, 528, 0),
(807, 526, 0),
(808, 525, 0),
(809, 524, 0),
(810, 520, 0),
(810, 521, 0),
(810, 522, 0),
(810, 523, 0),
(811, 518, 0),
(811, 519, 0),
(812, 517, 0),
(813, 512, 0),
(813, 513, 0),
(813, 514, 0),
(813, 515, 0),
(814, 511, 0),
(815, 510, 0),
(816, 509, 0),
(817, 508, 0),
(818, 507, 0),
(819, 506, 0),
(820, 505, 0),
(821, 504, 0),
(822, 503, 0),
(823, 502, 0),
(824, 501, 0),
(825, 500, 0),
(826, 498, 0),
(826, 499, 0),
(827, 496, 0),
(827, 497, 0),
(829, 494, 0),
(829, 495, 0),
(830, 492, 0),
(830, 493, 0),
(831, 490, 0),
(831, 491, 0),
(832, 488, 0),
(832, 489, 0),
(833, 485, 0),
(833, 486, 0),
(833, 487, 0),
(834, 483, 0),
(834, 484, 0),
(835, 480, 0),
(835, 481, 0),
(835, 482, 0),
(836, 477, 0),
(836, 478, 0),
(836, 479, 0),
(837, 476, 0),
(838, 475, 0),
(839, 471, 0),
(839, 472, 0),
(839, 473, 0),
(839, 474, 0),
(840, 470, 0),
(841, 469, 0),
(842, 467, 0),
(843, 465, 0),
(843, 466, 0),
(844, 463, 0),
(844, 464, 0),
(845, 462, 0),
(846, 461, 0),
(847, 460, 0),
(848, 459, 0),
(849, 458, 0),
(850, 456, 0),
(851, 455, 0),
(852, 453, 0),
(853, 454, 0),
(854, 450, 0),
(855, 449, 0),
(856, 446, 0),
(856, 447, 0),
(856, 448, 0),
(857, 445, 0),
(858, 444, 0),
(859, 443, 0),
(860, 441, 0),
(861, 440, 0),
(862, 439, 0),
(863, 438, 0),
(864, 437, 0),
(865, 433, 0),
(865, 434, 0),
(865, 435, 0),
(865, 436, 0),
(866, 429, 0),
(866, 430, 0),
(866, 431, 0),
(866, 432, 0),
(867, 427, 0),
(867, 428, 0),
(868, 425, 0),
(868, 426, 0),
(869, 422, 0),
(869, 423, 0),
(869, 424, 0),
(870, 419, 0),
(870, 420, 0),
(870, 421, 0),
(871, 416, 0),
(871, 417, 0),
(871, 418, 0),
(872, 414, 0),
(872, 415, 0),
(873, 412, 0),
(873, 413, 0),
(874, 409, 0),
(874, 410, 0),
(874, 411, 0),
(875, 407, 0),
(875, 408, 0),
(876, 402, 0),
(876, 403, 0),
(876, 404, 0),
(876, 405, 0),
(876, 406, 0),
(877, 401, 0),
(878, 400, 0),
(879, 399, 0),
(880, 398, 0),
(881, 396, 0),
(881, 397, 0),
(882, 394, 0),
(882, 395, 0),
(883, 392, 0),
(883, 393, 0),
(884, 391, 0),
(885, 390, 0),
(886, 389, 0),
(887, 388, 0),
(888, 387, 0),
(889, 386, 0),
(890, 385, 0),
(891, 382, 0),
(891, 383, 0),
(891, 384, 0),
(892, 379, 0),
(892, 380, 0),
(892, 381, 0),
(893, 378, 0),
(894, 377, 0),
(895, 376, 0),
(896, 375, 0),
(897, 374, 0),
(898, 372, 0),
(898, 373, 0),
(899, 369, 0),
(899, 370, 0),
(899, 371, 0),
(900, 368, 0),
(901, 366, 0),
(901, 367, 0),
(902, 364, 0),
(902, 365, 0),
(903, 361, 0),
(903, 362, 0),
(903, 363, 0),
(904, 360, 0),
(905, 359, 0),
(906, 358, 0),
(907, 357, 0),
(908, 356, 0),
(909, 355, 0),
(910, 626, 0),
(911, 627, 0),
(912, 628, 0),
(913, 629, 0),
(914, 630, 0),
(915, 631, 0),
(916, 632, 0),
(916, 634, 0),
(917, 636, 0),
(917, 638, 0),
(918, 639, 0),
(919, 640, 0),
(920, 641, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_related`
--

CREATE TABLE IF NOT EXISTS `tbl_product_related` (
  `product_id` int(11) NOT NULL,
  `related_id` int(11) NOT NULL,
  `sorting` int(11) DEFAULT '0',
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`product_id`,`related_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_product_related`
--

INSERT INTO `tbl_product_related` (`product_id`, `related_id`, `sorting`, `deleted`) VALUES
(917, 904, 0, 0),
(917, 905, 1, 0),
(917, 913, 4, 0),
(917, 914, 3, 0),
(917, 915, 2, 0),
(917, 916, 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_tag`
--

CREATE TABLE IF NOT EXISTS `tbl_product_tag` (
  `product_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_id`,`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_product_tag`
--

INSERT INTO `tbl_product_tag` (`product_id`, `tag_id`, `deleted`) VALUES
(867, 22, 0),
(867, 26, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tag`
--

CREATE TABLE IF NOT EXISTS `tbl_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `slug` varchar(128) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `tbl_tag`
--

INSERT INTO `tbl_tag` (`id`, `name`, `slug`, `deleted`) VALUES
(16, 'máy bộ hp', 'may-bo-hp', 0),
(17, 'máy tính để bàn hp', 'may-tinh-de-ban-hp', 0),
(18, 'máy tính để bàn', 'may-tinh-de-ban', 0),
(19, 'may bo hp', 'may-bo-hp1', 0),
(20, 'may bo hp gia re', 'may-bo-hp-gia-re', 0),
(21, 'may tinh de ban gia re', 'may-tinh-de-ban-gia-re', 0),
(22, 'máy bộ dell', 'may-bo-dell', 0),
(23, 'máy tính để bàn dell', 'may-tinh-de-ban-dell', 0),
(24, 'máy tính dell giá rẻ', 'may-tinh-dell-gia-re', 0),
(25, 'máy tính dell cũ', 'may-tinh-dell-cu', 0),
(26, 'may tinh de ban dell ', 'may-tinh-de-ban-dell-', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `full_name` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_activation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=95 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `full_name`, `email`, `password_hash`, `status`, `auth_key`, `password_reset_token`, `account_activation_token`, `created_at`, `updated_at`) VALUES
(87, 'mantran', NULL, 'tranduyminhman@gmail.com', '$2y$13$dOvblqIHLXoUXUfsTJeW5.ANNqXPuAgB0Rh0OFtkQm00kuSic/oUG', 10, 'mxHNRKro_qwyQ1j8purisSFeAPDwR0EZ', NULL, NULL, 1427867082, 1445228808),
(88, 'admin', 'Administator', 'man.tran@axonactive.vn', '$2y$13$pOo2.QX2L0wIEA2MDrvUuuKqbuGAciRMZcDU8Wn2aoErErTfj4RV.', 10, 'LUgN3Apv1cflayw6gtG6DqphRJdCS-Ow', NULL, NULL, 1428218361, 1446474271),
(89, '0909123456', 'Hùng Sùi', 'quocnam@gmail.com', '$2y$13$FK/pYH2vON1QkTRSeBp0HeH9dQq1aPsSQXcqu9zGU3ujV8esKZtz.', 10, 'Wyjq9gZYwDLfw65YN2MhZfLBniEHEmb-', NULL, NULL, 1444900043, 1446475417),
(90, '0908036105', 'Man Tran', 'tranman@cungmua.com', '$2y$13$NT0r56AIQaGu1kwAdpV4mOjSFBWD6qOdWxpDxmjao73Ealf5cF2m6', 10, '2XXbf26q6nR2zazWmt-UtsbCY4_NP7Ym', NULL, NULL, 1445323465, 1446474362),
(91, '0908070605', 'Thảo Điền', 'minhman@cungmua.com', '$2y$13$qqU9lUEGiv8WHf0sPbYGUOq8OdlJTZv8oFx14QwPuYshVrt2CxqtO', 10, 'Ss8gKZKX_JIzr2Oh6vy4lABxKzeru1NF', NULL, NULL, 1445324643, 1446474391),
(92, '0905030407', 'Tuấn Hưng', 'duyminh@gmail.com', '$2y$13$G9zbh7/TJeNG/Hrvx7b3Mu9PRehK4.zcj5jUrG3euxQkg3knwLigm', 10, 'v_JpZjOzmSriYpDUseGyKPzuo0WEe7Js', NULL, NULL, 1445336337, 1446474436),
(93, '01260490394', 'Thanh Khưu', 'man@man.co', '$2y$13$zIgPdSnZC.8ITMEC8lp1FuJUW31hcXCYIHK4xp7jNPnjaRUzM/nWa', 10, '4BIdiPIJUU6V-j9iCJCbaGn0u8IlaSw4', NULL, NULL, 1445395051, 1446474466),
(94, '0922522296', '0922522296', 'achilles0905@yahoo.com', '$2y$13$W3tHmuKWqqgTyHMX4Hn.7OiYBTgquwgbf4wEsZaJjth.DAKxZ/OqK', 10, 'm3hG879yPY--qVoqCIakG2supjBO6vFM', NULL, NULL, 1450667667, 1450667667);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
