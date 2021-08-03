<?php

namespace App\Service\ContentWriter;

use App\Service\FileProcessor\FileContent;
use App\Service\GoogleSheetAPIService;
use App\Utility\GoogleSheetUtil;


class GoogleSheetXMLWriter implements ContentWriterInterface
{
    private $googleSheetAPIService;

    /**
     * GoogleSheetXMLWriter constructor.
     * @param GoogleSheetAPIService $googleSheetAPIService
     */
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
        $range = GoogleSheetUtil::buildHeaderRange(count(array_keys($content)));
        $header = $this->googleSheetAPIService->getHeader($spreadSheetId,$range );
        $headerValues = GoogleSheetUtil::convertArrayToSpreadsheetValue(array_keys($content));

        if(is_null($header)) {
            $this->googleSheetAPIService->writeToSheet($spreadSheetId, $headerValues,$range);
        }

        $sheetRowValues = GoogleSheetUtil::convertArrayToSpreadsheetValue(array_values($content));
        $this->googleSheetAPIService->writeToSheet($spreadSheetId, $sheetRowValues, $range);


    }

}