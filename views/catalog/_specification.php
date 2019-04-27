<?php

/* @var $this yii\web\View */
/* @var $model app\models\Specifications */

$params = Yii::$app->params;
$capacity = strpos($model['capacity'], '.') === false ? $model['capacity'] . '.0' : $model['capacity'];
?>
<div class="modification col-xs-12">
    <span class="title col-xs-12">Модификация <?= $capacity . ' ' . $params['transmission']['short'][$model['transmission']] ?></span>
                                
    <div class="specifications col-xs-12">
        <div class="specification col-xs-6">
            <span class="text col-xs-12">Объем</span>
            <span class="value col-xs-12"><?= $capacity ?> л</span>
        </div>
        
        <?php if ($model['fuel']): ?>
                                    
        <div class="specification col-xs-6">
            <span class="text col-xs-12">Топливо</span>
            <span class="value col-xs-12"><?= $fuel = $params['fuel']['options'][$model['fuel']] ?></span>
        </div>
        
        <?php endif ?>
                                    
        <div class="specification col-xs-6">
            <span class="text col-xs-12">Мощность</span>
            <span class="value col-xs-12"><?= $model['power'] ?> л.с.</span>
        </div>
                                    
        <div class="specification col-xs-6">
            <span class="text col-xs-12">Привод</span>
            <span class="value col-xs-12"><?= $drive = mb_strtolower($params['drive']['options'][$model['drive']]) ?></span>
        </div>
                                    
        <div class="specification col-xs-6">
            <span class="text col-xs-12">Коробка</span>
            <span class="value col-xs-12"><?= $transmission = mb_strtolower($params['transmission']['options'][$model['transmission']]) ?></span>
        </div>
                                    
        <?php if ($model['racing']): ?>
        
        <div class="specification col-xs-6">
            <span class="text col-xs-12">Разгон</span>
            <span class="value col-xs-12"><?= $model['racing'] ?> с</span>
        </div>
        
        <?php endif ?>
                                    
        <div class="specification col-xs-6">
            <span class="text col-xs-12">Тип двигателя</span>
            <span class="value col-xs-12"><?= $engine = mb_strtolower($params['engine']['options'][$model['engine']]) ?></span>
        </div>
        
        <?php if ($model['consumption']): ?>
                                    
        <div class="specification col-xs-6">
            <span class="text col-xs-12">Расход</span>
            <span class="value col-xs-12"><?= $model['consumption'] ?> л</span>
        </div>
        
        <?php endif ?>
    </div>
</div>
                            
<div class="characteristics col-xs-12">
    <div class="column col-xs-12 col-sm-6">
        <div class="characteristic col-xs-12">
            <span class="title col-xs-12">Общая информация</span>

            <?php if ($model['country']): ?>
            
            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Страна марки</span>
                <span class="value col-xs-6"><?= $model['country'] ?></span>
            </div>
            
            <?php endif;
            if ($model['class']): ?>

            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Класс автомобиля</span>
                <span class="value col-xs-6"><?= strtoupper($model['class']) ?></span>
            </div>
            
            <?php endif;
            if ($model['doors']): ?>

            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Количество дверей</span>
                <span class="value col-xs-6"><?= $model['doors'] ?></span>
            </div>
            
            <?php endif;
            if ($model['seats']): ?>

            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Количество мест</span>
                <span class="value col-xs-6"><?= $model['seats'] ?></span>
            </div>
            
            <?php endif ?>
            
        </div>
                                    
        <div class="characteristic col-xs-12">
            <span class="title col-xs-12">Размеры<span class="param">, мм</span></span>

            <?php if ($model['width']): ?>
            
            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Длина</span>
                <span class="value col-xs-6"><?= $model['width'] ?></span>
            </div>
            
            <?php endif;
            if ($model['length']): ?>

            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Ширина</span>
                <span class="value col-xs-6"><?= $model['length'] ?></span>
            </div>
            
            <?php endif;
            if ($model['height']): ?>

            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Высота</span>
                <span class="value col-xs-6"><?= $model['height'] ?></span>
            </div>
            
            <?php endif;
            if ($model['wheelbase']): ?>

            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Колёсная база</span>
                <span class="value col-xs-6"><?= $model['wheelbase'] ?></span>
            </div>
            
            <?php endif;
            if ($model['clearance']): ?>
                                        
            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Клиренс</span>
                <span class="value col-xs-6"><?= $model['clearance'] ?></span>
            </div>
            
            <?php endif;
            if ($model['front_track']): ?>
                                        
            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Ширина передней колеи</span>
                <span class="value col-xs-6"><?= $model['front_track'] ?></span>
            </div>
            
            <?php endif;
            if ($model['rear_track']): ?>
                                        
            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Ширина задней колеи</span>
                <span class="value col-xs-6"><?= $model['rear_track'] ?></span>
            </div>
            
            <?php endif;
            if ($model['wheel_size']): ?>
                                        
            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Размер колёс</span>
                <span class="value col-xs-6"><?= $model['wheel_size'] ?></span>
            </div>
            
            <?php endif ?>
            
        </div>
                                    
        <div class="characteristic col-xs-12">
            <span class="title col-xs-12">Объём и масса</span>

            <?php if ($model['luggage_capacity']): ?>
            
            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Объем багажника, л</span>
                <span class="value col-xs-6"><?= $model['luggage_capacity'] ?></span>
            </div>
            
            <?php endif;
            if ($model['tank_capacity']): ?>

            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Объём топливного бака, л</span>
                <span class="value col-xs-6"><?= $model['tank_capacity'] ?></span>
            </div>
            
            <?php endif;
            if ($model['curb_weight']): ?>

            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Снаряженная масса, кг</span>
                <span class="value col-xs-6"><?= $model['curb_weight'] ?></span>
            </div>
            
            <?php endif;
            if ($model['full_weight']): ?>

            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Полная масса, кг</span>
                <span class="value col-xs-6"><?= $model['full_weight'] ?></span>
            </div>
            
            <?php endif ?>
            
        </div>
                                    
        <div class="characteristic col-xs-12">
            <span class="title col-xs-12">Трансмиссия</span>

            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Коробка передач</span>
                <span class="value col-xs-6"><?= $transmission ?></span>
            </div>
            
            <?php if ($model['gears']): ?>

            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Количество передач</span>
                <span class="value col-xs-6"><?= $model['gears'] ?></span>
            </div>
            
            <?php endif ?>

            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Тип привода</span>
                <span class="value col-xs-6"><?= $drive ?></span>
            </div>
            
        </div>
                                    
        <div class="characteristic col-xs-12">
            <span class="title col-xs-12">Подвеска и тормоза</span>

            <?php if ($model['front_suspension']): ?>
            
            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Тип передней подвески</span>
                <span class="value col-xs-6"><?= mb_strtolower($params['suspension']['options'][$model['front_suspension']]) ?></span>
            </div>
            
            <?php endif;
            if ($model['rear_suspension']): ?>

            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Тип задней подвески</span>
                <span class="value col-xs-6"><?= mb_strtolower($params['suspension']['options'][$model['rear_suspension']]) ?></span>
            </div>
            
            <?php endif;
            if ($model['front_brakes']): ?>

            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Передние тормоза</span>
                <span class="value col-xs-6"><?= mb_strtolower($params['brakes']['options'][$model['front_brakes']]) ?></span>
            </div>
            
            <?php endif;
            if ($model['rear_brakes']): ?>

            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Задние тормоза</span>
                <span class="value col-xs-6"><?= mb_strtolower($params['brakes']['options'][$model['rear_brakes']]) ?></span>
            </div>
            
            <?php endif ?>
            
        </div>
    </div>
                                
    <div class="column col-xs-12 col-sm-6">
        <div class="characteristic col-xs-12">
            <span class="title col-xs-12">Эксплуатационные показатели</span>

            <?php if ($model['max_speed']): ?>
            
            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Максимальная скорость, км/ч</span>
                <span class="value col-xs-6"><?= $model['max_speed'] ?></span>
            </div>
            
            <?php endif;
            if ($model['racing']): ?>

            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Разгон до 100 км/ч, с</span>
                <span class="value col-xs-6"><?= $model['racing'] ?></span>
            </div>
            
            <?php endif;
            if ($model['consumption_all']): ?>

            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Расход топлива, л город/трасса/смешанный</span>
                <span class="value col-xs-6"><?= $model['consumption_all'] ?></span>
            </div>
            
            <?php endif;
            if ($model['fuel']): ?>

            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Марка топлива</span>
                <span class="value col-xs-6"><?= $fuel ?></span>
            </div>
            
            <?php endif;
            if ($model['environmental_class']): ?>
                                        
            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Экологический класс</span>
                <span class="value col-xs-6"><?= mb_strtolower($params['environmental_class']['options'][$model['environmental_class']]) ?></span>
            </div>
            
            <?php endif ?>
            
        </div>
                                    
        <div class="characteristic col-xs-12">
            <span class="title col-xs-12">Двигатель</span>

            <?php if ($engine): ?>
            
            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Тип двигателя</span>
                <span class="value col-xs-6"><?= $engine ?></span>
            </div>
            
            <?php endif;
            if ($model['engine_location']): ?>

            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Расположение двигателя</span>
                <span class="value col-xs-6"><?= mb_strtolower($params['engine_location']['options'][$model['engine_location']]) ?></span>
            </div>
            
            <?php endif;
            if ($model['engine_capacity']): ?>

            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Объем двигателя, см³</span>
                <span class="value col-xs-6"><?= $model['engine_capacity'] ?></span>
            </div>
            
            <?php endif;
            if ($model['boost_type']): ?>

            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Тип наддува</span>
                <span class="value col-xs-6"><?= mb_strtolower($params['boost_type']['options'][$model['boost_type']]) ?></span>
            </div>
            
            <?php endif;
            if ($model['max_power']): ?>

            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Максимальная мощность, л.с./кВт при об/мин</span>
                <span class="value col-xs-6"><?= $model['max_power'] ?></span>
            </div>
            
            <?php endif;
            if ($model['max_torque']): ?>

            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Максимальный крутящий момент, Н*м при об/мин</span>
                <span class="value col-xs-6"><?= $model['max_torque'] ?></span>
            </div>
            
            <?php endif;
            if ($model['cylinder_location']): ?>
                                        
            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Расположение цилиндров</span>
                <span class="value col-xs-6"><?= $params['cylinder_location']['options'][$model['cylinder_location']] ?></span>
            </div>
            
            <?php endif;
            if ($model['cylinders_number']): ?>
                                        
            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Количество цилиндров</span>
                <span class="value col-xs-6"><?= $model['cylinders_number'] ?></span>
            </div>
            
            <?php endif;
            if ($model['cylinder_valves']): ?>
                                        
            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Число клапанов на цилиндр</span>
                <span class="value col-xs-6"><?= $model['cylinder_valves'] ?></span>
            </div>
            
            <?php endif;
            if ($model['power_system']): ?>
                                        
            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Система питания двигателя</span>
                <span class="value col-xs-6"><?= mb_strtolower($params['power_system']['options'][$model['power_system']]) ?></span>
            </div>
            
            <?php endif;
            if ($model['compression']): ?>
                                        
            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Степень сжатия</span>
                <span class="value col-xs-6"><?= $model['compression'] ?></span>
            </div>
            
            <?php endif;
            if ($model['bore_stroke']): ?>
                                        
            <div class="characteristic-item col-xs-12">
                <span class="text col-xs-6">Диаметр цилиндра и ход поршня, мм</span>
                <span class="value col-xs-6"><?= $model['bore_stroke'] ?></span>
            </div>
            
            <?php endif ?>
            
        </div>
    </div>
</div>