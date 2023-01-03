<?php namespace Masch\Getweekdays\Tests\Utilities;

use Masch\Getweekdays\utilities\CalculateWeekdayFromDate;
use PHPUnit\Framework\TestCase;

/**
 * 
 */
class CalculateWeekdayFromDateTest extends TestCase
{
    /**
     * @return void
     */
    public function testCanValidateYear(){
        // Arrange.
        $someYear = 1834;
        $calculator = new CalculateWeekdayFromDate();

        // Act
        $validYear= $calculator->validateYear($someYear);

        // Assert.
        $this->assertTrue($validYear, " The year ".$someYear." expected to be valid but was not.");
    }
    /**
     * @return void
     */
    public function testCanValidateMonth(){
        // Arrange.
        $someMonth = 12;
        $calculator = new CalculateWeekdayFromDate();

        // Act
        $validMonth= $calculator->validateMonth($someMonth);

        // Assert.
        $this->assertTrue($validMonth, " The month ".$someMonth." expected to be valid but was not.");
    }
    /**
     * @return void
     */
    public function testCanValidateDay(){
        // Arrange.
        $someDay = 31;
        $calculator = new CalculateWeekdayFromDate();

        // Act
        $validDay= $calculator->validateDay($someDay);

        // Assert.
        $this->assertTrue($validDay, " The day ".$someDay." expected to be valid but was not.");
    }
    /**
     * @return void
     */
    public function testCanGetYearCode(){
        // Arrange.
        $someYear = 2022;
        $expectedYearCode = 6;
        $calculator = new CalculateWeekdayFromDate();

        // Act
        $yearCode = $calculator->getYearCode($someYear);

        // Assert.
        $this->assertSame($expectedYearCode,$yearCode, " YearCode was ".$yearCode. " but should have been ".$expectedYearCode);
    }
    /**
     * @return void
     */
    public function testCanGetMonthCode(){
        // Arrange.
        $someMonth = 5;
        $expectedMonthCode = 1;
        $calculator = new CalculateWeekdayFromDate();

        // Act
        $monthCode = $calculator->getMonthCode($someMonth);

        // Assert.
        $this->assertSame($expectedMonthCode,$monthCode, " CenturyCode was ".$monthCode. " but should have been ".$expectedMonthCode);
    }
    /**
     * @return void
     */
    public function testCanGetCenturyCode(){
        // Arrange.
        $someYear = 2022;
        $expectedCenturyCode = 6;
        $calculator = new CalculateWeekdayFromDate();

        // Act
        $centuryCode = $calculator->getCenturyCode($someYear);

        // Assert.
        $this->assertSame($expectedCenturyCode,$centuryCode, " CenturyCode was ".$centuryCode. " but should have been ".$expectedCenturyCode);
    }

    /**
     * @return void
     */
    public function testCanGetLeapYearCode(): void
    {
        // Arrange.
        $someYear = 2024;
        $month = 2;
        $expectedLeapYearCode = -1;
        $calculator = new CalculateWeekdayFromDate();

        // Act
        $leapYearCode = $calculator->getLeapYearCode($someYear, $month);

        // Assert.
        $this->assertSame($expectedLeapYearCode,$leapYearCode, " LeapYearCode was ".$leapYearCode. " but should have been ".$expectedLeapYearCode);
    }

    /**
     * @dataProvider setsDateAndAssertWeekday
     * @param $someYear
     * @param $someMonth
     * @param $someDay
     */
    public function testSucceedsToGetWeekday($someYear,$someMonth,$someDay,$expectedWeekday)
    {

        // Arrange.
        $calculator = new CalculateWeekdayFromDate();

        // Act
        $weekdayArray = $calculator->getWeekday( $someYear,$someMonth, $someDay);
        $actualWeekday = $weekdayArray['weekday'];
        // Assert.
        $this->assertSame($expectedWeekday,$actualWeekday, " The weekday was ".$actualWeekday. " but should have been ".$expectedWeekday);
    }

    /**
     * @return array
     */
    public function setsDateAndAssertWeekday(): array
    {
        return [
            /**
             * setYear, month, day, weekday, assertionErrorMessage
             */
            ['2018', '11', '7', 'Weednesday', 'The day should have been Weednesday.'],
            ['2003', '2', '3', 'Monday', 'The day should have been Monday.'],
            ['1998', '11', '26', 'Thursday', 'The day should have been Thursday.'],
            ['1981', '6', '20', 'Saturday', 'The day should have been Saturday.'],
        ];
    }

    /**
     * @return void
     */
    public function testSucceedsToGetWeekdayEvenIfLeapYear(): void
    {

        // Arrange.
        $someYear        = 2016;
        $someMonth       = 1;
        $someDay         = 1;
        $expectedWeekday = 'Friday';
        $calculator      = new CalculateWeekdayFromDate();

        // Act
        $weekdayArray  = $calculator->getWeekday($someYear, $someMonth, $someDay);
        $actualWeekday = $weekdayArray['weekday'];
        // Assert.
        $this->assertSame($expectedWeekday, $actualWeekday, " The weekday was " . $actualWeekday . " but should have been " . $expectedWeekday);
    }
}
