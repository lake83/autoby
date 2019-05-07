<?php

use yii\widgets\Pjax;
use yii\widgets\ListView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="content col-xs-12">            
    <div class="container">
        <div class="row">
            <div class="cabinet col-xs-12">
                <nav class="cabinet-menu col-sm-3 col-lg-2 hidden-xs">
                    <div class="menu-item col-xs-12">
                        <a href="" class="active transition col-xs-12">Мои объявления <?= $dataProvider->getTotalCount() ?></a>
                    </div>
                    <div class="menu-item active col-xs-12">
                        <a href="<?= Url::to(['site/logout']) ?>" class="transition col-xs-12" data-method="post">Выход</a>
                    </div>
                </nav>
                        
                <div class="cabinet-content col-xs-12 col-sm-9 col-lg-10">
                    <span class="title col-xs-12">Мои объявления</span>
                            
                    <ul class="nav nav-tabs col-xs-12" role="tablist">
                        <li class="nav-item active text-center">
                            <a class="nav-link transition" id="cars-tab" data-toggle="tab" href="#cars" role="tab" aria-controls="cars" aria-selected="true">
                                Автомобили
                            </a>
                        </li>
                        <li class="nav-item text-center">
                            <a class="nav-link transition" id="spares-tab" data-toggle="tab" href="#spares" role="tab" aria-controls="spares" aria-selected="false">
                                Запчасти
                            </a>
                        </li>
                    </ul>
                            
                    <div class="tab-content col-xs-12">
                        <div role="tabpanel" class="tab-pane fade in active col-xs-12" id="cars">
                            <ul class="my-ads-list col-xs-12">
                                
                                <?php Pjax::begin();
                                
                                echo ListView::widget([
                                    'dataProvider' => $dataProvider,
                                    'layout' => "{items}\n{pager}",
                                    'itemView' => '_my_ads_item'
                                ]);
                                Pjax::end(); ?>
                                
                            </ul>
                        </div>
                                
                        <div role="tabpanel" class="tab-pane fade col-xs-12" id="spares">
                           <p style="margin-top: 30px;">Находится в разработке.</p>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>