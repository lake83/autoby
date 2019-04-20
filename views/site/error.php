<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="content col-xs-12">
    <?= \app\components\TopWidget::widget() ?>
            
    <div class="container">
        <div class="row">
            <div class="main-content col-xs-12 col-md-9">
                <h1><?= Html::encode($this->title) ?></h1>

                <div class="alert alert-danger">
                    <?= nl2br(Html::encode($message)) ?>
                </div>

                <p>Вышеуказанная ошибка произошла, когда веб-сервер обрабатывал ваш запрос.</p>
                <p>Пожалуйста, свяжитесь с нами, если считаете, что это ошибка сервера. Спасибо.</p>
                
            </div>
            <?= \app\components\AsideWidget::widget() ?>
        </div>
    </div>
</div>