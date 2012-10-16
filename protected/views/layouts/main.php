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
#Кешируем меню с ссылками на страницы
if (!$topMenu = Yii::app()->cache->get('top-menu')) {
    Yii::app()->cache->set('top-menu', Menu::getItems('top-menu'), 3600); #кэшируем меню на час
    $topMenu = Yii::app()->cache->get('top-menu');
}
#####################################
$this->widget(
    'bootstrap.widgets.TbNavbar',
    array(
        'type'         => 'inverse',
        'fixed'        => false,
        'brand'        => CHtml::encode(Yii::app()->name),
        'brandUrl'     => '/',
        'collapse'     => true, // requires bootstrap-responsive.css
        'items'        => array(
            array(
                'class' => 'bootstrap.widgets.TbMenu',
                'items' => $topMenu,
            ),
            '<form class="navbar-search pull-left" action=""><input type="text" class="search-query span2" placeholder="Что ищем?"></form>',
            array(
                'class'       => 'bootstrap.widgets.TbMenu',
                'htmlOptions' => array('class' => 'pull-right'),
                'items'       => array_merge(
                    Menu::getItems('admin-menu'),
                    array(
                        array(
                            'label'  => 'Войти',
                            'url'    => array('/user/account/login'),
                            'visible' => Yii::app()->user->isGuest
                        ),
                        array(
                            'label'       => 'Выйти',
                            'url'         => array('/user/account/logout'),
                            'visible'     => !Yii::app()->user->isGuest,
                            'htmlOptions' => array('class' => 'btn')
                        ),
                    )
                )
            ),
        ),
    )
);
?>
<?php if (Yii::app()->user->isSuperUser && $this->menu): ?>
<div class="subnav well">
    <?php
    $this->beginWidget(
        'bootstrap.widgets.TbMenu',
        array(
            'type' => 'list',
            'items' => $this->menu,
        )
    );
    $this->endWidget();
    ?>
</div>
    <?php endif ?>
<div class="container-fluid">
    <?php if (isset($this->breadcrumbs)): ?>
        <?php $this->widget(
        'bootstrap.widgets.TbBreadcrumbs',
        array(
            'links'     => $this->breadcrumbs,
            'separator' => ' / ',
            'homeLink'  => CHtml::link('Главная', Yii::app()->homeUrl),
        )
    ); ?><!-- breadcrumbs -->
    <?php endif?>
    <?php $this->widget('bootstrap.widgets.TbAlert');?>
    <?php if (isset($this->currentPage) && $this->currentPage['slug'] == Yii::app()->params['index']): ?>
    <div class="news" style="float: right">
        <?php $this->widget(
        'application.modules.news.widgets.LastNews',
        array('cacheTime' => 10)
    );?></div>
    <?php endif;?>
    <?php echo $content; ?>
</div>
<footer class="footer">
    <div class="container">
        <?php #$this->widget('ext.performance.widgets.statistic');?>
    </div>
</footer>
</body>
</html>
