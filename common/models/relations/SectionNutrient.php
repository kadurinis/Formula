<?php

namespace common\models\relations;

use common\models\models\Nutrient;
use common\models\models\Section;
use common\models\traits\DeletableTrait;

/**
 * This is the model class for table "section_nutrient".
 *
 * @property int $id
 * @property int|null $section_id
 * @property int|null $nutrient_id
 * @property int|null $deleted_at
 *
 * @property Nutrient $nutrient
 * @property Section $section
 */
class SectionNutrient extends \yii\db\ActiveRecord
{
    use DeletableTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'section_nutrient';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['section_id', 'nutrient_id', 'deleted_at'], 'integer'],
            [['nutrient_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nutrient::class, 'targetAttribute' => ['nutrient_id' => 'id']],
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
            'section_id' => 'Section ID',
            'nutrient_id' => 'Nutrient ID',
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
     * Gets query for [[Section]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(Section::class, ['id' => 'section_id']);
    }
}
