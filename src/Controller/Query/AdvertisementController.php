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
    /** @var  ViewListOfAdvertisementService */
    private $viewListOfAdvertisementsService;

    /** @var  ViewDetailOfAdvertisementService */
    private $viewDetailOfAdvertisementsService;

    /** @var AdvertisementDataTransformerInterface  */
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

    public function list(Request $request)
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

    public function detail(string $id)
    {
        $viewRequest = new ViewDetailOfAdvertisementRequest($id);

        $advertisement = $this->viewDetailOfAdvertisementsService->execute($viewRequest);

        $this->dataTransformer->write($advertisement);

        return $this->getJsonResponse(
            ['advertisement' => $this->dataTransformer->read()],
            200,
            []
        );
    }
}

