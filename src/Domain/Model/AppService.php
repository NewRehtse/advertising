<?php

namespace App\Domain\Model;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
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
