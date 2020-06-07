<?php


namespace App\Repository;


use App\DataReader\AbstractDataReader;
use App\Entity\Car;
use App\Entity\CarFactory;

class CarRepository
{
    protected iterable $data;
    public function __construct(AbstractDataReader $dataReader)
    {
        $this->data = $dataReader->getData();
    }

    public function findById(int $id): ?object
    {
        $res = array_filter((array)$this->data, fn (object $object) => (int)$object->id === $id);
        if (count($res) > 0)
            return CarFactory::build(
                array_values($res)[0]
            );
        return null;
    }

    public function getRange(int $length, int $offset = 0): array
    {
        $count = count($this->data);
        if ($offset >= $count)
            throw new \RuntimeException(sprintf('Max offset is %d, %d was given', ($count - 1), $offset));
        return array_map(fn (object $obj) => CarFactory::build($obj), array_slice($this->data, $offset, $length));
    }
}