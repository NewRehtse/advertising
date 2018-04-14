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
class Text extends Component
{
    /** @var Advertisement */
    private $advertisement;

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

        $this->text = $text;
    }

    /**
     * @return Advertisement
     */
    public function advertisement(): Advertisement
    {
        return $this->advertisement;
    }

    /**
     * @param Advertisement $advertisement
     *
     * @return $this
     */
    public function setAdvertisement(Advertisement $advertisement): self
    {
        $this->advertisement = $advertisement;

        return $this;
    }

    /**
     * @return string
     */
    public function text(): string
    {
        return $this->text;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return !empty($this->name()) && !empty($this->text()) && \strlen($this->text()) <= 140;
    }
}
