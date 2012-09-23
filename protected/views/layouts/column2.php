<?php /** @var $this CController */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="container">
    <div class="appcontent">
        <div class="row">
            <div class="span8">
                <?php echo $content; ?>
            </div>
            <div class="subnav well">
                <h3><?php #echo CHtml::encode($this->sidebarCaption); ?></h3>
                <?php
                $this->beginWidget(
                    'bootstrap.widgets.TbMenu',
                    array(
                        'type' => 'list',
                        'items' => $this->menu,
                    )
                );
                $this->endWidget();
                #print_r($this->menu);
                ?>
            </div>
        </div>
    </div>
</div> <!-- /container -->
<?php $this->endContent(); ?>