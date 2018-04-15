<?php

namespace App\Application\Service\DataTransformer;

use App\Domain\Model\Advertisement;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
interface AdvertisementDataTransformerInterface
{
    /**
     * @param Advertisement $adv
     */
    public function write(Advertisement $adv): void;

    /**
     * @param bool $raw
     *
     * @return array
     */
    public function read($raw = false): array;
}
