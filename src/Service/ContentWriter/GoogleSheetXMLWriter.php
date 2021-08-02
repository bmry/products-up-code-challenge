<?php

namespace App\Service\ContentWriter;

use App\Service\FileProcessor\FileContent;
use App\Service\GoogleSheetAPIService;
use App\Utility\GoogleSheetUtil;


class GoogleSheetXMLWriter implements ContentWriterInterface
{
    const HEADER_RANGE='A1:R1';

    private $googleSheetAPIService;

    public function __construct(GoogleSheetAPIService $googleSheetAPIService)
    {
        $this->googleSheetAPIService = $googleSheetAPIService;
    }

    /**
     * @param FileContent $content
     * @throws \App\Exception\SheetAPIServiceException
     */
    public function write(FileContent $content): void
    {
        $content = json_decode($content->getContent(), TRUE);
        $spreadSheet = $this->googleSheetAPIService->createSpreadSheet();
        $spreadSheetId = $spreadSheet->getSpreadsheetId();
        $header = $this->googleSheetAPIService->getHeader($spreadSheetId);
        $headerValues = GoogleSheetUtil::convertToSheetValue(array_keys($content));

        if(is_null($header)) {
            $this->googleSheetAPIService->writeToSheet($spreadSheetId,self::HEADER_RANGE, $headerValues );
        }

        $sheetRowValues = GoogleSheetUtil::convertToSheetValue(array_values($content));
        $this->googleSheetAPIService->writeToSheet($spreadSheetId,self::HEADER_RANGE, $sheetRowValues);


    }

}