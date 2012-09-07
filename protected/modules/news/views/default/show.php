<?php
/**
 * User: fad
 * Date: 27.07.12
 * Time: 15:56
 */
/** @var $news News */
$this->pageTitle = $news->title;
$this->breadcrumbs = array(
	Yii::t('news', 'Новости') => array('/news/list/'),
	#CHtml::encode($news->title)
);
?>
<div class="post">
	<h2><?php echo $news->title?></h2>
	<?php if ( $news->image) echo CHtml::image('/uploads/news/'.$news->slug.'/'.$news->image, $news->title, array('style' => 'float:left; margin: 0 15px 15px 0'));?>
	<?php echo $news->body; ?>
	<div class="nav">
		<span class="label"><?php echo $news->date; ?></span> <i class="icon-user"></i> <b><?php echo $news->author->username?></b>
	</div>
</div>

<br/><br/><br/>
<?php # $this->widget('application.modules.comment.widgets.CommentsListWidget', array('model' => $news, 'modelId' => $news->id)); ?>
<br/>
<!-- <h3>Оставить комментарий</h3> -->
<?php # $this->widget('application.modules.comment.widgets.CommentFormWidget', array('redirectTo' => $news->getPermaLink(), 'model' => $news, 'modelId' => $news->id)); ?>