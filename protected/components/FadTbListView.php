<?php
Yii::import('bootstrap.widgets.TbListView');
/**
 * @author Fadeev Ruslan <fadeevr@gmail.com>
 * Date: 16.11.12
 * Time: 1:08
 */
class FadTbListView extends TbListView
{
    /**
     * Renders the sorter.
     */
    public function renderSorter()
    {
        if($this->dataProvider->getItemCount()<=0 || !$this->enableSorting || empty($this->sortableAttributes))
            return;
        echo CHtml::openTag('div',array('class'=>$this->sorterCssClass))."\n";
        echo $this->sorterHeader===null ? Yii::t('zii','Sort by: ') : $this->sorterHeader;
        echo "<ul>\n";
        $sort=$this->dataProvider->getSort();
        foreach($this->sortableAttributes as $name=>$label)
        {
            echo "<li>";
            if(is_integer($name))
                echo $sort->link($label, null, array('rel' => 'nofollow'));
            else
                echo $sort->link($name,$label, array('rel' => 'nofollow'));
            echo "</li>\n";
        }
        echo "</ul>";
        echo $this->sorterFooter;
        echo CHtml::closeTag('div');
    }
}
