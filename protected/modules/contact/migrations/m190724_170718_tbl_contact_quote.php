<?php
 
 


use yii\db\Migration;

class m190724_170718_tbl_contact_quote extends Migration{
    public function safeUp()
	{
                                    $this->execute("DROP TABLE IF EXISTS `tbl_contact_quote`;
CREATE TABLE IF NOT EXISTS `tbl_contact_quote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `quote` int(11) DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `model_type` varchar(255) DEFAULT NULL,
  `detail` text NOT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `skype` varchar(255) DEFAULT NULL,
  `state_id` int(11) DEFAULT '0',
  `type_id` varchar(255) DEFAULT '0',
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
                                }
                
	public function safeDown()
	{

		echo "m190724_170718_tbl_contact_quote migrating down by doing nothing....\n";

	}
}