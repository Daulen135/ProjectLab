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
class m220105_190139_alter_tbl_contact_information_change_to_default_null extends Migration
{

    public function safeUp()
    {
        $table = Yii::$app->db->getTableSchema('{{%contact_information}}');
        if (isset($table->columns['full_name'])) {
            $this->execute("ALTER TABLE `tbl_contact_information` CHANGE `full_name` `full_name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;");
        }
        if (isset($table->columns['email'])) {
            $this->execute("ALTER TABLE `tbl_contact_information` CHANGE `email` `email` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;");
        }
        if (isset($table->columns['subject'])) {
            $this->execute("ALTER TABLE `tbl_contact_information` CHANGE `subject` `subject` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;");
        }
    }

    public function safeDown()
    {
        $table = Yii::$app->db->getTableSchema('{{%contact_information}}');
        if (! isset($table->columns['full_name'])) {
            $this->execute("ALTER TABLE `tbl_contact_information` ADD `full_name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL AFTER `id`;");
        }
        if (! isset($table->columns['email'])) {
            $this->execute("ALTER TABLE `tbl_contact_information` ADD `email` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL AFTER `full_name`;");
        }
        if (! isset($table->columns['subject'])) {
            $this->execute("ALTER TABLE `tbl_contact_information` ADD `subject` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL AFTER `email`;");
        }
    }
}