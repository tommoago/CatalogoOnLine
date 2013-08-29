<?php

/**
 * Description of dataBase
 *
 * @author ozntone
 */
class dataBase {

    var $DBH;

    function connect() {

        $host = 'localhost';
        $dbname = 'melarossa';
        $user = 'root';
        $pass = 'root';

        try {
            $DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
//            per loggale errori
            $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $DBH;
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }

    public function getDBH() {
        return $this->DBH;
    }

}

?>
