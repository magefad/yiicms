<!DOCTYPE html>
<html lang="<?php echo Yii::app()->language; ?>">
<head>
    <meta charset="utf-8">
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <!--[if lt IE 9]><script type="text/javascript" src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
<?php
/**
 * @var $this Controller
 */
$this->widget(
    'bootstrap.widgets.TbNavbar',
    array(
        'type'     => 'inverse',
        'fixed'    => false,
        'brand'    => CHtml::encode(Yii::app()->name),
        'brandUrl' => '/',
    )
);
?>
<div class="container-fluid">
    <?php $this->widget('bootstrap.widgets.TbAlert');?>
    <?php echo $content; ?>
</div>
</body>
</html>
