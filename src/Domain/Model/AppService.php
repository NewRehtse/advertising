<?php

namespace App\Domain\Model;

/**
 * @author NewRehtse
 */
interface AppService
{
    /**
     * @param AppRequest|null $request
     *
     * @throws \InvalidArgumentException
     */
    public function execute(AppRequest $request = null);
}
