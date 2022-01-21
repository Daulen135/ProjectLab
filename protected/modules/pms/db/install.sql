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
-- TABLE `tbl_pms_project`
-- -------------------------------------------
DROP TABLE IF EXISTS `tbl_pms_project`;
CREATE TABLE IF NOT EXISTS `tbl_pms_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `currency` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_id` int(11) DEFAULT '0',  /* Education, Investment, Project execution */
  `state_id` int(11) NOT NULL DEFAULT '0', /* Planning, Completed, Inprogress. */
  `created_on` datetime NOT NULL,
  `created_by_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX(`title`),
  KEY `fk_pms_project_created_by_id` (`created_by_id`),
  CONSTRAINT `fk_pms_project_created_by_id` FOREIGN KEY (`created_by_id`) REFERENCES `tbl_user` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



-- -------------------------------------------
-- TABLE `tbl_pms_milestone`
-- -------------------------------------------
DROP TABLE IF EXISTS `tbl_pms_milestone`;
CREATE TABLE IF NOT EXISTS `tbl_pms_milestone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `state_id` int(11) NOT NULL DEFAULT '0',
  `type_id` int(11) DEFAULT '0', 
  `created_on` datetime NOT NULL,
  `created_by_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX(`title`),
  KEY `fk_pms_milestone_project_id` (`project_id`),
  KEY `fk_pms_milestone_created_by_id` (`created_by_id`),
  CONSTRAINT `fk_pms_milestone_project_id` FOREIGN KEY (`project_id`) REFERENCES `tbl_pms_project` (`id`),
  CONSTRAINT `fk_pms_milestone_created_by_id` FOREIGN KEY (`created_by_id`) REFERENCES `tbl_user` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



-- -------------------------------------------
-- TABLE `tbl_pms_deliverable`
-- -------------------------------------------
DROP TABLE IF EXISTS `tbl_pms_deliverable`;
CREATE TABLE IF NOT EXISTS `tbl_pms_deliverable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL DEFAULT '0',
  `type_id` int(11) DEFAULT '0', 
  `created_on` datetime NOT NULL,
  `created_by_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX(`title`),
  KEY `fk_pms_deliverable_project_id` (`project_id`),
  KEY `fk_pms_deliverable_created_by_id` (`created_by_id`),
  CONSTRAINT `fk_pms_deliverable_project_id` FOREIGN KEY (`project_id`) REFERENCES `tbl_pms_project` (`id`),
  CONSTRAINT `fk_pms_deliverable_created_by_id` FOREIGN KEY (`created_by_id`) REFERENCES `tbl_user` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



-- -------------------------------------------
-- TABLE `tbl_pms_success_criteria`
-- -------------------------------------------
DROP TABLE IF EXISTS `tbl_pms_success_criteria`;
CREATE TABLE IF NOT EXISTS `tbl_pms_success_criteria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL DEFAULT '0',
  `type_id` int(11) DEFAULT '0', 
  `created_on` datetime NOT NULL,
  `created_by_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX(`title`),
  KEY `fk_pms_success_criteria_project_id` (`project_id`),
  KEY `fk_pms_success_criteria_created_by_id` (`created_by_id`),
  CONSTRAINT `fk_pms_success_criteria_project_id` FOREIGN KEY (`project_id`) REFERENCES `tbl_pms_project` (`id`),
  CONSTRAINT `fk_pms_success_criteria_created_by_id` FOREIGN KEY (`created_by_id`) REFERENCES `tbl_user` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



-- -------------------------------------------
-- TABLE `tbl_pms_task`
-- -------------------------------------------
DROP TABLE IF EXISTS `tbl_pms_task`;
CREATE TABLE IF NOT EXISTS `tbl_pms_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  `amount` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date NOT NULL,
  `progress_id` int(11) DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_id` int(11) DEFAULT '0',  /* High, Medium, Low */
  `state_id` int(11) NOT NULL DEFAULT '0', /* New, Completed, Inprogress. */
  `created_on` datetime NOT NULL,
  `created_by_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX(`title`),
  KEY `fk_pms_task_created_by_id` (`created_by_id`),
  KEY `fk_pms_task_project_id` (`project_id`),
  CONSTRAINT `fk_pms_task_created_by_id` FOREIGN KEY (`created_by_id`) REFERENCES `tbl_user` (`id`),
  CONSTRAINT `fk_pms_task_project_id` FOREIGN KEY (`project_id`) REFERENCES `tbl_pms_project` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



-- --------------------------------------------------------
-- TABLE `tbl_pms_capex_budget`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `tbl_pms_capex_budget`;
CREATE TABLE IF NOT EXISTS `tbl_pms_capex_budget` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `milestone_id` int(11) NOT NULL,
  `amount` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_id` int(11) NOT NULL DEFAULT '0',
  `type_id` int(11) DEFAULT '0', 
  `created_on` datetime NOT NULL,
  `created_by_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pms_capex_budget_created_by_id` (`created_by_id`),
  KEY `fk_pms_capex_budget_project_id` (`project_id`),
  KEY `fk_pms_capex_budget_milestone_id` (`milestone_id`),
  CONSTRAINT `fk_pms_capex_budget_created_by_id` FOREIGN KEY (`created_by_id`) REFERENCES `tbl_user` (`id`),
  CONSTRAINT `fk_pms_capex_budget_project_id` FOREIGN KEY (`project_id`) REFERENCES `tbl_pms_project` (`id`),
  CONSTRAINT `fk_pms_capex_budget_milestone_id` FOREIGN KEY (`milestone_id`) REFERENCES `tbl_pms_milestone` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- --------------------------------------------------------
-- TABLE `tbl_pms_opex_budget`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `tbl_pms_opex_budget`;
CREATE TABLE IF NOT EXISTS `tbl_pms_opex_budget` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `amount` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `expense` varchar(255) NOT NULL,
  `payroll` varchar(255) NOT NULL,
  `state_id` int(11) NOT NULL DEFAULT '0',
  `type_id` int(11) DEFAULT '0', 
  `created_on` datetime NOT NULL,
  `created_by_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pms_opex_budget_created_by_id` (`created_by_id`),
  KEY `fk_pms_opex_budget_project_id` (`project_id`),
  CONSTRAINT `fk_pms_opex_budget_created_by_id` FOREIGN KEY (`created_by_id`) REFERENCES `tbl_user` (`id`),
  CONSTRAINT `fk_pms_opex_budget_project_id` FOREIGN KEY (`project_id`) REFERENCES `tbl_pms_project` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- --------------------------------------------------------
-- TABLE `tbl_pms_finance`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `tbl_pms_finance`;
CREATE TABLE IF NOT EXISTS `tbl_pms_finance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `rate_id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `cash_flow` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `income` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `opex` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_id` int(11) NOT NULL DEFAULT '0',
  `type_id` int(11) DEFAULT '0', 
  `created_on` datetime NOT NULL,
  `created_by_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pms_finance_created_by_id` (`created_by_id`),
  KEY `fk_pms_finance_project_id` (`project_id`),
  KEY `fk_pms_finance_rate_id` (`rate_id`),
  CONSTRAINT `fk_pms_finance_created_by_id` FOREIGN KEY (`created_by_id`) REFERENCES `tbl_user` (`id`),
  CONSTRAINT `fk_pms_finance_project_id` FOREIGN KEY (`project_id`) REFERENCES `tbl_pms_project` (`id`),
  CONSTRAINT `fk_pms_finance_rate_id` FOREIGN KEY (`rate_id`) REFERENCES `tbl_pms_rate` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- --------------------------------------------------------
-- TABLE `tbl_pms_rate`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `tbl_pms_rate`;
CREATE TABLE IF NOT EXISTS `tbl_pms_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_id` int(11) NOT NULL,
  `rate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_id` int(11) NOT NULL DEFAULT '0',
  `type_id` int(11) DEFAULT '0', 
  `created_on` datetime NOT NULL,
  `created_by_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pms_rate_created_by_id` (`created_by_id`),
  KEY `fk_pms_rate_project_id` (`project_id`),
  CONSTRAINT `fk_pms_rate_created_by_id` FOREIGN KEY (`created_by_id`) REFERENCES `tbl_user` (`id`),
  CONSTRAINT `fk_pms_rate_project_id` FOREIGN KEY (`project_id`) REFERENCES `tbl_pms_project` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- --------------------------------------------------------
-- TABLE `tbl_pms_risk_matrix`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `tbl_pms_risk_matrix`;
CREATE TABLE IF NOT EXISTS `tbl_pms_risk_matrix` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_id` int(11) NOT NULL,
  `severity` int(11) NOT NULL, /* likehood */
  `impact` int(11) NOT NULL, /* consequence */
  `factor` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_id` int(11) NOT NULL DEFAULT '0', /* High, Low, Extreme, Moderate */
  `type_id` int(11) DEFAULT '0', 
  `created_on` datetime NOT NULL,
  `created_by_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pms_risk_matrix_created_by_id` (`created_by_id`),
  KEY `fk_pms_risk_matrix_project_id` (`project_id`),
  CONSTRAINT `fk_pms_risk_matrix_created_by_id` FOREIGN KEY (`created_by_id`) REFERENCES `tbl_user` (`id`),
  CONSTRAINT `fk_pms_risk_matrix_project_id` FOREIGN KEY (`project_id`) REFERENCES `tbl_pms_project` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
-- --------------------------------------------------------


COMMIT;
-- -------------------------------------------
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
-- -------------------------------------------
-- END BACKUP
-- -------------------------------------------
