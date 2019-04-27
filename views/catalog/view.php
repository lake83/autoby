<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Modifications */
/* @var $specification app\models\Specifications */

$request = Yii::$app->request;
?>
<div class="content col-xs-12">
    <?= \app\components\TopWidget::widget() ?>
            
    <div class="container">
        <div class="row">
            <div class="main-content col-xs-12 col-md-9">
            
                <section class="breadcrumbs col-xs-12">
                    <ul class="breadcrumbs-list col-xs-12">
                        <li class="list-item">
                            <a href="<?= Url::to(['catalog/index', 'brand' => $request->get('brand')]) ?>" class="transition">Марка</a>
                        </li>
                        <li class="list-item">
                            <a href="<?= Url::to(['catalog/index', 'brand' => $request->get('brand'), 'auto_model' => $request->get('auto_model')]) ?>" class="transition">Модель</a>
                        </li>
                        <li class="list-item">
                            <a href="<?= Url::to(['catalog/index', 'brand' => $request->get('brand'), 'auto_model' => $request->get('auto_model'), 'generation' => $request->get('generation')]) ?>" class="transition">Поколение</a>
                        </li>
                        <li class="list-item">
                            <span>Тип кузова</span>
                        </li>
                    </ul>
                </section>
                        
                <section class="catalog col-xs-12">
                            
                    <div class="engine-types col-xs-12 col-sm-4">
                                
                        <?php foreach ($model as $key => $items): ?>
                        
                        <div class="engine-type col-xs-12">
                            <span class="title col-xs-12"><?= $key ?></span>
                        
                            <ul class="engine-list col-xs-12">
                        
                                <?php foreach ($items as $item): ?>
                            
                                <li class="list-item col-xs-12">
                                    <span class="name"><a href="<?= $item['id'] ?>"><?= $item['capacity'] ?></a></span>
                                    <span class="power"><?= $item['power'] ?> л.c. <?= $item['drive'] ?></span>
                                    <span class="type"><?= $item['transmission'] ?></span>
                                </li>
                            
                                <?php endforeach ?>
                        
                            </ul>
                        </div>
                        
                        <?php endforeach ?>       
                                
                    </div>
                    
                    <div id="specification" class="col-xs-12 col-sm-8">
                    
                    <?= $this->render('_specification', ['model' => $specification]) ?>
                    
                    </div>
                            
                </section>
            
            </div>
                    
            <?= \app\components\AsideWidget::widget() ?>
                    
        </div>
    </div>
</div>