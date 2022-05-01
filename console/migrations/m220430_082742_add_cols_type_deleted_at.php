<?php

use yii\db\Migration;

/**
 * Class m220430_082742_add_cols_type_deleted_at
 */
class m220430_082742_add_cols_type_deleted_at extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('nutrient_type', 'created_at', $this->integer());
        $this->addColumn('nutrient_type', 'deleted_at', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('nutrient_type', 'created_at');
        $this->dropColumn('nutrient_type', 'deleted_at');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220430_082742_add_cols_type_deleted_at cannot be reverted.\n";

        return false;
    }
    */
}
