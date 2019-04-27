<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "modifications".
 *
 * @property int $id
 * @property int $catalog_id
 * @property string $name
 * @property string $image
 * @property int $is_active
 *
 * @property Catalog $catalog
 * @property Specifications[] $specifications
 */
class Modifications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'modifications';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['catalog_id', 'name'], 'required'],
            [['catalog_id', 'is_active'], 'integer'],
            [['image'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['catalog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Catalog::className(), 'targetAttribute' => ['catalog_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'catalog_id' => 'Каталог',
            'name' => 'Название',
            'image' => 'Изображение',
            'is_active' => 'Активно'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalog()
    {
        return $this->hasOne(Catalog::className(), ['id' => 'catalog_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecifications()
    {
        return $this->hasMany(Specifications::className(), ['modification_id' => 'id'])->select(['id', 'capacity', 'power', 'transmission', 'engine', 'drive'])->asArray();
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
}
