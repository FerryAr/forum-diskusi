-- Adminer 4.8.1 MySQL 5.5.5-10.5.11-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `forum`;
CREATE DATABASE `forum` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `forum`;

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_reply` int(11) NOT NULL,
  `id_user` int(11) unsigned NOT NULL,
  `isi` text NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) unsigned NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) unsigned DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `parent_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `id_reply` (`id_reply`),
  KEY `id_user` (`id_user`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`),
  CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `comment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`id_reply`) REFERENCES `reply` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `comment_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `comment_ibfk_5` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `comment_ibfk_6` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `comment` (`id`, `id_reply`, `id_user`, `isi`, `created_at`, `created_by`, `updated_at`, `updated_by`, `reason`, `parent_id`) VALUES
(4,	3,	3,	'test komen',	'2021-07-12 10:27:57',	3,	NULL,	NULL,	NULL,	NULL),
(5,	3,	3,	'test bales comment',	'2021-07-12 10:41:00',	3,	NULL,	NULL,	NULL,	4),
(6,	3,	1,	'di bales neh',	'2021-07-12 10:43:55',	3,	NULL,	NULL,	NULL,	4);

DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1,	'admin',	'Administrator'),
(2,	'members',	'General User');

DROP TABLE IF EXISTS `login_attempts`;
CREATE TABLE `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `pelajaran`;
CREATE TABLE `pelajaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pelajaran` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `pelajaran` (`id`, `pelajaran`) VALUES
(1,	'Matematika'),
(2,	'B. Indonesia'),
(3,	'B. Jawa');

DROP TABLE IF EXISTS `pesan`;
CREATE TABLE `pesan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pengirim` int(11) unsigned NOT NULL,
  `id_penerima` int(11) unsigned NOT NULL,
  `subject` text CHARACTER SET utf8 NOT NULL,
  `pesan` text CHARACTER SET utf8 NOT NULL,
  `is_read` smallint(6) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `pesan_ibfk_1` (`id_penerima`),
  KEY `pesan_ibfk_2` (`id_pengirim`),
  CONSTRAINT `pesan_ibfk_1` FOREIGN KEY (`id_penerima`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `pesan_ibfk_2` FOREIGN KEY (`id_pengirim`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `pesan` (`id`, `id_pengirim`, `id_penerima`, `subject`, `pesan`, `is_read`, `created`) VALUES
(1,	1,	3,	'testing',	'testing pesan',	1,	'2021-07-10 08:53:22'),
(2,	3,	1,	'testing',	'test outbox',	1,	'2021-07-10 09:38:06'),
(3,	4,	1,	'test',	'test kirim pesan',	1,	'2021-07-10 14:32:19');

DROP TABLE IF EXISTS `reply`;
CREATE TABLE `reply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_thread` int(11) NOT NULL,
  `id_user` int(11) unsigned NOT NULL,
  `isi` text NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) unsigned NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) unsigned DEFAULT NULL,
  `reason` text CHARACTER SET utf8 DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reply_ibfk_1` (`id_thread`),
  KEY `reply_ibfk_2` (`id_user`),
  KEY `reply_ibfk_3` (`created_by`),
  KEY `reply_ibfk_4` (`updated_by`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `reply_ibfk_1` FOREIGN KEY (`id_thread`) REFERENCES `thread` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `reply_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `reply_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `reply_ibfk_4` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `reply_ibfk_5` FOREIGN KEY (`parent_id`) REFERENCES `reply` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `reply` (`id`, `id_thread`, `id_user`, `isi`, `created_at`, `created_by`, `updated_at`, `updated_by`, `reason`, `parent_id`) VALUES
(3,	1017,	1,	'<p>testing</p>\r\n',	'2021-07-12 10:26:56',	1,	'2021-07-12 13:57:34',	1,	'a',	NULL),
(7,	1017,	3,	'testing',	'2021-07-12 14:28:39',	3,	NULL,	NULL,	NULL,	3);

DROP TABLE IF EXISTS `thread`;
CREATE TABLE `thread` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(100) NOT NULL,
  `isi` text NOT NULL,
  `id_pelajaran` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) unsigned NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) unsigned DEFAULT NULL,
  `reason` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pelajaran` (`id_pelajaran`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`),
  CONSTRAINT `thread_ibfk_1` FOREIGN KEY (`id_pelajaran`) REFERENCES `pelajaran` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `thread_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `thread_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `thread` (`id`, `judul`, `isi`, `id_pelajaran`, `created_at`, `created_by`, `updated_at`, `updated_by`, `reason`) VALUES
(1017,	'Sistem Persamaan Linear',	'<p><strong>Sistem persamaan linear</strong> adalah persamaan-persamaan linear yang dikorelasikan untuk membentuk suatu sistem. Sistem persamaannya bisa terdiri dari satu variabel, dua variabel atau lebih. Dalam bahasan ini, kita hanya membahas sistem persamaan linear dengan dua dan tiga variabel.</p>\r\n\r\n<h2>Sistem Persamaan Linear Dua Variabel (SPLDV)</h2>\r\n\r\n<p>Sistem persamaan linear dua variabel adalah sistem persamaan linear yang terdiri dari dua persamaan dimana masing-masing persamaan memiliki dua variabel. Contoh SPLDV dengan variabel <img alt=\"x\" src=\"https://s0.wp.com/latex.php?latex=x&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> dan <img alt=\"y\" src=\"https://s0.wp.com/latex.php?latex=y&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />:</p>\r\n\r\n<p><img alt=\"\\\\begin{cases}ax+by=c \\\\\\\\ px-qy=r \\\\end{cases}\" src=\"https://s0.wp.com/latex.php?latex=\\\\begin{cases}ax+by=c+\\\\\\\\+px-qy=r+\\\\end{cases}&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /></p>\r\n\r\n<p>dimana&nbsp;<img alt=\"a, b, c, p, q\" src=\"https://s0.wp.com/latex.php?latex=a,+b,+c,+p,+q&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />, dan <img alt=\"r\" src=\"https://s0.wp.com/latex.php?latex=r&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> adalah bilangan-bilangan real.</p>\r\n\r\n<p>Penyelesaian SPLDV</p>\r\n\r\n<p>Penyelesaian SP:DV bertujuan untuk menentukan nilai yang memenuhi kedua persamaan yang ada pada SPLDV. Penyelesaian SPLDV terdapat beberapa cara, yaitu:</p>\r\n\r\n<h3>Metode grafik</h3>\r\n\r\n<p>Pada metode grafik ini, langkah-langkah yang dilakukan pertama adalah menentukan grafik garis dari masing-masing persamaan kemudian menentukan titik potong dari kedua garis. Titik potong dari kedua garis tersebut adalah penyelesaian dari SPLDV.</p>\r\n\r\n<p>Contoh Soal:<br />\r\nTentukah penyelesaian dari SPLDV berikut:</p>\r\n\r\n<p><img alt=\"\\\\begin{cases}-x+y=1 \\\\\\\\ x+y=5 \\\\end{cases}\" src=\"https://s0.wp.com/latex.php?latex=\\\\begin{cases}-x+y=1+\\\\\\\\+x+y=5+\\\\end{cases}&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /></p>\r\n\r\n<p>Jawab:<br />\r\nLangkah pertama tentukan garis dari masing-masing persamaan.</p>\r\n\r\n<p><img alt=\"grafik sistem persamaan linear\" src=\"https://i2.wp.com/www.studiobelajar.com/wp-content/uploads/2015/10/grafik-sistem-persamaan-linear.jpg?w=960\" /></p>\r\n\r\n<p>Setelah diperoleh grafik dari kedua persamaan, sekarang menentukan titik potong dari kedua garis dan menentukan koordinat dari titik potong tesebut.</p>\r\n\r\n<p><img alt=\"spldv spltv\" src=\"https://i2.wp.com/www.studiobelajar.com/wp-content/uploads/2015/10/spldv-spltv.jpg?w=960\" /></p>\r\n\r\n<p>Dari grafik sistem persamaan linear diatas diperoleh titik potong dengan koordinat <img alt=\"(2, 3)\" src=\"https://s0.wp.com/latex.php?latex=(2,+3)&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />, sehingga penyelesaian dari SPLDV adalah <img alt=\"2, 3\" src=\"https://s0.wp.com/latex.php?latex=2,+3&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />.</p>\r\n\r\n<p>Untuk membuktikan penyelesaian dari SPLDV, penyelesaian tersebut kita subtitusikan ke persamaan dengan <img alt=\"x=2\" src=\"https://s0.wp.com/latex.php?latex=x=2&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> dan <img alt=\"y=3\" src=\"https://s0.wp.com/latex.php?latex=y=3&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />.</p>\r\n\r\n<p><img alt=\"\\\\begin{cases} -(2) + (3) = 1 \\\\\\\\ 2+3=5 \\\\end{cases}\" src=\"https://s0.wp.com/latex.php?latex=\\\\begin{cases}+-(2)+++(3)+=+1+\\\\\\\\+2+3=5+\\\\end{cases}&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /></p>\r\n\r\n<p>Pada metode grafik ini, terdapat beberapa jenis himpunan penyelesaian berdasarkan grafik persamaan, yaitu:</p>\r\n\r\n<ul>\r\n	<li>\r\n	<ul>\r\n		<li>Jika kedua garis berpotongan, maka perpotonga kedua garis adalah penyelesaian dari SPLDV dan memiliki satu penyelesaian.</li>\r\n		<li>Jika kedua garis sejajar, maka SPLDV tidak memiliki penyelesaian</li>\r\n		<li>Jika kedua garis saling berhimpit, maka SPLDV memiliki tak berhingga himpunan penyelesaian.</li>\r\n	</ul>\r\n	</li>\r\n</ul>\r\n\r\n<h3>Metode eliminasi</h3>\r\n\r\n<p>Pada metode eliminasi ini, menentukan penyelesaian dari variabel <img alt=\"x\" src=\"https://s0.wp.com/latex.php?latex=x&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> dengan cara mengeliminasi variabel <img alt=\"y\" src=\"https://s0.wp.com/latex.php?latex=y&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />, dan untuk menentukan penyelesaian variabel <img alt=\"y\" src=\"https://s0.wp.com/latex.php?latex=y&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> dengan cara mengeliminasi variabel <img alt=\"x\" src=\"https://s0.wp.com/latex.php?latex=x&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />.</p>\r\n\r\n<p>Contoh Soal:<br />\r\nTentukah penyelesaian dari sistem persamaan linear dua variabel berikut:</p>\r\n\r\n<p><img alt=\"\\\\begin{cases} -x +y=1 \\\\cdots (I) \\\\\\\\ x+y=5 \\\\cdots (II) \\\\end{cases}\" src=\"https://s0.wp.com/latex.php?latex=\\\\begin{cases}+-x++y=1+\\\\cdots+(I)+\\\\\\\\+x+y=5+\\\\cdots+(II)+\\\\end{cases}&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /></p>\r\n\r\n<p>Jawab:<br />\r\nPertama menentukan penyelesaian dari variabel <img alt=\"x\" src=\"https://s0.wp.com/latex.php?latex=x&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />.</p>\r\n\r\n<p>Mengeliminasi variabel <img alt=\"y\" src=\"https://s0.wp.com/latex.php?latex=y&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> dapat dilakukan dengan mengurangi persamaan I dengan persamaan II.</p>\r\n\r\n<p>Diperoleh persamaan akhir <img alt=\"-2x = -4\" src=\"https://s0.wp.com/latex.php?latex=-2x+=+-4&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />, bagi kedua ruas dengan -2, diperoleh penyelesaian <img alt=\"x=2\" src=\"https://s0.wp.com/latex.php?latex=x=2&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />.</p>\r\n\r\n<p>Kedua menentukan penyelesaian dari variabel <img alt=\"x\" src=\"https://s0.wp.com/latex.php?latex=x&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /></p>\r\n\r\n<p>Mengeliminasi variabel <img alt=\"x\" src=\"https://s0.wp.com/latex.php?latex=x&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> dapat dilakukan dengan menjumlahkan persamaan I dengan persamaan II.</p>\r\n\r\n<p>Diperoleh persamaan akhir <img alt=\"2y=6\" src=\"https://s0.wp.com/latex.php?latex=2y=6&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />, bagi kedua ruas dengan 2, diperoleh penyelesaian <img alt=\"y=3\" src=\"https://s0.wp.com/latex.php?latex=y=3&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /></p>\r\n\r\n<p>Sehingga himpunan penyelesaian dari SPLDV tersebut adalah <img alt=\"(2, 3)\" src=\"https://s0.wp.com/latex.php?latex=(2,+3)&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />.</p>\r\n\r\n<h3>Metode substitusi</h3>\r\n\r\n<p>Pada metode substitusi, langkah pertama yang dilakukan adalah mengubah salah satu persamaan menjadi persamaan fungsi, yaitu <img alt=\"x\" src=\"https://s0.wp.com/latex.php?latex=x&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> sebagai fungsi dari <img alt=\"y\" src=\"https://s0.wp.com/latex.php?latex=y&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> atau&nbsp;<img alt=\"y\" src=\"https://s0.wp.com/latex.php?latex=y&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> sebagai fungsi dari <img alt=\"x\" src=\"https://s0.wp.com/latex.php?latex=x&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />. Kemudian subtitusikan <img alt=\"x\" src=\"https://s0.wp.com/latex.php?latex=x&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> atau <img alt=\"y\" src=\"https://s0.wp.com/latex.php?latex=y&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> pada persamaan yang lain.</p>\r\n\r\n<p>Contoh Soal:<br />\r\nTentukah penyelesaian dari SPLDV berikut:</p>\r\n\r\n<p><img alt=\"\\\\begin{cases} -x+y=1 \\\\cdots (I) \\\\\\\\ x+y=5 \\\\cdots (II) \\\\end{cases}\" src=\"https://s0.wp.com/latex.php?latex=\\\\begin{cases}+-x+y=1+\\\\cdots+(I)+\\\\\\\\+x+y=5+\\\\cdots+(II)+\\\\end{cases}&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /></p>\r\n\r\n<p>Jawab:<br />\r\nUbah persamaan (I) menjadi bentuk fungsi&nbsp;<img alt=\"-x+y=1\" src=\"https://s0.wp.com/latex.php?latex=-x+y=1&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> dengan memindahkan variabel <img alt=\"x\" src=\"https://s0.wp.com/latex.php?latex=x&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> ke ruas kanan menjadi <img alt=\"y=1+x\" src=\"https://s0.wp.com/latex.php?latex=y=1+x&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />.</p>\r\n\r\n<p>Kemudian persamaan fungsi <img alt=\"y\" src=\"https://s0.wp.com/latex.php?latex=y&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> disubtitusikan pada persamaan (II), menjadi <img alt=\"x+(1+x)=5\" src=\"https://s0.wp.com/latex.php?latex=x+(1+x)=5&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />. Diperoleh persamaan <img alt=\"2x+1=5\" src=\"https://s0.wp.com/latex.php?latex=2x+1=5&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> dan kurangi masing-masing ruas dengan 1, menjadi <img alt=\"2x-4\" src=\"https://s0.wp.com/latex.php?latex=2x-4&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />. Kemudian bagi kedua ruas dengan 2 menjadi <img alt=\"x=2\" src=\"https://s0.wp.com/latex.php?latex=x=2&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />. Hasil variabel <img alt=\"x\" src=\"https://s0.wp.com/latex.php?latex=x&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> disubtitusikan pada salah satu persamaan awal, misal pada persamaan (I), menjadi <img alt=\"-(2)=y=1\" src=\"https://s0.wp.com/latex.php?latex=-(2)=y=1&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />, jadi <img alt=\"y=1+2\" src=\"https://s0.wp.com/latex.php?latex=y=1+2&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> atau <img alt=\"y=3\" src=\"https://s0.wp.com/latex.php?latex=y=3&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />.</p>\r\n\r\n<p>Sehingga himpunan penyelesaian sistem persamaan linear dua variabel nya adalah <img alt=\"(2, 3)\" src=\"https://s0.wp.com/latex.php?latex=(2,+3)&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />.</p>\r\n\r\n<h3>Metode eliminasi-subtitusi</h3>\r\n\r\n<p>Metode ini adalah gabungan dari metode eliminasi dan subtitusi. Pertama eliminasi salah satu variabel, kemudian penyelesaian dari variabel yang diperoleh disubtitusikan pada salah satu persamaan.</p>\r\n\r\n<p>Coba kerjakan soal di atas dengan menggunakan metode eliminasi-substitusi.</p>\r\n\r\n<h2>Sistem Persamaan Linear Tiga Variabel (SPLTV)</h2>\r\n\r\n<p>Sistem persamaan linear tiga variabel adalah sistem persamaan yang terdiri dari tiga persamaan dimana masing-masing persamaan memiliki tiga variabel. Contoh SPLTV dengan variabel <img alt=\"x, y\" src=\"https://s0.wp.com/latex.php?latex=x,+y&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> dan <img alt=\"z\" src=\"https://s0.wp.com/latex.php?latex=z&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />:</p>\r\n\r\n<p><img alt=\"\\\\begin{cases} a_1x_1+b_1y_1+c_1z_1=d_1 \\\\\\\\ a_2x_2+b_2y_2+c_2z_2=d_2 \\\\\\\\ a_3x_3+b_3y_3+c_3z_3=d_3 \\\\end{cases}\" src=\"https://s0.wp.com/latex.php?latex=\\\\begin{cases}+a_1x_1+b_1y_1+c_1z_1=d_1+\\\\\\\\+a_2x_2+b_2y_2+c_2z_2=d_2+\\\\\\\\+a_3x_3+b_3y_3+c_3z_3=d_3+\\\\end{cases}&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /></p>\r\n\r\n<p>dimana <img alt=\"a, b, c\" src=\"https://s0.wp.com/latex.php?latex=a,+b,+c&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> dan <img alt=\"d\" src=\"https://s0.wp.com/latex.php?latex=d&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> adalah bilangan-bilangan real.</p>\r\n\r\n<p>Pada SPLTV terdapat 2 cara penyelesaian, yaitu:</p>\r\n\r\n<ol>\r\n	<li>Metode Subtitusi</li>\r\n</ol>\r\n\r\n<p>Langkah yang dilakukan pada metode ini yaitu:</p>\r\n\r\n<ol>\r\n	<li>Ubah salah satu persamaan yang ada pada sistem dan nyatakan <img alt=\"x\" src=\"https://s0.wp.com/latex.php?latex=x&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> sebagai fungsi dari <img alt=\"y\" src=\"https://s0.wp.com/latex.php?latex=y&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> dan <img alt=\"z\" src=\"https://s0.wp.com/latex.php?latex=z&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />, atau <img alt=\"y\" src=\"https://s0.wp.com/latex.php?latex=y&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> sebagai fungsi dari <img alt=\"x\" src=\"https://s0.wp.com/latex.php?latex=x&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> dan <img alt=\"z\" src=\"https://s0.wp.com/latex.php?latex=z&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />, atau <img alt=\"z\" src=\"https://s0.wp.com/latex.php?latex=z&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> sebagai fungsi dari <img alt=\"x\" src=\"https://s0.wp.com/latex.php?latex=x&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> dan <img alt=\"y\" src=\"https://s0.wp.com/latex.php?latex=y&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />..</li>\r\n	<li>Subtitusikan fungsi <img alt=\"x\" src=\"https://s0.wp.com/latex.php?latex=x&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> atau <img alt=\"y\" src=\"https://s0.wp.com/latex.php?latex=y&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> atau <img alt=\"z\" src=\"https://s0.wp.com/latex.php?latex=z&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> dari langkah pertama pada dua persamaan yang lain, sehingga diperoleh SPLDV.</li>\r\n	<li>Selesaikan SPLDV yang diperoleh dengan metode yang dibahas pada penyelesaian SPLDV di atas.</li>\r\n</ol>\r\n\r\n<p>Contoh Soal:<br />\r\nTentukan penyelesaian dari sistem persamaan linear tiga variabel berikut:</p>\r\n\r\n<p><img alt=\"\\\\begin{cases} x-2y+z=6 \\\\cdots (I) \\\\\\\\ 3x+y-2z=4 \\\\cdots (II) \\\\\\\\ 7x-6y-z=10 \\\\cdots (III) \\\\end{cases}\" src=\"https://s0.wp.com/latex.php?latex=\\\\begin{cases}+x-2y+z=6+\\\\cdots+(I)+\\\\\\\\+3x+y-2z=4+\\\\cdots+(II)+\\\\\\\\+7x-6y-z=10+\\\\cdots+(III)+\\\\end{cases}&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />.</p>\r\n\r\n<p>Jawab:</p>\r\n\r\n<p>Langkah pertama, nyatakan persamaan (I) menjadi fungsi dari <img alt=\"x\" src=\"https://s0.wp.com/latex.php?latex=x&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />, yaitu: <img alt=\"x-2y+z=6 \\\\Rightarrow x=6+2y-z\" src=\"https://s0.wp.com/latex.php?latex=x-2y+z=6+\\\\Rightarrow+x=6+2y-z&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />. Kemudian subtitusikan pada persamaan (II) dan (III), menjadi</p>\r\n\r\n<p>Persamaan (II): <img alt=\"3(6+2y-z)+y-2z=4\" src=\"https://s0.wp.com/latex.php?latex=3(6+2y-z)+y-2z=4&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /></p>\r\n\r\n<p>Selesaikan, didapat: <img alt=\"7y-5z=-14 \\\\cdots (IV)\" src=\"https://s0.wp.com/latex.php?latex=7y-5z=-14+\\\\cdots+(IV)&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /></p>\r\n\r\n<p>Persamaan (III): <img alt=\"7(6+2y-z)-6y-z=10\" src=\"https://s0.wp.com/latex.php?latex=7(6+2y-z)-6y-z=10&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /></p>\r\n\r\n<p>Selesaikan, didapat: <img alt=\"8y-8z=-32\" src=\"https://s0.wp.com/latex.php?latex=8y-8z=-32&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> atau <img alt=\"y-z=-4 \\\\cdots (V)\" src=\"https://s0.wp.com/latex.php?latex=y-z=-4+\\\\cdots+(V)&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />.</p>\r\n\r\n<p>Persamaan (IV) dan (V) membentuk SPLDV</p>\r\n\r\n<p>Dari persamaan (V), <img alt=\"y-z=-4 \\\\Leftrightarrow y=z-4\" src=\"https://s0.wp.com/latex.php?latex=y-z=-4+\\\\Leftrightarrow+y=z-4&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />, kemudian disubtitusikan pada persamaan (IV), menjadi:</p>\r\n\r\n<p><img alt=\"7(z-4)-5z=-14\" src=\"https://s0.wp.com/latex.php?latex=7(z-4)-5z=-14&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /></p>\r\n\r\n<p><img alt=\"7z-28-5z=-14\" src=\"https://s0.wp.com/latex.php?latex=7z-28-5z=-14&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /></p>\r\n\r\n<p><img alt=\"2z=14 \\\\newline \\\\newline z=7\" src=\"https://s0.wp.com/latex.php?latex=2z=14+\\\\newline+\\\\newline+z=7&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /></p>\r\n\r\n<p>Kemudian subtitusikan <img alt=\"y=7\" src=\"https://s0.wp.com/latex.php?latex=y=7&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> pada persamaan <img alt=\"y=z-4\" src=\"https://s0.wp.com/latex.php?latex=y=z-4&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> diperoleh<img alt=\"y=7-4\" src=\"https://s0.wp.com/latex.php?latex=y=7-4&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> atau <img alt=\"y=3\" src=\"https://s0.wp.com/latex.php?latex=y=3&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />.</p>\r\n\r\n<p>Subtitusikan <img alt=\"z=7\" src=\"https://s0.wp.com/latex.php?latex=z=7&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> dan <img alt=\"z=3\" src=\"https://s0.wp.com/latex.php?latex=z=3&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /> pada persamaan <img alt=\"x=6+2y-z\" src=\"https://s0.wp.com/latex.php?latex=x=6+2y-z&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />, menjadi <img alt=\"x=6+2(3)-7\" src=\"https://s0.wp.com/latex.php?latex=x=6+2(3)-7&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />, diperoleh <img alt=\"x=5\" src=\"https://s0.wp.com/latex.php?latex=x=5&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" />.</p>\r\n\r\n<p>Sehingga himpunan penyelesaian adalah <img alt=\"\\\\{3, 5, 7 \\\\}\" src=\"https://s0.wp.com/latex.php?latex=\\\\{3,+5,+7+\\\\}&amp;bg=f9f9f9&amp;fg=000000&amp;s=0&amp;c=20201002\" /></p>\r\n\r\n<ol>\r\n	<li>Metode Eliminasi</li>\r\n</ol>\r\n\r\n<p>Langkah penyelesaian pada metode eliminasi yaitu:</p>\r\n\r\n<ol>\r\n	<li>Eliminasi salah satu variabel sehingga diperoleh SPLDV</li>\r\n	<li>Selesaikan SPLDV yang diperoleh dengan langkah seperti pada penyelesaian SPLDV yang telah dibahas</li>\r\n	<li>Subtitusikan variabel yang telah diperoleh pada persamaan yang ada.</li>\r\n</ol>\r\n\r\n<p>Sekarang coba kamu selesaikan contoh soal sistem persamaan linear tiga variabel di atas dengan menggunakan metode eliminasi!</p>\r\n',	1,	'2021-07-08 11:03:13',	1,	'2021-07-08 11:10:00',	3,	'hapus testing'),
(1018,	'Teks Drama',	'<h2>Pengertian Teks Drama</h2>\r\n\r\n<p><strong>Teks drama</strong> adalah teks yang berisi cerita, cerita disajikan melalui rentetan dialog per babak yang dibayangkan dan cerita, serta berbagai peristiwa yang disajikan di panggung teater dapat digambarkan melalui pertunjukan. Teks drama dibuat tak hanya untuk dibaca, tetapi juga harus dapat dipentaskan oleh para tokoh dengan tokoh yang harus dijiwai atau lakonnya.</p>\r\n\r\n<p>Drama secara luas dapat diartikan sebagai bentuk karya sastra yang isinya menyangkut kehidupan yang disajikan atau ditampilkan dalam bentuk gerak. Drama membutuhkan komunikasi, situasi, dan tindakan yang berkualitas tinggi. Kualitas dapat dilihat secara keseluruhan dan bagaimana konflik atau masalah muncul dalam drama.</p>\r\n\r\n<h2>Ciri-Ciri Teks Drama</h2>\r\n\r\n<p>Sebagai karya sastra yang berbeda dengan karya sastra lainnya, drama memiliki ciri-ciri sebagai berikut.</p>\r\n\r\n<ol>\r\n <li>Berisi dialog yang dapat dipercakapkan oleh aktor atau lakon teater.</li>\r\n <li>Berisi cerita atau kisah yang dinarasikan dan yang disampaikan melalui dialog atau antartokoh.</li>\r\n <li>Teks drama berisi instruksi khusus yang harus dijiwai oleh para tokoh, seperti: menyesuaikan ekspresi (marah atau senang), melakukan tindakan (berlari / melompat), dll. Karena drama hanya menggunakan dialog sebagai isinya, tanda petik (“…”) tidak diperlukan untuk penulisan dialog.</li>\r\n</ol>\r\n\r\n<h2>Struktur Teks Drama</h2>\r\n\r\n<p>Seperti jenis teks lainnya, kita dapat membagi bagian-bagian yang menyusus teks drama. Bagian-bagian ini disusun secara sistematis dan dapat dipertimbangkan dalam proses kreatif menulis.</p>\r\n\r\n<ol>\r\n <li>Prolog mengacu pada kalimat atau pembukaan cerita, dan <a href=\"https://www.studiobelajar.com/kata-pengantar/\">pengantar</a> atau latar belakang cerita biasanya disampaikan oleh wayang atau tokoh tertentu yang berlatarkan teks drama. Arahannya adalah pengenalan dan pengaturan tindakan dan posisi, meliputi: pengenalan tokoh , pernyataan situasi dan cerita, dan dari awal, konflik yang akan diceritakan dalam cerita yang akan diceritakan dalam drama.</li>\r\n <li>Komplikasi (juga disebut bagian tengah cerita) mulai menciptakan konflik. Pada bagian ini, tokoh utama akan menemukan berbagai kendala antara dirinya dengan tujuan atau keinginannya. Berbagai kesalahpahaman yang sering dialami oleh para tokoh dalam perjuangan melawan rintangan tersebut.</li>\r\n <li>Resolusi (kromatisitas), yaitu resolusi komplikasi atau hambatan yang menghalangi tokoh utama. Bagian ini harus muncul secara logis dan sesuai dengan berbagai kompleksitas atau klimaks yang diusulkan sebelumnya (mencegah konflik puncak kompleksitas dan resolusi).</li>\r\n <li>Epilog merupakan bagian akhir dari drama, dan bentuk kata penutup tersebut berisi kesimpulan atau informasi tentang keseluruhan isi drama. Bagian ini biasanya disediakan oleh dalang atau tokoh.</li>\r\n</ol>\r\n\r\n<h2>Unsur Teks Drama</h2>\r\n\r\n<p>Drama adalah sejenis teks, ia juga terdiri dari banyak elemen. Berikut ini adalah uraian unsur drama oleh tim Kementerian Pendidikan dan Kebudayaan (2017, p.245), yang di antaranya sebagai berikut.</p>\r\n\r\n<ol>\r\n <li>Latar belakang merupakan gambaran letak, waktu, dan suasana dalam naskah drama, meliputi: Menetapkan lokasi yaitu mendeskripsikan adegan dalam naskah, seperti di rumah, di medan perang, di atas meja makan.</li>\r\n <li>Setting atau waktu, yaitu waktu kejadian yang digambarkan dalam naskah, seperti pada pada Hari Pahlawan yang jatuh tanggal 10 Desember.</li>\r\n <li>Latar budaya, yaitu gambaran suasana atau budaya di balik layar atau peristiwa dalam drama. Misalnya dalam budaya Jawa, Betawi, Melayu, Sunda dan Papua hidup.</li>\r\n</ol>\r\n\r\n<h3>Penokohan</h3>\r\n\r\n<p>Penokohan dalam drama diklasifikasikan sebagai berikut.</p>\r\n\r\n<ol>\r\n <li>Tokoh gagal atau tokoh badut (foil). Posisi tokoh ini berlawanan dengan tokoh lain. Tokoh ini ada untuk menekankan tokoh</li>\r\n <li>Tokoh idaman atau tokoh pahlawan (tipe peran) Tokoh ini memainkan tokoh heroik, dengan peran yang kuat, adil, atau terpuji.</li>\r\n <li>Tokoh Statis (Static character). Dari awal hingga akhir cerita, peran tokoh  ini tetap tidak berubah.</li>\r\n <li>Tokoh bulat adalah tokoh yang mengalami perubahan watak secara berangsur-angsur. Misalnya, tokoh bulat adalah tokoh yang mengubah dari peran setia menjadi pengkhianat, dari peran menyakitkan menjadi peran baik, dan dari orang yang korup menjadi orang yang saleh dan bijaksana</li>\r\n</ol>\r\n\r\n<h3>Dialog</h3>\r\n\r\n<p>Dalam drama, dialog atau percakapan harus memenuhi beberapa syarat, antara lain mendukung perilaku tokoh . dan merefleksikan apa yang terjadi sebelum cerita, serta apa yang terjadi di balik cerita, juga harus bisa mengungkapkan pikiran dan perasaan para tokoh di atas panggung.</p>\r\n\r\n<p>Dialog di atas panggung lebih jelas dan lebih teratur daripada percakapan sehari-hari. Kata-kata yang disusun harus dimaksimalkan sebaik-baiknya; tokoh harus berbicara dengan jelas dan memiliki tujuan yang jelas. Dialog tersampaikan secara natural dan alamiah sehingga membuat penonton berpikira bahwa seolah-olah dialog tersebut diucapkan seperti sebenar-benarnya terjadi.</p>\r\n\r\n<h3>Tema</h3>\r\n\r\n<p>Tema adalah ide utama untuk menentukan struktur keseluruhan jalan cerita dari drama. Tema-tema dalam lakon menyentuh semua masalah, termasuk masalah kemanusiaan, kekuasaan, perasaan, kecemburuan, dll.</p>\r\n\r\n<p>Pada umumnya, tema tidak dinyatakan secara terang-terangan (tersurat), tetapi lebih pada tersirat. Oleh karena itu, untuk memahami dan merumuskan tema-tema drama, perlu adanya apresiasi terhadap berbagai unsur drama secara keseluruhan.</p>\r\n\r\n<h3>Pesan atau Amanat</h3>\r\n\r\n<p>Pesan atau amanat adalah ajaran moral doktrinal yang disampaikan drama kepada pembaca/penonton. Sepanjang drama, Pesan atau amanat disembunyi secara rapi dengan menyeseuaikan dari isi cerita drama.</p>\r\n\r\n<h2>Kaidah Kebahasaan Teks Drama</h2>\r\n\r\n<p>Aturan atau ciri yang paling kuat dari bahasa teks drama adalah bahwa hampir semua aturan atau fitur adalah dialog atau percakapan langsung dari tokoh. Oleh karena itu, hampir semua kalimat yang disajikan di dalamnya merupakan dialog atau bentuk tuturan langsung dari tokoh  tersebut. Kaidah kebahasaan teks drama, antara lain sebagai berikut.</p>\r\n\r\n<ol>\r\n <li>Menggunakan kata-kata yang mengungkapkan deret waktu (dalam urutan kronologis), seperti: sebelum, sekarang, setelah, pertama, kemudian.</li>\r\n <li>Menggunakan verba untuk mendeskripsikan suatu peristiwa yang terjadi, seperti: menugaskan, menggantikan, menyingkirkan, menghadap, bercengkrama.</li>\r\n <li>Menggunakan verba untuk mengungkapkan apa yang dipikirkan atau dirasakan karakter, seperti: merasa, ingin, mengharapkan, menginginkan, mengalami.</li>\r\n <li>Menggunakan bahasa deskriptif untuk mendeskripsikan orang, tempat atau suasana, misalnya: kotor, rapi, bengis, maskulin, feminine, dsb.</li>\r\n</ol>\r\n\r\n<h2>Contoh Teks Drama</h2>\r\n\r\n<p>Sebagai pengurus pemakaman jenazah di Pemakaman Umum Pondok Rangon, sejak Covid-19, beban kerja Udin, Yogi, dan Abil meningkat. Setiap harinya, kegiata mereka tak jauh dari gali, gali, dan menggali.</p>\r\n\r\n<p>Tiga laki-laki datang memakai kaos oblong dengan handuk kecil di bahu mereka. Setelah melepaskan semua atribut, tiap-tiap dari mereka duduk sambil berselanjar kaki.</p>\r\n\r\n<p>Yogi: “Duh, Bang Udin. Kalo kayak gini terus kapan kelarnya, yak, kita?</p>\r\n\r\n<p>Udin: “Ngeluh mulu, idup, lu. Syukurin aje, Kawan. Nyari kerje di Jakarte lu tau sendiri susahnye kayak nyari jarum dalem jemari. Nyang penting dapet duit!”</p>\r\n\r\n<p>Yogi: “Yak, gue, sih, beryukur, Bang, tapi gak gini juga. Masa kita harus bahagia tiap hari ada yang modar?!”</p>\r\n\r\n<p>Udin: “Yak, mau gimane?? Bingung juga. Dah, ah! Mulut lu jangan ngerocos mulu, bikin tambah capek aje!”</p>\r\n\r\n<p>ABIL MENYODORKAN SEBOTOL AIR MINERAL KEPADA UDIN DAN YOGI</p>\r\n\r\n<p>Abil: “Udeh, udeh, jangan pade rebut. Kalemin aje dulu. Kite, tuh, jarang istirahat. Dah, istirahat dulu. Simpen tenage lu pade. Tar, paling ambulans datang lagi.”</p>\r\n\r\n<p>Yogi: “Iya, iya. Soalnya, baru kali ini seumur-umur jadi tukang gali kubur ngerasa kecapean. Kemarin, kemarin, mah, gali sampe malam aja, gue sanggup.”</p>\r\n\r\n<p>Abil:”Iye, gapape, capek itu wajar. Namanya juga manusia. Bang Udin juga capek, Gak perlu memaksakan. Bisa-bisa, nih, kite gali kubur, eh, nanti buat kuburan kite sendiri, karena saking capeknye ngegali mulu.”</p>\r\n\r\n<p>Yogi: “Yaelah, Mas. Jadi, takut Yogi, Mas!”</p>\r\n\r\n<p>Udin: “Lagian, Yog. Elu masih mude aje ngeluh, lah gue nyang umurnye beda 10 tahun lebih tue dari elu, biasa-biasa aje.”</p>\r\n\r\n<p>Yogi: “Lah, tadi, kan, Abang ngeluh capek juga, Bang.”</p>\r\n\r\n<p>Udin: “Lah, siape nyang mulai? Bedain mane nyang ngeluh, mane nyang sengaje bales keluhan temen. Gitu aje ga bisa bedain lu!”</p>\r\n\r\n<p>Abil: “Udeh, udeh, jan pada berantem. Kite gimanepun juge itu tim. Jangen pade berantem. Ohiye, tadi Bang Udin sama Mas Yogi pas tadi malam aku makasih banget, loh, pas lagi berat ngangkat peti kosong ngerasa enteng berkat bantuan Bang Udin sama Mas Yogi.</p>\r\n\r\n<p>UDIN DAN YOGI SALING MENATAP</p>\r\n\r\n<p>Udin: “Jam berape lu angkat tuh peti?”</p>\r\n\r\n<p>Abil: “Jam berapa, ya? Jam setengah 9an kayaknye.”</p>\r\n\r\n<p>YOGI NGELUARIN HP BUAT NUNJUKKIN FOTO</p>\r\n\r\n<p>Yogi: “Bang, lu lihat, dah. Jam segitu kita lagi di warung Mpok Leha. Ini fotonya.</p>\r\n\r\n<p>SEMUA DIAM. UDIN, YOGI, dan ABIL SALING MENATAP. LAMPU PANGGUNG DIMATIKAN.</p>\r\n',	2,	'2021-07-08 14:20:11',	3,	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(254) NOT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_selector` varchar(255) DEFAULT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_email` (`email`),
  UNIQUE KEY `uc_activation_selector` (`activation_selector`),
  UNIQUE KEY `uc_forgotten_password_selector` (`forgotten_password_selector`),
  UNIQUE KEY `uc_remember_selector` (`remember_selector`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `email`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1,	'127.0.0.1',	'administrator',	'$2y$10$c8Tzq3RVBcaAZi.rd5VZ5eonGe4gmew7XV6v68yEDyCIWW6..qcL6',	'admin@admin.com',	NULL,	'',	NULL,	NULL,	NULL,	NULL,	NULL,	1268889823,	1626054951,	1,	'Admin',	'istrator',	'ADMIN',	'0'),
(3,	'127.0.0.1',	'azrl78',	'$2y$10$y5j.69yawwQsRlwWA0XQdewy68FdXL3JE7g8Ggmn/saQjaBj8Q8Gi',	'ferryakbarardiansyah@gmail.com',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1625622862,	1625902544,	1,	'Azriel',	'Akbar',	'mboh',	'08888888888'),
(4,	'127.0.0.1',	NULL,	'$2y$10$aWiTgdyz6wqs8Wf/0bC7DOpqn.RFitxdYTXdn5Wm1GNmgldBYe0Bu',	'test@test.com',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1625897343,	1626053726,	1,	'test',	'test',	'test',	'088888');

DROP TABLE IF EXISTS `users_groups`;
CREATE TABLE `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`),
  CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(8,	1,	1),
(9,	1,	2),
(10,	3,	1),
(11,	3,	2),
(12,	4,	2);

-- 2021-07-12 08:17:37
