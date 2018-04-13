<?php

/**
 * Created by Naumce Ivanovski
 * Date: 12/4/2018
 */

namespace Pxl\Library;

class Security {


    /**
     * Encrypt and decrypt
     * 
     * @param string $string string to be encrypted/decrypted
     * @param string $action what to do with this? en for encrypt, de for decrypt
     */
    public function crypt($string, $action = 'en') {
        // you may change these values to your own
        $secret_key = 'W0*3RgsySJGZK3urMLxb';
        $secret_iv = 'f*0DT@PTycnuAq@KrU0e';

        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'en') {
            $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
        } else if ($action == 'de') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

}

?>