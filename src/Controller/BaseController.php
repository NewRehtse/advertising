<?php

namespace App\Controller;

use Monolog\Logger;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author NewRehtse
 */
abstract class BaseController
{
    /** @var int */
    private $sharedMaxAge;

    /** * @var Logger */
    private $logger;

    /**
     * BaseController constructor.
     *
     * @param Logger|null $logger
     * @param int         $sharedMaxAge
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
     * @param int   $status
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
