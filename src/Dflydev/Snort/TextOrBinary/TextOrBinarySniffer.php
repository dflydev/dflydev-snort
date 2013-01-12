<?php

namespace Dflydev\Snort\TextOrBinary;

use Dflydev\Snort\Buffer;

class TextOrBinarySniffer
{
    public function __construct(Buffer $buffer)
    {
        $this->buffer = $buffer;
    }

    public function isMostlyAscii()
    {
        $control = $this->buffer->countRange(0, 0x20);
        $ascii = $this->buffer->countRange(0x20, 128);
        $safe = $this->countSafeControl();

        $total = $this->buffer->total();

        return $total > 0
            && ($control - $safe) * 100 < $total * 2
            && ($ascii + $safe) * 100 > $total * 90;
    }

    public function looksLikeUtf8()
    {
        $control = $this->buffer->countRange(0, 0x20);
        $utf8 = $this->buffer->countRange(0x20, 0x80);
        $safe = $this->countSafeControl();

        $expectedContinuation = 0;
        $leading = array(
            $this->buffer->countRange(0xc0, 0xe0),
            $this->buffer->countRange(0xe0, 0xf0),
            $this->buffer->countRange(0xf0, 0xf8),
        );

        for ($i = 0; $i < count($leading); $i++) {
            $utf8 += $leading[$i];
            $expectedContinuation += ($i + 1) * $leading[$i];
        }

        $continuation = $this->buffer->countRange(0x80, 0xc0);

        return $utf8 > 0
            && $continuation <= $expectedContinuation
            && $continuation >= $expectedContinuation - 3
            && ($control - $safe) * 100 < $utf8 * 2;
    }

    public function countControl()
    {
        return $this->buffer->countRange(0, 0x20) - $this->countSafeControl();
    }

    public function countSafeControl()
    {
        return
            $this->buffer->count(ord("\t")) +
            $this->buffer->count(ord("\n")) +
            $this->buffer->count(ord("\r")) +
            $this->buffer->count(0x0c) +
            $this->buffer->count(0x1b);
    }
}
