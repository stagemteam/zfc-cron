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

use ReflectionMethod;
use Zend\EventManager\EventInterface;
use Zend\Stdlib\Exception\InvalidArgumentException;
use Yalesov\Cron\Service\Cron;

class Module
{
    public function getConfig()
    {
        $config = include __DIR__ . '/../config/module.config.php';
        $config['service_manager'] = $config['dependencies'];
        unset($config['dependencies']);

        return $config;
    }

    /**
     * @param EventInterface $e
     */
    public function onBootstrap(EventInterface $e)
    {
        $container = $e->getApplication()->getServiceManager();
        $jobs = $container->get('config')['cron']['jobs'];
        foreach ($jobs as $job) {
            $alias = $job['alias'];
            $callback = $job['callback'];
            $frequency = $job['frequency'];
            $properties = $job['properties'];

            $callback = function() use ($container, $callback) {
                if (is_string($callback) && strpos($callback, '::')) {
                    list($class, $method) = explode('::', $callback);
                    $methodChecker = new ReflectionMethod($class, $method);
                    if ($methodChecker->isPublic() && !$methodChecker->isStatic()) {
                        if (!$container->has($class)) {
                            throw new InvalidArgumentException(sprintf(
                                'Class "%s" does not exists and cannot be created with Service Manager', $class
                            ));
                        }
                        $callback = [$container->get($class), $method];
                    }
                }
                $properties = func_get_args();

                return call_user_func_array($callback, $properties);
            };
            Cron::register($alias, $frequency, $callback, $properties);
        }
    }
}
