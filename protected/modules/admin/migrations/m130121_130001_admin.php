<?php

class m130121_130001_admin extends EDbMigration
{
    public function safeUp()
    {
        $options           = Yii::app()->getDb()->getSchema() instanceof CMysqlSchema ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8' : '';
        $onUpdateTimeStamp = Yii::app()->getDb()->getSchema() instanceof CMysqlSchema ? ' ON UPDATE CURRENT_TIMESTAMP' : '';

        $this->createTable('{{settings}}', array(
                'id'             => 'pk',
                'module_id'      => 'varchar(32) NOT NULL',
                'key'            => 'varchar(32) NOT NULL',
                'value'          => 'string NOT NULL',
                'create_user_id' => 'integer NOT NULL',
                'update_user_id' => 'integer DEFAULT NULL',
                'create_time'    => 'timestamp NULL DEFAULT NULL',
                'update_time'    => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP' . $onUpdateTimeStamp
            ),
            $options
        );

        $this->createIndex('ix_{{settings}}_module_id', '{{settings}}', 'module_id', false);
        $this->createIndex('ix_{{settings}}_create_user_id', '{{settings}}', 'create_user_id', false);
        $this->createIndex('ix_{{settings}}_update_user_id', '{{settings}}', 'update_user_id', false);

        if ((Yii::app()->getDb()->getSchema() instanceof CSqliteSchema) == false) {
            $this->addForeignKey('fk_{{settings}}_{{user}}_create_user_id', '{{settings}}', 'create_user_id', '{{user}}', 'id', 'RESTRICT', 'NO ACTION');
            $this->addForeignKey('fk_{{settings}}_{{user}}_update_user_id', '{{settings}}', 'update_user_id', '{{user}}', 'id', 'RESTRICT', 'NO ACTION');
        }
    }

    public function safeDown()
    {
        $this->dropTable('{{settings}}');
    }
}