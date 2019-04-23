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
 * @property string $issue_year
 * @property int $type
 * @property string $modification
 * @property int $condition 1-С пробегом,2-С повреждениями,3-На запчасти
 * @property double $price
 * @property int $currency 1-RUR,2-USD
 * @property string $text
 * @property int $engine_type
 * @property int $mileage
 * @property int $transmission
 * @property int $drive_type
 * @property int $color
 * @property string $image
 * @property int $city
 * @property string $seller_name
 * @property string $phones
 * @property int $is_active
 * @property int $created_at
 * @property int $updated_at
 */
class Ads extends \yii\db\ActiveRecord
{
    const CURRENCY_BYN = 1;
    const CURRENCY_USD = 2;
    
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
            [['catalog_id', 'issue_year', 'type', 'price', 'text', 'engine_type', 'mileage', 'transmission', 'color'], 'required'],
            [['catalog_id', 'type', 'condition', 'currency', 'engine_type', 'mileage', 'transmission', 'drive_type', 'color', 'city', 'is_active', 'created_at', 'updated_at'], 'integer'],
            [['price'], 'number'],
            [['text', 'image'], 'string'],
            [['issue_year'], 'string', 'max' => 4],
            [['modification', 'seller_name', 'phones'], 'string', 'max' => 255]
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
            'issue_year' => 'Год выпуска',
            'type' => 'Тип кузова',
            'modification' => 'Модефикация',
            'condition' => 'Состояние',
            'price' => 'Цена',
            'currency' => 'Валюта',
            'text' => 'Текст',
            'engine_type' => 'Тип двигателя',
            'mileage' => 'Пробег',
            'transmission' => 'Трансмисия',
            'drive_type' => 'Тип привода',
            'color' => 'Цвет',
            'image' => 'Изображение',
            'region' => 'Область',
            'city' => 'Город',
            'seller_name' => 'Имя продавца',
            'phones' => 'Телефоны',
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
     * Возвращает список валют или название валюты
     * 
     * @param integer $key ключ в массиве названий
     * @return mixed
     */
    public static function getСurrency($key = null)
    {
        $currency = [self::CURRENCY_BYN => 'BYN', self::CURRENCY_USD => 'USD'];
        return is_null($key) ? $currency : $currency[$key];
    }
}