<?php
/**
 * @var $model News
 * @var $this Controller
 */
$this->pageTitle   = $model->title;
$this->breadcrumbs = array(
    Yii::t('news', 'Новости') => array('/news'),
    CHtml::encode($model->title)
);
?>
<div class="post">
    <h2><?php echo $model->title?></h2>
    <?php if ($model->image) {
        echo CHtml::image($model->getImageUrl(), $model->title, array('style' => 'float:left; margin: 0 15px 15px 0'));
    }
    echo empty($model->content) ? $model->content_short : $model->content; ?>
    <div class="nav">
        <span class="label"><?php echo $model->date; ?></span> <i class="icon-user"></i>
        <b><?php echo $model->author->username?></b>
    </div>
</div>
<?php $this->renderPartial('application.modules.comment.views.default.commentList', array('model' => $model)); ?>
