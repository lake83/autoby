<?php 

/* @var $data app\models\Catalog */
/* @var $count array */

if ($data): ?>

<section class="car-models col-xs-12">
                            
    <?php foreach (array_slice($data, 0, 19) as $item): ?>
                            
    <div class="car-model">
        <a href="<?= $item['id'] ?>"><span class="title transition"><?= $item['name'] ?></span> <span class="count"><?= $count[$item['id']] ?></span></a>
    </div>
                            
    <?php endforeach;
    if (count($data) > 19): ?>
                            
    <div class="car-model show-all">
        <span class="title transition">Все модели</span> <i class="fas fa-angle-right transition"></i>
    </div>
    
    <?php endif; ?>
    
</section>

<?php if ($data = array_slice($data, 25)): ?>
                        
<section class="car-models all col-xs-12">
                            
    <?php foreach ($data as $item): ?>
                            
    <div class="car-model">
        <a href="<?= $item['id'] ?>"><span class="title transition"><?= $item['name'] ?></span> <span class="count"><?= $count[$item['id']] ?></span></a>
    </div>
                            
    <?php endforeach ?>
                            
</section>
                        
<?php endif; endif; ?>