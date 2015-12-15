<?php

use yii\db\Schema;
use yii\db\Migration;

class m151211_091359_create_order_details_table extends Migration
{

    public function up()
    {
        // Таблица "Детали заказа"
        // ID товара - integer notNull
        // ID заказа - integer notNull
        // Количество - integer notNull
        // Статус елемента заказа (не путать со статусом всего заказа!) - integer notNull
        // Цена товара (на момент заказа) - float(12,2)
        $this->createTable('{{order_details}}', [
            'product_id' => $this->integer()->notNull(),
            'order_id' => $this->integer()->notNull(),
            'quantity' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
            'price' => $this->float(12, 2)->notNull(),
        ]);
    }

    public function down()
    {
        if ($this->db->schema->getTableSchema('{{order_details}}', true) !== null) {
            $this->dropTable('{{order_details}}');
        }
    }

}
