<?php

namespace app\models;

/**
 * FilterForm is the model behind the filter form.
 */
class FilterForm extends \yii\base\Model
{
    public $brand;
    public $auto_model;
    public $generation;
    public $type;
    public $transmission;
    public $engine;
    public $drive;
    public $capacity_from;
    public $capacity_to;
    public $year_from;
    public $year_to;
    public $mileage_from;
    public $mileage_to;
    public $price_from;
    public $price_to;
    public $sort;

    public function formName()
    {
        return '';
    }
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['type', 'transmission', 'engine', 'drive', 'year_from', 'year_to', 'mileage_from', 'mileage_to'], 'integer'],
            [['capacity_from', 'capacity_to', 'price_from', 'price_to'], 'number'],
            [['brand', 'auto_model', 'generation', 'sort'], 'safe']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mileage_from' => 'Пробег',
            'mileage_to' => 'Пробег',
            'price_from' => 'Цена',
            'price_to' => 'Цена'
        ];
    }
}