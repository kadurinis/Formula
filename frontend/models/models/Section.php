<?php

namespace app\models\models;

use app\models\relations\RecipeNutrient;
use app\models\relations\SectionNutrient;
use app\models\traits\DeletableTrait;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "section".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $type_id
 * @property int|null $created_at
 * @property int|null $deleted_at
 *
 * @property RecipeNutrient[] $recipeNutrients
 * @property SectionNutrient[] $sectionNutrients
 * @property Type $type
 * @property Nutrient[] $nutrients
 */
class Section extends \yii\db\ActiveRecord
{
    use DeletableTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'section';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_id', 'created_at', 'deleted_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Type::class, 'targetAttribute' => ['type_id' => 'id']],
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
            'type_id' => 'Тип',
            'created_at' => 'Created At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function search() {
        return new ActiveDataProvider(['query' => self::findActive()]);
    }

    /**
     * Gets query for [[RecipeNutrients]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecipeNutrients()
    {
        return $this->hasMany(RecipeNutrient::class, ['section_id' => 'id']);
    }

    /**
     * Gets query for [[SectionNutrients]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSectionNutrients()
    {
        return $this->hasMany(SectionNutrient::class, ['section_id' => 'id'])->alias('sn')->andOnCondition(['sn.deleted_at' => null]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNutrients() {
        return $this->hasMany(Nutrient::class, ['id' => 'nutrient_id'])->alias('n')->via('sectionNutrients')->andOnCondition(['n.deleted_at' => null]);
    }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(Type::class, ['id' => 'type_id']);
    }
}
