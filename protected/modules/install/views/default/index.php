<?php
/**
 * @author Ruslan Fadeev <fadeevr@gmail.com>
 * @link http://yiifad.ru/
 * @copyright 2012-2013 Ruslan Fadeev
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

/**
 * @var $this Controller
 * @var array $requirements
 * @var bool $result passed or no
 * @var string $info
 */
if($result > 0) {
    Yii::app()->user->setFlash('success', Yii::t('InstallModule.views', 'Congratulations! Your server configuration satisfies all requirements by Yii.'));
} else if ($result < 0) {
    Yii::app()->user->setFlash('warning', Yii::t('InstallModule.views', 'Your server configuration satisfies the minimum requirements by Yii. Please pay attention to the warnings listed below if your application will use the corresponding features.'));
} else {
    Yii::app()->user->setFlash('error', Yii::t('InstallModule.views', 'Unfortunately your server configuration does not satisfy the requirements by Yii.'));
}
?>
<h1><?php echo Yii::t('InstallModule.views', 'Yii Requirement Checker'); ?></h1>
    <h2><?php echo Yii::t('InstallModule.views', 'Description'); ?></h2>
    <p>
        <?php echo Yii::t('InstallModule.views', 'This script checks if your server configuration meets the requirements for running <a href="http://www.yiiframework.com/">Yii</a> Web applications. It checks if the server is running the right version of PHP, if appropriate PHP extensions have been loaded, and if php.ini file settings are correct.'); ?>
    </p>

<h2><?php echo Yii::t('InstallModule.views', 'Conclusion'); ?></h2>
<?php $this->widget('bootstrap.widgets.TbAlert'); ?>
<?php if ($result != 0): ?>
<div style="text-align: center">
<?php $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'label' => Yii::t('InstallModule.main', 'Begin installing'),
            'type'  => 'primary',
            'size'  => 'large',
            'url'   => array('chmod')
        )
    ); ?>
<?php endif; ?>
</div>
<h2><?php echo Yii::t('InstallModule.views', 'Details'); ?></h2>
<table class="table table-striped table-bordered">
    <tr><th><?php echo Yii::t('InstallModule.views', 'Name'); ?></th><th><?php echo Yii::t('InstallModule.views', 'Result'); ?></th><th><?php echo Yii::t('InstallModule.views', 'Required By'); ?></th><th><?php echo Yii::t('InstallModule.views', 'Memo'); ?></th></tr>
    <?php foreach($requirements as $requirement): ?>
    <tr class="<?php echo $requirement[2] ? '' : ($requirement[1] ? 'error' : 'warning'); ?>">
        <td>
            <?php echo $requirement[0]; ?>
        </td>
        <td>
            <?php echo $requirement[2] ? Yii::t('InstallModule.views', 'Passed') : ($requirement[1] ? Yii::t('InstallModule.views', 'Failed') : Yii::t('InstallModule.views', 'Warning')); ?>
        </td>
        <td>
            <?php echo $requirement[3]; ?>
        </td>
        <td>
            <?php echo $requirement[4]; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php echo $info; ?>
<div>&nbsp;</div>
