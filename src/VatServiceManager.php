<?php

namespace Bilfeldt\VatService;

use Illuminate\Support\Manager;

class VatServiceManager extends Manager
{
    public function getDefaultDriver(): string
    {
        return $this->config->get('vat.default');
    }
}