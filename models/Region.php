<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\caching\TagDependency;

/**
 * This is the model class for table "{{%region}}".
 *
 * @property int $id
 * @property string $name
 * @property int $is_active
 *
 * @property City[] $cities
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%region}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['is_active'], 'integer'],
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
            'is_active' => 'Активно'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this->hasMany(City::className(), ['region_id' => 'id'])->andWhere(['is_active' => 1]);
    }
    
    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        TagDependency::invalidate(Yii::$app->cache, 'region');
        
        return parent::afterSave($insert, $changedAttributes);
    }
    
    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        TagDependency::invalidate(Yii::$app->cache, 'region');
        
        parent::afterDelete();
    }
    
    /**
     * Возвращает список областей
     * 
     * @return array
     */
    public static function getAll()
    {
        return Yii::$app->cache->getOrSet('regions', function () {
            return ArrayHelper::map(self::find()->select('id,name')->where(['is_active' => 1])->asArray()->all(), 'id', 'name');
        }, 0, new TagDependency(['tags' => 'region']));
    }
    
    /**
     * Возвращает список областей с городами
     * 
     * @return array
     */
    public static function getAllWithCities()
    {
        return Yii::$app->cache->getOrSet('regions_cities', function () {
            return ArrayHelper::map(self::find()->select('id,name')->where(['is_active' => 1])->all(), 'name', function($model) {
                return ArrayHelper::map($model->cities, 'id', 'name');
            });
        }, 0, new TagDependency(['tags' => 'region']));
    }
}