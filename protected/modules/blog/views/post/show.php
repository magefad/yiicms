<?php

/**
 * @var $this Controller
 * @var $model Post
 * @var $tags array
 */

$this->breadcrumbs = array(
    Yii::t('blog', 'Blogs')            => array('/blog'),
    CHtml::encode($model->blog->title) => array('/blog/default/show/', 'slug' => $model->blog->slug),
    CHtml::encode($model->title)
);
?>
<div class="post">
    <h2><?php echo $model->title?></h2>
    <?php echo $model->content; ?>
    <i class="icon-user"></i> <?php echo $model->createUser->username; ?>
    | <i class="icon-calendar"></i> <?php echo $model->publish_time; ?>
    | <i class="icon-comment"></i> <?php echo $model->getCommentCount() . ' ' . Yii::t('blog', 'Comment|Comments', $model->getCommentCount()); ?>
    <!--| <i class="icon-share"></i> <a href="#">39 Shares</a> -->
    | <i class="icon-tags"></i> <?php echo Yii::t('blog', 'Tags'); ?>:
    <?php foreach ($tags as $tag): ?>
    <?php echo CHtml::link($tag, array('/blog/post/tag', 'tag' => $tag), array('class' => 'label label-info')); ?>
    <?php endforeach; ?>
</div>
<?php $this->renderPartial('application.modules.comment.views.default.commentList', array('model'=> $model)); ?>
