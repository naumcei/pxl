<?php

/**
 * Created by Naumce Ivanovski
 * Date: 12/4/2018
 */

namespace Pxl\Library;

class Api {

    public function json_response($json_data) {
        header('Content-Type: application/json');
        echo json_encode($json_data);
    }

}

?>