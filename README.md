# customerio
PHP Service for CustomerIO integration (for Customer and Events entities)

##Usage

Composer packages

    "require": {
        "php": ">=7.1.3",
        "guzzlehttp/guzzle": "~6.0",
        "phpunit/phpunit": "~5.0"
    },

Get settings from your customer.io account and add it to .env file and to config file

    'site_id' => env('CUSTOMER_IO_SITE_ID'),
    'api_key' => env('CUSTOMER_IO_API_KEY'),

In my case, I used the service to send a status change event of a specific entity.
On the Customer IO side there was created a campaign for this event.
    
    $customerIoClient = CustomerIoService::createDefaultClient();
    $customerIoService = new CustomerIoService($customerIoClient);
    if($model->getOriginal('status_idx') !== $model->getAttribute('status_idx')) {
        $customerIoService->addStatusChangeEvent($model);
    }
