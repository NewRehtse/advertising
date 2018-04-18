<?php

namespace App\Application\Service\Manage;

use App\Application\Service\BaseAdvertisementService;
use App\Domain\Model\AppRequest;

/**
 * @author NewRehtse
 */
class DeleteAdvertisementService extends BaseAdvertisementService
{
    /**
     * @param AppRequest|null $request
     *
     * @throws \InvalidArgumentException
     */
    public function execute(AppRequest $request = null)
    {
        if (false === $request instanceof DeleteAdvertisementRequest) {
            throw new \InvalidArgumentException('Request is not valid.');
        }

        /** @var UpdateAdvertisementRequest $request */
        $advertisement = $this->findOrFail($request->id());

        $this->advertisementRepository()->remove($advertisement);
    }
}
