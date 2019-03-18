<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model yii\base\DynamicModel */
/* @var $title app\models\Catalog */
/* @var $specifications app\models\Specifications */
/* @var $form yii\bootstrap\ActiveForm */

$this->title = 'Характеристики ' . $title;

$form = ActiveForm::begin(['layout' => 'horizontal']);

foreach ($model as $key => $one): ?>
    <div class="col-md-6">
    <?php $specification = $specifications[str_replace('field', '', $key)];
        echo $specification->is_options ? 
            $form->field($model, $key)->widget(\dosamigos\multiselect\MultiSelect::className(),[
                'options' => ['multiple' => 'multiple'],
                'data' => \yii\helpers\ArrayHelper::map($specification->specificationOptions, 'id', 'name'),
                'clientOptions' => [
                    'nonSelectedText' => '- выбрать -',
                    'buttonWidth' => '100%',
                    'allSelectedText' => 'Выбрано '
                ]
            ])->label($specification->name) : $form->field($model, $key)->label($specification->name) ?>
    </div>
<?php endforeach; ?>

<div class="clearfix"></div>
<div class="box-footer">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>