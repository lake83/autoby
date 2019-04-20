<?php

use yii\db\Migration;

/**
 * Class m190417_182528_pages
 */
class m190417_182528_pages extends Migration
{
    public function up()
    {
        $this->createTable('pages', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'content' => $this->text()->notNull(),
            'title' => $this->string()->notNull(),
            'keywords' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'is_active' => $this->boolean()->defaultValue(1)
        ], $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB' : null);
    }

    public function down()
    {
        $this->dropTable('pages');
    }
}