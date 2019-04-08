<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Specifications;

/**
 * SpecificationsSearch represents the model behind the search form of `app\models\Specifications`.
 */
class SpecificationsSearch extends Specifications
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'modification_id', 'power', 'doors', 'length', 'width', 'height', 'wheelbase', 'clearance', 'front_track', 'rear_track', 'luggage_capacity', 'tank_capacity', 'curb_weight', 'full_weight', 'gears', 'max_speed', 'emissions', 'engine_capacity', 'cylinders_number', 'cylinder_valves', 'is_active'], 'integer'],
            [['capacity', 'racing', 'consumption', 'compression'], 'number'],
            [['transmission', 'engine', 'fuel', 'drive', 'country', 'class', 'seats', 'wheel_size', 'front_suspension', 'rear_suspension', 'front_brakes', 'rear_brakes', 'consumption_all', 'environmental_class', 'engine_location', 'boost_type', 'max_power', 'max_torque', 'cylinder_location', 'power_system', 'bore_stroke'], 'safe'],
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
        $query = Specifications::find()->where(['modification_id' => $params['modification_id']]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'modification_id' => $this->modification_id,
            'capacity' => $this->capacity,
            'power' => $this->power,
            'racing' => $this->racing,
            'consumption' => $this->consumption,
            'doors' => $this->doors,
            'length' => $this->length,
            'width' => $this->width,
            'height' => $this->height,
            'wheelbase' => $this->wheelbase,
            'clearance' => $this->clearance,
            'front_track' => $this->front_track,
            'rear_track' => $this->rear_track,
            'luggage_capacity' => $this->luggage_capacity,
            'tank_capacity' => $this->tank_capacity,
            'curb_weight' => $this->curb_weight,
            'full_weight' => $this->full_weight,
            'gears' => $this->gears,
            'max_speed' => $this->max_speed,
            'emissions' => $this->emissions,
            'engine_capacity' => $this->engine_capacity,
            'cylinders_number' => $this->cylinders_number,
            'cylinder_valves' => $this->cylinder_valves,
            'compression' => $this->compression,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'transmission', $this->transmission])
            ->andFilterWhere(['like', 'engine', $this->engine])
            ->andFilterWhere(['like', 'fuel', $this->fuel])
            ->andFilterWhere(['like', 'drive', $this->drive])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'class', $this->class])
            ->andFilterWhere(['like', 'seats', $this->seats])
            ->andFilterWhere(['like', 'wheel_size', $this->wheel_size])
            ->andFilterWhere(['like', 'front_suspension', $this->front_suspension])
            ->andFilterWhere(['like', 'rear_suspension', $this->rear_suspension])
            ->andFilterWhere(['like', 'front_brakes', $this->front_brakes])
            ->andFilterWhere(['like', 'rear_brakes', $this->rear_brakes])
            ->andFilterWhere(['like', 'consumption_all', $this->consumption_all])
            ->andFilterWhere(['like', 'environmental_class', $this->environmental_class])
            ->andFilterWhere(['like', 'engine_location', $this->engine_location])
            ->andFilterWhere(['like', 'boost_type', $this->boost_type])
            ->andFilterWhere(['like', 'max_power', $this->max_power])
            ->andFilterWhere(['like', 'max_torque', $this->max_torque])
            ->andFilterWhere(['like', 'cylinder_location', $this->cylinder_location])
            ->andFilterWhere(['like', 'power_system', $this->power_system])
            ->andFilterWhere(['like', 'bore_stroke', $this->bore_stroke]);

        return $dataProvider;
    }
}
