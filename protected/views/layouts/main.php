<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<meta name="keywords" content="<?php echo isset($this->keywords) ? $this->keywords : '';?>"/>
	<meta name="description" content="<?php echo isset($this->description) ? $this->description : '';?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.css">
	<!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<?php
		if ( !Yii::app()->user->isGuest /*&& Yii::app()->user->isSuperUser()*/ )
		{
			echo "<script src='".Yii::app()->request->baseUrl."/js/admin.js'></script>\n\t";
			echo "<script type='text/javascript'>$(function() { $('.mytip').tooltip(); });</script>\n";
		}
	#echo 'Url:'.Yii::app()->assetManager->getPublishedUrl(Yii::getPathOfAlias('ext.bootstrap.assets'));
	?>
	<!-- Le fav and touch icons -->
</head>
<body>
<?php #if ( $this->beginCache('navbar', array('duration'=> 300)) ): ?>
<?php
#echo Yii::app()->user->checkAccess('Editor');
#print_r($this->currentPage);

#Кешируем меню с ссылками на страницы
if ( !$topMenu = Yii::app()->cache->get('top-menu') )
{
	Yii::app()->cache->set('top-menu', Menu::getItems('top-menu'), 3600);#кэшируем меню на час
	$topMenu = Yii::app()->cache->get('top-menu');
}
#####################################
$this->widget('bootstrap.widgets.TbNavbar', array(
	'fixed'		=> false,
	'brand'		=> CHtml::encode(Yii::app()->name),
	'brandUrl'	=> '/',
	'collapse'	=> true, // requires bootstrap-responsive.css
	'items'		=> array(
		array(
			'class' => 'bootstrap.widgets.TbMenu',
			'items' => $topMenu,
		),
		'<form class="navbar-search pull-left" action=""><input type="text" class="search-query span2" placeholder="Что ищем?"></form>',
			array(
				'class' => 'bootstrap.widgets.TbMenu',
				'htmlOptions' => array('class' => 'pull-right'),
					'items' => array_merge(
						Menu::getItems('admin-menu'),
						array(
							array('label' => 'Войти', 'url' => array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
							array('label' => Yii::app()->user->name, 'url' => array('site/profile'), 'visible'=>!Yii::app()->user->isGuest),
							array('label' => 'Выйти', 'url' => array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest, 'htmlOptions' => array('class' => 'btn')),
						)
					)
				),
			),
		));
	?>
	<?php if ( !Yii::app()->user->isGuest /*&& Yii::app()->user->isSuperUser()*/ && $this->menu ):?>
		<div class="subnav well">
			<h3><?php #print_r(Yii::app()->user->id);# echo CHtml::encode($this->sidebarCaption); ?></h3>
			<?php
			$this->beginWidget('bootstrap.widgets.TbMenu', array(
					'type' => 'list',
					'items'=> $this->menu,
				)
			);
			$this->endWidget();
			?>
		</div>
	<?php endif ?>
	<div class="container-fluid">
		<?php if(isset($this->breadcrumbs)):?>
			<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links' => $this->breadcrumbs,
			'separator' => ' / ',
			'homeLink' => CHtml::link('Главная', Yii::app()->homeUrl),
		)); ?><!-- breadcrumbs -->
		<?php endif?>
	    <?php if ( isset($this->currentPage) && $this->currentPage['slug'] == Yii::app()->params['index'] ):?>
			<div class="news" style="float: right"><?php $this->widget('ext.news.widgets.LastNews', array('cacheTime' => 10));?></div>
		<?php endif;?>
		<?php echo $content; ?>
	</div>
	<footer class="footer">
		<div class="container">
			<?php $this->widget('ext.performance.widgets.statistic');?>
		</div>
	</footer>
</div><!-- page -->
</body>
</html>
