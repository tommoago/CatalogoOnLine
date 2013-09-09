<?php

/**
 * Description of Mailer
 *
 * @author ozntone
 */
class Mailer {

    function send($to, $from, $subject, $body) {
//        $headers = 'From:-f <oz.ntone@gmail.com>\r\n';
//
//        return mail($to, $subject, $body, $headers);

$intestazione = "From: Mario Rossi <oz.ntone@gmail.com>\n";
$intestazione .= "Cc: amministrazione@consoftinformatica.it\n";
$intestazione .= "Bcc: selezione@consoftinformatica.it\n";
$intestazione .= "X-Priority: 3\r\n"; // 2 = urgente, 3 = normale, 4 = non urgente

$destinatario = $to;

$oggetto = $subject;

$messaggio = $body;

$parametri = "-f oz.ntone@gmail.com";

return mail($destinatario, $oggetto, $messaggio, $intestazione, $parametri);
    }

}

?>
