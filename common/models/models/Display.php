<?php

namespace common\models\models;

use Yii;

/**
 * This is the model class for table "display".
 *
 * @property int $id
 * @property int|null $primary_id
 * @property int|null $secondary_id
 */
class Display extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'display';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['primary_id', 'secondary_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'primary_id' => 'Основной экран',
            'secondary_id' => 'Дополнительный экран',
        ];
    }

    public static function findModel() {
        if ($model = self::findActive()->one()) {
            return $model;
        }
        $model = new self(['primary_id' => 2, 'secondary_id' => 1]);
        $model->save();
        return $model;
    }

    public static function findActive() {
        return self::find();
    }
}
