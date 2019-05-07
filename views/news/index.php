<?php

use yii\widgets\Pjax;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<div class="content col-xs-12">

    <?= \app\components\TopWidget::widget() ?>
            
    <div class="container">
        <div class="row">
            <div class="main-content col-xs-12 col-md-9">
                      
                <section class="blog col-xs-12">
                    <h1 class="title col-xs-12">Новости</h1>
                            
                    <?php Pjax::begin();
                    
                    echo ListView::widget([
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