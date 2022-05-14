<?php

namespace frontend\models\editor;

use app\models\query\RemovableQuery;
use yii\db\Expression;

class SelectorQuery extends RemovableQuery
{
    public function buildSelect() {
        return $this->select([
            $this->c('id'),
            'section_id' => 's.id',
            'section_name' => 's.name',
            'nutrient_id' => 'n.id',
            'nutrient_name' => 'n.name',
            $this->c('weight'),
            $this->c('comment'),
            'code' => new Expression('CONCAT(s.id, \'_\', n.id)'),
        ]);
    }
}