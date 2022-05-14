<?php

namespace frontend\models\editor;

use app\models\models\Recipe;
use app\models\models\Section;
use app\models\query\RemovableQuery;
use app\models\relations\RecipeNutrient;
use app\models\relations\SectionNutrient;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class SectionSelector extends RecipeNutrient
{
    public $nutrient_name;
    public $section_name;
    public $nutrient_alive;
    public $section_alive;
    public $code;

    public function getEditorList() {
        $ex = self::findActive('a')->recipe($this->recipe_id);

        $query = self::find()->select('*')
            ->from(Section::findActive('s')
                ->select([
                    'id' => null,
                    'section_id' => 's.id',
                    'section_name' => 's.name',
                    'nutrient_id' => 'n.id',
                    'nutrient_name' => 'n.name',
                    'weight' => null,
                    'comment' => null,
                    'code' => new Expression('CONCAT(s.id, \'_\', n.id)'),
                ])
                ->innerJoinWith('nutrients')
            );

        $exists = $ex->indexBy('code')->all();
        $all = $query->indexBy('code')->all();

        /** @var self[] $list */
        $list = array_merge($all, $exists);
        ArrayHelper::multisort($list, 'code');

        $result = [];
        $section_id = null;
        foreach ($list as $k => $model) {
            if ($section_id === null || $model->section_id !== $section_id) {
                $result[] = new self(['section_id' => $model->section_id, 'section_name' => $model->section_name]);
                $section_id = $model->section_id;
            }
            $result[] = $model;
        }
        return $result;
    }

    public function getModels() {
        $query = self::find()->alias('c')->select('*')
            ->from(Section::findActive('s')
            ->select([
                'id' => null,
                'section_id' => 's.id',
                'section_name' => 's.name',
                'nutrient_id' => 'n.id',
                'nutrient_name' => 'n.name',
                'weight' => null,
                'comment' => null,
            ])
            ->innerJoinWith('nutrients')
        );

        $ex = self::findActive('a')->recipe($this->recipe_id);

        $sl = Section::findActive('s')->select(['id']);
        $se = self::findActive('se')->select(['section_id'])->recipe($this->recipe_id);

        $q = SectionNutrient::findActive('sn')->section($sl);
        $e = self::findActive('ss')->recipe($this->recipe_id);




        $q1 = SectionNutrient::find('s');
        $q2 = self::findActive()->recipe($this->recipe_id);

        $q1->leftJoin(['q' => $q2], 'q.section_id = s.section_id and q.nutrient_id = s.nutrient_id')
            ->where(['or', ['not', ['s.deleted_at' => null]], ['not', ['q.id' => null]]]);

        self::find()->from(['q' => $q1]);


        $q = self::find()
            ->select([
                'id' => new Expression('IFNULL()'),
                'section_id' => 's.id',
                'section_name' => 's.name',
                'nutrient_id' => 'n.id',
                'nutrient_name' => 'n.name',
                'weight' => null,
                'comment' => null,
            ])
            ->from(['c' => $query])
            ->leftJoin(['ex' => $ex], 'c.nutrient_id = ex.nutrient_id and c.section_id = ex.section_id');



        $list = $query->all();
        $exist = $ex->all();



        /** @var Section[] $sections */
        $sections = $query->all();
        $rows = [];
        foreach ($sections as $section) {
            $rows[] = $section;
            foreach ($section->nutrients as $nutrient) {
                $rows[] = $nutrient;
            }
        }
        return $rows;
    }

    public static function findActive($alias = null)
    {
        /** @var SelectorQuery $query */
        $query = parent::findActive($alias);
        return $query
            ->buildSelect()
            ->joinWith('nutrient n')
            ->joinWith('section s')
            ->joinWith('recipe r');
    }

    public static function getQueryModel() {
        return new SelectorQuery(static::class);
    }
}