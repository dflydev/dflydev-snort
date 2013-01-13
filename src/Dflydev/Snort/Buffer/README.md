Snort - Buffer
==============

Byte buffer statistics and analaysis.


Requirements
------------

 * PHP 5.3+


Installation
------------

Through [Composer][1] as [dflydev/snort-buffer][2].


Usage
-----

```php
<?php

require __DIR__.'/vendor/autoload.php';

$resource = fopen('/path/to/a/file', 'r');
$bytes = fread($resource, 512);

$buffer = new Dflydev\Snort\Buffer\Buffer;
$buffer->addData($bytes, 0, strlen($bytes));

// Number of occurances of the ASCII letter 'a'.
print $buffer->count(0x61) . "\n";

// Number of occurances of any ASCII character
// between 32-127.
print $buffer->countRange(0x20, 128) . "\n";
```


License
-------

MIT, see LICENSE.


Not Invented Here
-----------------

This work was heavily influenced by [Apache Tika][3].


[1]: http://getcomposer.org
[2]: https://packagist.org/packages/dflydev/snort
[3]: http://tika.apache.org
