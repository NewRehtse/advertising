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
