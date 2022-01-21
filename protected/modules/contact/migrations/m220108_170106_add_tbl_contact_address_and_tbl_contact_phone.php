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
class m220108_170106_add_tbl_contact_address_and_tbl_contact_phone extends Migration
{

    public function safeUp()
    {
        $table = Yii::$app->db->getTableSchema('{{%contact_address}}');
        if (! $table) {
            $this->execute("CREATE TABLE IF NOT EXISTS `tbl_contact_address` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                  `tel` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                  `mobile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                  `latitude` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                  `longitude` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                  `state_id` int(11) DEFAULT '0',
                  `type_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
                  `created_on` datetime NOT NULL,
                  `updated_on` datetime DEFAULT NULL,
                  `created_by_id` int(11) NOT NULL,
                  PRIMARY KEY (`id`),
                  INDEX(`title`),
                  INDEX(`email`),
                  KEY `fk_address_created_by_id` (`created_by_id`),
                  CONSTRAINT `fk_address_created_by_id` FOREIGN KEY (`created_by_id`) REFERENCES `tbl_user` (`id`)
                ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }
        $phone_table = Yii::$app->db->getTableSchema('{{%contact_phone}}');
        if (! $phone_table) {
            $this->execute("CREATE TABLE IF NOT EXISTS `tbl_contact_phone` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                  `contact_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                  `type_chat` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                  `skype_chat` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                  `gtalk_chat` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                  `type_id` int(11) NOT NULL DEFAULT '0',
                  `state_id` int(11) NOT NULL,
                  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                  `created_on` datetime NOT NULL,
                  `created_by_id` int(11) DEFAULT NULL,
                  PRIMARY KEY (`id`),
                  INDEX(`title`),
                  INDEX(`state_id`),
                  KEY `FK_contact_phone_created_by_id` (`created_by_id`),
                  CONSTRAINT `FK_contact_phone_created_by_id` FOREIGN KEY (`created_by_id`) REFERENCES `tbl_user` (`id`)
                ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }
        $quote_table = Yii::$app->db->getTableSchema('{{%contact_quote}}');
        if ($quote_table) {
            $this->dropTable('{{%contact_quote}}');
        }
    }

    public function safeDown()
    {
        $table = Yii::$app->db->getTableSchema('{{%contact_address}}');
        if ($table) {
            $this->dropTable('{{%contact_address}}');
        }
        $phone_table = Yii::$app->db->getTableSchema('{{%contact_phone}}');
        if ($phone_table) {
            $this->dropTable('{{%contact_phone}}');
        }
    }
}