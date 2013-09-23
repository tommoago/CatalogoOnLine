<?php
session_start();
require_once '../../vendor/twig/twig/lib/Twig/Autoloader.php';

Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../../templates');
$twig = new Twig_Environment($loader/* , array('cache' => '.../../templates/cache',) */);
$template = $twig->loadTemplate('user/profile/sign_up.phtml');

$var = "Privacy

            TRATTAMENTO DEI DATI PERSONALI

            (Privacy policy ai sensi dell’art. 13 del d.lgs. 196/2003)

            La informiamo che i dati che fornirà al gestore del presente sito al momento della compilazione del 'form contatti' (detto anche form mail) del sito stesso, saranno trattati nel rispetto delle disposizioni di cui al d.lgs. 196/2003, Codice in materia di protezione dei dati personali.

            Il form contatti messo a disposizione sul sito ha il solo scopo di consentire ai visitatori del sito di contattare, qualora lo desiderino, il gestore del sito stesso, inviando tramite il suddetto form una email al gestore.

            La presente informativa riguarda i dati personali inviati dall’utente visitatore al momento della compilazione del form contatti.

            La informiamo del fatto che i dati che conferirà volontariamente tramite il form verranno tramutati in una email che eventualmente potrà essere conservata all’interno del sistema di ricezione di email utilizzato dal titolare del sito.

            Questi dati non verranno registrati su altri supporti o dispositivi, nè verranno registrati altri dati derivanti dalla sua navigazione sul sito.

            1. FINALITÀ DEL TRATTAMENTO DEI DATI PERSONALI

            Le finalità del trattamento dei suoi dati sono le seguenti:

            I dati da lei inviati verranno utilizzati al solo scopo di poterla eventualmente ricontattare tramite i riferimenti da lei lasciati tramite il form contatti per evadere eventuali sue richieste contenute nel messaggio da lei inviato tramite il form contatti messo a disposizione sul sito.

            2. NATURA DEI DATI TRATTATI E MODALITÀ DEL TRATTAMENTO

            a. I dati personali trattati saranno esclusivamente i dati comuni strettamente necessari e pertinenti alle finalità di cui al punto 1 che precede.

            b. Il trattamento dei dati personali conferiti è realizzato per mezzo delle operazioni o del complesso delle operazioni indicate all’art. 4 comma 1 lett. a) D. Lgs. 196/2003.

            c. Il trattamento è svolto direttamente dall’organizzazione del titolare.

            3. NATURA DEL CONFERIMENTO E CONSEGUENZE DEL RIFIUTO

            Non vi é alcun obbligato a conferire al gestore del presente sito i dati personali richiesti nel form contatti.

            Il conferimento dei dati tramite form contatti è facoltativo.

            Tuttavia il rifiuto al conferimento per le finalità di cui all’art. 1 determinerà l’impossibilità di contattare il gestore del sito web tramite il form contatti messo a disposizione sul sito.

            4. TITOLARE DEL TRATTAMENTO

            I dati personali raccolti mediante il form contatti saranno inviati via email al gestore del presente sito web, che sarà titolare del trattamento.

            5. DIRITTI DELL’INTERESSATO

            In ogni momento potrà esercitare i diritti a lei attribuiti dall’art, 7 del d.lgs. 196/2003 che riportiamo qui di seguito, scrivendo al gestore del presente sito web tramite il form contatti.

            Art. 7. del d.lgs. 196/2003

            Diritto di accesso ai dati personali ed altri diritti

            1. L’interessato ha diritto di ottenere la conferma dell’esistenza o meno di dati personali che lo riguardano, anche se non ancora registrati, e la loro comunicazione in forma intelligibile.

            2. L’interessato ha diritto di ottenere l’indicazione:

            a) dell’origine dei dati personali;

            b) delle finalità e modalità del trattamento;

            c) della logica applicata in caso di trattamento effettuato con l’ausilio di strumenti elettronici;

            d) degli estremi identificativi del titolare, dei responsabili e del rappresentante designato ai sensi dell’articolo 5, comma 2;

            e) dei soggetti o delle categorie di soggetti ai quali i dati personali possono essere comunicati o che possono venirne a conoscenza in qualità di rappresentante designato nel territorio dello Stato, di responsabili o incaricati.

            3. L’interessato ha diritto di ottenere:

            a) l’aggiornamento, la rettificazione ovvero, quando vi ha interesse, l’integrazione dei dati;

            b) la cancellazione, la trasformazione in forma anonima o il blocco dei dati trattati in violazione di legge, compresi quelli di cui non è necessaria la conservazione in relazione agli scopi per i quali i dati sono stati raccolti o successivamente trattati;

            c) l’attestazione che le operazioni di cui alle lettere a) e b) sono state portate a conoscenza, anche per quanto riguarda il loro contenuto, di coloro ai quali i dati sono stati comunicati o diffusi, eccettuato il caso in cui tale adempimento si rivela impossibile o comporta un impiego di mezzi manifestamente sproporzionato rispetto al diritto tutelato.

            4. L’interessato ha diritto di opporsi, in tutto o in parte:

            a) per motivi legittimi al trattamento dei dati personali che lo riguardano, oltre che pertinenti allo scopo della raccolta;

            b) al trattamento di dati personali che lo riguardano a fini di invio di materiale pubblicitario o di vendita diretta o per il compimento di ricerche di mercato o di comunicazione commerciale.

            6. DURATA DEL TRATTAMENTO

            Il trattamento avrà una durata non superiore a quella necessaria alle finalità per le quali i dati sono stati raccolti.";

$var2 =  utf8_decode($var);

$template->display(array("var" => $var));
?>
