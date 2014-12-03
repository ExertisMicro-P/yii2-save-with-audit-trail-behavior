<?php

use yii\db\Schema;
use yii\db\Migration;

class m141203_093938_create_audittrail extends Migration
{
    public function up()
    {
        /*
                    CREATE TABLE `audittrail` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `table_name` VARCHAR(64) NULL DEFAULT NULL,
                    `record_id` INT(11) NULL DEFAULT NULL,
                    `message` VARCHAR(1024) NULL DEFAULT NULL,
                    `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `username` VARCHAR(128) NULL DEFAULT NULL,
                    PRIMARY KEY (`id`),
                    INDEX `table_name` (`table_name`),
                    INDEX `record_id` (`record_id`),
                    INDEX `audit_lookup` (`table_name`, `record_id`)
            )
            COLLATE='latin1_swedish_ci'
            ENGINE=InnoDB
            AUTO_INCREMENT=36249873
            ;
         *
         */

         $this->createTable('audittrail', [
            'id' => 'pk',
            'table_name' => Schema::TYPE_STRING,
            'record_id' => Schema::TYPE_INTEGER,
            'message' => Schema::TYPE_STRING,
            'timestamp' => Schema::TYPE_TIMESTAMP.' DEFAULT CURRENT_TIMESTAMP',
            'username' => Schema::TYPE_STRING,
        ]);

         $this->createIndex('table_name', 'audittrail', 'table_name');
         $this->createIndex('record_id', 'audittrail', 'record_id');
         $this->createIndex('audit_lookup', 'audittrail', ['table_name', 'record_id']);

    }

    public function down()
    {
        echo "m141203_093938_create_audittrail cannot be reverted.\n";

        return false;
    }
}
