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
    public static function convertToSheetValue($values)
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

}