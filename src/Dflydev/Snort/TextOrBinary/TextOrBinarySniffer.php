<?php

namespace Dflydev\Snort\TextOrBinary;

use Dflydev\Snort\Buffer\Buffer;

class TextOrBinarySniffer
{
    public function isLikelyText(Buffer $buffer)
    {
        return $this->isMostlyAscii($buffer) || $this->looksLikeValidUtf8($buffer);
    }

    public function isLikelyBinary(Buffer $buffer)
    {
        return !$this->isLikelyText($buffer);
    }

    public function isMostlyAscii(Buffer $buffer)
    {
        $control = $buffer->countRange(0, 0x20);
        $ascii = $buffer->countRange(0x20, 128);
        $safe = $this->countSafeControl($buffer);

        $total = $buffer->total();

        return $total > 0
            && ($control - $safe) * 100 < $total * 2
            && ($ascii + $safe) * 100 > $total * 90;
    }

    public function looksLikeValidUtf8(Buffer $buffer)
    {
        $control = $buffer->countRange(0, 0x20);
        $utf8 = $buffer->countRange(0x20, 0x80);
        $safe = $this->countSafeControl($buffer);

        $expectedContinuation = 0;
        $leading = array(
            $buffer->countRange(0xc0, 0xe0),
            $buffer->countRange(0xe0, 0xf0),
            $buffer->countRange(0xf0, 0xf8),
        );

        for ($i = 0; $i < count($leading); $i++) {
            $utf8 += $leading[$i];
            $expectedContinuation += ($i + 1) * $leading[$i];
        }

        $continuation = $buffer->countRange(0x80, 0xc0);

        return $utf8 > 0
            && $continuation <= $expectedContinuation
            && $continuation >= $expectedContinuation - 3
            && ($control - $safe) * 100 < $utf8 * 2;
    }

    public function countControl(Buffer $buffer)
    {
        return $buffer->countRange(0, 0x20) - $this->countSafeControl($buffer);
    }

    public function countSafeControl(Buffer $buffer)
    {
        return
            $buffer->count(ord("\t")) +
            $buffer->count(ord("\n")) +
            $buffer->count(ord("\r")) +
            $buffer->count(0x0c) +
            $buffer->count(0x1b);
    }
}
