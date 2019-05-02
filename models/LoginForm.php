<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 */
class LoginForm extends Model
{
    public $phone;
    public $sms;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['phone', 'required'],
            ['sms', 'validateSms']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'phone' => 'Телефон',
            'sms' => 'SMS'
        ];
    }
    
    /**
     * Validates the SMS.
     * This method serves as the inline validation for SMS.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateSms($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || $user->sms !== $this->sms) {
                $this->addError($attribute, 'Не верный телефон или SMS.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password. 
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate() && Yii::$app->user->login($this->getUser(), 3600*24*30)) {
            if ($this->_user->is_active === 0) {
                $this->_user->is_active = 1;
                $this->_user->save();
            }
            return $this->_user->status;
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByPhone($this->phone);
        }
        return $this->_user;
    }
    
    /**
     * НАхождение или создание пользователя и отправка SMS для авторизации
     *
     * @param array $phone
     * @return boolean
     */
    public function sendSms($phone)
    {
        $sms = rand(1000, 9999);
        if ($user = User::findByPhone($phone)){
            $user->sms = $sms;
        } else {
            $user = new User;
            $user->phone = $phone;
            $user->sms = $sms;
            $user->is_active = 0;
        }
        if ($user->save()) {
            return true;
        }
        return false;
    }
}
