<?php

namespace frontend\models\models;

use backend\models\search\RecipeActiveRow;
use common\models\models\Recipe;
use common\models\relations\RecipeNutrient;
use yii\data\ArrayDataProvider;

class RecipeView extends RecipeNutrient
{
    public $type_id;

    public function search() {
        return new ArrayDataProvider(['allModels' => $this->sort($this->getModels()), 'pagination' => ['pageSize' => 200],]);
    }

    public function sort($array) {
        usort($array, static function(self $a, self $b) {
            return (int)($a->section->name) > (int)($b->section->name);
        });
        return $array;
    }

    public function getModels() {
        return self::findActive('rn')
            ->joinWith('recipe r')
            ->joinWith('section s')
            ->joinWith('nutrient n')
            ->andWhere(['rn.recipe_id' => $this->recipe_id])
            ->andWhere(['s.type_id' => $this->type_id])
            ->all();
    }
}