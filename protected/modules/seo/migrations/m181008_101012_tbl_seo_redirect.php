<?php
 
 


use yii\db\Migration;

class m181008_101012_tbl_seo_redirect extends Migration{
    public function safeUp()
	{
                                    $this->execute("CREATE TABLE IF NOT EXISTS `tbl_seo_redirect` ( `id` int(11) NOT NULL AUTO_INCREMENT, `old_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL, `new_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL, `state_id` int(11) NOT NULL DEFAULT '0', `type_id` int(11) NOT NULL DEFAULT '0', `created_on` datetime NOT NULL, `updated_on` datetime DEFAULT NULL, `created_by_id` int(11) NOT NULL, PRIMARY KEY (`id`), KEY `fk_seo_redirect_created_by_id` (`created_by_id`), CONSTRAINT `fk_seo_redirect_created_by_id` FOREIGN KEY (`created_by_id`) REFERENCES `tbl_user` (`id`) )ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
                                }
                
	public function safeDown()
	{

		echo "m181008_101012_tbl_seo_redirect migrating down by doing nothing....\n";

	}
}