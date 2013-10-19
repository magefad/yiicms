<?php
/**
 * Class m130816_104840_addType
 * Added new type of Page statusType - article (annotation, photo, view articles as catalog)
 */
class m131019_111347_addTypeArticle extends EDbMigration
{
    public function safeUp()
    {
        $after = Yii::app()->getDb()->getSchema() instanceof CMysqlSchema ? ' AFTER description' : '';//sqlite not support AFTER
        $this->addColumn('{{page}}', 'annotation', 'varchar(400) NOT NULL' . $after);

        $after = Yii::app()->getDb()->getSchema() instanceof CMysqlSchema ? ' AFTER slug' : '';
        $this->addColumn('{{page}}', 'image', 'varchar(300) NOT NULL' . $after);
    }

    public function safeDown()
    {
        $this->dropColumn('{{page}}', 'annotation');
        $this->dropColumn('{{page}}', 'image');
    }
}
