<?php

namespace App\Application\Service\DataTransformer;

use App\Domain\Model\Advertisement;
use App\Domain\Model\Component;
use App\Domain\Model\Image;
use App\Domain\Model\Text;
use App\Domain\Model\Video;
use Doctrine\ORM\PersistentCollection;

/**
 * @author NewRehtse
 */
class AdvertisementDataTransformer implements AdvertisementDataTransformerInterface
{
    private const DEFAULT_PERSISTENT_COLLECTION_CLASS = 'Doctrine\ORM\PersistentCollection';
    /** @var Advertisement */
    private $adv;

    /** @var string */
    private $persistentCollectionClass;

    /**
     * AdvertisementDataTransformer constructor.
     *
     * @param string $persistentCollectionClass
     */
    public function __construct(string $persistentCollectionClass = self::DEFAULT_PERSISTENT_COLLECTION_CLASS)
    {
        $this->persistentCollectionClass = $persistentCollectionClass;
    }

    /**
     * @inheritdoc
     */
    public function write(Advertisement $adv): void
    {
        $this->adv = $adv;
    }

    /**
     * @inheritdoc
     */
    public function read($raw = false): array
    {
        $components = [];

        if (\is_array($this->adv->components())) {
            /** @var Component $c */
            foreach ($this->adv->components() as $c) {
                $aux = $this->deserializeComponent($c);
                if (!empty($aux)) {
                    $components[] = $this->deserializeComponent($c);
                }
            }
        } elseif ($this->adv->components() instanceof $this->persistentCollectionClass) {
            /** @var PersistentCollection $listComponents */
            $listComponents = $this->adv->components();
            foreach ($listComponents->getIterator() as $c) {
                $aux = $this->deserializeComponent($c);
                if (!empty($aux)) {
                    $components[] = $this->deserializeComponent($c);
                }
            }
        }

        $data = [
            'id' => $this->adv->id(),
            'status' => $this->adv->status(),
        ];

        if (!empty($components)) {
            $data['components'] = $components;
        }

        return $data;
    }

    /**
     * @param Component $c
     *
     * @return array
     */
    private function deserializeComponent(Component $c): array
    {
        if ($c instanceof Image || $c instanceof Video) {
            return [
                'id' => $c->id(),
                'name' => $c->name(),
                'position' => [$c->positionX(), $c->positionY(), $c->positionZ()],
                'width' => $c->width(),
                'height' => $c->height(),
                'weight' => $c->weight(),
                'format' => $c->format(),
                'url' => $c->url(),
            ];
        }
        if ($c instanceof Text) {
            return [
                'id' => $c->id(),
                'name' => $c->name(),
                'position' => [$c->positionX(), $c->positionY(), $c->positionZ()],
                'width' => $c->width(),
                'height' => $c->height(),
                'text' => $c->text(),
            ];
        }

        return [];
    }
}
