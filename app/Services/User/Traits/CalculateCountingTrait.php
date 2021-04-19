<?php


namespace App\Services\User\Traits;


use App\Storage\CalculatorConstants;

trait CalculateCountingTrait
{

    abstract protected function getCalculatorConstants();

    protected function calculatePrice($metaItem)
    {
        $name = $metaItem->name;
        $type = $metaItem->type;
        $meta = (int)($metaItem->meta ?? 0);
        $dimensionType = (int) $metaItem->dimension;
        $metric = CalculatorConstants::getMetric($dimensionType);
        $dimension = 1;
        $price = $meta;


        if($type === 'wall') {
            $area = $this->getCalculatorConstants()->getWallsArea();
            $dimension = round($area / 0.5) * .5;
            $price = $meta * $area;
        }

        if($type === 'сeiling' || $type === 'floor') {
            $area = $this->getCalculatorConstants()->getArea();
            $dimension = round($area / 0.5) * .5;
            $price = $meta * $area;
        }
        if($name === 'electrical') {
            $dimension = "6 " . $metric;
            $price = $meta * 6;
        }
        if($name === 'sockets') {
            $dimension = "3 " . $metric;
            $price = $meta * 3;
        }
        if($name === 'piping' && $this->getCalculatorConstants()->roomType === 'bathroom') {
            $dimension = 5;
            $price = $meta * 5;
        }
        if($name === 'piping' && $this->getCalculatorConstants()->roomType === 'kitchen') {
            $dimension = 2;
            $price = $meta * 2;
        }
        if($name === 'plinth') {
            $perimeter = $this->getCalculatorConstants()->getPerimeter();
            $dimension = round($perimeter * 10) / 10;
            $price = $perimeter * $meta;
        }
        if($name === 'floor_primer' || $name === 'wall_primer') {
            // Удваиваем цену пола и стен
            $price = $price * 2;
        }

        return [
            'name' => $name,
            'type' => $type,
            'price' => round($price),
            'dimension' => $dimension,
            'metric' => $metric
        ];
    }

    protected function calcTotalPrice($pricesArray) {
        $total = 0;
        foreach ($pricesArray as $subArray) {
            if(isset($subArray['price'])) {
                $total += $subArray['price'];
            } else
            {
                $total += $this->calcTotalPrice($subArray);
            }
        }
        return $total;
    }

    private function resetPattern(&$pattern) {
        if (isset($pattern['long']))
        {
            $this->getCalculatorConstants()->length = $pattern['long'];
            unset($pattern['long']);
        }
        if (isset($pattern['width']))
        {
            $this->getCalculatorConstants()->width = $pattern['width'];
            unset($pattern['width']);
        }
        if (isset($pattern['windows']))
        {
            $this->getCalculatorConstants()->windowsQuantity = $pattern['windows'];
            unset($pattern['windows']);
        } else
        {
            $this->getCalculatorConstants()->resetWindowsQuantity();
        }
        if (isset($pattern['divider']))
        {
            $this->getCalculatorConstants()->divider = $pattern['divider'];
            unset($pattern['divider']);
        } else
        {
            $this->getCalculatorConstants()->resetDivider();
        }
    }

}
