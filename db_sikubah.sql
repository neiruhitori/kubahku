-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 26 Bulan Mei 2026 pada 00.37
-- Versi server: 8.0.30
-- Versi PHP: 8.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sikubah`
--

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_wa_dashboard_stats` ()   BEGIN
    
    SELECT * FROM v_today_wa_stats;
    
    
    SELECT * FROM v_today_page_stats;
    
    
    SELECT * FROM v_wa_weekly_stats;
    
    
    SELECT * FROM v_wa_total_stats;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `admins`
--

CREATE TABLE `admins` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `password`, `full_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@sikubah.id', '$2y$10$60M631qouWJCOYcG3JCjIerQLa2HO7FLM3UhZPLsFvnMDjutX/0Ja', 'Administrator', '2026-05-19 13:50:06', '2026-05-19 13:50:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `articles`
--

CREATE TABLE `articles` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` longtext,
  `featured_image` varchar(255) DEFAULT NULL,
  `author_id` int DEFAULT NULL,
  `published` tinyint DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `articles`
--

INSERT INTO `articles` (`id`, `title`, `slug`, `content`, `featured_image`, `author_id`, `published`, `created_at`, `updated_at`) VALUES
(6, 'Pesan Kubah Masjid Kuningan Tembaga: Investasi Keindahan Abadi', 'pesan-kubah-masjid-kuningan-tembaga-investasi-keindahan-abadi', '<p><strong>Pesan kubah masjid</strong>&nbsp;dari bahan tembaga dan kuningan kini menjadi tren yang tidak hanya mengejar kemegahan, tetapi juga nilai investasi jangka panjang bagi bangunan ibadah. Pernahkah Anda melihat sebuah masjid yang terlihat begitu bercahaya dan ikonik bahkan dari jarak jauh? Rahasianya seringkali bukan pada cat temboknya, melainkan pada pemilihan material kubah yang tepat. Tembaga dan kuningan memberikan kesan artistik nan mewah yang tidak bisa ditandingi oleh material konvensional seperti baja atau beton.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Baca juga:&nbsp;</strong><a href=\"https://kubahku.id/kubahku/detail_artikel/ternyata-segini-harga-kubah-masjid-yang-bikin-pengurus-masjid-hemat\" target=\"_blank\"><strong>Ternyata Segini Harga Kubah Masjid yang Bikin Pengurus Masjid Hemat</strong></a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Pesan kubah masjid</strong>&nbsp;dengan material logam berkualitas tinggi juga berarti Anda sedang menyelamatkan anggaran perawatan untuk puluhan tahun ke depan. Material ini memiliki sifat anti-korosi alami yang membuatnya mampu bertahan di tengah cuaca ekstrem, mulai dari panas terik hingga hujan asam. Alih-alih kusam, seiring berjalannya waktu, tembaga akan mengalami proses oksidasi alami yang justru menambah nilai seni dan karakter unik pada kubah tersebut. Inilah alasan mengapa banyak pengurus masjid dan arsitek mulai beralih ke material premium ini.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Pesan Kubah Masjid: Alasan Mengapa Material Kuningan dan Tembaga Adalah Pilihan Terbaik</strong></h3>\r\n\r\n<p>Mengapa banyak orang rela mengalokasikan anggaran lebih untuk material ini? Berikut adalah alasan kuat yang akan membuat Anda yakin:</p>\r\n\r\n<ul>\r\n	<li><strong>Daya Tahan Luar Biasa:</strong>&nbsp;Tidak berkarat, tidak keropos, dan tahan terhadap perubahan suhu yang drastis.</li>\r\n	<li><strong>Warna yang Elegan:</strong>&nbsp;Kilauan emas dari kuningan memberikan kesan mewah layaknya lapisan emas asli, namun dengan harga yang lebih rasional.</li>\r\n	<li><strong>Custom Design:</strong>&nbsp;Logam tembaga sangat fleksibel untuk dibentuk menjadi berbagai motif, mulai dari pola kaligrafi rumit hingga desain modern minimalis.</li>\r\n	<li><strong>Nilai Jual Kembali:</strong>&nbsp;Logam adalah aset. Nilai bahan tembaga dan kuningan cenderung stabil bahkan meningkat di pasar material.</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Wujudkan Kemegahan Masjid Anda Sekarang!</strong></p>\r\n\r\n<p>Bayangkan masjid di lingkungan Anda berdiri dengan gagah, dihiasi kubah berkilau yang menjadi&nbsp;<em>landmark</em>&nbsp;kebanggaan seluruh jamaah. Jangan biarkan anggaran Anda terbuang sia-sia untuk material yang mudah rusak dan membutuhkan pengecatan ulang setiap tahun. Ini adalah saatnya beralih ke solusi yang lebih cerdas, indah, dan abadi. Tim ahli kami siap mendampingi Anda mulai dari konsultasi desain, pemilihan material, hingga proses instalasi presisi di seluruh wilayah. Kesempatan untuk mendapatkan penawaran eksklusif dan konsultasi gratis hanya tersedia hari ini. Jangan tunda lagi,<a href=\"https://kubahku.id/kubahku/detail_artikel/ternyata-segini-harga-kubah-masjid-yang-bikin-pengurus-masjid-hemat\" target=\"_blank\"><strong>hubungi tim ahli kami</strong></a><a href=\"https://api.whatsapp.com/send/?phone=6285168613452&amp;text=Assalamualaikum%2CMohon+info+kubahnya.https%3A%2F%2Fkubahku.com&amp;type=phone_number&amp;app_absent=0\" target=\"_blank\"><strong>&nbsp;</strong></a>sekarang juga melalui tombol di bawah ini dan jadikan masjid Anda pusat perhatian yang penuh kewibawaan!</p>', './images/1779334745_pw6.webp', 1, 1, '2026-05-21 03:39:06', '2026-05-21 03:40:15'),
(7, 'Update Harga Kubah Masjid Aluminium Terbaru Tahun Ini', 'update-harga-kubah-masjid-aluminium-terbaru-tahun-ini', '<p><strong>Harga Kubah Masjid&nbsp;</strong>material aluminium kini menjadi banyak perbincangan di kalangan pengurus masjid di seluruh Indonesia. Hal ini dikarenakan, material ini memiliki keunggulan yang tahan karat, ringan, dan pilihan warna yang variatif. Sehingga material ini menjadi investasi jangka panjang yang paling cerdas untuk masjid. Mengingat fluktuasi harga bahan baku logam di pasar global, banyak orang mulai bertanya-tanya apakah tahun ini adalah waktu yang tepat untuk melakukan pemesanan atau justru harus menunggu lebih lama lagi.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Mengapa Harga Kubah Masjid Aluminium Berubah-ubah?</strong></h3>\r\n\r\n<p><strong>Harga kubah masjid</strong>&nbsp;sangat dipengaruhi oleh ketebalan plat aluminium yang digunakan serta kerumitan desain motif yang diinginkan. Material aluminium dipilih karena sifatnya yang sangat adaptif terhadap cuaca ekstrem, sehingga warna kubah tidak mudah pudar meskipun terpapar panas matahari dan hujan terus-menerus selama puluhan tahun. Selain itu, proses pemasangan yang lebih cepat dibandingkan material beton membuat biaya tenaga kerja menjadi jauh lebih efisien, memberikan nilai tambah bagi anggaran pembangunan masjid Anda.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Baca juga:&nbsp;</strong><a href=\"https://kubahku.id/kubahku/detail_artikel/bocoran-harga-kubah-masjid-aluminium-hemat-budget-pembangunan\" target=\"_blank\"><strong>Bocoran Harga Kubah Masjid Aluminium, Hemat Budget Pembangunan!</strong></a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Memilih kubah bukan sekadar mencari yang paling murah, melainkan mencari keseimbangan antara estetika dan ketahanan struktur. Dengan teknik pengecatan&nbsp;<em>powder coating</em>&nbsp;terbaru, tampilan kubah aluminium kini terlihat jauh lebih mewah dan elegan, setara dengan masjid-masjid besar di Timur Tengah. Inilah alasan mengapa permintaan pasar terus melonjak tajam dalam beberapa bulan terakhir.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Jangan Sampai Kehabisan Slot Promo Bulan Ini!</strong></h3>\r\n\r\n<p><strong>Harga kubah masjid</strong>&nbsp;aluminium yang kami tawarkan sedang berada pada titik penawaran terbaik yang sulit untuk Anda temukan di tempat lain. Namun perlu diingat, kuota produksi kami terbatas setiap bulannya untuk menjaga kualitas pengerjaan yang presisi dan sempurna. Apakah Anda ingin mendapatkan harga khusus atau sekadar ingin membandingkan spesifikasi material terbaik untuk masjid kebanggaan warga?</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Jangan biarkan anggaran Anda membengkak karena menunda keputusan! Tim ahli kami sudah siap memberikan bocoran pricelist terbaru dan simulasi perhitungan biaya secara cuma-cuma.&nbsp;<strong>Klik tombol</strong><a href=\"https://api.whatsapp.com/send?phone=6285168613452&amp;text=Assalamualaikum%20KubahKu.id%20,%20mohon%20info%20kubahnya?\" target=\"_blank\"><strong>&nbsp;</strong></a><a href=\"https://api.whatsapp.com/send?phone=6285168613452&amp;text=Assalamualaikum%20KubahKu.id%20,%20mohon%20info%20kubahnya?\" target=\"_blank\"><strong>hubungi kami sekarang</strong></a><a href=\"https://api.whatsapp.com/send?phone=6285168613452&amp;text=Assalamualaikum%20KubahKu.Com%20,%20mohon%20info%20kubahnya?\" target=\"_blank\"><strong>&nbsp;juga</strong></a>&nbsp;untuk konsultasi gratis dan amankan penawaran harga spesial sebelum terjadi kenaikan bahan baku di bulan depan. Jadikan masjid Anda ikon keindahan yang abadi mulai hari ini!</p>', './images/1779336989_artikel2.webp', 1, 1, '2026-05-21 04:16:29', '2026-05-21 04:16:29'),
(8, 'Masjid Megah! Pesan Kubah Masjid Tanpa Ribet, Garansi Sampai Jadi!', 'masjid-megah-pesan-kubah-masjid-tanpa-ribet-garansi-sampai-jadi', '<p><strong>Pesan kubah masjid</strong>&nbsp;seringkali menjadi mimpi buruk bagi pengurus pembangunan jika bertemu dengan vendor yang tidak profesional. Pastinya ini menjadi hal yang sangat bermasalah dan akan mendatangkan kerugian. Bayangkan saja, dana umat yang sudah dikumpulkan dengan susah payah justru tertahan. Hal ini dikarenakan pengerjaan yang lambat atau hasilnya yang kurang memuaskan dan mengakibatkan bocor saat musim hujan. Jangan sampai niat mulia mempercantik rumah Allah berubah menjadi beban pikiran yang tak berkesudahan hanya karena salah memilih mitra produksi.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Pesan Kubah Masjid dengan Kualitas Sultan</strong></h3>\r\n\r\n<p><strong>Pesan kubah masjid</strong>&nbsp;di tempat kami memberikan Anda kepastian yang tidak dimiliki di tempat lain: Keamanan dana dan kualitas material. Tentunya kami sebagai pengrajin kubah masjid sangat memahami bahwa estetika adalah hal utama. Namun ketahanan, material, dan hasil dari kerja keras kami, kepuasan pelanggan sangat jauh lebih penting. Menggunakan teknologi&nbsp;<em>double layer</em>&nbsp;anti-bocor dan pewarnaan sistem&nbsp;<em>powder coating</em>, kubah Anda dijamin akan tetap berkilau hingga puluhan tahun tanpa perlu perawatan ekstra yang mahal.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Baca juga:&nbsp;</strong><a href=\"https://kubahku.id/kubahku/detail_artikel/bocoran-harga-kubah-masjid-aluminium-hemat-budget-pembangunan\" target=\"_blank\"><strong>Bocoran Harga Kubah Masjid Aluminium, Hemat Budget Pembangunan!</strong></a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Pemesanan kubah masjid kini bisa dilakukan hanya dari rumah melalui ponsel Anda. Anda tidak perlu lagi mondar-mandir ke bengkel las atau pusing memikirkan logistik pengiriman yang rumit. Tim ahli kami akan melakukan survei lokasi, membuatkan desain 3D secara gratis, hingga proses instalasi selesai dilakukan oleh tenaga profesional yang sudah berpengalaman menangani ratusan proyek di seluruh Indonesia.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Yang paling membuat para pengurus masjid tenang adalah komitmen kami mengenai&nbsp;<strong>Garansi Sampai Jadi!</strong>&nbsp;Kami memberikan jaminan penuh bahwa setiap rupiah yang Anda keluarkan akan berwujud kubah yang megah dan kokoh. Jika ada kerusakan selama proses pengiriman atau pemasangan, kami yang menanggung seluruh biayanya. Inilah rahasia mengapa ribuan panitia masjid merasa puas dan tanpa ragu merekomendasikan layanan kami.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Ayo! Jangan ditunda lagi membuat tempat beribadah di lokasi Anda menjadi lebih megah dan nyaman saat digunakan. Karena material, desain, interior, dan dekorasi yang diterapkan pada tempat beribadah tersebut membantu para jamaah untuk menjadi lebih khusyuk.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Capek urus vendor yang tidak jelas? Saatnya beralih ke layanan yang pasti-pasti saja. Kami urus semuanya dari desain hingga pasang. Anda tinggal terima jadi! Hubungi kami untuk survei lokasi sekarang juga. <strong>[Klik button WhatsApp untuk konsultasi]</strong></p>', './images/1779337699_artikel3.webp', 1, 1, '2026-05-21 04:28:19', '2026-05-21 04:29:21'),
(9, 'Ternyata Segini Harga Kubah Masjid yang Bikin Pengurus Masjid Hemat', 'ternyata-segini-harga-kubah-masjid-yang-bikin-pengurus-masjid-hemat', '<p><strong>Harga kubah masjid</strong>&nbsp;kerap menjadi hal yang menakutkan bagi para pengurus masjid. Tidak heran, karena pembangunan ini seringkali menguras&nbsp;<em>budget</em>&nbsp;yang dimiliki. Akan tetapi, fakta di lapangan justru mengatakan sebaliknya. Masih banyak orang yang belum sadar dibalik dari kemegahan sebuah masjid, terdapat sebuah strategi yang cerdas dalam pemilihan material. Sehingga biaya dari pembangunannya tidak mahal seperti banyak yang diketahui banyak orang. Jangan sampai&nbsp;<em>budget</em>&nbsp;yang dimiliki terbuang sia-sia dikarenakan tergiur dengan tampailan mewah tanpa paham harga sebenarnya. Dengan mengetahui rahasia dapur para kontraktor, Anda bisa mendapatkan kubah berkualitas premium dengan harga yang jauh lebih miring dari pasaran.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Baca juga:&nbsp;</strong><a href=\"https://kubahku.id/kubahku/detail_artikel/pesan-kubah-masjid-stainless-sekarang-anti-karat-selamanya\" target=\"_blank\"><strong>Pesan Kubah Masjid Stainless Sekarang, Anti Karat Selamanya!</strong></a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Harga kubah masjid</strong>&nbsp;yang kompetitif biasanya ditentukan oleh pemilihan material modern seperti enamel atau galvalum yang dikenal jauh lebih awet dan minim perawatan dibanding kubah beton tradisional. Penghematan ini bukan berarti mengurangi kualitas, melainkan efisiensi pada beban struktur bangunan dan biaya jangka panjang. Kubah panel modern memiliki bobot yang ringan sehingga tidak memerlukan fondasi yang terlalu mahal, yang secara otomatis akan memangkas anggaran pembangunan masjid secara keseluruhan. Inilah rahasia mengapa banyak masjid baru bisa terlihat sangat megah namun tetap hemat biaya.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Faktor Rahasia di Balik Harga Kubah Masjid yang Murah</strong></h3>\r\n\r\n<p>Banyak orang bertanya-tanya, apa yang sebenarnya membuat&nbsp;<em>pricelist</em>&nbsp;dari kubah masjid bisa sangat bervariasi di pasar? Jawabannya terletak pada sistem fabrikasi dan jalur distribusi. Membeli langsung dari produsen atau pabrikan spesialis akan menghindarkan Anda dari biaya tambahan perantara yang seringkali mengambil keuntungan terlalu besar. Selain itu, penggunaan teknologi laser cutting dan pengecatan sistem&nbsp;<em>powder coating</em>&nbsp;saat ini sudah semakin efisien, sehingga biaya produksi bisa ditekan tanpa mengorbankan ketahanan warna yang bisa mencapai puluhan tahun.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Amankan Anggaran Masjid Anda Sekarang Juga!</strong></h3>\r\n\r\n<p>Jangan biarkan keputusan yang terburu-buru membuat Anda menyesal di kemudian hari karena kubah yang bocor atau warna yang kusam hanya dalam hitungan bulan. Inilah saat yang tepat bagi Anda untuk menjadi pengurus masjid yang amanah dan cerdas dalam mengelola dana jamaah. Kami siap memberikan solusi terbaik yang menggabungkan estetika, kekuatan, dan efisiensi biaya secara transparan.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Jadi jangan sampai lewatkan kesempatan emas ini! Segera angkat telepon Anda dan hubungi&nbsp;<a href=\"https://api.whatsapp.com/send?phone=6285168613452&amp;text=Assalamualaikum%20KubahKu.id%20,%20mohon%20info%20kubahnya?\" target=\"_blank\">tim ahli kami</a>&nbsp;untuk konsultasi gratis mengenai desain dan spesifikasi teknis yang paling sesuai dengan anggaran Anda. Mari wujudkan rumah Allah yang megah, kokoh, dan indah tanpa harus menguras kantong. Hubungi kami sekarang dan dapatkan penawaran harga spesial yang tidak akan Anda temukan di tempat lain!</p>', './images/1779337827_artikel4.webp', 1, 1, '2026-05-21 04:30:27', '2026-05-21 04:30:27'),
(10, 'Trik Pesan Kubah Masjid Enamel Mewah Harga Murah', 'trik-pesan-kubah-masjid-enamel-mewah-harga-murah', '<p>Banyak pengelola tempat ibadah yang merasa cemas dengan anggaran pembangunan yang terus membengkak, padahal impian memiliki tampilan rumah ibadah yang megah bukan sekadar angan. Rahasianya terletak pada pemilihan material enamel yang dikenal memiliki warna tajam dan sangat awet hingga puluhan tahun. Jika Anda tahu triknya, Anda bisa melakukan&nbsp;<strong>pesan kubah masjid</strong>&nbsp;dengan kualitas premium namun tetap masuk dalam anggaran yang sangat efisien. Jangan terburu-buru tergiur dengan penawaran yang tidak jelas asal-usulnya; pastikan Anda memahami spesifikasi bahan sebelum memutuskan untuk melakukan transaksi besar. Kami akan membongkar rahasia bagaimana distributor besar memberikan harga khusus bagi mereka yang jeli melihat peluang.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Baca juga:&nbsp;</strong><a href=\"https://kubahku.id/kubahku/detail_artikel/viral-cek-disini-tempat-jual-kubah-masjid-beton-cor-termurah\" target=\"_blank\"><strong>Viral! Cek Disini Tempat Jual Kubah Masjid Beton Cor Termurah!</strong></a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Keunggulan utama dari material enamel adalah teknologi&nbsp;<em>porcelain coating</em>&nbsp;yang membuatnya tahan terhadap korosi dan cuaca ekstrem di Indonesia. Strategi terbaik saat akan&nbsp;<strong>pesan kubah masjid</strong>&nbsp;adalah dengan mencari produsen tangan pertama yang memiliki pabrik sendiri, bukan sekadar agen atau perantara. Hal ini karena rantai distribusi yang pendek memungkinkan Anda mendapatkan harga yang jauh lebih miring untuk kualitas yang sama. Selain itu, pilihlah vendor yang menawarkan konsultasi desain secara gratis sehingga Anda tidak perlu mengeluarkan biaya tambahan untuk arsitek. Proses&nbsp;<strong>pesan kubah masjid</strong>&nbsp;kini jauh lebih mudah dan transparan berkat bantuan teknologi desain 3D yang memastikan hasil akhir sesuai dengan ekspektasi jamaah.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Langkah Cerdas Sebelum Anda Pesan Kubah Masjid</strong></h3>\r\n\r\n<p>Sebelum Anda memutuskan untuk&nbsp;<strong>pesan kubah masjid</strong>, pastikan untuk memeriksa portofolio proyek yang telah diselesaikan sebelumnya. Garansi warna dan ketahanan konstruksi adalah dua poin krusial yang harus Anda negosiasikan sejak awal agar tidak ada biaya tak terduga di masa depan. Kami memahami bahwa amanah dari jamaah sangatlah berat, itulah sebabnya layanan kami hadir untuk mempermudah proses Anda dalam&nbsp;<strong>pesan kubah masjid</strong>&nbsp;yang berkualitas sultan dengan harga yang sangat bersahabat.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Jangan biarkan&nbsp;<em>budget</em>&nbsp;terbatas menghalangi keinginan Anda membangun mahkota masjid yang indah dan membanggakan. Bayangkan kemegahan warna enamel yang mengkilap menyambut kedatangan para jamaah setiap waktu salat tiba, memberikan kesan damai sekaligus mewah yang akan bertahan hingga generasi mendatang. Ambil langkah besar Anda hari ini dengan berkonsultasi langsung kepada ahlinya melalui tombol berikut;&nbsp;<a href=\"https://api.whatsapp.com/send?phone=6285168613452&amp;text=Assalamualaikum%20KubahKu.id%20,%20mohon%20info%20kubahnya?\" target=\"_blank\">tim kami</a>&nbsp;siap memberikan penawaran eksklusif yang tidak akan Anda temukan di tempat lain, khusus bagi Anda yang menghubungi kami sekarang juga!</p>', './images/1779337886_artikel5.webp', 1, 1, '2026-05-21 04:31:26', '2026-05-21 04:31:26'),
(11, 'Jual Kubah Masjid Galvalum: Harga Miring, Kualitas Tak Main-Main!', 'jual-kubah-masjid-galvalum-harga-miring-kualitas-tak-main-main', '<p><strong>Jual Kubah Masjid&nbsp;</strong>dengan harga murah seringkali dianggap remeh, hal tersebut wajar karena kemungkinan materialnya jelek. Jadi tidak heran jika banyak orang-orang berpikiran bahwa penjualan kubah masjid dengan harga murah menggunakan bahan material yang tidak sesuai dengan standar yang ada. Akan tetapi material Galvalum kini menjadi rahasia di balik megahnya bangunan masjid-masjid modern tanpa harus menguras kas jamaah. Banyak panitia pembangunan masjid yang terjebak dengan material berat yang mahal, padahal ada solusi cerdas yang mampu memberikan tampilan mewah layaknya masjid di Timur Tengah namun dengan biaya yang jauh lebih hemat.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Baca juga:&nbsp;</strong><a href=\"https://kubahku.id/kubahku/detail_artikel/viral-cek-disini-tempat-jual-kubah-masjid-beton-cor-termurah\" target=\"_blank\"><strong>Viral! Cek Disini Tempat Jual Kubah Masjid Beton Cor Termurah!</strong></a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Jual kubah masjid</strong>&nbsp;berbahan Galvalum bukan sekadar tren, melainkan standar baru dalam dunia konstruksi rumah ibadah yang efisien. Material yang merupakan perpaduan antara aluminium dan seng ini memiliki daya tahan terhadap karat yang luar biasa, bahkan di tengah cuaca ekstrem Indonesia yang tidak menentu. Bobotnya yang ringan adalah &ldquo;penyelamat&rdquo; bagi fondasi masjid Anda, mengurangi risiko keretakan struktur dalam jangka panjang. Bayangkan, Anda bisa menghemat jutaan rupiah dari sektor biaya logistik dan pemasangan, namun tetap mendapatkan kubah yang kokoh, anti-bocor, dan punya nilai estetika tinggi.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Banyak penyedia di luar sana yang menawarkan harga miring, namun hanya kami yang berani menjamin presisi pemasangan dan kualitas bahan tingkat tinggi. Material Galvalum kami dilapisi dengan cat khusus yang tidak mudah mengelupas meski terpapar terik matahari bertahun-tahun. Ini adalah investasi jangka panjang yang tidak hanya memperindah bangunan, tapi juga menjaga keamanan seluruh jamaah yang beribadah di bawahnya.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Jual Kubah Masjid: Siap Ubah Tampilan Masjid Anda Menjadi Ikonik?</strong></h3>\r\n\r\n<p>Jangan biarkan budget terbatas menghalangi niat mulia Anda untuk membangun rumah ibadah yang megah dan nyaman! Inilah kesempatan emas bagi Anda untuk mendapatkan kubah idaman dengan penawaran yang belum pernah ada sebelumnya. Tim ahli kami siap mendampingi Anda mulai dari tahap desain hingga instalasi akhir dengan penuh dedikasi.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Tunggu apa lagi? Klik button WhatsApp dibawah untuk konsultasi</strong><strong>&nbsp;sekarang juga dan klaim diskon eksklusif serta sesi konsultasi gratis senilai jutaan rupiah!</strong>&nbsp;Slot promo bulanan kami hampir penuh, jadi pastikan Anda menjadi salah satu yang beruntung mendapatkan kualitas sultan dengan harga teman. Klik tombol di bawah ini dan mari wujudkan masjid kebanggaan lingkungan Anda bersama kami!</p>', './images/1779337961_artikel6.webp', 1, 1, '2026-05-21 04:32:41', '2026-05-21 04:32:41'),
(12, 'Bocoran Harga Kubah Masjid Aluminium, Hemat Budget Pembangunan!', 'bocoran-harga-kubah-masjid-aluminium-hemat-budget-pembangunan', '<p><strong>Harga kubah masjid</strong>&nbsp;berbahan aluminium sering kali menjadi kejutan menyenangkan bagi para panitia pembangunan yang menginginkan tampilan mewah namun tetap memperhatikan efisiensi biaya. Material aluminium dikenal karena ketahanannya yang luar biasa terhadap korosi, yang secara otomatis memangkas biaya perawatan jangka panjang karena Anda tidak perlu melakukan pengecatan ulang sesering material lainnya. Memilih aluminium adalah strategi cerdas untuk mendapatkan estetika kubah yang berkilau dan modern tanpa harus menguras kas masjid secara berlebihan.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h2><strong>Mengapa Harga Kubah Masjid Aluminium Sangat Kompetitif?</strong></h2>\r\n\r\n<p><strong>Harga kubah masjid</strong>&nbsp;dengan material aluminium sangat dipengaruhi oleh bobotnya yang ringan, yang secara langsung berdampak pada penghematan struktur rangka bangunan. Dikarenakan bebannya tidak terlalu berat membuat kubah ini tidak memerlukan penguatan ekstra yang mahal. Sehingga&nbsp;total biaya konstruksi bangunan secara keseluruhan menjadi jauh lebih hemat. Selain itu, proses instalasi aluminium yang lebih cepat dibandingkan material konvensional berarti Anda bisa menghemat jutaan rupiah dari biaya upah tenaga kerja yang biasanya membengkak pada proyek jangka panjang.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Baca juga:&nbsp;</strong><a href=\"https://kubahku.com/harga-kubah-masjid-diameter-3-meter/\" target=\"_blank\"><strong>Harga Kubah Masjid Diameter 3 Meter</strong></a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Selain faktor biaya, daya tarik utama dari aluminium adalah fleksibilitasnya dalam desain. Kubah yang memiliki efek memantulkan cahaya matahari kerap memiliki desain yang indah. Dimana kubah tersebut memberikan kesan yang megah dan mewah pada rumah beribadah yang Anda miliki. Keunggulan dari material ini adalah material favorit bagi banyak masjid yang ingin tampil ikonik. Meskipun begitu, anggaran atau&nbsp;<em>budget&nbsp;</em>yang diperlukan untuk menerapkannya tanpa disangka sangatlah murah.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Konsultasikan Kubah Impian Anda Secara Gratis!</strong></h3>\r\n\r\n<p>Membangun masjid adalah amal jariyah yang besar, dan kami ingin menjadi bagian dari perjalanan mulia Anda. Jangan sampai salah langkah dalam memilih vendor yang hanya menawarkan janji tanpa kualitas nyata. Kami siap memberikan transparansi penuh mengenai&nbsp;<strong>a-index-in-node=&rdquo;255&Prime;&gt;harga kubah masjid</strong>&nbsp;yang sesuai dengan budget dan kebutuhan arsitektur Anda.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Jangan Tunda Lagi!</strong>&nbsp;Dapatkan penawaran eksklusif berupa potongan harga khusus dan layanan survei lokasi tanpa dipungut biaya sepeser pun hanya untuk bulan ini. Jadikan masjid Anda pusat perhatian dengan kubah aluminium berkualitas tinggi yang akan berdiri kokoh hingga puluhan tahun mendatang.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Klik tombol WhatsApp di bawah ini</strong> atau hubungi layanan pelanggan kami untuk sesi konsultasi gratis. Kami siap membantu Anda menghitung estimasi biaya secara akurat agar pembangunan masjid berjalan lancar tanpa kendala biaya. Mari wujudkan rumah ibadah yang indah dan megah bersama tim profesional kami!</p>', './images/1779338057_artikel7.webp', 1, 1, '2026-05-21 04:34:18', '2026-05-21 04:34:18'),
(13, 'Tempat Jual Kubah Murah GRC Mewah Awet Puluhan Tahun', 'tempat-jual-kubah-murah-grc-mewah-awet-puluhan-tahun', '<p><strong>Jual kubah murah&nbsp;</strong>dengan material GRC (Glassfiber Reinforced Concrete) kini menjadi perbincangan hangat. Dimana kubah masjid dengan material ini memberikan kesan yang mewah layaknya masjid-masjid yang ada di Timur Tengah. Dan hal yang tidak disangka-sangka adalah tampilan kubah ini tidak memerlukan banyak biaya. Sehingga material GRC adalah material yang menjadi solusi cerdas yang menawarkan ketahanan luar biasa pada cuaca ekstrem. Meskipun begitu harga penjualannya murah, dan dana masjid bisa digunakan untuk kebutuhan masjid atau kegiatan lainnya yang lebih bermanfaat.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Jual kubah murah</strong>&nbsp;dari kami menjamin penggunaan teknologi cetak presisi yang membuat setiap lekukan ornamen terlihat sempurna tanpa cacat. Berbeda dengan kubah beton konvensional yang berat dan rawan retak, kubah GRC jauh lebih ringan sehingga menghemat biaya struktur bangunan bawah. Ketahanannya pun tidak main-main; material ini tahan terhadap karat, jamur, dan perubahan suhu, memastikan mahkota masjid Anda tetap berdiri megah dan indah hingga puluhan tahun mendatang tanpa perlu renovasi berulang kali.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Alasan Memilih Tempat Jual Kubah Murah Material GRC Kami</strong></h3>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Baca juga:&nbsp;</strong><a href=\"https://kubahku.id/kubahku/detail_artikel/update-harga-kubah-masjid-aluminium-terbaru-tahun-ini\" target=\"_blank\"><strong>Update Harga Kubah Masjid Aluminium Terbaru Tahun Ini</strong></a></p>\r\n\r\n<p>Keunggulan dari material GRC ini ada banyak, yang pertama pemasangannya sangatlah cepat. Jika dibandingkan dengan material yang lain seperti kubah masjid cor, tentunya proses instalasinya lebih cepat. Yang kedua adalah desain dari kubah ini tanpa batas, artinya sebagai pelanggan, Anda bisa memesan motif ornamen rumit hingga kaligrafi dengan custom. Yang ketiga, perawatannya sangatlah mudah, lapisan warna dan materialnya tidak mudah keropos dan tahan lama. Dan yang terakhir adalah garansi mutu, hal ini tentunya memberikan rasa aman bagi seluruh pengurus masjid dan jamaah.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Wujudkan Masjid Impian Anda Melalui Jual Kubah Murah Terpercaya</strong></h3>\r\n\r\n<p>Jangan biarkan rencana mulia membangun rumah ibadah terhambat oleh budget yang membengkak atau vendor yang tidak amanah. Bayangkan betapa bangganya jamaah saat melihat kubah masjid yang berkilau mewah menjadi ikon baru di lingkungan Anda. Kesempatan untuk mendapatkan harga promo langsung dari pabrik tidak datang dua kali! Segera hubungi kami dengan&nbsp;<strong>Klik Button WhatsApp dibawah</strong><strong>&nbsp;</strong>sekarang untuk mendapatkan perhitungan biaya gratis dan desain eksklusif yang disesuaikan dengan kebutuhan Anda. Kami siap mewujudkan mahkota masjid impian Anda menjadi kenyataan!</p>', './images/1779340976_artikel8.webp', 1, 1, '2026-05-21 05:22:56', '2026-05-21 05:22:56'),
(14, 'Pesan Kubah Masjid Stainless Sekarang, Anti Karat Selamanya!', 'pesan-kubah-masjid-stainless-sekarang-anti-karat-selamanya', '<p><strong>Pesan kubah masjid</strong>&nbsp;material stainless steel adalah pilihan yang tepat untuk Anda yang menyukai kombinasi mewah dan tahan lama. Saat ini adalah era dari perkembangan teknologi konstruksi, dan material stainless steel adalah pilihan yang paling utama. Hal ini dikarenakan materialnya tahan pada korosi, terutama pada wilayah-wilayah dengan kelembahan tinggi. Dengan memilih material ini, Anda tidak hanya membangun sebuah atap rumah ibadah, tetapi juga memberikan perlindungan maksimal yang akan tetap berkilau tanpa perlu khawatir akan noda karat yang merusak estetika masjid selama puluhan tahun.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Baca juga:&nbsp;</strong><a href=\"https://kubahku.id/kubahku/detail_artikel/masjid-raya-al-jabbar-bandung-ikon-arsitektur-terbaru\" target=\"_blank\"><strong>Masjid Raya Al Jabbar Bandung: Ikon Arsitektur Terbaru</strong></a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Pesan kubah masjid</strong>&nbsp;dengan spesifikasi stainless steel terbaik memastikan biaya perawatan jangka panjang Anda menjadi jauh lebih hemat. Berbeda dengan material lain yang mungkin memerlukan pengecatan ulang secara berkala, stainless steel memiliki sifat&nbsp;<em>self-healing</em>&nbsp;terhadap lapisan pelindungnya. Selain itu, bobotnya yang relatif ringan dibandingkan beton cor membuat beban pada struktur bangunan menjadi lebih rendah, sehingga konstruksi masjid jauh lebih aman dari risiko keretakan fondasi. Keunggulan ini menjadikan stainless steel sebagai solusi praktis, ekonomis, dan tetap memberikan kesan elegan melalui kilaunya yang bersih.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Pesan Kubah Masjid: Mengapa Kualitas Kami Berbeda?</strong></h3>\r\n\r\n<p>Kami memahami bahwa kubah adalah mahkota dari setiap masjid. Oleh karena itu, kami menawarkan beberapa standar kualitas unggulan:</p>\r\n\r\n<ul>\r\n	<li><strong>Material Grade Industri:</strong>&nbsp;Kami hanya menggunakan stainless steel kualitas premium (seperti tipe 304) yang teruji anti karat secara permanen.</li>\r\n	<li><strong>Teknik Sambungan Presisi:</strong>&nbsp;Menggunakan teknologi pengelasan mutakhir untuk memastikan kubah 100% anti bocor.</li>\r\n	<li><strong>Estetika Reflektif:</strong>&nbsp;Permukaan yang mengkilap sempurna, memberikan kesan megah saat terkena pantulan cahaya matahari maupun lampu di malam hari.</li>\r\n	<li>&nbsp;</li>\r\n</ul>\r\n\r\n<p>Jangan biarkan rencana mulia Anda terhambat oleh kekhawatiran akan kualitas bangunan yang cepat rusak. Bayangkan masjid Anda berdiri megah dengan mahkota berkilauan yang tidak akan pernah pudar dimakan usia. Kami di sini siap membantu mewujudkan visi tersebut dengan pengerjaan yang rapi, profesional, dan tepat waktu. Yuk konsultasi sekarang pada&nbsp;<a href=\"https://api.whatsapp.com/send?phone=6285168613452&amp;text=Assalamualaikum%20KubahKu.id%20,%20mohon%20info%20kubahnya?\" target=\"_blank\"><strong><u>t</u></strong></a>im ahli kamu dengan&nbsp;<strong>Klik Button WhatsApp dibawah</strong><a href=\"https://api.whatsapp.com/send?phone=6285168613452&amp;text=Assalamualaikum%20KubahKu.id%20,%20mohon%20info%20kubahnya?\" target=\"_blank\"><u>.</u></a>&nbsp;Dan mari kita ciptakan mahkota masjid terbaik yang akan dibanggakan oleh seluruh jamaah hingga generasi mendatang!</p>', './images/1779341071_artikel9.webp', 1, 1, '2026-05-21 05:24:31', '2026-05-21 05:24:31'),
(15, 'Viral! Cek Disini Tempat Jual Kubah Masjid Beton Cor Termurah!', 'viral-cek-disini-tempat-jual-kubah-masjid-beton-cor-termurah', '<p><strong>Jual Kubah Masjid&nbsp;</strong>dengan bahan betor cor menjadi perbincangan hangat baru-baru ini dikalangan pengurus masjid. Hal ini dikarenakan, banyak orang yang sudah mengetahui kelebihan dari material ini, yakni ketahanannya. Dengan memilih bahan ini, tentunya para pengurus masjid tidak memerlukan biaya yang banyak untuk membuat kubah yang megah dan estetik. Selain kokoh menghadapi cuaca ekstrem di Indonesia, kubah jenis ini memberikan kesan mewah yang permanen, tanpa perlu khawatir soal kebocoran atau kerusakan warna dalam jangka waktu singkat.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Jual Kubah Masjid Beton Cor: Rahasia Masjid Kokoh Abadi</strong></h3>\r\n\r\n<p><strong>Jual kubah masjid</strong>&nbsp;dengan teknik cor beton seringkali dianggap mahal oleh sebagian orang, padahal kenyataannya justru jauh lebih hemat untuk investasi jangka panjang. Mengapa bisa viral? Karena kini hadir teknologi&nbsp;<em>molding</em>&nbsp;terbaru yang membuat proses pengerjaan jauh lebih cepat dan presisi. Anda tidak hanya mendapatkan kubah yang kuat secara struktur, tetapi juga desain detail yang sangat artistik. Bayangkan sebuah kubah yang tetap berdiri tegak dan indah meskipun sudah dihantam hujan dan panas selama puluhan tahun. Inilah alasan mengapa para kontraktor besar kini beralih kembali ke material beton.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Baca juga:&nbsp;</strong><a href=\"https://kubahku.id/kubahku/detail_artikel/update-harga-kubah-masjid-aluminium-terbaru-tahun-ini\" target=\"_blank\"><strong>Update Harga Kubah Masjid Aluminium Terbaru Tahun Ini</strong></a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Banyak penyedia di luar sana yang menawarkan harga selangit, namun kami hadir membawa standar baru. Kami memahami bahwa setiap rupiah dana umat sangat berharga. Oleh karena itu, kami mengkombinasikan efisiensi kerja dengan material semen berkualitas tinggi untuk menghasilkan kubah yang bukan hanya sekadar atap, melainkan mahkota bagi rumah Allah.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Jangan Sampai Menyesal Salah Pilih Kontraktor!</strong></h3>\r\n\r\n<p>Sudah banyak yang kecewa karena tergiur harga murah tapi kubah retak hanya dalam hitungan bulan.&nbsp;<strong>Apakah Anda ingin masjid kebanggaan jamaah bocor saat hujan tiba atau terlihat kusam dalam setahun? Tentu tidak!</strong></p>\r\n\r\n<p><strong>﻿</strong></p>\r\n\r\n<p>Jangan pertaruhkan dana umat pada yang belum berpengalaman. Konsultasikan kebutuhan kubah masjid Anda sekarang juga secara&nbsp;<strong>GRATIS</strong>&nbsp;kepada tim kami. <strong>Klik tombol WhatsAp</strong>p di bawah ini atau hubungi kami segera untuk mendapatkan penawaran harga spesial yang akan membuat Anda terkejut.&nbsp;<strong>Amankan kuota pengerjaan bulan ini dan wujudkan masjid megah impian jamaah sekarang juga!</strong></p>', './images/1779341181_artikel10.webp', 1, 1, '2026-05-21 05:26:21', '2026-05-21 05:26:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `portfolios`
--

CREATE TABLE `portfolios` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `portfolios`
--

INSERT INTO `portfolios` (`id`, `title`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Masjid Magelang', 'Jln magelang km.5 popongan, no 231. rt 012 rw 030 kelurahan sinduadi kec mlati DIY', 'images/1779302461_MAGELANG.webp', '2026-05-20 18:41:01', '2026-05-21 04:07:49'),
(2, 'Masjid Al-Fudhollah', 'Link Pecek RT 003, RW 003 Gedong Dalem Kecamatan Jombang Kota Cilegon', 'images/1779330015_Masjid-Al-Fudhollah.webp', '2026-05-21 02:20:15', '2026-05-21 04:11:36'),
(3, 'Masjid Al-Muhaijrin', 'Masjid Al-Muhajirin, Pasar kurik, Rt 3, Rw 2, Kampung kurik, Kec. Kurik, Kab. Merauke, Prov. PAPUA SELATAN', 'images/1779330054_Masjid-Al-Muhajirin.webp', '2026-05-21 02:20:54', '2026-05-21 04:08:33'),
(4, 'Masjid Al-Munawarah Pandai', 'Alamat : Masjid Al-Munawarah Pandai, Desa Pandai, Kec. Pantar Kab. Alor, Prov. NTT. \r\nTetap kita saling berkordinasi yah Abah.', 'images/1779330098_Masjid-Al-Munawarah-Pandai.webp', '2026-05-21 02:21:38', '2026-05-21 04:09:15'),
(5, 'Masjid Baru Makassar', 'Masjid Baru Gn Medan, Kec. Sitiung, Kab. Dharmasraya, Sumatera Barat', 'images/1779330127_Masjid-Baru-MAKASSAR.webp', '2026-05-21 02:22:08', '2026-05-21 04:09:54'),
(6, 'Masjid Baru', 'Jl. Masale 1, Kel Tamamaung Kec. Panakkukang, Makasar Sulawesi Selatan di Makasar', 'images/1779330160_Masjid-Baru.webp', '2026-05-21 02:22:40', '2026-05-21 04:10:28'),
(7, 'Masjid Darus Salam', 'Dsn. Banyumas, Ds. Klampar, Kec. Proppo, Kab. Pamekasan', 'images/1779330182_MASJID-DARUS-SALAM.webp', '2026-05-21 02:23:02', '2026-05-21 04:10:56'),
(8, 'Masjid Muzdalifah', 'Asinua, KEC. Unaaha, Kabupaten Konawe, Sulawesi Tenggara', 'images/1779330207_Masjid-Muzdalifah.webp', '2026-05-21 02:23:27', '2026-05-21 04:12:27'),
(9, 'Masjid Nurul Mujahidin', 'Tameming, Kel. Kalabahi Barat, Kec. Teluk Mutiara, Kab. Alor NUSA TENGGARA TIMUR', 'images/1779330242_MASJID-NURUL-MUJAHIDIN--2-.webp', '2026-05-21 02:24:02', '2026-05-21 04:12:05'),
(10, 'Masjid Nurul Mujahidin', 'Kecamatan taka bonerate, kabupaten kepulauan selayar\r\nSULAWESI SELATAN', 'images/1779330267_MASJID-NURUL-MUJAHIDIN.webp', '2026-05-21 02:24:27', '2026-05-21 04:07:20'),
(11, 'Masjid Usang', 'Lekok, Jorong Bungo Tanjung Nagarisaok Laweh, Kec. Kubung, Kab. Solok', 'images/1779330293_Masjid-Usang.webp', '2026-05-21 02:24:54', '2026-05-21 04:06:28'),
(12, 'Masjid Yayasan Ponpes Al-Mati\'in', 'Jl. H. Nasa Syamsyudin, Kedaung, Pamulang, Tangerang Selatan', 'images/1779330345_Masjid-Yayasan-Ponpes-Al-Mati---in.webp', '2026-05-21 02:25:45', '2026-05-21 04:05:59'),
(13, 'Musholla Al-Ashri', 'Jl. Sememi Jaya Gg 9B Rt 11 Rw 01 Kecamatan Benowo Kota Surabaya', 'images/1779330372_Musholla-Al--Ashri.webp', '2026-05-21 02:26:12', '2026-05-21 04:06:12'),
(14, 'Musholla Syaikhuna', 'Apotek Medika Jln Tambunbungai - Palangkaraya Kalimantan Tengah', 'images/1779330401_Musholla-Syaikhuna.webp', '2026-05-21 02:26:41', '2026-05-21 04:04:32'),
(15, 'Masjid Pamekasan', 'Dusun Tlangi 1, Desa Waru Barat, Kecamatan Waru, Kabupaten Pamekasan.', 'images/1779330423_PAMEKASAN.webp', '2026-05-21 02:27:04', '2026-05-21 04:03:34');

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_today_page_stats`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_today_page_stats` (
`clicks` bigint
,`first_click` time
,`last_click` time
,`page_name` varchar(100)
,`unique_ips` bigint
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_today_wa_stats`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_today_wa_stats` (
`today_clicks` bigint
,`top_page` varchar(100)
,`top_page_clicks` bigint
,`unique_visitors` bigint
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_wa_total_stats`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_wa_total_stats` (
`first_click_date` date
,`last_click_date` date
,`most_clicked_page` varchar(100)
,`most_clicked_page_total` bigint
,`total_active_days` bigint
,`total_all_clicks` bigint
,`total_unique_visitors` bigint
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_wa_weekly_stats`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_wa_weekly_stats` (
`click_date` date
,`pages_clicked` bigint
,`total_clicks` bigint
,`unique_visitors` bigint
);

-- --------------------------------------------------------

--
-- Struktur dari tabel `wa_clicks`
--

CREATE TABLE `wa_clicks` (
  `id` int NOT NULL,
  `page_name` varchar(100) NOT NULL COMMENT 'Nama halaman yang diklik (index, produk, harga, dll)',
  `page_url` varchar(255) NOT NULL COMMENT 'URL lengkap halaman',
  `button_type` varchar(50) DEFAULT 'standard' COMMENT 'Jenis button (sticky, inline, footer, dll)',
  `user_ip` varchar(45) DEFAULT NULL COMMENT 'IP address pengunjung',
  `user_agent` text COMMENT 'Browser dan device info',
  `referer` varchar(255) DEFAULT NULL COMMENT 'Halaman sebelumnya (jika ada)',
  `click_date` date NOT NULL COMMENT 'Tanggal klik',
  `click_time` time NOT NULL COMMENT 'Waktu klik',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Tracking setiap klik tombol WhatsApp';

--
-- Trigger `wa_clicks`
--
DELIMITER $$
CREATE TRIGGER `after_wa_click_insert` AFTER INSERT ON `wa_clicks` FOR EACH ROW BEGIN
    
    INSERT INTO wa_daily_stats (stat_date, total_clicks, unique_ips) 
    VALUES (NEW.click_date, 1, 1)
    ON DUPLICATE KEY UPDATE 
        total_clicks = total_clicks + 1,
        unique_ips = (SELECT COUNT(DISTINCT user_ip) FROM wa_clicks WHERE click_date = NEW.click_date);
    
    
    INSERT INTO wa_page_stats (stat_date, page_name, click_count)
    VALUES (NEW.click_date, NEW.page_name, 1)
    ON DUPLICATE KEY UPDATE 
        click_count = click_count + 1;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `wa_daily_stats`
--

CREATE TABLE `wa_daily_stats` (
  `id` int NOT NULL,
  `stat_date` date NOT NULL COMMENT 'Tanggal statistik',
  `total_clicks` int DEFAULT '0' COMMENT 'Total klik hari ini',
  `unique_ips` int DEFAULT '0' COMMENT 'Jumlah IP unik',
  `top_page` varchar(100) DEFAULT NULL COMMENT 'Halaman dengan klik terbanyak',
  `top_page_clicks` int DEFAULT '0' COMMENT 'Jumlah klik halaman teratas',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Ringkasan statistik harian klik WhatsApp';

-- --------------------------------------------------------

--
-- Struktur dari tabel `wa_page_stats`
--

CREATE TABLE `wa_page_stats` (
  `id` int NOT NULL,
  `stat_date` date NOT NULL COMMENT 'Tanggal statistik',
  `page_name` varchar(100) NOT NULL COMMENT 'Nama halaman',
  `click_count` int DEFAULT '0' COMMENT 'Jumlah klik di halaman ini',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Statistik klik per halaman per hari';

-- --------------------------------------------------------

--
-- Struktur untuk view `v_today_page_stats`
--
DROP TABLE IF EXISTS `v_today_page_stats`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_today_page_stats`  AS SELECT `wa_clicks`.`page_name` AS `page_name`, count(0) AS `clicks`, count(distinct `wa_clicks`.`user_ip`) AS `unique_ips`, min(`wa_clicks`.`click_time`) AS `first_click`, max(`wa_clicks`.`click_time`) AS `last_click` FROM `wa_clicks` WHERE (`wa_clicks`.`click_date` = curdate()) GROUP BY `wa_clicks`.`page_name` ORDER BY `clicks` DESC ;

-- --------------------------------------------------------

--
-- Struktur untuk view `v_today_wa_stats`
--
DROP TABLE IF EXISTS `v_today_wa_stats`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_today_wa_stats`  AS SELECT count(0) AS `today_clicks`, count(distinct `wa_clicks`.`user_ip`) AS `unique_visitors`, (select `wa_clicks`.`page_name` from `wa_clicks` where (`wa_clicks`.`click_date` = curdate()) group by `wa_clicks`.`page_name` order by count(0) desc limit 1) AS `top_page`, (select count(0) from `wa_clicks` where ((`wa_clicks`.`click_date` = curdate()) and (`wa_clicks`.`page_name` = (select `wa_clicks`.`page_name` from `wa_clicks` where (`wa_clicks`.`click_date` = curdate()) group by `wa_clicks`.`page_name` order by count(0) desc limit 1)))) AS `top_page_clicks` FROM `wa_clicks` WHERE (`wa_clicks`.`click_date` = curdate()) ;

-- --------------------------------------------------------

--
-- Struktur untuk view `v_wa_total_stats`
--
DROP TABLE IF EXISTS `v_wa_total_stats`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_wa_total_stats`  AS SELECT count(0) AS `total_all_clicks`, count(distinct `wa_clicks`.`user_ip`) AS `total_unique_visitors`, count(distinct `wa_clicks`.`click_date`) AS `total_active_days`, min(`wa_clicks`.`click_date`) AS `first_click_date`, max(`wa_clicks`.`click_date`) AS `last_click_date`, (select `wa_clicks`.`page_name` from `wa_clicks` group by `wa_clicks`.`page_name` order by count(0) desc limit 1) AS `most_clicked_page`, (select count(0) from `wa_clicks` where (`wa_clicks`.`page_name` = (select `wa_clicks`.`page_name` from `wa_clicks` group by `wa_clicks`.`page_name` order by count(0) desc limit 1))) AS `most_clicked_page_total` FROM `wa_clicks` ;

-- --------------------------------------------------------

--
-- Struktur untuk view `v_wa_weekly_stats`
--
DROP TABLE IF EXISTS `v_wa_weekly_stats`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_wa_weekly_stats`  AS SELECT `wa_clicks`.`click_date` AS `click_date`, count(0) AS `total_clicks`, count(distinct `wa_clicks`.`user_ip`) AS `unique_visitors`, count(distinct `wa_clicks`.`page_name`) AS `pages_clicked` FROM `wa_clicks` WHERE (`wa_clicks`.`click_date` >= (curdate() - interval 7 day)) GROUP BY `wa_clicks`.`click_date` ORDER BY `wa_clicks`.`click_date` DESC ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `published` (`published`),
  ADD KEY `created_at` (`created_at`);

--
-- Indeks untuk tabel `portfolios`
--
ALTER TABLE `portfolios`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `wa_clicks`
--
ALTER TABLE `wa_clicks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_date` (`click_date`),
  ADD KEY `idx_page` (`page_name`),
  ADD KEY `idx_created` (`created_at`);

--
-- Indeks untuk tabel `wa_daily_stats`
--
ALTER TABLE `wa_daily_stats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stat_date` (`stat_date`),
  ADD KEY `idx_date` (`stat_date`);

--
-- Indeks untuk tabel `wa_page_stats`
--
ALTER TABLE `wa_page_stats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_date_page` (`stat_date`,`page_name`),
  ADD KEY `idx_date` (`stat_date`),
  ADD KEY `idx_page` (`page_name`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `portfolios`
--
ALTER TABLE `portfolios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `wa_clicks`
--
ALTER TABLE `wa_clicks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `wa_daily_stats`
--
ALTER TABLE `wa_daily_stats`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `wa_page_stats`
--
ALTER TABLE `wa_page_stats`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

DELIMITER $$
--
-- Event
--
CREATE DEFINER=`root`@`localhost` EVENT `cleanup_old_wa_clicks` ON SCHEDULE EVERY 1 MONTH STARTS '2026-05-25 23:50:38' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    
    DELETE FROM wa_clicks 
    WHERE created_at < DATE_SUB(NOW(), INTERVAL 90 DAY);
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
