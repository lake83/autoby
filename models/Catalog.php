<?php

namespace app\models;

use Yii;
use creocoder\nestedsets\NestedSetsBehavior;
use app\components\CatalogQuery;
use yii\behaviors\SluggableBehavior;
use yii\caching\TagDependency;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%catalog}}".
 *
 * @property integer $id
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property string $name
 * @property string $slug
 * @property string $image
 * @property string $year_from
 * @property string $year_to
 * @property integer $is_active
 */
class Catalog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%catalog}}';
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className()
            ],
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'immutable' => true
            ]
        ];
    }
    
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function find()
    {
        return new CatalogQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            [['lft', 'is_active', 'rgt', 'depth'], 'integer'],
            ['image', 'string', 'max' => 100],
            [['year_from', 'year_to'], 'string', 'max' => 4],
            [['name', 'slug'], 'string', 'max' => 255]
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
            'slug' => 'Алиас',
            'image' => 'Изображение',
            'year_from' => 'Год начала выпуска',
            'year_to' => 'Год окончания выпуска',
            'is_active' => 'Активно'
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        TagDependency::invalidate(Yii::$app->cache, 'catalog');
        
        return parent::afterSave($insert, $changedAttributes);
    }
    
    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        TagDependency::invalidate(Yii::$app->cache, 'catalog');
        
        parent::afterDelete();
    }
    
    /**
     * Возвращает список категорий
     * 
     * @return array
     */
    public static function getAll()
    {
        $db = Yii::$app->db;
        return $db->cache(function ($db) {
            return ArrayHelper::map(self::find()->select(['id', 'name', 'depth'])->where(['is_active' => 1])->andWhere('depth>0')->orderBy('lft ASC')->asArray()->all(),
                'id', function($model) {
                          return ($model['depth'] > 1 ? str_repeat('---', $model['depth'] - 1) : '') . $model['name'];
                      }
                );
        }, 0, new TagDependency(['tags' => 'catalog']));
    }
    
    /**
     * Возвращает список марок автомобилей
     * 
     * @return array
     */
    public static function getBrands()
    {
        $db = Yii::$app->db;
        return $db->cache(function ($db) {
            return ArrayHelper::map(self::find()->select(['id', 'name'])->where(['is_active' => 1, 'depth' => 1])->orderBy('lft ASC')->asArray()->all(), 'id', 'name');
        }, 0, new TagDependency(['tags' => 'catalog']));
    }
    
    /**
     * Возвращает ID следующего в БД элемента первого уровня
     * 
     * @return integer
     */
    public function getNext()
    {
        return $this->find()->select(['id'])->where(['>', 'id', $this->id])->orderBy('id asc')->andWhere(['depth' => 1])->scalar();
    }

    /**
     * Возвращает ID предыдущего в БД элемента первого уровня
     * 
     * @return integer
     */
    public function getPrev()
    {
        return $this->find()->select(['id'])->where(['<', 'id', $this->id])->orderBy('id desc')->andWhere(['depth' => 1])->scalar();
    }
}