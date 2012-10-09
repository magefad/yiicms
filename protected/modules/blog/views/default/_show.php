<?php
/**
 * @var $data Post
 * @var $this Controller
 */
$tags              = $data->getTags();
?>
<div class="row">
    <h2 class="span12">
        <?php echo CHtml::link($data->title, array('/blog/post/show', 'slug' => $data->slug)); ?>
        <small><?php echo CHtml::link($data->blog->title, array('/blog/default/show', 'slug' => $data->blog->slug), array('class' => 'muted')); ?></small>
    </h2>
    <div class="span12">
        <?php
        if ($cutPosition = strpos($data->content, '<cut>')) {
            echo substr($data->content, 0, $cutPosition);
            $this->widget(
                'bootstrap.widgets.TbButton',
                array(
                    'label'=> Yii::t('blog', 'Read more →'),
                    'size' => 'mini',
                    'url'  => array('/blog/post/show/', 'slug' => $data->slug, '#' => 'cut'),
                )
            );
        } else {
            echo $data->content;
        }
        ?>
    </div>
    <div class="span12">
        <i class="icon-user"></i> <?php echo $data->createUser->username; ?>
        | <i class="icon-calendar"></i> <?php echo $data->publish_time; ?>
        | <i class="icon-comment"></i> <?php echo CHtml::link(
        ($data->getCommentCount() . ' ' . Yii::t(
            'blog',
            'Comment|Comments',
            $data->getCommentCount()
        )),
        array('/blog/post/show/', 'slug' => $data->slug, '#' => 'comments')
    ); ?>
        <?php if (count($tags)): ?>
        | <i class="icon-tags"></i> <?php echo Yii::t('blog', 'Tags'); ?>:
        <?php foreach ($tags as $tag): ?>
            <?php echo CHtml::link(
                $tag,
                array('/blog/post/tag', 'tag' => $tag),
                array('class' => 'label label-info')
            ); ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<hr />
