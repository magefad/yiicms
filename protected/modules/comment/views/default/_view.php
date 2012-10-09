<?php
/** @var $data Comment */
?>
<a id="comments"></a>
<div class="row-fluid">
    <div class="comment" id="comment-<?php echo $data->id; ?>">
	<span class="comment-head muted">
		<?php echo $data->username; ?>
        <span class="comment-date">
			<?php echo Yii::app()->getDateFormatter()->formatDateTime($data->create_time, 'short', 'short'); ?>
		</span>
        <span class="comment-options">
        <?php if (!Yii::app()->user->isGuest && (Yii::app()->user->id == $data->create_user_id)) {
            echo CHtml::ajaxLink(
                '<i class="icon-pencil"></i>',
                array('/comment/default/update', 'id' => $data->id),
                array(
                    'replace' => '#comment-' . $data->id,
                    'type'    => 'GET',
                ),
                array(
                    'id'    => 'comment-edit-' . $data->id,
                    'title' => Yii::t('CommentModule.comment', 'Edit'),
                    'rel'   => 'tooltip'
                )
            );
            echo ' ';
            echo CHtml::ajaxLink(
                '<i class="icon-trash"></i>',
                array('/comment/default/delete', 'id' => $data->id),
                array(
                    'success' => 'function(){ $("#comment-' . $data->id . '").remove(); }',
                    'type'    => 'POST',
                ),
                array(
                    'id'      => 'delete-comment-' . $data->id,
                    'title'   => Yii::t('CommentModule.comment', 'Remove'),
                    'rel'     => 'tooltip',
                    'confirm' => Yii::t('blog', 'Are you sure you want to delete this item?'),
                )
            );
        } ?>
        </span>
	</span>
        <?php if (is_object($data->user)): ?>
        <span class="pull-left" style="padding: 3px 5px 0 0;"><?php echo $data->user->getAvatar(32); ?></span>
        <?php endif; ?>
        <div><?php echo nl2br(CHtml::encode($data->text)); ?></div>
        <br style="clear: both;"/>
    </div>
</div>
