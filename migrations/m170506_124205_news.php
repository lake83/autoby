<?php

use yii\db\Migration;

class m170506_124205_news extends Migration
{
    public function up()
    {
        $this->createTable('news', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'image' => $this->string(100)->notNull(),
            'intro_text' => $this->text()->notNull(),
            'full_text' => $this->text()->notNull(),
            'title' => $this->string()->notNull(),
            'keywords' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'is_active' => $this->boolean()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ], $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB' : null);
    }

    public function down()
    {
        $this->dropTable('materials');
    }
}
