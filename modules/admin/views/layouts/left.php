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
        ['label' => 'Страницы', 'url' => ['/admin/pages/index'], 'icon' => 'file'],
        ['label' => 'Новости', 'url' => ['/admin/news/index'], 'icon' => 'book'],
        ['label' => 'Каталог', 'url' => ['/admin/catalog/index'], 'icon' => 'table'],
        ['label' => 'Объявления', 'url' => ['/admin/ads/index'], 'icon' => 'shopping-cart'],
        ['label' => 'Геолокация', 'url' => ['/admin/region/index'], 'icon' => 'location-arrow'],
        ['label' => 'Медиабиблиотека', 'url' => ['/admin/media/index'], 'icon' => 'window-restore']
    ]
]);	
?>
    </section>
</aside>