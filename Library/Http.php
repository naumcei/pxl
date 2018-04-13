<?php

/**
 * Created by Naumce Ivanovski
 * Date: 12/4/2018
 */

namespace Pxl\Library;

class Http {

    public function __construct() {
        $this->HttpClean();
    }

    /**
     * security request method GET,POST from xss and sql linjection
     */
    public function HttpClean() {
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' and count($_POST) != 0) {

            foreach ($_POST as $key => $value) {
                $_POST[$key] = htmlspecialchars(addslashes($value));
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' and count($_GET) != 0) {

            foreach ($_GET as $key => $value) {
                $_GET[$key] = htmlspecialchars(addslashes($value));
            }
        }
        
    }

}

?>