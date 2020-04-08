<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\File;

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
     * @var float number
     */
    private $x_shift;

    /**
     * Shift by Y-axis measured in heights of the mask scaled to the face size, from top to bottom. For example, 1.0 will
     * place the mask just below the default mask position.
     *
     * @var float number
     */
    private $y_shift;

    /**
     * Mask scaling coefficient. For example, 2.0 means double size.
     *
     * @var float number
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
     * @return float
     */
    public function getXShift(): float
    {
        return $this->x_shift;
    }

    /**
     * @param float $x_shift
     */
    public function setXShift(float $x_shift): void
    {
        $this->x_shift = $x_shift;
    }

    /**
     * @return float
     */
    public function getYShift(): float
    {
        return $this->y_shift;
    }

    /**
     * @param float $y_shift
     */
    public function setYShift(float $y_shift): void
    {
        $this->y_shift = $y_shift;
    }

    /**
     * @return float
     */
    public function getScale(): float
    {
        return $this->scale;
    }

    /**
     * @param float $scale
     */
    public function setScale(float $scale): void
    {
        $this->scale = $scale;
    }

}