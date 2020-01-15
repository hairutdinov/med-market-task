<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%role}}`.
 */
class m200115_103919_create_role_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%role}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
        ]);
        $this->batchInsert('{{%role}}', ['id', 'name'], [
          [1, 'Администратор'],
          [2, 'Менеджер'],
          [3, 'Покупатель'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%role}}', ['id' => 1]);
        $this->delete('{{%role}}', ['id' => 2]);
        $this->delete('{{%role}}', ['id' => 3]);
        $this->dropTable('{{%role}}');
    }
}
