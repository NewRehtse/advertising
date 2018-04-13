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

namespace App\Domain\Model;


/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class Advertising
{
    const ADV_STATE_PUBLISHED = 0;
    const ADV_STATE_STOPPED = 1;
    const ADV_STATE_PUBLISHING = 2;

    /** @var AppId */
    private $id;
    /** @var Component[] */
    private $components;

    /** @var int */
    private $state;

    /**
     * Advertising constructor.
     *
     * @param AppId $id
     * @param Component[] $components
     * @param int $state
     *
     * @throws \App\Domain\Model\InvalidComponentException
     */
    public function __construct(AppId $id, $components, $state = self::ADV_STATE_PUBLISHED)
    {
        //He asumido que el estado inicial debe ser published, pero eso debería preguntarlo

        //Todos los componentes deben ser válidos antes de crear el anuncio
        foreach ($components as $component) {
            if (false === ($component instanceof Component) || ($component instanceof Component && false === $component->isValid())) {
                throw new InvalidComponentException('Every component must be valid.');
            }
        }
        $this->id = $id;
        $this->components = $components;
        $this->state = $state;
    }

    /**
     * @return AppId
     */
    public function id(): AppId
    {
        return $this->id;
    }

    /**
     * @return Component[]
     */
    public function components(): array
    {
        return $this->components;
    }

    /**
     * @param Component $component
     *
     * @throws \App\Domain\Model\InvalidComponentException
     *
     * @return Advertising
     */
    public function addComponent(Component $component): self
    {
        //Todos los componentes deben ser válidos antes de crear el anuncio
        if (false === $component->isValid()) {
            throw new InvalidComponentException('Every component must be valid.');
        }

        $this->components[] = $component;

        return $this;
    }

    /**
     * @param Component $component
     *
     * @return Advertising
     */
    public function removeComponent(Component $component): self
    {
        $arr = [];
        //TODO Aquí se podría hacer una función para comparar ambos componentes que cumplan la interfaz Comparable
        foreach ($this->components() as $c) {
            if ($component->id() !== $c->id()) {
                $arr[] = $c;
            }
        }
        $this->components = $arr;

        return $this;
    }

    /**
     * @return int
     */
    public function state(): int
    {
        return $this->state;
    }

    /**
     * @param int $state
     *
     * @throws \App\Domain\Model\InvalidStateException
     *
     * @return $this
     */
    public function setState($state): self
    {
        if (self::ADV_STATE_PUBLISHING === $this->state()) {
            throw new InvalidStateException('An advertisement can not be modified when is publishing');
        }
        if (false === $this->isValidState($state)) {
            throw new InvalidStateException('State must be published, publishing or stopped');
        }

        $this->state = $state;

        return $this;
    }

    /**
     * @param int $state
     *
     * @return bool
     */
    private function isValidState($state): bool
    {
        return \in_array($state, [self::ADV_STATE_STOPPED, self::ADV_STATE_PUBLISHING, self::ADV_STATE_PUBLISHED], true);
    }
}
