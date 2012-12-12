<?php
/**
 * @author Fadeev Ruslan <fadeevr@gmail.com>
 * Date: 07.12.12
 * Time: 13:17
 * @property SitemapModule $module
 */
class DefaultController extends Controller
{
    /**
     * Displays sitemap in XML or HTML format,
     * depending on the value of $format parameter
     * @param string $format
     */
    public function actionIndex($format = 'html')
    {
        if ($format == 'xml') {
            header('Content-Type: text/xml');
            $this->renderPartial('xml', array('urls' => $this->module->getUrls()));
        } else {
            $this->render('html', array('urls' => $this->module->getUrls()));
        }
        Yii::app()->end();
    }
}
