# customerio
PHP Service for CustomerIO integration (for Customer and Events entities)

##Usage

Composer packages

    "require": {
        "php": ">=7.1.3",
        "guzzlehttp/guzzle": "~6.0",
        "phpunit/phpunit": "~5.0"
    },

Get settings from your customer.io account and put it here instead of site_id and api_key

    $customerIoService = CustomerIoService::createDefault('site_id', 'api_key');
    
In my case, I used the service to send a status change event of a specific entity.
On the Customer IO side there was created a campaign for this event.
    
    if($model->getOriginal('status_idx') !== $model->getAttribute('status_idx')) {
        $customerIoService->addStatusChangeEvent($model);
    }
