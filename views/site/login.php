<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\models\LoginForm */

?>

<div class="container text-center">
    <div class="row">
        <div class="login-form">
            <div class="logo">
                 <a href="/">
                     <img src="images/logo.png" alt="">
                 </a>
             </div>
             <span class="title col-xs-12">Вход на сайт</span>
             
             <?php $form = ActiveForm::begin(['id' => 'user-login']) ?>
             
                 <div class="input-wrapper col-xs-12">
                     <?= $form->field($model, 'phone', ['template' => '{input}<input type="submit" class="send" value="Продолжить">{error}'])
                         ->widget(MaskedInput::className(), ['mask' => Yii::$app->params['phone_mask'],
                         'options' => ['placeholder' => 'Введите свой телефон', 'class' => 'phone transition']])->label(false)
                     ?>
                 </div>
                 
                 <div class="sms-block col-xs-12 hide">
                     <span class="text col-xs-12">Вам отправлено смс с кодом подтверждения</span>
                     
                     <div class="input-wrapper col-xs-12">
                         <?= $form->field($model, 'sms')->textInput(['placeholder' => 'Код из смс', 'class' => 'confirm-code transition'])->label(false) ?>
                     </div>
                     
                     <a href="" class="repeat-send-code transition">Отправить код повторно</a>
                 </div>
                 
                 <div class="auth-agreement col-xs-12">Авторизуясь на сайте, я принимаю условия <a class="link transition" href="<?= $href = Url::to(['site/page', 'slug' => 'polzovatelskoe-soglasenie']) ?>" target="_blank">пользовательского соглашения</a> и даю согласие на обработку персональных данных в соответствии с законодательством Белорусии и <a class="link transition" href="<?= $href ?>" target="_blank">пользовательским соглашением</a>.</div>
             
             <?php ActiveForm::end(); ?>
             
        </div>
    </div>
</div>