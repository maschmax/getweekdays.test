CREATE DATABASE `bonnier_case`;
USE `bonnier_case`;

CREATE TABLE `months` (
						  `id` int unsigned NOT NULL,
						  `monthname` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
						  `code` int unsigned NOT NULL,
						  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;


CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `year` int unsigned NOT NULL,
  `month_id` int unsigned NOT NULL,
  `day` int unsigned NOT NULL,
  `weekday` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`month_id`) REFERENCES months(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;



INSERT INTO `months` (`id`, `monthname`, `code`) VALUES
('1', 'January', '0'),
('2', 'February', '3'),
('3', 'March', '3'),
('4', 'April', '6'),
('5', 'May', '1'),
('6', 'June', '4'),
('7', 'July', '6'),
('8', 'August', '2'),
('9', 'September', '5'),
('10', 'October', '0'),
('11', 'November', '3'),
('12', 'December', '5');

