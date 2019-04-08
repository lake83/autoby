<?php

use yii\db\Migration;

/**
 * Class m190329_123907_modifications
 */
class m190329_123907_modifications extends Migration
{
    public function up()
    {
        $this->createTable('modifications', [
            'id' => $this->primaryKey(),
            'catalog_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'image' => $this->text()->notNull(),
            'is_active' => $this->boolean()->defaultValue(1)
        ], $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB' : null);
        
        $this->createIndex('idx-modifications', 'modifications', 'catalog_id');
        $this->addForeignKey('modifications_ibfk_1', 'modifications', 'catalog_id', 'catalog', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('modifications_ibfk_1', 'modifications');
        $this->dropIndex('idx-modifications', 'modifications');
        
        $this->dropTable('modifications');
    }
}
