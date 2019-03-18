<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%specification_options}}".
 *
 * @property int $id
 * @property int $specification_id
 * @property string $name
 * @property int $is_active
 *
 * @property Specifications $specification
 */
class SpecificationOptions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%specification_options}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['specification_id', 'is_active'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['specification_id'], 'exist', 'skipOnError' => true, 'targetClass' => Specifications::className(), 'targetAttribute' => ['specification_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'specification_id' => 'Характеристика',
            'name' => 'Название',
            'is_active' => 'Активно',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecification()
    {
        return $this->hasOne(Specifications::className(), ['id' => 'specification_id']);
    }
}
