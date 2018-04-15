<?php

namespace App\Controller\Query;

use App\Application\Service\DataTransformer\AdvertisementDataTransformerInterface;
use App\Application\Service\Query\ViewDetailOfAdvertisementService;
use App\Application\Service\Query\ViewListOfAdvertisementService;
use App\Application\Service\Query\ViewListOfAdvertisementRequest;
use App\Controller\BaseController;
use App\Application\Service\Query\ViewDetailOfAdvertisementRequest;
use Monolog\Logger;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class AdvertisementController extends BaseController
{
    /** @var ViewListOfAdvertisementService */
    private $viewListOfAdvertisementsService;

    /** @var ViewDetailOfAdvertisementService */
    private $viewDetailOfAdvertisementsService;

    /** @var AdvertisementDataTransformerInterface */
    private $dataTransformer;

    public function __construct(
        ViewListOfAdvertisementService $viewListOfAdvertisementsService,
        ViewDetailOfAdvertisementService $viewDetailOfAdvertisementsService,
        AdvertisementDataTransformerInterface $dataTransformer,
        Logger $logger = null,
        $sharedMaxAge = 0
    ) {
        parent::__construct($logger, $sharedMaxAge);

        $this->viewListOfAdvertisementsService = $viewListOfAdvertisementsService;
        $this->viewDetailOfAdvertisementsService = $viewDetailOfAdvertisementsService;
        $this->dataTransformer = $dataTransformer;
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function list(Request $request): ?\Symfony\Component\HttpFoundation\Response
    {
        try {
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
    public function detail(string $id): ?\Symfony\Component\HttpFoundation\Response
    {
        try {
            $viewRequest = new ViewDetailOfAdvertisementRequest($id);

            $advertisement = $this->viewDetailOfAdvertisementsService->execute($viewRequest);

            $this->dataTransformer->write($advertisement);

            return $this->getJsonResponse(
                ['advertisement' => $this->dataTransformer->read()],
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
}
