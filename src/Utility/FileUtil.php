<?php


namespace App\Utility;


class FileUtil
{
    public static function getFileType(string $filePath):string
    {
        $fileInfo =   pathinfo($filePath);

        return $fileInfo['extension'];

    }
}