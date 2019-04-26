<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\caching\TagDependency;

/**
 * This is the model class for table "{{%ads}}".
 *
 * @property int $id
 * @property int $catalog_id
 * @property int $user_id
 * @property string $issue_year
 * @property double $capacity
 * @property int $type
 * @property string $modification
 * @property int $condition 1-С пробегом,2-С повреждениями,3-На запчасти
 * @property double $price
 * @property string $text
 * @property int $engine_type
 * @property int $mileage
 * @property int $transmission
 * @property int $drive_type
 * @property int $doors
 * @property int $color
 * @property string $image
 * @property int $city_id
 * @property int $is_active
 * @property int $created_at
 * @property int $updated_at
 */
class Ads extends \yii\db\ActiveRecord
{
    public $brand;
    public $auto_model;
    public $region;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%ads}}';
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['catalog_id', 'user_id', 'issue_year', 'capacity', 'type', 'price', 'text', 'engine_type', 'mileage', 'transmission', 'color', 'drive_type', 'doors', 'city_id'], 'required'],
            [['catalog_id', 'type', 'condition', 'engine_type', 'mileage', 'transmission', 'drive_type', 'doors', 'color', 'city_id', 'is_active', 'created_at', 'updated_at'], 'integer'],
            [['capacity', 'price'], 'number'],
            [['text', 'image'], 'string'],
            [['issue_year'], 'string', 'max' => 4],
            [['doors'], 'string', 'max' => 1],
            [['modification'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => false, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brand' => 'Марка автомобиля',
            'auto_model' => 'Модель',
            'catalog_id' => 'Автомобиль',
            'user_id' => 'Пользователь',
            'issue_year' => 'Год выпуска',
            'capacity' => 'Объем, л',
            'type' => 'Тип кузова',
            'modification' => 'Модефикация',
            'condition' => 'Состояние',
            'price' => 'Цена, USD',
            'text' => 'Текст',
            'engine_type' => 'Тип двигателя',
            'mileage' => 'Пробег',
            'transmission' => 'Трансмисия',
            'drive_type' => 'Тип привода',
            'doors' => 'Количество дверей',
            'color' => 'Цвет',
            'image' => 'Изображение',
            'region' => 'Область',
            'city_id' => 'Город',
            'is_active' => 'Активно',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен'
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        $this->image = trim(str_replace(',,', ',', $this->image), ',');
        
        return parent::beforeSave($insert);
    }
    
    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        if (strpos($this->image, ',')) {
            $this->image = explode(',', $this->image);
        } elseif (!empty($this->image)) {
            $this->image = [$this->image];
        }
        parent::afterFind();
    }
    
    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        TagDependency::invalidate(Yii::$app->cache, 'ads');
        
        parent::afterDelete();
    }
    
    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        TagDependency::invalidate(Yii::$app->cache, 'ads');
        
        return parent::afterSave($insert, $changedAttributes);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCar()
    {
        return $this->hasOne(Catalog::className(), ['id' => 'catalog_id']);
    }
    
    /**
     * Возвращает спецификацию автомобиля
     * 
     * @return string
     */
    public function getCarTitle()
    {
        $model = $this->car;
        
        return ucwords($model->parents(2)->select(['name'])->one()->name . ' ' . $model->parents(1)->select(['name'])->one()->name . ' ' . $model->name);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }
}