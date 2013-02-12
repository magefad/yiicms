<?php
/**
 * modulesInstall.php class file.
 *
 * @author Ruslan Fadeev <fadeevr@gmail.com>
 * @link http://yiifad.ru/
 * @copyright 2012-2013 Ruslan Fadeev
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
/**
 * @var $this Controller
 * @var $modules array
 */
?>
<h1><?php echo Yii::t('InstallModule.modules', 'Installing Modules...'); ?></h1>
<div class="progress progress-striped active">
    <div class="bar" style="width: 3%"></div>
</div>
<div style="text-align: center; margin: 5px 0 15px 0; display: none;" id="button-next">
<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'label' => Yii::t('InstallModule.main', 'Next step'),
        'type'  => 'primary',
        'size'  => 'large',
        'url'   => array('config')
    )
); ?>
</div>
<div class="accordion" id="modules">
<?php foreach ($modules as $id): ?>    
    <div class="accordion-group">
        <div class="accordion-heading">
            <a id="accordion<?php echo $id; ?>" class="accordion-toggle" data-toggle="collapse" data-parent="#modules" href="#collapse<?php echo $id; ?>">
                <?php echo Modules::getModuleName($id); ?>
            </a>
        </div>
        <div id="collapse<?php echo $id; ?>" class="accordion-body collapse">
            <div class="accordion-inner">
                <?php echo Yii::t('InstallModule.modules', 'Waiting for installation...'); ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>