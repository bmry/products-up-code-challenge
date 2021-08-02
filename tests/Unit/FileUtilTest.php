<?php


namespace App\Unit\Tests;


use App\Utility\FileUtil;
use PHPUnit\Framework\TestCase;

class FileUtilTest extends TestCase
{
    public function test_That_XML_Is_Return_If_XML_File_Is_Passed()
    {
        $file = 'sample.xml';
        $this->assertEquals(FileUtil::getFileType($file), 'xml');
    }

    public function test_That_XML_Is_Not_Return_If_Txt_File_Is_Passed()
    {
        $file = 'sample.txt';
        $this->assertNotEquals(FileUtil::getFileType($file), 'xml');
    }
}