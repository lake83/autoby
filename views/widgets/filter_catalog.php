<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $filter app\models\FilterForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $cars array */

$request = Yii::$app->request;
?>
                        
<section class="filters col-xs-12" id="filters">
    <span class="title hidden-xs col-xs-12">Каталог</span>
                            
    <?php $form = ActiveForm::begin(['id' => 'catalog-filter', 'method' => 'get', 'action' => Url::to(['catalog/view'])]) ?>
                            
        <div class="filters-wrapper col-xs-12">
            <div class="filters-group col-xs-3">
                                    
                <?= $form->field($filter, 'brand')->widget(Select2::classname(), [
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'data' => $cars,
                    'options' => [
                        'value' => $request->get('brand'),
                        'placeholder' => 'Марка'
                    ]
                ])->label(false) ?>
                                    
            </div>
                                
            <div class="filters-group col-xs-3">
                                    
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
                                
            <div class="filters-group col-xs-3">
                                    
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
                
            <div class="filters-group col-xs-3">
             
                <?= $form->field($filter, 'type')->widget(DepDrop::classname(), [
                    'type' => DepDrop::TYPE_SELECT2,
                    'select2Options' => [
                        'hideSearch' => true,
                        'theme' => Select2::THEME_BOOTSTRAP
                    ],
                    'pluginOptions' => [
                        'depends' => ['brand', 'auto_model', 'generation'],
                        'placeholder' => 'Кузов',
                        'loading' => false,
                        'url' => Url::to(['/filter/type', 'selected' => $request->get('type')])
                    ]
                ])->label(false) ?>
                                        
            </div>
            
            <div class="btn-wrapper">
                
                <?= Html::submitButton('Показать', ['class' => 'blue-btn transition']) ?>
                
            </div>
        </div>
                            
    <?php ActiveForm::end(); ?>
                              
</section>