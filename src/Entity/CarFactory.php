<?php


namespace App\Entity;


use ReflectionClass;

class CarFactory
{
    static public function build(object $data, $buildObj=true): object
    {
        if (!$buildObj)
            return $data;

        $carRef = new ReflectionClass(Car::class);
        $car = $carRef->newInstanceWithoutConstructor();
        foreach ((array)$data as $key => $val) {
            if (property_exists(Car::class, $key)) {
                $prop = $carRef->getProperty($key);
                $prop->setAccessible(true);
                $prop->setValue($car, $val);
            }
        }
        return $car;
    }
}