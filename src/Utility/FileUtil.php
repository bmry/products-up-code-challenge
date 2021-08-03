<?php


namespace App\Utility;


class FileUtil
{
    public static function getFileType(string $filePath):string
    {
        $fileInfo =   pathinfo($filePath);

        return $fileInfo['extension'];

    }

    public static function getFullPath($filePath)
    {
        if(strpos($filePath,'http') || strpos($filePath,'ftp') ){
            return $filePath;
        }

        return getenv('HOME').'/'.$filePath;
    }
}