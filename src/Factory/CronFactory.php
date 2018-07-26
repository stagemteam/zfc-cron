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

namespace Stagem\ZfcCron\Factory;

use Psr\Container\ContainerInterface;
use Yalesov\Cron\Service\Cron;

class CronFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $config = $container->get('config')['di']['instance']['cron']['parameters'];

        $cron = (new Cron())
            ->setEm($entityManager)
            ->setScheduleAhead($config['scheduleAhead'])
            ->setMaxRunningTime($config['maxRunningTime'])
            ->setScheduleLifetime($config['scheduleLifetime'])
            ->setSuccessLogLifetime($config['successLogLifetime'])
            ->setFailureLogLifetime($config['failureLogLifetime'])
        ;

        return $cron;
    }
}