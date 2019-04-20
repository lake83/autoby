<?php

use yii\helpers\Url;
use app\components\SiteHelper;

/* @var $this yii\web\View */
/* @var $model app\models\News */

?>
<div class="image" style="background: url('<?= SiteHelper::resized_image($model['image'], 280) ?>')"></div>

<div class="info">
    <span class="time col-xs-12"><?= Yii::$app->formatter->asDate($model['created_at'], 'php:j F Y') ?></span>
    <span class="title col-xs-12"><a href="<?= $url = Url::to(['news/view', 'slug' => $model['slug']]) ?>" class="transition"><?= $model['name'] ?></a></span>
    <p class="description col-xs-12"><?= $model['intro_text'] ?></p>

    <a href="<?= $url ?>" class="read-more transition">Читать дальше <i class="fas fa-angle-right transition"></i></a>
</div>