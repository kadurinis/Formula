<?php

namespace common\models\traits;

use common\models\query\RemovableQuery;

trait DeletableTrait
{
    public function isAlive() {
        return !$this->deleted_at;
    }

    public function remove() {
        $this->deleted_at = time();
        return $this;
    }

    public static function findActive($alias = null) {
        return static::find($alias)->a();
    }

    public static function find($alias = null) {
        $query = static::getQueryModel();
        return $alias ? $query->alias($alias) : $query;
    }

    public static function getQueryModel() {
        return new RemovableQuery(static::class);
    }
}