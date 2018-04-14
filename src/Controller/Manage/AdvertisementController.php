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

namespace App\Controller\Manage;

use App\Application\Service\Manage\CreateAdvertisementRequest;
use App\Application\Service\Manage\CreateAdvertisementService;
use App\Application\Service\DataTransformer\AdvertisementDataTransformerInterface;
use App\Application\Service\Query\ViewListOfAdvertisementService;
use App\Application\Service\Query\ViewListOfAdvertisementRequest;
use App\Controller\BaseController;
use Monolog\Logger;
use Symfony\Component\HttpFoundation\Request;


/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class AdvertisementController extends BaseController
{
    /** @var  CreateAdvertisementService */
    private $createAdvertisementService;

    /** @var AdvertisementDataTransformerInterface  */
    private $dataTransformer;

    public function __construct(
        CreateAdvertisementService $createAdvertisementService,
        AdvertisementDataTransformerInterface $dataTransformer,
        Logger $logger = null,
        $sharedMaxAge = 0
    ) {
        parent::__construct($logger, $sharedMaxAge);

        $this->dataTransformer = $dataTransformer;
        $this->createAdvertisementService = $createAdvertisementService;
    }

    public function create(Request $request)
    {
        try {
            $createRequest = $this->handleCreateRequest($request);

            $adv = $this->createAdvertisementService->execute($createRequest);

            $this->dataTransformer->write($adv);

            return $this->getJsonResponse(
                ['site' => $this->dataTransformer->read(true)],
                201,
                []
            );
        } catch (\Exception $exception) {
            return $this->getJsonResponse(
                [
                    'code' => $exception->getCode(),
                    'message' => $exception->getMessage(),
                ],
                409
            );
        }
    }

    /**
     * @param Request $request
     *
     * @return CreateAdvertisementRequest
     */
    private function handleCreateRequest(Request $request): CreateAdvertisementRequest
    {
        $data = \json_decode($request->getContent(), true);

        $createRequest = new CreateAdvertisementRequest(
            $data['status'],
            $data['components']
        );

        return $createRequest;
    }
}

