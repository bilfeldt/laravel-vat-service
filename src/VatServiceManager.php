<?php

namespace Bilfeldt\VatService;

use Illuminate\Support\Manager;
use Bilfeldt\VatService\Drivers\CvrApi;

class VatServiceManager extends Manager
{
    public function getDefaultDriver(): string
    {
        return $this->config->get('vat.default');
    }

    public function createCvrApiDriver(): CvrApi
    {
        return new CvrApi(
            config('vat.drivers.cvr_api.access_token'),
        );
    }
}
