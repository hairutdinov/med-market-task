<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%role}}`
 */
class m200115_110502_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'firstName' => $this->string(100)->notNull(),
            'lastName' => $this->string(100),
            'email' => $this->string(100)->unique(),
            'login' => $this->string(50)->notNull()->unique(),
            'password' => $this->string(50)->notNull(),
            'role_id' => $this->integer()->notNull()->defaultValue(3),
        ]);

        // creates index for column `role_id`
        $this->createIndex(
            '{{%idx-user-role_id}}',
            '{{%user}}',
            'role_id'
        );

        // add foreign key for table `{{%role}}`
        $this->addForeignKey(
            '{{%fk-user-role_id}}',
            '{{%user}}',
            'role_id',
            '{{%role}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%role}}`
        $this->dropForeignKey(
            '{{%fk-user-role_id}}',
            '{{%user}}'
        );

        // drops index for column `role_id`
        $this->dropIndex(
            '{{%idx-user-role_id}}',
            '{{%user}}'
        );

        $this->dropTable('{{%user}}');
    }
}
