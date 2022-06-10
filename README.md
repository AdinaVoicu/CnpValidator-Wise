# CnpValidator-Wise


# Requirements

PHP >= 8.0

## How to install?

### 1. use composer
```php
composer install
```

## How to use?

```php
<?php
require __DIR__ . '\vendor\autoload.php';
use Library\CNP;

$cnpValue = '2890905230065';

$cnp = new Cnp($cnpValue);
if ($cnp->getIsValid()) {
    echo "CNP {$cnpValue} - is valid" . PHP_EOL;
} else {
    echo "CNP {$cnpValue} is invalid" . PHP_EOL;
}

```
## To test open a terminal and run command:

./vendor/bin/phpunit --bootstrap ./vendor/autoload.php
```


## License

This package is licensed under the [MIT](http://opensource.org/licenses/MIT) license.
