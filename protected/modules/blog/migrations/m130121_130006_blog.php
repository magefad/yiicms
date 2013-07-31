<?php

class m130121_130006_blog extends EDbMigration
{
    public function safeUp()
    {
        $options           = Yii::app()->getDb()->getSchema() instanceof CMysqlSchema ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8' : '';
        $onUpdateTimeStamp = Yii::app()->getDb()->getSchema() instanceof CMysqlSchema ? ' ON UPDATE CURRENT_TIMESTAMP' : '';
        $tinyint           = Yii::app()->getDb()->getSchema() instanceof CPgsqlSchema ? 'smallint' : 'tinyint(1)';

        $this->createTable('{{blog}}', array(
                'id'             => 'pk',
                'title'          => 'varchar(75) NOT NULL',
                'keywords'       => 'varchar(200) NOT NULL',
                'description'    => 'varchar(200) NOT NULL',
                'slug'           => 'varchar(75) NOT NULL',
                'type'           => 'boolean NOT NULL DEFAULT \'1\'',
                'status'         => $tinyint.' NOT NULL DEFAULT \'1\'',
                'create_user_id' => 'integer NOT NULL',
                'update_user_id' => 'integer DEFAULT NULL',
                'create_time'    => 'timestamp NULL DEFAULT NULL',
                'update_time'    => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP' . $onUpdateTimeStamp
            ),
            $options
        );
        $this->createIndex('ux_{{blog}}_slug', '{{blog}}', 'slug', true);
        $this->createIndex('ix_{{blog}}_type', '{{blog}}', 'type', false);
        $this->createIndex('ix_{{blog}}_status', '{{blog}}', 'status', false);
        $this->createIndex('ix_{{blog}}_create_user_id', '{{blog}}', 'create_user_id', false);
        $this->createIndex('ix_{{blog}}_update_user_id', '{{blog}}', 'update_user_id', false);
        if ((Yii::app()->getDb()->getSchema() instanceof CSqliteSchema) == false) {
            $this->addForeignKey('fk_{{blog}}_{{user}}_create_user_id', '{{blog}}', 'create_user_id', '{{user}}', 'id', 'CASCADE', 'NO ACTION');
            $this->addForeignKey('fk_{{blog}}_{{user}}_update_user_id', '{{blog}}', 'update_user_id', '{{user}}', 'id', 'CASCADE', 'NO ACTION');
        }

        $this->createTable('{{blog_post}}', array(
                'id'             => 'pk',
                'blog_id'        => 'integer NOT NULL',
                'title'          => 'varchar(75) NOT NULL',
                'keywords'       => 'varchar(200) NOT NULL',
                'description'    => 'varchar(200) NOT NULL',
                'content'        => 'text NOT NULL',
                'slug'           => 'varchar(75) NOT NULL',
                'link'           => 'varchar(200) NOT NULL DEFAULT \'\'',
                'status'         => $tinyint.' NOT NULL DEFAULT \'1\'',
                'comment_status' => 'boolean NOT NULL DEFAULT \'1\'',
                'access_type'    => 'boolean NOT NULL DEFAULT \'1\'',
                'create_user_id' => 'integer NOT NULL',
                'update_user_id' => 'integer DEFAULT NULL',
                'publish_time'   => 'timestamp NULL DEFAULT NULL',
                'create_time'    => 'timestamp NULL DEFAULT NULL',
                'update_time'    => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP' . $onUpdateTimeStamp
            ),
            $options
        );
        $this->createIndex('ux_{{blog_post}}_slug', '{{blog_post}}', 'slug', true);
        $this->createIndex('ix_{{blog_post}}_blog_id', '{{blog_post}}', 'blog_id', false);
        $this->createIndex('ix_{{blog_post}}_status', '{{blog_post}}', 'status', false);
        $this->createIndex('ix_{{blog_post}}_comment_status', '{{blog_post}}', 'comment_status', false);
        $this->createIndex('ix_{{blog_post}}_access_type', '{{blog_post}}', 'access_type', false);
        $this->createIndex('ix_{{blog_post}}_create_user_id', '{{blog_post}}', 'create_user_id', false);
        $this->createIndex('ix_{{blog_post}}_update_user_id', '{{blog_post}}', 'update_user_id', false);
        if ((Yii::app()->getDb()->getSchema() instanceof CSqliteSchema) == false) {
            $this->addForeignKey('fk_{{blog_post}}_{{blog}}_blog_id', '{{blog_post}}', 'blog_id', '{{blog}}', 'id', 'CASCADE', 'NO ACTION');
            $this->addForeignKey('fk_{{blog_post}}_{{user}}_create_user_id', '{{blog_post}}', 'create_user_id', '{{user}}', 'id', 'RESTRICT', 'NO ACTION');
            $this->addForeignKey('fk_{{blog_post}}_{{user}}_update_user_id', '{{blog_post}}', 'update_user_id', '{{user}}', 'id', 'RESTRICT', 'NO ACTION');
        }

        $this->createTable('{{user_blog}}', array(
                'id'             => 'pk',
                'user_id'        => 'integer NOT NULL',
                'blog_id'        => 'integer NOT NULL',
                'role'           => $tinyint.' NOT NULL DEFAULT \'1\'',
                'status'         => 'boolean NOT NULL DEFAULT \'1\'',
                'note'           => 'string NOT NULL DEFAULT \'\'',
                'create_time'    => 'timestamp NULL DEFAULT NULL',
                'update_time'    => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP' . $onUpdateTimeStamp
            ),
            $options
        );
        $this->createIndex('ux_{{user_blog}}_user_id_blog_id', '{{user_blog}}', 'user_id,blog_id', true);
        $this->createIndex('ix_{{user_blog}}_blog_user_id', '{{user_blog}}', 'user_id', false);
        $this->createIndex('ix_{{user_blog}}_blog_blog_id', '{{user_blog}}', 'blog_id', false);
        if ((Yii::app()->getDb()->getSchema() instanceof CSqliteSchema) == false) {
            $this->addForeignKey('fk_{{user_blog}}_{{user}}_user_id', '{{user_blog}}', 'user_id', '{{user}}', 'id', 'CASCADE', 'NO ACTION');
            $this->addForeignKey('fk_{{user_blog}}_{{blog}}_blog_id', '{{user_blog}}', 'blog_id', '{{blog}}', 'id', 'CASCADE', 'NO ACTION');
        }

        $this->createTable('{{tag}}', array(
                'id'   => 'pk',
                'name' => 'string NOT NULL',
            ),
            $options
        );
        $this->createIndex('ux_tag_name', '{{tag}}', 'name', true);

        $this->createTable('{{blog_post_tag}}', array(
                'post_id' => 'integer NOT NULL',
                'tag_id'  => 'integer NOT NULL',
                'PRIMARY KEY (post_id, tag_id)'
            ),
            $options
        );
        $this->createIndex('ix_{{blog_post_tag}}_post_id', '{{blog_post_tag}}', 'post_id', false);
        $this->createIndex('ix_{{blog_post_tag}}_tag_id', '{{blog_post_tag}}', 'tag_id', false);
        if ((Yii::app()->getDb()->getSchema() instanceof CSqliteSchema) == false) {
            $this->addForeignKey('fk_{{blog_post_tag}}_{{blog_post}}_post_id', '{{blog_post_tag}}', 'post_id', '{{blog_post}}', 'id', 'CASCADE', 'NO ACTION');
            $this->addForeignKey('fk_{{blog_post_tag}}_{{tag}}_tag_id', '{{blog_post_tag}}', 'tag_id', '{{tag}}', 'id', 'CASCADE', 'NO ACTION');
        }
    }

    public function safeDown()
    {
        $this->dropTable('{{blog_post_tag}}');
        $this->dropTable('{{tag}}');
        $this->dropTable('{{user_blog}}');
        $this->dropTable('{{blog_post}}');
        $this->dropTable('{{blog}}');
    }
}