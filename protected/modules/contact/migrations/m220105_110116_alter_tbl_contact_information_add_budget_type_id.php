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
 * php console.php module/migrate
 */
class m220105_110116_alter_tbl_contact_information_add_budget_type_id extends Migration
{

    public function safeUp()
    {
        $table = Yii::$app->db->getTableSchema('{{%contact_information}}');
        if (! isset($table->columns['budget_type_id'])) {
            $this->addColumn('{{%contact_information}}', 'budget_type_id', $this->integer(11)
                ->defaultValue(null)
                ->after('website'));
        }
        if (! isset($table->columns['user_agent'])) {
            $this->execute("ALTER TABLE `tbl_contact_information` ADD `user_agent` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL AFTER `referrer_url`;");
        }
    }

    public function safeDown()
    {
        $table = Yii::$app->db->getTableSchema('{{%contact_information}}');
        if (isset($table->columns['budget_type_id'])) {
            $this->dropColumn('{{%contact_information}}', 'budget_type_id');
        }
        if (isset($table->columns['user_agent'])) {
            $this->dropColumn('{{%contact_information}}', 'user_agent');
        }
    }
}