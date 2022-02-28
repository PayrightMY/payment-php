<?php

namespace Payright\Contracts;

interface PaymentCompletion
{
    public function redirectUrl(): array;

    public function callbackUrl(): array;

    public function toArray(): array;
}
