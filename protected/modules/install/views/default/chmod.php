<?php
/**
 * @author Ruslan Fadeev <fadeevr@gmail.com>
 * @link http://yiifad.ru/
 * @copyright 2012-2013 Ruslan Fadeev
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
/**
 * @var $this Controller
 * @var array $result (dir => writable)
 */
?>
<h1><?php echo Yii::t('InstallModule.chmod', 'Checking CHMOD (permissions) on directory'); ?></h1>
<p></p>
<table class="table table-condensed table-bordered" style="width: 50%; margin: 0 auto;">
    <tr>
        <th><?php echo Yii::t('InstallModule.chmod', 'Directory'); ?></th>
        <th><?php echo Yii::t('InstallModule.chmod', 'Writable'); ?></th>
    </tr>
<?php foreach ($result as $dir => $writable):?>
    <tr class="<?php echo $writable ? '' : 'error'; ?>">
        <td><?php echo $dir; ?></td><td><?php echo Yii::t('InstallModule.views', $writable ? 'Passed' : 'Failed'); ?></td>
    </tr>
<?php endforeach; ?>
</table>
<div style="text-align: center; margin-top: 20px; ">
<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'label' => Yii::t('InstallModule.main', 'Next step'),
        'type'  => 'primary',
        'size'  => 'large',
        'url'   => array('database'),
    )
);
?>
</div>
