<?php

use yii\db\Migration;

/**
 * Class m200422_183423_create_merchants_products
 */
class m200422_183423_create_merchants_products extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('merchant_products', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer(11)->notNull(),
            'vendor_code' => $this->string(255)->defaultValue(NULL),
            'title' => $this->string(300)->notNull(),
            'price' => $this->integer(11)->defaultValue(NULL),
            'old_price' => $this->integer(11)->defaultValue(NULL),
            'image' => $this->string(255)->defaultValue(NULL),
            'quantity' => $this->integer(11)->defaultValue(NULL),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('merchant_products');
    }
}
