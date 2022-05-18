<?php

namespace backend\models\search;

use common\models\models\Type;
use yii\data\ActiveDataProvider;

class TypeModel extends Type
{
    public function search() {
        $this->load(\Yii::$app->request->queryParams);
        return new ActiveDataProvider(['query' => $this->getQuery()]);
    }

    public function getQuery() {
        return self::findActive('t');
    }

    public function findUsage() {
        return array_merge($this->sections, $this->nutrients);
    }
}