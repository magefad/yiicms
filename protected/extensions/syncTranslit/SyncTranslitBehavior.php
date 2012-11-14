<?php
/**
 * @author Fadeev Ruslan <fadeevr@gmail.com>
 * Date: 14.11.12
 * Time: 12:14
 */
class SyncTranslitBehavior extends CActiveRecordBehavior
{
    public $textAttribute = 'title';

    public $options = array();

    public $forceOverwrite = false;

    private static $defaultOptions = array(
        'dictOriginal' => array(
            'а', 'б', 'в', 'г', 'д', 'е',
            'ё', 'ж', 'з', 'и', 'й', 'к',
            'л', 'м', 'н', 'о', 'п', 'р',
            'с', 'т', 'у', 'ф', 'х', 'ц',
            'ч', 'ш', 'щ', 'ъ', 'ы', 'ь',
            'э', 'ю', 'я',
            'і', 'є', 'ї', 'ґ',//ukraine
            'А', 'Б', 'В', 'Г', 'Д', 'Е',
            'Ё', 'Ж', 'З', 'И', 'Й', 'К',
            'Л', 'М', 'Н', 'О', 'П', 'Р',
            'С', 'Т', 'У', 'Ф', 'Х', 'Ц',
            'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь',
            'Э', 'Ю', 'Я',
            'I', 'Є', 'Ї', 'Ґ'//ukraine
        ),
        'dictTranslate' => array(
            'a', 'b', 'v', 'g', 'd', 'e',
            'e', 'zh','z', 'i', 'j', 'k',
            'l', 'm', 'n', 'o', 'p', 'r',
            's', 't', 'u', 'f', 'h', 'ts',
            'ch','sh','sch', '', 'y', '',
            'e', 'ju', 'ja',
            'i', 'je', 'ji', 'g',//ukraine
            'A', 'B', 'V', 'G', 'D', 'E',
            'E', 'ZH','Z', 'I', 'J', 'K',
            'L', 'M', 'N', 'O', 'P', 'R',
            'S', 'T', 'U', 'F', 'H', 'TS',
            'CH','SH','SCH', '', 'Y', '',
            'E', 'JU', 'JA',
            'I', 'JE', 'JI', 'G'//ukraine
        ),
        'caseStyle'    => 'lower',
        'urlSeparator' => '-',
        'type'         => 'url'
    );

    public function attach($owner)
    {
        if (!isset($this->options['destination'])) {
            $this->options['destination'] = 'slug';
        }
        $this->options = array_merge(self::$defaultOptions, $this->options);
    }

    public function beforeValidate()
    {
        if (($this->owner->isNewRecord && empty($this->owner->{$this->textAttribute})) || $this->forceOverwrite) {
            $this->owner->{$this->textAttribute} = $this->translit($this->owner->{$this->options['destination']});
        }
    }

    /**
     * @param $string
     * @return mixed
     */
    public function translit($string)
    {
        $string = str_replace(self::$defaultOptions['dictOriginal'], self::$defaultOptions['dictTranslate'], $string);
        if ($this->options['type'] == 'url') {
            $string = str_replace(array(' ', '_'), $this->options['urlSeparator'], $string);
            $string = preg_replace('/[' . $this->options['urlSeparator'] . ']{2,}/', $this->options['urlSeparator'], $string);
            return preg_replace('/[^0-9a-z\-]/', '', strtolower($string));
        }
        return $string;
    }
}
