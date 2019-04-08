<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "specifications".
 *
 * @property int $id
 * @property int $modification_id
 * @property double $capacity
 * @property int $power
 * @property string $transmission
 * @property string $engine
 * @property string $fuel
 * @property string $drive
 * @property double $racing
 * @property double $consumption
 * @property string $country
 * @property string $class
 * @property int $doors
 * @property string $seats
 * @property int $length
 * @property int $width
 * @property int $height
 * @property int $wheelbase
 * @property int $clearance
 * @property int $front_track
 * @property int $rear_track
 * @property string $wheel_size
 * @property int $luggage_capacity
 * @property int $tank_capacity
 * @property int $curb_weight
 * @property int $full_weight
 * @property int $gears
 * @property string $front_suspension
 * @property string $rear_suspension
 * @property string $front_brakes
 * @property string $rear_brakes
 * @property int $max_speed
 * @property string $consumption_all
 * @property string $environmental_class
 * @property int $emissions
 * @property string $engine_location
 * @property int $engine_capacity
 * @property string $boost_type
 * @property string $max_power
 * @property string $max_torque
 * @property string $cylinder_location
 * @property int $cylinders_number
 * @property int $cylinder_valves
 * @property string $power_system
 * @property double $compression
 * @property string $bore_stroke
 * @property int $is_active
 *
 * @property Modifications $modification
 */
class Specifications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'specifications';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['modification_id', 'capacity', 'power'], 'required'],
            [['modification_id', 'power', 'doors', 'length', 'width', 'height', 'wheelbase', 'clearance', 'front_track', 'rear_track', 'luggage_capacity', 'tank_capacity', 'curb_weight', 'full_weight', 'gears', 'max_speed', 'emissions', 'engine_capacity', 'cylinders_number', 'cylinder_valves', 'is_active'], 'integer'],
            [['capacity', 'racing', 'consumption', 'compression'], 'number'],
            [['power', 'doors', 'length', 'width', 'height', 'wheelbase', 'clearance', 'front_track', 'rear_track', 'luggage_capacity', 'tank_capacity', 'curb_weight', 'full_weight', 'gears', 'max_speed', 'emissions', 'engine_capacity', 'cylinders_number', 'cylinder_valves', 'capacity', 'racing', 'consumption', 'compression'], 'default', 'value' => 0],
            [['transmission', 'engine', 'fuel', 'drive', 'country', 'wheel_size', 'front_suspension', 'rear_suspension', 'front_brakes', 'rear_brakes', 'engine_location', 'boost_type', 'max_power', 'max_torque', 'cylinder_location', 'power_system', 'bore_stroke'], 'string', 'max' => 255],
            [['class'], 'string', 'max' => 1],
            [['seats'], 'string', 'max' => 2],
            [['consumption_all', 'environmental_class'], 'string', 'max' => 20],
            [['modification_id'], 'exist', 'skipOnError' => true, 'targetClass' => Modifications::className(), 'targetAttribute' => ['modification_id' => 'id']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'modification_id' => 'Модификация',
            'capacity' => 'Объем',
            'power' => 'Мощность',
            'transmission' => 'Коробка',
            'engine' => 'Тип двигателя',
            'fuel' => 'Топливо',
            'drive' => 'Привод',
            'racing' => 'Разгон',
            'consumption' => 'Расход топлива',
            'country' => 'Страна марки',
            'class' => 'Класс автомобиля',
            'doors' => 'Количество дверей',
            'seats' => 'Количество мест',
            'length' => 'Длина',
            'width' => 'Ширина',
            'height' => 'Высота',
            'wheelbase' => 'Колёсная база',
            'clearance' => 'Клиренс',
            'front_track' => 'Ширина передней колеи',
            'rear_track' => 'Ширина задней колеи',
            'wheel_size' => 'Размер колёс',
            'luggage_capacity' => 'Объем багажника, л',
            'tank_capacity' => 'Объём топливного бака, л',
            'curb_weight' => 'Снаряженная масса, кг',
            'full_weight' => 'Полная масса, кг',
            'gears' => 'Количество передач',
            'front_suspension' => 'Тип передней подвески',
            'rear_suspension' => 'Тип задней подвески',
            'front_brakes' => 'Передние тормоза',
            'rear_brakes' => 'Задние тормоза',
            'max_speed' => 'Максимальная скорость, км/ч',
            'consumption_all' => 'Расход топлива, л город/трасса/смешанный',
            'environmental_class' => 'Экологический класс',
            'emissions' => 'Выбросы CO2, г/км',
            'engine_location' => 'Расположение двигателя',
            'engine_capacity' => 'Объем двигателя, см³',
            'boost_type' => 'Тип наддува',
            'max_power' => 'Максимальная мощность, л.с./кВт при об/мин',
            'max_torque' => 'Максимальный крутящий момент, Н*м при об/мин',
            'cylinder_location' => 'Расположение цилиндров',
            'cylinders_number' => 'Количество цилиндров',
            'cylinder_valves' => 'Число клапанов на цилиндр',
            'power_system' => 'Система питания двигателя',
            'compression' => 'Степень сжатия',
            'bore_stroke' => 'Диаметр цилиндра и ход поршня, мм',
            'is_active' => 'Активно'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModification()
    {
        return $this->hasOne(Modifications::className(), ['id' => 'modification_id']);
    }
}
