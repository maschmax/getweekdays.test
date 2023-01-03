<?php namespace Masch\Getweekdays\utilities;

/**
 * Class CalculateWeekdayFromDate
 * Calculates the weekday from any date, starting from when we changed calendar from Julian calendar to Gregorian calender 1752.
 * @package Utilities.
 */
class CalculateWeekdayFromDate
{
    const STARTING_YEAR = 1752;


    protected static $monthCodes = [
        1  => 0,
        2  => 3,
        3  => 3,
        4  => 6,
        5  => 1,
        6  => 4,
        7  => 6,
        8  => 2,
        9  => 5,
        10 => 0,
        11 => 3,
        12 => 5,
    ];

    protected static $centuryCodes = [
        17 => 4,
        18 => 2,
        19 => 0,
        20 => 6,
        21 => 4,
        22 => 2,
        23 => 0,
    ];

    protected static $weekdayCodes = [
        0 => "Sunday",
        1 => "Monday",
        2 => "Tuesday",
        3 => "Weednesday",
        4 => "Thursday",
        5 => "Friday",
        6 => "Saturday"
    ];

    /**
     * @param int $year
     * @param int $month
     * @param int $day
     *
     * @return array
     */
    public function getWeekday(int $year, int $month, int $day): array
    {

        if (false == $this->validateYear($year)) {
            return ['error' => 'The year was not in correct format.'];
        }
        if (false == $this->validateMonth($month)) {
            return ['error' => 'The month was not in correct format.'];
        }
        if (false == $this->validateDay($day)) {
            return ['error' => 'The day was not in correct format.'];
        }

        $yearCode     = $this->getYearCode($year);
        $monthCode    = $this->getMonthCode($month);
        $centuryCode  = $this->getCenturyCode($year);
        $leapYearCode = $this->getLeapYearCode($year, $month);
        $weekday      = $this->getTheWeekday($yearCode, $monthCode, $centuryCode, $day, $leapYearCode);

        return ["weekday" => $weekday];
    }

    /**
     * @param int  $yearCode
     * @param int  $monthCode
     * @param int  $centuryCode
     * @param int  $day
     * @param int  $leapYearCode
     *
     * @return string|null
     */
    public function getTheWeekday(int $yearCode, int $monthCode,int $centuryCode,int $day,int $leapYearCode): ?string
    {
        $sumOfCodes = $yearCode + $monthCode + $centuryCode + $day + $leapYearCode;
        $weekdayNumber = $sumOfCodes % 7;

        return self::$weekdayCodes[$weekdayNumber];
    }

    /**
     * @param int $year
     *
     * @return bool
     */
    public function validateYear(int $year): bool
    {
        if ($year <= self::STARTING_YEAR) {
            return false;
        }
        if (false === preg_match(' /^\d{4}$/', $year)) {
            return false;
        }
        return true;
    }

    /**
     * @param int $month
     *
     * @return bool
     */
    public function validateMonth(int $month): bool
    {

        if (preg_match('/^([1-9]|1[012])$/', $month)) {
            return true;
        }
        return false;
    }

    /**
     * @param int $day
     *
     * @return bool
     */
    public function validateDay(int $day): bool
    {

        if (preg_match('/^([1-9]|1[0-9]|2[0-9]|3[01])$/', $day)) {
            return true;
        }
        return false;
    }

    /**
     * @param int $year
     *
     * @return int
     */
    public function getYearCode(int $year): int
    {
        $shortYear                       = substr($year, -2);
        $shortYearDividedWithoutDecimals = (int)($shortYear / 4);
        return ($shortYear + $shortYearDividedWithoutDecimals) % 7;
    }

    /**
     * @param int $month
     *
     * @return integer
     */
    public function getMonthCode(int $month): int
    {
        return self::$monthCodes[$month];
    }

    /**
     * @param int $year
     *
     * @return integer
     */
    public function getCenturyCode(int $year)
    {
        $century = substr($year, 0, 2);
        return self::$centuryCodes[$century];
    }

    /**
     * If you can divide a Gregorian year by 4, it’s a leap year,
     * unless it’s divisible by 100. But it is a leap year if it’s divisible by 400.
     *
     * @param int $year
     * @param int $month
     *
     * @return int
     */
    public function getLeapYearCode(int $year, int $month): int
    {
        // Not leap year.
        if(0 !== $year % 4){
           return 0;
        }
        // A leap year.
        if(0 === $year % 400){
            if(true === $this->isJanuaryOrFebruari($month)){
                return -1;
            }
            return 0;
        }
        // A leap year.
        if(0 !== $year % 100){
            if(true === $this->isJanuaryOrFebruari($month)){
                return -1;
            }
            return 0;
        }
        // Not a leap year.
        return 0;
    }

    /**
     * @param $month
     *
     * @return bool
     */
    public function isJanuaryOrFebruari($month){
        return   (1 === $month OR 2 === $month)? true : false;
    }
}
