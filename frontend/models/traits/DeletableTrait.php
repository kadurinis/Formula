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
        $query = static::getQueryModel();
        return $alias ? $query->alias($alias) : $query;
    }

    public static function getQueryModel() {
        return new RemovableQuery(static::class);
    }
}