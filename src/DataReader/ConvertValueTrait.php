<?php


namespace App\DataReader;


trait ConvertValueTrait
{
    protected array $toDateTime;

    /**
     * @param $key
     * @param $value
     * @return \DateTime|false|null
     */
    protected function convertValue($key, $value)
    {
        if (!empty($value)) {
            if (in_array($key, $this->toDateTime))
                return date_create_from_format('d.m.Y', $value);
            return $value;
        }
        return null;
    }
}