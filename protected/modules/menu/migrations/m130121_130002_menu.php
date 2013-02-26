<?php

class m130121_130002_menu extends EDbMigration
{
    public function safeUp()
    {
        $options           = Yii::app()->getDb()->getSchema() instanceof CMysqlSchema ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8' : '';
        $onUpdateTimeStamp = Yii::app()->getDb()->getSchema() instanceof CMysqlSchema ? ' ON UPDATE CURRENT_TIMESTAMP' : '';
        $tinyint3           = Yii::app()->getDb()->getSchema() instanceof CPgsqlSchema ? 'smallint' : 'tinyint(3)';
        $tinyint4           = Yii::app()->getDb()->getSchema() instanceof CPgsqlSchema ? 'smallint' : 'tinyint(4)';
        $this->createTable('{{menu}}', array(
                'id'             => 'pk',
                'root'           => 'integer NOT NULL',
                'lft'            => 'integer NOT NULL',
                'rgt'            => 'integer NOT NULL',
                'level'          => $tinyint4.' NOT NULL',
                'code'           => 'varchar(20) NOT NULL DEFAULT \'\'',
                'title'          => 'varchar(100) NOT NULL',
                'href'           => 'varchar(200) NOT NULL DEFAULT \'\'',
                'type'           => $tinyint3.' NOT NULL DEFAULT \'1\'',
                'access'         => 'varchar(50) DEFAULT NULL',
                'status'         => 'boolean NOT NULL DEFAULT \'1\'',
                'create_user_id' => 'integer NOT NULL',
                'update_user_id' => 'integer DEFAULT NULL',
                'create_time'    => 'timestamp NULL DEFAULT NULL',
                'update_time'    => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP' . $onUpdateTimeStamp,
            ),
            $options
        );
        $this->createIndex('ix_{{menu}}_status', '{{menu}}', 'status', false);
        $this->createIndex('ix_{{menu}}_create_user_id', '{{menu}}', 'create_user_id', false);
        $this->createIndex('ix_{{menu}}_update_user_id', '{{menu}}', 'update_user_id', false);
        if ((Yii::app()->getDb()->getSchema() instanceof CSqliteSchema) == false) {
            $this->addForeignKey('fk_{{menu}}_{{user}}_create_user_id', '{{menu}}', 'create_user_id', '{{user}}', 'id', 'CASCADE', 'NO ACTION');
            $this->addForeignKey('fk_{{menu}}_{{user}}_update_user_id', '{{menu}}', 'update_user_id', '{{user}}', 'id', 'CASCADE', 'NO ACTION');
        }
        //menu category
        if (strncasecmp('sqlite', $this->dbConnection->driverName, 6) === 0) {
            $createTime = new CDbExpression("date('now')");
        } else {
            $createTime = new CDbExpression('NOW()');
        }
        echo 'Create "' . Yii::t('menu', 'Верхнее меню') . '"' . PHP_EOL;
        $this->insert('{{menu}}', array(
                'root'           => 1,
                'lft'            => 1,
                'rgt'            => 4,
                'level'          => 1,
                'code'           => 'top',
                'title'          => Yii::t('menu', 'Верхнее меню'),
                'type'           => 1,
                'create_user_id' => 1,
                'create_time'    => $createTime,
        ));
        echo 'Create menu item "' . Yii::t('zii', 'Home') . '"' . PHP_EOL;
        //menu link to index page item
        $this->insert('{{menu}}', array(
                'root'           => 1,
                'lft'            => 2,
                'rgt'            => 3,
                'level'          => 2,
                'title'          => Yii::t('zii', 'Home'),
                'href'           => '/page/index/',
                'type'           => 1,
                'create_user_id' => 1,
                'create_time'    => $createTime,
            ));
    }

    public function safeDown()
    {
        $this->dropTable('{{menu}}');
    }
}