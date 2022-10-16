<?php

namespace App\Services;

use App\Models\Company;
use MoveMoveIo\DaData\Enums\BranchType;
use MoveMoveIo\DaData\Enums\CompanyType;
use MoveMoveIo\DaData\Facades\DaDataCompany;

class DadataService
{

    public ?Company $company = null;

    public function __construct($id)
    {
        $this->company = Company::find($id);
    }

    public function address()
    {

        $dadata = DaDataCompany::id($this->company->INN, 1, null, BranchType::MAIN, CompanyType::LEGAL);
        if (array_key_exists(0, $dadata['suggestions'])) {
            return $dadata['suggestions'][0]['data']['address']['unrestricted_value'];
        } else {
            return '';
        }

    }

}
