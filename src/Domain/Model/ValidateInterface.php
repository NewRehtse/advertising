<?php

namespace App\Domain\Model;

/**
 * @author NewRehtse
 */
interface ValidateInterface
{
    /**
     * @return bool
     */
    public function isValid(): bool;
}
