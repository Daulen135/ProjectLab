<?php
 
 


use yii\db\Migration;

class m190709_190713_blog_indexing extends Migration{
    public function safeUp()
	{
                                    $this->execute("ALTER TABLE `tbl_blog_post` ADD INDEX(`title`);
ALTER TABLE `tbl_blog_post` ADD INDEX(`keywords`);
ALTER TABLE `tbl_blog_post` ADD INDEX(`state_id`);
ALTER TABLE `tbl_blog_post` ADD INDEX(`created_on`);

ALTER TABLE `tbl_blog_category` ADD INDEX(`title`);
ALTER TABLE `tbl_blog_category` ADD INDEX(`state_id`);");
                                }
                
	public function safeDown()
	{

		echo "m190709_190713_blog_indexing migrating down by doing nothing....\n";

	}
}