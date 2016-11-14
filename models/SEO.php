<?php

namespace app\modules\SEO\models;

use Yii;

class SEO extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SEO';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['route','title', 'keywords', 'description', 'url'], 'string', 'max' => 255],
            [['itemId'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'keywords' => Yii::t('app', 'Keywords'),
            'description' => Yii::t('app', 'Desription'),
            'url' => Yii::t('app', 'Url'),
        ];
    }
}
