<?php

namespace common\models\models;

use common\models\traits\DeletableTrait;
use Yii;
use Yii\data\ActiveDataProvider;

/**
 * This is the model class for table "nutrient_type".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $sort_num
 * @property int|null $allow_mix
 * @property int|null $created_at
 * @property int|null $deleted_at
 *
 * @property Nutrient[] $nutrients
 * @property Section[] $sections
 */
class Type extends BaseModel
{
    use DeletableTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nutrient_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sort_num', 'allow_mix'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function search() {
        return new ActiveDataProvider(['query' => self::findActive()]);
    }

    public static function getList() {
        return self::findActive()->select(['name', 'id'])->indexBy('id')->column();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Тип',
            'sort_num' => 'Sort Num',
            'allow_mix' => 'Allow Mix',
        ];
    }

    /**
     * Gets query for [[Nutrients]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNutrients()
    {
        return $this->hasMany(Nutrient::class, ['type_id' => 'id']);
    }

    /**
     * Gets query for [[Sections]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSections()
    {
        return $this->hasMany(Section::class, ['type_id' => 'id']);
    }
}
