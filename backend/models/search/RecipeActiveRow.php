<?php

namespace backend\models\search;

use yii\data\ArrayDataProvider;

class RecipeActiveRow extends RecipeNutrientModel
{
    public function search() {
        return new ArrayDataProvider(['allModels' => $this->getModels()]);
    }

    public function getModels() {
        /** @var self[] $selected */
        $selected = self::findActive('rn')
            ->joinWith('recipe r')
            ->joinWith('section s')
            ->joinWith('nutrient n')
            ->andWhere(['rn.recipe_id' => $this->recipe_id])
            ->all();
        /** @var self[] $all */
        $doc = RecipeInactiveRow::findActive('ri')
            ->joinWith('section s')
            ->joinWith('nutrient n')
            ->all();

        $all = array_merge($doc, $selected);
        $arr = [];
        /** В merge $selected идут вторым, поэтому при совпадении кодов (сочетания section-nutrient), предпочтение будет отдано выбранному */
        foreach ($all as $item) {
            $arr[$item->getCode()] = $item;
        }

        usort($arr, static function ($a, $b) {
            return $a->section_id > $b->section_id || ($a->section_id === $b->section_id && $a->nutrient_id > $b->nutrient_id);
        });

        return $arr;
    }

    public function beforeSave($insert)
    {
        if (!$this->weight) {
            if ($insert) {
                $this->addError('weight', 'Вес должен быть целым числом в граммах, больше нуля');
                return false;
            }
            $this->remove();
        }
        return parent::beforeSave($insert);
    }

    public function isSelected() {
        return (bool)$this->id;
    }

    public static function findModel($params) {
        if (!isset($params['recipe_id'], $params['section_id'], $params['nutrient_id'])) {
            return 'Не переданы обязательные параметры';
        }
        $where = array_intersect_key($params, array_flip(['recipe_id', 'section_id', 'nutrient_id']));
        if ($model = self::findActive()->andWhere($where)->one()) {
            $model->attributes = $params;
        }else {
            $model = new self($params);
        }
        return $model;
    }
}