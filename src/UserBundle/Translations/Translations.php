<?php
/**
 * Created by PhpStorm.
 * User: marko
 * Date: 06/08/2016
 * Time: 23:19
 */

namespace UserBundle\Translations;

use AppBundle\Translations\BaseTranslation;

class Translations extends BaseTranslation {

    public function __construct(){
        parent::__construct();

        $this->translations = array(
            'Invalid credentials.' => 'Bad password bro.',
            'Account is disabled.' => 'Sorry, you\'re locked out and disabled.'
        );

    }

}

