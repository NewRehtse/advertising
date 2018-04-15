<?php

namespace App\Controller\Manage;

use App\Application\Service\Manage\CreateAdvertisementRequest;
use App\Application\Service\Manage\CreateAdvertisementService;
use App\Application\Service\DataTransformer\AdvertisementDataTransformerInterface;
use App\Application\Service\Manage\DeleteAdvertisementRequest;
use App\Application\Service\Manage\DeleteAdvertisementService;
use App\Application\Service\Manage\UpdateAdvertisementRequest;
use App\Application\Service\Manage\UpdateAdvertisementService;
use App\Controller\BaseController;
use Monolog\Logger;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class AdvertisementController extends BaseController
{
    /** @var CreateAdvertisementService */
    private $createAdvertisementService;

    /** @var UpdateAdvertisementService */
    private $updateAdvertisementService;

    /** @var DeleteAdvertisementService */
    private $deleteAdvertisementService;

    /** @var AdvertisementDataTransformerInterface */
    private $dataTransformer;

    /**
     * AdvertisementController constructor.
     *
     * @param CreateAdvertisementService            $createAdvertisementService
     * @param UpdateAdvertisementService            $updateAdvertisementService
     * @param DeleteAdvertisementService            $deleteAdvertisementService
     * @param AdvertisementDataTransformerInterface $dataTransformer
     * @param Logger|null                           $logger
     * @param int                                   $sharedMaxAge
     */
    public function __construct(
        CreateAdvertisementService $createAdvertisementService,
        UpdateAdvertisementService $updateAdvertisementService,
        DeleteAdvertisementService $deleteAdvertisementService,
        AdvertisementDataTransformerInterface $dataTransformer,
        Logger $logger = null,
        $sharedMaxAge = 0
    ) {
        parent::__construct($logger, $sharedMaxAge);

        $this->dataTransformer = $dataTransformer;
        $this->createAdvertisementService = $createAdvertisementService;
        $this->updateAdvertisementService = $updateAdvertisementService;
        $this->deleteAdvertisementService = $deleteAdvertisementService;
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request): ?\Symfony\Component\HttpFoundation\Response
    {
        try {
            $createRequest = $this->handleCreateRequest($request);

            $adv = $this->createAdvertisementService->execute($createRequest);

            $this->dataTransformer->write($adv);

            return $this->getJsonResponse(
                ['advertisement' => $this->dataTransformer->read(true)],
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
     * @param string  $id
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update($id, Request $request): ?\Symfony\Component\HttpFoundation\Response
    {
        try {
            $updateRequest = $this->handleUpdateRequest($id, $request);

            $adv = $this->updateAdvertisementService->execute($updateRequest);

            $this->dataTransformer->write($adv);

            return $this->getJsonResponse(
                ['advertisement' => $this->dataTransformer->read(true)],
                200,
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
     * @param string $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(string $id): ?\Symfony\Component\HttpFoundation\Response
    {
        try {
            $updateRequest = new DeleteAdvertisementRequest($id);

            $this->deleteAdvertisementService->execute($updateRequest);

            return $this->getJsonResponse(
                [],
                204,
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

    /**
     * @param string  $id
     * @param Request $request
     *
     * @return UpdateAdvertisementRequest
     */
    private function handleUpdateRequest($id, Request $request): UpdateAdvertisementRequest
    {
        $data = \json_decode($request->getContent(), true);

        $updateRequest = new UpdateAdvertisementRequest(
            $id,
            $data['components'],
            $data['status']
        );

        return $updateRequest;
    }
}
