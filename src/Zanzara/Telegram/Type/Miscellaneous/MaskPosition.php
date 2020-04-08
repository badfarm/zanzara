<?php
declare(strict_types=1);

namespace Zanzara\Telegram\Type\Miscellaneous;

/**
 * This object describes the position on faces where a mask should be placed by default.
 *
 * More on https://core.telegram.org/bots/api#maskposition
 */
class MaskPosition
{

    /**
     * The part of the face relative to which the mask should be placed. One of "forehead", "eyes", "mouth", or "chin".
     *
     * @var string
     */
    private $point;

    /**
     * Shift by X-axis measured in widths of the mask scaled to the face size, from left to right. For example, choosing
     * -1.0 will place mask just to the left of the default mask position.
     *
     * @var Float number
     */
    private $x_shift;

    /**
     * Shift by Y-axis measured in heights of the mask scaled to the face size, from top to bottom. For example, 1.0 will
     * place the mask just below the default mask position.
     *
     * @var Float number
     */
    private $y_shift;

    /**
     * Mask scaling coefficient. For example, 2.0 means double size.
     *
     * @var Float number
     */
    private $scale;

    /**
     * @return string
     */
    public function getPoint(): string
    {
        return $this->point;
    }

    /**
     * @param string $point
     */
    public function setPoint(string $point): void
    {
        $this->point = $point;
    }

    /**
     * @return Float
     */
    public function getXShift(): Float
    {
        return $this->x_shift;
    }

    /**
     * @param Float $x_shift
     */
    public function setXShift(Float $x_shift): void
    {
        $this->x_shift = $x_shift;
    }

    /**
     * @return Float
     */
    public function getYShift(): Float
    {
        return $this->y_shift;
    }

    /**
     * @param Float $y_shift
     */
    public function setYShift(Float $y_shift): void
    {
        $this->y_shift = $y_shift;
    }

    /**
     * @return Float
     */
    public function getScale(): Float
    {
        return $this->scale;
    }

    /**
     * @param Float $scale
     */
    public function setScale(Float $scale): void
    {
        $this->scale = $scale;
    }

}