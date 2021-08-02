<?php
/**
 * Created by PhpStorm.
 * User: morayobamgbose
 * Date: 02/08/2021
 * Time: 2:37 AM
 */

namespace App\Utility;


class GoogleSheetUtil
{
    public static function convertArrayToSpreadsheetValue($values)
    {
        $rowValues = [];

        foreach ($values as $value){

            if(is_array($value) && empty($value)) {
                $rowValues[] = '';
                continue;
            }

            $rowValues[] = $value;
        }

        return $rowValues;
    }


    public static function buildHeaderRange(int $columnLenght, $start= 'A')
    {
        $ranges = [];

        $ranges [] = $start;

        for ($i = $start, $i < $columnLenght; $i++;) {
            $ranges[] = $i;

            if(count($ranges) == $columnLenght){
                break;
            }
        }

        $firstRange = $ranges[0].'1';
        $lastRange = $ranges[$columnLenght-1].'1';
        $headerRange = $firstRange.':'.$lastRange;

        return $headerRange;
    }

}