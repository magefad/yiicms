<?php

class m130121_130000_comment extends EDbMigration
{
    public function safeUp()
    {
        $options = Yii::app()->db->schema instanceof CMysqlSchema ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8' : '';

        $this->createTable('{{comment}}', array(
                'id'             => 'int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'model'          => 'varchar(16) NOT NULL',
                'model_id'       => 'int(11) unsigned NOT NULL',
                'content'        => 'text NOT NULL',
                'ip'             => 'varchar(20) DEFAULT NULL',
                'status'         => 'enum("not_approved","approved","spam","deleted") NOT NULL DEFAULT "approved"',
                'username'       => 'varchar(20) DEFAULT NULL',
                'create_user_id' => 'int(11) unsigned DEFAULT NULL',
                'update_user_id' => 'int(11) unsigned DEFAULT NULL',
                'create_time'    => 'timestamp NULL DEFAULT NULL',
                'update_time'    => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
            ),
            $options
        );
        $this->createIndex('ix_{{comment}}_status', '{{comment}}', 'status', false);
        $this->createIndex('ix_{{comment}}_create_user_id', '{{comment}}', 'create_user_id', false);
        $this->createIndex('ix_{{comment}}_update_user_id', '{{comment}}', 'update_user_id', false);
        if ((Yii::app()->db->schema instanceof CSqliteSchema) == false) {
            $this->addForeignKey('fk_{{comment}}_{{user}}_create_user_id', '{{comment}}', 'create_user_id', '{{user}}', 'id', 'CASCADE', 'NO ACTION');
            $this->addForeignKey('fk_{{comment}}_{{user}}_update_user_id', '{{comment}}', 'update_user_id', '{{user}}', 'id', 'NO ACTION', 'NO ACTION');
        }
    }

    public function safeDown()
    {
        $this->dropTable('{{comment}}');
    }
}