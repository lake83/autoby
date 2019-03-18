<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%specifications}}".
 *
 * @property int $id
 * @property string $name
 * @property int $is_options
 * @property int $is_active
 *
 * @property SpecificationOptions[] $specificationOptions
 */
class Specifications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%specifications}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['is_options', 'is_active'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'is_options' => 'Опции',
            'is_active' => 'Активно',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecificationOptions()
    {
        return $this->hasMany(SpecificationOptions::className(), ['specification_id' => 'id'])->andOnCondition(['is_active' => 1])->asArray();
    }
}
