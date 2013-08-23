<?php
/**
 * @var Good $good
 * @var $this Controller
 */
$css = <<<CSS
    .bg {
        background-color: #6c7480; color: white;
    }
    .good .header .big {
        font-size: 250%; font-weight: bold;
    }
    .good .footer .big {
        font-size: 190%;
        font-weight: bold;
        padding-left: 10px
    }
    .good .border {
    border: 1px solid #a9a5a5
    }
    .good .header {
        padding-top: 8px;
        padding-bottom: 4px;
    }
    .good .footer {
        padding: 15px 0 15px 0;
    }
    .good .footer a {
        color: white;
    }
CSS;
Yii::app()->clientScript->registerCss(__FILE__, $css);
?>
<div class="span4 good">
    <div class="row-fluid">
        <div class="row">
            <div class="header span5 text-center bg">
                <span class="big"><?=$good->getValue('perfomance')?></span> <big style="font-weight: bold">ед./ч!</big>
            </div>
        </div>
    </div>
    <div class="row border">
        <a class="span12 text-center" href="<?=$this->createAbsoluteUrl('/catalog/good/show', array('slug' => $good->slug))?>">
            <img src="<?=$good->getValue('photo') ?>" alt="<?=$good->getValue('name') ?>"/>
        </a>
    </div>
    <div class="row bg footer">
        <a class="span4 big" href="<?=$this->createAbsoluteUrl('/catalog/good/show', array('slug' => $good->slug))?>">
            <?=GoodTemplate::getName('id') ?> <?=$good->getValue('id') ?>
        </a>
        <div class="span8" style="font-weight: 600; padding-left: 10px">
            <?=GoodTemplate::getName('perfomance') ?> - <?= $good->getValue('perfomance') ?> ед.ч<br/>
            <?=GoodTemplate::getName('area') ?> - <?= $good->getValue('area') ?> м<sup>2</sup><br/>
            <?=GoodTemplate::getName('height') ?> - <?= $good->getValue('height') ?> м<br/>
        </div>
    </div>
</div>