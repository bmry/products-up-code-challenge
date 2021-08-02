<?php

namespace App\Service\ContentWriter;



class ContentWriterFactory
{
    private  $googleSheetXMLWriter;

    /**
     * ContentWriterFactory constructor.
     * @param GoogleSheetXMLWriter $googleSheetXMLWriter
     */
    public function __construct(GoogleSheetXMLWriter $googleSheetXMLWriter)
    {
        $this->googleSheetXMLWriter = $googleSheetXMLWriter;
    }

    /**
     * @param string $type
     * @return ContentWriterInterface
     */
    public function build(string $type): ?ContentWriterInterface
    {
        switch ($type){
            case ContentWriterInterface::GOOGLE_XML_WRITER:
                return $this->googleSheetXMLWriter;
            default:
               return null;
        }
    }
}