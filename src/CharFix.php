<?php
/**
 * Created by OxGroup.
 * User: aliaxander
 * Date: 19.05.15
 * Time: 14:38
 */

namespace Ox\Component\Fixer;

/**
 * Class CharFix
 *
 * @package Ox
 */
class CharFix
{
    public $text;

    /**
     * @param string $text
     *
     * @return mixed|string
     */
    public function char($text = "")
    {
        return preg_replace("/[^a-z]/i", "", $text);
    }

    /**
     * @param string $text
     *
     * @return mixed
     */
    public function number($text = "")
    {
        return preg_replace("/[^0-9]/i", "", $text);
    }

    /**
     * @param string $text
     *
     * @return mixed
     */
    public function charNumber($text = "")
    {
        return preg_replace("/[^a-z0-9]/i", "", $text);
    }

    /**
     * @param string $text
     *
     * @return string
     */
    public function noHtml($text = "")
    {
        return htmlspecialchars($text, ENT_QUOTES);
    }

    /**
     * @param string $text
     *
     * @return mixed|string
     */
    public function noSpec($text = "")
    {
        $text = preg_replace("#[" . preg_quote("'`\\|>!`~^<%)(&") . "]#", "", $text);
        $text = str_replace('"', '\"', $text);

        return $text;
    }

    /**
     * @param $string
     *
     * @return string
     */
    public function rus2translit($string)
    {
        $converter = array(
            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ё' => 'e',
            'ж' => 'zh',
            'з' => 'z',
            'и' => 'i',
            'й' => 'y',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ф' => 'f',
            'х' => 'h',
            'ц' => 'c',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'sch',
            'ь' => '\'',
            'ы' => 'y',
            'ъ' => '\'',
            'э' => 'e',
            'ю' => 'yu',
            'я' => 'ya',

            'А' => 'A',
            'Б' => 'B',
            'В' => 'V',
            'Г' => 'G',
            'Д' => 'D',
            'Е' => 'E',
            'Ё' => 'E',
            'Ж' => 'Zh',
            'З' => 'Z',
            'И' => 'I',
            'Й' => 'Y',
            'К' => 'K',
            'Л' => 'L',
            'М' => 'M',
            'Н' => 'N',
            'О' => 'O',
            'П' => 'P',
            'Р' => 'R',
            'С' => 'S',
            'Т' => 'T',
            'У' => 'U',
            'Ф' => 'F',
            'Х' => 'H',
            'Ц' => 'C',
            'Ч' => 'Ch',
            'Ш' => 'Sh',
            'Щ' => 'Sch',
            'Ь' => '\'',
            'Ы' => 'Y',
            'Ъ' => '\'',
            'Э' => 'E',
            'Ю' => 'Yu',
            'Я' => 'Ya',
        );

        return strtr($string, $converter);
    }

    /**
     * @param $str
     *
     * @return mixed|string
     */
    public function str2url($str)
    {
        $str = $this->rus2translit($str);
        $str = strtolower($str);
        $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
        $str = trim($str, "-");

        return $str;
    }

    /**
     * @param string $text
     * @param string $cfg
     *
     * @return string
     */
    public function fixAll($text = "", $cfg = "")
    {
        $this->text = $text;
        $cfg = explode("|", $cfg);
        foreach ($cfg as $val) {
            switch ($val) {
                case ("noSpec"):
                    $this->text = $this->noSpec($this->text);
                    break;

                case ("noHtml"):
                    $this->text = $this->noHtml($this->text);
                    break;

                case ("charNumber"):
                    $this->text = $this->charNumber($this->text);
                    break;

                case ("char"):
                    $this->text = $this->char($this->text);
                    break;

                case ("number"):
                    $this->text = $this->number($this->text);
                    break;
            }
        }

        return $this->text;
    }
}
