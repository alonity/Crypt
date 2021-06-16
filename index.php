<?php

use alonity\crypt\Crypt;

require('vendor/autoload.php');

echo Crypt::createPassword('MySuperPassword');

?>