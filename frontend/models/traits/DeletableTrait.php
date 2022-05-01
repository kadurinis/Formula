<?php

namespace app\models\traits;

use app\models\query\RemovableQuery;

trait DeletableTrait
{
    public function remove() {
        $this->deleted_at = time();
        return $this;
    }

    public static function findActive($alias = null) {
        return static::find($alias)->a();
    }

    public static function find($alias = null) {
        $query = new RemovableQuery(static::class);
        return $alias ? $query->alias($alias) : $query;
    }
}