<?php

namespace ValueObjects\Tests\DateTime;

use ValueObjects\DateTime\Month;
use ValueObjects\DateTime\MonthDay;
use ValueObjects\DateTime\Year;
use ValueObjects\Tests\TestCase;
use ValueObjects\DateTime\Date;

class DateTest extends TestCase
{
    public function testFromNativeDateTime()
    {
        $nativeDate = new \DateTime('today');
        $dateFromNative = Date::fromNativeDateTime($nativeDate);
        $constructedDate = new Date($nativeDate->format('Y'), $nativeDate->format('m'), $nativeDate->format('d'));

        $this->assertTrue($dateFromNative->equals($constructedDate));
    }

    public function testNow()
    {
        $date = Date::now();
        $this->assertEquals(date('Y-n-j'), \strval($date));
    }

    /** @expectedException ValueObjects\DateTime\Exception\InvalidDateException */
    public function testInvalidDateException()
    {
        new Date(2013, 13, 41);
    }

    /** @expectedException ValueObjects\DateTime\Exception\InvalidDateException */
    public function testAlmostValidDateException()
    {
        new Date(2013, 2, 31);
    }

    public function testEquals()
    {
        $date1 = new Date(2013, 12, 3);
        $date2 = new Date(2013, 12, 3);
        $date3 = new Date(2013, 12, 5);

        $this->assertTrue($date1->equals($date2));
        $this->assertTrue($date2->equals($date1));
        $this->assertFalse($date1->equals($date3));

        $mock = $this->getMock('ValueObjects\ValueObjectInterface');
        $this->assertFalse($date1->equals($mock));
    }

    public function testGetYear()
    {
        $date = new Date(2013, 12, 3);
        $year = new Year(2013);

        $this->assertTrue($year->equals($date->getYear()));
    }

    public function testGetMonth()
    {
        $date  = new Date(2013, 12, 3);
        $month = new Month(12);

        $this->assertTrue($month->equals($date->getMonth()));
    }

    public function testGetDay()
    {
        $date = new Date(2013, 12, 3);
        $day  = new MonthDay(3);

        $this->assertTrue($day->equals($date->getDay()));
    }

    public function testToNativeDateTime()
    {
        $date = new Date(2013, 12, 3);
        $nativeDate = \DateTime::createFromFormat('Y-n-j H:i:s', '2013-12-3 00:00:00');

        $this->assertEquals($nativeDate, $date->toNativeDateTime());
    }

    public function testToString()
    {
        $date = new Date(2013, 12, 3);
        $this->assertEquals('2013-12-3', $date->__toString());
    }

}
