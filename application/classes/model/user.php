<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user
 *
 * @author Fanqie
 */
class Model_User {

    public function Validate($_POSTs) {

        $post = Validate::factory($_POST)->filter(TRUE, 'trim')
        ->rules('email', array(
            'not_empty' => NULL,
            'matches' => array('another_field')
        ));
        //   echo Kohana::debug(Validate::email($_POSTs['email']));
        echo Kohana::debug($post);
    }

}

?>
