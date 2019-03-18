<?php

use yii\db\Migration;

class m160920_101728_location extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('region', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'is_active' => $this->boolean()->defaultValue(1)
        ], $tableOptions);
        
        $this->createTable('city', [
            'id' => $this->primaryKey(),
            'region_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'is_active' => $this->boolean()->defaultValue(1)
        ], $tableOptions);
        
        $this->createIndex('idx-city', 'city', 'region_id');
        $this->addForeignKey('city_ibfk_1', 'city', 'region_id', 'region', 'id', 'CASCADE');
    }
    
    public function safeDown()
    {
        $this->dropForeignKey('city_ibfk_1', 'city');
        $this->dropIndex('idx-city', 'city');
        
        $this->dropTable('region');
        $this->dropTable('city');     
    }
}
