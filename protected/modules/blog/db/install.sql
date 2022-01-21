
-- -------------------------------------------
SET AUTOCOMMIT=0;
START TRANSACTION;
SET SQL_QUOTE_SHOW_CREATE = 1;
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
-- -------------------------------------------
-- -------------------------------------------
-- --------------------------------------------
-- TABLE `tbl_blog_post`
-- -------------------------------------------
DROP TABLE IF EXISTS `tbl_blog_post`;
CREATE TABLE IF NOT EXISTS `tbl_blog_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_file` varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL,
  `view_count` int(11) NOT NULL DEFAULT '0',
  `state_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `created_by_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX(`title`),
  INDEX(`keywords`),
  INDEX(`state_id`),
  INDEX(`created_on`),
  KEY `FK_blog_created_by_id` (`created_by_id`),
  CONSTRAINT `FK_blog_created_by_id` FOREIGN KEY (`created_by_id`) REFERENCES `tbl_user` (`id`)

) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- --------------------------------------------
-- TABLE `tbl_category`
-- -------------------------------------------
DROP TABLE IF EXISTS `tbl_blog_category`;
CREATE TABLE IF NOT EXISTS `tbl_blog_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `state_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `created_by_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX(`title`),
  INDEX(`state_id`),
  KEY `FK_blog_category_created_by_id` (`created_by_id`),
  CONSTRAINT `FK_blog_category_created_by_id` FOREIGN KEY (`created_by_id`) REFERENCES `tbl_user` (`id`)

) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- -- -------------------------------------------
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
COMMIT;
-- --------------------------------------------------------------------------------------
-- END BACKUP
-- -------------------------------------------
