Snort
=====

Sniff content to determine things about it.

Partially implemented based off of [Content-Type Processing Model draft][1].


Requirements
------------

 * PHP 5.3+


Installation
------------

Through [Composer][2] as [dflydev/snort][3].


Usage
-----

```php
<?php

require __DIR__.'/vendor/autoload.php';

$resource = fopen('/path/to/a/file', 'r');
$bytes = fread($resource, 512);

$buffer = new Dflydev\Snort\Buffer;
$buffer->addData($bytes, 0, strlen($bytes));

$sniffer = new Dflydev\Snort\TextOrBinary\TextOrBinarySniffer($buffer);

if ($sniffer->isMostlyAscii()) {
    print "Yup, Mostly ASCII!\n";
}

if ($sniffer->looksLikeUtf8()) {
    print "Yup, UTF-8!\n";
}
```


License
-------

MIT, see LICENSE.


Not Invented Here
-----------------

This work was heavily influenced by [Apache Tika][4] and the information
available from the [Content-Type Processing Model draft][5].


[1]: http://tools.ietf.org/html/draft-abarth-mime-sniff-01
[2]: http://getcomposer.org
[3]: https://packagist.org/packages/dflydev/snort
[4]: http://tika.apache.org
