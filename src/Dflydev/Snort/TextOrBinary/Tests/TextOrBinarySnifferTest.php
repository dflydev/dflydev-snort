<?php

namespace Dflydev\Snort\TextOrBinary\Tests;

use Dflydev\Snort\Buffer\Buffer;
use Dflydev\Snort\TextOrBinary\TextOrBinarySniffer;

class TextOrBinarySnifferTest extends \PHPUnit_Framework_TestCase
{
    public function testSimple()
    {
        $buffer = new Buffer;

        $bytes = "Hello World!";

        $buffer->addData($bytes, 0, strlen($bytes));

        $sniffer = new TextOrBinarySniffer;

        $this->assertTrue($sniffer->isLikelyText($buffer));
        $this->assertTrue($sniffer->looksLikeValidUtf8($buffer));
        $this->assertFalse($sniffer->isLikelyBinary($buffer));
    }
}
