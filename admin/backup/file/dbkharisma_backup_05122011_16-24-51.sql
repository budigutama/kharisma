DROP TABLE t_admin;<|||||||>

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COMMENT='Tabel Administrator';<|||||||>

INSERT INTO t_admin VALUES("6","tes a","","gutama@localhost","","e10adc3949ba59abbe56e057f20f883e","1");<|||||||>



DROP TABLE t_bukutamu;<|||||||>

CREATE TABLE `t_bukutamu` (
  `id_bukutamu` int(11) NOT NULL auto_increment,
  `id_member` int(11) default NULL,
  `nama_bukutamu` varchar(100) NOT NULL,
  `email_bukutamu` varchar(50) NOT NULL,
  `isi_bukutamu` text NOT NULL,
  `status_bukutamu` enum('1','0') NOT NULL,
  `tanggal_bukutamu` datetime NOT NULL,
  PRIMARY KEY  (`id_bukutamu`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='Tabel Buku Tamu';<|||||||>

INSERT INTO t_bukutamu VALUES("1","0","budi","budi@localhost","bagus","1","2011-12-05 11:29:43");<|||||||>



DROP TABLE t_detail_pembelian;<|||||||>

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;<|||||||>

INSERT INTO t_detail_pembelian VALUES("1","1","122222","2","1","1","0");<|||||||>
INSERT INTO t_detail_pembelian VALUES("2","2","1800000","1","1","2","0");<|||||||>
INSERT INTO t_detail_pembelian VALUES("3","3","2250000","3","1","4","0");<|||||||>
INSERT INTO t_detail_pembelian VALUES("4","3","122222","2","1","1","0");<|||||||>



DROP TABLE t_detail_retur;<|||||||>

CREATE TABLE `t_detail_retur` (
  `id_retur` int(11) NOT NULL,
  `id_pembalian` int(11) NOT NULL,
  `id_detailproduk` int(11) NOT NULL,
  `qty_retur` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `komplain` text NOT NULL,
  `session_id` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;<|||||||>




DROP TABLE t_detailproduk;<|||||||>

CREATE TABLE `t_detailproduk` (
  `id_detailproduk` int(11) NOT NULL auto_increment,
  `id_produk` int(4) unsigned zerofill NOT NULL,
  `id_warna` int(4) NOT NULL,
  `tanggal_detailproduk` datetime NOT NULL,
  `stok_detailproduk` int(11) NOT NULL,
  `berat_detailproduk` float NOT NULL,
  PRIMARY KEY  (`id_detailproduk`),
  KEY `id_barang` (`id_produk`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COMMENT='Tabel Detail Produk';<|||||||>

INSERT INTO t_detailproduk VALUES("1","0003","1","2010-11-13 12:33:37","5","2");<|||||||>
INSERT INTO t_detailproduk VALUES("2","0004","3","2011-11-14 13:35:55","8","1");<|||||||>
INSERT INTO t_detailproduk VALUES("3","0005","2","2011-11-15 11:18:31","11","4");<|||||||>
INSERT INTO t_detailproduk VALUES("4","0006","2","2011-11-17 13:39:04","2","6");<|||||||>
INSERT INTO t_detailproduk VALUES("5","0007","2","2011-11-17 13:48:27","2","6");<|||||||>
INSERT INTO t_detailproduk VALUES("6","0007","4","2011-11-17 13:49:55","2","6");<|||||||>
INSERT INTO t_detailproduk VALUES("7","0007","5","2011-11-17 13:50:08","1","6");<|||||||>
INSERT INTO t_detailproduk VALUES("9","0008","6","2011-11-17 14:02:51","2","7");<|||||||>
INSERT INTO t_detailproduk VALUES("10","0008","2","2011-11-17 14:03:08","4","7");<|||||||>
INSERT INTO t_detailproduk VALUES("11","0008","3","2011-11-17 14:03:22","1","7");<|||||||>
INSERT INTO t_detailproduk VALUES("12","0003","6","2011-12-04 22:00:19","12","2");<|||||||>



DROP TABLE t_forwarder;<|||||||>

CREATE TABLE `t_forwarder` (
  `id_forwarder` int(11) NOT NULL auto_increment,
  `nama_forwarder` varchar(500) NOT NULL,
  `deskripsi_forwarder` text NOT NULL,
  PRIMARY KEY  (`id_forwarder`),
  UNIQUE KEY `nama_jasapengiriman` (`nama_forwarder`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='Tabel Forwarder';<|||||||>

INSERT INTO t_forwarder VALUES("1","JNE ","Express Accros Nation				");<|||||||>
INSERT INTO t_forwarder VALUES("2","TIKI","Titipan Kilat");<|||||||>
INSERT INTO t_forwarder VALUES("3","POS Indonesia","PT. POS Indonesia Tbk.");<|||||||>



DROP TABLE t_gambar;<|||||||>

CREATE TABLE `t_gambar` (
  `id_gambar` int(11) NOT NULL auto_increment,
  `id_produk` int(4) unsigned zerofill NOT NULL,
  `nama_gambar` varchar(150) NOT NULL,
  `profile_gambar` enum('0','1') NOT NULL,
  PRIMARY KEY  (`id_gambar`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 COMMENT='Tabel Gambar';<|||||||>

INSERT INTO t_gambar VALUES("4","0004","images (6).jpg","1");<|||||||>
INSERT INTO t_gambar VALUES("5","0003","images (4).jpg","1");<|||||||>
INSERT INTO t_gambar VALUES("6","0005","images (3).jpg","1");<|||||||>
INSERT INTO t_gambar VALUES("8","0003","images (5).jpg","0");<|||||||>
INSERT INTO t_gambar VALUES("9","0006","Drum_YAMAHA_GIG_MAKER_120211020256_ll.jpg.jpg","1");<|||||||>
INSERT INTO t_gambar VALUES("10","0007","Drum_YAMAHA_STAGE_CUSTOM_BIRCH_120211020253_ll.jpg.jpg","1");<|||||||>
INSERT INTO t_gambar VALUES("11","0007","19286_12076_1.jpg","0");<|||||||>
INSERT INTO t_gambar VALUES("12","0007","YamahaStageCustomBirch.jpg","0");<|||||||>
INSERT INTO t_gambar VALUES("14","0008","Drum_YAMAHA_TOUR_CUSTOM_120211020257_ll.jpg.jpg","1");<|||||||>
INSERT INTO t_gambar VALUES("15","0008","tour custom.jpg","0");<|||||||>
INSERT INTO t_gambar VALUES("16","0008","06F161D5BF4A4E6ABA937306A59375B6_12001.jpg","0");<|||||||>



DROP TABLE t_jeniskirim;<|||||||>

CREATE TABLE `t_jeniskirim` (
  `id_jeniskirim` int(11) NOT NULL auto_increment,
  `id_forwarder` int(11) NOT NULL,
  `nama_jeniskirim` varchar(50) NOT NULL,
  `deskripsi_jeniskirim` text NOT NULL,
  PRIMARY KEY  (`id_jeniskirim`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='Tabel Jenis Pengiriman';<|||||||>

INSERT INTO t_jeniskirim VALUES("1","1","YES","Yakin Esok Sampai dong");<|||||||>
INSERT INTO t_jeniskirim VALUES("2","1","Reguler","Biasa");<|||||||>
INSERT INTO t_jeniskirim VALUES("3","1","OKE","");<|||||||>
INSERT INTO t_jeniskirim VALUES("4","2","Reguler","");<|||||||>
INSERT INTO t_jeniskirim VALUES("5","2","ONS","One Night Service");<|||||||>



DROP TABLE t_kategori;<|||||||>

CREATE TABLE `t_kategori` (
  `id_kategori` int(4) NOT NULL auto_increment,
  `kode_kategori` varchar(20) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `deskripsi_kategori` text NOT NULL,
  PRIMARY KEY  (`id_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='Tabel Kategori';<|||||||>

INSERT INTO t_kategori VALUES("1","GTR","Gitar","Alat Musik Petik dong lho");<|||||||>
INSERT INTO t_kategori VALUES("2","DRM","Drums","				");<|||||||>
INSERT INTO t_kategori VALUES("3","PNO","Piano","	Piano Bagus		");<|||||||>
INSERT INTO t_kategori VALUES("4","BAS","Bass","");<|||||||>



DROP TABLE t_kota;<|||||||>

CREATE TABLE `t_kota` (
  `id_kota` int(10) NOT NULL auto_increment,
  `id_provinsi` int(10) default NULL,
  `nama_kota` varchar(50) default NULL,
  `kabkota` varchar(20) default NULL,
  UNIQUE KEY `kota#PX` (`id_kota`),
  KEY `id_provinsi` (`id_provinsi`)
) ENGINE=InnoDB AUTO_INCREMENT=425 DEFAULT CHARSET=latin1 COMMENT='Tabel ota';<|||||||>

INSERT INTO t_kota VALUES("1","1","KEPULAUAN SERIBU","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("2","1","JAKARTA SELATAN","KOTA");<|||||||>
INSERT INTO t_kota VALUES("3","1","JAKARTA TIMUR","KOTA");<|||||||>
INSERT INTO t_kota VALUES("4","1","JAKARTA PUSAT","KOTA");<|||||||>
INSERT INTO t_kota VALUES("5","1","JAKARTA BARAT","KOTA");<|||||||>
INSERT INTO t_kota VALUES("6","1","JAKARTA UTARA","KOTA");<|||||||>
INSERT INTO t_kota VALUES("7","2","Kab.BOGOR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("8","2","Kab.SUKABUMI","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("9","2","Kab.CIANJUR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("10","2","Kab.BANDUNG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("11","2","Kab.GARUT","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("12","2","Kab.TASIK MALAYA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("13","2","Kab.CIAMIS","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("14","2","Kab.KUNINGAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("15","2","Kab.CIREBON","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("16","2","Kab.MAJALENGKA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("17","2","Kab.SUMEDANG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("18","2","Kab.INDRAMAYU","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("19","2","Kab.SUBANG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("20","2","Kab.PURWAKARTA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("21","2","Kab.KARAWANG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("22","2","Kab.BEKASI","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("23","2","BOGOR","KOTA");<|||||||>
INSERT INTO t_kota VALUES("24","2","SUKABUMI","KOTA");<|||||||>
INSERT INTO t_kota VALUES("25","2","BANDUNG","KOTA");<|||||||>
INSERT INTO t_kota VALUES("26","2","CIREBON","KOTA");<|||||||>
INSERT INTO t_kota VALUES("27","2","BEKASI","KOTA");<|||||||>
INSERT INTO t_kota VALUES("28","2","DEPOK","KOTA");<|||||||>
INSERT INTO t_kota VALUES("29","2","CIMAHI","KOTA");<|||||||>
INSERT INTO t_kota VALUES("30","2","TASIK MALAYA","KOTA");<|||||||>
INSERT INTO t_kota VALUES("31","2","BANJAR","KOTA");<|||||||>
INSERT INTO t_kota VALUES("32","3","CILACAP","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("33","3","BANYUMAS","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("34","3","PURBALINGGA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("35","3","BANJARNEGARA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("36","3","KEBUMEN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("37","3","PURWOREJO","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("38","3","WONOSOBO","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("39","3","MAGELANG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("40","3","BOYOLALI","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("41","3","KLATEN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("42","3","SUKOHARJO","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("43","3","WONOGIRI","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("44","3","KARANG ANYAR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("45","3","SRAGEN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("46","3","GROBOGAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("47","3","BLORA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("48","3","REMBANG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("49","3","PATI","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("50","3","KUDUS","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("51","3","JEPARA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("52","3","DEMAK","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("53","3","SEMARANG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("54","3","TEMANGGUNG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("55","3","KENDAL","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("56","3","BATANG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("57","3","PEKALONGAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("58","3","PEMALANG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("59","3","TEGAL","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("60","3","BREBES","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("61","3","MAGELANG","KOTA");<|||||||>
INSERT INTO t_kota VALUES("62","3","SURAKARTA","KOTA");<|||||||>
INSERT INTO t_kota VALUES("63","3","SALATIGA","KOTA");<|||||||>
INSERT INTO t_kota VALUES("64","3","SEMARANG","KOTA");<|||||||>
INSERT INTO t_kota VALUES("65","3","PEKALONGAN","KOTA");<|||||||>
INSERT INTO t_kota VALUES("66","3","TEGAL","KOTA");<|||||||>
INSERT INTO t_kota VALUES("67","4","KULON PROGO","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("68","4","BANTUL","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("69","4","GUNUNG KIDUL","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("70","4","SLEMAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("71","4","YOGYAKARTA","KOTA");<|||||||>
INSERT INTO t_kota VALUES("72","5","PACITAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("73","5","PONOROGO","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("74","5","TRENGGALEK","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("75","5","TULUNGAGUNG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("76","5","BLITAR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("77","5","KEDIRI","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("78","5","MALANG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("79","5","LUMAJANG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("80","5","JEMBER","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("81","5","BANYUWANGI","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("82","5","BONDOWOSO","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("83","5","SITUBONDO","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("84","5","PROBOLINGGO","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("85","5","PASURUAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("86","5","SIDOARJO","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("87","5","MOJOKERTO","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("88","5","JOMBANG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("89","5","NGANJUK","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("90","5","MADIUN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("91","5","MAGETAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("92","5","NGAWI","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("93","5","BOJONEGORO","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("94","5","TUBAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("95","5","LAMONGAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("96","5","GRESIK","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("97","5","BANGKALAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("98","5","SAMPANG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("99","5","PAMEKASAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("100","5","SUMENEP","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("101","5","KEDIRI","KOTA");<|||||||>
INSERT INTO t_kota VALUES("102","5","BLITAR","KOTA");<|||||||>
INSERT INTO t_kota VALUES("103","5","MALANG","KOTA");<|||||||>
INSERT INTO t_kota VALUES("104","5","PROBOLINGGO","KOTA");<|||||||>
INSERT INTO t_kota VALUES("105","5","PASURUAN","KOTA");<|||||||>
INSERT INTO t_kota VALUES("106","5","MOJOKERTO","KOTA");<|||||||>
INSERT INTO t_kota VALUES("107","5","MADIUN","KOTA");<|||||||>
INSERT INTO t_kota VALUES("108","5","SURABAYA","KOTA");<|||||||>
INSERT INTO t_kota VALUES("109","5","BATU","KOTA");<|||||||>
INSERT INTO t_kota VALUES("110","6","SIMEULUE SINABUNG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("111","6","ACEH SINGKIL","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("112","6","ACEH SELATAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("113","6","ACEH TENGGARA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("114","6","ACEH TIMUR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("115","6","ACEH TENGAH","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("116","6","ACEH BARAT","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("117","6","ACEH BESAR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("118","6","PIDIE","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("119","6","BIREUEN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("120","6","ACEH UTARA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("121","6","ACEH BARAT DAYA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("122","6","GAYO LUES","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("123","6","ACEH TAMIANG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("124","6","NAGAN RAYA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("125","6","ACEH JAYA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("126","6","BANDA ACEH","KOTA");<|||||||>
INSERT INTO t_kota VALUES("127","6","SABANG","KOTA");<|||||||>
INSERT INTO t_kota VALUES("128","6","LANGSA","KOTA");<|||||||>
INSERT INTO t_kota VALUES("129","6","LHOKSEUMAWE","KOTA");<|||||||>
INSERT INTO t_kota VALUES("130","7","NIAS","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("131","7","MANDAILING NATAL","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("132","7","TAPANULI SELATAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("133","7","TAPANULI TENGAH","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("134","7","TAPANULI UTARA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("135","7","TOBA SAMOSIR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("136","7","LABUHAN BATU","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("137","7","ASAHAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("138","7","SIMALUNGUN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("139","7","DAIRI","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("140","7","KARO","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("141","7","DELI SERDANG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("142","7","LANGKAT","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("143","7","NIAS SELATAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("144","7","HUMBANG HASUNDUTAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("145","7","PAK-PAK BARAT","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("146","7","SIBOLGA","KOTA");<|||||||>
INSERT INTO t_kota VALUES("147","7","TANJUNG BALAI","KOTA");<|||||||>
INSERT INTO t_kota VALUES("148","7","PEMATANG SIANTAR","KOTA");<|||||||>
INSERT INTO t_kota VALUES("149","7","TEBING TINGGI","KOTA");<|||||||>
INSERT INTO t_kota VALUES("150","7","MEDAN","KOTA");<|||||||>
INSERT INTO t_kota VALUES("151","7","BINJAI","KOTA");<|||||||>
INSERT INTO t_kota VALUES("152","7","PADANG SIDEMPUAN","KOTA");<|||||||>
INSERT INTO t_kota VALUES("153","8","KEPULAUAN MENTAWAI","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("154","8","PESISIR SELATAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("155","8","SOLOK","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("156","8","SAWAH LUNTO","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("157","8","TANAH DATAR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("158","8","PADANG PARIAMAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("159","8","AGAM","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("160","8","LIMA PULUH KOTO","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("161","8","PASAMAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("162","8","PADANG","KOTA");<|||||||>
INSERT INTO t_kota VALUES("163","8","SOLOK","KOTA");<|||||||>
INSERT INTO t_kota VALUES("164","8","SAWAH LUNTO","KOTA");<|||||||>
INSERT INTO t_kota VALUES("165","8","PADANG PANJANG","KOTA");<|||||||>
INSERT INTO t_kota VALUES("166","8","BUKITTINGGI","KOTA");<|||||||>
INSERT INTO t_kota VALUES("167","8","PAYAKUMBUH","KOTA");<|||||||>
INSERT INTO t_kota VALUES("168","8","PARIAMAN","KOTA");<|||||||>
INSERT INTO t_kota VALUES("169","9","KUANTAN SINGINGI","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("170","9","INDRAGIRI HULU","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("171","9","INDRAGIRI HILIR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("172","9","PELALAWAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("173","9","SIAK","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("174","9","KAMPAR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("175","9","ROKAN HULU","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("176","9","BENGKALIS","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("177","9","ROKAN HILIR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("178","9","PEKANBARU","KOTA");<|||||||>
INSERT INTO t_kota VALUES("179","9","DUMAI","KOTA");<|||||||>
INSERT INTO t_kota VALUES("180","10","KERINCI","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("181","10","MERANGIN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("182","10","SAROLANGUN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("183","10","BATANG HARI","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("184","10","MUARO JAMBI","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("185","10","TANJUNG JABUNG TIMUR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("186","10","TANJUNG JABUNG BARAT","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("187","10","TEBO","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("188","10","BUNGO","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("189","10","JAMBI","KOTA");<|||||||>
INSERT INTO t_kota VALUES("190","11","OGAN KOMERING ULU","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("191","11","OGAN KOMERING ILIR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("192","11","MUARA ENIM","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("193","11","LAHAT","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("194","11","MUSI RAWAS","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("195","11","MUSI BANYUASIN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("196","11","BANYUASIN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("197","11","PALEMBANG","KOTA");<|||||||>
INSERT INTO t_kota VALUES("198","11","PRABUMULIH","KOTA");<|||||||>
INSERT INTO t_kota VALUES("199","11","PAGARALAM","KOTA");<|||||||>
INSERT INTO t_kota VALUES("200","11","LUBUK LINGGAU","KOTA");<|||||||>
INSERT INTO t_kota VALUES("201","12","LAMPUNG BARAT","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("202","12","TANGGAMUS","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("203","12","LAMPUNG SELATAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("204","12","LAMPUNG TIMUR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("205","12","LAMPUNG TENGAH","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("206","12","LAMPUNG UTARA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("207","12","WAY KANAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("208","12","TULANGBAWANG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("209","12","BANDAR LAMPUNG","KOTA");<|||||||>
INSERT INTO t_kota VALUES("210","12","METRO","KOTA");<|||||||>
INSERT INTO t_kota VALUES("211","13","SAMBAS","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("212","13","BENGKAYANG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("213","13","LANDAK","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("214","13","PONTIANAK","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("215","13","SANGGAU","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("216","13","KETAPANG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("217","13","SINTANG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("218","13","KAPUAS HULU","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("219","13","PONTIANAK","KOTA");<|||||||>
INSERT INTO t_kota VALUES("220","13","SINGKAWANG","KOTA");<|||||||>
INSERT INTO t_kota VALUES("221","14","KOTAWARINGIN BARAT","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("222","14","KOTAWARINGIN TIMUR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("223","14","KAPUAS","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("224","14","BARITO SELATAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("225","14","BARITO UTARA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("226","14","SUKAMARA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("227","14","LAMANDAU","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("228","14","SERUYAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("229","14","KATINGAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("230","14","PULANG PISAU","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("231","14","GUNUNG MAS","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("232","14","BARITO TIMUR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("233","14","MURUNG RAYA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("234","14","PALANGKA RAYA","KOTA");<|||||||>
INSERT INTO t_kota VALUES("235","15","TANAH LAUT","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("236","15","KOTABARU","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("237","15","BANJAR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("238","15","BARITO KUALA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("239","15","TAPIN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("240","15","HULU SUNGAI SELATAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("241","15","HULU SUNGAI TENGAH","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("242","15","HULU SUNGAI UTARA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("243","15","TABALONG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("244","15","TANAH BUMBU","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("245","15","BALANGAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("246","15","BANJARMASIN","KOTA");<|||||||>
INSERT INTO t_kota VALUES("247","15","BANJARBARU","KOTA");<|||||||>
INSERT INTO t_kota VALUES("248","16","PASIR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("249","16","KUTAI BARAT","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("250","16","KUTAI","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("251","16","KUTAI TIMUR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("252","16","BERAU","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("253","16","MALINAU","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("254","16","BULUNGAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("255","16","NUNUKAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("256","16","PENAJAM PASIR UTARA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("257","16","BALIKPAPAN","KOTA");<|||||||>
INSERT INTO t_kota VALUES("258","16","SAMARINDA","KOTA");<|||||||>
INSERT INTO t_kota VALUES("259","16","TARAKAN","KOTA");<|||||||>
INSERT INTO t_kota VALUES("260","16","BONTANG","KOTA");<|||||||>
INSERT INTO t_kota VALUES("261","17","BOLAANG MONGONDOW","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("262","17","MINAHASA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("263","17","SANGIHE","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("264","17","TALAUD","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("265","17","MINAHASA SELATAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("266","17","MANADO","KOTA");<|||||||>
INSERT INTO t_kota VALUES("267","17","BITUNG","KOTA");<|||||||>
INSERT INTO t_kota VALUES("268","17","TOMOHON","KOTA");<|||||||>
INSERT INTO t_kota VALUES("269","18","PULAU BANGGAI","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("270","18","BANGGAI","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("271","18","MOROWALI","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("272","18","POSO","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("273","18","DONGGALA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("274","18","TOLI-TOLI","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("275","18","BUOL","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("276","18","PARIGI MOUTONG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("277","18","PALU","KOTA");<|||||||>
INSERT INTO t_kota VALUES("278","19","SELAYAR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("279","19","BULUKUMBA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("280","19","BANTAENG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("281","19","JENEPONTO","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("282","19","TAKALAR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("283","19","GOWA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("284","19","SINJAI","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("285","19","MAROS","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("286","19","PANGKAJENE","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("287","19","BARRU","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("288","19","BONE","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("289","19","SOPPENG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("290","19","WAJO","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("291","19","SIDENRENG RAPPANG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("292","19","PINRANG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("293","19","ENREKANG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("294","19","LUWU","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("295","19","TANA TORAJA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("296","19","LUWU UTARA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("297","19","LUWU TIMUR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("298","19","MAKASSAR","KOTA");<|||||||>
INSERT INTO t_kota VALUES("299","19","PARE-PARE","KOTA");<|||||||>
INSERT INTO t_kota VALUES("300","19","PALOPO","KOTA");<|||||||>
INSERT INTO t_kota VALUES("301","20","BUTON","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("302","20","MUNA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("303","20","KENDARI","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("304","20","KOLAKA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("305","20","KENDARI","KOTA");<|||||||>
INSERT INTO t_kota VALUES("306","20","BAU-BAU","KOTA");<|||||||>
INSERT INTO t_kota VALUES("307","20","KONAWE SELATAN","KOTA");<|||||||>
INSERT INTO t_kota VALUES("308","21","MALUKU TENGGARA BARA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("309","21","MALUKU TENGGARA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("310","21","MALUKU TENGAH","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("311","21","BURU","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("312","21","AMBON","KOTA");<|||||||>
INSERT INTO t_kota VALUES("313","22","JEMBRANA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("314","22","TABANAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("315","22","BADUNG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("316","22","GIANYAR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("317","22","KLUNGKUNG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("318","22","BANGLI","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("319","22","KARANG ASEM","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("320","22","BULELENG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("321","22","DENPASAR","KOTA");<|||||||>
INSERT INTO t_kota VALUES("322","23","LOMBOK BARAT","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("323","23","LOMBOK TENGAH","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("324","23","LOMBOK TIMUR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("325","23","SUMBAWA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("326","23","DOMPU","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("327","23","BIMA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("328","23","MATARAM","KOTA");<|||||||>
INSERT INTO t_kota VALUES("329","23","BIMA","KOTA");<|||||||>
INSERT INTO t_kota VALUES("330","24","SUMBA BARAT","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("331","24","SUMBA TIMUR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("332","24","KUPANG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("333","24","TIMOR TENGAH SELATAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("334","24","TIMOR TENGAH UTARA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("335","24","BELU","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("336","24","ALOR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("337","24","LEMBATA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("338","24","FLORES TIMUR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("339","24","SIKKA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("340","24","ENDE","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("341","24","NGADA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("342","24","MANGGARAI","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("343","24","ROTE NDAO","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("344","24","MANGGARAI BARAT","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("345","24","KUPANG","KOTA");<|||||||>
INSERT INTO t_kota VALUES("346","25","MERAUKE","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("347","25","JAYA WIJAYA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("348","25","JAYAPURA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("349","25","NABIRE","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("350","25","YAPEN WAROPEN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("351","25","BIAK NUMFOR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("352","25","PANIAI","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("353","25","PUNCAK JAYA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("354","25","MIMIKA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("355","25","BOVEN DIGOEL","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("356","25","MAPPI","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("357","25","ASMAT","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("358","25","YAKUHIMO","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("359","25","GUNUNG BINTANG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("360","25","TOLIKARA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("361","25","SARMI","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("362","25","KEEROM","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("363","25","WAROPEN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("364","25","JAYAPURA","KOTA");<|||||||>
INSERT INTO t_kota VALUES("365","26","BENGKULU SELATAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("366","26","REJANG LEBONG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("367","26","BENGKULU UTARA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("368","26","KAUR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("369","26","SELUMA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("370","26","MUKO-MUKO","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("371","26","BENGKULU","KOTA");<|||||||>
INSERT INTO t_kota VALUES("372","27","PANDEGLANG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("373","27","LEBAK","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("374","27","TANGERANG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("375","27","SERANG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("376","27","TANGERANG","KOTA");<|||||||>
INSERT INTO t_kota VALUES("377","27","CILEGON","KOTA");<|||||||>
INSERT INTO t_kota VALUES("378","28","HALMAHERA BARAT","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("379","28","HALMAHERA TENGAH","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("380","28","PULAU SULA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("381","28","HALMAHERA SELATAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("382","28","HALMAHERA UTARA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("383","28","HALMAHERA TIMUR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("384","28","TERNATE","KOTA");<|||||||>
INSERT INTO t_kota VALUES("385","28","TIDORE","KOTA");<|||||||>
INSERT INTO t_kota VALUES("386","29","BANGKA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("387","29","BELITUNG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("388","29","BANGKA SELATAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("389","29","BANGKA TENGAH","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("390","29","BANGKA BARAT","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("391","29","BELITUNG TIMUR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("392","29","PANGKALPINANG","KOTA");<|||||||>
INSERT INTO t_kota VALUES("393","30","BOALEMO","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("394","30","GORONTALO","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("395","30","PUHUWATO","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("396","30","BONE BOLANGO","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("397","30","GORONTALO","KOTA");<|||||||>
INSERT INTO t_kota VALUES("398","31","FAK-FAK","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("399","31","SORONG","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("400","31","MANOKWARI","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("401","31","KAIMANA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("402","31","SORONG SELATAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("403","31","RAJA AMPAT","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("404","31","TELUK BINTUNI","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("405","31","TELUK WONDANA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("406","31","SORONG","KOTA");<|||||||>
INSERT INTO t_kota VALUES("407","32","KARIMUN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("408","32","KEPULAUAN RIAU","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("409","32","NATUNA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("410","32","BATAM","KOTA");<|||||||>
INSERT INTO t_kota VALUES("411","32","TANJUNG PINANG","KOTA");<|||||||>
INSERT INTO t_kota VALUES("412","33","MAMUJU","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("413","33","MAMUJU UTARA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("414","33","MAJENE","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("415","33","POLEWALI MANDAR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("416","33","MAMASA","KOTA");<|||||||>
INSERT INTO t_kota VALUES("417","11","OGAN ILIR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("418","11","OKU TIMUR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("419","11","OKU SELATAN","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("420","21","SERAM BAGIAN BARAT","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("421","21","SERAM BARAT TIMUR","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("422","21","ARU","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("423","17","MINAHASA UTARA","KABUPATEN");<|||||||>
INSERT INTO t_kota VALUES("424","25","SUPIORI","KOTA");<|||||||>



DROP TABLE t_kurs;<|||||||>

CREATE TABLE `t_kurs` (
  `id_kurs` varchar(3) NOT NULL,
  `nama_kurs` varchar(50) NOT NULL,
  `lambang_kurs` varchar(10) NOT NULL,
  `nilai_kurs` float NOT NULL,
  PRIMARY KEY  (`id_kurs`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;<|||||||>

INSERT INTO t_kurs VALUES("USD","Dollar Amerika","US$","9000");<|||||||>



DROP TABLE t_member;<|||||||>

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='Tabel Member';<|||||||>

INSERT INTO t_member VALUES("1","24","joni","kpo","23456789","43152","budi@localhost","e807f1fcf82d132f9bb018ca6738a19f","d013a8fadd4973bc17b113efcd0dd02f","1");<|||||||>



DROP TABLE t_merek;<|||||||>

CREATE TABLE `t_merek` (
  `id_merek` int(11) NOT NULL auto_increment,
  `kode_merek` varchar(3) NOT NULL,
  `nama_merek` varchar(50) NOT NULL,
  `deskripsi_merek` text NOT NULL,
  PRIMARY KEY  (`id_merek`),
  UNIQUE KEY `nama_kategori` (`nama_merek`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='Tabel Merek';<|||||||>

INSERT INTO t_merek VALUES("1","FND","Fender","Bagus banget");<|||||||>
INSERT INTO t_merek VALUES("2","RCK","Rock","bAGUS jUGA");<|||||||>
INSERT INTO t_merek VALUES("3","YMH","Yamaha","");<|||||||>
INSERT INTO t_merek VALUES("4","TMA","Tama","");<|||||||>
INSERT INTO t_merek VALUES("5","PRL","Pearl","Bagus		");<|||||||>



DROP TABLE t_ongkir;<|||||||>

CREATE TABLE `t_ongkir` (
  `id_ongkir` int(11) NOT NULL auto_increment,
  `id_kota` int(11) NOT NULL,
  `id_jeniskirim` int(11) NOT NULL,
  `harga_ongkir` int(11) NOT NULL,
  PRIMARY KEY  (`id_ongkir`)
) ENGINE=MyISAM AUTO_INCREMENT=65 DEFAULT CHARSET=latin1 COMMENT='Tabel Ongkos Kirim';<|||||||>

INSERT INTO t_ongkir VALUES("1","1","1","12000");<|||||||>
INSERT INTO t_ongkir VALUES("2","2","1","8000");<|||||||>
INSERT INTO t_ongkir VALUES("3","3","1","8000");<|||||||>
INSERT INTO t_ongkir VALUES("4","4","1","8000");<|||||||>
INSERT INTO t_ongkir VALUES("5","5","1","8000");<|||||||>
INSERT INTO t_ongkir VALUES("6","6","1","8000");<|||||||>
INSERT INTO t_ongkir VALUES("7","7","1","8000");<|||||||>
INSERT INTO t_ongkir VALUES("8","8","1","9000");<|||||||>
INSERT INTO t_ongkir VALUES("9","9","1","10000");<|||||||>
INSERT INTO t_ongkir VALUES("10","10","1","5000");<|||||||>
INSERT INTO t_ongkir VALUES("11","11","1","7000");<|||||||>
INSERT INTO t_ongkir VALUES("12","12","1","8000");<|||||||>
INSERT INTO t_ongkir VALUES("13","13","1","10000");<|||||||>
INSERT INTO t_ongkir VALUES("14","14","1","14000");<|||||||>
INSERT INTO t_ongkir VALUES("15","15","1","14000");<|||||||>
INSERT INTO t_ongkir VALUES("16","16","1","14000");<|||||||>
INSERT INTO t_ongkir VALUES("17","17","1","14000");<|||||||>
INSERT INTO t_ongkir VALUES("18","18","1","17000");<|||||||>
INSERT INTO t_ongkir VALUES("19","19","1","9000");<|||||||>
INSERT INTO t_ongkir VALUES("20","20","1","8000");<|||||||>
INSERT INTO t_ongkir VALUES("21","21","1","12000");<|||||||>
INSERT INTO t_ongkir VALUES("22","22","1","10000");<|||||||>
INSERT INTO t_ongkir VALUES("23","23","1","8000");<|||||||>
INSERT INTO t_ongkir VALUES("24","24","1","9000");<|||||||>
INSERT INTO t_ongkir VALUES("25","25","1","100");<|||||||>
INSERT INTO t_ongkir VALUES("26","26","1","9000");<|||||||>
INSERT INTO t_ongkir VALUES("27","27","1","9000");<|||||||>
INSERT INTO t_ongkir VALUES("28","28","1","10000");<|||||||>
INSERT INTO t_ongkir VALUES("29","29","1","7000");<|||||||>
INSERT INTO t_ongkir VALUES("30","30","1","8000");<|||||||>
INSERT INTO t_ongkir VALUES("31","1","2","12000");<|||||||>
INSERT INTO t_ongkir VALUES("32","2","2","12000");<|||||||>
INSERT INTO t_ongkir VALUES("33","3","2","12000");<|||||||>
INSERT INTO t_ongkir VALUES("34","4","2","12000");<|||||||>
INSERT INTO t_ongkir VALUES("35","5","2","12000");<|||||||>
INSERT INTO t_ongkir VALUES("36","6","2","12000");<|||||||>
INSERT INTO t_ongkir VALUES("37","7","2","14000");<|||||||>
INSERT INTO t_ongkir VALUES("38","8","2","14000");<|||||||>
INSERT INTO t_ongkir VALUES("39","9","2","14000");<|||||||>
INSERT INTO t_ongkir VALUES("40","10","2","10000");<|||||||>
INSERT INTO t_ongkir VALUES("41","11","2","10000");<|||||||>
INSERT INTO t_ongkir VALUES("42","12","2","10000");<|||||||>
INSERT INTO t_ongkir VALUES("43","13","2","12000");<|||||||>
INSERT INTO t_ongkir VALUES("44","14","2","20500");<|||||||>
INSERT INTO t_ongkir VALUES("45","15","2","16000");<|||||||>
INSERT INTO t_ongkir VALUES("46","16","2","14000");<|||||||>
INSERT INTO t_ongkir VALUES("47","17","2","10500");<|||||||>
INSERT INTO t_ongkir VALUES("48","18","2","20500");<|||||||>
INSERT INTO t_ongkir VALUES("49","19","2","10500");<|||||||>
INSERT INTO t_ongkir VALUES("50","20","2","10500");<|||||||>
INSERT INTO t_ongkir VALUES("51","21","2","18000");<|||||||>
INSERT INTO t_ongkir VALUES("52","22","2","14000");<|||||||>
INSERT INTO t_ongkir VALUES("53","23","2","14000");<|||||||>
INSERT INTO t_ongkir VALUES("54","24","2","14000");<|||||||>
INSERT INTO t_ongkir VALUES("55","25","2","9000");<|||||||>
INSERT INTO t_ongkir VALUES("57","26","2","16000");<|||||||>
INSERT INTO t_ongkir VALUES("58","27","2","14000");<|||||||>
INSERT INTO t_ongkir VALUES("59","28","2","16000");<|||||||>
INSERT INTO t_ongkir VALUES("60","29","2","7000");<|||||||>
INSERT INTO t_ongkir VALUES("61","30","1","10000");<|||||||>
INSERT INTO t_ongkir VALUES("63","32","3","21000");<|||||||>
INSERT INTO t_ongkir VALUES("64","170","1","47000");<|||||||>



DROP TABLE t_pembelian;<|||||||>

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;<|||||||>

INSERT INTO t_pembelian VALUES("1","mmbs5eh59ih4vudsv0ntigr075","2011-11-22 15:02:43","0000-00-00 00:00:00","0000-00-00","0000-00-00","pesan","1","1","","joni","kpo","23456789","24","43152","14000","","2","","","0","","136222");<|||||||>
INSERT INTO t_pembelian VALUES("2","1f4t57gkap4rp61se675aaam75","2011-11-24 09:53:52","2011-11-24 11:13:24","2011-12-04","2011-12-04","terima","2","1","transfer","joni","kpo","23456789","24","43152","28000","987654345678","2","Mandiri","4353546","1828000","2","1828000");<|||||||>
INSERT INTO t_pembelian VALUES("3","1f4t57gkap4rp61se675aaam75","2011-11-24 10:52:05","2011-11-24 11:10:43","2011-12-05","2011-12-05","terima","2","1","transfer","joni","kpo","23456789","24","43152","45000","09876543210987","1","HSBC","23435454","2417222","1","2417222");<|||||||>



DROP TABLE t_pemesanan;<|||||||>

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='Temporari Pemesanan';<|||||||>

INSERT INTO t_pemesanan VALUES("3","1","97brhs1t9to263ip0063vog6h4","2","2","1800000","2011-11-19");<|||||||>



DROP TABLE t_produk;<|||||||>

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COMMENT='Tabel Produk';<|||||||>

INSERT INTO t_produk VALUES("0003","1","1","Bagus","2000000","bagus Lho","10","0","0","28");<|||||||>
INSERT INTO t_produk VALUES("0004","1","1","jelek","122222","		asa										","0","0","0","133");<|||||||>
INSERT INTO t_produk VALUES("0005","2","2","Drums Bagus","2500000","Drums Bagus canggih sekali","10","0","0","20");<|||||||>
INSERT INTO t_produk VALUES("0006","3","2","GIG MAKER","6000000","		as		","5","0","0","8");<|||||||>
INSERT INTO t_produk VALUES("0007","3","2","STAGE CUSTOM BIRCH","6500000","Borrowing from our legendary Recording Custom drum sets, the world-famous Yamaha birch sound is now available in an affordable package. From the YESS mounting system to the tom ball clamps to the rich lacquer finishes, the Stage Custom Birch encompasses value, quality, and craftsmanship.","10","0","0","28");<|||||||>
INSERT INTO t_produk VALUES("0008","3","2","Tour Custom","5600000","Designed for Rock drummers from the start, Rock Tour is ideal for live situations when you need to cut through a wall of guitars.Designed for Rock drummers from the start, Rock Tour is ideal for live situations when you need to cut through a wall of guitars.Designed for Rock drummers from the start, Rock Tour is ideal for live situations when you need to cut through a wall of guitars.","10","0","0","8");<|||||||>



DROP TABLE t_provinsi;<|||||||>

CREATE TABLE `t_provinsi` (
  `id_provinsi` int(10) NOT NULL auto_increment,
  `nama_provinsi` varchar(30) default NULL,
  KEY `id_prov` (`id_provinsi`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1 COMMENT='Tabel Provinsi';<|||||||>

INSERT INTO t_provinsi VALUES("1","DKI JAKARTA");<|||||||>
INSERT INTO t_provinsi VALUES("2","JAWA BARAT");<|||||||>
INSERT INTO t_provinsi VALUES("3","JAWA TENGAH");<|||||||>
INSERT INTO t_provinsi VALUES("4","D I YOGYAKARTA");<|||||||>
INSERT INTO t_provinsi VALUES("5","JAWA TIMUR");<|||||||>
INSERT INTO t_provinsi VALUES("6","ACEH DARUSSALAM");<|||||||>
INSERT INTO t_provinsi VALUES("7","SUMATERA UTARA");<|||||||>
INSERT INTO t_provinsi VALUES("8","SUMATERA BARAT");<|||||||>
INSERT INTO t_provinsi VALUES("9","RIAU");<|||||||>
INSERT INTO t_provinsi VALUES("10","JAMBI");<|||||||>
INSERT INTO t_provinsi VALUES("11","SUMATERA SELATAN");<|||||||>
INSERT INTO t_provinsi VALUES("12","LAMPUNG");<|||||||>
INSERT INTO t_provinsi VALUES("13","KALIMANTAN BARAT");<|||||||>
INSERT INTO t_provinsi VALUES("14","KALIMANTAN TENGAH");<|||||||>
INSERT INTO t_provinsi VALUES("15","KALIMANTAN SELATAN");<|||||||>
INSERT INTO t_provinsi VALUES("16","KALIMANTAN TIMUR");<|||||||>
INSERT INTO t_provinsi VALUES("17","SULAWESI UTARA");<|||||||>
INSERT INTO t_provinsi VALUES("18","SULAWESI TENGAH");<|||||||>
INSERT INTO t_provinsi VALUES("19","SULAWESI SELATAN");<|||||||>
INSERT INTO t_provinsi VALUES("20","SULAWESI TENGGARA");<|||||||>
INSERT INTO t_provinsi VALUES("21","MALUKU");<|||||||>
INSERT INTO t_provinsi VALUES("22","BALI");<|||||||>
INSERT INTO t_provinsi VALUES("23","NUSA TENGGARA BARAT");<|||||||>
INSERT INTO t_provinsi VALUES("24","NUSA TENGGARA TIMUR");<|||||||>
INSERT INTO t_provinsi VALUES("25","PAPUA");<|||||||>
INSERT INTO t_provinsi VALUES("26","BENGKULU");<|||||||>
INSERT INTO t_provinsi VALUES("27","BANTEN");<|||||||>
INSERT INTO t_provinsi VALUES("28","MALUKU UTARA");<|||||||>
INSERT INTO t_provinsi VALUES("29","BANGKA BELITUNG");<|||||||>
INSERT INTO t_provinsi VALUES("30","GORONTALO");<|||||||>
INSERT INTO t_provinsi VALUES("31","IRIAN JAYA BARAT");<|||||||>
INSERT INTO t_provinsi VALUES("32","KEPULAUAN RIAU");<|||||||>
INSERT INTO t_provinsi VALUES("33","SULAWESI BARAT");<|||||||>



DROP TABLE t_rekening;<|||||||>

CREATE TABLE `t_rekening` (
  `id_rekening` int(11) NOT NULL auto_increment,
  `nama_rekening` varchar(50) NOT NULL,
  `bank_rekening` varchar(50) NOT NULL,
  `cabang_rekening` varchar(100) NOT NULL,
  `no_rekening` varchar(32) NOT NULL,
  `gambar_rekening` varchar(200) NOT NULL,
  PRIMARY KEY  (`id_rekening`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='Tabel Rekening';<|||||||>

INSERT INTO t_rekening VALUES("1","Afriliyan","BNI","ITB Bandung","089756656541","c6d2921aa6f2ec9b1e092a5a0ad15addicon_bni.gif");<|||||||>
INSERT INTO t_rekening VALUES("2","Afriliyan","BCA","Dago Bandung","09788779798","f4afe1fd002b3215b968b351b199b4e5icon_bca.gif");<|||||||>



DROP TABLE t_retur;<|||||||>

CREATE TABLE `t_retur` (
  `id_retur` int(11) NOT NULL auto_increment,
  `id_member` int(11) NOT NULL,
  `jasa_kirim` varchar(30) NOT NULL,
  `no_kirim` varchar(20) NOT NULL,
  `tgl_retur` date NOT NULL,
  `total_retur` int(11) NOT NULL,
  `status_retur` varchar(10) NOT NULL,
  PRIMARY KEY  (`id_retur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel Retur';<|||||||>




DROP TABLE t_testiproduk;<|||||||>

CREATE TABLE `t_testiproduk` (
  `id_testi` int(11) NOT NULL auto_increment,
  `id_produk` int(4) unsigned zerofill NOT NULL,
  `id_member` int(11) NOT NULL,
  `testimoni` text NOT NULL,
  `status_testi` enum('1','0') NOT NULL,
  `tgl_testi` datetime NOT NULL,
  PRIMARY KEY  (`id_testi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;<|||||||>




DROP TABLE t_warna;<|||||||>

CREATE TABLE `t_warna` (
  `id_warna` int(11) NOT NULL auto_increment,
  `nama_warna` varchar(50) NOT NULL,
  `format_warna` varchar(10) default NULL,
  PRIMARY KEY  (`id_warna`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='Tabel Warna';<|||||||>

INSERT INTO t_warna VALUES("1","Biru","#090");<|||||||>
INSERT INTO t_warna VALUES("2","Hitam","#000");<|||||||>
INSERT INTO t_warna VALUES("3","Merah","#F00");<|||||||>
INSERT INTO t_warna VALUES("4","Hijau","#09f");<|||||||>
INSERT INTO t_warna VALUES("5","Krem","#576");<|||||||>
INSERT INTO t_warna VALUES("6","Coklat","#F57");<|||||||>



