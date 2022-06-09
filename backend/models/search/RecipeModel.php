<?php

namespace backend\models\search;

use common\models\models\Recipe;
use common\models\relations\RecipeNutrient;
use yii\data\ActiveDataProvider;

class RecipeModel extends Recipe
{
    const VISIBLE = 1;
    const INVISIBLE = 0;

    public function search() {
        $this->load(\Yii::$app->request->queryParams);
        return new ActiveDataProvider(['query' => $this->getQuery()]);
    }

    public function getQuery() {
        return self::findActive('n')
            ->andFilterWhere(['like', 'n.name', $this->name]);
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['name'], 'required'],
        ]);
    }

    public function show() {
        $this->visible = self::VISIBLE;
        return $this;
    }

    public function hide() {
        $this->visible = self::INVISIBLE;
        return $this;
    }

    public function getRowModel() {
        return new RecipeActiveRow(['recipe_id' => $this->id]);
    }

    public function copy() {
        if ($this->isNewRecord) {
            return 'Невозможно создать копию';
        }
        $name = $this->name . ' - копия ';
        $i = 1;
        while (self::findActive()->andWhere(['name' => $name . $i])->exists()) {
            $i++;
        }
        $name .= $i;

        $copy = new self([
            'name' => $name,
            'field' => $this->field,
            'percent' => $this->percent,
            'visible' => $this->visible,
        ]);
        if ($copy->save()) {
            /** @var RecipeNutrientModel[] $rows */
            $rows = RecipeNutrientModel::findActive('rn')->andWhere(['rn.recipe_id' => $this->id])->orderBy(['rn.id' => SORT_ASC])->all();
            foreach ($rows as $row) {
                $n = $row->copy();
                $n->recipe_id = $copy->id;
                $n->save();
            }
            return $copy;
        }
        return 'Не удалось скопировать';
    }
}