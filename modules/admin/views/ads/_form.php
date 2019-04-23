<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use app\models\City;
use app\models\Catalog;

/* @var $this yii\web\View */
/* @var $model app\models\Ads */
/* @var $form yii\bootstrap\ActiveForm */

$params = Yii::$app->params;
$listOptions = ['class' => 'form-control', 'prompt' => '- выбрать -'];

if (!$model->isNewRecord) {
    $city = City::find()->select(['name', 'region_id'])->where(['id' => $model->city])->asArray()->one();
    $car = Catalog::findOne($model->catalog_id);
    $auto_model = $car->parents(1)->select(['id', 'name'])->asArray()->one();
}
$form = ActiveForm::begin(['layout' => 'horizontal']); ?>

    <?= $form->field($model, 'brand')->dropDownList(Catalog::getBrands(), $listOptions + [
        'id' => 'brand', 'options' => $model->isNewRecord ? [] : [$car->parents(2)->select(['id'])->scalar() => ['selected' => 'selected']]
    ]) ?>
    
    <?= $form->field($model, 'auto_model')->widget(DepDrop::classname(), [
        'options' => ['id' => 'auto_model'],
        'data' => $model->isNewRecord ? [] : [$auto_model['id'] => $auto_model['name']],
        'pluginOptions' => [
            'depends' => ['brand'],
            'placeholder' => '- выбрать -',
            'loading' => false,
            'url' => Url::to(['/filter/models'])
        ]
    ]) ?>
    
    <?= $form->field($model, 'issue_year')->widget(DepDrop::classname(), [
        'options' => ['id' => 'issue_year'],
        'data' => $model->isNewRecord ? [] : [$model->issue_year => $model->issue_year],
        'pluginOptions' => [
            'depends' => ['brand', 'auto_model'],
            'placeholder' => '- выбрать -',
            'loading' => false,
            'url' => Url::to(['/filter/issue-year'])
        ]
    ]) ?>
    
    <?= $form->field($model, 'catalog_id')->widget(DepDrop::classname(), [
        'options' => ['id' => 'catalog_id'],
        'data' => $model->isNewRecord ? [] : [$model->catalog_id => $car->name],
        'pluginOptions' => [
            'depends' => ['brand', 'auto_model', 'issue_year'],
            'placeholder' => '- выбрать -',
            'loading' => false,
            'url' => Url::to(['/filter/car'])
        ]
    ]) ?>
    
    <?= $form->field($model, 'type')->widget(DepDrop::classname(), [
        'options' => ['id' => 'type'],
        'data' => $model->isNewRecord ? [] : [$model->type => Yii::$app->params['car_body_type']['options'][$model->type]],
        'pluginOptions' => [
            'depends' => ['brand', 'auto_model', 'issue_year', 'catalog_id'],
            'placeholder' => '- выбрать -',
            'loading' => false,
            'url' => Url::to(['/filter/type'])
        ]
    ]) ?>
    
    <?= $form->field($model, 'capacity')->textInput() ?>

    <?= $form->field($model, 'modification')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'condition')->dropDownList(Yii::$app->params['condition']['options'], $listOptions) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'engine_type')->dropDownList(Yii::$app->params['engine']['options'], $listOptions) ?>
    
    <?= $form->field($model, 'doors')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mileage')->textInput() ?>

    <?= $form->field($model, 'transmission')->dropDownList(Yii::$app->params['transmission']['options'], $listOptions) ?>

    <?= $form->field($model, 'drive_type')->dropDownList(Yii::$app->params['drive']['options'], $listOptions) ?>

    <?= $form->field($model, 'color')->dropDownList(Yii::$app->params['color']['options'], $listOptions) ?>

    <?= $form->field($model, 'image')->widget(\app\components\FilemanagerMultipleInput::className()) ?>

    <?= $form->field($model, 'region')->dropDownList(\app\models\Region::getAll(), $listOptions + [
        'id' => 'region', 'options' => $model->isNewRecord ? [] : [$city['region_id'] => ['selected' => 'selected']]
    ]) ?>
    
    <?= $form->field($model, 'city')->widget(DepDrop::classname(), [
        'options' => ['id' => 'city'],
        'data' => $model->isNewRecord ? [] : [$model->city => $city['name']],
        'pluginOptions' => [
            'depends' => ['region'],
            'placeholder' => '- выбрать -',
            'loading' => false,
            'url' => Url::to(['/filter/city'])
        ]
    ]) ?>

    <?= $form->field($model, 'seller_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phones')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_active')->checkbox() ?>

    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>