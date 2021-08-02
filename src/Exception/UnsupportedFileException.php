<?php

namespace App\Exception;


use Throwable;

class UnsupportedFileException extends ProductsUpException
{
    const MESSAGE = "The file type is not supported.";

    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct(self::MESSAGE, $code, $previous);
    }

}