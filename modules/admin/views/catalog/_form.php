<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Catalog */
/* @var $form yii\bootstrap\ActiveForm */

$form = ActiveForm::begin(['layout' => 'horizontal']); ?>

    <?php if ($model->depth == 1): ?>
    
    <?= $form->field($model, 'image')->widget(\app\components\FilemanagerInput::className()) ?>
    
    <?php endif; ?>
    
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true])->hint('Генерируется из названия.') ?>
    
    <?php if ($model->depth > 1) {
        echo $form->field($model, 'year_from')->textInput(['maxlength' => true]);
        echo $form->field($model, 'year_to')->textInput(['maxlength' => true]);
    } ?>
    
    <?= $form->field($model, 'is_active')->checkbox() ?>

    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>