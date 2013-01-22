<?php

class m130121_130000_admin extends EDbMigration
{
    public function safeUp()
    {
        $options = Yii::app()->db->schema instanceof CMysqlSchema ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8' : '';

        $this->createTable('{{settings}}', array(
                'id'             => 'int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'module_id'      => 'varchar(32) NOT NULL',
                'key'            => 'varchar(32) NOT NULL',
                'value'          => 'varchar(255) NOT NULL',
                'create_user_id' => 'int(11) unsigned NOT NULL',
                'update_user_id' => 'int(11) unsigned DEFAULT NULL',
                'create_time'    => 'timestamp NULL DEFAULT NULL',
                'update_time'    => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
            ),
            $options
        );

        $this->createIndex('ix_{{settings}}_module_id', '{{settings}}', 'module_id', false);
        $this->createIndex('ix_{{settings}}_create_user_id', '{{settings}}', 'create_user_id', false);
        $this->createIndex('ix_{{settings}}_update_user_id', '{{settings}}', 'update_user_id', false);

        if ((Yii::app()->db->schema instanceof CSqliteSchema) == false) {
            $this->addForeignKey('fk_{{settings}}_{{user}}_create_user_id', '{{settings}}', 'create_user_id', '{{user}}', 'id', 'RESTRICT', 'NO ACTION');
            $this->addForeignKey('fk_{{settings}}_{{user}}_update_user_id', '{{settings}}', 'update_user_id', '{{user}}', 'id', 'RESTRICT', 'NO ACTION');
        }
    }

    public function safeDown()
    {
        $this->dropTable('{{settings}}');
    }
}