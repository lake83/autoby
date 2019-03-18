<?php

namespace app\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%catalog_specification}}".
 *
 * @property int $id
 * @property int $specification_id
 * @property string $value
 *
 * @property Specifications $specification
 */
class CatalogSpecification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%catalog_specification}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['specification_id', 'value'], 'required'],
            [['specification_id'], 'integer'],
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
            'value' => 'Значение',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecification()
    {
        return $this->hasOne(Specifications::className(), ['id' => 'specification_id']);
    }
    
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (is_array($this->value)) {
            $this->value = Json::encode($this->value);
        }
        return parent::beforeSave($insert);
    }
    
    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        if (!empty($this->value)) {
            $this->value = Json::decode($this->value);
        }
        return parent::afterFind();
    }
}
