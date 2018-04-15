<?php

namespace App\Domain\Model;

/**
 * @author Esther Ibáñez González <eibanez@ces.vocento.com>
 */
class Text extends Component
{
    /** @var string */
    private $text;

    /**
     * Text constructor.
     *
     * @param AppId  $id
     * @param string $name
     * @param string $text
     */
    public function __construct(AppId $id, $name, $text)
    {
        parent::__construct($id, $name);

        $this->setText($text);
    }

    /**
     * @return string
     */
    public function text(): ?string
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return $this
     */
    public function setText(string $text): self
    {
        if (!empty($text) && \strlen($text) <= 140) {
            $this->text = $text;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return !empty($this->name()) && !empty($this->text()) && \strlen($this->text()) <= 140;
    }
}
