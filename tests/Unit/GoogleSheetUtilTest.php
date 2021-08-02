<?php
/**
 * Created by PhpStorm.
 * User: morayobamgbose
 * Date: 02/08/2021
 * Time: 8:20 PM
 */

namespace App\Unit\Tests;


use App\Utility\GoogleSheetUtil;
use PHPUnit\Framework\TestCase;

class GoogleSheetUtilTest extends TestCase
{
    public function testRangeBuilderWillReturn_Expected_Range_When_ColumnLength_Is_18()
    {
        $expectedResult = 'A1:R1';
        $actualResult = GoogleSheetUtil::buildHeaderRange(18);
        $this->assertEquals($expectedResult, $actualResult);
    }

    public function testRangeBuilderWillReturn_Expected_Result_When_ColumnLength_Is_5()
    {
        $expectedResult = 'A1:E1';
        $actualResult = GoogleSheetUtil::buildHeaderRange(5);
        $this->assertEquals($expectedResult, $actualResult);
    }

    public function test_RangeBuilder_Will_Return_Expected_When_ColumnLength_Is_5_And_Start_Column_is_E()
    {
        $expectedResult = 'E1:I1';
        $actualResult = GoogleSheetUtil::buildHeaderRange(5, 'E');
        $this->assertEquals($expectedResult, $actualResult);
    }

}