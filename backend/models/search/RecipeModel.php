<?php

namespace backend\models\search;

use common\models\models\Recipe;
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

    public static function getList() {
        return self::findActive()->select(['name', 'id'])->indexBy('id')->column();
    }
}