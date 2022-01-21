<?php
 
 


use yii\db\Migration;

class m190107_120149_contact extends Migration{
    public function safeUp()
	{
                                    $this->execute("-- --------------------------------------------
-- TABLE `tbl_contact_information`
-- -------------------------------------------
DROP TABLE IF EXISTS `tbl_contact_information`;
CREATE TABLE IF NOT EXISTS `tbl_contact_information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `description` text DEFAULT  NULL,
  `address` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `landline` varchar(255) DEFAULT NULL,
  `skype_id` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `state_id` int(11) DEFAULT '0',
  `type_id` varchar(255) DEFAULT '0',
  `created_on` datetime NOT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
 KEY `FK_contact_information_created_by` (`created_by_id`),
  CONSTRAINT `FK_contact_information_created_by` FOREIGN KEY (`created_by_id`) REFERENCES `tbl_user` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
                                }
                
	public function safeDown()
	{

		echo "m190107_120149_contact migrating down by doing nothing....\n";

	}
}