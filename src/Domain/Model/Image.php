<?php

namespace App\Domain\Model;

/**
 * @author NewRehtse
 */
class Image extends Component
{
    public const VALID_FORMATS = 'jpg|png';

    /** @var int */
    private $weight;

    /** @var string */
    private $format;

    /** @var string */
    private $url;

    /**
     * Image constructor.
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
    public function format(): ?string
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
        if (false !== \strpos(self::VALID_FORMATS, $format)) {
            $this->format = \strtolower($format);
        }

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
     * @param string $url
     *
     * @return Image
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function isValid(): bool
    {
        $valid1 = !empty($this->name()) && !empty($this->url());

        return false !== $valid1 && $this->format && false !== \strpos(self::VALID_FORMATS, $this->format());
    }
}
