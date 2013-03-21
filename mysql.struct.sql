DROP TABLE IF EXISTS `Colors`;
CREATE TABLE `Colors`(
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `hex` varchar(6) NOT NULL,
    `count` int unsigned NOT NULL DEFAULT '1',
    PRIMARY KEY (`id`),
    INDEX `rgb` (hex)
)ENGINE='InnoDB' DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `Webpages`;
CREATE TABLE `Webpages`(
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `url` varchar(50) NOT NULL,
    `code` mediumtext DEFAULT NULL,
    PRIMARY KEY (`id`)
)ENGINE='InnoDB' DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `Pictures`;
CREATE TABLE `Pictures`(
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `url_id` int unsigned NOT NULL,
    `adress` varchar(70) UNIQUE NOT NULL,
    `size` int unsigned NOT NULL,
    `width` int unsigned NOT NULL,
    `height` int unsigned NOT NULL,
    `histogram` mediumtext NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`url_id`) REFERENCES `Webpages` (`id`) ON DELETE CASCADE,
    INDEX (`url_id`)
)ENGINE='InnoDB' DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `PicturesColors`;
CREATE TABLE `Picture_Colors`(
    `pic_id` int unsigned NOT NULL,
    `color_id` int unsigned NOT NULL,
    INDEX `pics` (`pic_id`),
    INDEX `colors` (`color_id`),
    FOREIGN KEY (`pic_id`) REFERENCES `Pictures` (`id`) ON DELETE CASCADE,
    FOREIGN KEY (`color_id`) REFERENCES `Colors` (`id`) ON DELETE CASCADE
)ENGINE='InnoDB' DEFAULT CHARSET=utf8;