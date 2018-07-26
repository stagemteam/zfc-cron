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

namespace Stagem\ZfcCron\Controller;

use Doctrine\ORM\EntityManager;
use Zend\Console\Request as ConsoleRequest;
use Zend\Console\Response as ConsoleResponse;
use Zend\Mvc\Controller\AbstractActionController;
use Yalesov\BackgroundExec\BackgroundExec;
use Yalesov\Cron\Service\Cron;

class CronController extends AbstractActionController
{
    /**
     * @var Cron
     */
    protected $cron;

    public function __construct(Cron $cron)
    {
        $this->cron = $cron;
    }

    /**
     * Run the cron service
     * if called from browser,
     * will suppress output and continue execution in background
     *
     * @return Response|void
     */
    public function indexAction()
    {
        if (!$this->getRequest() instanceof ConsoleRequest) {
            BackgroundExec::start();
        }

        $this->cron->run();

        $response = $this->getResponse();
        if (!$response instanceof ConsoleResponse) {
            $response->setStatusCode(200);

            return $response;
        }
    }
}
