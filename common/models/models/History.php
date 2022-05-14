<?php

namespace common\models\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "history".
 *
 * @property int $id
 * @property int|null $recipe_id
 * @property int|null $started
 * @property int|null $finished
 *
 * @property Recipe $recipe
 */
class History extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'history';
    }

    /**
     * @return self|\yii\db\ActiveRecord|null
     */
    public static function findOpen() {
        return self::find()->where(['finished' => null])->one();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['recipe_id', 'started', 'finished'], 'integer'],
            [['recipe_id'], 'exist', 'skipOnError' => true, 'targetClass' => Recipe::className(), 'targetAttribute' => ['recipe_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'recipe_id' => 'Рецепт',
            'started' => 'Начата',
            'finished' => 'Завершена',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['started'],
                ],
            ]
        ];
    }

    public function complete() {
        $this->finished = time();
        return $this;
    }

    /**
     * Gets query for [[Recipe]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecipe()
    {
        return $this->hasOne(Recipe::className(), ['id' => 'recipe_id']);
    }
}
