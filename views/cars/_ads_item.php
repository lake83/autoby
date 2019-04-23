<?php

use yii\helpers\Url;
use app\components\SiteHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Ads */

?>
<div class="list-item col-xs-12">
    <div class="info-wrapper visible-xs">
        <div class="info">
            <a target="_blank" href="<?= $href = Url::to(['cars/view', 'id' => $model->id]) ?>" class="title transition col-xs-12" data-pjax=0><?= $model->carTitle ?></a>
        </div>
                                    
        <div class="price visible-xs">
            <div class="r-price col-xs-12">
                <span>150 000 BYN</span>
            </div>
            <div class="d-price">
                <span>100 000 $</span>
            </div>
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
                    <div class="item">2.2л / Дизель</div>
                    <div class="item">Автомат</div>
                    <div class="item">Минивэн</div>
                </div>
                                            
                <div class="right">
                    <div class="item">Передний</div>
                    <div class="item">Серебристый</div>
                </div>
            </div>
                                        
            <div class="city col-xs-12">
                                            Минск
            </div>
        </div>
                                    
        <div class="price hidden-xs">
            <div class="r-price col-xs-12">
                <span>150 000 BYN</span>
            </div>
            <div class="d-price">
                <span>100 000 $</span>
            </div>
        </div>
                                    
        <div class="year text-center">
                                        2011
        </div>
                                    
        <div class="mileage text-center">
                                        150000 км
        </div>
    </div>
</div>