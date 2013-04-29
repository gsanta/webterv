<?php

class Install {

	public static function init_if_not_exists() {
    $connection = mysql_connect(Constants::$HOST,Constants::$DATABASE_USERNAME,Constants::$DATABASE_PASSWORD) or die("Hiba történt kapcsolódáskor".mysql_error() );

    if (!(mysql_select_db(Constants::$DATABASE_NAME,$connection)) ) {
      
      mysql_query("CREATE DATABASE ". Constants::$DATABASE_NAME . " DEFAULT CHARACTER SET utf8 COLLATE utf8_hungarian_ci;");


  		$db = new PDO(Constants::$DATABASE_URL, Constants::$DATABASE_USERNAME, Constants::$DATABASE_PASSWORD);

  		$sql_query = <<<STR
-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Hoszt: 127.0.0.1
-- Létrehozás ideje: 2013. ápr. 29. 21:40
-- Szerver verzió: 5.5.29
-- PHP verzió: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Adatbázis: `h171917`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet: `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `content` mediumtext COLLATE utf8mb4_hungarian_ci NOT NULL,
  `create_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `like` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci AUTO_INCREMENT=16 ;

--
-- A tábla adatainak kiíratása `comment`
--

INSERT INTO `comment` (`id`, `topic_id`, `user_id`, `content`, `create_date`, `modified_date`, `like`) VALUES
(1, 1, 2, 'Ide lehet írni filmekről mindenfélét.', '2013-04-19 19:58:09', '2013-04-19 19:58:09', 2),
(2, 1, 2, 'Valaki tud valami jó horror filmet ajánlani?', '2013-04-19 21:30:57', '2013-04-19 21:30:57', 0),
(13, 1, 8, 'Heló!\r\n\r\nParanormal Activity-t nézd meg:\r\n\r\nKatie és Micah, a húszas éveiben járó, középosztálybeli pár beköltözik az új San Diegó-i otthonába. Katie érdeklődik a természetfeletti jelenségek iránt, amelyek gyermekkora óta kísértik, Micah azonban nem hisz az ilyen dolgokban. Sőt, egyre dühösebb, amikor Katie beszámol neki az érzéseiről. Szerinte ugyanis van valami a házban, furcsa zajokat hall, és elmozdulnak helyükről a tárgyak. Micah végül vesz egy videokamerát, hogy így szerezzen bizonyítékot. A felvételek láttán libabőrös lesz a hátuk, éjszakánként ugyanis egy démon garázdálkodik náluk. A szörnyű események egyre szaporodnak, a fiatal pár az őrület határán áll.', '2013-04-29 20:03:03', '2013-04-29 20:03:03', 0),
(14, 6, 8, 'Kedvenc számotok?', '2013-04-29 20:15:38', '2013-04-29 20:15:38', 0),
(15, 6, 9, 'Sok van.', '2013-04-29 20:16:28', '2013-04-29 20:16:28', 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet: `last_read`
--

CREATE TABLE IF NOT EXISTS `last_read` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci AUTO_INCREMENT=88 ;

--
-- A tábla adatainak kiíratása `last_read`
--

INSERT INTO `last_read` (`id`, `topic_id`, `user_id`, `date`) VALUES
(76, 1, 8, '2013-04-29 20:11:12'),
(79, 6, 8, '2013-04-29 20:15:42'),
(81, 6, 9, '2013-04-29 20:16:31'),
(87, 1, 2, '2013-04-29 21:13:04');

-- --------------------------------------------------------

--
-- Tábla szerkezet: `topic`
--

CREATE TABLE IF NOT EXISTS `topic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci AUTO_INCREMENT=7 ;

--
-- A tábla adatainak kiíratása `topic`
--

INSERT INTO `topic` (`id`, `title`, `create_date`) VALUES
(1, 'Filmek', '2013-04-15 20:23:14'),
(2, 'Zene', '2013-04-15 20:23:14'),
(6, 'Bob Dylan', '2013-04-21 03:27:01');

-- --------------------------------------------------------

--
-- Tábla szerkezet: `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `password` char(32) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `image_name` varchar(100) COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT 'profile.jpg',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci AUTO_INCREMENT=11 ;

--
-- A tábla adatainak kiíratása `user`
--

INSERT INTO `user` (`id`, `name`, `password`, `email`, `image_name`) VALUES
(2, 'gsanta', 'e2d2215bb3c4809cd293e5fdfe00978b', 'santa_gergely@hotmail.com', 'profile_2.jpg'),
(8, 'bela90', '02841057993977c275a61bfa74457f5c', 'bela90@gmail.hu', 'profile.jpg'),
(9, 'kicsia', '0dcc7915f61300e659cd81b3c3e6a5e2', 'kicsia@gmail.hu', 'profile.jpg');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Hoszt: 127.0.0.1
-- Létrehozás ideje: 2013. ápr. 29. 21:40
-- Szerver verzió: 5.5.29
-- PHP verzió: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Adatbázis: `h171917`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet: `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `content` mediumtext COLLATE utf8mb4_hungarian_ci NOT NULL,
  `create_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `like` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci AUTO_INCREMENT=16 ;

--
-- A tábla adatainak kiíratása `comment`
--

INSERT INTO `comment` (`id`, `topic_id`, `user_id`, `content`, `create_date`, `modified_date`, `like`) VALUES
(1, 1, 2, 'Ide lehet írni filmekről mindenfélét.', '2013-04-19 19:58:09', '2013-04-19 19:58:09', 2),
(2, 1, 2, 'Valaki tud valami jó horror filmet ajánlani?', '2013-04-19 21:30:57', '2013-04-19 21:30:57', 0),
(13, 1, 8, 'Heló!\r\n\r\nParanormal Activity-t nézd meg:\r\n\r\nKatie és Micah, a húszas éveiben járó, középosztálybeli pár beköltözik az új San Diegó-i otthonába. Katie érdeklődik a természetfeletti jelenségek iránt, amelyek gyermekkora óta kísértik, Micah azonban nem hisz az ilyen dolgokban. Sőt, egyre dühösebb, amikor Katie beszámol neki az érzéseiről. Szerinte ugyanis van valami a házban, furcsa zajokat hall, és elmozdulnak helyükről a tárgyak. Micah végül vesz egy videokamerát, hogy így szerezzen bizonyítékot. A felvételek láttán libabőrös lesz a hátuk, éjszakánként ugyanis egy démon garázdálkodik náluk. A szörnyű események egyre szaporodnak, a fiatal pár az őrület határán áll.', '2013-04-29 20:03:03', '2013-04-29 20:03:03', 0),
(14, 6, 8, 'Kedvenc számotok?', '2013-04-29 20:15:38', '2013-04-29 20:15:38', 0),
(15, 6, 9, 'Sok van.', '2013-04-29 20:16:28', '2013-04-29 20:16:28', 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet: `last_read`
--

CREATE TABLE IF NOT EXISTS `last_read` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci AUTO_INCREMENT=88 ;

--
-- A tábla adatainak kiíratása `last_read`
--

INSERT INTO `last_read` (`id`, `topic_id`, `user_id`, `date`) VALUES
(76, 1, 8, '2013-04-29 20:11:12'),
(79, 6, 8, '2013-04-29 20:15:42'),
(81, 6, 9, '2013-04-29 20:16:31'),
(87, 1, 2, '2013-04-29 21:13:04');

-- --------------------------------------------------------

--
-- Tábla szerkezet: `topic`
--

CREATE TABLE IF NOT EXISTS `topic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci AUTO_INCREMENT=7 ;

--
-- A tábla adatainak kiíratása `topic`
--

INSERT INTO `topic` (`id`, `title`, `create_date`) VALUES
(1, 'Filmek', '2013-04-15 20:23:14'),
(2, 'Zene', '2013-04-15 20:23:14'),
(6, 'Bob Dylan', '2013-04-21 03:27:01');

-- --------------------------------------------------------

--
-- Tábla szerkezet: `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `password` char(32) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `image_name` varchar(100) COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT 'profile.jpg',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci AUTO_INCREMENT=11 ;

--
-- A tábla adatainak kiíratása `user`
--

INSERT INTO `user` (`id`, `name`, `password`, `email`, `image_name`) VALUES
(2, 'gsanta', 'e2d2215bb3c4809cd293e5fdfe00978b', 'santa_gergely@hotmail.com', 'profile_2.jpg'),
(8, 'bela90', '02841057993977c275a61bfa74457f5c', 'bela90@gmail.hu', 'profile.jpg'),
(9, 'kicsia', '0dcc7915f61300e659cd81b3c3e6a5e2', 'kicsia@gmail.hu', 'profile.jpg');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

STR;
			$stmt = $db->prepare($sql_query);
			$stmt->execute();

		} else {
			//echo 'rowCount = ' . $stmt->rowCount();
		}
	}

}