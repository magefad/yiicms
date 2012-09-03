<?php

/**
 * Abstract FileManager to use with TinyMce.
 * For example see elFinder extension.
 */
abstract class TinyMceFileManager extends CComponent
{
    /**
     * Initialize FileManager component, registers required JS
     */
    public function init()
    {

    }

    /**
     * @abstract
     * @return string JavaScript callback function, starts with "js:"
     */
    abstract public function getFileBrowserCallback();
}
