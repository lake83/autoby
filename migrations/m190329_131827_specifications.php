<?php

use yii\db\Migration;

/**
 * Class m190329_131827_specifications
 */
class m190329_131827_specifications extends Migration
{
    public function up()
    {
        $this->createTable('specifications', [
            'id' => $this->primaryKey(),
            'modification_id' => $this->integer()->notNull(),
            'capacity' => $this->float()->notNull(),
            'power' => $this->integer()->notNull(),
            'transmission' => $this->string()->notNull(),
            'engine' => $this->string()->notNull(),
            'fuel' => $this->string()->notNull(),
            'drive' => $this->string()->notNull(),
            'racing' => $this->float()->notNull(),
            'consumption' => $this->float()->notNull(),
            'country' => $this->string()->notNull(),
            'class' => $this->string(1)->notNull(),
            'doors' => $this->integer(1)->notNull(),
            'seats' => $this->string(1)->notNull(),
            'length' => $this->integer()->notNull(),
            'width' => $this->integer()->notNull(),
            'height' => $this->integer()->notNull(),
            'wheelbase' => $this->integer()->notNull(),
            'clearance' => $this->integer()->notNull(),
            'front_track' => $this->integer()->notNull(),
            'rear_track' => $this->integer()->notNull(),
            'wheel_size' => $this->string()->notNull(),
            'luggage_capacity' => $this->integer()->notNull(),
            'tank_capacity' => $this->integer()->notNull(),
            'curb_weight' => $this->integer()->notNull(),
            'full_weight' => $this->integer()->notNull(),
            'gears' => $this->integer(1)->notNull(),
            'front_suspension' => $this->string()->notNull(),
            'rear_suspension' => $this->string()->notNull(),
            'front_brakes' => $this->string()->notNull(),
            'rear_brakes' => $this->string()->notNull(),
            'max_speed' => $this->integer()->notNull(),
            'consumption_all' => $this->string(20)->notNull(),
            'environmental_class' => $this->string(20)->notNull(),
            'emissions' => $this->integer()->notNull(),
            'engine_location' => $this->string()->notNull(),
            'engine_capacity' => $this->integer()->notNull(),
            'boost_type' => $this->string()->notNull(),
            'max_power' => $this->string()->notNull(),
            'max_torque' => $this->string()->notNull(),
            'cylinder_location' => $this->string()->notNull(),
            'cylinders_number' => $this->integer(2)->notNull(),
            'cylinder_valves' => $this->integer()->notNull(),
            'power_system' => $this->string()->notNull(),
            'compression' => $this->float()->notNull(),
            'bore_stroke' => $this->string()->notNull(),
            'is_active' => $this->boolean()->defaultValue(1)
        ], $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB' : null);
        
        $this->createIndex('idx-specifications', 'specifications', 'modification_id');
        $this->addForeignKey('specifications_ibfk_1', 'specifications', 'modification_id', 'modifications', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('specifications_ibfk_1', 'specifications');
        $this->dropIndex('idx-specifications', 'specifications');
        
        $this->dropTable('specifications');
    }
}
