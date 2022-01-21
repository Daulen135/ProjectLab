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
class m211228_101243_alter_tbl_contact_information_add_ip_address_add_country_code extends Migration
{

    public function safeUp()
    {
        $table = Yii::$app->db->getTableSchema('{{%contact_information}}');
        if (! isset($table->columns['ip_address'])) {
            $this->addColumn('{{%contact_information}}', 'ip_address', $this->string(64)
                ->defaultValue(null)
                ->after('address'));
        }
        if (! isset($table->columns['country_code'])) {
            $this->addColumn('{{%contact_information}}', 'country_code', $this->string(16)
                ->defaultValue(null)
                ->after('ip_address'));
        }

        if (! isset($table->columns['referrer_url'])) {
            $this->addColumn('{{%contact_information}}', 'referrer_url', $this->string(255)
                ->defaultValue(null)
                ->after('ip_address'));
        }
    }

    public function safeDown()
    {
        $table = Yii::$app->db->getTableSchema('{{%contact_information}}');
        if (isset($table->columns['ip_address'])) {
            $this->dropColumn('{{%contact_information}}', 'ip_address');
        }
        if (isset($table->columns['country_code'])) {
            $this->dropColumn('{{%contact_information}}', 'country_code');
        }
    }
}