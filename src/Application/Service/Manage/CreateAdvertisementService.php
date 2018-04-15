<?php

namespace App\Application\Service\Manage;

use App\Application\Service\BaseAdvertisementService;
use App\Domain\Model\AppRequest;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class CreateAdvertisementService extends BaseAdvertisementService
{
    /**
     * @inheritdoc
     */
    public function execute(AppRequest $request = null)
    {
        if (false === $request instanceof CreateAdvertisementRequest) {
            throw new \InvalidArgumentException('Request is not valid.');
        }

        $id = $this->factory()->buildAppId();
        $components = [];
        /** @var CreateAdvertisementRequest $request */
        foreach ($request->components() as $component) {
            $components[] = $this->factory()->buildComponentFromArray($component);
        }

        $advertisement = $this->factory()->build($id, $components, $request->status());

        $this->advertisementRepository()->persist($advertisement);

        return $advertisement;
    }
}
