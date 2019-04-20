<?php

use app\components\SiteHelper;
use yii\helpers\Url;
use evgeniyrru\yii2slick\Slick;
use yii\widgets\ActiveForm;
use app\models\Catalog;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $news app\models\News */
/* @var $filter app\models\FilterForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $cars array */
/* @var $ads_count array */
/* @var $years array */
/* @var $capacity array */

$this->title = 'Покупка и продажа автомобилей в Беларуси | Купить, продать, авто «Автобай»';
$this->registerMetaTag(['name' => 'keywords',
    'content' => 'Покупка и продажа автомобилей в Беларуси'
]);
$this->registerMetaTag(['name' => 'description',
    'content' => 'Объявления о продаже бу авто с пробегом в Беларуси. Срочный выкуп, обмен, кредит, лизинг, продажа подержанных автомобилей в своём автохаусе «Автобай». Заходите на сайт!'
]);

//print_r(Yii::$app->msdb->createCommand('SELECT * FROM dbo.Site_Car')->queryOne());
?>
        
        <div class="content col-xs-12">
            <?= \app\components\TopWidget::widget() ?>
            
            <div class="container">
                <div class="row">
                    <div class="main-content col-xs-12 col-md-9">

                        <?php if (count($news) > 0): $first = array_shift($news); ?>
                        
                        <section class="main-ad col-xs-12 hidden-xs">
                            <div class="image" style="background: url('<?= SiteHelper::resized_image($first['image'], 200) ?>')"></div>
                            
                            <div class="info">
                                <span class="category col-xs-12">новости компаний</span>
                                <span class="title col-xs-12"><?= $first['name'] ?></span>
                                <p class="description col-xs-12"><?= $first['intro_text'] ?></p>
                                
                                <a href="<?= Url::to(['news/view', 'slug' => $first['slug']]) ?>" class="read-more transition">Читать дальше <i class="fas fa-angle-right transition"></i></a>
                            </div>
                        </section>
                        
                        <?php endif ?>
                        
                        <div class="mobile-all-filters">
                            <div class="filter-top text-center col-xs-12">
                                <span class="filter-cancel">Отменить</span>
                                <span class="filter-title">Фильтр</span>
                                <span class="filter-reset">Очистить</span>
                            </div>
                        </div>
                        
                        <section class="filters col-xs-12" id="filters">
                            <span class="title hidden-xs col-xs-12">Легковые автомобили</span>
                            
                            <?php $form = ActiveForm::begin(['id' => 'ads-filter']) ?>
                            
                            <div class="filters-wrapper col-xs-12">
                                <div class="filters-group col-xs-4">
                                    
                                    <?= $form->field($filter, 'brand')->widget(Select2::classname(), [
                                        'theme' => Select2::THEME_BOOTSTRAP,
                                        'data' => $cars,
                                        'options' => [
                                            'placeholder' => 'Марка'
                                        ]
                                    ])->label(false) ?>
                                    
                                </div>
                                
                                <div class="filters-group col-xs-4">
                                    
                                    <?= $form->field($filter, 'auto_model')->widget(DepDrop::classname(), [
                                        'type' => DepDrop::TYPE_SELECT2,
                                        'select2Options' => [
                                            'theme' => Select2::THEME_BOOTSTRAP
                                        ],
                                        'pluginOptions' => [
                                            'depends' => ['filterform-brand'],
                                            'placeholder' => 'Модель',
                                            'loading' => false,
                                            'url' => Url::to(['/filter/models'])
                                        ]
                                    ])->label(false) ?>
                                    
                                </div>
                                
                                <div class="filters-group col-xs-4">
                                    
                                    <?= $form->field($filter, 'generation')->widget(DepDrop::classname(), [
                                        'type' => DepDrop::TYPE_SELECT2,
                                        'select2Options' => [
                                            'hideSearch' => true,
                                            'theme' => Select2::THEME_BOOTSTRAP
                                        ],
                                        'pluginOptions' => [
                                            'depends' => ['filterform-brand', 'filterform-auto_model'],
                                            'placeholder' => 'Поколение',
                                            'loading' => false,
                                            'url' => Url::to(['/filter/generations'])
                                        ]
                                    ])->label(false) ?>
                                    
                                </div>
                                
                                <div class="filters-group col-xs-4 hidden-xs more">
                                    <div class="btn-group half col-xs-6">
                                        
                                        <?= $form->field($filter, 'type')->widget(Select2::classname(), [
                                            'theme' => Select2::THEME_BOOTSTRAP,
                                            'data' => Yii::$app->params['car_body_type']['options'],
                                            'options' => [
                                                'placeholder' => 'Кузов'
                                            ]
                                        ])->label(false) ?>
                                        
                                    </div>
                                    
                                    <div class="btn-group half col-xs-6">
                                        
                                        <?= $form->field($filter, 'transmission')->widget(Select2::classname(), [
                                            'theme' => Select2::THEME_BOOTSTRAP,
                                            'data' => Yii::$app->params['transmission']['options'],
                                            'hideSearch' => true,
                                            'options' => [
                                                'placeholder' => 'Коробка'
                                            ]
                                        ])->label(false) ?>
                                        
                                    </div>
                                    
                                    <div class="btn-group half-out-border col-xs-6">
                                        
                                        <?= $form->field($filter, 'year_from')->widget(Select2::classname(), [
                                            'theme' => Select2::THEME_BOOTSTRAP,
                                            'data' => $years,
                                            'options' => [
                                                'placeholder' => 'Год от'
                                            ]
                                        ])->label(false) ?>
                                        
                                    </div>
                                    
                                    <div class="btn-group half-out-border col-xs-6">
                                        
                                        <?= $form->field($filter, 'year_to')->widget(Select2::classname(), [
                                            'theme' => Select2::THEME_BOOTSTRAP,
                                            'data' => $years,
                                            'options' => [
                                                'placeholder' => 'Год до'
                                            ]
                                        ])->label(false) ?>
                                    
                                    </div>
                                </div>
                                
                                <div class="filters-group col-xs-4 hidden-xs more">
                                    <div class="btn-group half col-xs-6">
                                        
                                        <?= $form->field($filter, 'engine')->widget(Select2::classname(), [
                                            'theme' => Select2::THEME_BOOTSTRAP,
                                            'data' => Yii::$app->params['engine']['options'],
                                            'hideSearch' => true,
                                            'options' => [
                                                'placeholder' => 'Двигатель'
                                            ]
                                        ])->label(false) ?>
                                        
                                    </div>
                                    
                                    <div class="btn-group half col-xs-6">
                                        
                                        <?= $form->field($filter, 'drive')->widget(Select2::classname(), [
                                            'theme' => Select2::THEME_BOOTSTRAP,
                                            'data' => Yii::$app->params['drive']['options'],
                                            'hideSearch' => true,
                                            'options' => [
                                                'placeholder' => 'Привод'
                                            ]
                                        ])->label(false) ?>
                                        
                                    </div>
                                    
                                    <div class="btn-group half-out-border col-xs-6">
                                        
                                        <?= $form->field($filter, 'mileage_from')->textInput(['placeholder' => 'Пробег от, км', 'class' => 'btn form-input text-left transition', 'style' => 'width:100%'])->label(false) ?>
                                    
                                    </div>
                                    
                                    <div class="btn-group half-out-border col-xs-6">
                                        
                                        <?= $form->field($filter, 'mileage_to')->textInput(['placeholder' => 'до', 'class' => 'btn form-input text-left transition', 'style' => 'width:100%'])->label(false) ?>
                                                                                                                        
                                    </div>
                                </div>
                                
                                <div class="filters-group col-xs-4 hidden-xs more">
                                    <div class="btn-group half-out-border col-xs-6">
                                        
                                        <?= $form->field($filter, 'capacity_from')->widget(Select2::classname(), [
                                            'theme' => Select2::THEME_BOOTSTRAP,
                                            'data' => $capacity,
                                            'options' => [
                                                'placeholder' => 'Обьем от, л'
                                            ]
                                        ])->label(false) ?>
                                        
                                    </div>
                                    
                                    <div class="btn-group half-out-border col-xs-6">
                                        
                                        <?= $form->field($filter, 'capacity_to')->widget(Select2::classname(), [
                                            'theme' => Select2::THEME_BOOTSTRAP,
                                            'data' => $capacity,
                                            'options' => [
                                                'placeholder' => 'до'
                                            ]
                                        ])->label(false) ?>
                                        
                                    </div>
                                    
                                    <div class="btn-group half-out-border col-xs-6">
                                        
                                        <?= $form->field($filter, 'price_from')->textInput(['placeholder' => 'Цена от, $', 'class' => 'btn form-input text-left transition', 'style' => 'width:100%'])->label(false) ?>
                                    
                                    </div>
                                    
                                    <div class="btn-group half-out-border col-xs-6">
                                        
                                        <?= $form->field($filter, 'price_to')->textInput(['placeholder' => 'до', 'class' => 'btn form-input text-left transition', 'style' => 'width:100%'])->label(false) ?>
                                                                                                                        
                                    </div>
                                    
                                </div>
                                
                                <div class="clearfix"></div>
                                <div class="reset-filters">
                                    <a href="#" class="hidden-xs">Сбросить <i class="fas fa-times"></i></a> 
                                    <span class="m-all-filters transition visible-xs">
                                        <img class="white" src="/images/filter_btn_w.svg" alt=""> 
                                        <img class="red" src="/images/filter_btn_r.svg" alt=""> Все параметры
                                    </span>
                                </div>
                                <div class="btn-wrapper">
                                    <a href="" class="blue-btn hidden-xs transition"><?= Yii::t('app', 'Показать <span>{n, plural, =0{#</span> предложений} =1{#</span> предложене} one{#</span> предложене} few{#</span> предложения} many{#</span> предложений} other{#</span> предложений}}', ['n' => array_sum($ads_count)]) ?></a>
                                </div>
                            </div>
                            
                            <?php ActiveForm::end(); ?>
                              
                        </section>
                        
                        <div data-href="#filters" class="all-filters-anchor transition text-center hidden-xs"><i class="fas fa-angle-up"></i> Все параметры</div>
                        
                        <div id="select-list" class="hidden-xs">
                        
                        <section class="car-logos flex col-xs-12">
                            
                            <?php foreach (['Audi', 'BMW', 'Ford', 'Peugeot', 'Mercedes-Benz', 'Nissan', 'Opel', 'Renault', 'Toyota', 'Volkswagen'] as $name): ?>
                            
                            <a href="<?= array_search($name, $cars['Популярные']) ?>" class="car-logo">
                                <img src="/images/car-marks/<?= $name ?>.png" class="transition" alt="<?= $name ?>">
                            </a>
                            
                            <?php endforeach ?>
                                                        
                        </section>
                        
                        <section class="car-marks col-xs-12">
                            
                            <?php foreach ($cars['Популярные'] as $id => $name): ?>
                            
                            <div class="car-mark">
                                <a href="<?= $id ?>"><span class="title transition"><?= $name ?></span> <span class="count"><?= $ads_count[$id] ?></span></a>
                            </div>
                            
                            <?php endforeach ?>
                            
                            <div class="car-mark show-all">
                                <span class="title transition">Все марки</span> <i class="fas fa-angle-right transition"></i>
                            </div>
                        </section>
                        
                        <section class="car-marks all col-xs-12">
                            
                            <?php foreach ($cars['Все'] as $id => $name): ?>
                            
                            <div class="car-mark">
                                <a href="<?= $id ?>"><span class="title transition"><?= $name ?></span> <span class="count"><?= $ads_count[$id] ?></span></a>
                            </div>
                            
                            <?php endforeach ?>
                            
                        </section>
                        
                        </div>                                                
                        
                        <section class="banner text-center hidden-xs col-xs-12">
                            920 x 150
                        </section>
                        
                        <?php if (count($news) > 0): $items = []; ?>
                        
                        <section class="ads col-xs-12">
                            <span class="title col-xs-12">новости</span>
                            
                            <?php foreach ($news as $item){
                                $items[] = $this->context->renderPartial('_news_item', ['model' => $item]);
                            }
                            echo Slick::widget([
                                'containerTag' => 'div',
                                'containerOptions' => ['class' => 'ads-list ads-slider col-xs-12'],
                                'itemContainer' => 'div',
                                'itemOptions' => ['class' => 'ads-item col-xs-12'],
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