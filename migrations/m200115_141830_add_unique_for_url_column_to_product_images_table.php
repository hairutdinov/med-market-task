<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%product_images}}`.
 */
class m200115_141830_add_unique_for_url_column_to_product_images_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `product_images` ADD UNIQUE(`url`);");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("ALTER TABLE `product_images` DROP INDEX `url`");
    }
}
