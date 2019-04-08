<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Specifications */
/* @var $form yii\bootstrap\ActiveForm */

$params = Yii::$app->params;
$listOptions = ['class' => 'form-control', 'prompt' => '- выбрать -'];

$form = ActiveForm::begin(['layout' => 'horizontal', 'fieldConfig' => [
    'options' => ['class' => 'col-md-4'],
    'labelOptions' => ['class' => 'col-md-12'],
    'horizontalCssClasses' => [
        'label' => 'control-label',
        'offset' => '',
        'wrapper' => 'col-md-12'
    ]
]]); ?>

    <?= $form->field($model, 'capacity')->textInput() ?>

    <?= $form->field($model, 'power')->textInput() ?>

    <?= $form->field($model, 'transmission')->dropDownList($params['transmission']['options'], $listOptions) ?>

    <?= $form->field($model, 'engine')->dropDownList($params['engine']['options'], $listOptions) ?>

    <?= $form->field($model, 'fuel')->dropDownList($params['fuel']['options'], $listOptions) ?>

    <?= $form->field($model, 'drive')->dropDownList($params['drive']['options'], $listOptions) ?>

    <?= $form->field($model, 'racing')->textInput() ?>

    <?= $form->field($model, 'consumption')->textInput() ?>

    <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'class')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'doors')->textInput() ?>

    <?= $form->field($model, 'seats')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'length')->textInput() ?>

    <?= $form->field($model, 'width')->textInput() ?>

    <?= $form->field($model, 'height')->textInput() ?>

    <?= $form->field($model, 'wheelbase')->textInput() ?>

    <?= $form->field($model, 'clearance')->textInput() ?>

    <?= $form->field($model, 'front_track')->textInput() ?>

    <?= $form->field($model, 'rear_track')->textInput() ?>

    <?= $form->field($model, 'wheel_size')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'luggage_capacity')->textInput() ?>

    <?= $form->field($model, 'tank_capacity')->textInput() ?>

    <?= $form->field($model, 'curb_weight')->textInput() ?>

    <?= $form->field($model, 'full_weight')->textInput() ?>

    <?= $form->field($model, 'gears')->textInput() ?>

    <?= $form->field($model, 'front_suspension')->dropDownList($params['suspension']['options'], $listOptions) ?>

    <?= $form->field($model, 'rear_suspension')->dropDownList($params['suspension']['options'], $listOptions) ?>

    <?= $form->field($model, 'front_brakes')->dropDownList($params['brakes']['options'], $listOptions) ?>

    <?= $form->field($model, 'rear_brakes')->dropDownList($params['brakes']['options'], $listOptions) ?>

    <?= $form->field($model, 'max_speed')->textInput() ?>

    <?= $form->field($model, 'consumption_all')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'environmental_class')->dropDownList($params['environmental_class']['options'], $listOptions) ?>

    <?= $form->field($model, 'emissions')->textInput() ?>

    <?= $form->field($model, 'engine_location')->dropDownList($params['engine_location']['options'], $listOptions) ?>

    <?= $form->field($model, 'engine_capacity')->textInput() ?>

    <?= $form->field($model, 'boost_type')->dropDownList($params['boost_type']['options'], $listOptions) ?>

    <?= $form->field($model, 'max_power')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'max_torque')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cylinder_location')->dropDownList($params['cylinder_location']['options'], $listOptions) ?>

    <?= $form->field($model, 'cylinders_number')->textInput() ?>

    <?= $form->field($model, 'cylinder_valves')->textInput() ?>

    <?= $form->field($model, 'power_system')->dropDownList($params['power_system']['options'], $listOptions) ?>

    <?= $form->field($model, 'compression')->textInput() ?>

    <?= $form->field($model, 'bore_stroke')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_active')->checkbox() ?>
    
    <?= $form->field($model, 'modification_id')->hiddenInput(['value' => Yii::$app->request->get('modification_id')])->label(false) ?>

    <div class="clearfix"></div>
    
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>