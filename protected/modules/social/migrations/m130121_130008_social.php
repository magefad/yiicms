<?php

class m130121_130008_social extends EDbMigration
{
    public function safeUp()
    {
        $options = Yii::app()->getDb()->getSchema() instanceof CMysqlSchema ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8' : '';

        $this->createTable('{{user_social}}', array(
                'id'           => 'string NOT NULL',
                'user_id'      => 'integer NOT NULL',
                'service'      => 'varchar(64) NOT NULL',
                'access_token' => 'string NOT NULL',
                'email'        => 'varchar(150)',
            ),
            $options
        );
        $this->createIndex('ux_{{user_social}}_id', '{{user_social}}', 'id', true);
        $this->createIndex('ix_{{user_social}}_user_id', '{{user_social}}', 'user_id', false);
        if ((Yii::app()->getDb()->getSchema() instanceof CSqliteSchema) == false) {
            $this->addForeignKey('fk_{{user_social}}_{{user}}_user_id', '{{user_social}}', 'user_id', '{{user}}', 'id', 'CASCADE', 'NO ACTION');
        }
    }

    public function safeDown()
    {
        $this->dropTable('{{user_social}}');
    }
}