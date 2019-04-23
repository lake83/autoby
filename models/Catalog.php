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
 * @property string $year_from
 * @property string $year_to
 * @property integer $popular
 * @property integer $is_active
 */
class Catalog extends \yii\db\ActiveRecord
{
    public $image;
    
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
            [['lft', 'is_active', 'rgt', 'depth', 'popular'], 'integer'],
            [['year_from', 'year_to'], 'string', 'max' => 4],
            [['name', 'slug', 'image'], 'string', 'max' => 255]
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
            'year_from' => 'Год начала выпуска',
            'year_to' => 'Год окончания выпуска',
            'image' => 'Логотип',
            'popular' => 'Популярная',
            'is_active' => 'Активно'
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        TagDependency::invalidate(Yii::$app->cache, 'catalog');
        
        if (!empty($this->image)) {
            if ($this->logo !== null && $this->logo->image !== $this->image) {
                $this->logo->image = $this->image;
                $this->logo->save();                
            } else {
                $model = new CatalogLogo;
                $model->catalog_id = $this->id;                
                $model->image = $this->image;
                $model->save();                
            }
        }
        return parent::afterSave($insert, $changedAttributes);
    }
    
    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        if ($this->depth == 1 && $this->logo !== null) {
            $this->image = $this->logo->image;
        }
        parent::afterFind();
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
        return Yii::$app->cache->getOrSet('catalog_all', function(){
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
        return Yii::$app->cache->getOrSet('catalog_brands', function(){
            $data = ArrayHelper::map(self::find()->select(['id', 'name', 'popular'])->where(['is_active' => 1, 'depth' => 1])->orderBy('lft ASC')->asArray()->all(), 'id', 'name', 'popular');
            return ['Популярные' => $data[1], 'Все' => $data[0]];
        }, 0, new TagDependency(['tags' => 'catalog']));
    }
    
    /**
     * Возвращает список марок с количеством объявлений
     * 
     * @return array
     */
    public static function getAdsCount()
    {
        return Yii::$app->cache->getOrSet('ads_count', function(){
            $result = [];
            $cars = self::getBrands();
            foreach ($cars['Популярные'] + $cars['Все'] as $id => $name) {
                $result[$id] = self::getCountAds($id, 3);
            }
            return $result;
        }, 0, new TagDependency(['tags' => ['ads', 'catalog']]));
    }
    
    /**
     * Подсчет количества объявлений
     * 
     * @param  integer $id
     * @param  integer $depth
     * @return integer
     */
    public static function getCountAds($id, $depth)
    {
        return Ads::find()->where(['catalog_id' => self::findOne($id)->children($depth)->select(['id'])->andWhere(['is_active' => 1])->column(), 'is_active' => 1])->count();
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
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogo()
    {
        return $this->hasOne(CatalogLogo::className(), ['catalog_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModifications()
    {
        return $this->hasMany(Modifications::className(), ['catalog_id' => 'id']);
    }
}