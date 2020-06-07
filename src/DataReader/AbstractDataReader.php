<?php


namespace App\DataReader;


use SplFileObject;

/**
 * Class AbstractDataReader
 * @package App\DataReader
 */
abstract class AbstractDataReader
{
    /**
     * @param string $filename
     * @return iterable
     */
    public final static function getData(string $filename): iterable
    {
        $file = static::readFile($filename);
        return static::parseFileData($file);
    }

    /**
     * @param string $filename
     * @return SplFileObject
     */
    protected static function readFile(string $filename): SplFileObject
    {
        return new SplFileObject($filename, 'rb');
    }

    /**
     * @param SplFileObject $file
     * @return iterable
     */
    abstract static protected function parseFileData(SplFileObject $file): iterable;
}