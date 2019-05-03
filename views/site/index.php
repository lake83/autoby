<?php

use app\components\SiteHelper;
use yii\helpers\Url;
use evgeniyrru\yii2slick\Slick;

/* @var $this yii\web\View */
/* @var $news app\models\News */

$this->title = 'Покупка и продажа автомобилей в Беларуси | Купить, продать, авто «Автобай»';
$this->registerMetaTag(['name' => 'keywords',
    'content' => 'Покупка и продажа автомобилей в Беларуси'
]);
$this->registerMetaTag(['name' => 'description',
    'content' => 'Объявления о продаже бу авто с пробегом в Беларуси. Срочный выкуп, обмен, кредит, лизинг, продажа подержанных автомобилей в своём автохаусе «Автобай». Заходите на сайт!'
]);
?>
        
<div class="content col-xs-12">
    <?= \app\components\TopWidget::widget() ?>
            
    <div class="container">
        <div class="row">
            <div class="main-content col-xs-12 col-md-9">

                <?php if (count($news) > 0): ?>
                        
                <section class="main-news col-xs-12 hidden-xs">
                    <div class="image" style="background: url('<?= SiteHelper::resized_image($news[0]['image'], 200) ?>')"></div>
                            
                    <div class="info">
                        <span class="category col-xs-12">новости компаний</span>
                        <span class="title col-xs-12"><?= $news[0]['name'] ?></span>
                        <p class="description col-xs-12"><?= $news[0]['intro_text'] ?></p>
                                
                        <a href="<?= Url::to(['news/view', 'slug' => $news[0]['slug']]) ?>" class="read-more transition">Читать дальше <i class="fas fa-angle-right transition"></i></a>
                    </div>
                </section>
                        
                <?php endif ?>
                        
                <?= \app\components\FilterWidget::widget() ?>                                            
                        
                <section class="banner text-center hidden-xs col-xs-12">
                    920 x 150
                </section>
                        
                <?php if (count($news) > 0): $items = []; ?>
                        
                <section class="news col-xs-12">
                    <span class="title col-xs-12">новости</span>
                            
                    <?php foreach ($news as $item){
                        $items[] = $this->context->renderPartial('_news_item', ['model' => $item]);
                    }
                    echo Slick::widget([
                        'containerTag' => 'div',
                        'containerOptions' => ['class' => 'news-list news-slider col-xs-12'],
                        'itemContainer' => 'div',
                        'itemOptions' => ['class' => 'news-item col-xs-12'],
                        'items' => $items,
                        'clientOptions' => [
                            'autoplay' => false,
                            'infinite' => false,
                            'draggable' => true,
                            'adaptiveHeight' => true,
                            'arrows' => true,
                            'slidesToShow' => 3,
                            'slidesToScroll' => 1,
                            'responsive' => [
                                [
                                    'breakpoint' => 767,
                                    'settings' => [
                                        'slidesToShow' => 2,
                                        'slidesToScroll' => 1,
                                        'arrows' => false,
                                        'infinite' => true,
                                        'centerMode' => true,
                                        'centerPadding' => '30px'
                                    ]
                                ],
                                [
                                    'breakpoint' => 575,
                                    'settings' => [
                                        'slidesToShow' => 1,
                                        'slidesToScroll' => 1,
                                        'arrows' => false,
                                        'infinite' => true,
                                        'centerMode' => true,
                                        'centerPadding' => '30px'
                                    ]
                                ]
                            ]
                        ]
                    ]) ?>
                            
                </section>
                        
                <?php endif ?>
                        
            </div>
                    
            <?= \app\components\AsideWidget::widget() ?>
                    
        </div>
    </div>
</div>