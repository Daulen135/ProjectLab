-- -------------------------------------------

SET SQL_QUOTE_SHOW_CREATE = 1;
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;

SET AUTOCOMMIT=0;
START TRANSACTION;
-- -------------------------------------------
-- -------------------------------------------
-- START BACKUP
-- -------------------------------------------


-- -------------------------------------------
-- TABLE `tbl_subscription_plan`
-- -------------------------------------------
DROP TABLE IF EXISTS `tbl_subscription_plan`;
CREATE TABLE IF NOT EXISTS `tbl_subscription_plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `validity` int(11) NOT NULL,
  `price` varchar(32) NOT NULL,
  `big_text` varchar(64) DEFAULT NULL,
  `state_id` int(11) DEFAULT 0,
  `type_id` int(11) NOT NULL,
  `created_on` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX(`title`),
  INDEX(`state_id`),
  INDEX(`created_on`),
  INDEX(`created_by_id`),
  KEY `fk_subscription_plan_created_by_id` (`created_by_id`),
  CONSTRAINT `fk_subscription_plan_created_by_id` FOREIGN KEY (`created_by_id`) REFERENCES `tbl_user` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------
-- TABLE `tbl_subscription_billing`
-- -------------------------------------------
DROP TABLE IF EXISTS `tbl_subscription_billing`;
CREATE TABLE IF NOT EXISTS `tbl_subscription_billing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subscription_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `state_id` int(11) NOT NULL ,
  `type_id` int(11) NOT NULL ,
  `created_on` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX(`state_id`),
  INDEX(`created_on`),
  INDEX(`created_by_id`), 
  KEY `fk_subscription_billing_subscription_id` (`subscription_id`),
  CONSTRAINT `fk_subscription_billing_subscription_id` FOREIGN KEY (`subscription_id`) REFERENCES `tbl_subscription_plan` (`id`),
  KEY `fk_subscription_billing_created_by_id` (`created_by_id`),
  CONSTRAINT `fk_subscription_billing_created_by_id` FOREIGN KEY (`created_by_id`) REFERENCES `tbl_user` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- -------------------------------------------

COMMIT;
-- -------------------------------------------
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
-- -------------------------------------------
-- END BACKUP
-- -------------------------------------------
