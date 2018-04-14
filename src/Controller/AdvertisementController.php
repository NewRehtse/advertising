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

use App\Application\Service\CreateAdvertisementRequest;
use App\Application\Service\CreateAdvertisementService;
use App\Application\Service\DataTransformer\AdvertisementDataTransformerInterface;
use App\Application\Service\ViewListOfAdvertisementService;
use App\Application\Service\ViewListOfAdvertisementRequest;
use Monolog\Logger;
use Symfony\Component\HttpFoundation\Request;


/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class AdvertisementController extends BaseController
{
    /** @var  ViewListOfAdvertisementService */
    private $viewListOfAdvertisementsService;

    /** @var  CreateAdvertisementService */
    private $createAdvertisementService;

    /** @var AdvertisementDataTransformerInterface  */
    private $dataTransformer;

    public function __construct(
        ViewListOfAdvertisementService $viewListOfAdvertisementsService,
        CreateAdvertisementService $createAdvertisementService,
        AdvertisementDataTransformerInterface $dataTransformer,
        Logger $logger = null,
        $sharedMaxAge = 0
    ) {
        parent::__construct($logger, $sharedMaxAge);

        $this->viewListOfAdvertisementsService = $viewListOfAdvertisementsService;
        $this->dataTransformer = $dataTransformer;
        $this->createAdvertisementService = $createAdvertisementService;
    }

    public function view(Request $request)
    {
        $data = $request->request->all();

        $limit = $data['limit'] ?? 10;
        $offset = $data['offset'] ?? 0;

        $viewRequest = new ViewListOfAdvertisementRequest($limit, $offset);

        $advertisements = $this->viewListOfAdvertisementsService->execute($viewRequest);

        $result = [];
        foreach ($advertisements as $adv) {
            $this->dataTransformer->write($adv);
            $result[] = $this->dataTransformer->read();
        }

        return $this->getJsonResponse(
            ['advertisements' => $result],
            200,
            []
        );
    }

    public function createAction(Request $request)
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
        $data = $request->request->all();
        var_dump($data);die();

        $components = [];

        $createRequest = new CreateAdvertisementRequest(
            $data['id'],
            $data['status'],
            $components
        );

        return $createRequest;
    }
}

