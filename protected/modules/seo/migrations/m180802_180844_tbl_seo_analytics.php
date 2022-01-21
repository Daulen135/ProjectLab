<?php
 
 


use yii\db\Migration;

class m180802_180844_tbl_seo_analytics extends Migration{
    public function safeUp()
	{
                                    $this->execute("CREATE TABLE IF NOT EXISTS `tbl_seo_analytics` ( `id` int(11) NOT NULL AUTO_INCREMENT, `account` varchar(512) COLLATE utf8_unicode_ci NOT NULL, `domain_name` varchar(512) COLLATE utf8_unicode_ci NOT NULL, `additional_information` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL, `state_id` int(11) NOT NULL DEFAULT '1', `type_id` int(11) NOT NULL DEFAULT '0', `created_on` datetime NOT NULL, `updated_on` datetime NOT NULL, `created_by_id` int(11) NOT NULL, PRIMARY KEY (`id`), KEY `fk_seo_analytics_created_by_id` (`created_by_id`), CONSTRAINT `fk_seo_analytics_created_by_id` FOREIGN KEY (`created_by_id`) REFERENCES `tbl_user` (`id`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
                                }
                
	public function safeDown()
	{

		echo "m180802_180844_tbl_seo_analytics migrating down by doing nothing....\n";

	}
}