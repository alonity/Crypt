<?php

use alonity\crypt\Crypt;

ini_set('display_errors', true);
error_reporting(E_ALL);

require_once('../vendor/autoload.php');

// Generate random string 20 length
echo Crypt::random(20);

// Generate random integer from 0 to 10000
echo Crypt::randomInt(0, 10000);

// Encode string by key
echo Crypt::encodeString('Hello', 'MySuperPassword');

// Decode string by key
echo Crypt::decodeString('kYqzuk0hHXnwm65/3oG3kYa0A9XrNMYUjtELDRQW8AjxmfLhPZloFrEbNGguTkvAgpM7hZ7SOED+8drynG4/3w==', 'MySuperPassword');

// Generate password hash (bcrypt)
echo Crypt::createPassword('MySuperPassword');

if(!Crypt::verifyPassword('MySuperPassword', '$2y$12$Dia.GNzsOtDYY9g4PmxcgeXhlEFQOgdCX7o2u0lEbFkehhpi6UnX.')){
    echo 'Verify!';
}else{
    echo 'Wrong password!';
}

?>