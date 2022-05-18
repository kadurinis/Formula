<?php

namespace backend\models\search;

class SectionWarning extends SectionModel
{
    public function getModels()
    {
        /** @var self[] $wrong_types */
        $wrong_types = self::findActive('s')
            ->innerJoinWith('nutrients')
            ->andFilterWhere(['s.id' => $this->id])
            ->andWhere('n.type_id != s.type_id')
            ->all();

        /** @var self[] $dead_nutrients */
        $dead_nutrients = self::findActive('s')
            ->joinWith('allNutrients n')
            ->andFilterWhere(['s.id' => $this->id])
            ->andWhere(['not', ['n.deleted_at' => null]])
            ->all();

        $arr = [];
        foreach ($wrong_types as $model) {
            $arr[$model->id] = "Нутриент не совпадает по типу с секцией";
        }
        foreach ($dead_nutrients as $model) {
            $arr[$model->id] = "Нутриент удален из списка нутриентов";
        }
        return $arr;
    }

    public static function getCount() {
        return count((new self())->getModels());
    }
}