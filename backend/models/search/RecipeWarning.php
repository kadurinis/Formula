<?php

namespace backend\models\search;

class RecipeWarning extends RecipeNutrientModel
{
    public function getModels($indexBy = 'id')
    {
        /** @var self[] $wrong_types */
        $wrong_types = self::findActive('rn')
            ->innerJoinWith('nutrient n')
            ->innerJoinWith('section s')
            ->innerJoinWith('recipe r')
            ->andFilterWhere(['s.id' => $this->id])
            ->andWhere(['r.deleted_at' => null])
            ->andWhere('n.type_id != s.type_id')
            ->all();

        /** @var self[] $dead_nutrients */
        $dead_nutrients = self::findActive('s')
            ->joinWith('allNutrients n')
            ->innerJoinWith('recipe r')
            ->andFilterWhere(['s.id' => $this->id])
            ->andWhere(['r.deleted_at' => null])
            ->andWhere(['not', ['n.deleted_at' => null]])
            ->all();

        $arr = [];
        foreach ($wrong_types as $model) {
            $arr[$model->$indexBy] = "Нутриент не совпадает по типу с секцией";
        }
        foreach ($dead_nutrients as $model) {
            $arr[$model->$indexBy] = "Нутриент удален из списка нутриентов";
        }
        return $arr;
    }
    public function getAllNutrients() {
        return $this->hasMany(NutrientModel::class, ['id' => 'nutrient_id']);
    }

    public static function getCount() {
        return count((new self())->getModels());
    }
}