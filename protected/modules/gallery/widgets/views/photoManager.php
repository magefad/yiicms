<?php
/**
 * @var $model Photo
 * @var $this Controller
 * @var $albums array
 */
?>
<div class="GalleryEditor" id="<?php echo $this->id?>">
    <!-- Gallery Toolbar -->
    <div class="gform">
        <span class="btn btn-success fileinput-button">
            <i class="icon-plus icon-white"></i>
            <?php echo Yii::t('GalleryModule.gallery', 'Add photo…');?>
            <?php echo CHtml::activeFileField($model, 'image', array('class' => 'afile', 'accept' => "image/*", 'multiple' => 'true'));?>
        </span>

        <span class="btn disabled edit_selected"><?php echo Yii::t('GalleryModule.gallery', 'Change selected');?></span>
        <span class="btn disabled remove_selected"><?php echo Yii::t('GalleryModule.gallery', 'Remove selected');?></span>

        <label for="select_all_<?php echo $this->id?>" class="btn" style="height: 18px">
            <input type="checkbox" style="margin-bottom: 6px;display:inline-block;"
                   id="select_all_<?php echo $this->id?>"
                   class="select_all"/>
            <?php echo Yii::t('GalleryModule.gallery', 'Select All');?>
        </label>
        <!--  progress bar
          <div style="display: inline-block; vertical-align: middle;">
                      <div class="progress progress-striped active" style="width:200px;margin: 0 0 0 10px;">
                          <div class="bar" style="width: 100%;"></div>
                      </div>
          </div>-->
        <?php $this->widget(
        'bootstrap.widgets.TbButtonGroup',
        array(
            'buttons'     => array(
                array(
                    'label' => Yii::t('GalleryModule.gallery', 'Album'),
                    'items' => $albums
                ),
            ),
            'htmlOptions' => array('style' => 'float: right; margin: 3px 10px 0 0'),
        )
    ); ?>
        <?php echo CHtml::hiddenField('returnUrl', Yii::app()->getRequest()->getUrl() . '#' . $this->id);?>
    </div>
    <hr/>
    <!-- Gallery Photos -->
    <div class="sorter">
        <div class="images"></div>
        <br style="clear: both;"/>
    </div>
    <!-- Modal window to edit photo information -->
    <div class="modal hide editor-modal"> <!-- fade removed because of opera -->
        <div class="modal-header">
            <a class="close" data-dismiss="modal">×</a>

            <h3><?php echo Yii::t('GalleryModule.gallery', 'Edit Data')?></h3>
        </div>
        <div class="modal-body">
            <div class="form"></div>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-primary save-changes">
                <?php echo Yii::t('GalleryModule.gallery', 'Save')?>
            </a>
            <a href="#" class="btn" data-dismiss="modal"><?php echo Yii::t('GalleryModule.gallery', 'Close')?></a>
        </div>
    </div>
</div>