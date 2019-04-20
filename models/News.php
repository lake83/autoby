<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "{{%news}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $image
 * @property string $intro_text
 * @property string $full_text
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property integer $is_active
 * @property integer $created_at
 * @property integer $updated_at
 */
class News extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news}}';
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'immutable' => true
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'full_text'], 'required'],
            [['intro_text', 'full_text', 'description'], 'string'],
            [['is_active', 'updated_at'], 'integer'],
            ['image', 'string', 'max' => 100],
            [['name', 'slug', 'title', 'keywords'], 'string', 'max' => 255],
            ['created_at', 'date', 'format' => 'php:d.m.Y', 'timestampAttribute' => 'created_at'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'parent_id' => 'Родитель',
            'slug' => 'Алиас',
            'region' => 'Регион',
            'image' => 'Изображение',
            'intro_text' => 'Короткий текст',
            'full_text' => 'Полный текст',
            'title' => 'Title',
            'keywords' => 'Keywords',
            'description' => 'Description',
            'type' => 'Тип',
            'in_slider' => 'Показовать в слайдере "Нам доверяют"',
            'not_show_region' => 'Не выводить для региона',
            'is_active' => 'Активно',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен'
        ];
    }
}