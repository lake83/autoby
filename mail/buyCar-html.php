<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BuyCarForm */

?>

<table style="padding:0;background-color:#e5e5e5;width:650px;border-collapse:collapse;border-spacing:0; text-align:center; vertical-align:top; margin:0 auto;">
    <tbody>
        <tr style="padding:0;text-align:center;vertical-align:top;width:100%;" align="center">
            <td>                 
                <h1 style="padding:0 25px;color:#485671;font:400 24px Arial;margin-bottom:35px;margin-top:35px;width:100%;float:left;text-align:left;">Здравствуйте</h1>
                <div style="float: left;width: 60%;">
                    <span style="padding:0 25px;color:#4a5773;font:400 16px Arial;margin-bottom:30px;text-align:left;float:left;width:100%;">Вы получили новую заявку на выкуп автомобиля.</span>
                    <span style="padding:0 25px;color:#4a5773;font:400 16px Arial;margin-bottom:30px;text-align:left;float:left;width:100%;">Данные указанные пользователем:</span>
                    <div style="margin-bottom:30px;float:left;width:100%;margin-left: 25px;">
                        <span style="float:left;color: #4a5773;font:700 16px Arial;margin-right:30px;">Марка:</span>
                        <span style="float:left;color: #4a5773;font:700 16px Arial;margin-right:30px;"><?= $model->brand ?></span>
                    </div>
                    <div style="margin-bottom: 30px;float:left;width:100%;margin-left: 25px;">
                        <span style="float:left;color: #4a5773;font:700 16px Arial;margin-right:30px;">Модель:</span>
                        <span style="float:left;color: #4a5773;font:700 16px Arial;margin-right:30px;"><?= $model->auto_model ?></span>
                    </div>
                    <div style="margin-bottom: 30px;float:left;width:100%;margin-left: 25px;">
                        <span style="float:left;color: #4a5773;font:700 16px Arial;margin-right:30px;">Год выпуска:</span>
                        <span style="float:left;color: #4a5773;font:700 16px Arial;margin-right:30px;"><?= $model->issue_year ?></span>
                    </div>
                    <div style="margin-bottom: 30px;float:left;width:100%;margin-left: 25px;">
                        <span style="float:left;color: #4a5773;font:700 16px Arial;margin-right:30px;">Цена:</span>
                        <span style="float:left;color: #4a5773;font:700 16px Arial;margin-right:30px;"><?= $model->price ?></span>
                    </div>
                    <div style="margin-bottom: 30px;float:left;width:100%;margin-left: 25px;">
                        <span style="float:left;color: #4a5773;font:700 16px Arial;margin-right:30px;">Телефон:</span>
                        <span style="float:left;color: #4a5773;font:700 16px Arial;margin-right:30px;"><?= $model->phone ?></span>
                    </div>
                    
                    <?php if ($model->info): ?>
                    
                    <div style="margin-bottom: 30px;float:left;width:100%;margin-left: 25px;">
                        <span style="float:left;color: #4a5773;font:700 16px Arial;margin-right:30px;">Дополнительная информация:</span>
                        <span style="float:left;color: #4a5773;font:700 16px Arial;margin-right:30px;"><?= $model->info ?></span>
                    </div>
                    
                    <?php endif ?>
                    
                </div>
            </td>
        </tr>
    </tbody>            
</table>