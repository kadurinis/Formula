<?php

namespace app\models\query;

use yii\db\ActiveQuery;

class RemovableQuery extends ActiveQuery
{
    private $_alias;

    public function alias($alias)
    {
        $this->_alias = $alias;
        return parent::alias($alias);
    }

    protected function c($c) {
        return $this->_alias ? "{$this->_alias}.{$c}" : $c;
    }

    public function a() {
        return $this->andWhere([$this->c('deleted_at') => null]);
    }
}