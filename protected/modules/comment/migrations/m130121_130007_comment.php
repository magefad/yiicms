<?php

class m130121_130007_comment extends EDbMigration
{
    public function safeUp()
    {
        $options           = Yii::app()->db->schema instanceof CMysqlSchema ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8' : '';
        $onUpdateTimeStamp = Yii::app()->db->schema instanceof CMysqlSchema ? ' ON UPDATE CURRENT_TIMESTAMP' : '';

        $this->createTable('{{comment}}', array(
                'id'             => 'pk',
                'model'          => 'varchar(16) NOT NULL',
                'model_id'       => 'integer NOT NULL',
                'content'        => 'text NOT NULL',
                'ip'             => 'varchar(20) DEFAULT NULL',
                'status'         => 'tinyint(1) NOT NULL DEFAULT "1"',
                'username'       => 'varchar(20) DEFAULT NULL',
                'create_user_id' => 'integer DEFAULT NULL',
                'update_user_id' => 'integer DEFAULT NULL',
                'create_time'    => 'timestamp NULL DEFAULT NULL',
                'update_time'    => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP' . $onUpdateTimeStamp
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