<?php

class m130121_130000_menu extends EDbMigration
{
    public function safeUp()
    {
        $options = Yii::app()->db->schema instanceof CMysqlSchema ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8' : '';

        $this->createTable('{{menu}}', array(
                'id'             => 'int(11) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT',
                'root'           => 'int(11) unsigned NOT NULL',
                'lft'            => 'int(11) unsigned NOT NULL',
                'rgt'            => 'int(11) unsigned NOT NULL',
                'level'          => 'smallint(5) unsigned NOT NULL',
                'code'           => 'varchar(20) NOT NULL',
                'title'          => 'varchar(100) NOT NULL',
                'href'           => 'varchar(200) NOT NULL',
                'type'           => 'tinyint(3) unsigned NOT NULL DEFAULT "1"',
                'access'         => 'varchar(50) DEFAULT NULL',
                'status'         => 'tinyint(1) NOT NULL DEFAULT "1"',
                'create_user_id' => 'int(11) unsigned NOT NULL',
                'update_user_id' => 'int(11) unsigned DEFAULT NULL',
                'create_time'    => 'timestamp NULL DEFAULT NULL',
                'update_time'    => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            ),
            $options
        );
        $this->createIndex('ix_{{menu}}_status', '{{menu}}', 'status', false);
        $this->createIndex('ix_{{menu}}_create_user_id', '{{menu}}', 'create_user_id', false);
        $this->createIndex('ix_{{menu}}_update_user_id', '{{menu}}', 'update_user_id', false);
        if ((Yii::app()->db->schema instanceof CSqliteSchema) == false) {
            $this->addForeignKey('fk_{{menu}}_{{user}}_create_user_id', '{{menu}}', 'create_user_id', '{{user}}', 'id', 'CASCADE', 'NO ACTION');
            $this->addForeignKey('fk_{{menu}}_{{user}}_update_user_id', '{{menu}}', 'update_user_id', '{{user}}', 'id', 'CASCADE', 'NO ACTION');
        }
    }

    public function safeDown()
    {
        $this->dropTable('{{menu}}');
    }
}