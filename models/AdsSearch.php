<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ads;
use app\models\Catalog;

/**
 * AdsSearch represents the model behind the search form of `app\models\Ads`.
 */
class AdsSearch extends Ads
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'catalog_id', 'user_id', 'type', 'condition', 'engine_type', 'doors', 'mileage', 'transmission', 'drive_type', 'color', 'city_id', 'is_active'], 'integer'],
            [['created_at', 'updated_at'], 'date', 'format' => 'd.m.Y'],
            [['issue_year', 'modification', 'text', 'image'], 'safe'],
            [['capacity', 'price'], 'number']
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Ads::find();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'capacity' => $this->capacity,
            'type' => $this->type,
            'condition' => $this->condition,
            'price' => $this->price,
            'engine_type' => $this->engine_type,
            'mileage' => $this->mileage,
            'transmission' => $this->transmission,
            'drive_type' => $this->drive_type,
            'doors' => $this->doors,
            'color' => $this->color,
            'city_id' => $this->city_id,
            'is_active' => $this->is_active,
            'FROM_UNIXTIME(created_at, "%d.%m.%Y")' => $this->created_at,
            'FROM_UNIXTIME(updated_at, "%d.%m.%Y")' => $this->updated_at
        ]);
        
        if (!empty($this->catalog_id)) {
            $brand = Catalog::findOne($this->catalog_id);
            $query->andFilterWhere(['catalog_id' => $brand->children()->andWhere(['depth' => 3])->select(['id'])->column()]);     
        }
        $query->andFilterWhere(['like', 'modification', $this->modification])
            ->andFilterWhere(['like', 'issue_year', $this->issue_year])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'image', $this->image]);

        return $dataProvider;
    }
}