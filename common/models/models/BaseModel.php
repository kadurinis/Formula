<?php

namespace common\models\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class BaseModel extends ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
                'skipUpdateOnClean' => false
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'created_at' => 'Создан',
            'deleted_at' => 'Удален',
        ];
    }
}