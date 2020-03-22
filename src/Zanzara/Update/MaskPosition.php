<?php

declare(strict_types=1);

namespace Zanzara\Update;

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
     * @param array $data
     */
    public function __construct(array &$data)
    {
        $this->point = $data['point'];
        $this->xShift = $data['x_shift'];
        $this->yShift = $data['y_shift'];
        $this->scale = $data['scale'];
    }

    /**
     * @return int
     */
    public function getPoint(): int
    {
        return $this->point;
    }

    /**
     * @return float
     */
    public function getXShift(): float
    {
        return $this->xShift;
    }

    /**
     * @return float
     */
    public function getYShift(): float
    {
        return $this->yShift;
    }

    /**
     * @return float
     */
    public function getScale(): float
    {
        return $this->scale;
    }

}
