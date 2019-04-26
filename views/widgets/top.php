<?php
	
use dosamigos\multiselect\MultiSelect;
use yii\web\JsExpression;

/* @var $this yii\web\View */
?>
<div class="top-navigation col-xs-12">
    <div class="container">
        <div class="row">
            <nav class="navigation-left">
                <div class="item active">
                    <a href="" class="transition">Объявления</a>
                </div>
                <div class="item">
                    <a href="" class="transition">Объявления1</a>
                </div>
                <div class="item">
                    <a href="" class="transition">Объявления1</a>
                </div>
                <div class="item">
                    <a href="" class="transition">Объявления1</a>
                </div>
                <div class="item">
                    <a href="" class="transition">Объявления1</a>
                </div>
                <div class="item">
                    <a href="" class="transition">Объявления1</a>
                </div>
            </nav>  
                        
            <div class="navigation-right hidden-xs">
                <img src="/images/location.svg" class="icon" alt="location icon">
                            
                <span class="country">Беларусь
                            
                <?= MultiSelect::widget([
                    'id' => 'locations',
                    'options' => ['multiple' => 'multiple'],
                    'data' => $regions,
                    'value' => (($locations = $_COOKIE['locations']) !== null ? explode(',', $_COOKIE['locations']) : false),
                    'name' => 'locations',
                    'clientOptions' =>  [
                        'buttonWidth' => '190px',
                        'nSelectedText' => 'Выбрано',
                        'selectAllText' => 'Выбрать все',
                        'nonSelectedText' => 'Любая область',
                        'allSelectedText' => 'Все области',
                        'includeSelectAllOption' => true,
                        'enableCollapsibleOptGroups' => true,
                        'enableClickableOptGroups' => true,
                        'collapseOptGroupsByDefault' => true,
                        'selectAllValue' => 'all',
                        'numberDisplayed' => 2,
                        'onChange' => new JsExpression("function() {
                            var selected = [];
                            $('#locations option:selected').each(function(){
                                selected.push($(this).val());
                            });
                            document.cookie = 'locations=' + selected;
                            $('input[name=locations]').val(selected);
                            filterCount();
                        }"),
                        'onSelectAll' => new JsExpression("function() {
                            var selected = [];
                            $('#locations option').each(function(){
                                selected.push($(this).val());
                            });
                            document.cookie = 'locations=' + selected;
                            $('input[name=locations]').val(selected);
                            filterCount();
                        }")
                   ]
                ]) ?>
                
                </span>
            </div>  
        </div>
    </div>
</div>