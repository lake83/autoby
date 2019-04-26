<?php

use yii\helpers\Url;
use app\components\SiteHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Ads */

$params = Yii::$app->params;
?>
<div class="list-item col-xs-12">
    <div class="info-wrapper visible-xs">
        <div class="info">
            <a target="_blank" href="<?= $href = Url::to(['cars/view', 'id' => $model->id]) ?>" class="title transition col-xs-12" data-pjax=0><?= $model->carTitle ?></a>
        </div>
                                    
        <div class="price visible-xs">
            
            <?php $this->beginBlock('price', true) ?>
            
            <div class="r-price col-xs-12">
                <span><?= round($model->price * SiteHelper::exchangeRate()) ?> BYN</span>
            </div>
            <div class="d-price">
                <span><?= $model->price ?> $</span>
            </div>
            
            <?php $this->endBlock() ?>
            
        </div>
    </div>
                               
    <a target="_blank" href="<?= $href ?>" data-pjax=0>
        <div class="image" style="background: url('<?= SiteHelper::resized_image($model->image[0], 300) ?>')"></div>
    </a>
                                
    <div class="info-wrapper">
        <div class="info">
            <a target="_blank" href="<?= $href ?>" class="title transition hidden-xs col-xs-12" data-pjax=0><?= $model->carTitle ?></a>
                                        
            <div class="specifications flex col-xs-12">
                <div class="left">
                    <div class="item"><?= $model->capacity ?> л / <?= $params['engine']['options'][$model->engine_type] ?></div>
                    <div class="item"><?= $params['transmission']['options'][$model->transmission] ?></div>
                    <div class="item"><?= $params['car_body_type']['options'][$model->type] ?></div>
                </div>
                                            
                <div class="right">
                    <div class="item"><?= $params['drive']['options'][$model->drive_type] ?></div>
                    <div class="item"><?= $params['color']['options'][$model->color] ?></div>
                </div>
            </div>
                                        
            <div class="city col-xs-12"><?= $model->city->name ?></div>
        </div>
                                    
        <div class="price hidden-xs"><?= $this->blocks['price'] ?></div>
                                    
        <div class="year text-center"><?= $model->issue_year ?></div>
                                    
        <div class="mileage text-center"><?= $model->mileage ?> км</div>
    </div>
</div>