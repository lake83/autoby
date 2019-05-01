<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * BuyCarForm is the model behind the contact form.
 */
class BuyCarForm extends Model
{
    public $brand;
    public $auto_model;
    public $price;
    public $issue_year;
    public $phone;
    public $info;
    
    public function formName()
    {
        return '';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['brand', 'auto_model', 'price', 'issue_year', 'phone'], 'required'],
            ['info', 'safe']
        ];
    }
    
    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'brand' => 'Марка',
            'auto_model' => 'Модель',
            'price' => 'Цена',
            'issue_year' => 'Год выпуска',
            'phone' => 'Телефон',
            'info' => 'Дополнительная информация'
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function offer($email)
    {
        if ($this->validate()) {
            $this->brand = Catalog::find()->select(['name'])->where(['id' => $this->brand])->scalar();
            $this->auto_model = Catalog::find()->select(['name'])->where(['id' => $this->auto_model])->scalar();
            
            Yii::$app->mailer->compose(['html' => 'buyCar-html'], ['model' => $this])
                ->setFrom(['noreply@autoby.by' => Yii::$app->name])
                ->setTo($email)
                ->setSubject('Заявка на выкуп автомобиля на ' . Yii::$app->name)
                ->send();

            return true;
        }
        return false;
    }
}