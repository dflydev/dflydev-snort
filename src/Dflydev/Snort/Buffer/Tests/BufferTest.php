<?php

namespace Dflydev\Snort\Buffer\Tests;

use Dflydev\Snort\Buffer\Buffer;

class BufferTest extends \PHPUnit_Framework_TestCase
{
    public function testZeroTotalToStart()
    {
        $buffer = new Buffer;

        $this->assertEquals(0, $buffer->total());
    }

    public function testAddDataAddsData()
    {
        $data = "data";

        $buffer = new Buffer;

        $buffer->addData($data, 0, strlen($data));
        $this->assertEquals(4, $buffer->total());

        $buffer->addData($data, 0, strlen($data));
        $this->assertEquals(8, $buffer->total());
    }

    public function testCount()
    {
        $data = 'aaaabbbccd';

        $buffer = new Buffer;

        $this->assertEquals(0, $buffer->count(ord('a')));
        $this->assertEquals(0, $buffer->count(ord('b')));
        $this->assertEquals(0, $buffer->count(ord('c')));
        $this->assertEquals(0, $buffer->count(ord('d')));
        $this->assertEquals(0, $buffer->count(ord('e')));

        $buffer->addData($data, 0, strlen($data));

        $this->assertEquals(4, $buffer->count(ord('a')));
        $this->assertEquals(3, $buffer->count(ord('b')));
        $this->assertEquals(2, $buffer->count(ord('c')));
        $this->assertEquals(1, $buffer->count(ord('d')));
        $this->assertEquals(0, $buffer->count(ord('e')));
    }

    public function testAddDataOffset()
    {
        $data = 'aaaabbbccd';

        $buffer = new Buffer;

        $buffer->addData($data, 3, strlen($data) - 3);

        $this->assertEquals(1, $buffer->count(ord('a')));
        $this->assertEquals(3, $buffer->count(ord('b')));
        $this->assertEquals(2, $buffer->count(ord('c')));
        $this->assertEquals(1, $buffer->count(ord('d')));
        $this->assertEquals(0, $buffer->count(ord('e')));
    }

    public function testCountRange()
    {
        $data = 'aaaabbbccd';

        $buffer = new Buffer;

        $buffer->addData($data, 0, strlen($data));

        $this->assertEquals(10, $buffer->countRange(ord('a'), ord('z')));
        $this->assertEquals(10, $buffer->countRange(ord('a'), ord('e')));
        $this->assertEquals(9, $buffer->countRange(ord('a'), ord('d')));
        $this->assertEquals(6, $buffer->countRange(ord('b'), ord('e')));
    }

    public function testCountRangeSameValueForToAndFrom()
    {
        $data = 'aaaabbbccd';

        $buffer = new Buffer;

        $buffer->addData($data, 0, strlen($data));

        $this->assertEquals(4, $buffer->countRange(ord('a'), ord('b')));
        $this->assertEquals(1, $buffer->countRange(ord('d'), ord('e')));
        $this->assertEquals(0, $buffer->countRange(ord('e'), ord('f')));
        $this->assertEquals(0, $buffer->countRange(ord('y'), ord('z')));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCountRangeNegativeFrom()
    {
        $buffer = new Buffer;
        $buffer->countRange(-1, 0);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCountRangeFromEqualsTo()
    {
        $buffer = new Buffer;
        $buffer->countRange(0, 0);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCountRangeToLessThanFrom()
    {
        $buffer = new Buffer;
        $buffer->countRange(1, 0);
    }
}
