<?php
/**
 * Created by OxGroup.
 * User: aliaxander
 * Date: 12.03.16
 * Time: 18:26
 */

namespace Ox\Component\Fixer;

/**
 * Class Validator
 *
 * @package Ox
 */
class Validator extends CharFix
{

    public $text;
    public $error;

    /**
     * @param $val
     *
     * @return bool
     */
    protected function checkValid($val)
    {
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

            case ("mail"):
                if (!preg_match("/^[a-zA-Z0-9\._-]+@[a-zA-Z0-9\._-]+\.[a-zA-Z]{2,6}$/i", $this->text)) {
                    $this->error['mail'][] = "Неверный формат";

                    return false;
                } else {
                    return true;
                }
                break;

            case ("domain"):
                $mask = '/^((www\.)?([A-Za-z0-9\-]+\.)+([A-Za-z]+){2,4})(\:(\d)+)?(\/(.*))?$/i';
                if (!preg_match($mask, $this->text)) {
                    $this->error['domain'][] = "Неверный формат";

                    return false;
                } else {
                    return true;
                }
                break;

            case (preg_match('/min:*/', $val) ? true : false):
                $valcou = explode(":", $val);
                $count = iconv_strlen($this->text, 'UTF-8');

                if ($count < $valcou['1']) {
                    $this->error['min'][] = "Требуется минимум {$valcou['1']} символов";

                    return false;
                } else {
                    return true;
                }
                break;

            case (preg_match('/max:*/', $val) ? true : false):
                $valcou = explode(":", $val);
                $count = iconv_strlen($this->text, 'UTF-8');

                if ($count > $valcou['1']) {
                    $this->error['max'][] = "Максимум символов {$valcou['1']}";

                    return false;
                } else {
                    return true;
                }
                break;

        }
    }

    /**
     * @param $text
     * @param $cfg
     *
     * @return bool
     */
    public function valid($text, $cfg, $name = "")
    {
        $this->text = $text;
        $cfg = explode("|", $cfg);
        foreach ($cfg as $val) {
            $this->checkValid($val);
        }
        if ($this->text == $text) {
            return true;
        } else {
            $this->error['char'][$name] = "Недопустимые символы";

            return false;
        }
    }

    /**
     * @return bool|string
     */
    public function viewErrors()
    {
        if (!empty($this->error) and $this->error != "") {
            $error = '';
            foreach ($this->error as $key => $val) {
                $error[$key] = implode(",", $val);
            }

            return $error;
        } else {
            return false;
        }
    }
}
