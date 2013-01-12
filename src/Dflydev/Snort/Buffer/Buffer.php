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
            $byte = $buffer[$i];
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

    public function countRange($from, $to)
    {
        if ($from < 0 || $from > $to) {
            throw new \InvalidArgumentException('Invalid range');
        }

        $count = 0;
        for ($i = $from; $i < $to; $i++) {
            $count += $this->count($i);
        }

        return $count;
    }
}
