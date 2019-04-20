<?php

namespace app\models;

/**
 * This is the model class for table "{{%pages}}".
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property string $content
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property int $is_active
 */
class Pages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%pages}}';
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\SluggableBehavior::className(),
                'attribute' => 'name',
                'immutable' => true
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'content'], 'required'],
            [['content', 'description'], 'string'],
            [['is_active'], 'integer'],
            [['name', 'slug', 'title', 'keywords'], 'string', 'max' => 255]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'slug' => 'Алиас',
            'content' => 'Контент',
            'title' => 'Title',
            'keywords' => 'Keywords',
            'description' => 'Description',
            'is_active' => 'Активно'
        ];
    }
}