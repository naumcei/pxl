<?php

/**
 * Created by Naumce Ivanovski
 * Date: 12/4/2018
 */

namespace Pxl;

require_once 'Library/Date.php';
require_once 'Library/Api.php';
require_once 'Library/Security.php';

use Pxl\Library\Date;
use Pxl\Library\Api;
use Pxl\Library\Security;

class PrimeYear {

    protected $year = "";
    protected $prime_years = [];
    protected $num_of_prime_years = 0;
    

    public function __construct($year) {
        $this->year = $year;
        $this->get_prime_years();
    }

    public function get_prime_years() {
        
        while ($this->num_of_prime_years < 30) {
            $this->year--;

            if ($this->isPrime($this->year)) {

                array_push($this->prime_years, [
                    'year' => $this->year,
                    'crypt' => Security::crypt(Date::get_christmas_day($this->year)),
                    'decrypt' => Security::crypt(Security::crypt(Date::get_christmas_day($this->year)), 'de')
                ]);

                $this->num_of_prime_years++;
            }
        }

        return $this->prime_years;
    }

    public function isPrime($number) {
        $n = abs($number);
        $i = 2;
        while ($i <= sqrt($n)) {
            if ($n % $i == 0) {
                return false;
            }
            $i++;
        }
        return true;
    }

}

?>