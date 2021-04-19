<?php


namespace App\Storage;


use Illuminate\Support\Facades\Log;

class CalculatorConstants
{
    public $width = 0;
    public $length = 0;
    public $height = self::DEFAULT_FLOOR_HEIGHT;
    public $windowsQuantity = self::DEFAULT_WINDOWS_QUANTITY;
    public $roomType = null;
    public $divider = self::DEFAULT_DIVIDER;

    const NO_WINDOWS_ROOM = ['bathroom', 'hallway'];

    const DEFAULT_FLOOR_HEIGHT = 2.7;
    const DEFAULT_WINDOW_AREA = 2.26;
    const DEFAULT_DOOR_AREA = 1.8;
    const DEFAULT_CALC_TYPE = 'lite';
    const DEFAULT_WINDOWS_QUANTITY = 1;
    const DEFAULT_WINDOWS_QUANTITY_IN_NO_WIN_ROOM = 0;
    const DEFAULT_DIVIDER = 1;

    const METRIC_TYPE_AREA = 1;
    const METRIC_TYPE_PIECE = 2;
    const METRIC_TYPE_RUNNING_METER = 3;

    public function resetDivider() {
        $this->divider = self::DEFAULT_DIVIDER;
    }
    public function resetWindowsQuantity() {
        if(in_array($this->roomType, self::NO_WINDOWS_ROOM)) {
            $this->windowsQuantity = self::DEFAULT_WINDOWS_QUANTITY_IN_NO_WIN_ROOM;
        } else {
            $this->windowsQuantity = self::DEFAULT_WINDOWS_QUANTITY;
        }

    }

    public static function getDoorQuantity($roomType)
    {
        return $roomType === 'hallway' ? 4 : 1;
    }

    public static function getWindowArea($windowsQuantity)
    {
        return $windowsQuantity * self::DEFAULT_WINDOW_AREA;
    }

    public static function getDoorsArea($doorsQuantity)
    {
        return $doorsQuantity * self::DEFAULT_DOOR_AREA;
    }

    public static function getMetric($type)
    {
        switch ($type)
        {
            case self::METRIC_TYPE_AREA:
                return 'м²';
            case self::METRIC_TYPE_PIECE:
                return 'шт.';
            case self::METRIC_TYPE_RUNNING_METER:
                return 'п/м';
            default:
                return null;
        }
    }

    public static function getPerimeterStatic($width, $length)
    {
        return ($width + $length) * 2;
    }

    public function getPerimeter($width = null, $length = null)
    {
        $width = $width ?? $this->width;
        $length = $length ?? $this->length;
        return self::getPerimeterStatic($width, $length);
    }

    public static function getWallsAreaStatic(
        $doorsQuantity, $windowsQuantity, $width, $length, $height = self::DEFAULT_FLOOR_HEIGHT, $divider = 1
    )
    {

        $pureWallsArea = (self::getPerimeterStatic($width, $length) * $height)
            - self::getDoorsArea($doorsQuantity) - self::getWindowArea($windowsQuantity);
        Log::info([$pureWallsArea / $divider, $height, $width, $length, $windowsQuantity]);
        return $pureWallsArea / $divider;
    }

    public function getWallsArea(
        $doorsQuantity = null, $windowsQuantity = null, $width = null, $length = null, $height =
    self::DEFAULT_FLOOR_HEIGHT, $divider = null)
    {
        $width = $width ?? $this->width;
        $length = $length ?? $this->length;
        $height = $height ?? $this->height;
        $windowsQuantity = $windowsQuantity ?? $this->windowsQuantity;
        $doorsQuantity = $doorsQuantity ?? self::getDoorQuantity($this->roomType);
        $divider = $divider ?? $this->divider;

        return self::getWallsAreaStatic($doorsQuantity, $windowsQuantity, $width, $length, $height, $divider);
    }

    public static function getAreaStatic($width, $length)
    {
        return $width * $length;
    }

    public function getArea($width = null, $length = null)
    {
        $width = $width ?? $this->width;
        $length = $length ?? $this->length;
        return $width * $length;
    }
}
