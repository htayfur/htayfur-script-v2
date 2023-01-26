-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 14 Eyl 2016, 18:12:27
-- Sunucu sürümü: 5.7.11
-- PHP Sürümü: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `ht_db`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `dinlediklerim`
--

CREATE TABLE `dinlediklerim` (
  `id` int(11) NOT NULL,
  `sarkiadi` text NOT NULL,
  `sarkikodu` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `fotograflar`
--

CREATE TABLE `fotograflar` (
  `id` int(11) NOT NULL,
  `yaziid` int(11) NOT NULL,
  `fotolink` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `genelayarlar`
--

CREATE TABLE `genelayarlar` (
  `id` int(11) NOT NULL,
  `ht_anahtar` varchar(55) NOT NULL,
  `ht_deger` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `genelayarlar`
--

INSERT INTO `genelayarlar` (`id`, `ht_anahtar`, `ht_deger`) VALUES
(1, 'siteadresi', 'http://htscriptv2'),
(2, 'temayolu', '/tema/htblack/'),
(3, 'siteadi', 'Hakan Tayfur'),
(4, 'kacadetyazi', '10'),
(5, 'sitedescription', ''),
(6, 'sitekeywords', ''),
(7, 'logo', ''),
(8, 'izlemekodu', '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `izlediklerim`
--

CREATE TABLE `izlediklerim` (
  `id` int(11) NOT NULL,
  `filmadi` text NOT NULL,
  `filmafis` text NOT NULL,
  `filmyil` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategoriler`
--

CREATE TABLE `kategoriler` (
  `id` int(11) NOT NULL,
  `kategoriadi` text NOT NULL,
  `kategoriurl` text NOT NULL,
  `kategoridescription` text NOT NULL,
  `kategorikeywords` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `id` int(11) NOT NULL,
  `adsoyad` varchar(15) NOT NULL,
  `kadi` varchar(15) NOT NULL,
  `sifre` varchar(32) NOT NULL,
  `email` varchar(25) NOT NULL,
  `yetki` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sayfalar`
--

CREATE TABLE `sayfalar` (
  `id` int(11) NOT NULL,
  `sayfa` varchar(25) NOT NULL,
  `anatitle` varchar(255) NOT NULL,
  `anakeywords` varchar(255) NOT NULL,
  `anadescription` varchar(255) NOT NULL,
  `anaicerik` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yazilar`
--

CREATE TABLE `yazilar` (
  `id` int(11) NOT NULL,
  `yaziadi` text NOT NULL,
  `yaziicerik` text NOT NULL,
  `yazikeywords` text NOT NULL,
  `yazidescription` text NOT NULL,
  `yaziyazar` int(5) NOT NULL,
  `yazitarih` datetime NOT NULL,
  `yazidurum` varchar(10) NOT NULL,
  `yaziurl` text NOT NULL,
  `yazionecikarilmis` text NOT NULL,
  `yazikategori` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yetenekler`
--

CREATE TABLE `yetenekler` (
  `id` int(11) NOT NULL,
  `yetenekadi` varchar(15) NOT NULL,
  `yetenekaciklama` text NOT NULL,
  `yetenekyuzde` varchar(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `yetenekler`
--

INSERT INTO `yetenekler` (`id`, `yetenekadi`, `yetenekaciklama`, `yetenekyuzde`) VALUES
(1, 'HTML', '', '%100'),
(2, 'PHP', 'Orta Düzey', '%90'),
(3, 'MySQL', '', '%95'),
(4, 'CSS', 'CSS1 / CSS2', '%90'),
(5, 'jQuery', '', '%75'),
(6, 'Java', 'Temel', '%20'),
(7, 'Android', '', '%25');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `dinlediklerim`
--
ALTER TABLE `dinlediklerim`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `fotograflar`
--
ALTER TABLE `fotograflar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `genelayarlar`
--
ALTER TABLE `genelayarlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `izlediklerim`
--
ALTER TABLE `izlediklerim`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kategoriler`
--
ALTER TABLE `kategoriler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `sayfalar`
--
ALTER TABLE `sayfalar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `yazilar`
--
ALTER TABLE `yazilar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `yetenekler`
--
ALTER TABLE `yetenekler`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `dinlediklerim`
--
ALTER TABLE `dinlediklerim`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `fotograflar`
--
ALTER TABLE `fotograflar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `genelayarlar`
--
ALTER TABLE `genelayarlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Tablo için AUTO_INCREMENT değeri `izlediklerim`
--
ALTER TABLE `izlediklerim`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `kategoriler`
--
ALTER TABLE `kategoriler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `sayfalar`
--
ALTER TABLE `sayfalar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `yazilar`
--
ALTER TABLE `yazilar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `yetenekler`
--
ALTER TABLE `yetenekler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
