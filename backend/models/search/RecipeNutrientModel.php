<?php

namespace backend\models\search;

use common\models\relations\RecipeNutrient;
use yii\data\ActiveDataProvider;

class RecipeNutrientModel extends RecipeNutrient
{
    public function search() {
        $this->load(\Yii::$app->request->queryParams);
        return new ActiveDataProvider(['query' => $this->getQuery()]);
    }

    public function getQuery() {
        return self::findActive('rn');
    }

    public function getCode() {
        return "{$this->section_id}_{$this->nutrient_id}";
    }
}
