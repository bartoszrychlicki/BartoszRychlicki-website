<html>
<head><title> </title></head>
<body>
<p>There is nothing here to see. So what are you doing here ?</p>
<p><a href="http://www.bartoszrychlicki.com">Go home</a>.</p>
<?php
/* whitelist: end processing end exit */

/* end of whitelist */
$badbot = 0;
/* scan the blacklist.dat file for addresses of SPAM robots
to prevent filling it up with duplicates */
$filename = "../../blacklist.dat";
$fp = fopen($filename, "r") or die ("Error opening file ... <br>\n");
while ($line = fgets($fp,255)) {
    $u = explode(" ",$line);
    $u0 = $u[0];
    if (preg_match("/$u0/",$_SERVER['REMOTE_ADDR'])) {$badbot++;}
}
fclose($fp);
if ($badbot == 0) { /* we just see a new bad bot not yet listed ! */
    /* send a mail to hostmaster */
    $tmestamp = time();
    $datum = date("Y-m-d (D) H:i:s",$tmestamp);
    $from = "badbot-watch@bartoszrychlicki.com";
    $to = "bartosz.rychlicki@gmail.com";
    $subject = "domain-tld alert: bad robot";
        $msg = "A bad robot hit " . $_SERVER['REQUEST_URI'] . " $datum \n";
        $msg .= "address is " . $_SERVER['REMOTE_ADDR'] . ", agent is " . $_SERVER['HTTP_USER_AGENT'] . "\n";
      /* append bad bot address data to blacklist log file: */
        $fp = fopen($filename,'a+');
        fwrite($fp,$_SERVER['REMOTE_ADDR'] . " - - [$datum] " . $_SERVER['REQUEST_METHOD']. ' ' . $_SERVER['REQUEST_URI'] . ' ' .
            $_SERVER['SERVER_PROTOCOL'] .' '. $_SERVER['HTTP_REFERER'] .' '. $_SERVER['HTTP_USER_AGENT'] . "\n");
        fclose($fp);
      }
    @mail($to, $subject, $msg, "From: $from");

?>
</body>
</html>