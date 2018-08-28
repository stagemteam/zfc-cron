# Zfc-Cron

Config based wrapper for [Yalesov\Cron](https://github.com/yalesov/zf2-cron) module, which allow use config for register cron jobs.
Simply speaking *Zend Framework way* for module implementation.

## Installation
```bash
composer require stagem/zfc-cron
```

Then add `Yalesov\Cron` and `Stagem\ZfcCron` to the modules key in (app root)/config/modules.config.* in that order.

## Usage
```php
//config/module.config.php

return [
    'cron' => [
        'jobs' => [
            [
                'alias' => 'unique-cron-job-code',
                'frequency' => '*/1 * * * *',
                'callback' => 'Stagem\Amazon\Service\ParserService::parse',
                'properties' => [
                    'task' => 'foo',
                ],
            ],
        ],
    ],
];
```

### Options

#### **`alias`**

Unique stringable code of cron Job. 
By this code you can identify cron Job in log or somewhere else.

#### **`frequency`**

Cron schedule time. [Explanation](http://www.adminschoice.com/crontab-quick-reference)

#### **`callback`**

Any valid PHP callback. If callback passed as namespace notation and a method is not static 
Cron will try to get the object through ServiceManager.

> Notice. Static method usage is not preferable. Use ServiceManager for maximum flexibility.

#### **`properties`**

Additional properties which will be passed to `callback`

Other option you can read [here](https://github.com/yalesov/zf2-cron).
