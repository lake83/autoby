<?php

use yii\db\Migration;

/**
 * Class m190316_161033_catalog_specification
 */
class m190316_161033_catalog_specification extends Migration
{
    public function up()
    {
        $this->createTable('catalog_specification', [
            'id' => $this->primaryKey(),
            'catalog_id' => $this->integer()->notNull(),
            'specification_id' => $this->integer()->notNull(),
            'value' => $this->string()->notNull(),
        ], $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB' : null);
        
        $this->createIndex('idx-catalog_id', 'catalog_specification', 'catalog_id');
        $this->addForeignKey('catalog_ibfk_1', 'catalog_specification', 'catalog_id', 'catalog', 'id', 'CASCADE');
        
        $this->createIndex('idx-catalog_specification_id', 'catalog_specification', 'specification_id');
        $this->addForeignKey('catalog_specification_ibfk_1', 'catalog_specification', 'specification_id', 'specifications', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('catalog_ibfk_1', 'catalog_specification');
        $this->dropIndex('idx-catalog_id', 'catalog_specification');
        
        $this->dropForeignKey('catalog_specification_ibfk_1', 'catalog_specification');
        $this->dropIndex('idx-catalog_specification_id', 'catalog_specification');
        
        $this->dropTable('catalog_specification');
    }
}
