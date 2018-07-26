<?php
/**
 * The MIT License (MIT)
 * Copyright (c) 2018 Stagem
 * This source file is subject to The MIT License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/MIT
 *
 * @category Stagem
 * @package Stagem_ZfcCron
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @license https://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace Stagem\ZfcCron;

return [
    'cron' => [
        'jobs' => [],
    ],
    'controllers' => [
        'aliases' => [
            \Yalesov\Cron\Controller\CronController::class => Controller\CronController::class,
        ],
        'factories' => [
            Controller\CronController::class => Controller\Factory\CronControllerFactory::class,
        ],
    ],
    'dependencies' => [
        'factories' => [
            \Yalesov\Cron\Service\Cron::class => Factory\CronFactory::class,
        ],
    ],
];