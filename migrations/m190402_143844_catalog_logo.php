<?php

use yii\db\Migration;

/**
 * Class m190402_143844_catalog_logo
 */
class m190402_143844_catalog_logo extends Migration
{
    public function up()
    {
        $this->createTable('catalog_logo', [
            'id' => $this->primaryKey(),
            'catalog_id' => $this->integer()->notNull(),
            'image' => $this->string()->notNull()
        ], $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB' : null);
        
        $this->createIndex('idx-catalog_logo', 'catalog_logo', 'catalog_id');
        $this->addForeignKey('catalog_logo_ibfk_1', 'catalog_logo', 'catalog_id', 'catalog', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('catalog_logo_ibfk_1', 'catalog_logo');
        $this->dropIndex('idx-catalog_logo', 'catalog_logo');
        
        $this->dropTable('catalog_logo');
    }
}
