<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AppAsset;

AppAsset::register($this);

$params = Yii::$app->params;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="shortcut icon" href="" type="image/x-icon"> 
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="container-fluid">
    <div class="row">
        <header>
            <div class="container">
                <div class="row">
                    <div class="header col-xs-12">
                        <div class="header-logo">
                           <a href="/"><img src="/images/footer-logo-w.png" style="margin-top: -6px;" alt=""></a>
                        </div>
                        <div class="header-menu-wrapper">
                            <nav class="header-menu">
                                <div class="login visible-xs">
                                    <a href="login.html" class="transition">Войти</a>
                                </div>
                                
                                <div class="add-offer visible-xs">
                                    <a href="product-create.html" class="transition"><i class="fas fa-plus"></i> <span>Продать</span></a>
                                </div>
                               
                                <div class="menu-item transition">
                                    <a href="<?= Url::to(['cars/all']) ?>" class="transition">Автомобили</a>
                                </div>

                                <div class="menu-item transition">
                                    <a href="<?= Url::to(['news/index']) ?>" class="transition">Новости</a>
                                </div>

                                <div class="menu-item transition">
                                    <a href="" class="transition">Каталог</a>
                                </div>
                                
                                <div class="menu-item transition">
                                    <a href="" class="transition">Выкуп авто</a>
                                </div>
                               <div class="footer-menu visible-xs">
                                   
                                   <?php $this->beginBlock('menu', true) ?>
                                   
                                   <div class="menu-item">
                                       <a href="<?= Url::to(['site/page', 'slug' => 'pravila-podaci-obavlenia']) ?>" class="transition">Правила подачи обьявления</a>
                                   </div>
                                   <div class="menu-item">
                                       <a href="<?= Url::to(['site/page', 'slug' => 'razmestit-reklamu']) ?>" class="transition">Разместить рекламу</a>
                                   </div>
                                   <div class="menu-item">
                                       <a href="<?= Url::to(['site/page', 'slug' => 'dileram']) ?>" class="transition">Дилерам</a>
                                   </div>
                                   <div class="menu-item">
                                       <a href="<?= Url::to(['site/page', 'slug' => 'pomosch']) ?>" class="transition">Помощь</a>
                                   </div>
                                   <div class="menu-item">
                                       <a href="<?= Url::to(['site/page', 'slug' => 'obratnaa-svaz']) ?>" class="transition">Обратная связь</a>
                                   </div>
                                   <div class="menu-item">
                                       <a href="<?= Url::to(['site/page', 'slug' => 'o-proekte']) ?>" class="transition">О проекте</a>
                                   </div>
                                   
                                   <?php $this->endBlock() ?>
                               </div>
                            </nav>
                            <div class="header-bg visible-xs"></div>
                        </div>
                        
                        <div class="login hidden-xs">
                            <a href="login.html" class="transition">Войти</a>
                        </div>
                        
                        <div class="add-offer">
                            <a href="product-create.html" class="transition"><i class="fas fa-plus"></i> <span class="hidden-xs">Продать</span></a>
                        </div>
                        
                        <div class="navbar-header visible-xs">
                            <button type="button" class="navbar-toggle collapsed visible-xs visible-sm">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <?= $content ?>
        
        <footer>
            <div class="container">
                <div class="row">
                    <div class="footer text-center col-xs-12">
                       <div class="footer-menu-wrapper hidden-xs col-xs-12">
                           <nav class="footer-menu">
                               
                               <?= $this->blocks['menu'] ?>
                               
                           </nav>
                        </div>   
                       
                       <div class="footer-bottom">
                           <span class="unp">УНП 192598946</span>
                           
                           <div class="footer-logo">
                               <img src="/images/logo.png" alt="logo">
                           </div>
                           
                           <ul class="footer-social-networks">
                               <li class="social-network">
                                   <a href="<?= $params['vk'] ?>" target="_blank" rel="nofollow"><i class="fab fa-vk transition"></i></a>
                               </li>
                               <li class="social-network">
                                   <a href="<?= $params['fb'] ?>" target="_blank" rel="nofollow"><i class="fab fa-facebook-f transition"></i></a>
                               </li>
                               <li class="social-network">
                                   <a href="<?= $params['ok'] ?>" target="_blank" rel="nofollow"><i class="fab fa-odnoklassniki transition"></i></a>
                               </li>
                               <li class="social-network">
                                   <a href="<?= $params['instagram'] ?>" target="_blank" rel="nofollow"><i class="fab fa-instagram transition"></i></a>
                               </li>
                           </ul>
                       </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>    
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>