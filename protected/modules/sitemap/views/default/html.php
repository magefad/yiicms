<?php
/**
 * @author Fadeev Ruslan <fadeevr@gmail.com>
 * Date: 10.12.12
 * Time: 15:09
 * @var $this Controller
 * @var $urls array
 */
$level           = 0;
$this->pageTitle = Yii::t('SitemapModule.sitemap', 'Sitemap');
?>
<h1><?php echo $this->pageTitle; ?></h1>
<ul>
<?php
foreach ($urls as $url => $data) {
    if ($data['htmlDisable']) {
        continue;
    }
    $urlLevel = isset($data['level']) ? (int)$data['level'] : 1;
    if ($urlLevel) {
        if ($urlLevel > $level) {
            echo $level ? '<ul>' : '';
        } else if ($urlLevel < $level) {
            echo str_repeat('</li></ul>', $level - $urlLevel);
        } else if ($level) {
            echo '</li>';
        }
        $level = $urlLevel;
    }
    echo '<li>';
    echo !empty($data['title']) ? CHtml::link($data['title'], $url) : CHtml::link($url, $url);
}
?>
</ul>