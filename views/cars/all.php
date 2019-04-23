<?php

use kartik\select2\Select2;
use yii\widgets\Pjax;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$sort = Yii::$app->request->get('sort');
?>

<div class="content col-xs-12">
    <?= \app\components\TopWidget::widget() ?>
            
    <div class="container">
        <div class="row">
            <div class="main-content col-xs-12 col-md-9">
                
                <?= \app\components\FilterWidget::widget() ?>
                
                <section class="cars-list col-xs-12">
                    <div class="filters-group hidden-xs">
                        <div class="btn-group col-xs-12">
                            
                            <?= Select2::widget([
                                'id' => 'sort',
                                'name' => 'sort',
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'data' => ['created_at_desc' => 'По актуальности', 'price_asc' => 'По дешевле', 'price_desc' => 'По дороже', 'year_from_asc' => 'По старее', 'year_from_desc' => 'По новее'],
                                'value' => $sort,
                                'hideSearch' => true,
                                'pluginEvents' => [
                                    'select2:select' => "function() {jQuery('input[name=sort]').val($(this).val());$('#ads-filter').submit();}"
                                ]
                            ]) ?>
                            
                        </div>
                    </div>
                            
                    <div class="filters-group visible-xs mob-sort">
                        <span class="text"><b>Сортировать по:</b></span>
                                
                        <ul class="sort-list col-xs-12">
                            <li class="sort-item transition<?= $sort == 'created_at_desc' ? ' active' : '' ?>"><a href="created_at_desc">актуальности</a></li>
                            <li class="sort-item transition<?= $sort == 'price_asc' ? ' active' : '' ?>"><a href="price_asc">дешевле</a></li>
                            <li class="sort-item transition<?= $sort == 'price_desc' ? ' active' : '' ?>"><a href="price_desc">дороже</a></li>
                            <li class="sort-item transition<?= $sort == 'year_from_asc' ? ' active' : '' ?>"><a href="year_from_asc">старее</a></li>
                            <li class="sort-item transition<?= $sort == 'year_from_desc' ? ' active' : '' ?>"><a href="year_from_desc">новее</a></li>
                        </ul>
                    </div>
                    
                    <?php Pjax::begin();
                    
                    echo ListView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "{items}\n{pager}",
                        'itemView' => '_ads_item'
                    ]);
                    Pjax::end(); ?>
                            
                </section>
                
            </div>
            
            <?= \app\components\AsideWidget::widget() ?>
        
        </div>
    </div>
</div>