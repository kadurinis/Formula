<?php

use yii\db\Migration;

/**
 * Class m220514_195412_create_table_display
 */
class m220514_195412_create_table_display extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('display', [
            'id' => $this->primaryKey(),
            'primary_id' => $this->integer(),
            'secondary_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('display');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220514_195412_create_table_display cannot be reverted.\n";

        return false;
    }
    */
}
