<?php
app\assets\AdminAsset::register($this);

/* @var $this \yii\web\View */
/* @var $content string */

?>
<aside class="main-sidebar">
    <section class="sidebar">
<?= dmstr\widgets\Menu::widget([
    'options' => ['class' => 'sidebar-menu', 'data-widget' => 'tree'],
    'encodeLabels' => false,
    'items' => [
        ['label' => 'Пользователи', 'url' => ['/admin/user/index'], 'icon' => 'users'],
        ['label' => 'Новости', 'url' => ['/admin/news/index'], 'icon' => 'book'],
        ['label' => 'Каталог', 'url' => ['/admin/catalog/index'], 'icon' => 'table']
    ]
]);	
?>
    </section>
</aside>