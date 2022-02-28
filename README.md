## Payright PHP Package.

[![tests](https://github.com/PayrightMY/payment-php/actions/workflows/tests.yml/badge.svg)](https://github.com/PayrightMY/payment-php/actions/workflows/tests.yml)

This package is used to interacting with Payright payment API using PHP.

## Installation

You can install the package via composer:

```bash
composer require payrightmy/payment-php 
```

### Usage basic

```php
<?php 

use Payright\Client;
use GuzzleHttp\Client as HttpClient;

$payright = Client::make(new HttpClient(),[
    'api_key' => 'secret',
    'sandbox' => true
]);

$response = $payright->collections('v1')
 ->create([
  'name' => 'Collection name',
  'status' => 'active'
 ]);

echo $response->getStatusCode();
echo $response->getBody();

```


#### 1. Create Bill

```php
<?php 

use Payright\Client;
use GuzzleHttp\Client as HttpClient;

$payright = Client::make(new HttpClient(),[
    'api_key' => 'secret',
    'sandbox' => true
]);

$response = $payright->bills('v1')
->create([
    'collection' => '2Rjzopem',
    'biller_name' => 'Muhammad Imran',
    'biller_email' => 'imran@example.com',
    'biller_mobile' => '60121234567',
    'description' => 'Example bill description',
    'amount' => 100,
    'callback_url' => 'https://webhook.site/4370e625-4197-4059-911c-f4e16d6489f6',
    'redirect_url' => 'https://example.com/redirect/',
    'due_at' => '2021-12-01'
]);

echo $response->getStatusCode();
echo $response->getBody();

```

#### 2. Get Bill

```php
<?php 

use Payright\Client;
use GuzzleHttp\Client as HttpClient;

$payright = Client::make(new HttpClient(),[
    'api_key' => 'secret',
    'sandbox' => true
]);

$response = $payright->bills('v1')
->get('7BeQgzGP');

echo $response->getStatusCode();
echo $response->getBody();

```

### Available methods

- collections
- bills
- paymentchannel
- transactions

For more information, refer our official API Reference:

https://payright.stoplight.io/docs/api-reference/

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.


### Security

If you discover any security related issues, please email dev@payright.my instead of using the issue tracker.

