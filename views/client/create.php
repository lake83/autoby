<?php

use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use app\models\Catalog;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Ads */
/* @var $form yii\widgets\ActiveForm */

if (!$model->isNewRecord) {
    $car = Catalog::findOne($model->catalog_id);
    $model->brand = $car->parents(2)->select(['id'])->scalar();
    $model->region = $model->city->region->id;
}
?>
<div class="content col-xs-12">
    <?= \app\components\TopWidget::widget() ?>
            
    <div class="container">
        <div class="row">
            <div class="main-content col-xs-12 col-md-9">
            
                <section class="product-create col-xs-12">
                    <h1 class="title hidden-xs col-xs-12"><?= $model->isNewRecord ? 'Новое обьявление' : 'Редактирование объявления' ?></h1>
                            
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
                                    
                                <?php $form = ActiveForm::begin(['id' => 'create-ad', 'options' => ['enctype'=>'multipart/form-data', 'data-ad_id' => $model->id]]) ?>
                                        
                                    <div class="step col-xs-12">
                                        <div class="group-wrapper col-xs-12">
                                            <span class="text col-xs-12 col-sm-4 col-lg-3">Марка автомобиля *</span>

                                            <div class="btn-group col-xs-12 col-sm-5 col-lg-4">
                                                    
                                                <?= $form->field($model, 'brand')->widget(Select2::classname(), [
                                                    'theme' => Select2::THEME_BOOTSTRAP,
                                                    'data' => Catalog::getBrands(),
                                                    'options' => [
                                                        'value' => $model->brand,
                                                        'placeholder' => 'Выбрать'
                                                    ]
                                                ])->label(false) ?>
                                                    
                                            </div>
                                        </div>

                                        <div class="group-wrapper col-xs-12">
                                            <span class="text col-xs-12 col-sm-4 col-lg-3">Модель *</span>

                                            <div class="btn-group col-xs-12 col-sm-5 col-lg-4">
                                                
                                                <?= $form->field($model, 'auto_model')->widget(DepDrop::classname(), [
                                                    'type' => DepDrop::TYPE_SELECT2,
                                                    'select2Options' => [
                                                        'theme' => Select2::THEME_BOOTSTRAP
                                                    ],
                                                    'pluginOptions' => [
                                                        'depends' => ['brand'],
                                                        'placeholder' => 'Выбрать',
                                                        'loading' => false,
                                                        'initialize' => !$model->isNewRecord,
                                                        'url' => Url::to(['/filter/models', 'selected' => !$model->isNewRecord ? $car->parents(1)->select(['id'])->scalar() : ''])
                                                    ]
                                                ])->label(false) ?>  
                                                    
                                            </div>
                                        </div>

                                        <div class="group-wrapper col-xs-12">
                                            <span class="text col-xs-12 col-sm-4 col-lg-3">Год выпуска *</span>

                                            <div class="btn-group col-xs-12 col-sm-3 col-lg-2">
                                                    
                                                <?= $form->field($model, 'issue_year')->widget(DepDrop::classname(), [
                                                    'type' => DepDrop::TYPE_SELECT2,
                                                    'select2Options' => [
                                                        'hideSearch' => true,
                                                        'theme' => Select2::THEME_BOOTSTRAP
                                                    ],
                                                    'pluginOptions' => [
                                                        'depends' => ['brand', 'auto_model'],
                                                        'placeholder' => 'Выбрать',
                                                        'loading' => false,
                                                        'url' => Url::to(['/filter/issue-year', 'selected' => !$model->isNewRecord ? $model->issue_year : ''])
                                                    ]
                                                ])->label(false) ?>    
                                                    
                                            </div>
                                        </div>

                                        <div class="group-wrapper col-xs-12">
                                            <span class="text col-xs-12 col-sm-4 col-lg-3">Поколение *</span>

                                            <div class="btn-group col-xs-12 col-sm-5 col-lg-4">
                                                
                                                <?= $form->field($model, 'catalog_id')->widget(DepDrop::classname(), [
                                                    'type' => DepDrop::TYPE_SELECT2,
                                                    'select2Options' => [
                                                        'hideSearch' => true,
                                                        'theme' => Select2::THEME_BOOTSTRAP
                                                    ],
                                                    'pluginOptions' => [
                                                        'depends' => ['brand', 'auto_model', 'issue_year'],
                                                        'placeholder' => 'Выбрать',
                                                        'loading' => false,
                                                        'url' => Url::to(['/filter/car', 'selected' => !$model->isNewRecord ? $model->catalog_id : ''])
                                                    ]
                                                ])->label(false) ?>
                                                
                                            </div>
                                        </div>

                                        <div class="group-wrapper col-xs-12">
                                            <span class="text col-xs-12 col-sm-4 col-lg-3">Тип кузова *</span>

                                            <div class="btn-group col-xs-12 col-sm-5 col-lg-4">
                                                    
                                                <?= $form->field($model, 'type')->widget(DepDrop::classname(), [
                                                    'type' => DepDrop::TYPE_SELECT2,
                                                    'select2Options' => [
                                                        'hideSearch' => true,
                                                        'theme' => Select2::THEME_BOOTSTRAP
                                                    ],
                                                    'pluginOptions' => [
                                                        'depends' => ['brand', 'auto_model', 'issue_year', 'catalog_id'],
                                                        'placeholder' => 'Выбрать',
                                                        'loading' => false,
                                                        'url' => Url::to(['/filter/type', 'selected' => !$model->isNewRecord ? $model->type : ''])
                                                    ]
                                                ])->label(false) ?>    
                                                    
                                            </div>
                                        </div>

                                        <div class="group-wrapper col-xs-12">
                                            <span class="text col-xs-12 col-sm-4 col-lg-3">Модификация</span>

                                            <div class="btn-group col-xs-12 col-sm-5 col-lg-4">
                                                 
                                                 <?= $form->field($model, 'modification')->textInput(['maxlength' => true])->label(false) ?>
                                                 
                                            </div>

                                            <div class="description col-xs-12 col-sm-9 col-sm-offset-3">Пожалуйста, корректно заполняйте поля модель и модификация. <br> Обьявления с некорректно заполненной модефикацией будут модерироваться.</div>
                                        </div>

                                        <div class="group-wrapper col-xs-12">
                                            <span class="text col-xs-12 col-sm-4 col-lg-3">Состояние *</span>
                                            
                                            <div class="btn-group col-xs-12 col-sm-8 col-lg-9">
                                            
                                                <?= $form->field($model, 'condition')->radioList(Yii::$app->params['condition']['options'], [
                                                    'item' => function($index, $label, $name, $checked, $value) {
                                                        return '<div class="radio">
                                                            <label class="transition noselect">
                                                                <input type="radio" name="' . $name . '"  value="' . $value . '"' . ($checked ? ' checked="checked"' : '') . '>' .
                                                                $label
                                                            . '</label>
                                                        </div>';
                                                        }
                                                ])->label(false) ?>
                                                
                                            </div>
                                        </div>

                                        <div class="group-wrapper col-xs-12">
                                            <span class="text col-xs-12 col-sm-4 col-lg-3">Цена, USD *</span>

                                            <div class="btn-group col-xs-12 col-sm-5 col-lg-4">
                                                    
                                                <?= $form->field($model, 'price')->textInput()->label(false) ?>    
                                                    
                                            </div>
                                        </div>

                                        <div class="group-wrapper col-xs-12">
                                            <span class="text col-xs-12 col-sm-4 col-lg-3">Текст обьявления</span>

                                            <div class="btn-group col-xs-12 col-sm-8 col-lg-9">
                                                
                                                <?= $form->field($model, 'text')->textarea(['rows' => 4])->label(false) ?>
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="step hidden col-xs-12">
                                        <div class="group-wrapper col-xs-12">
                                            <span class="text col-xs-12 col-sm-4 col-lg-3">Тип двигателя *</span>
                                            
                                            <div class="btn-group col-xs-12 col-sm-8 col-lg-9">
                                            
                                                <?= $form->field($model, 'engine_type')->radioList(Yii::$app->params['engine']['options'], [
                                                    'item' => function($index, $label, $name, $checked, $value) {
                                                        return '<div class="radio">
                                                            <label class="transition noselect">
                                                                <input type="radio" name="' . $name . '"  value="' . $value . '"' . ($checked ? ' checked="checked"' : '') . '>' .
                                                                $label
                                                            . '</label>
                                                        </div>';
                                                        }
                                                ])->label(false) ?>
                                                
                                            </div>
                                        </div>

                                        <div class="group-wrapper col-xs-12">
                                            <span class="text col-xs-12 col-sm-4 col-lg-3">Пробег, км *</span>

                                            <div class="btn-group col-xs-12 col-sm-5 col-lg-4">
                                                
                                                <?= $form->field($model, 'mileage')->textInput()->label(false) ?>
                                                
                                            </div>
                                        </div>
                                        
                                        <div class="group-wrapper col-xs-12">
                                            <span class="text col-xs-12 col-sm-4 col-lg-3">Объем, л *</span>

                                            <div class="btn-group col-xs-12 col-sm-5 col-lg-4">
                                                
                                                <?= $form->field($model, 'capacity')->textInput()->label(false) ?>
                                                
                                            </div>
                                        </div>
                                        
                                        <div class="group-wrapper col-xs-12">
                                            <span class="text col-xs-12 col-sm-4 col-lg-3">Количество дверей *</span>

                                            <div class="btn-group col-xs-12 col-sm-5 col-lg-4">
                                                
                                                <?= $form->field($model, 'doors')->textInput()->label(false) ?>
                                                
                                            </div>
                                        </div>

                                        <div class="group-wrapper col-xs-12">
                                            <span class="text col-xs-12 col-sm-4 col-lg-3">Трансмиссия *</span>

                                            <div class="btn-group col-xs-12 col-sm-8 col-lg-9">
                                                
                                                <?= $form->field($model, 'transmission')->radioList(Yii::$app->params['transmission']['options'], [
                                                    'item' => function($index, $label, $name, $checked, $value) {
                                                        return '<div class="radio">
                                                            <label class="transition noselect">
                                                                <input type="radio" name="' . $name . '"  value="' . $value . '"' . ($checked ? ' checked="checked"' : '') . '>' .
                                                                $label
                                                            . '</label>
                                                        </div>';
                                                        }
                                                ])->label(false) ?>
                                                
                                            </div>
                                        </div>

                                        <div class="group-wrapper col-xs-12">
                                            <span class="text col-xs-12 col-sm-4 col-lg-3">Тип привода *</span>

                                            <div class="btn-group col-xs-12 col-sm-5 col-lg-4">
                                                    
                                                <?= $form->field($model, 'drive_type')->widget(Select2::classname(), [
                                                    'theme' => Select2::THEME_BOOTSTRAP,
                                                    'data' => Yii::$app->params['drive']['options'],
                                                    'hideSearch' => true,
                                                    'options' => [
                                                        'value' => !$model->isNewRecord ? $model->drive_type : '',
                                                        'placeholder' => 'Выбрать'
                                                    ],
                                                    'pluginOptions' => [
                                                        'allowClear' => true
                                                    ]
                                                ])->label(false) ?>    
                                                    
                                            </div>
                                        </div>

                                        <div class="group-wrapper col-xs-12">
                                            <span class="text col-xs-12 col-sm-4 col-lg-3">Цвет *</span>

                                            <div class="btn-group col-xs-12 col-sm-5 col-lg-4">
                                                 
                                                <?= $form->field($model, 'color')->widget(Select2::classname(), [
                                                    'theme' => Select2::THEME_BOOTSTRAP,
                                                    'data' => Yii::$app->params['color']['options'],
                                                    'hideSearch' => true,
                                                    'options' => [
                                                        'value' => !$model->isNewRecord ? $model->color : '',
                                                        'placeholder' => 'Выбрать'
                                                    ],
                                                    'pluginOptions' => [
                                                        'allowClear' => true
                                                    ]
                                                ])->label(false) ?> 
                                                 
                                            </div>
                                        </div>
                                        
                                        <div class="group-wrapper col-xs-12">
                                            <span class="text col-xs-12 col-sm-4 col-lg-3">Фото для обьявления</span>

                                            <div class="btn-group col-xs-12 col-sm-8 col-lg-9">
                                                
                                                <?= $form->field($model, 'image[]')->widget(FileInput::classname(), [
                                                    'options' => [
                                                        'multiple' => true,
                                                        'accept' => 'image/*'
                                                    ],
                                                    'pluginOptions' => [
                                                        'previewFileType' => 'image',
                                                        'maxFileCount' => 30,
                                                        'maxFileSize' => 8000,
                                                        'initialPreview' => !$model->isNewRecord && isset($model->image['urls']) ? $model->image['urls'] : [],
                                                        'initialPreviewAsData' => true,
                                                        'initialPreviewConfig' => !$model->isNewRecord && isset($model->image['config']) ? $model->image['config'] : [],
                                                        'overwriteInitial' => false,
                                                        'showUpload' => false,
                                                        'allowedFileExtensions' => ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'],
                                                        'fileActionSettings' => [
                                                            'showZoom' => false
                                                        ],
                                                        'deleteUrl' => Url::to(['client/delete-image', 'ad_id' => $model->id])
                                                    ]
                                                ])->label(false) ?>
                                                
                                            </div>

                                            <div class="description col-xs-12 col-sm-9 col-sm-offset-3">Допускается загрузка не более 30 фотографий в формате JPG и PNG размером не более 8МБ.<br> Наши <a href="<?= Url::to(['site/page', 'slug' => 'pravila-podaci-obavlenia']) ?>">правила</a> не рекомендуют вам использовать фотошоп, рекламу и чужие фотографии.</div>
                                        </div>
                                            
                                        <div class="group-wrapper col-xs-12">
                                            <span class="text col-xs-12 col-sm-4 col-lg-3">Адрес *</span>

                                            <div class="btn-group-wrap address col-xs-12 col-sm-5 col-lg-9">
                                                <div class="btn-group">
                                                    <label for="">Область</label>
                                                    
                                                    <?= $form->field($model, 'region')->widget(Select2::classname(), [
                                                        'theme' => Select2::THEME_BOOTSTRAP,
                                                        'data' => \app\models\Region::getAll(),
                                                        'hideSearch' => true,
                                                        'options' => [
                                                            'value' => $model->region,
                                                            'placeholder' => 'Выбрать'
                                                        ],
                                                        'pluginOptions' => [
                                                            'allowClear' => true
                                                        ]
                                                    ])->label(false) ?>
                                                        
                                                </div>

                                                <div class="btn-group">
                                                    <label for="">Город</label>
                                                    
                                                    <?= $form->field($model, 'city_id')->widget(DepDrop::classname(), [
                                                        'type' => DepDrop::TYPE_SELECT2,
                                                        'select2Options' => [
                                                            'hideSearch' => true,
                                                            'theme' => Select2::THEME_BOOTSTRAP
                                                        ],
                                                        'pluginOptions' => [
                                                            'depends' => ['region'],
                                                            'placeholder' => 'Выбрать',
                                                            'initialize' => !$model->isNewRecord,
                                                            'loading' => false,
                                                            'url' => Url::to(['/filter/city', 'selected' => !$model->isNewRecord ? $model->city_id : ''])
                                                        ]
                                                    ])->label(false) ?>
                                                        
                                                </div>
                                            </div>

                                            <div class="description col-xs-12 col-sm-9 col-sm-offset-3">Информация о местоположении техники</div>
                                        </div>
                                        
                                        <div class="group-wrapper col-xs-12 col-sm-9 col-sm-offset-3">
                                            <div class="checkbox">
                                                <label class="transition noselect" style="padding-left:0">
                                                        
                                                    <?= $form->field($model, 'rules', ['template' => '{input}Я ознакомлен с <a href="' . Url::to(['site/page', 'slug' => 'pravila-podaci-obavlenia']) . '">правилами подачи</a> объявлений и согласен на нанесение рекламного логотипа ' . Yii::$app->name . ' на загруженные мной фотографии.{error}'])->checkbox() ?>

                                                </label>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="continue-wrapper more col-xs-12">
                                        <span class="continue col-sm-offset-3">Продолжить <i class="fas fa-arrow-down"></i></span>
                                    </div>

                                    <div class="continue-wrapper hidden col-xs-12">
                                            
                                        <?= Html::submitButton('Опубликовать', ['class' => 'continue col-sm-offset-3']) ?>
                                                                                        
                                    </div>
                                        
                                <?php ActiveForm::end(); ?>
                                
                            </div>
                                
                            <div role="tabpanel" class="tab-pane fade col-xs-12" id="spares">
                                Находится в разработке.
                            </div>
                        </div>        
                </section>
            
            </div>
                    
            <?= \app\components\AsideWidget::widget() ?>  
        </div>
    </div>
</div>