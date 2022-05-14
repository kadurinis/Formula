<?php

namespace backend\models\search;

use common\models\models\History;
use yii\data\ActiveDataProvider;

class HistoryModel extends History
{
    public function search() {
        $this->load(\Yii::$app->request->queryParams);
        return new ActiveDataProvider(['query' => $this->getQuery()]);
    }

    public function getQuery() {
        return self::find()->joinWith('recipe');
    }
}