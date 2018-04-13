<?php

/**
 * Created by Naumce Ivanovski
 * Date: 12/4/2018
 */

namespace Pxl\Library;

class Date {

    protected $year;

    public function __construct($year) {
        $this->year = $year;
    }

    public function get_christmas_day($year) {
        return date("(l)", mktime(0, 0, 0, 12, 25, $year));
    }

}

?>