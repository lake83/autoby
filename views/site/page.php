<?php

/* @var $this yii\web\View */
/* @var $model app\models\Pages */

$this->title = $model->title;
$this->registerMetaTag(['name' => 'keywords', 'content' => $model->keywords]);
$this->registerMetaTag(['name' => 'description', 'content' => $model->description]);
?>

<div class="content col-xs-12">
    <?= \app\components\TopWidget::widget() ?>
            
    <div class="container">
        <div class="row">
            <div class="main-content col-xs-12 col-md-9">
                
                <?= $model->content ?>
                
            </div>
            <?= \app\components\AsideWidget::widget() ?>
        </div>
    </div>
</div>