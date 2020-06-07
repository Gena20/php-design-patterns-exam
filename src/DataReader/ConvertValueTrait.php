<?php


namespace App\DataReader;


trait ConvertValueTrait
{
    protected array $toDateTime;

    /**
     * @param $value
     * @return \DateTime|false|null
     */
    protected function convertValue($value)
    {
        if (!empty($value)) {
            if (in_array($value, $this->toDateTime))
                return date_create_from_format('d.m.Y', $value);
            return $value;
        }
        return null;
    }
}