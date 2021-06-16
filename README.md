# Crypt
Crypt component

## Install

`composer require alonity/crypt`

### Examples
```php
use alonity\crypt\Crypt;

require('vendor/autoload.php');

// Generate random string 20 length
echo Crypt::random(20);
```