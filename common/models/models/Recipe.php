<?php

namespace common\models\models;

use common\models\relations\RecipeNutrient;
use common\models\traits\DeletableTrait;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

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
class Recipe extends BaseModel
{
    use DeletableTrait;

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
            'name' => 'Название',
            'field' => 'Тоннаж',
            'percent' => 'Проценты',
            'visible' => 'Visible',
            'created_at' => 'Создан',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getUpdatedAt() {
        return max($this->created_at, RecipeNutrient::find()->where(['recipe_id' => $this->id])->max('IFNULL(`deleted_at`, `created_at`)'));
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

    public static function getList() {
        return self::findActive()->select(['name', 'id'])->indexBy('id')->column();
    }

    public static function getActualList() {
        return self::findActive()->select(['name', 'id'])->andWhere(['visible' => 1])->indexBy('id')->column();
    }

    public function begin() {
        return new History(['recipe_id' => $this->id]);
    }

    public function getTotalWeight() {
        return RecipeNutrient::findActive('rn')->andWhere(['rn.recipe_id' => $this->id])->sum('rn.weight');
    }

    public function getManualInput() {
        return RecipeNutrient::findActive('rn')
            ->joinWith('section s')
            ->andWhere(['rn.recipe_id' => $this->id])
            ->andWhere(['>','s.name', 0])
            ->sum('rn.weight');
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['created_at'],
                ],
            ],
        ];
    }
}
