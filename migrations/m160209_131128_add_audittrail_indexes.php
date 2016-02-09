<?php

use yii\db\Schema;
use yii\db\Migration;
use exertis\savewithaudittrail\models\Audittrail;

class m160209_131128_add_audittrail_indexes extends Migration
{
    public function up()
    {
        $this->createIndex('username', Audittrail::tableName(), 'username');
        $this->createIndex('timestamp', Audittrail::tableName(), 'timestamp');
    }

    public function down()
    {
        $this->dropIndex('username');
        $this->dropIndex('timestamp');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
