<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\Catalog;
use kartik\depdrop\DepDrop;
use yii\widgets\MaskedInput;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\models\BuyCarForm */

?>

<div class="content col-xs-12">
    <?= \app\components\TopWidget::widget() ?>
            
    <div class="container">
        <div class="row">
            <div class="main-content col-xs-12 col-md-9">
                
                <section class="filters buy-car col-xs-12">
                    <h1 class="title hidden-xs col-xs-12">Выкуп авто</h1>
                    
                    <?php if (Yii::$app->session->hasFlash('buyCarFormSubmitted')): ?>
                    
                    <span class="short-descroption col-xs-12">Спасибо, что обратились к нам. Мы свяжемся с Вами как можно скорее.</span>
                    
                    <?php else: ?>
                            
                    <span class="short-descroption col-xs-12">Компания «Автобай» выполняет выкуп авто различных марок в Минске и на территории всей Беларуси, предлагая продавцу максимально возможную цену.</span>
                            
                    <?php $form = ActiveForm::begin() ?>
                    
                        <div class="filters-wrapper col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                            <div class="filters-group col-xs-6">
                               
                                <?= $form->field($model, 'brand')->widget(Select2::classname(), [
                                    'theme' => Select2::THEME_BOOTSTRAP,
                                    'data' => Catalog::getBrands(),
                                    'options' => [
                                        'placeholder' => 'Марка'
                                    ]
                                ])->label(false) ?>     
                                    
                            </div>

                            <div class="filters-group col-xs-6">
                                
                                <?= $form->field($model, 'auto_model')->widget(DepDrop::classname(), [
                                    'type' => DepDrop::TYPE_SELECT2,
                                    'select2Options' => [
                                        'theme' => Select2::THEME_BOOTSTRAP
                                    ],
                                    'pluginOptions' => [
                                        'depends' => ['brand'],
                                        'placeholder' => 'Модель',
                                        'loading' => false,
                                        'url' => Url::to(['/filter/models'])
                                    ]
                                ])->label(false) ?>
                                
                            </div>
                            
                            <div class="clearfix"></div>
                                
                            <div class="filters-group col-xs-6">
                                
                                <?= $form->field($model, 'price')->textInput(['placeholder' => 'Цена, USD'])->label(false) ?>
                                
                            </div>
                                
                            <div class="filters-group col-xs-6">
                                
                                <?= $form->field($model, 'issue_year')->widget(DepDrop::classname(), [
                                    'type' => DepDrop::TYPE_SELECT2,
                                    'select2Options' => [
                                        'theme' => Select2::THEME_BOOTSTRAP
                                    ],
                                    'pluginOptions' => [
                                        'depends' => ['brand', 'auto_model'],
                                        'placeholder' => 'Год выпуска',
                                        'loading' => false,
                                        'allowClear' => true,
                                        'url' => Url::to(['/filter/issue-year'])
                                    ]
                                ])->label(false) ?>
                                
                            </div>
                                
                            <div class="filters-group col-xs-12">
                                
                                <?= $form->field($model, 'phone')->widget(MaskedInput::className(), ['mask' => Yii::$app->params['phone_mask'], 'options' => ['placeholder' => 'Телефон', 'class' => 'form-control']])->label(false) ?>
                                
                            </div>
                                
                            <div class="filters-group col-xs-12">
                                
                                <?= $form->field($model, 'info')->textarea(['rows' => 4, 'placeholder' => 'Дополнительная информация'])->label(false) ?>
                                
                            </div>
                                
                            <div class="btn-wrapper col-xs-12 text-center">
                            
                                <?= Html::submitButton('Отправить заявку', ['class' => 'blue-btn transition']) ?>
                            
                            </div>
                                
                        </div> 
                            
                    <?php ActiveForm::end(); ?>
                    
                    <?php endif ?>
                               
                </section>
                        
            </div>
            <?= \app\components\AsideWidget::widget() ?>
        </div>
    </div>
</div>