<?php

/**
 * Description of Mailer
 *
 * @author ozntone
 */
class Mailer {

    function send($to, $from, $subject, $body) {
        $headers = 'From: <oz.ntone@gmail.com>\r\n';

        return mail($to, $subject, $body, $headers);
    }

}

?>
