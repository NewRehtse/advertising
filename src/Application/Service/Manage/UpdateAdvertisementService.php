<?php

namespace App\Application\Service\Manage;

use App\Application\Service\BaseAdvertisementService;
use App\Domain\Model\AdvertisingFactoryInterface;
use App\Domain\Model\AppRequest;
use App\Domain\Model\Component;
use App\Domain\Model\Image;
use App\Domain\Model\Repositories\AdvertisementRepositoryInterface;
use App\Domain\Model\Repositories\ComponentRepositoryInterface;
use App\Domain\Model\Text;
use App\Domain\Model\Video;
use Doctrine\ORM\PersistentCollection;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class UpdateAdvertisementService extends BaseAdvertisementService
{
    /** @var ComponentRepositoryInterface */
    private $componentRepository;

    /**
     * UpdateAdvertisementService constructor.
     *
     * @param AdvertisementRepositoryInterface $advertisementRepository
     * @param ComponentRepositoryInterface     $componentRepository
     * @param AdvertisingFactoryInterface      $factory
     */
    public function __construct(
        AdvertisementRepositoryInterface $advertisementRepository,
        ComponentRepositoryInterface $componentRepository,
        AdvertisingFactoryInterface $factory
    ) {
        parent::__construct($advertisementRepository, $factory);

        $this->componentRepository = $componentRepository;
    }

    /**
     * @inheritdoc
     */
    public function execute(AppRequest $request = null)
    {
        if (false === $request instanceof UpdateAdvertisementRequest) {
            throw new \InvalidArgumentException('Request is not valid.');
        }

        /** @var UpdateAdvertisementRequest $request */
        $advertisement = $this->findOrFail($request->id());

        $advertisement->setStatus($request->status());
        /** @var PersistentCollection $components */
        $components = $advertisement->components();

        $toCreate = [];
        foreach ($request->components() as $c) {
            $finded = false;
            /** @var Component $i */
            foreach ($components->getIterator() as $i) {
                if (isset($c['id']) && $c['id'] === $i->id()) {
                    $finded = true;
                    //Entonces existe y hay que modificarlo
                    $i->setHeight($c['height']);
                    $i->setWidth($c['width']);
                    $i->setPosition($this->factory()->buildPosition($c['positionX'], $c['positionY'], $c['positionZ']));

                    if ($i instanceof Video || $i instanceof Image) {
                        $i->setWeight($c['weight']);
                        $i->setFormat($c['format']);
                        $i->setUrl($c['url']);
                    }
                    if ($i instanceof Text) {
                        $i->setText($c['text']);
                    }
                }
            }

            if (false === $finded && false === isset($c['id'])) {
                $toCreate[] = $c;
            }
        }

        $elementsToDelete = [];
        foreach ($components->getIterator() as $i) {
            $finded = false;
            foreach ($request->components() as $c) {
                if (isset($c['id']) && $c['id'] === $i->id()) {
                    $finded = true;
                }
            }

            if (false === $finded) {
                $elementsToDelete[] = $i;
            }
        }

        foreach ($toCreate as $c) {
            $advertisement->addComponent($this->factory()->buildComponentFromArray($c));
        }
        foreach ($elementsToDelete as $i) {
            $advertisement->removeComponent($i);
            $this->componentRepository->remove($i);
        }

        $this->advertisementRepository()->persist($advertisement);

        return $advertisement;
    }
}
