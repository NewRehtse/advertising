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
abstract class Media extends Component
{
    /** @var int */
    private $weight;

    /** @var string */
    private $format;

    /** @var string */
    private $url;

    /**
     * Media constructor.
     *
     * @param AppId  $id
     * @param string $name
     * @param string $url
     */
    public function __construct(AppId $id, $name, $url)
    {
        parent::__construct($id, $name);
        $this->url = $url;
    }

    /**
     * @return int
     */
    public function weight(): int
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     *
     * @return $this
     */
    public function setWeight($weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @return string
     */
    public function format(): string
    {
        return $this->format;
    }

    /**
     * @param string $format
     *
     * @return $this
     */
    public function setFormat($format): self
    {
        $this->format = \strtolower($format);

        return $this;
    }

    /**
     * @return string
     */
    public function url(): string
    {
        return $this->url;
    }

    /**
     * @inheritdoc
     */
    public function isValid(): bool
    {
        return !empty($this->name()) && !empty($this->url());
    }
}
