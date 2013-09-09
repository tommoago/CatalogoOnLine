<?php

/**
 * Description of Mailer
 *
 * @author ozntone
 */
class Mailer {

    function send($to, $from, $subject, $body) {
        $intestazione = "From: Mela Rossa <info@ozntone.com>\n";
        $intestazione .= "X-Priority: 3\r\n"; // 2 = urgente, 3 = normale, 4 = non urgente

        $parametri = "-f info@ozntone.com";

        return mail($to, $subject, $body, $intestazione, $parametri);
    }

}

?>
