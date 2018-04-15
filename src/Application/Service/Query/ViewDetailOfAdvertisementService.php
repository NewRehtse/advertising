<?php

namespace App\Application\Service\Query;

use App\Application\Service\BaseAdvertisementService;
use App\Domain\Model\AppRequest;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class ViewDetailOfAdvertisementService extends BaseAdvertisementService
{
    /**
     * @inheritdoc
     */
    public function execute(AppRequest $request = null)
    {
        if (false === $request instanceof ViewDetailOfAdvertisementRequest) {
            throw new \InvalidArgumentException('Request is not valid.');
        }

        /** @var ViewDetailOfAdvertisementRequest $request */
        $id = $request->id();

        return $this->findOrFail($id);
    }
}
