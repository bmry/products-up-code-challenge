<?php
/**
 * Created by PhpStorm.
 * User: morayobamgbose
 * Date: 01/08/2021
 * Time: 9:49 PM
 */

namespace App\Service;

use App\Exception\ProductsUpException;
use App\Exception\SheetAPIServiceException;
use Google\Exception;
use Google\Service\Sheets\Spreadsheet;
use http\Exception\InvalidArgumentException;
use Psr\Log\LoggerInterface;

class GoogleSheetAPIService
{
    const SPREADSHEET_NAME =  'Catalog';
    const HEADER_RANGE='A1:B1';

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return \Google_Client
     * @throws ProductsUpException
     * @throws \Google\Exception
     */
    private function getClient()
    {
        $client = new \Google_Client();
        $googleCredential= getenv('HOME').'/'.getenv('GOOGLE_APPLICATION_CREDENTIALS');
        $client->setApplicationName('ProductsUp Code Challenge');
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');
        $client->setAuthConfig($googleCredential);

        return $client;
    }

    public function getSheetService() {

        $client = $this->getClient();
        $service = new \Google_Service_Sheets($client);

        return $service;
    }

    /**
     * @param string $spreadName
     * @return Spreadsheet|null
     * @throws SheetAPIServiceException
     */
    public function createSpreadSheet(string $spreadName = self::SPREADSHEET_NAME):?Spreadsheet
    {
        $spreadsheet = new \Google_Service_Sheets_Spreadsheet([
            'properties' => [
                'title' => $spreadName
            ]
        ]);

        return $this->getSheetService()->spreadsheets->create($spreadsheet, [
                'fields' => 'spreadsheetId'
        ]);
    }

    /**
     * @param string $spreadSheetId
     * @param array $value
     * @param $range
     */
    public function writeToSheet(string $spreadsheetId, $values, $range): void
    {
        $body = new \Google_Service_Sheets_ValueRange([
            'values' =>[ $values ],
            'majorDimension' => 'ROWS'
        ]);

        $params = [
            'valueInputOption' => 'RAW'
        ];

        $this->getSheetService()->spreadsheets_values->append($spreadsheetId, $range, $body,$params);
    }

    public function getHeader($spreadSheetId, $range)
    {
       $response =  $this->getSheetService()->spreadsheets_values->get($spreadSheetId, $range);

       return $response->getValues();
    }
}