<?php

namespace common\models\relations;

use common\models\models\Nutrient;
use common\models\models\Recipe;
use common\models\models\Section;
use common\models\traits\DeletableTrait;

/**
 * This is the model class for table "recipe_nutrient".
 *
 * @property int $id
 * @property int|null $recipe_id
 * @property int|null $section_id
 * @property int|null $nutrient_id
 * @property int|null $weight
 * @property string|null $comment
 * @property int|null $created_at
 * @property int|null $deleted_at
 *
 * @property Nutrient $nutrient
 * @property Recipe $recipe
 * @property Section $section
 */
class RecipeNutrient extends \yii\db\ActiveRecord
{
    use DeletableTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recipe_nutrient';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['recipe_id', 'section_id', 'nutrient_id', 'weight', 'created_at', 'deleted_at'], 'integer'],
            [['comment'], 'string', 'max' => 255],
            [['nutrient_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nutrient::class, 'targetAttribute' => ['nutrient_id' => 'id']],
            [['recipe_id'], 'exist', 'skipOnError' => true, 'targetClass' => Recipe::class, 'targetAttribute' => ['recipe_id' => 'id']],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => Section::class, 'targetAttribute' => ['section_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'recipe_id' => 'Recipe ID',
            'section_id' => 'Section ID',
            'nutrient_id' => 'Nutrient ID',
            'weight' => 'Вес, г',
            'comment' => 'Комментарий',
            'created_at' => 'Created At',
            'deleted_at' => 'Deleted At',
        ];
    }

    /**
     * Gets query for [[Nutrient]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNutrient()
    {
        return $this->hasOne(Nutrient::class, ['id' => 'nutrient_id']);
    }

    /**
     * Gets query for [[Recipe]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecipe()
    {
        return $this->hasOne(Recipe::class, ['id' => 'recipe_id']);
    }

    /**
     * Gets query for [[Section]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(Section::class, ['id' => 'section_id']);
    }
}
