<?php

/**
 * Description of Mailer
 *
 * @author ozntone
 */
class Mailer {

    function send($to, $from, $subject, $body) {
        if($from == '')
            $from = 'info@ozntone.com';
        $intestazione = "From: Mela Rossa <".$from.">\n";
        $intestazione .= "X-Priority: 3\r\n"; // 2 = urgente, 3 = normale, 4 = non urgente

        $parametri = "-f ".$from;

        return mail($to, $subject, $body, $intestazione, $parametri);
    }

}

?>
