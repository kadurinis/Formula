<?php

namespace backend\models\search;

use common\models\relations\SectionNutrient;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

/**
 * @property-read NutrientModel $nutrient
 * @property-read SectionModel $section
 */
class SectionNutrientModel extends SectionNutrient
{
    public function search() {
        $this->load(\Yii::$app->request->queryParams);
        return new ActiveDataProvider(['query' => $this->getQuery()]);
    }

    public function getQuery() {
        return self::findActive('sn')
            ->joinWith('nutrient')
            ->joinWith('section')
            ->andFilterWhere(['sn.section_id' => $this->section_id])
            ->andFilterWhere(['sn.nutrient_id' => $this->nutrient_id]);
    }

    public function getNutrient()
    {
        return $this->hasOne(NutrientModel::class, ['id' => 'nutrient_id']);
    }

    public function getSection()
    {
        return $this->hasOne(SectionModel::class, ['id' => 'section_id']);
    }

    public function beforeSave($insert)
    {
        if ($insert && $this->findExist()) {
            $this->addError('id', 'Уже привязано');
            return false;
        }
        return parent::beforeSave($insert);
    }

    public function getCode() {
        return "{$this->section_id}_{$this->nutrient_id}";
    }

    /**
     * @return self|ActiveRecord|null
     */
    public function findExist() {
        return self::findActive()->andWhere(['section_id' => $this->section_id, 'nutrient_id' => $this->nutrient_id])->one();
    }
}