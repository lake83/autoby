<?php

use yii\db\Migration;

/**
 * Class m190316_132852_specifications
 */
class m190316_132852_specifications extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('specifications', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'is_options' => $this->boolean()->defaultValue(0),
            'is_active' => $this->boolean()->defaultValue(1),
        ], $tableOptions);
        
        $this->createTable('specification_options', [
            'id' => $this->primaryKey(),
            'specification_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'is_active' => $this->boolean()->defaultValue(1),
        ], $tableOptions);
        
        $this->createIndex('idx-specification_options_id', 'specification_options', 'specification_id');
        $this->addForeignKey('specification_options_ibfk_1', 'specification_options', 'specification_id', 'specifications', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('specification_options_ibfk_1', 'specification_options');
        $this->dropIndex('idx-specification_options_id', 'specification_options');
        
        $this->dropTable('specifications');
        $this->dropTable('specification_options');
    }
}