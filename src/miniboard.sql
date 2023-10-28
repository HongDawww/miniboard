-- --------------------------------------------------------
-- 호스트:                          127.0.0.1
-- 서버 버전:                        10.11.5-MariaDB - mariadb.org binary distribution
-- 서버 OS:                        Win64
-- HeidiSQL 버전:                  12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- miniboard 데이터베이스 구조 내보내기
CREATE DATABASE IF NOT EXISTS `miniboard` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `miniboard`;

-- 테이블 miniboard.miniboard 구조 내보내기
CREATE TABLE IF NOT EXISTS `miniboard` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `b_title` varchar(100) NOT NULL,
  `b_content` text NOT NULL,
  `b_date` datetime NOT NULL,
  `b_hit` int(10) unsigned NOT NULL DEFAULT 0,
  `b_id` varchar(20) NOT NULL,
  `b_pw` varchar(50) NOT NULL,
  `delete_flg` int(11) DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 테이블 데이터 miniboard.miniboard:~17 rows (대략적) 내보내기
INSERT INTO `miniboard` (`id`, `b_title`, `b_content`, `b_date`, `b_hit`, `b_id`, `b_pw`, `delete_flg`) VALUES
	(1, 'dd', 'dd', '2023-10-04 09:44:03', 0, 'ddd', '1234', 0),
	(2, '1111111111', '111111', '2023-10-04 09:58:45', 0, '1111111111', '1234', 0),
	(3, '2222', '2222', '2023-10-04 09:58:55', 0, '2222', '2222', 0),
	(4, '333', '3333', '2023-10-04 09:59:02', 0, '3333', '3333', 0),
	(5, '4444', '4444', '2023-10-04 09:59:12', 0, '4444', '4444', 0),
	(6, '5555', '5555', '2023-10-04 09:59:21', 0, '5555', '5555', 0),
	(7, '6666', '6666', '2023-10-04 09:59:28', 0, '6666', '6666', 0),
	(8, '777', '7777', '2023-10-04 09:59:35', 0, '7777', '7777', 0),
	(9, '888', '8888', '2023-10-04 09:59:43', 0, '8888', '8888', 0),
	(10, '9999', '9999', '2023-10-04 09:59:51', 0, '9999', '9999', 0),
	(11, '1010', '1010', '2023-10-04 10:00:01', 0, '1010', '1010', 0),
	(12, '1212', '1212', '2023-10-04 10:00:17', 0, '1212', '1212', 0),
	(13, '1313', '1313', '2023-10-04 10:00:26', 0, '1313', '1313', 0),
	(14, '1414', '1414', '2023-10-04 10:00:37', 0, '1414', '1414', 0),
	(15, 'ddddddddd', 'dddddddddd', '2023-10-04 15:57:56', 0, 'dddddddd', 'dddddddddd', 0),
	(16, 'sdaf', 'sfda', '2023-10-04 16:11:21', 0, 'sadf', 'safd', 0),
	(17, 'sfsfd', 'asfsfd', '2023-10-05 09:23:37', 0, 'safdsfd', 'sadfsadf', 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
