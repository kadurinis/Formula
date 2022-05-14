<?php

namespace backend\models\search;

use common\models\models\Nutrient;
use yii\data\ActiveDataProvider;

class NutrientModel extends Nutrient
{
    public function search() {
        $this->load(\Yii::$app->request->queryParams);
        return new ActiveDataProvider(['query' => $this->getQuery()]);
    }

    public function getQuery() {
        return self::findActive('n')
            ->joinWith('type')
            ->andFilterWhere(['n.type_id' => $this->type_id])
            ->andFilterWhere(['like', 'n.name', $this->name]);
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
            $this->addError('name', "Нутриент с именем {$this->name} существует");
            return false;
        }
        return parent::beforeSave($insert);
    }

    public function findUsage() {
        return array_merge($this->sectionNutrients, $this->recipeNutrients);
    }

    public static function getList() {
        return self::findActive()->select(['name', 'id'])->indexBy('id')->column();
    }

    public function __toString() {
        return $this->name . '';
    }
}