<div class="GalleryEditor" id="<?php echo $this->id?>">
	<div class="gform">
        <span class="btn btn-success fileinput-button">
            <i class="icon-plus icon-white"></i>
			<?php echo Yii::t('gallery', 'Добавить фото…');?>
			<?php echo CHtml::activeFileField($model, 'image', array('class' => 'afile', 'accept' => "image/*", 'multiple' => 'true'));?>
        </span>

		<span class="btn disabled edit_selected"><?php echo Yii::t('gallery', 'Изменить выбранные');?></span>
		<span class="btn disabled remove_selected"><?php echo Yii::t('gallery', 'Удалить выбранные');?></span>

		<label for="select_all_<?php echo $this->id?>" class="btn" style="height: 18px">
			<input type="checkbox" style="margin-bottom: 6px;display:inline-block;"
				   id="select_all_<?php echo $this->id?>"
				   class="select_all"/>
			<?php echo Yii::t('gallery', 'Выбрать все');?>
		</label>
		<!--  progress bar
		<div style="display: inline-block; vertical-align: middle;">
					<div class="progress progress-striped active" style="width:200px;margin: 0 0 0 10px;">
						<div class="bar" style="width: 100%;"></div>
					</div>
		</div>-->
		<?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
			'buttons' => array(
				array(
					'label' => Yii::t('gallery', 'Альбом'),
					'items' => $albums
				),
			), 'htmlOptions' => array('style' => 'float: right; margin: 3px 10px 0 0'),
		)); ?>
		<?php echo CHtml::hiddenField('returnUrl', Yii::app()->getRequest()->getUrl() . '#' . $this->id);?>
	</div>
	<hr/>
	<div class="sorter">
		<div class="images">
			<?php foreach ($photos as $photo): ?>
			<div id="<?php echo $this->id . '-' . $photo->id ?>" class="photo">
				<div class="image-preview">
					<?php echo CHtml::image($photo->getPreview()); ?>
				</div>
				<div class="caption">
					<h5><?php echo $photo->name ?></h5>
					<p><?php echo $photo->description ?></p>
				</div>
				<div class="actions">
					<?php
					echo CHtml::hiddenField('order[' . $photo->id . ']', $photo->sort);
					echo '<span data-photo-id="' . $photo->id . '" class="editPhoto btn btn-primary"><i class="icon-edit icon-white"></i></span>';
					echo ' <span data-photo-id="' . $photo->id . '" class="deletePhoto btn btn-danger"><i class="icon-remove icon-white"></i></span>';
					?>
				</div>
				<input type="checkbox" class="photo-select"/>
			</div>
			<?php endforeach;?>
		</div>
		<br style="clear: both;"/>
	</div>

	<div class="modal hide editor-modal"> <!-- fade removed because of opera -->
		<div class="modal-header">
			<a class="close" data-dismiss="modal">×</a>
			<h3><?php echo Yii::t('gallery', 'Изменить данные')?></h3>
		</div>
		<div class="modal-body">
			<div class="form"></div>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn btn-primary save-changes">
				<?php echo Yii::t('gallery', 'Сохранить')?>
			</a>
			<a href="#" class="btn" data-dismiss="modal"><?php echo Yii::t('gallery', 'Закрыть')?></a>
		</div>
	</div>
</div>