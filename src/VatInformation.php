<?php

namespace Bilfeldt\VatService;

class VatInformation
{
    public function __construct(
        public string $company,
        public string $vatNumber,
        public ?string $contact,
        public ?string $address,
        public ?string $postalCode,
        public ?string $city,
        public ?string $state,
        public ?string $region,
        public ?string $country,
        public ?string $sms,
        public ?string $phone,
        public ?string $email,
    ) {}
}