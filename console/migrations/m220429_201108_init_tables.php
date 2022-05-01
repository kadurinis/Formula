<?php

use yii\db\Migration;

/**
 * Class m220429_201108_init_tables
 */
class m220429_201108_init_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('recipe', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'field' => $this->string()->comment('top title, like 22.5t.'),
            'percent' => $this->string()->comment('percent, like 0.48%'),
            'visible' => $this->boolean()->defaultValue(1)->comment('hide or show recipe'),
            'created_at' => $this->integer(),
            'deleted_at' => $this->integer(),
        ], $tableOptions);
        $this->createTable('nutrient_type', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'sort_num' => $this->integer(),
            'allow_mix' => $this->boolean()->defaultValue(0),
        ], $tableOptions);
        $this->createTable('section', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'type_id' => $this->integer(),
            'created_at' => $this->integer(),
            'deleted_at' => $this->integer(),
        ], $tableOptions);
        $this->createTable('nutrient', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'type_id' => $this->integer(),
            'created_at' => $this->integer(),
            'deleted_at' => $this->integer(),
        ], $tableOptions);
        $this->createTable('section_nutrient', [
            'id' => $this->primaryKey(),
            'section_id' => $this->integer(),
            'nutrient_id' => $this->integer(),
            'deleted_at' => $this->integer(),
        ], $tableOptions);
        $this->createTable('recipe_nutrient', [
            'id' => $this->primaryKey(),
            'recipe_id' => $this->integer(),
            'section_id' => $this->integer(),
            'nutrient_id' => $this->integer(),
            'weight' => $this->integer(),
            'comment' => $this->string(),
            'created_at' => $this->integer(),
            'deleted_at' => $this->integer(),
        ], $tableOptions);
        $this->createTable('history', [
            'id' => $this->primaryKey(),
            'recipe_id' => $this->integer(),
            'started' => $this->integer(),
            'finished' => $this->integer(),
        ], $tableOptions);
        $this->addForeignKey('FK_history', 'history', 'recipe_id', 'recipe', 'id');
        $this->addForeignKey('FK_rep_nut_rep', 'recipe_nutrient', 'recipe_id', 'recipe', 'id');
        $this->addForeignKey('FK_rep_nut_sec', 'recipe_nutrient', 'section_id', 'section', 'id');

        $this->addForeignKey('FK_rep_nut_nut', 'recipe_nutrient', 'nutrient_id', 'nutrient', 'id');
        $this->addForeignKey('FK_sec_nut_sec', 'section_nutrient', 'section_id', 'section', 'id');
        $this->addForeignKey('FK_sec_nut_nut', 'section_nutrient', 'nutrient_id', 'nutrient', 'id');
        $this->addForeignKey('FK_nut_type', 'nutrient', 'type_id', 'nutrient_type', 'id');
        $this->addForeignKey('FK_sec_type', 'section', 'type_id', 'nutrient_type', 'id');

        $this->insert('nutrient_type', ['id' => 1, 'name' => 'Микро']);
        $this->insert('nutrient_type', ['id' => 2, 'name' => 'Макро']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_history', 'history');
        $this->dropForeignKey('FK_rep_nut_rep', 'recipe_nutrient');
        $this->dropForeignKey('FK_rep_nut_sec', 'recipe_nutrient');
        $this->dropForeignKey('FK_rep_nut_nut', 'recipe_nutrient');
        $this->dropForeignKey('FK_sec_nut_sec', 'section_nutrient');
        $this->dropForeignKey('FK_sec_nut_nut', 'section_nutrient');
        $this->dropForeignKey('FK_nut_type', 'nutrient');
        $this->dropForeignKey('FK_sec_type', 'section');

        $this->dropTable('history');
        $this->dropTable('recipe_nutrient');
        $this->dropTable('section_nutrient');
        $this->dropTable('nutrient');
        $this->dropTable('section');
        $this->dropTable('nutrient_type');
        $this->dropTable('recipe');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220429_201108_init_tables cannot be reverted.\n";

        return false;
    }
    */
}
