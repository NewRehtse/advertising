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

namespace App\Application\Service\DataTransformer;

use App\Domain\Model\Advertisement;
use App\Domain\Model\Component;
use App\Domain\Model\Image;
use App\Domain\Model\Text;
use App\Domain\Model\Video;
use Doctrine\ORM\PersistentCollection;


/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class AdvertisementDataTransformer implements AdvertisementDataTransformerInterface
{
    /** @var  Advertisement */
    private $adv;
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
            $arrComponents = $this->adv->components();
        }
        else if ($this->adv->components() instanceof PersistentCollection) {
            $arrComponents = $this->adv->components()->getValues();
        }

        if (!empty($arrComponents)) {
            /** @var Component $c */
            foreach ($this->adv->components() as $c) {
                if ($c instanceof Image || $c instanceof Video) {
                    $components[] = [
                        'id' => (string)$c->id(),
                        'name' => $c->name(),
                        'position' => [$c->positionX(), $c->positionY(), $c->positionZ()],
                        'width' => $c->width(),
                        'height' => $c->height(),
                        'weight' => $c->weight(),
                        'format' => $c->format(),
                        'url' => $c->url(),
                    ];
                }
                else if ($c instanceof Text) {
                    $components[] = [
                        'id' => (string)$c->id(),
                        'name' => $c->name(),
                        'position' => [$c->positionX(), $c->positionY(),$c->positionZ()],
                        'width' => $c->width(),
                        'height' => $c->height(),
                        'text' => $c->text(),
                    ];
                }
            }
        }

        $data = [
            'id' => (string) $this->adv->id(),
            'status' => $this->adv->status(),
        ];

        if (!empty($components)) {
            $data['components'] = $components;
        }

        return $data;
    }
}

