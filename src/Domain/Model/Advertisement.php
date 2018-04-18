<?php

namespace App\Domain\Model;

use App\Domain\Model\Exceptions\InvalidComponentException;
use App\Domain\Model\Exceptions\InvalidStatusException;

/**
 * @author NewRehtse
 */
class Advertisement
{
    public const ADV_STATUS_PUBLISHED = 0;
    public const ADV_STATUS_STOPPED = 1;
    public const ADV_STATUS_PUBLISHING = 2;

    /** @var AppId */
    private $id;

    /** @var Component[] */
    private $components;

    /** @var int */
    private $status;

    /**
     * Advertisement constructor.
     *
     * @param AppId $id
     * @param array $components
     * @param int   $status
     *
     * @throws \App\Domain\Model\Exceptions\InvalidComponentException
     */
    public function __construct(AppId $id, $components, $status = self::ADV_STATUS_PUBLISHED)
    {
        //He asumido que el estado inicial debe ser published, pero eso debería preguntarlo
        $this->components = [];

        //Todos los componentes deben ser válidos antes de crear el anuncio
        foreach ($components as $component) {
            if (false === $component instanceof Component) {
                throw new InvalidComponentException('Every component must be valid.');
            }
            $this->addComponent($component);
        }
        $this->id = $id;
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return (string) $this->id;
    }

    /**
     * @return Component[]
     */
    public function components()
    {
        return $this->components;
    }

    /**
     * @param Component $component
     *
     * @throws \App\Domain\Model\Exceptions\InvalidComponentException
     *
     * @return Advertisement
     */
    public function addComponent(Component $component): self
    {
        if ($component instanceof Component && false === $component->isValid()) {
            throw new InvalidComponentException('Every component must be valid.');
        }

        $component->setAdvertisement($this);
        $this->components[] = $component;

        return $this;
    }

    /**
     * @param Component $component
     *
     * @return Advertisement
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
    public function status(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     *
     * @throws \App\Domain\Model\Exceptions\InvalidStatusException
     *
     * @return $this
     */
    public function setStatus($status): self
    {
        if (self::ADV_STATUS_PUBLISHING === $this->status()) {
            throw new InvalidStatusException('An advertisement can not be modified when is publishing');
        }
        if (false === $this->isValidStatus($status)) {
            throw new InvalidStatusException('status must be published, publishing or stopped');
        }

        $this->status = $status;

        return $this;
    }

    /**
     * @param int $status
     *
     * @return bool
     */
    private function isValidStatus($status): bool
    {
        return \in_array($status, [self::ADV_STATUS_STOPPED, self::ADV_STATUS_PUBLISHING, self::ADV_STATUS_PUBLISHED], true);
    }
}
