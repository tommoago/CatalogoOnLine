<?php

/**
 * Description of data_Base
 *
 * @author ozntone
 */
class data_Base
{

    var $DBH;

    function connect()
    {

        /* $conf = array(
             'host' => 'sql.ozntone.com',
             'dbname' => 'ozntonec90256',
             'user' => 'ozntonec90256',
             'pass' => 'oznt93536');

         if($_SERVER['HTTP_HOST'] == 'localhost'){*/
        $conf = array(
            'host' => '127.0.0.1:3306',
            'dbname' => 'catalogoonline',
            'user' => 'root',
            'pass' => 'root');
        // }

        try {
            $DBH = new PDO('mysql:host=' . $conf['host'] . ';dbname=' . $conf['dbname'], $conf['user'], $conf['pass']);
            //per loggale errori
            $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $DBH;
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }

    public function getDBH()
    {
        return $this->DBH;
    }

}

?>
