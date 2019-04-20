<?php

use yii\db\Migration;

class m170516_115013_catalog extends Migration
{
    public function up()
    {
        $this->createTable('catalog', [
            'id' => $this->primaryKey(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'year_from' => $this->string(4)->notNull(),
            'year_to' => $this->string(4)->notNull(),
            'popular' => $this->boolean()->defaultValue(0),
            'is_active' => $this->boolean()->defaultValue(1),
        ], $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB' : null);
    }

    public function down()
    {
        $this->dropTable('catalog');
    }
}