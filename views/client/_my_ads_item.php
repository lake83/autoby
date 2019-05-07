<?php

use yii\helpers\Url;
use app\components\SiteHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Ads */

?>
<li class="list-item col-xs-12">
    <div class="image" style="background: url('<?= SiteHelper::resized_image($model->image[0], 300) ?>')"></div>
                                            
    <div class="info">
        <span class="number col-xs-12">№ <?= $model->id ?></span>
                                                
        <span class="title col-xs-12"><a href="<?= Url::to(['cars/view', 'id' => $model->id]) ?>" data-pjax=0><?= $model->carTitle ?></a></span>
                                                
        <div class="price col-xs-12"><?= $model->issue_year ?>, <span class="r-price"><?= round($model->price * SiteHelper::exchangeRate()) ?> BYN</span> <span class="d-price"><?= $model->price ?> $</span></div>
                                                
    </div>
                                            
    <div class="actions">
        <div class="action-wrap">
            <a href="<?= Url::to(['client/update', 'id' => $model->id]) ?>" class="edit transition" data-pjax=0>Изменить</a>
        </div>
                                                
        <div class="action-wrap">
            <a href="<?= Url::to(['client/delete', 'id' => $model->id]) ?>" class="delete transition" data-method="post" data-pjax=0 data-confirm="Вы уверены, что хотите удалить это объявление?">Удалить</a>
        </div>
    </div>
</li>