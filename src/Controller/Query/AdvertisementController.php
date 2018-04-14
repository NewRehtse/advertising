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
    /** @var  ViewListOfAdvertisementService */
    private $viewListOfAdvertisementsService;

    /** @var AdvertisementDataTransformerInterface  */
    private $dataTransformer;

    public function __construct(
        ViewListOfAdvertisementService $viewListOfAdvertisementsService,
        AdvertisementDataTransformerInterface $dataTransformer,
        Logger $logger = null,
        $sharedMaxAge = 0
    ) {
        parent::__construct($logger, $sharedMaxAge);

        $this->viewListOfAdvertisementsService = $viewListOfAdvertisementsService;
        $this->dataTransformer = $dataTransformer;
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
}

