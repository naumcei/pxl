<?php

/**
 * Created by Naumce Ivanovski
 * Date: 12/4/2018
 * @todo Add more Validate methods for $POST 
 */

namespace Pxl\Library;

class DB {

    private $link = null;

    public function __construct() {
        mb_internal_encoding('UTF-8');
        mb_regex_encoding('UTF-8');
        mysqli_report(MYSQLI_REPORT_STRICT);

        try {
            $this->link = new \mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $this->link->set_charset("utf8");
        } catch (Exception $e) {
            die('Unable to connect to database');
        }
    }

    public function __destruct() {
        if ($this->link) {
            $this->disconnect();
        }
    }

    /**
     * Sanitize user data
     */
    public function filter($data) {
        if (!is_array($data)) {
            $data = $this->link->real_escape_string($data);
            $data = trim(htmlentities($data, ENT_QUOTES, 'UTF-8', false));
        } else {
            //Self call function to sanitize array data
            $data = array_map(array($this, 'filter'), $data);
        }
        return $data;
    }

    /**
     * 
     * @param type $data
     * @return Normalize sanitized data for display (reverse $database->filter cleaning)
     */
    public function clean($data) {
        $data = stripslashes($data);
        $data = html_entity_decode($data, ENT_QUOTES, 'UTF-8');
        $data = nl2br($data);
        $data = urldecode($data);
        return $data;
    }

    public function insert($year, $day) {
        
        $year = $this->filter( $year );
        $day = $this->filter( $day );

        $stmt = $this->link->prepare("INSERT INTO `pxl` (`year`, `day`) VALUES (?, ?)");
        $stmt->bind_param("is", $year, $day);
        $stmt->execute();
        
    }

    /**
     * 
     * @param type $query
     * @param type $object
     * @return boolean
     */
    public function get_results($query, $object = false) {
        //Overwrite the $row var to null
        $row = null;

        $results = $this->link->query($query);
        if ($this->link->error) {
            $this->log_db_errors($this->link->error, $query);
            return false;
        } else {
            $row = array();
            while ($r = (!$object ) ? $results->fetch_assoc() : $results->fetch_object()) {
                $row[] = $r;
            }
            return $row;
        }
    }

    public function log_db_errors($error, $query) {
        $message = '<p>Error at ' . date('Y-m-d H:i:s') . ':</p>';
        $message .= '<p>Query: ' . htmlentities($query) . '<br />';
        $message .= 'Error: ' . $error;
        $message .= '</p>';

        echo $message;
    }

    /**
     * Disconnect from db server
     * Called automatically from __destruct function
     */
    public function disconnect() {
        $this->link->close();
    }

}

?>