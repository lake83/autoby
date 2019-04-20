<?php

use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<div class="content col-xs-12">

    <?= \app\components\TopWidget::widget() ?>
            
    <div class="container">
        <div class="row">
            <div class="main-content col-xs-12 col-md-9">
                      
                <section class="blog col-xs-12">
                    <span class="title col-xs-12">Новости</span>
                            
                    <?php Pjax::begin();
                    
                    echo \yii\widgets\ListView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "{items}\n{pager}",
                        'itemView' => '_list_item'
                    ]);
                    Pjax::end(); ?>

                </section>
                        
            </div>
                    
            <?= \app\components\AsideWidget::widget() ?>
            
        </div>
    </div>
</div>