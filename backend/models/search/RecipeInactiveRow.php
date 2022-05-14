<?php

namespace backend\models\search;

class RecipeInactiveRow extends RecipeActiveRow
{
    public $weight = 0;
    public $comment = '';

    public static function tableName()
    {
        return 'section_nutrient';
    }

    public static function find($alias = null) {
        $t = $alias ?: self::tableName();
        return parent::find($alias)->select(["{$t}.section_id", "{$t}.nutrient_id", "{$t}.deleted_at"]);
    }
}