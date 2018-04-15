<?php

namespace App\Application\Service\Query;

use App\Application\Service\BaseAdvertisementService;
use App\Domain\Model\AppRequest;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class ViewListOfAdvertisementService extends BaseAdvertisementService
{
    /**
     * @inheritdoc
     */
    public function execute(AppRequest $request = null)
    {
        if (false === $request instanceof ViewListOfAdvertisementRequest) {
            throw new \InvalidArgumentException('Request is not valid.');
        }

        /** @var ViewListOfAdvertisementRequest $request */
        $limit = $request->limit();
        $offset = $request->offset();

        return $this->advertisementRepository()->getList($limit, $offset);
    }
}
