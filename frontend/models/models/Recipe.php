<?php

namespace app\models\models;

use app\models\relations\RecipeNutrient;
use Yii;

/**
 * This is the model class for table "recipe".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $field top title, like 22.5t.
 * @property string|null $percent percent, like 0.48%
 * @property int|null $visible hide or show recipe
 * @property int|null $created_at
 * @property int|null $deleted_at
 *
 * @property History[] $histories
 * @property RecipeNutrient[] $recipeNutrients
 */
class Recipe extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recipe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['visible', 'created_at', 'deleted_at'], 'integer'],
            [['name', 'field', 'percent'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'field' => 'Field',
            'percent' => 'Percent',
            'visible' => 'Visible',
            'created_at' => 'Created At',
            'deleted_at' => 'Deleted At',
        ];
    }

    /**
     * Gets query for [[Histories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHistories()
    {
        return $this->hasMany(History::class, ['recipe_id' => 'id']);
    }

    /**
     * Gets query for [[RecipeNutrients]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecipeNutrients()
    {
        return $this->hasMany(RecipeNutrient::class, ['recipe_id' => 'id']);
    }
}
