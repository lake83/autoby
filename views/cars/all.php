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
                                'data' => ['created_at-desc' => 'По актуальности', 'price-asc' => 'По дешевле', 'price-desc' => 'По дороже', 'issue_year-asc' => 'По старее', 'issue_year-desc' => 'По новее'],
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
                            <li class="sort-item transition<?= $sort == 'created_at-desc' || $sort == null ? ' active' : '' ?>"><a href="created_at-desc">актуальности</a></li>
                            <li class="sort-item transition<?= $sort == 'price-asc' ? ' active' : '' ?>"><a href="price-asc">дешевле</a></li>
                            <li class="sort-item transition<?= $sort == 'price-desc' ? ' active' : '' ?>"><a href="price-desc">дороже</a></li>
                            <li class="sort-item transition<?= $sort == 'issue_year-asc' ? ' active' : '' ?>"><a href="issue_year-asc">старее</a></li>
                            <li class="sort-item transition<?= $sort == 'issue_year-desc' ? ' active' : '' ?>"><a href="issue_year-desc">новее</a></li>
                        </ul>
                    </div>
                    
                    <div class="clearfix" style="margin-bottom: 15px;"></div>
                    
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