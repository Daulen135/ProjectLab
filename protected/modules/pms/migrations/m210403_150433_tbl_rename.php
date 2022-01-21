<?php
 /**
 *@copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 *@author    : Shiv Charan Panjeta < shiv@toxsl.com >
 *
 * All Rights Reserved.
 * Proprietary and confidential :  All information contained herein is, and remains
 * the property of ToXSL Technologies Pvt. Ltd. and its partners.
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 *
 */
 
use yii\db\Migration;
/**
 *   php console.php module/migrate 
 */
class m210403_150433_tbl_rename extends Migration{
    public function safeUp()
	{
                                    $this->execute("CREATE TABLE IF NOT EXISTS `tbl_rename` ( `id` int(11) NOT NULL AUTO_INCREMENT, `title` varchar(255) NOT NULL, `type_id` varchar(255) DEFAULT NULL, `state_id` int(11) DEFAULT 0, `created_by_id` int(11) NOT NULL, `created_on` datetime NOT NULL, PRIMARY KEY (`id`), INDEX(`created_on`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
                                }
                
	public function safeDown()
	{

		echo "m210403_150433_tbl_rename migrating down by doing nothing....\n";

	}
}