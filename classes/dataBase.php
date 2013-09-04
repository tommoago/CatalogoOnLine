<?php

/**
 * Description of dataBase
 *
 * @author ozntone
 */
class dataBase {

    var $DBH;

    function connect() {

        $conf = array(
            'host' => 'localhost',
            'dbname' => 'melarossa',
            'user' => 'root',
            'pass' => 'root');
        
        $confProd = array(
            'host' => 'sql.ozntone.com',
            'dbname' => 'ozntonec41438',
            'user' => 'ozntonec41438',
            'pass' => 'oznt50584');

        try {
            $DBH = new PDO('mysql:host='.$conf['host'].';dbname='.$conf['dbname'], $conf['user'], $conf['pass']);
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
