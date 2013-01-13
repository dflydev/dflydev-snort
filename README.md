Snort
=====

Sniff content to determine things about it.

Partial implementation of [Content-Type Processing Model draft][1] as inspired
by [Apache Tika][4].


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
on **irc.freenode.net** or mention [@dflydev][5] on Twitter.


Not Invented Here
-----------------

This work was heavily influenced by [Apache Tika][4] and the information
available from the [Content-Type Processing Model draft][1].


[1]: http://tools.ietf.org/html/draft-abarth-mime-sniff-01
[2]: http://getcomposer.org
[3]: https://packagist.org/packages/dflydev/snort
[4]: http://tika.apache.org
[5]: https://twitter.com/dflydev
