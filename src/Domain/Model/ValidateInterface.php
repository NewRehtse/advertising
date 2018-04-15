<?php

namespace App\Domain\Model;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
interface ValidateInterface
{
    /**
     * @return bool
     */
    public function isValid(): bool;
}
