<?php
 
 


use yii\db\Migration;

class m190729_130719_indexing extends Migration{
    public function safeUp()
	{
                                    $this->execute("ALTER TABLE `tbl_contact_information` ADD INDEX(`full_name`);
ALTER TABLE `tbl_contact_information` ADD INDEX(`email`);
ALTER TABLE `tbl_contact_information` ADD INDEX(`created_on`);

ALTER TABLE `tbl_contact_quote` ADD INDEX(`email`);
ALTER TABLE `tbl_contact_quote` ADD INDEX(`model_id`);
ALTER TABLE `tbl_contact_quote` ADD INDEX(`model_type`);
ALTER TABLE `tbl_contact_quote` ADD INDEX(`created_on`);");
                                }
                
	public function safeDown()
	{

		echo "m190729_130719_indexing migrating down by doing nothing....\n";

	}
}