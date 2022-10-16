<?php

namespace App\Services;

use Google_Client;
use Google_Service_Sheets_ValueRange;
use function Illuminate\Events\queueable;

class GoogleService
{
    private $spreadSheetId;
    private $client;
    private $googleSheetService;
    public bool $save;
    public string $entity;
    public bool $tracknum;

    public function __construct($save = false, $entity = 'order', $tracknum = false)
    {
        if ($save) {
            if ($entity == 'order') {
                $this->spreadSheetId = '1S4Ahbz_ABfAvfdioRykLoX3D38xZLHATh2b5s3-ygIo';

            } elseif ($entity == 'application') {
                $this->spreadSheetId = '1Jkzr5gmkrEkPAzPsgXgQSRBi_pNEKbyiEa6zX1N7jJw';

            }
        } else {
            $this->spreadSheetId = '1S4Ahbz_ABfAvfdioRykLoX3D38xZLHATh2b5s3-ygIo';

        }
        $this->entity = $entity;
        $this->save = $save;
        $this->tracknum = $tracknum;
        $this->client= new Google_Client();
        $this->client->setAuthConfig(storage_path('credentials.json'));
        $this->client->addScope('https://www.googleapis.com/auth/spreadsheets');

        $this->googleSheetService = new \Google_Service_Sheets($this->client);
    }

    public function readGoogleSheet()
    {
        $dimensions = $this->getDimensions($this->spreadSheetId);

        if ($this->save) {
            if ($this->entity == 'order') {
                $range = "Лист1!A" . ($dimensions['colCount'] + 1);

            } elseif ($this->entity == 'application') {
                $range = "Лист1!A" . ($dimensions['colCount'] + 1);

            }

        } else {
            if ($this->tracknum) {
                $range = "Лист1!AW:AW";
            } else {
                $range = "Лист1!A" . ($dimensions['colCount'] + 1);
            }


        }



        $data = $this->googleSheetService
            ->spreadsheets_values
            ->batchGet($this->spreadSheetId, ['ranges' => $range]);

        return $data->getValueRanges()[0]->values;
    }

    public function saveDataToSheet(array $data)
    {
        $dimensions = $this->getDimensions($this->spreadSheetId);

        $body = new Google_Service_Sheets_ValueRange([
            'values' => $data
        ]);

        $params = [
            'valueInputOption' => 'USER_ENTERED',
        ];
        if ($this->save) {
            if ($this->entity == 'order') {
                $range = "Лист1!A" . ($dimensions['rowCount'] + 1);

            } elseif ($this->entity == 'application') {
                $range = "Лист1!A" . ($dimensions['rowCount'] + 1);

            }

        } else {
            $range = "Лист1!A" . ($dimensions['rowCount'] + 1);
        }


        return $this->googleSheetService
            ->spreadsheets_values
            ->update($this->spreadSheetId, $range, $body, $params);
    }

    private function getDimensions($spreadSheetId)
    {
        if ($this->save) {
            if ($this->entity == 'order') {
                $rowDimensions = $this->googleSheetService->spreadsheets_values->batchGet(
                    $spreadSheetId,
                    ['ranges' => 'Лист1!A:A', 'majorDimension' => 'COLUMNS']
                );


            } elseif ($this->entity == 'application') {
                $rowDimensions = $this->googleSheetService->spreadsheets_values->batchGet(
                    $spreadSheetId,
                    ['ranges' => 'Лист1!A:A', 'majorDimension' => 'COLUMNS']
                );

            }

        } else {
            $rowDimensions = $this->googleSheetService->spreadsheets_values->batchGet(
                $spreadSheetId,
                ['ranges' => 'Лист1!A:A', 'majorDimension' => 'COLUMNS']
            );
        }


        //if data is present at nth row, it will return array till nth row
        //if all column values are empty, it returns null
        $rowMeta = $rowDimensions->getValueRanges()[0]->values;
        if (!$rowMeta) {
            return [
                'error' => true,
                'message' => 'missing row data'
            ];
        }
        if ($this->save) {
            if ($this->entity == 'order') {
                $colDimensions = $this->googleSheetService->spreadsheets_values->batchGet(
                    $spreadSheetId,
                    ['ranges' => 'Лист1!A:A', 'majorDimension' => 'ROWS']
                );

            } elseif ($this->entity == 'application') {
                $colDimensions = $this->googleSheetService->spreadsheets_values->batchGet(
                    $spreadSheetId,
                    ['ranges' => 'Лист1!A:A', 'majorDimension' => 'ROWS']
                );

            }
        } else {
            $colDimensions = $this->googleSheetService->spreadsheets_values->batchGet(
                $spreadSheetId,
                ['ranges' => 'Лист1!1:1', 'majorDimension' => 'ROWS']
            );
        }


        //if data is present at nth col, it will return array till nth col
        //if all column values are empty, it returns null
        $colMeta = $colDimensions->getValueRanges()[0]->values;
        if (!$colMeta) {
            return [
                'error' => true,
                'message' => 'missing row data'
            ];
        }

        return [
            'error' => false,
            'rowCount' => count($rowMeta[0]),
            'colCount' => $this->colLengthToColumnAddress(count($colMeta[0]))
        ];
    }

    private function colLengthToColumnAddress($number)
    {
        if ($number <= 0) return null;

        $letter = '';
        while ($number > 0) {
            $temp = ($number - 1) % 26;
            $letter = chr($temp + 65) . $letter;
            $number = ($number - $temp - 1) / 26;
        }
        return $letter;
    }
}
