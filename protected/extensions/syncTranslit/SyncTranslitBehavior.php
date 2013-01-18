<?php
/**
 * @author Fadeev Ruslan <fadeevr@gmail.com>
 * GOST 779B
 * @link http://ru.wikipedia.org/wiki/%D0%93%D0%9E%D0%A1%D0%A2_7.79-2000
 * Date: 14.11.12
 * Time: 12:14
 */
class SyncTranslitBehavior extends CActiveRecordBehavior
{
    /**
     * @var string The name of the attribute stored the text to translit
     * Defaults to 'title'
     */
    public $textAttribute = 'title';

    /**
     * @var string The name of the attribute to put translit
     * Defaults to 'title'
     */
    public $translitAttribute = 'slug';

    /**
     * @var array Options
     */
    public $options = array();

    /**
     * @var bool if true, translitAttribute will be sync with textAttribute always
     */
    public $forceOverwrite = false;

    private static $defaultOptions = array(
        'table' => array(
            'А' => 'A', 'а' => 'a',
            'Б' => 'B', 'б' => 'b',
            'В' => 'V', 'в' => 'v',
            'Г' => 'G', 'г' => 'g',
            'Д' => 'D', 'д' => 'd',
            'Е' => 'E', 'е' => 'e',
            'Ё' => 'Yo', 'ё' => 'yo',
            'Ж' => 'Zh', 'ж' => 'zh',
            'З' => 'Z', 'з' => 'z',
            'И' => 'I', 'и' => 'i',
            'Й' => 'J', 'й' => 'j',
            'К' => 'K', 'к' => 'k',
            'Л' => 'L', 'л' => 'l',
            'М' => 'M', 'м' => 'm',
            'Н' => "N", 'н' => 'n',
            'О' => 'O', 'о' => 'o',
            'П' => 'P', 'п' => 'p',
            'Р' => 'R', 'р' => 'r',
            'С' => 'S', 'с' => 's',
            'Т' => 'T', 'т' => 't',
            'У' => 'U', 'у' => 'u',
            'Ф' => 'F', 'ф' => 'f',
            'Х' => 'H', 'х' => 'h',
            'Ц' => 'C', 'ц' => 'c',
            'Ч' => 'Ch', 'ч' => 'ch',
            'Ш' => 'Sh', 'ш' => 'sh',
            'Щ' => 'Shh', 'щ' => 'shh',
            'Ъ' => 'ʺ', 'ъ' => 'ʺ',
            'Ы' => 'Y`', 'ы' => 'y`',
            'Ь' => '', 'ь' => '',
            'Э' => 'E`', 'э' => 'e`',
            'Ю' => 'Yu', 'ю' => 'yu',
            'Я' => 'Ya', 'я' => 'ya',
            '№' => '#', 'Ӏ' => '‡',
            '’' => '`', 'ˮ' => '¨',
            'ґ' => 'g', 'Ґ' => 'G',//ukraine
            'є' => 'ye', 'Є' => 'YE',
            'ї' => 'yi', 'Ї' => 'YI',
            'і' => 'i', 'I' => 'I'
        ),
        'caseStyle'    => 'normal',
        'urlSeparator' => '-',
        'type'         => 'url'
    );

    /**
     * Responds to {@link CModel::onBeforeValidate} event.
     * Overrides this method if you want to handle the corresponding event of the {@link owner}.
     * You may set {@link CModelEvent::isValid} to be false to quit the validation process.
     * @param CModelEvent $event event parameter
     */
    public function beforeValidate($event)
    {
        if (($this->owner->isNewRecord && empty($this->owner->{$this->translitAttribute})) || $this->forceOverwrite) {
            $this->owner->{$this->translitAttribute} = $this->translit($this->owner->{$this->textAttribute});
        }
        parent::beforeValidate($event);
    }

    /**
     * @param string $string
     * @return mixed
     */
    public function translit($string)
    {
        $this->options = array_merge(self::$defaultOptions, $this->options);
        $string = str_replace(array_keys(self::$defaultOptions['table']), array_values(self::$defaultOptions['table']), $string);
        if ($this->options['type'] == 'url') {
            $string = str_replace(array(' ', '_'), $this->options['urlSeparator'], $string);
            $string = preg_replace('/[^0-9a-z\-]/', '', strtolower($string));
            return preg_replace('/[' . $this->options['urlSeparator'] . ']{2,}/', $this->options['urlSeparator'], $string);
        } else if ($this->options['caseStyle'] != 'normal') {
            return $this->options['caseStyle'] = 'upper' ? strtoupper($string) : strtolower($string);
        } else {
            return $string;
        }
    }
}
