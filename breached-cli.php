<?php

require_once "functions/breached.php";
if (empty(getopt('p:'))) {

        die("You did not specifiy password, please use with -p parameter (php breached-cli.php -p yourpassword) \n");
}
$var=getopt("p:");

CheckIfPasswordIsBreached($var['p'], 1);
