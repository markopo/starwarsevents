<?php
/**
 * Created by PhpStorm.
 * User: marko
 * Date: 06/08/2016
 * Time: 23:31
 */

namespace AppBundle\Translations;

class BaseTranslation {
    protected  $translations = array();

    public function __construct(){

    }

    public function get($key)
    {
        return array_key_exists($key, $this->translations) ? $this->translations[$key] : "";
    }
} 