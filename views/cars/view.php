<?php

use yii\helpers\Html;
use app\components\SiteHelper;
use evgeniyrru\yii2slick\Slick;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Ads */

$params = Yii::$app->params;
?>
<div class="content col-xs-12">
    <div class="top-navigation hidden-xs col-xs-12">
        <div class="container">
            <?= \app\components\TopWidget::widget() ?>
        </div>
    </div>
            
    <div class="container">
        <div class="row">
            <div class="main-content col-xs-12 col-md-9">
                <section class="product col-xs-12">                            
                    <span class="product-title col-xs-12"><?= $model->carTitle ?></span>
                            
                    <div class="complain col-xs-12">
                        <a href="" class="transition">Пожаловаться на объявление</a>
                    </div>
                            
                    <div class="product-info col-xs-12 col-sm-4">
                        <div class="price col-xs-12">
                            <div class="r-price col-xs-12">
                                <span><?= round($model->price * SiteHelper::exchangeRate()) ?> BYN</span>
                            </div>
                            <div class="d-price">
                                <span><?= $model->price ?> $</span>
                            </div>
                        </div>
                                
                        <ul class="specifications col-xs-12">
                            <li class="specification col-xs-12">
                                <span class="text col-xs-6">Год выпуска</span>
                                <span class="value col-xs-6"><?= $model->issue_year ?></span>
                            </li>
                            <li class="specification col-xs-12">
                                <span class="text col-xs-6">Пробег</span>
                                <span class="value col-xs-6"><?= $model->mileage ?> км</span>
                            </li>
                            <li class="specification col-xs-12">
                                <span class="text col-xs-6">Объем</span>
                                <span class="value col-xs-6"><?= $model->capacity * 1000 ?> см<sup>3</sup></span>
                            </li>
                            <li class="specification col-xs-12">
                                <span class="text col-xs-6">Цвет</span>
                                <span class="value col-xs-6"><?= $params['color']['options'][$model->color] ?></span>
                            </li>
                            <li class="specification col-xs-12">
                                <span class="text col-xs-6">Тип кузова</span>
                                <span class="value col-xs-6"><?= $params['car_body_type']['options'][$model->type] ?></span>
                            </li>
                            <li class="specification col-xs-12">
                                <span class="text col-xs-6">Тип топлива</span>
                                <span class="value col-xs-6"><?= $params['engine']['options'][$model->engine_type] ?></span>
                            </li>
                            <li class="specification col-xs-12">
                                <span class="text col-xs-6">Дверей</span>
                                <span class="value col-xs-6"><?= $model->doors ?></span>
                            </li>
                            <li class="specification col-xs-12">
                                <span class="text col-xs-6">Трансмиссия</span>
                                <span class="value col-xs-6"><?= $params['transmission']['options'][$model->transmission] ?></span>
                            </li>
                            <li class="specification col-xs-12">
                                <span class="text col-xs-6">Класс</span>
                                <span class="value col-xs-6">Легковой а/м</span>
                            </li>
                            <li class="specification col-xs-12">
                                <span class="text col-xs-6">Привод</span>
                                <span class="value col-xs-6"><?= $params['drive']['options'][$model->drive_type] ?></span>
                            </li>
                        </ul>
                                
                        <a href="<?= Url::to(['catalog/view', 'brand' => $model->car->parents(2)->select(['slug'])->one()->slug,
                            'auto_model' => $model->car->parents(1)->select(['slug'])->one()->slug, 'generation' => $model->catalog_id,
                            'type' => $model->type ]) ?>" class="catalog-link transition">Характеристики модели в каталоге</a>
                                
                        <div class="author-info col-xs-12">
                            
                            <span class="name col-xs-12"><?= Html::encode($model->user->username) ?></span>
                            
                            <div class="phone col-xs-12">
                                <i class="fas fa-phone-volume"></i> <a href="tel:<?= $model->user->phone ?>"><?= $model->user->phone ?></a>
                            </div>                                                      
                                    
                            <span class="address col-xs-12"><?= $model->city->name ?>, <?= $model->city->region->name ?></span>
                        </div>
                    </div>
                            
                    <?php if ($model->image): ?>
                    
                    <div class="product-images col-xs-12 col-sm-8">
                            
                            <?php \app\assets\LightGalleryAsset::register($this);
                            $items = [];
                            foreach ($model->image as $image){
                                $items[] = '<div class="main-image-slide col-xs-12" data-src="/images/uploads/source/' . $image . '">
                                    <img src="' . SiteHelper::resized_image($image, 550, 420) . '">
                                </div>';
                            }
                            $this->registerJs("
                                $('#lightgallery').lightGallery({
                                    selector: '.main-image-slide'
                                });
                                var statusProduct = $('.main-images-slider + .pagingInfo'), slickElement = $('.main-images-slider');
                                slickElement.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
                                    var i = (currentSlide ? currentSlide : 0) + 1;
                                    statusProduct.text(i + ' / ' + slick.slideCount);
                                });"
                            );
                            echo Slick::widget([
                                'containerTag' => 'div',
                                'containerOptions' => ['id' => 'lightgallery', 'class' => 'main-images-slider col-xs-12'],
                                'items' => $items,
                                'clientOptions' => [
                                    'slidesToShow' => 1,
                                    'slidesToScroll' => 1,
                                    'dots' => false,
                                    'arrows' => false,
                                    'adaptiveHeight' => true,
                                    'asNavFor' => '.mini-images-slider',
                                    'customPaging' => 'function(slider, i) {
                                        var thumb = $(slider.$slides[i]).data();
                                    }'
                                ]
                            ]); ?>
                            
                        <span class="pagingInfo"></span>
                                
                        <?php if (count($model->image) > 1){
                            $items = [];
                            foreach ($model->image as $image){
                                $items[] = Html::img(SiteHelper::resized_image($image, 120, 100));
                            }
                            echo Slick::widget([
                                'containerTag' => 'div',
                                'containerOptions' => ['class' => 'mini-images-slider hidden-xs col-xs-12'],
                                'itemContainer' => 'div',
                                'itemOptions' => ['class' => 'mini-image-slide col-xs-12 col-sm-4 col-md-3'],
                                'items' => $items,
                                'clientOptions' => [
                                    'slidesToShow' => 5,
                                    'slidesToScroll' => 1,
                                    'dots' => false,
                                    'arrows' => false,
                                    'asNavFor' => '.main-images-slider',
                                    'focusOnSelect' => true,
                                    'responsive' => [
                                        [
                                            'breakpoint' => 1200,
                                            'settings' => [
                                                'slidesToShow' => 4,
                                                'slidesToScroll' => 1
                                            ]
                                        ],
                                        [
                                            'breakpoint' => 992,
                                            'settings' => [
                                                'slidesToShow' => 4,
                                                'slidesToScroll' => 1
                                            ]
                                        ],
                                        [
                                            'breakpoint' => 768,
                                            'settings' => [
                                                'slidesToShow' => 3,
                                                'slidesToScroll' => 1
                                            ]
                                        ],
                                        [
                                            'breakpoint' => 575,
                                            'settings' => [
                                                'slidesToShow' => 2,
                                                'slidesToScroll' => 1
                                            ]
                                        ]
                                    ]
                                ]
                            ]);
                        } ?>
                        
                    </div>
                    
                    <?php endif ?>
                            
                    <div class="description col-xs-12 col-sm-8 pull-right">
                        <span class="title col-xs-12">Комментарий продавца</span>
                                
                        <p class="col-xs-12"><?= Html::encode($model->text) ?></p>
                        
                        <?php if ($model->modification): ?>
                        
                        <span class="title col-xs-12">Модефикация</span>
                                
                        <p class="col-xs-12"><?= Html::encode($model->modification) ?></p>
                        
                        <?php endif ?>
                        
                    </div>
                </section>
            </div>
                    
            <?= \app\components\AsideWidget::widget() ?>
        </div>
    </div>
</div>