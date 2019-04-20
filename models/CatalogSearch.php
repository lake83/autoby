<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Catalog;

/**
 * CatalogSearch represents the model behind the search form about `app\models\Catalog`.
 */
class CatalogSearch extends Catalog
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'lft', 'rgt', 'depth', 'is_active', 'popular'], 'integer'],
            [['name', 'slug', 'year_from', 'year_to'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        if (isset($params['brand'])) {
            $brand = Catalog::findOne(['slug' => $params['brand']]);
            $query = $brand->children();
        } else {
            $query = Catalog::find();
            if (Catalog::find()->count() > 1) {
                $query->where(['depth' => 1])->andWhere(['!=', 'slug', 'catalog'])->orderBy('lft ASC')->indexBy('id');
            }
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => isset($params['brand']) ? false : ['pageSize' => 20]
        ]);
        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'lft' => $this->lft,
            'rgt' => $this->rgt,
            'depth' => $this->depth,
            'popular' => $this->popular,
            'is_active' => $this->is_active
        ]);
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'year_from', $this->year_from])
            ->andFilterWhere(['like', 'year_to', $this->year_to]);

        return $dataProvider;
    }
}