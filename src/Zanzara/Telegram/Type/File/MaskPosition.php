<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\File;

/**
 *
 */
class MaskPosition
{

    /**
     * @var int
     */
    private $point;

    /**
     * @var float
     */
    private $xShift;

    /**
     * @var float
     */
    private $yShift;

    /**
     * @var float
     */
    private $scale;

    /**
     * @return int
     */
    public function getPoint(): int
    {
        return $this->point;
    }

    /**
     * @param int $point
     */
    public function setPoint(int $point): void
    {
        $this->point = $point;
    }

    /**
     * @return float
     */
    public function getXShift(): float
    {
        return $this->xShift;
    }

    /**
     * @param float $xShift
     */
    public function setXShift(float $xShift): void
    {
        $this->xShift = $xShift;
    }

    /**
     * @return float
     */
    public function getYShift(): float
    {
        return $this->yShift;
    }

    /**
     * @param float $yShift
     */
    public function setYShift(float $yShift): void
    {
        $this->yShift = $yShift;
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
