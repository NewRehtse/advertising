<?php
/*
* This file is part of the Vocento Software.
*
* (c) Vocento S.A., <desarrollo.dts@vocento.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
*/

namespace App\Controller;

use Monolog\Logger;
use Symfony\Component\HttpFoundation\JsonResponse;
use \Symfony\Component\HttpFoundation\Response;


/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
abstract class BaseController
{
    /** @var int */
    private $sharedMaxAge = 0;

    /** * @var Logger */
    private $logger;

    /**
     * StatsController constructor.
     *
     * @param Logger $logger
     * @param int    $sharedMaxAge
     */
    public function __construct(
        Logger $logger = null,
        $sharedMaxAge = 0
    ) {
        $this->sharedMaxAge = $sharedMaxAge;
        $this->logger = $logger;
    }

    /**
     * @return Logger
     */
    public function logger()
    {
        return $this->logger;
    }

    /**
     * @param array $data
     * @param int $status
     * @param array $headers
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getJsonResponse(array $data, $status = 200, array $headers = []): Response
    {
        return JsonResponse::create($data, $status, $headers)
            ->setSharedMaxAge($this->sharedMaxAge);
    }
}

