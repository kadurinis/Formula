<?php

namespace common\models\models;

use common\models\relations\RecipeNutrient;
use common\models\relations\SectionNutrient;
use common\models\traits\DeletableTrait;
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
 * @property Recipe[] $recipes
 */
class Section extends BaseModel
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
            'created_at' => 'Создано',
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
        return $this->hasMany(RecipeNutrient::class, ['section_id' => 'id'])->alias('rn')->andOnCondition(['rn.deleted_at' => null]);
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

    public function getRecipes() {
        return $this->hasMany(Recipe::class, ['id' => 'recipe_id'])->alias('r')->via('recipeNutrients')->andOnCondition(['r.deleted_at' => null]);
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
