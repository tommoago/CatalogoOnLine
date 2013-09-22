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
            'host' => 'sql.ozntone.com',
            'dbname' => 'ozntonec41438',
            'user' => 'ozntonec41438',
            'pass' => 'oznt50584');
        
        if($_SERVER['HTTP_HOST'] == 'localhost'){
            $conf = array(
                'host' => 'localhost',
                'dbname' => 'melarossa',
                'user' => 'root',
                'pass' => 'root');
        }

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
