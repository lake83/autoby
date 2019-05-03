<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\components\SiteHelper;

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
            ['phone', 'match', 'pattern' => '/^\+37 \(\d{3}\) \d{3}\-\d{2}\-\d{2}$/'],
            ['sms', 'integer'],
            ['sms', 'string', 'max' => 4],
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
            
            if (!$user || !($user->sms == $this->sms)) {
                $this->addError($attribute, 'Не верный код SMS.');
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
                $this->_user->scenario = 'sms';
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
        $params = Yii::$app->params;
        $url = 'http://cp.websms.by/?' . http_build_query([
           'r' => 'api/msg_send',
           'user' => $params['api_login'],
           'apikey' => $params['api_key'],
           'recipients' => preg_replace('/[^0-9+]/', '', $phone),
           'message' => 'Код для входа на сайте "' . Yii::$app->name . '": ' . $sms,
           'sender' => 'autoby.by'
        ]);
        
        if ($content = SiteHelper::sendCurl($url)) {
            $content = json_decode($content, true);
            if ($content['status'] !== 'success') {
                return false;
            }
            if ($user = User::findByPhone($phone)){
                $user->scenario = 'sms';
                $user->sms = $sms;
            } else {
                $user = new User(['scenario' => 'sms']);
                $user->phone = $phone;
                $user->sms = $sms;
                $user->is_active = 0;
            }
            if ($user->save()) {
                return true;
            }
        }
        return false;
    }
}
