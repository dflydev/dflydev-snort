Snort - Text or Binary
======================

Buffer analysis to determine whether a Buffer is more likely to represent text
or binary data.


Requirements
------------

 * PHP 5.3+


Installation
------------

Through [Composer][1] as [dflydev/snort-textorbinary][2].


Usage
-----

```php
<?php

require __DIR__.'/vendor/autoload.php';

$resource = fopen('/path/to/a/file', 'r');
$bytes = fread($resource, 512);

$buffer = new Dflydev\Snort\Buffer\Buffer;
$buffer->addData($bytes, 0, strlen($bytes));

$sniffer = new Dflydev\Snort\TextOrBinary\TextOrBinarySniffer;

if ($sniffer->isLikelyText($buffer)) {
	print "Well, probably text? (as best as we can guess in 512 bytes...)\n";
}

if ($sniffer->isLikelyBinary($buffer)) {
	print "Well, probably binary? (as best as we can guess in 512 bytes...)\n";
}

if ($sniffer->isMostlyAscii($buffer)) {
    print "Yup, Mostly ASCII!\n";
}

if ($sniffer->looksLikeUtf8($buffer)) {
    print "Yup, UTF-8!\n";
}
```


License
-------

MIT, see LICENSE.


Community
---------

If you have questions or want to help out, join us in the **#dflydev** channel
on **irc.freenode.net** or mention [@dflydev][4] on Twitter.


Not Invented Here
-----------------

This work was heavily influenced by [Apache Tika][3].


[1]: http://getcomposer.org
[2]: https://packagist.org/packages/dflydev/snort-textorbinary
[3]: http://tika.apache.org
[4]: https://twitter.com/dflydev
