<?php

/**
 * Created by Naumce Ivanovski
 * Date: 12/4/2018
 */
// Request Post Variable

require_once 'PrimeYear.php';
require_once 'Library/Api.php';
require_once 'Library/Security.php';
require_once 'Library/Http.php';
require_once 'Library/DB.php';

use Pxl\PrimeYear;
use Pxl\Library\Api;
use Pxl\Library\Security;
use Pxl\Library\Http;
use Pxl\Library\DB;

//security request method GET,POST from xss and sq linjectio
$http_clear = new Http();

define('DB_HOST', 'localhost'); // set database host
define('DB_USER', 'root'); // set database user
define('DB_PASS', 'admin'); // set database password 
define('DB_NAME', 'pxl'); // set database password 
$database = new DB;


$year = $_POST['year'];
$list = new PrimeYear($year);


foreach ($list->get_prime_years() as $value) {
    $database->insert($value['year'],$value['crypt']);
}


return Api::json_response($list->get_prime_years());

?>