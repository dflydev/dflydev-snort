<?php

namespace Dflydev\Snort\Buffer;

class Buffer
{
    private $counts = array();
    private $total = 0;
    private $bytes = array();

    public function addData($buffer, $offset, $length)
    {
        for ($i = 0; $i < $length; $i++) {
            $byte = $buffer[$i + $offset];
            $asciiValue = ord($byte);
            if (!isset($this->counts[$asciiValue])) {
                $this->counts[$asciiValue] = 0;
            }

            $this->counts[$asciiValue]++;
            $this->bytes[] = $byte;
            $this->total++;
        }
    }

    public function total()
    {
        return $this->total;
    }

    public function count($asciiValue)
    {
        if (isset($this->counts[$asciiValue])) {
            return $this->counts[$asciiValue];
        }

        return 0;
    }

    public function countRange($fromInclusive, $toExclusive)
    {
        if ($fromInclusive < 0) {
            throw new \InvalidArgumentException('Invalid range; cannot count from a negative "from" value.');
        }

        if ($fromInclusive > $toExclusive) {
            throw new \InvalidArgumentException('Invalid range; cannot count from a "from" value that is larger than the "to" value.');
        }

        if ($fromInclusive === $toExclusive) {
            throw new \InvalidArgumentException('Invalid range; cannot count from a "from" value to the same "to" value since "to" value is exclusive.');
        }

        $count = 0;
        for ($i = $fromInclusive; $i < $toExclusive; $i++) {
            $count += $this->count($i);
        }

        return $count;
    }
}
