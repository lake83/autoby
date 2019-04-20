<?php 

/* @var $data app\models\Catalog */
/* @var $depth string */

if ($data): ?>

<section class="car-marks col-xs-12">
                            
    <?php foreach (array_slice($data, 0, 24) as $item): ?>
                            
    <div class="car-mark">
        <a href="<?= $item['id'] ?>"><span class="title transition"><?= $item['name'] ?></span> <span class="count"><?= 0 ?></span></a>
    </div>
                            
    <?php endforeach;
    if (count($data) > 24): ?>
                            
    <div class="car-mark show-all">
        <span class="title transition">Все модели</span> <i class="fas fa-angle-right transition"></i>
    </div>
    
    <?php endif; ?>
    
</section>

<?php if ($data = array_slice($data, 25)): ?>
                        
<section class="car-marks all col-xs-12">
                            
    <?php foreach ($data as $item): ?>
                            
    <div class="car-mark">
        <a href="<?= $item['id'] ?>"><span class="title transition"><?= $item['name'] ?></span> <span class="count"><?= 0 ?></span></a>
    </div>
                            
    <?php endforeach ?>
                            
</section>
                        
<?php endif; endif; ?>