<?php
/**
 * CommandExecutor class file.
 *
 * @author Ruslan Fadeev <fadeevr@gmail.com>
 * @link http://yiifad.ru/
 * @copyright 2012-2013 Ruslan Fadeev
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

/**
 * @method migrate(string $args) call "yiic migrate $args"
 */

class CommandExecutor extends CApplicationComponent
{
    /**
     * @var CConsoleCommandRunner
     */
    public $runner;

    /**
     * Initializes the application component.
     * This method is required by {@link IApplicationComponent} and is invoked by application.
     */
    public function init()
    {
        $this->runner = new CConsoleCommandRunner();
        $this->addCommands('system.cli.commands');
        $this->addCommandsFromConfig('console');
        parent::init();
    }

    /**
     * Calls the named method which is not a class method.
     * Do not call this method. This is a PHP magic method that we override
     * to implement the behavior feature.
     * @param string $name the method name
     * @param array $parameters
     * @return mixed the method return value
     */
    public function __call($name, $parameters)
    {
        $args = array('yiic', $name);
        if (isset($parameters[0])) {
            $parameters = explode(' ', $parameters[0]);
        }

        foreach ($parameters as $item) {
            array_push($args, $item);
        }
        try {
            ob_start();
            ob_implicit_flush(false);
            array_push($args, '--interactive=0');
            $this->runner->run($args);
            $result = ob_get_clean();
        } catch ( Exception $e ) {
            ob_clean();
            $result = $e->getMessage() . (YII_DEBUG ? $e->getTraceAsString() : '');
        }

        return $result;
    }

    /**
     * @param string $alias
     */
    public function addCommands($alias)
    {
        $path = Yii::getPathOfAlias($alias);
        if (is_dir($path)) {
            $this->runner->addCommands($path);
        }
    }

    /**
     * @param string $config filename
     */
    public function addCommandsFromConfig($config)
    {
        $config = new CConfiguration(Yii::getPathOfAlias('application.config') . DIRECTORY_SEPARATOR . $config . '.php');
        foreach ($config['commandMap'] as $id => $conf) {
            $this->runner->commands[$id] = $conf;
        }
    }
}
