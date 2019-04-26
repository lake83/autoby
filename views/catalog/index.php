<?php

/* @var $this yii\web\View */

?>
<div class="content col-xs-12">
    <?= \app\components\TopWidget::widget() ?>
            
    <div class="container">
        <div class="row">
            <div class="main-content col-xs-12 col-md-9">
            
            <?= \app\components\FilterWidget::widget(['catalog' => true]) ?>
            
            </div>
            
            <?= \app\components\AsideWidget::widget() ?>
        
        </div>
    </div>
</div>