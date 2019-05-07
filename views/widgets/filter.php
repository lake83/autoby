<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Html;
use app\models\Catalog;

/* @var $this yii\web\View */
/* @var $filter app\models\FilterForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $cars array */
/* @var $ads_count array */
/* @var $years array */
/* @var $capacity array */

$request = Yii::$app->request;
$h1 = 'Автомобили';
if ($request->get('brand')) {
    $h1 = 'Купить ' . (isset($cars['Популярные'][$request->get('brand')]) ? $cars['Популярные'][$request->get('brand')] : $cars['Все'][$request->get('brand')]);
}
if ($request->get('auto_model')) {
    $h1.= ' ' . Catalog::find()->select(['name'])->where(['id' => $request->get('auto_model')])->scalar();
}
if ($request->get('generation')) {
    $h1.= ' ' . Catalog::find()->select(['name'])->where(['id' => $request->get('generation')])->scalar();
}
?>

<div class="mobile-all-filters">
    <div class="filter-top text-center col-xs-12">
        <span class="filter-cancel">Отменить</span>
        <span class="filter-title">Фильтр</span>
        <a href="<?= $href = Yii::$app->controller->action->id == 'all' ? Url::to(['cars/all']) : '#' ?>" class="filter-reset">Очистить</a>
    </div>
</div>
                        
<section class="filters col-xs-12" id="filters">
    <h1 class="title col-xs-12"><?= $h1 ?></h1>
                            
    <?php $form = ActiveForm::begin(['id' => 'ads-filter', 'method' => 'get', 'action' => Url::to(['cars/all']), 'options' => ['data-params' => '']]) ?>
                            
        <div class="filters-wrapper col-xs-12">
            <div class="filters-group col-xs-4">
                                    
                <?= $form->field($filter, 'brand')->widget(Select2::classname(), [
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'data' => $cars,
                    'options' => [
                        'value' => $request->get('brand'),
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
                        'depends' => ['brand'],
                        'placeholder' => 'Модель',
                        'loading' => false,
                        'initialize' => true,
                        'url' => Url::to(['/filter/models', 'selected' => $request->get('auto_model')])
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
                        'depends' => ['brand', 'auto_model'],
                        'placeholder' => 'Поколение',
                        'loading' => false,
                        'url' => Url::to(['/filter/generations', 'selected' => $request->get('generation')])
                    ]
                ])->label(false) ?>
                                    
            </div>
                                
            <div class="filters-group col-xs-4 hidden-xs more">
                <div class="btn-group half col-xs-6">
                                        
                    <?= $form->field($filter, 'type')->widget(Select2::classname(), [
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'data' => Yii::$app->params['car_body_type']['options'],
                        'options' => [
                            'value' => $request->get('type'),
                            'placeholder' => 'Кузов'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ])->label(false) ?>
                                        
                </div>
                                    
                <div class="btn-group half col-xs-6">
                                        
                    <?= $form->field($filter, 'transmission')->widget(Select2::classname(), [
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'data' => Yii::$app->params['transmission']['options'],
                        'hideSearch' => true,
                        'options' => [
                            'value' => $request->get('transmission'),
                            'placeholder' => 'Коробка'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ])->label(false) ?>
                                        
                </div>
                                    
                <div class="btn-group half-out-border col-xs-6">
                                        
                    <?= $form->field($filter, 'year_from')->widget(Select2::classname(), [
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'data' => $years,
                        'options' => [
                            'value' => $request->get('year_from'),
                            'placeholder' => 'Год от'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ])->label(false) ?>
                                        
                </div>
                                    
                <div class="btn-group half-out-border col-xs-6">
                                        
                    <?= $form->field($filter, 'year_to')->widget(Select2::classname(), [
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'data' => $years,
                        'options' => [
                            'value' => $request->get('year_to'),
                            'placeholder' => 'Год до'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
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
                            'value' => $request->get('engine'),
                            'placeholder' => 'Двигатель'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ])->label(false) ?>
                                        
                </div>
                                    
                <div class="btn-group half col-xs-6">
                                        
                    <?= $form->field($filter, 'drive')->widget(Select2::classname(), [
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'data' => Yii::$app->params['drive']['options'],
                        'hideSearch' => true,
                        'options' => [
                            'value' => $request->get('drive'),
                            'placeholder' => 'Привод'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ])->label(false) ?>
                                        
                </div>
                                    
                <div class="btn-group half-out-border col-xs-6">
                                        
                    <?= $form->field($filter, 'mileage_from')->textInput(['value' => $request->get('mileage_from'), 'placeholder' => 'Пробег от, км', 'class' => 'btn form-input text-left transition', 'style' => 'width:100%'])->label(false) ?>
                                    
                </div>
                                    
                <div class="btn-group half-out-border col-xs-6">
                                        
                    <?= $form->field($filter, 'mileage_to')->textInput(['value' => $request->get('mileage_to'), 'placeholder' => 'до', 'class' => 'btn form-input text-left transition', 'style' => 'width:100%'])->label(false) ?>
                                                                                                                        
                </div>
            </div>
                                
            <div class="filters-group col-xs-4 hidden-xs more">
                <div class="btn-group half-out-border col-xs-6">
                                        
                    <?= $form->field($filter, 'capacity_from')->widget(Select2::classname(), [
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'data' => $capacity,
                        'options' => [
                            'value' => $request->get('capacity_from'),
                            'placeholder' => 'Обьем от, л'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ])->label(false) ?>
                                        
                </div>
                                    
                <div class="btn-group half-out-border col-xs-6">
                                        
                    <?= $form->field($filter, 'capacity_to')->widget(Select2::classname(), [
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'data' => $capacity,
                        'options' => [
                            'value' => $request->get('capacity_to'),
                            'placeholder' => 'до'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ])->label(false) ?>
                                        
                </div>
                                    
                <div class="btn-group half-out-border col-xs-6">
                                        
                    <?= $form->field($filter, 'price_from')->textInput(['value' => $request->get('price_from'), 'placeholder' => 'Цена от, $', 'class' => 'btn form-input text-left transition', 'style' => 'width:100%'])->label(false) ?>
                                    
                </div>
                                    
                <div class="btn-group half-out-border col-xs-6">
                                        
                    <?= $form->field($filter, 'price_to')->textInput(['value' => $request->get('price_to'), 'placeholder' => 'до', 'class' => 'btn form-input text-left transition', 'style' => 'width:100%'])->label(false) ?>
                                                                                                                        
                </div>
                                    
            </div>
            
            <?= Html::hiddenInput('sort', $request->get('sort')) ?>
            
            <?= Html::hiddenInput('locations', $_COOKIE['locations']) ?>
                                
            <div class="clearfix"></div>
            
            <div class="reset-filters">
                <a href="<?= $href ?>" class="hidden-xs">Сбросить <i class="fas fa-times"></i></a> 
                <span class="m-all-filters transition visible-xs">
                    <img class="white" src="/images/filter_btn_w.svg" alt=""> 
                    <img class="red" src="/images/filter_btn_r.svg" alt=""> Все параметры
                </span>
            </div>
            <div class="btn-wrapper">
                <?php if ($count = array_sum($ads_count)): ?>
                                    
                <?= Html::submitButton(Yii::t('app', 'Показать <span>{n, plural, =0{#</span> предложений} =1{#</span> предложене} one{#</span> предложене} few{#</span> предложения} many{#</span> предложений} other{#</span> предложений}}', ['n' => $count]), ['class' => 'blue-btn hidden-xs transition']) ?>
                                    
                <?php else: ?>
                                    
                <span class="empty">Ничего не найдено</span>
                                    
                <?php endif ?>
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