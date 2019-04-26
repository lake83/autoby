<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Modifications */
/* @var $form yii\bootstrap\ActiveForm */

$form = ActiveForm::begin(['layout' => 'horizontal']); ?>

    <?= $form->field($model, 'catalog_id')->hiddenInput(['value' => Yii::$app->request->get('catalog_id')])->label(false) ?>

    <?= $form->field($model, 'name')->dropDownList(Yii::$app->params['car_body_type']['options'], ['class' => 'form-control', 'prompt' => '- выбрать -']) ?>

    <?= $form->field($model, 'image')->widget(\app\components\FilemanagerMultipleInput::className()) ?>

    <?= $form->field($model, 'is_active')->checkbox() ?>

    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>