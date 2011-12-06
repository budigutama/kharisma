-- phpMyAdmin SQL Dump
-- version 2.11.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 06, 2011 at 10:11 AM
-- Server version: 5.0.51
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kharisma_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_admin`
--

CREATE TABLE `t_admin` (
  `id_admin` int(11) NOT NULL auto_increment,
  `nama_admin` varchar(50) NOT NULL,
  `alamat_admin` text NOT NULL,
  `email_admin` varchar(50) NOT NULL,
  `telp_admin` varchar(20) NOT NULL,
  `password_admin` varchar(32) NOT NULL,
  `status_login` enum('1','0') NOT NULL,
  PRIMARY KEY  (`id_admin`),
  UNIQUE KEY `email_admin` (`email_admin`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Tabel Administrator' AUTO_INCREMENT=8 ;

--
-- Dumping data for table `t_admin`
--

INSERT INTO `t_admin` (`id_admin`, `nama_admin`, `alamat_admin`, `email_admin`, `telp_admin`, `password_admin`, `status_login`) VALUES
(6, 'tes a', '', 'gutama@localhost', '', 'e10adc3949ba59abbe56e057f20f883e', '1');

-- --------------------------------------------------------

--
-- Table structure for table `t_bukutamu`
--

CREATE TABLE `t_bukutamu` (
  `id_bukutamu` int(11) NOT NULL auto_increment,
  `id_member` int(11) default NULL,
  `nama_bukutamu` varchar(100) NOT NULL,
  `email_bukutamu` varchar(50) NOT NULL,
  `isi_bukutamu` text NOT NULL,
  `status_bukutamu` enum('1','0') NOT NULL,
  `tanggal_bukutamu` datetime NOT NULL,
  PRIMARY KEY  (`id_bukutamu`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Tabel Buku Tamu' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `t_bukutamu`
--

INSERT INTO `t_bukutamu` (`id_bukutamu`, `id_member`, `nama_bukutamu`, `email_bukutamu`, `isi_bukutamu`, `status_bukutamu`, `tanggal_bukutamu`) VALUES
(1, 0, 'budi', 'budi@localhost', 'bagus', '1', '2011-12-05 11:29:43');

-- --------------------------------------------------------

--
-- Table structure for table `t_detailproduk`
--

CREATE TABLE `t_detailproduk` (
  `id_detailproduk` int(11) NOT NULL auto_increment,
  `id_produk` int(4) unsigned zerofill NOT NULL,
  `id_warna` int(4) NOT NULL,
  `tanggal_detailproduk` datetime NOT NULL,
  `stok_detailproduk` int(11) NOT NULL,
  `berat_detailproduk` float NOT NULL,
  PRIMARY KEY  (`id_detailproduk`),
  KEY `id_barang` (`id_produk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabel Detail Produk' AUTO_INCREMENT=13 ;

--
-- Dumping data for table `t_detailproduk`
--

INSERT INTO `t_detailproduk` (`id_detailproduk`, `id_produk`, `id_warna`, `tanggal_detailproduk`, `stok_detailproduk`, `berat_detailproduk`) VALUES
(1, 0003, 1, '2010-11-13 12:33:37', 5, 2),
(2, 0004, 3, '2011-11-14 13:35:55', 8, 1),
(3, 0005, 2, '2011-11-15 11:18:31', 11, 4),
(4, 0006, 2, '2011-11-17 13:39:04', 1, 6),
(5, 0007, 2, '2011-11-17 13:48:27', 2, 6),
(6, 0007, 4, '2011-11-17 13:49:55', 2, 6),
(7, 0007, 5, '2011-11-17 13:50:08', 1, 6),
(9, 0008, 6, '2011-11-17 14:02:51', 2, 7),
(10, 0008, 2, '2011-11-17 14:03:08', 3, 7),
(11, 0008, 3, '2011-11-17 14:03:22', 1, 7),
(12, 0003, 6, '2011-12-04 22:00:19', 12, 2);

-- --------------------------------------------------------

--
-- Table structure for table `t_detail_pembelian`
--

CREATE TABLE `t_detail_pembelian` (
  `id_detailpembelian` int(11) NOT NULL auto_increment,
  `id_pembelian` int(11) NOT NULL,
  `hargabeli` int(20) NOT NULL,
  `id_detailproduk` int(8) NOT NULL,
  `qty` int(11) NOT NULL,
  `berat` float NOT NULL,
  `retur_qty` int(11) NOT NULL,
  PRIMARY KEY  (`id_detailpembelian`),
  KEY `pembelian_FK` (`id_pembelian`),
  KEY `produk_id_FK` (`id_detailproduk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `t_detail_pembelian`
--

INSERT INTO `t_detail_pembelian` (`id_detailpembelian`, `id_pembelian`, `hargabeli`, `id_detailproduk`, `qty`, `berat`, `retur_qty`) VALUES
(2, 2, 1800000, 1, 1, 2, 0),
(3, 3, 2250000, 3, 1, 4, 0),
(4, 3, 122222, 2, 1, 1, 0),
(5, 4, 5040000, 10, 1, 7, 0),
(6, 4, 5700000, 4, 1, 6, 0);

-- --------------------------------------------------------

--
-- Table structure for table `t_detail_retur`
--

CREATE TABLE `t_detail_retur` (
  `id_retur` int(11) NOT NULL,
  `id_pembalian` int(11) NOT NULL,
  `id_detailproduk` int(11) NOT NULL,
  `qty_retur` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `komplain` text NOT NULL,
  `session_id` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_detail_retur`
--


-- --------------------------------------------------------

--
-- Table structure for table `t_forwarder`
--

CREATE TABLE `t_forwarder` (
  `id_forwarder` int(11) NOT NULL auto_increment,
  `nama_forwarder` varchar(500) NOT NULL,
  `deskripsi_forwarder` text NOT NULL,
  PRIMARY KEY  (`id_forwarder`),
  UNIQUE KEY `nama_jasapengiriman` (`nama_forwarder`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Tabel Forwarder' AUTO_INCREMENT=4 ;

--
-- Dumping data for table `t_forwarder`
--

INSERT INTO `t_forwarder` (`id_forwarder`, `nama_forwarder`, `deskripsi_forwarder`) VALUES
(1, 'JNE ', 'Express Accros Nation				'),
(2, 'TIKI', 'Titipan Kilat'),
(3, 'POS Indonesia', 'PT. POS Indonesia Tbk.');

-- --------------------------------------------------------

--
-- Table structure for table `t_gambar`
--

CREATE TABLE `t_gambar` (
  `id_gambar` int(11) NOT NULL auto_increment,
  `id_produk` int(4) unsigned zerofill NOT NULL,
  `nama_gambar` varchar(150) NOT NULL,
  `profile_gambar` enum('0','1') NOT NULL,
  PRIMARY KEY  (`id_gambar`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabel Gambar' AUTO_INCREMENT=17 ;

--
-- Dumping data for table `t_gambar`
--

INSERT INTO `t_gambar` (`id_gambar`, `id_produk`, `nama_gambar`, `profile_gambar`) VALUES
(4, 0004, 'images (6).jpg', '1'),
(5, 0003, 'images (4).jpg', '1'),
(6, 0005, 'images (3).jpg', '1'),
(8, 0003, 'images (5).jpg', '0'),
(9, 0006, 'Drum_YAMAHA_GIG_MAKER_120211020256_ll.jpg.jpg', '1'),
(10, 0007, 'Drum_YAMAHA_STAGE_CUSTOM_BIRCH_120211020253_ll.jpg.jpg', '1'),
(11, 0007, '19286_12076_1.jpg', '0'),
(12, 0007, 'YamahaStageCustomBirch.jpg', '0'),
(14, 0008, 'Drum_YAMAHA_TOUR_CUSTOM_120211020257_ll.jpg.jpg', '1'),
(15, 0008, 'tour custom.jpg', '0'),
(16, 0008, '06F161D5BF4A4E6ABA937306A59375B6_12001.jpg', '0');

-- --------------------------------------------------------

--
-- Table structure for table `t_jeniskirim`
--

CREATE TABLE `t_jeniskirim` (
  `id_jeniskirim` int(11) NOT NULL auto_increment,
  `id_forwarder` int(11) NOT NULL,
  `nama_jeniskirim` varchar(50) NOT NULL,
  `deskripsi_jeniskirim` text NOT NULL,
  PRIMARY KEY  (`id_jeniskirim`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Tabel Jenis Pengiriman' AUTO_INCREMENT=7 ;

--
-- Dumping data for table `t_jeniskirim`
--

INSERT INTO `t_jeniskirim` (`id_jeniskirim`, `id_forwarder`, `nama_jeniskirim`, `deskripsi_jeniskirim`) VALUES
(1, 1, 'YES', 'Yakin Esok Sampai dong'),
(2, 1, 'Reguler', 'Biasa'),
(3, 1, 'OKE', ''),
(4, 2, 'Reguler', ''),
(5, 2, 'ONS', 'One Night Service');

-- --------------------------------------------------------

--
-- Table structure for table `t_kategori`
--

CREATE TABLE `t_kategori` (
  `id_kategori` int(4) NOT NULL auto_increment,
  `kode_kategori` varchar(20) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `deskripsi_kategori` text NOT NULL,
  PRIMARY KEY  (`id_kategori`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabel Kategori' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `t_kategori`
--

INSERT INTO `t_kategori` (`id_kategori`, `kode_kategori`, `nama_kategori`, `deskripsi_kategori`) VALUES
(1, 'GTR', 'Gitar', 'Alat Musik Petik dong lho'),
(2, 'DRM', 'Drums', '				'),
(3, 'PNO', 'Piano', '	Piano Bagus		'),
(4, 'BAS', 'Bass', '');

-- --------------------------------------------------------

--
-- Table structure for table `t_kota`
--

CREATE TABLE `t_kota` (
  `id_kota` int(10) NOT NULL auto_increment,
  `id_provinsi` int(10) default NULL,
  `nama_kota` varchar(50) default NULL,
  `kabkota` varchar(20) default NULL,
  UNIQUE KEY `kota#PX` (`id_kota`),
  KEY `id_provinsi` (`id_provinsi`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabel ota' AUTO_INCREMENT=425 ;

--
-- Dumping data for table `t_kota`
--

INSERT INTO `t_kota` (`id_kota`, `id_provinsi`, `nama_kota`, `kabkota`) VALUES
(1, 1, 'KEPULAUAN SERIBU', 'KABUPATEN'),
(2, 1, 'JAKARTA SELATAN', 'KOTA'),
(3, 1, 'JAKARTA TIMUR', 'KOTA'),
(4, 1, 'JAKARTA PUSAT', 'KOTA'),
(5, 1, 'JAKARTA BARAT', 'KOTA'),
(6, 1, 'JAKARTA UTARA', 'KOTA'),
(7, 2, 'Kab.BOGOR', 'KABUPATEN'),
(8, 2, 'Kab.SUKABUMI', 'KABUPATEN'),
(9, 2, 'Kab.CIANJUR', 'KABUPATEN'),
(10, 2, 'Kab.BANDUNG', 'KABUPATEN'),
(11, 2, 'Kab.GARUT', 'KABUPATEN'),
(12, 2, 'Kab.TASIK MALAYA', 'KABUPATEN'),
(13, 2, 'Kab.CIAMIS', 'KABUPATEN'),
(14, 2, 'Kab.KUNINGAN', 'KABUPATEN'),
(15, 2, 'Kab.CIREBON', 'KABUPATEN'),
(16, 2, 'Kab.MAJALENGKA', 'KABUPATEN'),
(17, 2, 'Kab.SUMEDANG', 'KABUPATEN'),
(18, 2, 'Kab.INDRAMAYU', 'KABUPATEN'),
(19, 2, 'Kab.SUBANG', 'KABUPATEN'),
(20, 2, 'Kab.PURWAKARTA', 'KABUPATEN'),
(21, 2, 'Kab.KARAWANG', 'KABUPATEN'),
(22, 2, 'Kab.BEKASI', 'KABUPATEN'),
(23, 2, 'BOGOR', 'KOTA'),
(24, 2, 'SUKABUMI', 'KOTA'),
(25, 2, 'BANDUNG', 'KOTA'),
(26, 2, 'CIREBON', 'KOTA'),
(27, 2, 'BEKASI', 'KOTA'),
(28, 2, 'DEPOK', 'KOTA'),
(29, 2, 'CIMAHI', 'KOTA'),
(30, 2, 'TASIK MALAYA', 'KOTA'),
(31, 2, 'BANJAR', 'KOTA'),
(32, 3, 'CILACAP', 'KABUPATEN'),
(33, 3, 'BANYUMAS', 'KABUPATEN'),
(34, 3, 'PURBALINGGA', 'KABUPATEN'),
(35, 3, 'BANJARNEGARA', 'KABUPATEN'),
(36, 3, 'KEBUMEN', 'KABUPATEN'),
(37, 3, 'PURWOREJO', 'KABUPATEN'),
(38, 3, 'WONOSOBO', 'KABUPATEN'),
(39, 3, 'MAGELANG', 'KABUPATEN'),
(40, 3, 'BOYOLALI', 'KABUPATEN'),
(41, 3, 'KLATEN', 'KABUPATEN'),
(42, 3, 'SUKOHARJO', 'KABUPATEN'),
(43, 3, 'WONOGIRI', 'KABUPATEN'),
(44, 3, 'KARANG ANYAR', 'KABUPATEN'),
(45, 3, 'SRAGEN', 'KABUPATEN'),
(46, 3, 'GROBOGAN', 'KABUPATEN'),
(47, 3, 'BLORA', 'KABUPATEN'),
(48, 3, 'REMBANG', 'KABUPATEN'),
(49, 3, 'PATI', 'KABUPATEN'),
(50, 3, 'KUDUS', 'KABUPATEN'),
(51, 3, 'JEPARA', 'KABUPATEN'),
(52, 3, 'DEMAK', 'KABUPATEN'),
(53, 3, 'SEMARANG', 'KABUPATEN'),
(54, 3, 'TEMANGGUNG', 'KABUPATEN'),
(55, 3, 'KENDAL', 'KABUPATEN'),
(56, 3, 'BATANG', 'KABUPATEN'),
(57, 3, 'PEKALONGAN', 'KABUPATEN'),
(58, 3, 'PEMALANG', 'KABUPATEN'),
(59, 3, 'TEGAL', 'KABUPATEN'),
(60, 3, 'BREBES', 'KABUPATEN'),
(61, 3, 'MAGELANG', 'KOTA'),
(62, 3, 'SURAKARTA', 'KOTA'),
(63, 3, 'SALATIGA', 'KOTA'),
(64, 3, 'SEMARANG', 'KOTA'),
(65, 3, 'PEKALONGAN', 'KOTA'),
(66, 3, 'TEGAL', 'KOTA'),
(67, 4, 'KULON PROGO', 'KABUPATEN'),
(68, 4, 'BANTUL', 'KABUPATEN'),
(69, 4, 'GUNUNG KIDUL', 'KABUPATEN'),
(70, 4, 'SLEMAN', 'KABUPATEN'),
(71, 4, 'YOGYAKARTA', 'KOTA'),
(72, 5, 'PACITAN', 'KABUPATEN'),
(73, 5, 'PONOROGO', 'KABUPATEN'),
(74, 5, 'TRENGGALEK', 'KABUPATEN'),
(75, 5, 'TULUNGAGUNG', 'KABUPATEN'),
(76, 5, 'BLITAR', 'KABUPATEN'),
(77, 5, 'KEDIRI', 'KABUPATEN'),
(78, 5, 'MALANG', 'KABUPATEN'),
(79, 5, 'LUMAJANG', 'KABUPATEN'),
(80, 5, 'JEMBER', 'KABUPATEN'),
(81, 5, 'BANYUWANGI', 'KABUPATEN'),
(82, 5, 'BONDOWOSO', 'KABUPATEN'),
(83, 5, 'SITUBONDO', 'KABUPATEN'),
(84, 5, 'PROBOLINGGO', 'KABUPATEN'),
(85, 5, 'PASURUAN', 'KABUPATEN'),
(86, 5, 'SIDOARJO', 'KABUPATEN'),
(87, 5, 'MOJOKERTO', 'KABUPATEN'),
(88, 5, 'JOMBANG', 'KABUPATEN'),
(89, 5, 'NGANJUK', 'KABUPATEN'),
(90, 5, 'MADIUN', 'KABUPATEN'),
(91, 5, 'MAGETAN', 'KABUPATEN'),
(92, 5, 'NGAWI', 'KABUPATEN'),
(93, 5, 'BOJONEGORO', 'KABUPATEN'),
(94, 5, 'TUBAN', 'KABUPATEN'),
(95, 5, 'LAMONGAN', 'KABUPATEN'),
(96, 5, 'GRESIK', 'KABUPATEN'),
(97, 5, 'BANGKALAN', 'KABUPATEN'),
(98, 5, 'SAMPANG', 'KABUPATEN'),
(99, 5, 'PAMEKASAN', 'KABUPATEN'),
(100, 5, 'SUMENEP', 'KABUPATEN'),
(101, 5, 'KEDIRI', 'KOTA'),
(102, 5, 'BLITAR', 'KOTA'),
(103, 5, 'MALANG', 'KOTA'),
(104, 5, 'PROBOLINGGO', 'KOTA'),
(105, 5, 'PASURUAN', 'KOTA'),
(106, 5, 'MOJOKERTO', 'KOTA'),
(107, 5, 'MADIUN', 'KOTA'),
(108, 5, 'SURABAYA', 'KOTA'),
(109, 5, 'BATU', 'KOTA'),
(110, 6, 'SIMEULUE SINABUNG', 'KABUPATEN'),
(111, 6, 'ACEH SINGKIL', 'KABUPATEN'),
(112, 6, 'ACEH SELATAN', 'KABUPATEN'),
(113, 6, 'ACEH TENGGARA', 'KABUPATEN'),
(114, 6, 'ACEH TIMUR', 'KABUPATEN'),
(115, 6, 'ACEH TENGAH', 'KABUPATEN'),
(116, 6, 'ACEH BARAT', 'KABUPATEN'),
(117, 6, 'ACEH BESAR', 'KABUPATEN'),
(118, 6, 'PIDIE', 'KABUPATEN'),
(119, 6, 'BIREUEN', 'KABUPATEN'),
(120, 6, 'ACEH UTARA', 'KABUPATEN'),
(121, 6, 'ACEH BARAT DAYA', 'KABUPATEN'),
(122, 6, 'GAYO LUES', 'KABUPATEN'),
(123, 6, 'ACEH TAMIANG', 'KABUPATEN'),
(124, 6, 'NAGAN RAYA', 'KABUPATEN'),
(125, 6, 'ACEH JAYA', 'KABUPATEN'),
(126, 6, 'BANDA ACEH', 'KOTA'),
(127, 6, 'SABANG', 'KOTA'),
(128, 6, 'LANGSA', 'KOTA'),
(129, 6, 'LHOKSEUMAWE', 'KOTA'),
(130, 7, 'NIAS', 'KABUPATEN'),
(131, 7, 'MANDAILING NATAL', 'KABUPATEN'),
(132, 7, 'TAPANULI SELATAN', 'KABUPATEN'),
(133, 7, 'TAPANULI TENGAH', 'KABUPATEN'),
(134, 7, 'TAPANULI UTARA', 'KABUPATEN'),
(135, 7, 'TOBA SAMOSIR', 'KABUPATEN'),
(136, 7, 'LABUHAN BATU', 'KABUPATEN'),
(137, 7, 'ASAHAN', 'KABUPATEN'),
(138, 7, 'SIMALUNGUN', 'KABUPATEN'),
(139, 7, 'DAIRI', 'KABUPATEN'),
(140, 7, 'KARO', 'KABUPATEN'),
(141, 7, 'DELI SERDANG', 'KABUPATEN'),
(142, 7, 'LANGKAT', 'KABUPATEN'),
(143, 7, 'NIAS SELATAN', 'KABUPATEN'),
(144, 7, 'HUMBANG HASUNDUTAN', 'KABUPATEN'),
(145, 7, 'PAK-PAK BARAT', 'KABUPATEN'),
(146, 7, 'SIBOLGA', 'KOTA'),
(147, 7, 'TANJUNG BALAI', 'KOTA'),
(148, 7, 'PEMATANG SIANTAR', 'KOTA'),
(149, 7, 'TEBING TINGGI', 'KOTA'),
(150, 7, 'MEDAN', 'KOTA'),
(151, 7, 'BINJAI', 'KOTA'),
(152, 7, 'PADANG SIDEMPUAN', 'KOTA'),
(153, 8, 'KEPULAUAN MENTAWAI', 'KABUPATEN'),
(154, 8, 'PESISIR SELATAN', 'KABUPATEN'),
(155, 8, 'SOLOK', 'KABUPATEN'),
(156, 8, 'SAWAH LUNTO', 'KABUPATEN'),
(157, 8, 'TANAH DATAR', 'KABUPATEN'),
(158, 8, 'PADANG PARIAMAN', 'KABUPATEN'),
(159, 8, 'AGAM', 'KABUPATEN'),
(160, 8, 'LIMA PULUH KOTO', 'KABUPATEN'),
(161, 8, 'PASAMAN', 'KABUPATEN'),
(162, 8, 'PADANG', 'KOTA'),
(163, 8, 'SOLOK', 'KOTA'),
(164, 8, 'SAWAH LUNTO', 'KOTA'),
(165, 8, 'PADANG PANJANG', 'KOTA'),
(166, 8, 'BUKITTINGGI', 'KOTA'),
(167, 8, 'PAYAKUMBUH', 'KOTA'),
(168, 8, 'PARIAMAN', 'KOTA'),
(169, 9, 'KUANTAN SINGINGI', 'KABUPATEN'),
(170, 9, 'INDRAGIRI HULU', 'KABUPATEN'),
(171, 9, 'INDRAGIRI HILIR', 'KABUPATEN'),
(172, 9, 'PELALAWAN', 'KABUPATEN'),
(173, 9, 'SIAK', 'KABUPATEN'),
(174, 9, 'KAMPAR', 'KABUPATEN'),
(175, 9, 'ROKAN HULU', 'KABUPATEN'),
(176, 9, 'BENGKALIS', 'KABUPATEN'),
(177, 9, 'ROKAN HILIR', 'KABUPATEN'),
(178, 9, 'PEKANBARU', 'KOTA'),
(179, 9, 'DUMAI', 'KOTA'),
(180, 10, 'KERINCI', 'KABUPATEN'),
(181, 10, 'MERANGIN', 'KABUPATEN'),
(182, 10, 'SAROLANGUN', 'KABUPATEN'),
(183, 10, 'BATANG HARI', 'KABUPATEN'),
(184, 10, 'MUARO JAMBI', 'KABUPATEN'),
(185, 10, 'TANJUNG JABUNG TIMUR', 'KABUPATEN'),
(186, 10, 'TANJUNG JABUNG BARAT', 'KABUPATEN'),
(187, 10, 'TEBO', 'KABUPATEN'),
(188, 10, 'BUNGO', 'KABUPATEN'),
(189, 10, 'JAMBI', 'KOTA'),
(190, 11, 'OGAN KOMERING ULU', 'KABUPATEN'),
(191, 11, 'OGAN KOMERING ILIR', 'KABUPATEN'),
(192, 11, 'MUARA ENIM', 'KABUPATEN'),
(193, 11, 'LAHAT', 'KABUPATEN'),
(194, 11, 'MUSI RAWAS', 'KABUPATEN'),
(195, 11, 'MUSI BANYUASIN', 'KABUPATEN'),
(196, 11, 'BANYUASIN', 'KABUPATEN'),
(197, 11, 'PALEMBANG', 'KOTA'),
(198, 11, 'PRABUMULIH', 'KOTA'),
(199, 11, 'PAGARALAM', 'KOTA'),
(200, 11, 'LUBUK LINGGAU', 'KOTA'),
(201, 12, 'LAMPUNG BARAT', 'KABUPATEN'),
(202, 12, 'TANGGAMUS', 'KABUPATEN'),
(203, 12, 'LAMPUNG SELATAN', 'KABUPATEN'),
(204, 12, 'LAMPUNG TIMUR', 'KABUPATEN'),
(205, 12, 'LAMPUNG TENGAH', 'KABUPATEN'),
(206, 12, 'LAMPUNG UTARA', 'KABUPATEN'),
(207, 12, 'WAY KANAN', 'KABUPATEN'),
(208, 12, 'TULANGBAWANG', 'KABUPATEN'),
(209, 12, 'BANDAR LAMPUNG', 'KOTA'),
(210, 12, 'METRO', 'KOTA'),
(211, 13, 'SAMBAS', 'KABUPATEN'),
(212, 13, 'BENGKAYANG', 'KABUPATEN'),
(213, 13, 'LANDAK', 'KABUPATEN'),
(214, 13, 'PONTIANAK', 'KABUPATEN'),
(215, 13, 'SANGGAU', 'KABUPATEN'),
(216, 13, 'KETAPANG', 'KABUPATEN'),
(217, 13, 'SINTANG', 'KABUPATEN'),
(218, 13, 'KAPUAS HULU', 'KABUPATEN'),
(219, 13, 'PONTIANAK', 'KOTA'),
(220, 13, 'SINGKAWANG', 'KOTA'),
(221, 14, 'KOTAWARINGIN BARAT', 'KABUPATEN'),
(222, 14, 'KOTAWARINGIN TIMUR', 'KABUPATEN'),
(223, 14, 'KAPUAS', 'KABUPATEN'),
(224, 14, 'BARITO SELATAN', 'KABUPATEN'),
(225, 14, 'BARITO UTARA', 'KABUPATEN'),
(226, 14, 'SUKAMARA', 'KABUPATEN'),
(227, 14, 'LAMANDAU', 'KABUPATEN'),
(228, 14, 'SERUYAN', 'KABUPATEN'),
(229, 14, 'KATINGAN', 'KABUPATEN'),
(230, 14, 'PULANG PISAU', 'KABUPATEN'),
(231, 14, 'GUNUNG MAS', 'KABUPATEN'),
(232, 14, 'BARITO TIMUR', 'KABUPATEN'),
(233, 14, 'MURUNG RAYA', 'KABUPATEN'),
(234, 14, 'PALANGKA RAYA', 'KOTA'),
(235, 15, 'TANAH LAUT', 'KABUPATEN'),
(236, 15, 'KOTABARU', 'KABUPATEN'),
(237, 15, 'BANJAR', 'KABUPATEN'),
(238, 15, 'BARITO KUALA', 'KABUPATEN'),
(239, 15, 'TAPIN', 'KABUPATEN'),
(240, 15, 'HULU SUNGAI SELATAN', 'KABUPATEN'),
(241, 15, 'HULU SUNGAI TENGAH', 'KABUPATEN'),
(242, 15, 'HULU SUNGAI UTARA', 'KABUPATEN'),
(243, 15, 'TABALONG', 'KABUPATEN'),
(244, 15, 'TANAH BUMBU', 'KABUPATEN'),
(245, 15, 'BALANGAN', 'KABUPATEN'),
(246, 15, 'BANJARMASIN', 'KOTA'),
(247, 15, 'BANJARBARU', 'KOTA'),
(248, 16, 'PASIR', 'KABUPATEN'),
(249, 16, 'KUTAI BARAT', 'KABUPATEN'),
(250, 16, 'KUTAI', 'KABUPATEN'),
(251, 16, 'KUTAI TIMUR', 'KABUPATEN'),
(252, 16, 'BERAU', 'KABUPATEN'),
(253, 16, 'MALINAU', 'KABUPATEN'),
(254, 16, 'BULUNGAN', 'KABUPATEN'),
(255, 16, 'NUNUKAN', 'KABUPATEN'),
(256, 16, 'PENAJAM PASIR UTARA', 'KABUPATEN'),
(257, 16, 'BALIKPAPAN', 'KOTA'),
(258, 16, 'SAMARINDA', 'KOTA'),
(259, 16, 'TARAKAN', 'KOTA'),
(260, 16, 'BONTANG', 'KOTA'),
(261, 17, 'BOLAANG MONGONDOW', 'KABUPATEN'),
(262, 17, 'MINAHASA', 'KABUPATEN'),
(263, 17, 'SANGIHE', 'KABUPATEN'),
(264, 17, 'TALAUD', 'KABUPATEN'),
(265, 17, 'MINAHASA SELATAN', 'KABUPATEN'),
(266, 17, 'MANADO', 'KOTA'),
(267, 17, 'BITUNG', 'KOTA'),
(268, 17, 'TOMOHON', 'KOTA'),
(269, 18, 'PULAU BANGGAI', 'KABUPATEN'),
(270, 18, 'BANGGAI', 'KABUPATEN'),
(271, 18, 'MOROWALI', 'KABUPATEN'),
(272, 18, 'POSO', 'KABUPATEN'),
(273, 18, 'DONGGALA', 'KABUPATEN'),
(274, 18, 'TOLI-TOLI', 'KABUPATEN'),
(275, 18, 'BUOL', 'KABUPATEN'),
(276, 18, 'PARIGI MOUTONG', 'KABUPATEN'),
(277, 18, 'PALU', 'KOTA'),
(278, 19, 'SELAYAR', 'KABUPATEN'),
(279, 19, 'BULUKUMBA', 'KABUPATEN'),
(280, 19, 'BANTAENG', 'KABUPATEN'),
(281, 19, 'JENEPONTO', 'KABUPATEN'),
(282, 19, 'TAKALAR', 'KABUPATEN'),
(283, 19, 'GOWA', 'KABUPATEN'),
(284, 19, 'SINJAI', 'KABUPATEN'),
(285, 19, 'MAROS', 'KABUPATEN'),
(286, 19, 'PANGKAJENE', 'KABUPATEN'),
(287, 19, 'BARRU', 'KABUPATEN'),
(288, 19, 'BONE', 'KABUPATEN'),
(289, 19, 'SOPPENG', 'KABUPATEN'),
(290, 19, 'WAJO', 'KABUPATEN'),
(291, 19, 'SIDENRENG RAPPANG', 'KABUPATEN'),
(292, 19, 'PINRANG', 'KABUPATEN'),
(293, 19, 'ENREKANG', 'KABUPATEN'),
(294, 19, 'LUWU', 'KABUPATEN'),
(295, 19, 'TANA TORAJA', 'KABUPATEN'),
(296, 19, 'LUWU UTARA', 'KABUPATEN'),
(297, 19, 'LUWU TIMUR', 'KABUPATEN'),
(298, 19, 'MAKASSAR', 'KOTA'),
(299, 19, 'PARE-PARE', 'KOTA'),
(300, 19, 'PALOPO', 'KOTA'),
(301, 20, 'BUTON', 'KABUPATEN'),
(302, 20, 'MUNA', 'KABUPATEN'),
(303, 20, 'KENDARI', 'KABUPATEN'),
(304, 20, 'KOLAKA', 'KABUPATEN'),
(305, 20, 'KENDARI', 'KOTA'),
(306, 20, 'BAU-BAU', 'KOTA'),
(307, 20, 'KONAWE SELATAN', 'KOTA'),
(308, 21, 'MALUKU TENGGARA BARA', 'KABUPATEN'),
(309, 21, 'MALUKU TENGGARA', 'KABUPATEN'),
(310, 21, 'MALUKU TENGAH', 'KABUPATEN'),
(311, 21, 'BURU', 'KABUPATEN'),
(312, 21, 'AMBON', 'KOTA'),
(313, 22, 'JEMBRANA', 'KABUPATEN'),
(314, 22, 'TABANAN', 'KABUPATEN'),
(315, 22, 'BADUNG', 'KABUPATEN'),
(316, 22, 'GIANYAR', 'KABUPATEN'),
(317, 22, 'KLUNGKUNG', 'KABUPATEN'),
(318, 22, 'BANGLI', 'KABUPATEN'),
(319, 22, 'KARANG ASEM', 'KABUPATEN'),
(320, 22, 'BULELENG', 'KABUPATEN'),
(321, 22, 'DENPASAR', 'KOTA'),
(322, 23, 'LOMBOK BARAT', 'KABUPATEN'),
(323, 23, 'LOMBOK TENGAH', 'KABUPATEN'),
(324, 23, 'LOMBOK TIMUR', 'KABUPATEN'),
(325, 23, 'SUMBAWA', 'KABUPATEN'),
(326, 23, 'DOMPU', 'KABUPATEN'),
(327, 23, 'BIMA', 'KABUPATEN'),
(328, 23, 'MATARAM', 'KOTA'),
(329, 23, 'BIMA', 'KOTA'),
(330, 24, 'SUMBA BARAT', 'KABUPATEN'),
(331, 24, 'SUMBA TIMUR', 'KABUPATEN'),
(332, 24, 'KUPANG', 'KABUPATEN'),
(333, 24, 'TIMOR TENGAH SELATAN', 'KABUPATEN'),
(334, 24, 'TIMOR TENGAH UTARA', 'KABUPATEN'),
(335, 24, 'BELU', 'KABUPATEN'),
(336, 24, 'ALOR', 'KABUPATEN'),
(337, 24, 'LEMBATA', 'KABUPATEN'),
(338, 24, 'FLORES TIMUR', 'KABUPATEN'),
(339, 24, 'SIKKA', 'KABUPATEN'),
(340, 24, 'ENDE', 'KABUPATEN'),
(341, 24, 'NGADA', 'KABUPATEN'),
(342, 24, 'MANGGARAI', 'KABUPATEN'),
(343, 24, 'ROTE NDAO', 'KABUPATEN'),
(344, 24, 'MANGGARAI BARAT', 'KABUPATEN'),
(345, 24, 'KUPANG', 'KOTA'),
(346, 25, 'MERAUKE', 'KABUPATEN'),
(347, 25, 'JAYA WIJAYA', 'KABUPATEN'),
(348, 25, 'JAYAPURA', 'KABUPATEN'),
(349, 25, 'NABIRE', 'KABUPATEN'),
(350, 25, 'YAPEN WAROPEN', 'KABUPATEN'),
(351, 25, 'BIAK NUMFOR', 'KABUPATEN'),
(352, 25, 'PANIAI', 'KABUPATEN'),
(353, 25, 'PUNCAK JAYA', 'KABUPATEN'),
(354, 25, 'MIMIKA', 'KABUPATEN'),
(355, 25, 'BOVEN DIGOEL', 'KABUPATEN'),
(356, 25, 'MAPPI', 'KABUPATEN'),
(357, 25, 'ASMAT', 'KABUPATEN'),
(358, 25, 'YAKUHIMO', 'KABUPATEN'),
(359, 25, 'GUNUNG BINTANG', 'KABUPATEN'),
(360, 25, 'TOLIKARA', 'KABUPATEN'),
(361, 25, 'SARMI', 'KABUPATEN'),
(362, 25, 'KEEROM', 'KABUPATEN'),
(363, 25, 'WAROPEN', 'KABUPATEN'),
(364, 25, 'JAYAPURA', 'KOTA'),
(365, 26, 'BENGKULU SELATAN', 'KABUPATEN'),
(366, 26, 'REJANG LEBONG', 'KABUPATEN'),
(367, 26, 'BENGKULU UTARA', 'KABUPATEN'),
(368, 26, 'KAUR', 'KABUPATEN'),
(369, 26, 'SELUMA', 'KABUPATEN'),
(370, 26, 'MUKO-MUKO', 'KABUPATEN'),
(371, 26, 'BENGKULU', 'KOTA'),
(372, 27, 'PANDEGLANG', 'KABUPATEN'),
(373, 27, 'LEBAK', 'KABUPATEN'),
(374, 27, 'TANGERANG', 'KABUPATEN'),
(375, 27, 'SERANG', 'KABUPATEN'),
(376, 27, 'TANGERANG', 'KOTA'),
(377, 27, 'CILEGON', 'KOTA'),
(378, 28, 'HALMAHERA BARAT', 'KABUPATEN'),
(379, 28, 'HALMAHERA TENGAH', 'KABUPATEN'),
(380, 28, 'PULAU SULA', 'KABUPATEN'),
(381, 28, 'HALMAHERA SELATAN', 'KABUPATEN'),
(382, 28, 'HALMAHERA UTARA', 'KABUPATEN'),
(383, 28, 'HALMAHERA TIMUR', 'KABUPATEN'),
(384, 28, 'TERNATE', 'KOTA'),
(385, 28, 'TIDORE', 'KOTA'),
(386, 29, 'BANGKA', 'KABUPATEN'),
(387, 29, 'BELITUNG', 'KABUPATEN'),
(388, 29, 'BANGKA SELATAN', 'KABUPATEN'),
(389, 29, 'BANGKA TENGAH', 'KABUPATEN'),
(390, 29, 'BANGKA BARAT', 'KABUPATEN'),
(391, 29, 'BELITUNG TIMUR', 'KABUPATEN'),
(392, 29, 'PANGKALPINANG', 'KOTA'),
(393, 30, 'BOALEMO', 'KABUPATEN'),
(394, 30, 'GORONTALO', 'KABUPATEN'),
(395, 30, 'PUHUWATO', 'KABUPATEN'),
(396, 30, 'BONE BOLANGO', 'KABUPATEN'),
(397, 30, 'GORONTALO', 'KOTA'),
(398, 31, 'FAK-FAK', 'KABUPATEN'),
(399, 31, 'SORONG', 'KABUPATEN'),
(400, 31, 'MANOKWARI', 'KABUPATEN'),
(401, 31, 'KAIMANA', 'KABUPATEN'),
(402, 31, 'SORONG SELATAN', 'KABUPATEN'),
(403, 31, 'RAJA AMPAT', 'KABUPATEN'),
(404, 31, 'TELUK BINTUNI', 'KABUPATEN'),
(405, 31, 'TELUK WONDANA', 'KABUPATEN'),
(406, 31, 'SORONG', 'KOTA'),
(407, 32, 'KARIMUN', 'KABUPATEN'),
(408, 32, 'KEPULAUAN RIAU', 'KABUPATEN'),
(409, 32, 'NATUNA', 'KABUPATEN'),
(410, 32, 'BATAM', 'KOTA'),
(411, 32, 'TANJUNG PINANG', 'KOTA'),
(412, 33, 'MAMUJU', 'KABUPATEN'),
(413, 33, 'MAMUJU UTARA', 'KABUPATEN'),
(414, 33, 'MAJENE', 'KABUPATEN'),
(415, 33, 'POLEWALI MANDAR', 'KABUPATEN'),
(416, 33, 'MAMASA', 'KOTA'),
(417, 11, 'OGAN ILIR', 'KABUPATEN'),
(418, 11, 'OKU TIMUR', 'KABUPATEN'),
(419, 11, 'OKU SELATAN', 'KABUPATEN'),
(420, 21, 'SERAM BAGIAN BARAT', 'KABUPATEN'),
(421, 21, 'SERAM BARAT TIMUR', 'KABUPATEN'),
(422, 21, 'ARU', 'KABUPATEN'),
(423, 17, 'MINAHASA UTARA', 'KABUPATEN'),
(424, 25, 'SUPIORI', 'KOTA');

-- --------------------------------------------------------

--
-- Table structure for table `t_kurs`
--

CREATE TABLE `t_kurs` (
  `id_kurs` varchar(3) NOT NULL,
  `nama_kurs` varchar(50) NOT NULL,
  `lambang_kurs` varchar(10) NOT NULL,
  `nilai_kurs` float NOT NULL,
  PRIMARY KEY  (`id_kurs`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_kurs`
--

INSERT INTO `t_kurs` (`id_kurs`, `nama_kurs`, `lambang_kurs`, `nilai_kurs`) VALUES
('USD', 'Dollar Amerika', 'US$', 9000);

-- --------------------------------------------------------

--
-- Table structure for table `t_member`
--

CREATE TABLE `t_member` (
  `id_member` int(11) NOT NULL auto_increment,
  `id_kota` int(11) NOT NULL,
  `nama_member` varchar(50) NOT NULL,
  `alamat_member` text NOT NULL,
  `telp_member` varchar(20) NOT NULL,
  `kodepos_member` varchar(6) NOT NULL,
  `email_member` varchar(50) NOT NULL,
  `password_member` varchar(32) NOT NULL,
  `verificationcode_member` varchar(32) NOT NULL,
  `status_member` enum('0','1') NOT NULL,
  PRIMARY KEY  (`id_member`),
  UNIQUE KEY `email_member` (`email_member`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Tabel Member' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `t_member`
--

INSERT INTO `t_member` (`id_member`, `id_kota`, `nama_member`, `alamat_member`, `telp_member`, `kodepos_member`, `email_member`, `password_member`, `verificationcode_member`, `status_member`) VALUES
(1, 24, 'joni', 'kpo', '23456789', '43152', 'budi@localhost', 'e807f1fcf82d132f9bb018ca6738a19f', '5a569b9913dee679dd27769cc2cea9b0', '1');

-- --------------------------------------------------------

--
-- Table structure for table `t_merek`
--

CREATE TABLE `t_merek` (
  `id_merek` int(11) NOT NULL auto_increment,
  `kode_merek` varchar(3) NOT NULL,
  `nama_merek` varchar(50) NOT NULL,
  `deskripsi_merek` text NOT NULL,
  PRIMARY KEY  (`id_merek`),
  UNIQUE KEY `nama_kategori` (`nama_merek`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Tabel Merek' AUTO_INCREMENT=6 ;

--
-- Dumping data for table `t_merek`
--

INSERT INTO `t_merek` (`id_merek`, `kode_merek`, `nama_merek`, `deskripsi_merek`) VALUES
(1, 'FND', 'Fender', 'Bagus banget'),
(2, 'RCK', 'Rock', 'bAGUS jUGA'),
(3, 'YMH', 'Yamaha', ''),
(4, 'TMA', 'Tama', ''),
(5, 'PRL', 'Pearl', 'Bagus		');

-- --------------------------------------------------------

--
-- Table structure for table `t_ongkir`
--

CREATE TABLE `t_ongkir` (
  `id_ongkir` int(11) NOT NULL auto_increment,
  `id_kota` int(11) NOT NULL,
  `id_jeniskirim` int(11) NOT NULL,
  `harga_ongkir` int(11) NOT NULL,
  PRIMARY KEY  (`id_ongkir`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Tabel Ongkos Kirim' AUTO_INCREMENT=65 ;

--
-- Dumping data for table `t_ongkir`
--

INSERT INTO `t_ongkir` (`id_ongkir`, `id_kota`, `id_jeniskirim`, `harga_ongkir`) VALUES
(1, 1, 1, 12000),
(2, 2, 1, 8000),
(3, 3, 1, 8000),
(4, 4, 1, 8000),
(5, 5, 1, 8000),
(6, 6, 1, 8000),
(7, 7, 1, 8000),
(8, 8, 1, 9000),
(9, 9, 1, 10000),
(10, 10, 1, 5000),
(11, 11, 1, 7000),
(12, 12, 1, 8000),
(13, 13, 1, 10000),
(14, 14, 1, 14000),
(15, 15, 1, 14000),
(16, 16, 1, 14000),
(17, 17, 1, 14000),
(18, 18, 1, 17000),
(19, 19, 1, 9000),
(20, 20, 1, 8000),
(21, 21, 1, 12000),
(22, 22, 1, 10000),
(23, 23, 1, 8000),
(24, 24, 1, 9000),
(25, 25, 1, 100),
(26, 26, 1, 9000),
(27, 27, 1, 9000),
(28, 28, 1, 10000),
(29, 29, 1, 7000),
(30, 30, 1, 8000),
(31, 1, 2, 12000),
(32, 2, 2, 12000),
(33, 3, 2, 12000),
(34, 4, 2, 12000),
(35, 5, 2, 12000),
(36, 6, 2, 12000),
(37, 7, 2, 14000),
(38, 8, 2, 14000),
(39, 9, 2, 14000),
(40, 10, 2, 10000),
(41, 11, 2, 10000),
(42, 12, 2, 10000),
(43, 13, 2, 12000),
(44, 14, 2, 20500),
(45, 15, 2, 16000),
(46, 16, 2, 14000),
(47, 17, 2, 10500),
(48, 18, 2, 20500),
(49, 19, 2, 10500),
(50, 20, 2, 10500),
(51, 21, 2, 18000),
(52, 22, 2, 14000),
(53, 23, 2, 14000),
(54, 24, 2, 14000),
(55, 25, 2, 9000),
(57, 26, 2, 16000),
(58, 27, 2, 14000),
(59, 28, 2, 16000),
(60, 29, 2, 7000),
(61, 30, 1, 10000),
(63, 32, 3, 21000),
(64, 170, 1, 47000);

-- --------------------------------------------------------

--
-- Table structure for table `t_pembelian`
--

CREATE TABLE `t_pembelian` (
  `id_pembelian` int(11) NOT NULL auto_increment,
  `session_id` varchar(32) NOT NULL,
  `tgl_beli` datetime NOT NULL,
  `tgl_bayar` datetime NOT NULL,
  `tgl_kirim` date NOT NULL,
  `tgl_terima` date NOT NULL,
  `status` enum('pesan','bayar','konfirmasi','kirim','terima') NOT NULL,
  `status_pembayaran` enum('1','2','3') NOT NULL,
  `id_member` int(11) NOT NULL,
  `pembayaran` enum('transfer','paypal','cod') NOT NULL,
  `kirim_nama` varchar(50) NOT NULL,
  `kirim_alamat` text NOT NULL,
  `kirim_telp` varchar(12) NOT NULL,
  `kirim_kota` int(11) NOT NULL,
  `kirim_kdpos` varchar(6) NOT NULL,
  `kirim_ongkos` int(32) NOT NULL,
  `kirim_resi` varchar(15) NOT NULL,
  `id_jeniskirim` int(11) NOT NULL,
  `transfer_bank` varchar(20) NOT NULL,
  `transfer_no` varchar(30) NOT NULL,
  `transfer_jumlah` double NOT NULL,
  `id_rekening` varchar(30) NOT NULL,
  `totalbayar` double NOT NULL,
  PRIMARY KEY  (`id_pembelian`),
  KEY `kota_FK` (`kirim_kota`),
  KEY `member_FK` (`id_member`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `t_pembelian`
--

INSERT INTO `t_pembelian` (`id_pembelian`, `session_id`, `tgl_beli`, `tgl_bayar`, `tgl_kirim`, `tgl_terima`, `status`, `status_pembayaran`, `id_member`, `pembayaran`, `kirim_nama`, `kirim_alamat`, `kirim_telp`, `kirim_kota`, `kirim_kdpos`, `kirim_ongkos`, `kirim_resi`, `id_jeniskirim`, `transfer_bank`, `transfer_no`, `transfer_jumlah`, `id_rekening`, `totalbayar`) VALUES
(2, '1f4t57gkap4rp61se675aaam75', '2011-11-24 09:53:52', '2011-11-24 11:13:24', '2011-12-04', '2011-12-04', 'terima', '2', 1, 'transfer', 'joni', 'kpo', '23456789', 24, '43152', 28000, '987654345678', 2, 'Mandiri', '4353546', 1828000, '2', 1828000),
(3, '1f4t57gkap4rp61se675aaam75', '2011-11-24 10:52:05', '2011-11-24 11:10:43', '2011-12-05', '2011-12-05', 'terima', '2', 1, 'transfer', 'joni', 'kpo', '23456789', 24, '43152', 45000, '09876543210987', 1, 'HSBC', '23435454', 2417222, '1', 2417222),
(4, 'jjc2mrsa9vsuj8tj484ca6hlm2', '2011-12-06 09:41:40', '0000-00-00 00:00:00', '0000-00-00', '0000-00-00', 'pesan', '1', 1, '', 'joni', 'kpo', '23456789', 24, '43152', 117000, '', 1, '', '', 0, '', 10857000);

-- --------------------------------------------------------

--
-- Table structure for table `t_pemesanan`
--

CREATE TABLE `t_pemesanan` (
  `id_temp` int(11) NOT NULL auto_increment,
  `id_detailproduk` int(11) NOT NULL,
  `session_id` varchar(32) NOT NULL,
  `qty` int(11) NOT NULL,
  `berat` float NOT NULL,
  `temp_hargadiskon` int(20) NOT NULL,
  `tanggal_pesan` date NOT NULL,
  PRIMARY KEY  (`id_temp`),
  KEY `produk_FK` (`id_detailproduk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Temporari Pemesanan' AUTO_INCREMENT=6 ;

--
-- Dumping data for table `t_pemesanan`
--

INSERT INTO `t_pemesanan` (`id_temp`, `id_detailproduk`, `session_id`, `qty`, `berat`, `temp_hargadiskon`, `tanggal_pesan`) VALUES
(3, 1, '97brhs1t9to263ip0063vog6h4', 2, 2, 1800000, '2011-11-19');

-- --------------------------------------------------------

--
-- Table structure for table `t_produk`
--

CREATE TABLE `t_produk` (
  `id_produk` int(4) unsigned zerofill NOT NULL auto_increment,
  `id_merek` int(11) NOT NULL,
  `id_kategori` int(4) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `harga_produk` int(11) NOT NULL,
  `deskripsi_produk` text NOT NULL,
  `diskon_produk` int(11) NOT NULL,
  `rating_produk` float NOT NULL,
  `voterrating_produk` int(11) NOT NULL,
  `viewcounter_produk` int(11) NOT NULL,
  PRIMARY KEY  (`id_produk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabel Produk' AUTO_INCREMENT=9 ;

--
-- Dumping data for table `t_produk`
--

INSERT INTO `t_produk` (`id_produk`, `id_merek`, `id_kategori`, `nama_produk`, `harga_produk`, `deskripsi_produk`, `diskon_produk`, `rating_produk`, `voterrating_produk`, `viewcounter_produk`) VALUES
(0003, 1, 1, 'Bagus', 2000000, 'bagus Lho', 10, 0, 0, 28),
(0004, 1, 1, 'jelek', 122222, '		asa										', 0, 0, 0, 133),
(0005, 2, 2, 'Drums Bagus', 2500000, 'Drums Bagus canggih sekali', 10, 0, 0, 20),
(0006, 3, 2, 'GIG MAKER', 6000000, '		as		', 5, 0, 0, 10),
(0007, 3, 2, 'STAGE CUSTOM BIRCH', 6500000, 'Borrowing from our legendary Recording Custom drum sets, the world-famous Yamaha birch sound is now available in an affordable package. From the YESS mounting system to the tom ball clamps to the rich lacquer finishes, the Stage Custom Birch encompasses value, quality, and craftsmanship.', 10, 0, 0, 28),
(0008, 3, 2, 'Tour Custom', 5600000, 'Designed for Rock drummers from the start, Rock Tour is ideal for live situations when you need to cut through a wall of guitars.Designed for Rock drummers from the start, Rock Tour is ideal for live situations when you need to cut through a wall of guitars.Designed for Rock drummers from the start, Rock Tour is ideal for live situations when you need to cut through a wall of guitars.', 10, 0, 0, 10);

-- --------------------------------------------------------

--
-- Table structure for table `t_provinsi`
--

CREATE TABLE `t_provinsi` (
  `id_provinsi` int(10) NOT NULL auto_increment,
  `nama_provinsi` varchar(30) default NULL,
  KEY `id_prov` (`id_provinsi`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabel Provinsi' AUTO_INCREMENT=34 ;

--
-- Dumping data for table `t_provinsi`
--

INSERT INTO `t_provinsi` (`id_provinsi`, `nama_provinsi`) VALUES
(1, 'DKI JAKARTA'),
(2, 'JAWA BARAT'),
(3, 'JAWA TENGAH'),
(4, 'D I YOGYAKARTA'),
(5, 'JAWA TIMUR'),
(6, 'ACEH DARUSSALAM'),
(7, 'SUMATERA UTARA'),
(8, 'SUMATERA BARAT'),
(9, 'RIAU'),
(10, 'JAMBI'),
(11, 'SUMATERA SELATAN'),
(12, 'LAMPUNG'),
(13, 'KALIMANTAN BARAT'),
(14, 'KALIMANTAN TENGAH'),
(15, 'KALIMANTAN SELATAN'),
(16, 'KALIMANTAN TIMUR'),
(17, 'SULAWESI UTARA'),
(18, 'SULAWESI TENGAH'),
(19, 'SULAWESI SELATAN'),
(20, 'SULAWESI TENGGARA'),
(21, 'MALUKU'),
(22, 'BALI'),
(23, 'NUSA TENGGARA BARAT'),
(24, 'NUSA TENGGARA TIMUR'),
(25, 'PAPUA'),
(26, 'BENGKULU'),
(27, 'BANTEN'),
(28, 'MALUKU UTARA'),
(29, 'BANGKA BELITUNG'),
(30, 'GORONTALO'),
(31, 'IRIAN JAYA BARAT'),
(32, 'KEPULAUAN RIAU'),
(33, 'SULAWESI BARAT');

-- --------------------------------------------------------

--
-- Table structure for table `t_rekening`
--

CREATE TABLE `t_rekening` (
  `id_rekening` int(11) NOT NULL auto_increment,
  `nama_rekening` varchar(50) NOT NULL,
  `bank_rekening` varchar(50) NOT NULL,
  `cabang_rekening` varchar(100) NOT NULL,
  `no_rekening` varchar(32) NOT NULL,
  `gambar_rekening` varchar(200) NOT NULL,
  PRIMARY KEY  (`id_rekening`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Tabel Rekening' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `t_rekening`
--

INSERT INTO `t_rekening` (`id_rekening`, `nama_rekening`, `bank_rekening`, `cabang_rekening`, `no_rekening`, `gambar_rekening`) VALUES
(1, 'Afriliyan', 'BNI', 'ITB Bandung', '089756656541', 'c6d2921aa6f2ec9b1e092a5a0ad15addicon_bni.gif'),
(2, 'Afriliyan', 'BCA', 'Dago Bandung', '09788779798', 'f4afe1fd002b3215b968b351b199b4e5icon_bca.gif');

-- --------------------------------------------------------

--
-- Table structure for table `t_retur`
--

CREATE TABLE `t_retur` (
  `id_retur` int(11) NOT NULL auto_increment,
  `id_member` int(11) NOT NULL,
  `jasa_kirim` varchar(30) NOT NULL,
  `no_kirim` varchar(20) NOT NULL,
  `tgl_retur` date NOT NULL,
  `total_retur` int(11) NOT NULL,
  `status_retur` varchar(10) NOT NULL,
  PRIMARY KEY  (`id_retur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel Retur' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `t_retur`
--


-- --------------------------------------------------------

--
-- Table structure for table `t_testiproduk`
--

CREATE TABLE `t_testiproduk` (
  `id_testi` int(11) NOT NULL auto_increment,
  `id_produk` int(4) unsigned zerofill NOT NULL,
  `id_member` int(11) NOT NULL,
  `testimoni` text NOT NULL,
  `status_testi` enum('1','0') NOT NULL,
  `tgl_testi` datetime NOT NULL,
  PRIMARY KEY  (`id_testi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `t_testiproduk`
--


-- --------------------------------------------------------

--
-- Table structure for table `t_warna`
--

CREATE TABLE `t_warna` (
  `id_warna` int(11) NOT NULL auto_increment,
  `nama_warna` varchar(50) NOT NULL,
  `format_warna` varchar(10) default NULL,
  PRIMARY KEY  (`id_warna`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabel Warna' AUTO_INCREMENT=7 ;

--
-- Dumping data for table `t_warna`
--

INSERT INTO `t_warna` (`id_warna`, `nama_warna`, `format_warna`) VALUES
(1, 'Biru', '#090'),
(2, 'Hitam', '#000'),
(3, 'Merah', '#F00'),
(4, 'Hijau', '#09f'),
(5, 'Krem', '#576'),
(6, 'Coklat', '#F57');
