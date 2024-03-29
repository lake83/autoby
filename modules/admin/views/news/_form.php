<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\RedactorTinymce;

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\bootstrap\ActiveForm */

$form = ActiveForm::begin(['layout' => 'horizontal']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'slug')->textInput(['maxlength' => true])->hint('Генерируется из названия.') ?>
    
    <?= $form->field($model, 'image')->widget(\app\components\FilemanagerInput::className()) ?>
        
    <?=  $form->field($model, 'intro_text')->widget(RedactorTinymce::className()) ?>

    <?= $form->field($model, 'full_text')->widget(RedactorTinymce::className()) ?>
    
    <?= $form->field($model, 'created_at')->widget(\yii\jui\DatePicker::className() , [
            'language' => 'ru',
            'dateFormat' => 'dd.MM.yyyy',
            'options' => ['class' => 'form-control', 'autocomplete' => 'off'],
            'clientOptions' => [
                'changeMonth' => true,
                'changeYear' => true
            ]
    ]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'is_active')->checkbox() ?>

    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>