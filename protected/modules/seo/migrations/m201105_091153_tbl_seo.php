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
class m201105_091153_tbl_seo extends Migration{
    public function safeUp()
	{
                                    $this->execute("ALTER TABLE `tbl_seo` ADD `state_id` INT(11) NOT NULL DEFAULT '0'  AFTER `data`;");
                                }
                
	public function safeDown()
	{

		echo "m201105_091153_tbl_seo migrating down by doing nothing....\n";

	}
}