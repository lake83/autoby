<?php

use yii\db\Migration;

/**
 * Class m190317_103814_ads
 */
class m190317_103814_ads extends Migration
{
    public function up()
    {
        $this->createTable('ads', [
            'id' => $this->primaryKey(),
            'catalog_id' => $this->integer()->notNull(),
            'issue_year' => $this->string(4)->notNull(),
            'capacity' => $this->float()->notNull(),
            'type' => $this->integer()->notNull(),
            'modification' => $this->string()->notNull(),
            'condition' => $this->integer()->notNull()->defaultValue(1)->comment('1-С пробегом,2-С повреждениями,3-На запчасти'),
            'price' => $this->float()->notNull(),
            'text' => $this->text()->notNull(),
            'engine_type' => $this->integer()->notNull(),
            'mileage' => $this->integer()->notNull(),
            'transmission' => $this->integer()->notNull(),
            'drive_type' => $this->integer()->notNull(),
            'doors' => $this->integer(1)->notNull(),
            'color' => $this->integer()->notNull(),
            'image' => $this->text()->notNull(),
            'city' => $this->integer()->notNull(),
            'seller_name' => $this->string()->notNull(),
            'phones' => $this->string()->notNull(),
            'is_active' => $this->boolean()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ], $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB' : null);
    }

    public function down()
    {
        $this->dropTable('ads');
    }
}