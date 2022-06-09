<?php

use yii\db\Migration;

/**
 * Class m220609_103431_change_column_weight_to_varchar
 */
class m220609_103431_change_column_weight_to_varchar extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('recipe_nutrient', 'weight', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('recipe_nutrient', 'weight', $this->integer());
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220609_103431_change_column_weight_to_varchar cannot be reverted.\n";

        return false;
    }
    */
}
