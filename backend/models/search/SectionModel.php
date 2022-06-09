<?php

namespace backend\models\search;

use common\models\models\Nutrient;
use common\models\models\Section;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * @property Nutrient[] $allNutrients
 */
class SectionModel extends Section
{
    public function search() {
        $this->load(\Yii::$app->request->queryParams);
        return new ActiveDataProvider(['query' => $this->getQuery(), 'pagination' => ['pageSize' => 200]]);
    }

    public function getQuery() {
        return self::findActive('s')->joinWith('nutrients')->orderBy('type_id ASC, cast(s.name as unsigned) ASC')->groupBy('s.id');
    }

    public static function getList() {
        return self::findActive()->select(['name', 'id'])->indexBy('id')->column();
    }

    public function findUsage() {
        return $this->recipes; // array_merge($this->sectionNutrients, $this->recipeNutrients);
    }

    public function __toString() {
        return $this->name . '';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['type_id', 'name'], 'required'],
        ]);
    }

    public function beforeSave($insert)
    {
        $exist = self::findActive()->andWhere(['name' => $this->name, 'type_id' => $this->type_id])->one();
        if ($exist && ($insert || $exist->id !== $this->id)) {
            $this->addError('name', "Секция с именем {$this->name} существует");
            return false;
        }
        return parent::beforeSave($insert);
    }

    /**
     * @return NutrientModel[]|\yii\db\ActiveRecord[]
     */
    public function getAvailable() {
        $sq = ArrayHelper::getColumn($this->getBound(), 'id');
        return NutrientModel::findActive('n')
            ->andWhere(['n.type_id' => $this->type_id])
            ->andWhere(['not', ['n.id' => $sq]])->all();
    }

    /**
     * @return NutrientModel[]|\yii\db\ActiveRecord[]
     */
    public function getBound() {

        return NutrientModel::find()->alias('n')->joinWith('sectionNutrients')->andWhere(['sn.section_id' => $this->id])->orderBy(['sn.id' => SORT_ASC])->all();
    }

    public function getAllNutrients() {
        return $this->hasMany(NutrientModel::class, ['id' => 'nutrient_id'])->alias('n')->via('sectionNutrients');
    }
}